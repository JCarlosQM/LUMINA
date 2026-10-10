# LUMINA — Plan Maestro de Desarrollo v1.0

> **Fecha de referencia:** 2026-10-10 · **Estado:** PLANIFICACIÓN (no iniciada) · **Responsable:** pendiente de aprobación
> **Regla de lectura:** cada afirmación se marca como **[DOC]** (documento LUMINA), **[PDF]** (especificación v5.0), **[VER]** (verificado externamente, con fuente y fecha), **[INF]** (inferencia técnica) o **[REC]** (recomendación, pendiente de aprobación).
> **Restricciones respetadas:** sin código, sin dependencias, sin migraciones, sin despliegues, sin credenciales, sin cambios en Stitch, sin regenerar evidencias, **sin modificar documentos originales**. **`APR = 0`.**
> **Este plan no aprueba decisiones.** Las decisiones P-01…P-24 y D-01…D-15 conservan su estado; las sprints que dependen de decisiones abiertas se marcan **PROVISIONAL / BLOQUEADO**.

---

## 1. Resumen ejecutivo

LUMINA es una plataforma web de mapas turísticos interactivos de alta curaduría (piloto en Tarma, Junín), con PWA, geolocalización, descubrimiento en movimiento, fichas de lugares, rutas temáticas, reseñas moderadas, panel administrativo y monetización futura. Este plan maestro organiza el desarrollo en **7 fases**, con sprints incrementales, una estrategia de pruebas en pirámide, integración de las 62 pantallas de Stitch, y criterios de aceptación verificables.

**Situación:** el repositorio contiene **sólo documentación** (20 documentos de análisis + el PDF v5.0). **No hay código, ni Git, ni dependencias.** Las 59 decisiones de producto (D-01…D-15) y las preguntas P-01…P-24 están registradas; **P-01…P-08 respondidas, P-09…P-24 abiertas.** La evidencia visual de FASE 1.5 **se perdió** (temporal limpiado); el proyecto **Stitch (62 pantallas) está intacto**.

**Decisión adoptada:** el stack definitivo es **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01/P-03/P-05 ADOPTADAS; ver `11` §10). La Opción B (React/TS/Vite + Node + PostGIS) queda descartada como arquitectura objetivo; su comparativa se conserva como referencia histórica.

---

## 2. Estado real del proyecto (verificado 2026-10-10)

| Aspecto | Estado | Fuente |
|---|---|---|
| Repositorio | Sólo `docs/` (20 análisis + `docs/referencia/`). **Sin código, Git, dependencias.** | Verificado |
| Git | **No existe** (no se inicializa en esta misión). | Verificado |
| Requisitos | 59 REQ trazados; **`APR = 0`**; 48 DOC, 35 VER, 17 AMB, 8 SIN, 1 REC. | `02` |
| Decisiones | D-01…D-15 adoptadas (dirección). **P-01/P-03/P-04/P-05 adoptadas** (alineación definitiva). **P-02, P-07, P-08 y P-09…P-24 abiertas o pendientes.** | `11` §10, `20` |
| Modelo de dominio | `08` = base provisional (P-06), C-1…C-5 aplicados. | `08` |
| Matriz RBAC | `17` = propuesta 15×4, **no aprobada** (P-05). | `17` |
| Retención | `18` = propuesta sin plazos, **no aprobada** (P-07). | `18` |
| Alcance MVP | `13` = propuesta de planificación, **no definitiva** (P-08). | `13` |
| PDF v5.0 | `docs/referencia/Lumina_Documento_Tecnico_Especificacion_v5.pdf` (9 págs., v5.0, 2026-10-09). | Leído |
| Evidencia FASE 1.5 | **PERDIDA** (temporal limpiado; 0 archivos inspeccionados). | Verificado |
| Stitch | **Intacto**: 62 pantallas (32 móviles, 29 escritorio, 1 logotipo). | `list_screens` |

---

## 3. Alcance y exclusiones del MVP

**Incluido en el MVP** (trazable a RF con pantalla o decisión adoptada — `13` §2): exploración cartográfica, búsqueda con estados, ficha de lugar, catálogo/detalle de ruta, registro/login/OTP, favoritos, itinerarios (sin constructor complejo), reseñas con cola offline, PWA instalable, navegación unificada, ajustes (idioma/notificaciones primer plano), tablet 768–1024, acceso+dashboard+CRUD lugares/rutas+multimedia, usuarios+RBAC+moderación+auditoría+métricas.

**Excluido por decisión adoptada:** SMS (D-06), geofencing 2.º plano (D-07), gamificación (D-10), "Reglas AI" (D-13), app nativa (D-07).

**Excluido por asesoramiento pendiente:** formulario ARCO con plazo publicado (P-17), Libro de Reclamaciones operativo (P-18), textos legales (P-20).

**Pendiente de decisión:** modo oscuro (P-10), cobertura responsive (P-11), perfil (P-12), constructor itinerarios (P-13), idiomas (P-14), patrocinios/aforo (P-15), SEO (P-01/REQ-WEB-01), perfil (P-12).

**Ampliaciones post-MVP:** SMS, geofencing nativo, gamificación, modo oscuro, offline ampliado, Cloudinary, perfiles.

---

## 4. Evaluación comparativa de arquitecturas

### 4.1 Corrección de versiones de la Opción A (verificado)

El PDF v5.0 propone **Laravel 11**, pero **[VER]** Laravel 11 está **EOL** (soporte de seguridad terminó 2026-03-12). Las versiones apropiadas para un proyecto nuevo en oct-2026:

