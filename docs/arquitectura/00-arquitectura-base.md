# LUMINA — Arquitectura base v1.0 (real, verificada 2026-10-10)

> Alcance: base técnica inicial del monolito modular. No implementa negocio, no migra tablas de negocio,
> no valida SSR/SEO/SMTP/consultas de negocio. P-02 (teselas) sigue pendiente. Todo lo afirmado aquí fue ejecutado.

## 1. Versiones reales instaladas (verificadas por ejecución)

| Componente | Versión | Cómo se verificó |
|---|---|---|
| PHP | 8.5.10 (Homebrew, NTS) | `php -v` |
| Composer | 2.10.3 | `composer --version` |
| Laravel | 13.35.0 (`laravel/framework ^13.17`) | `php artisan --version` |
| `inertiajs/inertia-laravel` | ^3.5 | `composer require` + `route:list` + HTTP 200 en `/` |
| `@inertiajs/vue3` / `vue` | 3.9.1 / 3.5.43 | `npm install` + `vite build` |
| `filament/filament` | ^5.10 | `composer require` + rutas `/admin` registradas |
| TypeScript | 5.9 (fijado; 7.x es incompatible con `vue-tsc@3`) | `vue-tsc --noEmit` exit 0 |
| `@vitejs/plugin-vue` / `vite` / `laravel-vite-plugin` | 6.0.10 / 8.x / 3.x | `vite build` OK |
| `maplibre-gl` | 6.13.0 (solo dependencia instalada, sin uso aún) | `package.json` |
| Node / npm | 24.20.0 / 11.19.0 | `node -v`, `npm -v` |
| PostgreSQL | 18.6 (Postgres.app, `aarch64`) | `SELECT version()` vía MCP `postgres-local` |
| PostGIS | 3.6.3 (`USE_GEOS=1 USE_PROJ=1`), GEOS 3.14.1, PROJ 9.7.1 | `postgis_version()`, `postgis_geos_version()`, `postgis_proj_version()` |
| Extensiones PHP | `pdo_pgsql`, `pgsql`, `intl`, `mbstring`, `curl`, `gd`, `zip`, `bcmath`, `sodium` | `php -m` + chequeo por extensión |
| `laravel/boost` | ^2.10 (dev) | `composer require` + `boost:install` |

## 2. Cómo se relacionan los componentes

```
Navegador ──HTTP──▶ routes/web.php ──▶ Controlador ──▶ Acción/Servicio de aplicación
      Inertia (X-Inertia)                     │                    │ (reglas de negocio)
                                              │                    ▼
                                     HandleInertiaRequests   Eloquent ──▶ PostgreSQL/PostGIS
                                     (middleware web)          (SQL espacial con DB::raw)
                                              │
                                              ▼
                                   Inertia::render('Pagina', props)
                                              │
                                              ▼
                              app.blade.php + app.ts ──▶ Vue 3 (Pages/*.vue)
                                              │
                              /admin ──▶ Filament 5 (stack Blade/Livewire propio, separado de Inertia)
```

- **Laravel** es el único servidor: enruta, valida, autoriza, ejecuta negocio y persiste. Expone HTML vía
  Inertia para la app y vía Filament para `/admin`. No hay API REST pública en la base (se añadirá versionada
  `/v1` solo si un cliente la necesita: PWA nativa o terceros).
- **Inertia 3** elimina la API intermedia para la web: el controlador devuelve props tipadas y Vue renderiza.
  Sin `controllers` que devuelvan JSON para la web salvo que se justifique.
- **Vue 3 + TypeScript**: páginas en `resources/js/Pages/**`, componentes en `resources/js/Components/**`,
  layouts en `resources/js/Layouts/**`, composables en `resources/js/Composables/**`, tipos en
  `resources/js/Types/**`. Solo se crean directorios/archivos cuando el incremento los necesite (sin vacíos).
- **Filament 5** vive aislado en `/admin` con su propio auth y no comparte layouts Vue. Verificado:
  `GET /admin` → 302 a `/admin/login`; `GET /admin/login` → 200 (sin login no hay acceso).
- **PostgreSQL/PostGIS** es el único motor (decisión adoptada; MySQL del PDF v5.0 no es objetivo ni migración).
  Conexión Laravel `pgsql` a `127.0.0.1:5433/lumina` verificada con `db:show` (lectura, sin migraciones).
- **MapLibre GL JS** (instalado, sin cablear): renderiza el mapa y obtiene la geolocalización del navegador.
  Nunca calcula en cliente lo que deba decidir el servidor (§5).

## 3. Responsabilidades

- **Backend**: rutas, Form Requests, autorización (políticas/Gates/middleware), acciones/servicios de aplicación,
  modelos Eloquent, consultas espaciales, eventos/jobs, correo OTP, auditoría, sitemap/robots/hreflang.
- **Frontend**: presentación, navegación Inertia, estados de carga/vacío/error, mapa (render + posición),
  cola offline (IndexedDB) con reenvío idempotente, PWA. Sin reglas de negocio ni autorización (solo reflejo UX).
