# LUMINA — Comparativa de Stack y Recomendación Técnica (FASE 1.6)

> **Regla de lectura:** cada afirmación está marcada como **HECHO** (verificable en fuente citada), **ESTIMACIÓN** (cálculo o precio orientativo, fecha de consulta 2026-10-09, fuentes secundarias que deben re-verificarse) o **RECOMENDACIÓN** (nuestra, pendiente de tu aprobación — esto **no** selecciona stack: esa decisión es P-01/P-02/P-03 de `11-decisiones-consolidadas.md`).
> **No se ha instalado, inicializado ni ejecutado nada.** Este documento es análisis previo a FASE 2.
> **FASE 1.7 (2026-10-10):** P-01 **aprobó la dirección** del stack recomendado aquí en su momento (React+TS+Vite · Node+TS · PostgreSQL+PostGIS · REST+OpenAPI · Vitest/Playwright/axe-core). **Superado por la alineación definitiva** (ver nota siguiente). Los precios de tiles y BD se **actualizaron con fuentes oficiales y fecha 2026-10-10** en `15-fase-1-7-informe.md` §2/§3 — **ante discrepancia con las cifras de 2026-10-09 de este documento, manda `15`**. El contrato OTP quedó especificado en `16`.
> **Alineación 2026-10-10:** este documento (Opción B) **contradicía la especificación v5.0** (Opción A: Laravel 11 + Vue 3 + Inertia + Filament + MySQL 8 + Redis + Sanctum). **Superado: arquitectura adoptada Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01 ADOPTADA). Comparativa completa y recomendación en `20-alineacion-integral.md` §4.
> **ALINEACIÓN DEFINITIVA (2026-10-10):** la arquitectura adoptada es **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01 ADOPTADA). MySQL 8 **no** es la base principal ni una migración futura. Las secciones de MySQL de este documento quedan como referencia histórica comparativa. Detalle: `11` §10, `Plan_Maestro` §4/§5.

---

## 1. Restricciones de partida (lo único verificado)

| Restricción | Origen | Consecuencia para el stack |
|---|---|---|
| Mapa continuo a sangre entre rutas (full-bleed) con capa editorial encima | `designMd`, REQ-UI-01 | El shell debe sobrevivir a los cambios de ruta → favorece SPA con shell persistente |
| PWA instalable con offline y cola de escritura (IndexedDB + ServiceWorker **citados en las pantallas**) | `11M`, `H06M`, `G05M` (HECHO) | Requiere control del Service Worker y de la persistencia local |
| Cliente de mapa citado: **MapLibre GL JS** | `01` §6.1 (HECHO, texto del `designMd`) | El SDK de proveedor queda descartado como imposición |
| Sólo 390 px y 1280 px en los artefactos; **0 `@media`** en 62 HTML | `05` §4 (HECHO) | El responsive real se construye en FASE 2; el stack debe soportar 3 breakpoints |
| Consola admin separada, densa, sólo desktop/tablet | `03` §2.2, familia ADM* | Candidata a app aparte con el mismo design system |
| Importación GPX 1.1/GeoJSON con parseo en servidor | `ADM-08`, RF-14 | Necesita trabajo en servidor y validación de XML (riesgo R4/XXE) |
| Reseñas, favoritos e itinerarios funcionan sin red y se sincronizan | RF-09, V-4 | API con idempotencia y aplicación atómica de colas |
| i18n + toponimia (español/quechua) | `H02M`, RF-10 | Internacionalización desde el inicio, no parcheada |
| Moderación con 15 permisos × 3 niveles y auditoría con hash | `ADM-18`, RF-15/16 | Autorización en servidor, no en cliente (riesgo R3) |
| Decisiones adoptadas D-06 (OTP correo), D-07 (primer plano), D-10 (sin gamificación), D-14 (proveedores desacoplados) | `11` §2 | El stack no puede atarse a SMS, geofencing nativo ni a un proveedor concreto |

---

## 2. Recomendación para el MVP (resumen)