| Componente | PDF v5.0 | Versión adoptada (oct-2026) | Fuente |
|---|---|---|---|
| Laravel | 11 | **Laravel 13** (actual, PHP 8.3–8.5, bug fixes hasta Q3 2027) | laravel.com / laravel-news.com 2026 |
| Filament | (sin versión) | **Filament 5** (actual; el 4 es "previous") | filamentphp.com 2026 |
| Inertia | (sin versión) | **Inertia 3** (inertia-laravel 3.x, con Laravel 13) | inertiajs/inertia-laravel 2026 |
| Vue | 3 | **Vue 3 + TypeScript** | — |
| **Base de datos** | MySQL 8.0 | **PostgreSQL con PostGIS** (adoptada por decisión del proyecto; ver `11` §10) | — |

**[VER]** PostgreSQL + PostGIS proporciona tipos `geometry`/`geography`, SRID 4326, índices GiST, **KNN indexado** (`<->`), `ST_DWithin`, `ST_Buffer` completo y ~200 funciones espaciales — **superior a MySQL 8** para las necesidades geoespaciales de LUMINA (proximidad, geometrías de rutas, corredores). **MySQL 8 no es la base principal ni una migración futura** (decisión del proyecto).

### 4.2 Matriz comparativa A vs B

| Dimensión | **Opción A** (Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS) | **Opción B** (React+TS+Vite + Node+TS + PostGIS) | Valoración |
|---|---|---|---|
| Ajuste a requisitos | Alto (monolito, admin rápido) | Alto (geoespacial superior) | A≈B |
| Geoespacial | **PostGIS: KNN, geography, buffers** (adoptada) | **PostGIS** (KNN, geography, buffers) | A≈B (ambas usan PostGIS) |
| SEO | **Inertia = páginas server-rendered indexables** | SPA: requiere prerender/SSR | **A** |
| Panel admin | **Filament 5: CRUD/moderación/métricas rápido** | A construir (o librería React) | **A** |
| Complejidad | **Menor** (un monolito, un deploy) | Mayor (frontend+API, dos servicios) | **A** |
| Seguridad | Madura (Sanctum, protección CSRF/XSS, validación) | Madura (librerías) | A≈B |
| Pruebas | Pest/PHPUnit + Playwright | Vitest/Jest + Playwright | A≈B |
| Coste infraestructura | **Menor** (monolito PHP + PostgreSQL local; producción IONOS por evaluar) | Medio (PaaS + DB gestionada) | **A** |
| Mantenimiento | **Menor** (un codebase) | Mayor (dos codebases) | **A** |
| Escalabilidad | Estándar | Estándar | A≈B |
| Riesgo implementación | **Menor** (stack maduro, admin resuelto) | Medio (admin por construir, prerender) | **A** |
| Tiempo hasta MVP verificable | **Menor** | Mayor | **A** |

### 4.3 Recomendación **[REC]**

**Recomiendo la Opción A (Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre)** como candidata prioritaria, por estas razones **justificadas**:

1. **SEO (REQ-WEB-01):** Inertia + **SSR como estrategia preferente** resuelve las fichas indexables (requiere configurar el servidor SSR; no es automático). La Opción B requiere prerender/SSR.
2. **Panel administrativo:** Filament 5 resuelve CRUD/moderación/métricas/roles **rápido**; es una gran parte del producto (18 pantallas ADM).
3. **Geoespacial:** **PostgreSQL con PostGIS** (adoptado) proporciona KNN indexado, tipo `geography`, buffers y corredores de ruta — cubre las necesidades geoespaciales de LUMINA.
4. **Tiempo y coste:** monolito, un deploy, menor mantenimiento → **MVP verificable antes y más barato**.

**Condiciones (adoptadas):** (a) P-01 ADOPTADA — stack Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS; (b) usar **Laravel 13 / Filament 5 / Inertia 3** (no las versiones del PDF); (c) desarrollo **local** en Mac; (d) producción se evaluará con **IONOS** (P-03 motor resuelto; proveedor pendiente).

**Decisiones que requieren tu autorización:** P-01 (stack), P-02 (teselas), P-03 (proveedor/entorno producción), P-04 (OTP), P-05 (RBAC), P-07 (retención), P-08 (alcance), P-23 (evidencia), P-24 (lotes Stitch).

---

## 5. Arquitectura objetivo propuesta (Opción A, condicionada a P-01)

> **ADOPTADA (alineación definitiva):** stack Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre (P-01/P-03/P-05). Desarrollo local en Mac; producción IONOS por evaluar.

- **Monolito Laravel 13** (PHP 8.3+) con **Inertia 3 + Vue 3 + TypeScript** (páginas server-rendered, SPA-like).
- **Filament 5** para el panel administrativo (`/admin`).
- **PostgreSQL con PostGIS** (tipos `geometry`/`geography`, SRID 4326, índices GiST, KNN).
- **MapLibre GL JS** para mapas; **PWA** (Service Worker + IndexedDB) para offline.
- **Redis** (futuro) para caché/colas/OTP.
- **Almacenamiento de medios:** disco local (piloto) → S3-compatible/Cloudinary (futuro).
- **API:** Inertia para la app; **API REST/JSON** (futuro, si se consume desde PWA nativa o terceros).
- **Despliegue:** entorno **local** en Mac (desarrollo); producción se evaluará con **IONOS** (no verificado).

### 5.1 Compatibilidad verificada documentalmente (sin bloqueos)