- **Dominio** (según `docs/analisis/08-modelo-dominio-api.md`): `User`, `Place`, `Route`, `Waypoint/Beacon`,
  `Itinerary`, `Favorite`, `Review`, `MediaAsset`, `Sponsorship`, `ModerationItem`, `Consent/PrivacyRequest/Claim/AuditLog`,
  `OfflinePackage/SyncQueue`, `NotificationPreference`, `Report`. Las tablas se crearán por incremento mediante
  migraciones versionadas y reversibles, cuando corresponda (no en esta fase). Diseño de datos vigente en
  `docs/arquitectura/01-modelo-dominio-geoespacial.md` (16 tablas, DD-01…DD-09).

## 4. Organización del código (convención adoptada)

```
app/
  Http/
    Controllers/        # Finos: reciben Request validado, delegan a Acción, devuelven Inertia/redirect
    Requests/           # Form Requests: TODA validación de entrada vive aquí, nunca en el controlador
    Middleware/         # HandleInertiaRequests + middlewares propios mínimos
    Resources/          # Eloquent API Resources (solo si se abre API /v1)
  Actions/              # Una clase = un caso de uso (p. ej. RegisterUserWithOtp, ModerateReview)
  Services/             # Servicios de dominio/integración reutilizables (p. ej. GeoSearch, OtpManager, EmailSender)
  Models/               # Eloquent + casts; lo espacial con scopes que encapsulan DB::raw GIS
  Policies/             # Una por modelo + Gates para acciones sin modelo; Filament las reutiliza
  Events/Listeners/Jobs # Efectos secundarios async (correo OTP, purga EXIF, métricas)
  Filament/             # Resources/Pages/Widgets del panel (generado por Filament, curado a mano)
resources/js/
  Pages/ Components/ Layouts/ Composables/ Types/
routes/
  web.php               # Web Inertia (con auth/verified donde toque)
  admin.php (futuro)    # Solo si se necesitan rutas admin fuera de Filament
  api.php (futuro)      # Solo si se abre API /v1
tests/
  Feature/ Unit/        # Pest/PHPUnit según pirámide del Plan Maestro §8
```

Reglas: controlador fino; validación en Form Request; autorización en servidor (política/Gate/middleware,
nunca solo UI); sin `catch` vacíos; paginación siempre en servidor (`paginate`/`cursorPaginate`, nunca
`Model::all()`); N+1 prohibido (eager loading + tests que lo cubran en módulos críticos).

## 5. Arquitectura geoespacial PostGIS (base verificada, negocio no implementado)

Verificado por ejecución vía MCP `postgres-local` (solo lectura): `ST_AsText/ST_MakePoint/ST_SetSRID/
ST_DWithin/ST_Distance/ST_Buffer/ST_Intersects/ST_Contains` disponibles; operadores KNN `<->/<#>/<<->>`
disponibles; SRID 4326 presente en `spatial_ref_sys`; accesos `GiST/SP-GiST/BRIN` disponibles; prueba con
coordenadas de Tarma (`POINT(-75.5 -11.4)`, distancia 1554 m, `ST_DWithin` 5 km = true).

- **`geography` vs `geometry`**: usar `geography(Point,4326)` para lugares y distancias reales en metros
  (`ST_DWithin`, `ST_Distance`); usar `geometry(LineString,4326)` para tracks de rutas (GPX) donde se necesite
  manipulación planar, casteando a `geography` para medir. SRID siempre 4326 (WGS 84, GPS).
- **Índices**: GiST en cada columna espacial (`USING gist`). Proximidad con `ST_DWithin(... , radio)` (usa índice)
  + orden KNN `<->` para "los N más cercanos". Nunca `ST_Distance` sobre tabla completa sin filtro previo.
- **Patrones por caso** (todos en servidor, el frontend solo envía `lat/lon/radio` validados):
  - Cercanos a un punto: `WHERE ST_DWithin(col::geography, ST_SetSRID(ST_MakePoint(:lon,:lat),4326)::geography, :r)`
    `ORDER BY col::geography <-> punto`.
  - **«Lo que hay en este trayecto»**: el track de la ruta vive en servidor; se calcula
    `ST_Buffer(track::geography, :ancho)` una vez por consulta y se buscan lugares con `ST_DWithin(lugar, buffer)`
    u `ST_Intersects`, ordenando por distancia al punto del usuario o por abscisa sobre el track. El cliente
    NO descarga lugares para filtrar ni calcula el corredor.
  - Intersecciones/contención: `ST_Intersects` / `ST_Contains` sobre `geometry` 4326.
- **MapLibre** renderiza teselas + marcadores + posición GPS y envía la posición al servidor solo cuando una
  acción lo requiera (búsqueda, trayecto activo), con consentimiento; por defecto la ubicación no se almacena
  (requisito PDF §5.5/§10.9). **P-02 pendiente**: sin proveedor de teselas; `MAP_TILE_URL` reservada en
  `.env.example`, vacía hasta autorización. No se hardcodea ninguna URL de teselas en código.

