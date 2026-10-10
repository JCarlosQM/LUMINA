# LUMINA — Propuesta de Arquitectura (PROVISIONAL, requiere confirmación)

> **Advertencia:** no hay ninguna decisión de stack confirmada por el usuario, ni modelo de datos, ni API. Todo lo que sigue es una *propuesta justificada* derivada de restricciones observadas en Stitch. Nada de este documento debe tratarse como aprobado.
> **ALINEACIÓN DEFINITIVA (2026-10-10):** el stack adoptado es **Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS** (`11` §10). Este documento se conserva como propuesta histórica stack-agnóstica (SPA, MapLibre, API única, offline); **no propone arquitectura objetivo vigente**.

## 1. Restricciones observadas (las únicas "dadas")

1. Diseño en dos anchos: 390 px y 1280 px (§2 del informe). Breakpoints del designMd: <768, 768–1024, >1024.
2. Mapa full-bleed continuo con capa editorial encima (bottom sheet en móvil, panel en tablet, split en desktop).
3. PWA instalable con modo offline y caché (A01M–A04M, 11M).
4. Reseñas con respaldo offline (G05M) → la escritura debe funcionar sin red y encolarse.
5. Consola admin separada, densa, tablas/formularios, solo desktop/tablet.
6. i18n + toponimia (H02M); consentimiento de telemetría (H06M); ARCO (H07M).
7. Importación GPX (ADM-08) → procesamiento de archivos en servidor.

## 2. Propuesta

### 2.1 Frontend público: PWA SPA
- **Justificación:** el mapa debe permanecer continuo entre rutas (el designMd lo llama "Map Layer (Full-Bleed Engine)" edge-to-edge). Un modelo de documentos multipágina conlleva remontar/rehidratar el mapa en cada navegación. Una SPA con shell persistente encaja con el patrón "split-canvas" y con los estados offline.
- **Mapa:** MapLibre GL JS (mencionado explícitamente en el designMd).
- **Estado:** almacenamiento local para favoritos/cola offline + capa de sincronización con reintentos (necesario por G05M y 11M).
- **i18n:** capa de traducción desde el inicio (H02M lo exige tarde o temprano).
- **Deshabilitado hasta confirmar:** SSR/SSG (el contenido editorial de fichas de lugar podría beneficiarse de SEO; decisión pendiente, podría optarse por renderizado estático de fichas + shell interactiva).

### 2.2 Consola admin: aplicación separada
- **Justificación:** distinto público, distinto modelo de navegación (tablas/CRUD), distinta política de seguridad (RBAC, ADM-18), y el diseño ya la trata como familia independiente (ADM-*) con shell 1280. Mantenerla separada evita cargar el bundle público con librerías de tablas/admin y permite endurecer cabeceras/CSP solo en `/admin`.
- Se reutiliza el design system (tokens), no el shell.

### 2.3 Backend: API única con dos superficies
- Un solo servicio de API con autorización diferenciada (usuario final vs rol admin) es suficiente; no hay evidencia de que necesiten desplegarse distinto.
- Endpoints implícitos por las pantallas: auth (registro/OTP), lugares, rutas (GPX), favoritos, itinerarios, reseñas + moderación, reseñas/reclamaciones legales, usuarios/roles, curaduría, patrocinios, métricas.
- **Límite de confianza:** toda validación (incluida la moderación y la subida de fotos) en servidor. Las pantallas de admin no sustituyen autorización.

### 2.4 Dominio sugerido (a confirmar, NO derivado de especificación)
Agregados mínimos que las 63 pantallas parecen requerir: `User`, `Role`, `Place`, `Photo`, `Route`, `Waypoint`, `GPXImport`, `Favorite`, `Itinerary`, `Review`, `ModerationDecision`, `Sponsorship`, `Consent`, `Complaint`, `LanguageEntry(toponimia)`.
→ **El modelado real está sin especificar (REQ-DATA-01 / R10).**

### 2.5 Offline
- Shell, locales y contenido ya visitado en caché (11M).
- Cola de escritura persistente para reseñas con estados `pending/synced/failed` (G05M + G10M).
- **Pendiente de definir:** política de resolución de conflictos y cuota máxima de caché.

### 2.6 Capa de diseño
- Los tokens del designMd (color/tipografía/espacio/radio/elevación) como fuente única de verdad, generados a CSS variables y consumidos por público y admin.
- **Requisito previo a implementar:** resolver la contradicción C1 (prosa vs tokens de color). Mientras tanto, cualquier implementación visual es provisional.

## 3. Por qué NO se puede cerrar la arquitectura hoy

| Bloqueante | Qué falta |
|---|---|
| B1 | Contratos de API y modelo de datos (REQ-DATA-01) |
| B2 | Fuente de verdad de tokens de color (C1) |
| B3 | Fuente de verdad de pantallas: set numerado vs codificado (C3) |
| B4 | Requisito SEO/SSG vs SPA pura |
| B5 | Proveedor de tiles de mapa y su coste |
| B6 | Proveedor OTP y canal (A3) |
| B7 | Alcance offline (¿hasta qué punto offline-first?) (A10) |
| B8 | Requisitos jurídicos adjuntos (ARCO, libro de reclamaciones) |

Hasta resolver B1–B3, cualquier elección de framework sería una apuesta, no una decisión.