| Componente | Requisito | Estado |
|---|---|---|
| PHP | 8.3+ (Laravel 13) | Compatible |
| Laravel 13 + Inertia 3 + Vue 3 + TypeScript | `inertia-laravel` 3.x, Vite, TS | Compatible (sin bloqueo demostrable) |
| Filament 5 | PHP 8.2+, Laravel 11.28+, Tailwind 4.1+ | Compatible con Laravel 13 |
| PostgreSQL + PostGIS | extensión PostGIS, driver `pgsql` | Por verificar **en el entorno local** antes de modelar (riesgo, no bloqueo) |
| Node.js | 22+ para SSR de Inertia | Requisito operativo de SSR |

> **No se detectó ninguna incompatibilidad demostrable** entre los componentes adoptados. La verificación pendiente es **operativa** (instalar y comprobar en local), no teórica.

### 5.2 Entorno local (Mac) — requisitos y decisiones por concretar

- **Requisitos:** PHP 8.3+, Composer, Node.js 22+, PostgreSQL + PostGIS, Mailpit/MailHog (capturador de correos), Vite, Tailwind 4.
- **PostgreSQL/PostGIS:** instalar localmente (p. ej. Postgres.app/Homebrew) o vía **Docker solo para la base de datos** (alternativa, no impuesta); debe quedar documentada la opción elegida al preparar el desarrollo.
- **Por concretar en la preparación:** versiones exactas fijadas, `.env.example`, semillas de datos de prueba, estrategia de migraciones con PostGIS, y comandos reproducibles de arranque.
- **No se contrata infraestructura ni se despliega en esta etapa.**

### 5.3 Estrategia SEO (Inertia + SSR preferente)

- **Páginas públicas indexables:** ficha de lugar, ficha de ruta, catálogo/búsqueda pública, páginas de contenido público (según `13`).
- **No indexables:** formularios de autenticación, áreas privadas (favoritos, itinerarios, cuenta), panel **Filament** (`/admin`) — con `noindex` y protección por auth.
- **Por página pública:** título y descripción dinámicos, URL canónica, metadatos Open Graph/Twitter, **Schema.org** (JSON-LD), códigos HTTP correctos (200/404/301), enlaces internos.
- **Sitemap XML + robots.txt** generados desde Laravel; **es/en** con URLs por idioma y **hreflang**; prevención de duplicados con canonical.
- **SSR de Inertia** como solución preferente para servir HTML completo en las páginas públicas; requisitos operativos: build SSR, proceso Node 22+, supervisión del proceso. **La ejecución real en IONOS se comprobará en fase posterior.**
- **El SEO no está validado:** requiere aplicación funcional e inspección de respuestas HTML en staging/producción.

### 5.4 Autenticación OTP y correo (P-04)

- OTP numérico de **6 dígitos** por correo **solo durante el registro**; cuenta pendiente hasta validar; **no es 2FA por login**; sin enlace como flujo principal.
- Parámetros propuestos: caducidad **10 min**, **5 intentos** por código, **60 s** entre reenvíos; a definir en configuración y contrato de autenticación.
- Envío por **SMTP con cuenta de Google dedicada**; credenciales solo en variables de entorno; **capturador de correos en local**; sin credenciales reales en archivos.
- Recuperación de contraseña y login con Google: **fuera de alcance** hasta autorización expresa. Detalle: `16`.

### 5.5 Panel Filament y autorización (P-05)

- **Filament 5 cubre directamente:** CRUD, formularios, validación, tablas, autenticación del panel, notificaciones, widgets/métricas.
- **Debe configurarse:** protección de `/admin` (middleware + autorización), **políticas/Gates** por recurso, roles y permisos según la matriz **15×4** (`17`), autorización **en servidor** para operaciones sensibles (incl. moderación y auditoría).
- Se conservan los **15 permisos y reglas RS-1…RS-9** sin inventar roles ni reducir permisos. Detalle: `17`.

### 5.6 Implicaciones PostGIS (sin implementar)

- Columnas `geography`/`geometry` SRID 4326 para lugares, rutas (LineString), waypoints; índices **GiST**; consultas `ST_Distance`, `ST_DWithin`, `ST_Buffer`, KNN (`<->`).
- En Laravel: migraciones con SQL PostGIS o paquete complementario; Eloquent con expresiones nativas (`DB::raw`) para lo espacial; validación de coordenadas en servidor.
- Afecta a: `08` (entidades `Place`, `Route`, `Waypoint`, búsquedas), RF-01/RF-02/RF-04, y requisitos de proximidad/corredores. **Sin migraciones ni código en esta etapa.**

---

## 6. Fases, dependencias y criterios de salida

| Fase | Objetivo | Dependencias | Criterios de salida |
|---|---|---|---|
| **Fase 0** | Auditoría y preparación | — | Documentación verificada; contradicciones identificadas; trazabilidad inicial; criterios de entrada definidos |
| **Fase 1** | Cierre de arquitectura y especificaciones | P-02, P-07, P-08, alcance 2FA (P-04), firma exportación (P-05) — P-01/P-03/P-04/P-05 base ya adoptadas | Proveedores, privacidad/retención, alcance MVP y contratos pendientes cerrados |
| **Fase 2** | Diseño técnico y entornos | Fase 1 | Repo, convenciones, secretos, ramas, entornos, CI, migraciones, datos de prueba, observabilidad |
| **Fase 3** | Fundamentos de la aplicación | Fase 2 | Proyecto inicializado; design system; navegación; auth+permisos; registro de errores; integración frontend-backend-DB |
| **Fase 4** | Funcionalidades del producto | Fase 3 | Módulos incrementales (exploración, mapa, búsqueda, fichas, usuarios/reseñas, itinerarios, admin, seguridad, i18n/SEO/PWA) |
| **Fase 5** | Integración y estabilización | Fase 4 | Pruebas integrales, regresión, permisos, accesibilidad, rendimiento, revisión visual vs Stitch, seguridad |
| **Fase 6** | Preparación del lanzamiento | Fase 5 | Staging validado; migraciones reversibles; backups; dominio/HTTPS; monitorización; checklist; plan de incidentes |
| **Fase 7** | Operación y evolución | Fase 6 | Corrección de defectos; métricas; actualizaciones; mantenimiento; mejoras post-MVP |