## 6. SEO e i18n (diseño, no validado)

- Locales: `es` por defecto, `en` fallback (`APP_LOCALE=es`, `APP_FALLBACK_LOCALE=en` en `.env`).
- Páginas públicas indexables (ficha lugar/ruta, catálogo, contenido público): título/descripción dinámicos,
  URL canónica, Open Graph/Twitter, JSON-LD Schema.org, HTTP correctos, `es/en` con `hreflang`, canonical
  anti-duplicados; `sitemap.xml` + `robots.txt` generados desde Laravel; `/admin` y áreas privadas con `noindex`.
- **SSR de Inertia**: estrategia preferente pero NO implementada ni validada (requiere build SSR + proceso
  Node supervisado; compatibilidad IONOS sin comprobar). Hasta entonces, fichas con contenido server-rendered
  básico y mejora progresiva. No se declara nada validado.

## 7. Autenticación OTP (implementada 2026-10-10 según `docs/analisis/16-*`)

Flujo: registro → cuenta **pendiente sin acceso** (`email_verified_at = null`, sin sesión) → OTP 6 dígitos
por correo → valida → activa y entra con correo+contraseña (nunca OTP por login; sin enlace principal;
sin 2FA login; sin login social; sin recuperación de contraseña: fuera de alcance).
Implementación: `config/otp.php` (10 min, 5 intentos, 60 s, tope 10/hora), `OtpManager` (hash bcrypt, un solo
uso, nuevo invalida anterior, transacciones con `lockForUpdate`), `RegisterUserWithOtp`, Form Requests,
controladores `Auth/*`, rutas `/registro /verificar /reenviar-codigo /entrar /salir /cuenta` (límites
`throttle:auth/otp` por cuenta+IP), páginas Vue `Auth/Register/Verify/Login/Account`, `MustVerifyEmail` en
`User`, middleware `verified` en `/cuenta`, `canAccessPanel` denegado a pendientes, respuestas idénticas
anti-enumeración. Correo: Mailpit local (`127.0.0.1:1025`, UI `:8025`, entrega verificada); SMTP Google pendiente
de autorización posterior. Tests: 16 Feature OTP + 2 base en verde (104 assertions).
Pendiente: SMTP real, 2FA/TOTP de consola (decisión de alcance), recuperación, social.

## 8. Filament y autorización (base aplicada 2026-10-10; matriz pendiente campo a campo)

Se conservan roles (Explorador, Super Admin, Editor&Topógrafo, Moderador/Custodio), matriz 15×4 y RS-1…RS-9
sin inventar ni reducir. Aplicado: `User::canAccessPanel` exige correo verificado (pendientes → 403 en
`/admin`), `verified` en rutas protegidas, sin recursos de negocio en el panel todavía. Verificado por tests.
Pendiente: recursos Filament por entidad + políticas/Gates por recurso cuando existan las tablas de negocio.

## 9. Transversales

Validación (Form Requests) · secretos solo en `.env` (`DB_PASSWORD` vacía en local; nada en repo) ·
multimedia con autorización en servidor + validación de duración 15–25 s pendiente de implementar (sin proveedor
externo obligatorio) · auditoría append-only con hash · paginación/rate-limit siempre · rendimiento (índices,
eager, caché futura; Redis/colas cuando el incremento lo exija) · pruebas según pirámide del Plan Maestro.

## 10. Estado de la base y siguientes pasos (actualizado 2026-10-10)

- BD `lumina` (local `127.0.0.1:5433`, destino verificado antes de migrar): lote 1 aplicado con
  `migrate --path` (sin `fresh`/`wipe`): `migrations`, `users`, `password_reset_tokens`, `sessions`, `otp_codes`
  (FK `user_id → users` con cascade); `spatial_ref_sys` intacta (8500 filas); 0 filas de usuarios/códigos;
  **0 tablas de negocio turístico**. `cache`/`jobs` pendientes a propósito (drivers `file`/`sync` sin cambios).
  Reversibilidad comprobada en SQLite desechable (`down()` elimina solo lo suyo).
- Correo dev: Mailpit v1.31.4 en `/usr/local/bin` (SMTP `:1025`, UI `:8025`), entrega verificada y buzón purgado.
  Sin correos reales, sin secretos en el repo (`.env` excluido de Git; Mailpit sin credenciales).
- Comprobaciones: 18/18 tests (104 assertions) · `vue-tsc` OK · `vite build` OK · Pint OK ·
  `/ /registro /verificar /entrar /admin/login` 200 · `/cuenta`→login · `/admin`→login (invitado) / 403 (pendiente).
  No validados: SSR, SEO, SMTP real, autorización integral, consultas espaciales de negocio.
- Siguiente paso (no implementado aquí): revisar el modelo de dominio turístico y diseñar las primeras
  migraciones geoespaciales. Pendientes explícitos: P-02 teselas · SMTP real · IONOS · P-17…P-20 · Git.