| Área | Recomendación | Alternativas descartadas (por ahora) | Coste inicial |
|---|---|---|---|
| Frontend público | **React + TypeScript + Vite (SPA) + Workbox** | Angular, Svelte (ecosistema menor para MapLibre/PWA) | 0 US$ |
| Renderizado público | **Híbrido: shell SPA + páginas de lugar/ruta prerrenderizadas** (SSG al publicar) | SSR puro (servidor siempre encendido), SPA pura si SEO no interesa | 0 US$ |
| Consola admin | **App separada, mismo lenguaje (React+TS)**, sin el bundle público | Monolito compartido (arrastra peso al cliente público) | 0 US$ |
| Backend | **Node.js + TypeScript (API REST)** con worker para GPX/media | Python/FastAPI, Laravel, Go (viables si tu equipo los domina) | 0 US$ |
| Base de datos | **PostgreSQL + PostGIS gestionado** | MongoDB (geoespacial más pobre para RF-01), MySQL (PostGIS no disponible) | 0–25 US$/mes |
| API | **REST/JSON + OpenAPI** (contrato provisional ya en `08`) | GraphQL (complejidad innecesaria hoy), tRPC (acopla cliente/servidor) | 0 |
| Autenticación | **Propia con librerías consolidadas** + OTP por correo | Auth0/Clerk/Supabase Auth (coste y límites de RBAC propio) | 0 US$ (+ email) |
| Mapas | **MapLibre GL JS** + proveedor de tiles **MapTiler en desarrollo** (decisión de pago con métricas) | SDK de Google/Mapbox (atadura), render fijo de Stitch | 0 US$ (dev) |
| Offline | **IndexedDB (`idb`) + outbox propio + Workbox** de precaché | librerías sync "mágicas" (resuelven casos que no tenemos) | 0 |
| Media | **Almacenamiento compatible S3 con egress gratuito (p. ej. R2)** + transformación bajo demanda | S3 clásico con egress (factura disparada), CDN con min. mensual | 0–15 US$/mes |
| i18n | **i18next + recursos JSON** + topónimos como dato por lugar (`08` `toponymOriginal`) | plantillas de servidor (rompe el offline) | 0 |
| Notificaciones | **Web Push (VAPID)** en primer plano + programadas por horario (D-07) | geofencing PWA (imposible), SDK nativo | 0 |
| Analítica | **Primera parte o autoalojada (p. ej. Matomo propio)** con opt-in (`H06M`) | GA4 por defecto (transferencias de datos, consentimiento) | 0–25 US$/mes |
| Pruebas | **Vitest + Testing Library · Playwright (e2e + visual) · axe-core** | suites extensas desde el día 1 (coste sin señal) | 0 |
| Despliegue | **PaaS gestionado** (frontend en Pages/Netlify, API en contenedor gestionado, DB gestionada) | VPS propio desde el minuto 1 (operación temprana) | 0–40 US$/mes |

---

## 3. Criterios de selección

1. **Cobrir RF/REQ verificados** sin forzar la arquitectura (especialmente RF-01 mapa, RF-09 offline, RF-15/16 autorización y moderación).
2. **Desacople de proveedores** (D-14): cambiar de tiles, email o storage no debe exigir reescribir.
3. **Coste inicial 0** y coste marginal previsible al crecer.
4. **Reversibilidad**: migración viable sin reescritura total.
5. **Seguridad por diseño**: secretos fuera del cliente (riesgo R12), autorización en servidor (R3), validación de entradas (GPX/media).
6. **Accesibilidad y rendimiento** medibles desde el inicio (gama baja, mapa + sheets, riesgo R9).
7. **Operabilidad mínima**: copias, observabilidad y recuperación sin equipo dedicado.

---

## 4. Comparativas por área

### 4.1 Frontend público (B1)