---

## 7. Plan de sprints

> **Supuestos:** equipo de **1–2 desarrolladores** (capacidad real no confirmada). **Estimaciones relativas** (baja/media/alta), no hay velocidad de equipo conocida. **Las sprints de Fase 3+ son PROVISIONALES y BLOQUEADAS por P-01** (stack). Duración orientativa: 1–2 semanas.

### Fase 0 — Auditoría (sprint 0, stack-ágil)
| Sprint | Objetivo | Alcance | Entregable | Criterio de aceptación |
|---|---|---|---|---|
| **S0** | Auditoría y preparación | Verificar docs/requisitos/decisiones; contradicciones; trazabilidad; Stitch | Este plan + matriz de trazabilidad | Trazabilidad REQ→decisión→módulo completa; contradicciones listadas |

### Fase 1 — Cierre de arquitectura (sprints A1–A3, decisiones)
| Sprint | Objetivo | Dependencia | Entregable | Criterio |
|---|---|---|---|---|
| **A1** | Stack y arquitectura lógica | **RESUELTA** (P-01 ADOPTADA: Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS) | Decisión registrada en `11` §10 | Stack adoptado |
| **A2** | Modelo de datos + contratos API + auth/seguridad | A1, P-04, P-05 | Esquema + OpenAPI + diseño auth | Modelo coherente con `08`; auth según `16`/`17` |
| **A3** | Privacidad/retención + cartografía/alcance MVP | A1, P-02, P-03, P-07, P-08 | Política + proveedores + alcance cerrado | P-02/P-03/P-07/P-08 aprobados |

### Fase 2 — Diseño técnico y entornos (sprints B1–B2, stack-específico)
| Sprint | Objetivo | Dependencia | Entregable | Criterio |
|---|---|---|---|---|
| **B1** | Repo, convenciones, secretos, ramas, CI | A1 | Repo + CI verde | `lint && test` en verde; sin secretos |
| **B2** | Entornos, migraciones, datos de prueba, observabilidad | B1 | Entornos local/pruebas/staging + migraciones reversibles | Migración aplicable y reversible; datos de prueba |

### Fase 3 — Fundamentos (sprints C1–C3, **PROVISIONAL/BLOQUEADO por P-01**)
| Sprint | Objetivo | Requisitos | Entregable | Criterio |
|---|---|---|---|---|
| **C1** | Inicialización + design system + componentes | REQ-UI-05/06/07 | Componentes base en 390/1280 | Componentes idénticos a `REQ-UI-06` |
| **C2** | Navegación + responsive | REQ-UI-01/02/04/08/09 | Shell con 3 patrones | 3 detents funcionan en dispositivo real |
| **C3** | Auth + permisos + registro de errores | REQ-AUTH-01…04, REQ-ADM-13 | Login/registro/OTP + RBAC + tests negativos | 403 por permiso; 429 rate limit; no enumeración |

### Fase 4 — Funcionalidades (sprints D1–D6, **PROVISIONAL/BLOQUEADO por P-01**)
| Sprint | Módulo | Requisitos | Entregable | Criterio |
|---|---|---|---|---|
| **D1** | Exploración + mapa + geolocalización | REQ-MAP-01/02/04, REQ-UI-01 | Mapa full-bleed + permisos ubicación | Flujo V-1 hasta la ficha |
| **D2** | Búsqueda + proximidad + trayectos | REQ-MAP-03, REQ-RUT-01…03, RF-22 | Búsqueda con estados + modo seguir | V-2 completo; proximidad en cliente |
| **D3** | Fichas + imágenes + vídeos | REQ-PLZ-01, REQ-ADM-04, RF-23 | Ficha con galería + vídeo | Ficha completa; WebP; vídeo 15–25 s |
| **D4** | Usuarios + reseñas + valoraciones | REQ-REV-01…04, REQ-AUTH-05 | Reseñas + cola offline + recuperación | V-4 con offline; reenvío idempotente |
| **D5** | Itinerarios + favoritos | REQ-FAN-01/02 | Favoritos + itinerarios | V-3 con offline |
| **D6** | Admin + moderación + seguridad + i18n/SEO/PWA | REQ-ADM-01…14, REQ-WEB-01, REQ-MULTI-01 | Consola + moderación + SEO + PWA | A-1…A-4 con RBAC; fichas indexables; PWA instalable |

### Fase 5 — Integración (sprints E1–E2, **PROVISIONAL/BLOQUEADO**)
| Sprint | Objetivo | Entregable | Criterio |
|---|---|---|---|
| **E1** | Pruebas integrales + regresión + accesibilidad | Informe de pruebas | Sin críticos/serios (axe-core); V-1…V-5 verdes |
| **E2** | Rendimiento + revisión visual vs Stitch + seguridad | Informe de rendimiento y visual | Presupuesto de carga; diferencias revisadas; sin vulnerabilidades críticas |

### Fase 6 — Lanzamiento (sprint F1, **PROVISIONAL/BLOQUEADO**)
| Sprint | Objetivo | Entregable | Criterio |
|---|---|---|---|
| **F1** | Staging + migraciones + backups + dominio + monitorización | Checklist de lanzamiento | Staging validado; backup restaurado; HTTPS; alertas activas |