| Alternativa | Ventajas | Inconvenientes | Riesgo |
|---|---|---|---|
| **React + TS + Vite** (REC) | Ecosistema mayor para mapas (react-map-gl), PWA/Workbox sólidos, contratación amplia, tipado compartido con la API | Bundle a vigilar en gama baja | Bajo |
| Vue/Nuxt | Curva suave, buena documentación | Menos wrappers maduros de MapLibre, SSR obliga a replantear el offline | Medio |
| Svelte/SvelteKit | Bundle pequeño (bueno para R9) | Ecosistema menor; menos piezas de referencia | Medio |
| Angular | Estructura completa de serie | Peso y verbosidad; overkill para este MVP | Medio |

**HECHO:** los mockups de Stitch son HTML fijo con Tailwind por CDN (`05` §4), no código productivo: no hay herencia de framework que preservar.
**RECOMENDACIÓN:** React + TS + Vite. Motivo: minimiza el riesgo de integración mapa + offline + admin reutilizando componentes y tipos.

### 4.2 Renderizado (SPA / SSR / híbrido) y SEO

| Alternativa | Ventajas | Inconvenientes | Coste |
|---|---|---|---|
| SPA pura | Shell de mapa persistente, offline simple, despliegue estático | Las fichas de lugar no llegan con meta/contenido al rastreador sin JS | 0 |
| SSR completo | SEO perfecto, datos siempre frescos | Servidor siempre encendido; complica el offline y el caché | +operación |
| **Híbrido (REC): shell SPA + fichas de lugar/ruta prerrenderizadas al publicar** | SEO para páginas públicas sin servidor siempre activo; el mapa sigue siendo SPA | Requiere re-render al publicar/editar (webhook de publicación) | 0 |

**Nota de honestidad:** **no existe requisito de SEO en Stitch** (ningún RF lo menciona); el interés por SEO procede del encargo de FASE 1.6. Si no te interesa, la SPA pura es válida y más simple. **P-08 lo confirma con el alcance.**

### 4.3 Backend (B2)

| Alternativa | Ventajas | Inconvenientes |
|---|---|---|
| **Node.js + TS** (REC) | Un lenguaje con el cliente, tipos compartidos, librerías maduras de GPX/media, despliegue sencillo | Trabajo pesado (GPX, imágenes) debe ir a un proceso aparte |
| Python (FastAPI/Django) | Excelente para datos y parseo; Django Admin reduce la consola | Dos lenguajes; tipado compartido más pobre |
| PHP (Laravel) | Productividad alta y hosting barato | Ecosistema de offline/PWA menos directo |
| Go | Rendimiento y binario simple | Velocidad de desarrollo menor para CRUD denso |

**RECOMENDACIÓN:** Node + TS con arquitectura simple (rutas → servicios → repositorios), **worker separado** para parseo de GPX (riesgo R4: XML aislado, límites de tamaño) y procesado de medios.
**HECHO:** la consola admin puede ser la misma app con rutas `/admin` o un artefacto separado; `03` §2.2 recomienda separación por seguridad (CSP/headers distintos) — se mantiene.

### 4.4 Persistencia (B3)

| Alternativa | Ventajas | Inconvenientes | Coste (ESTIMACIÓN 2026) |
|---|---|---|---|
| **PostgreSQL + PostGIS gestionado** (REC) | Consultas `bbox`/distancia/ordenación de RF-01 nativas; transacciones para `sync/batch`; JSONB para flexibilidad; copias gestionadas | Requiere proveedor que ofrezca PostGIS (**verificar**) | Free 0 → entrada ~19–25 US$/mes |
| PostgreSQL autoalojado (VPS) | Sin cuota, control total | Copias, escalado y parches a cargo tuyo | VPS ≈ 4–10 US$/mes |
| MongoDB | Documentos flexibles | Geoespacial y relaciones de moderación/auditoría más débiles | Free pequeño → pago |
| MySQL/MariaDB | Familiar | Sin PostGIS real → RF-01 requeriría implementación casera | — |

**HECHO (de `08`):** el modelo provisional es relacional de facto (entidades con FK, estados, auditoría).
**RECOMENDACIÓN:** Postgres+PostGIS gestionado. **Comprobar antes de contratar:** disponibilidad de PostGIS, límite de almacenamiento (los paquetes offline y medios **no** van a la BD) y política de pausas en planes gratuitos.