### Fase 7 — Operación (continuo)
Corrección de defectos, métricas, actualizaciones de dependencias, mantenimiento de seguridad, mejoras post-MVP.

---

## 8. Estrategia de pruebas

### 8.1 Pirámide de pruebas

```
        /  E2E (Playwright)  \
       /  Integración (API/DB) \
      /  Unitarias (Pest/Vitest) \
```
- **Unitarias** (base, ~60%): reglas de negocio, permisos, validaciones, utilidades.
- **Integración** (~30%): API, DB/migraciones, auth, permisos, formularios.
- **E2E** (~10%): flujos críticos V-1…V-5, A-1…A-4.

### 8.2 Tipos de prueba

| Tipo | Objetivo | Nivel | Herramienta candidata | Momento | Resultado esperado | Evidencia |
|---|---|---|---|---|---|---|
| Unitaria | Reglas de negocio | Unidad | Pest/PHPUnit (backend) + Vitest (frontend Vue) | Cada PR | Verde | Log de test |
| Integración | API/DB/auth | Integración | Pest+HTTP (A) / Supertest (B) | Cada PR | Verde | Log + respuestas |
| API | Contratos | Integración | Pest / Supertest | Cada PR | Contrato válido | OpenAPI + tests |
| DB/migraciones | Esquema | Integración | Migraciones + tests | Cada PR | Aplicable y reversible | Migración test |
| Autorización | Permisos | Integración | Tests de roles | Cada PR | 403 donde toca | Matriz de tests |
| Autenticación | Login/OTP/recuperación | Integración | Tests de flujo | Cada PR | OTP funciona; no enumeración | Log de auth |
| Formularios | Validación | Integración | Tests de request | Cada PR | 422 con campos | Tests |
| E2E | Flujos críticos | E2E | Playwright | Pre-staging | Sin fallos en 3 anchos | Screenshots + vídeo |
| Visual | Regresión UI | E2E | Playwright + capturas | Pre-staging | Diferencias revisadas | Capturas con ID/fecha |
| Responsive | 390/768–1024/1280 | E2E | Playwright | Pre-staging | Sin fallos | Screenshots 3 anchos |
| Accesibilidad | WCAG | E2E | axe-core | Pre-staging | Sin críticos/serios | Informe axe |
| Seguridad | Vulnerabilidades | E2E | Revisión + herramientas | Pre-staging | Sin críticos | Informe |
| Rendimiento | Carga | E2E | k6 / Lighthouse | Pre-staging | Dentro de presupuesto | Informe |
| SEO | Indexabilidad | E2E | Lighthouse / rastreador | Pre-staging | Fichas indexables | Informe SEO |
| Geoespacial | Mapa/proximidad | Integración | Tests de consultas | Cada PR | Consultas correctas | Tests espaciales |
| PWA/offline | Sin conexión | E2E | Playwright (red cortada) | Pre-staging | Cola y reenvío | Test offline |
| Recuperación | Restauración | E2E | Ejercicio de restauración | Pre-lanzamiento | RPO/RTO cumplidos | Informe de restauración |

### 8.3 Controles por etapa

| Etapa | Controles |
|---|---|
| **Cada PR** | `lint && test` unitarias+integración; sin secretos; revisión de código |
| **Pre-staging** | E2E flujos críticos; visual 3 anchos; accesibilidad; rendimiento; seguridad |
| **Pre-lanzamiento** | Staging validado; backup restaurado; migraciones reversibles; checklist |

**Umbrales justificables** (no arbitrarios): 0 vulnerabilidades críticas/altas; 0 errores de accesibilidad críticos/serios; flujos V-1…V-5 y A-1…A-4 en verde; migraciones reversibles; backup restaurado con éxito. **No se imponen porcentajes de cobertura como garantía**; se exige cobertura de los módulos críticos (auth, permisos, pagos, moderación).

---

## 9. Integración de Stitch y regresión visual

Las 62 pantallas son **referencia de diseño**, no prueba de implementación.

### 9.1 Proceso

1. **Inventariar** las 62 pantallas por módulo y dispositivo (ya en `06`/`19`).
2. **Identificar** flujos, estados, variantes y componentes compartidos.
3. **Relacionar** cada pantalla con sus requisitos e historias (matriz §14).
4. **Obtener capturas de referencia autorizadas** — **la evidencia histórica se perdió**; hay que **regenerarlas desde Stitch** (requiere tu autorización, P-24). **No se afirma que se han recuperado.**
5. **Comparar** la implementación con el diseño.
6. **Registrar** diferencias visuales y funcionales.
7. **Corregir** desviaciones y repetir.
8. **Conservar** evidencias con identificador, fecha, versión y resultado.

### 9.2 Estado de la evidencia

| Concepto | Registrado (`19`) | Inspeccionado (2026-10-10) |
|---|---|---|
| screens/ (62 PNG + 62 HTML) | 124 | **0 — PERDIDA** |
| screens-full/ | 62 | **0** |
| crops/ | 38 | **0** |
| **Total** | **226 (≈63 MB)** | **0** |

**Plan de regeneración (P-23/P-24):** capturar de nuevo las 62 pantallas desde Stitch (intacto) y almacenarlas en una ruta estable. **No se ejecuta sin tu autorización.**

---

## 10. Seguridad, privacidad y cumplimiento

### 10.1 Controles técnicos

| Área | Control |
|---|---|
| Protección de datos | Minimización; cifrado en tránsito (HTTPS) y en reposo; registro de acceso |
| Consentimiento | Checkbox no premarcado; registro de consentimientos (`Consent`) |
| Ubicación | Procesada en cliente; no se almacena en servidor por defecto (RF-01/02) |
| Sesiones/OTP | TTL 10 min; rate limit; anti-enumeración; hash de códigos; recuperación segura |
| Control de acceso | RBAC por acción (matriz `17`); mínimo privilegio; evaluación en servidor |
| Moderación | Cola con estados; rechazo motivado; trazabilidad |
| Información sensible | Email no visible en moderación (D-12); EXIF purgado (R6) |
| Retención/eliminación | Política `18`; borrado vs anonimización; cascada |
| Incidentes | Procedimiento (P-19); registro; notificación |
| Dependencias | Escaneo de vulnerabilidades; actualizaciones |

### 10.2 Cumplimiento legal (Perú) — verificado vs pendiente

| Obligación | Estado |
|---|---|
| Consentimiento expreso/previo/informado | **[VER]** Ley 29733 + DS 016-2024-JUS |
| Política de Privacidad (art. 18) | **[VER]** |
| Registro Banco de Datos ANPDP | **[VER]** Ley 29733 art. 29 |
| ARCO + portabilidad + desindexación | **[VER]** Plazos: información 8, acceso 20, rectificación/cancelación/oposición 10 (hábiles/calendario por confirmar) |
| Libro de Reclamaciones Virtual | **[VER]** 15 días hábiles; conservación 2 años; libro físico de respaldo; multas 50–450 UIT (INDECOPI / DS 101-2022-PCM) |
| Notificación de brechas | **[VER]** DS 016-2024-JUS art. 34: **48 h** (con condiciones) |
| Licencia UGC / autorización imagen | **[PDF]** (texto requiere abogado) |
| Oficial de Datos Personales | **[VER]** DS 016-2024-JUS: ODP para grandes empresas (desde 2025-11-30) |

> **El plan técnico no sustituye a la asesoría legal.** Los textos legales (P-20), los plazos exactos ARCO (P-17) y el Libro de Reclamaciones (P-18) requieren validación jurídica profesional.

---

## 11. Estrategia de CI/CD y despliegue

| Aspecto | Estrategia |
|---|---|
| Ramas | `main` (protegida), `develop`, feature branches; PR obligatorio |
| CI | Lint + tests unitarias/integración en cada PR; build de assets |
| CD | Auto a staging tras merge a `develop`; manual a producción |
| Entornos | local, pruebas, staging, producción (configuración por variables) |
| Migraciones | Versionadas, reversibles, probadas en local |
| Secretos | Variables de entorno / secret manager; nunca en código |
| Backups | Automáticos, cifrados, fuera del servidor; restauración probada |
| Monitorización | Logs con `requestId`; alertas; métricas |
| Despliegue | Entorno **local** en Mac (desarrollo); producción se evaluará con **IONOS** (no verificado) |

---

## 12. Riesgos y mitigaciones

| Riesgo | Impacto | Mitigación |
|---|---|---|
| **P-01 (stack) adoptado** | Base para construir | Stack registrado en `11` §10; preparar entorno local |
| **PostGIS por verificar en local** | Consultas espaciales sin probar | Instalar extensión + comprobar migraciones/consultas antes de modelar |
| **Evidencia visual perdida** | Sin regresión de referencia | Regenerar desde Stitch (P-23/P-24) |
| **Decisiones legales abiertas** | Publicación ilegal | No publicar copy legal sin dictamen (P-17…P-20) |
| **Equipo pequeño/capacidad desconocida** | Retrasos | Estimaciones relativas; sprints incrementales; alcance flexible |
| **Cambios de alcance** | Alcance inflado | Cambios se presentan antes de aprobarse (P-08) |
| **Dependencias desactualizadas** | Vulnerabilidades | Escaneo; actualizaciones planificadas |
| **PWA en iOS** | Push/offline limitados | Alcance primer plano (D-07); comunicar limitaciones |

---

## 13. Matriz de trazabilidad (Requisito → decisión → módulo → historia → sprint)

> Conserva la numeración original. Las sprints de Fase 4+ son **PROVISIONALES/BLOQUEADAS por P-01**.

| Requisito | Decisión | Módulo | Historia de usuario (tipo) | Sprint |
|---|---|---|---|---|
| REQ-UI-01/04 | D-01 | Exploración | Ver mapa full-bleed con capa editorial | D1 |
| REQ-MAP-01/02/04 | D-14 | Mapa | Explorar y geolocalizar | D1 |
| REQ-MAP-03 | D-05 | Búsqueda | Buscar lugares con estados | D2 |
| REQ-RUT-01…03, RF-22 | D-07 | Rutas | Seguir ruta con proximidad | D2 |
| REQ-PLZ-01 | — | Ficha | Ver ficha de lugar completa | D3 |
| REQ-ADM-04, RF-23 | — | Medios | Ver galería y vídeo | D3 |
| REQ-AUTH-01…04 | D-06 | Auth | Registrarme y acceder con OTP | C3 |
| REQ-AUTH-05 | D-06 | Auth | Recuperar contraseña | D4 |
| REQ-REV-01…04 | D-08, D-10 | Reseñas | Reseñar con cola offline | D4 |
| REQ-FAN-01/02 | D-10 | Itinerarios | Guardar favoritos e itinerarios | D5 |
| REQ-ADM-01…14 | D-09, D-12, D-13 | Admin | Gestionar contenido y usuarios | D6 |
| REQ-SET-01/02/03 | D-07 | Ajustes | Configurar idioma y notificaciones | D6 |
| REQ-WEB-01 | P-01 | SEO | Fichas indexables | D6 |
| REQ-MULTI-01 | P-14 | i18n | Ver app en español e inglés | D6 |
| REQ-APP-01/02/03 | D-07 | PWA | Instalar y usar sin conexión | D6 |
| REQ-PRV-01/02/03 | D-15 | Privacidad | Gestionar consentimientos y ARCO | D6 |
| REQ-LEG-01 | D-15 | Legal | Libro de Reclamaciones | Fase 6 (tras P-18) |