### 4.5 API

| Alternativa | Ventajas | Inconvenientes |
|---|---|---|
| **REST/JSON + OpenAPI** (REC) | Ya descrito en `08` §6; caché HTTP; idempotencia con `Idempotency-Key`; contrato estable para la PWA offline | Sobrecarga de endpoints (aceptable) |
| GraphQL | Evita over/under-fetching | Cacheo y autorización por campo más complejos; aporte dudoso con mapa y listados |
| tRPC | Tipado extremo a extremo | Acopla frontend y backend y complica consumidores externos |

**HECHO:** `08` §6 define errores `401/403/409/413/422/429`, versionado `/v1` y cola `POST /sync/batch` idempotente. **RECOMENDACIÓN:** mantener REST y publicar el contrato como OpenAPI (sirve además para tests de contrato).

### 4.6 Autenticación y autorización (B5 + P-05)

| Alternativa | Ventajas | Inconvenientes |
|---|---|---|
| **Propia con librerías consolidadas** (REC) | RBAC de 15 permisos y auditoría (`ADM-18`) a medida; sin cuota por usuario; OTP por correo controlado | Debes cubrir anti-abuso, caducidad, recuperación |
| Auth proveedor (Auth0/Clerk/Supabase Auth) | Arranque rápido, MFA de serie | RBAC propio suele requerir su modelo; coste por MAU; atadura (D-14) |

**Contrato OTP mínimo a documentar antes de código (D-06):** expiración del código, nº de reintentos, ventana de rate limit por IP y por cuenta, respuesta idéntica exista o no el usuario (riesgo R1), recuperación de contraseña, errores tipados y registro de intentos.
**HECHO:** `B02M` ya muestra validación inline de correo/contraseña y `B07M` el OTP de 6 dígitos con temporizador.
**RECOMENDACIÓN:** autenticación propia; proveedor de **email transaccional** para el OTP (plan gratuito inicial). SMS queda fuera (D-06).

### 4.7 Mapas, teselas y búsqueda geográfica (B4)

| Proveedor | HECHO/ESTIMACIÓN (2026) | Notas |
|---|---|---|
| **MapTiler** | HECHO (web oficial): Free 5.000 sesiones/mes, 100 k peticiones, 1 k búsquedas; **Flex 30 US$/mes** con 25 k sesiones; exceso **2,50 US$/1 k sesiones** | Compatible con MapLibre: cambiar de proveedor = cambiar URL de estilo |
| **Mapbox** | HECHO (web oficial): 50.000 cargas GL JS/mes gratis; después **5 US$/1 k** (desciende con volumen); tiles incluidos en la carga | SDK propio tentador → riesgo de atadura |
| **Stadia Maps** | ESTIMACIÓN (su web): Free con créditos; Starter 20 · Standard 80 · Professional 250 US$/mes | También ecosistema MapLibre |
| **Google Maps Platform** | ESTIMACIÓN (fuentes secundarias): niveles de suscripción y precios muy superiores; fuerte atadura y requisitos de atribución | Descartado para MVP |
| **Protomaps / OSM autoalojado** | ESTIMACIÓN: sin cuota por uso, pero requiere generar y servir tiles (más operación) | Interesante si el offline de 148 MB se confirma |

**RECOMENDACIÓN (P-02):** MapLibre (cliente) + MapTiler Free durante desarrollo y demo; decisión de pago cuando haya métricas; comparar Protomaps si el paquete offline se convierte en requisito duro.
**HECHO:** los renders de Stitch son imágenes fijas: no hay mapa real en los mockups (`05` §L5).
**ASESORAMIENTO (10 §1):** política de uso de tiles de OpenStreetMap (uso productivo vía proveedor) — no verificada aquí.
**Búsqueda/geocodificación:** incluida en los planes de los mismos proveedores; verificar límite de búsquedas y si las sugerencias (`C01`) son peticiones facturables.

### 4.8 Offline / PWA (B7)