---

## 14. Criterios de aceptación

### 14.1 Funcionales
- Flujos V-1…V-5 y A-1…A-4 completos en 390/768–1024/1280.
- Auth con OTP: login, registro, verificación, recuperación; sin enumeración.
- RBAC: 15 permisos verificados en servidor; 403 donde toca.
- Reseñas: cola offline con reenvío idempotente; sin SLA < 24 h; sin puntos.
- PWA: instalable iOS/Android; offline con cola.
- SEO: fichas indexables con title, meta, Schema.org; sitemap; robots.

### 14.2 Técnicos
- `lint && test` en verde en CI; sin secretos en el árbol.
- Migraciones reversibles; backup restaurado con éxito.
- Sin vulnerabilidades críticas/altas.
- Accesibilidad: sin críticos/serios (axe-core).
- Rendimiento: dentro de presupuesto de carga (gama baja).

### 14.3 Visuales
- Componentes idénticos a `REQ-UI-06` en 390 y 1280.
- Diferencias vs Stitch revisadas y aceptadas una a una.
- 38/38 hex de roles de color intactos (D-02).

### 14.4 Seguridad
- Autorización en servidor verificada; rate limit (429); no enumeración.
- Consentimientos opt-in; ubicación en cliente; email no visible (D-12).

---

## 15. Definición de terminado

Una funcionalidad está **terminada** cuando:
1. El código está implementado y revisado.
2. Las pruebas unitarias/integración/E2E relevantes pasan en CI.
3. La migración (si aplica) es aplicable y reversible.
4. No hay secretos en el árbol; las dependencias están justificadas.
5. La documentación necesaria está actualizada.
6. Los criterios de aceptación de la historia se cumplen.
7. La evidencia (tests, capturas) se conserva con identificador, fecha y versión.
8. **No se da por terminada** solo por existir código: requiere pruebas y aceptación.

---

## 16. Indicadores de seguimiento

| Indicador | Fuente | Frecuencia |
|---|---|---|
| Historias por estado (propuesto/en desarrollo/implementado/en pruebas/aceptado) | Backlog | Cada sprint |
| Cobertura de pruebas (módulos críticos) | CI | Cada PR |
| Resultados de accesibilidad | axe-core | Pre-staging |
| Vulnerabilidades abiertas | Escaneo de dependencias | Semanal |
| Estado de decisiones P-01…P-24 | `11` | Cada sprint |
| Diferencias visuales vs Stitch | Regresión | Pre-staging |
| Estado de evidencias | `19` | Cada sprint |

---

## 17. Condiciones para autorizar el inicio del desarrollo

1. **P-01 adoptado** (stack Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS) — base para construir.
2. **P-02/P-03 aprobados** (proveedor de teselas y BD/entorno) — bloquea costes y esquema.
3. **P-04/P-05 aprobados** (contrato OTP y matriz RBAC) — bloquea auth y consola.
4. **P-07/P-08 aprobados** (retención y alcance MVP) — bloquea esquema de purga y alcance.
5. **P-23/P-24 autorizados** (regenerar evidencia y lotes Stitch) — bloquea regresión visual.
6. **P-17…P-20 resueltos** (legal) — bloquea publicación de copy legal.
7. **Aprobación de este plan** por el responsable del proyecto.

> **No se inicia el desarrollo** hasta que se cumplan las condiciones 1–4 (mínimo para construir). Las sprints de Fase 3+ son **PROVISIONALES/BLOQUEADAS** hasta entonces.

---

## 18. Contradicciones y datos faltantes detectados

| # | Contradicción / hueco | Estado |
|---|---|---|
| 1 | PDF propone Laravel 11 (EOL) → corregido a Laravel 13 | Resuelto en §4.1 |
| 2 | PDF vs FASE 1.7: stack distinto | **Resuelto** — adoptado Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS (§4, `11` §10) |
| 3 | Evidencia FASE 1.5 perdida | Registrada; regeneración planificada (P-23/P-24) |
| 4 | SEO local sin REQ formal | Creado REQ-WEB-01 |
| 5 | Idiomas es/en sin REQ formal | Creado REQ-MULTI-01 |
| 6 | Matriz RBAC 15×3 vs 15×4 | Alineada a 15×4 (P-05) |
| 7 | Plazos legales (ARCO, brechas) | Verificados con condiciones; texto requiere abogado |
| 8 | Stadia ToS no verificado (URL 404) | Pendiente de verificación |

---

## 19. Supuestos utilizados

- Equipo de 1–2 desarrolladores (capacidad real no confirmada).
- Estimaciones relativas (baja/media/alta), no hay velocidad de equipo conocida.
- El piloto es Tarma con ≈24 lugares y 1–2 rutas.
- La Opción A se describe a título orientativo (no aprobada).
- Las sprints de Fase 3+ son provisionales/bloqueadas por P-01.
- No se dispone de fecha de lanzamiento objetivo confirmada.

---

## 20. Siguiente paso recomendado

**Aprobar el stack definitivo (P-01)** — es la condición #1 que desbloquea todo lo demás. Con esa decisión (y las condiciones 2–4), la Fase 2 queda desbloqueada y el desarrollo puede iniciar de manera ordenada.

> **No se inicia automáticamente la siguiente fase.**

---

## 21. Registro de avance — base técnica inicializada (2026-10-10)

> Addendum chronological; no reescribe el estado histórico anterior. P-01 ya estaba ADOPTADA (alineación
> definitiva en `11` §10); este registro deja constancia de su materialización parcial en una base funcional.

- **Base creada en la raíz del repositorio** (convive con `docs/` intacto): Laravel 13.35.0 (PHP 8.5.10),
  `inertia-laravel` ^3.5 + `@inertiajs/vue3` 3.9.1 + Vue 3.5.43 + TS 5.9, Filament ^5.10 con panel `/admin`,
  `maplibre-gl` 6.13.0 como dependencia, Vite 8 + Tailwind 4, `laravel/boost` dev.
- **Conexión Laravel→PostgreSQL verificada sin migraciones**: `pgsql 127.0.0.1:5433/lumina`, PG 18.6 +
  PostGIS 3.6.3 (GEOS 3.14.1, PROJ 9.7.1); funciones `ST_DWithin/ST_Distance/ST_Buffer`, KNN `<->` y SRID 4326
  comprobados por ejecución de solo lectura (MCP `postgres-local`); la BD conserva solo `spatial_ref_sys`.
- **Comprobaciones ejecutadas**: `vue-tsc --noEmit` OK · `vite build` OK · `php artisan test` 2/2 OK ·
  `GET /` 200 (Inertia) · `GET /admin` 302→login · `GET /admin/login` 200 · Pint aplicado.
  No validados: SSR, SEO, SMTP real, Mailpit, consultas de negocio, IONOS. P-02 sigue pendiente.
- **Documento de arquitectura**: `docs/arquitectura/00-arquitectura-base.md` (relaciones, responsabilidades,
  organización del código, PostGIS, SEO, OTP, Filament, transversales, pendientes).
- **Siguiente incremento propuesto**: lote framework controlado (sesiones/caché/colas + `users` + OTP) con
  migraciones reversibles y tests Feature en verde. Requiere autorización expresa (altera la BD).

---

## 22. Registro de avance — persistencia + auth OTP (2026-10-10)

> Incremento funcional limitado a persistencia framework, `users` base y registro con OTP. Sin tablas de negocio.

- **Destino verificado antes de migrar**: config resuelta `pgsql 127.0.0.1:5433/lumina` (sin `DB_URL`) y servidor
  confirma `lumina`/puerto 5433/PG 18.6; solo existía `spatial_ref_sys` (8500 filas, intacta). Sin `fresh`/`wipe`.
- **Migraciones (lote 1, `migrate --path`)**: `0001_01_01_000000` (`users`, `password_reset_tokens`, `sessions` —
  lote framework sin modificar) + `2026_10_10_215940` (`otp_codes`: FK cascade, índice `user_id/used_at`,
  `down()` honesto). `cache`/`jobs` pendientes: drivers siguen `file`/`sync` por innecesarios. 0 filas, 0 negocio.
- **Implementado**: `config/otp.php`, `OtpManager`, `RegisterUserWithOtp`, `OtpCodeMail` + plantilla texto,
  4 Form Requests, 6 controladores `Auth/*`, rutas con `throttle:auth/otp`, páginas Vue
  `Register/Verify/Login/Account`, `MustVerifyEmail` + `canAccessPanel` verificado-denegado, Mailpit v1.31.4
  (entrega local verificada, buzón purgado; 0 correos reales; 0 secretos en repo).
- **Pruebas**: 18/18 (104 assertions) — registro, OTP bueno/malo/expirado/agotado/reenvío ±cooldown/reúso,
  pendiente bloqueado (`/cuenta`, `/admin` 403, login sin sesión), verificado OK, anti-enumeración, home 200;
  `vue-tsc`/`vite build`/Pint OK; rollback verificado en SQLite desechable; HTTP verificado con `serve`.
- **No validado**: SSR, SEO, SMTP real, autorización integral, consultas espaciales. Matriz 15×4 y RS-1…RS-9
  intactas. Siguiente: modelo de dominio turístico + diseño de migraciones geoespaciales (sin implementar).

---

## 23. Registro de avance — diseño del modelo de dominio (2026-10-10)

> Solo análisis y documentación. Sin migraciones, sin cambios de BD (verificada por lectura: 6 tablas de
> infra), sin dependencias, sin datos, sin `fresh`/`wipe`.

- **Creado** `docs/arquitectura/01-modelo-dominio-geoespacial.md`: 16 tablas en 9 grupos (categorías+i18n,
  lugares, rutas+paradas, itinerarios/favoritos, reseñas, multimedia, moderación/reportes, patrocinios,
  privacidad/auditoría/notificaciones), diagrama Mermaid, campos/obligatoriedad/unicidad/FK, estados,
  estrategia GiST/B-tree/GIN, patrones `ST_DWithin`+KNN y corredor con `ST_LineLocatePoint`, reglas
  Eloquent/migraciones/Inertia/MapLibre, SEO/i18n, criterios de aceptación.
- **Decisiones**: DD-01…DD-07 **[PROPUESTA]** (consolidaciones, polimórficas, i18n, `geography`/`geometry`,
  contadores); DD-08/DD-09 adoptadas por alcance (fuera: Claim/P-18, métricas P-15, gamificación, 2.º plano,
  SMS, IA). `08`/`07`/`13`/`17`/`11` no reescritos (trazabilidad). Puntero añadido en `00` §3.
- Siguiente (no implementado): migraciones geoespaciales por incremento autorizado.