| Pieza | Recomendación | Motivo |
|---|---|---|
| Precaché de shell, locales y contenido visitado | **Workbox** | Menos código casero y actualizaciones controladas |
| Cola de escritura (reseñas, favoritos) | **IndexedDB con `idb` + outbox propio** con `clientId` idempotente | `08` §6.4 ya define `POST /sync/batch`; la caché del SW no es base de datos (10 §3) |
| Paquetes descargados (mapa/ruta/itinerario, p. ej. 148 MB) | Descarga con URL firmada + verificación `sha256` + cuota con `navigator.storage.estimate()` | `OfflinePackage` ya está modelado en `08` §1.12 |
| Conflicto | Última escritura + marcado de conflicto; nunca merge silencioso en reseñas | 10 §3, riesgo R8 |

**HECHO:** iOS no ofrece background sync en PWAs y el push está condicionado (10 §3) → el MVP no promete nada en segundo plano (D-07).
**Riesgo a verificar:** límite real de almacenamiento de la PWA en iOS Safari para paquetes de 148 MB (**ESTIMACIÓN**: puede exigir descargas parciales o límite de paquete por usuario).

### 4.9 Multimedia (B6)

- **HECHO (10 §4):** R2 ≈ 0,015 US$/GB-mes sin coste de egress; S3 Standard ≈ 0,023 US$/GB **más** egress.
- **HECHO (`ADM-06`):** referencia de carga 4032×3024 · 3,4 MB → el volumen de fotos domina el coste, no el almacenamiento.
- **RECOMENDACIÓN:** storage compatible S3 con egress gratuito + transformación bajo demanda (redimensionar a anchos útiles 390/768/1280) + límites por subida (R4, R6: EXIF opcional).
- **ASESORAMIENTO:** licencia/derechos de imagen al subir (`ADM-14`, riesgo R10).

### 4.10 Idiomas y topónimos (A4 / P-14)

- **RECOMENDACIÓN:** i18next (recursos JSON por locale, plurales, fechas `es-PE`), toponimia como **dato por lugar** (`toponymOriginal` ya en `08`) con alternancia en `H02M`.
- **Pendiente:** catálogo de idiomas exacto (P-14) y si se traducen reseñas (08 §2.7).

### 4.11 Moderación, permisos y auditoría

- **HECHO:** `ADM-18` exige 15 permisos × 3 niveles con "Guardar Cambios", "Restablecer por defecto" y auditoría con hash (`SHA 7e9f..3a21`).
- **RECOMENDACIÓN:** política de autorización **en servidor** (middleware por acción, no por pantalla), matriz cargada desde base de datos y cacheada, y **log de auditoría append-only con encadenado de hashes** (no editable desde la UI).
- **Riesgo R9** (Reglas AI de `ADM-13`): fuera del MVP hasta criterios transparentes (D-13/D-10).

### 4.12 Notificaciones

- **RECOMENDACIÓN:** Web Push con VAPID + suscripción persistida por usuario/dispositivo; alertas **en primer plano** y recordatorios por horario (el ocaso se calcula localmente, sí funciona); **sin geofencing** (D-07).
- **FALTA:** endpoint de preferencias y suscripción (hallazgo C-1 de `11` §4.4) — **añadido en FASE 1.7** en `08` §1.13/§6.2 bajo la aprobación condicional de P-06.

### 4.13 Analítica y consentimiento (B8)

| Alternativa | Ventajas | Inconvenientes |
|---|---|---|
| **Primera parte / autoalojada (p. ej. Matomo propio)** (REC) | Menos transferencias internacionales; coherente con `H06M` | Operación propia |
| Proveedor externo (GA4, PostHog, Plausible) | Rápido, maduro | Consentimiento y transferencias (10 §6); coste por evento |

**RECOMENDACIÓN:** opt-in por defecto (ya diseñado en `H06M`), even schema mínimo, sin identificadores personales en URLs.
**ASESORAMIENTO:** texto legal de consentimiento (P-20).

### 4.14 Pruebas

| Nivel | Herramienta propuesta | Qué cubre |
|---|---|---|
| Unidad | **Vitest** | Reglas de negocio: estados de moderación, cola offline, validaciones GPX, permisos |
| Componente | Testing Library | Formularios (`B02M`), chips/filtros (`REQ-UI-06`) |
| Integración/API | Tests contra contrato OpenAPI | Errores 401/403/409/429 de `08` §6.4, idempotencia de `sync/batch` |
| E2E | **Playwright** | V-1…V-5 y A-1…A-4 de `07` |
| Visual | Playwright screenshots en 390 / 768–1024 / 1280 | Regresión contra las capturas de Stitch (62 PNG de la evidencia, si P-23 la preserva) |
| Accesibilidad | **axe-core** + revisión manual de teclado/lector | `05` §L7 (hoy no verificado) |
| Rendimiento | Presupuesto: carga inicial, tiempo hasta mapa interactivo | Riesgo R9 |

**RECOMENDACIÓN:** empezar con unidad + e2e del flujo V-1 y V-4; ampliar por riesgo, no por volumen.

### 4.15 Configuración de desarrollo, variables de entorno y secretos

- **HECHO:** está prohibido introducir secretos en el código (estándares del proyecto) — todo por **variables de entorno**.
- **RECOMENDACIÓN:** repositorio con `.env.example` versionado (sin valores), `.env` real ignorado, **validación de entorno al arrancar** (schema con `zod`-style), cuentas de desarrollo separadas para tiles/email (para no mezclar cuotas), rotación de claves documentada, y **proxy propio** para claves de tiles/OTP (riesgo R12: `ADM-18` no debe exportar claves al cliente).
- Nada de esto se configura en FASE 1.6.

### 4.16 Despliegue, observabilidad, copias y recuperación

| Opción | Ventajas | Inconvenientes | Coste (ESTIMACIÓN 2026) |
|---|---|---|---|
| **PaaS gestionado** (REC) | Despliegue git, copias y TLS gestionados | Coste creciente; verificar uso comercial | Front 0–20 · API 0–25 · DB 0–25 US$/mes |
| VPS + Docker | Control y precio | Operación, copias y parches propios | ≈ 4–15 US$/mes |
| Serverless puro | Escala a cero | Frío para el mapa y límites de duración | Variable |

**HECHO:** Vercel **Hobby es sólo para uso no comercial** (documentación oficial 2026); LUMINA tiene patrocinios → si se elige esa vía, el plan de producción es de pago (≈20 US$/usuario/mes, ESTIMACIÓN). Netlify sí permite uso comercial en su nivel gratuito (ESTIMACIÓN de fuentes secundarias).
**RECOMENDACIÓN (mínima viable):**
1. Frontend estático + API contenedor en PaaS; DB gestionada.
2. **Observabilidad:** errores (Sentry o equivalente), logs estructurados con `requestId` (ya lo pide `08` §6.4), sondeo de uptime, y métricas de cola de moderación (D-08).
3. **Copias:** PITR del proveedor + volcado diario a storage distinto + **prueba de restauración documentada**.
4. **Objetivos a confirmar (no inventados):** RPO/RTO por acordar con el usuario; el procedimiento de incidentes entra en P-19.

---

## 5. Coste previsible del MVP (ESTIMACIÓN — fuentes secundarias 2026-10-09, re-verificar)

| Concepto | Desarrollo/demo | Producción inicial | Nota |
|---|---|---|---|
| Frontend | 0 | 0–20 US$/mes | Cuidado con planes "sólo no comercial" |
| API (contenedor gestionado) | 0 | 0–25 US$/mes | Escala con CPU/memoria |
| BD Postgres+PostGIS | 0 | 0–25 US$/mes | Plan gratuito con límites pequeños |
| Tiles de mapa | 0 (plan Free) | 0–30 US$/mes | Pago real sólo con uso (P-02) |
| Email OTP | 0 | 0–20 US$/mes | Volumen bajo al inicio |
| Media/CDN | 0 | 0–15 US$/mes | Dominado por egress de fotos |
| Observabilidad | 0 | 0–26 US$/mes | Planes gratuitos amplios |
| **Total** | **0 US$** | **≈ 0–140 US$/mes** | **ESTIMACIÓN, sin contratar nada** |

**Riesgo de coste:** el vector principal es el **egress de media y paquetes offline**, no la BD. Los límites de los planes gratuitos (p. ej. 500 MB de BD y 5 GB de salida en un plan gratuito tipo Supabase, ESTIMACIÓN) se superan con contenido multimedia, por eso la media va a storage con egress gratuito.

---

## 6. Riesgos del stack recomendado

| # | Riesgo | Mitigación |
|---|---|---|
| S1 | PWA en iOS: push condicionado, sin background sync, límite de almacenamiento | Alcance primer plano (D-07), paquetes con cuota y verificación |
| S2 | Atadura a proveedor de tiles | MapLibre + URL de estilo conmutable (D-14) |
| S3 | Coste de egress de media | Storage sin egress + transformación + límites de subida |
| S4 | Contrato de color aún sin congelar (C1/D-02) | Congelar tokens en FASE 2 (`#7` de `04`) antes de construir componentes |
| S5 | Trabajo pesado en el proceso de API (GPX/media) | Worker aislado con límites y timeouts |
| S6 | Planes gratuitos que pausan proyectos inactivos | Despliegue de demo con sondeo; no usar Free para producción real |
| S7 | SEO asumido sin requisito formal | Confirmar en P-08; si no aplica, simplificar a SPA pura |

---

## 7. Qué hay que verificar **antes de contratar o desplegar**

1. Precios oficiales de tiles, hosting, BD y email (las cifras de aquí son secundarias).
2. Disponibilidad de **PostGIS** en el proveedor elegido.
3. Política de tiles de **OpenStreetMap** y obligaciones de atribución.
4. Almacenamiento máximo real de la PWA en iOS para paquetes grandes.
5. Requisitos peruanos si algún día entra SMS (D-06) y obligaciones de la Ley 29733 para datos alojados.
6. SPF/DKIM/DMARC del dominio de envío de OTP.
7. Límites de uso comercial de cada plan gratuito elegido.

---

## 8. Mapeo con las decisiones B1–B8

| Decisión | Estado (FASE 1.6 → FASE 1.7) | Dónde se decide |
|---|---|---|
| B1 Frontend | PROPUESTA-PROV (§4.1) → **ADOPTADA** (P-01: Vue 3 + TS + Inertia 3; SSR preferente D-16) | — |
| B2 Backend y despliegue | PROPUESTA-PROV (§4.3, §4.16) → **ADOPTADA** (P-01: Laravel 13; desarrollo local) | producción: IONOS por evaluar |
| B3 Base de datos | PROPUESTA-PROV (§4.4) → **ADOPTADA (motor)** (P-03: PostgreSQL con PostGIS); comparativa final en `15` §3 como referencia | proveedor producción: pendiente |
| B4 Tiles | PROPUESTA-PROV (§4.7) → **PARCIAL**: MapLibre adoptado; proveedor pendiente; comparativa final en `15` §2 | P-02 |
| B5 OTP/email | PROPUESTA-PROV (§4.6) + D-06 fija el canal → **ADOPTADA** (P-04: OTP 6 dígitos solo en registro; SMTP Google — `16`) | — |
| B6 Media | PROPUESTA-PROV (§4.9) — sin cambio | P-01 (decidir aparte) |
| B7 Offline | PROPUESTA-PROV (§4.8) — acotada por D-07; condicionada por P-02 | P-01 (librerías) |
| B8 Analítica | PROPUESTA-PROV (§4.13) — P-08 aceptado sólo como alcance de planificación | P-08 |

> **Estado (alineación definitiva):** stack adoptado Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS + MapLibre (P-01/P-03/P-05 ADOPTADAS). **Siguen pendientes** el proveedor de tiles (P-02), el proveedor de producción (P-03 proveedor), el 2FA de consola (P-04 alcance) y la firma de exportación (P-05 operación). Media/CDN (B6) y analítica (B8) no formaron parte del combo adoptado.
