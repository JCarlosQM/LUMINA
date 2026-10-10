# LUMINA — Modelo de Dominio y API Provisional (FASE 1.5 · ajustado en FASE 1.7)

> **Estado (FASE 1.7):** **base provisional APROBADA** por P-06 (2026-10-10), sujeta a los ajustes **C-1…C-5** (aplicados y marcados abajo) y a las preguntas abiertas de §7. **Sigue sin ser contrato de producción:** no autoriza migraciones, contratos definitivos ni endpoints funcionales. Este documento deriva el modelo **únicamente** de las 62 pantallas y el `designMd`, y separa lo derivable de lo indeterminado.
> **Alineación 2026-10-10:** este modelo es **conceptual y agnóstico del stack** (no asume Laravel/Node ni MySQL/Postgres). Las decisiones de implementación que dependan del stack definitivo (P-01) se marcan al cerrar la arquitectura. Retención y anonimización (C-7): propuesta en `18-politica-retencion-anonimizacion.md`, pendiente de P-07. Permisos: matriz propuesta en `17-matriz-rbac-propuesta.md`, pendiente de P-05.
> **ALINEACIÓN DEFINITIVA (2026-10-10):** base de datos adoptada = **PostgreSQL con PostGIS** (P-03 ADOPTADA motor). Implicaciones conceptuales (sin implementar): columnas espaciales `geography`/`geometry` con SRID 4326, índices GiST, migraciones Laravel con PostGIS (`laravel-postgis` o SQL nativo), consultas Eloquent vía expresiones nativas (`DB::raw`) para ST_Distance/ST_DWithin/ST_Buffer, y geocodificación/rutas como servicios externos. Detalle: `Plan_Maestro` §4/§5.

---

## 1. Entidades derivadas de las pantallas

Leyenda: **[D]** campo derivado con evidencia directa en un artefacto · **[I]** campo indeterminado (no aparece, se requiere definición) · 🔒 dato personal.

### 1.1 `User` (RF-08, RF-15)
| Campo | Tipo | Evidencia |
|---|---|---|
| `id` | uuid | implícito por sesión y moderación |
| `email` 🔒 | string | `B01M`, `B04M`, `B07M` |
| `password_hash` | string | `B01M` |
| `displayName` 🔒 | string | `B04M` "Nombre", `ADM-10` |
| `role` | enum | `ADM-18`: `SUPER_ADMIN` \| `EDITOR_TOPOGRAFO` \| `MODERADOR_COMUNITARIO`; `ADM-10` añade `EXPLORADOR` |
| `status` | enum | `ADM-10`: activo/suspendido `[I]` (nombres exactos) |
| `reliabilityScore` | percent | `12T` "Fiabilidad: 98%", `ADM-14` |
| `contributionsCount` | int | `ADM-15` "24 contribuciones", `ADM-14` "46 aprobadas" |
| `level` / `points` | int | `G10M` "+40 pts", `H01M` "420 pts · Explorador Ético", `ADM-15` "Nivel 4" → **gamificación [ABI]** |
| `phone` 🔒 | string | **solo si** el OTP pasa a SMS (`B08M`) → A3 `[I]` |
| `language` / `toponymyMode` | enum | `H02M` (Español/Quechua) |
| `createdAt` | datetime | `[I]` implícito |

**Datos personales:** email, nombre, nivel de contribución y posiblemente teléfono y ubicación precisa. Sin pantallas de perfil público se evita exponer email: `ADM-14` muestra `manuel.arrieta@tarma-explora.pe` → **riesgo** (ver §5).

### 1.2 `Place` (RF-01, RF-03, RF-13)
| Campo | Evidencia |
|---|---|
| `id`, `name`, `category` | `01`, `C01`, `ADM-03` |
| `geo.lat`, `geo.lon` | `ADM-14` `-11.357, -75.688`; `D01` GPS sexagesimal |
| `toponymOriginal` (quechua) | `H02M`, `ADM-18` "Parajes & Toponimia" `[I]` si es campo o sistema |
| `altitudeM`, `difficulty`, `duration`, `elevationGain` | `D01`, `F04`, `ADM-04` |
| `accessStatus` (`libre`/`restringido`) | `D01` "Acceso libre" |
| `schedule`, `priceMin/Max`, `paymentMethods` | `03`: `S/ 35-75`, Yape/Plin |
| `status` (borrador/publicado) | `ADM-08` "Guardar Borrador / Validar y Publicar" |
| `isFeatured` | `ADM-11` curaduría de destacados |
| `sponsorshipId` | `ADM-12` + badges públicos |
| `wgs84Verified` | `ADM-02` "100% WGS84 verificado" |
| `avgRating`, `reviewCount` | `D01` 4.9 (318) — **inconsistente entre pantallas [I]** |
| `topographicSheet` (p. ej. 23-M) | `D01` |
| `lastVerifiedAt` / curador | `D01` "Verificado por curadores locales" |

### 1.3 `Route` (RF-04, RF-14)
`id`, `title`, `description`, `category`, `difficulty`, `distanceM`, `elevationGainM`, `maxElevationM`, `durationMin`, `stopsCount` (`F04`), `geometry` (track), `sourceFile` (`GPX 1.1`/`GeoJSON`, `ADM-08`), `waypoints[]`, `proximityBeacons[]` (`ADM-08` paso 3), `offlinePackageSize` (148 MB `E01`), `sponsorshipId`, `status`, `visibility`, `safeguardAlerts` (paso 4).

> ⚠️ **`beacons` y `safeguardAlerts`** tienen requisito de ejecución en segundo plano que la PWA no soporta → A14.

### 1.4 `Waypoint` / `Beacon`
`routeId`, `order` (`ADM-09` reordenable), `name`, `kind` (`photo_camera`, `park`, `flag`, `add_location_alt`), `lat/lon`, `altitudeM`, `radiusM` (`+40 m` en `H05M`), `trigger` (`proximity`, `derivation`, `sunset-45min`).

### 1.5 `Itinerary` (RF-06)
`id`, `ownerId` 🔒, `title`, `description`, `status` (`borrador`/`en_curso`/`completado` — `F04`), `days` (`Día 1 de 2`), `stops[] {placeId, plannedTime, note}`, `metrics {distance, elevationGain, maxElevation}`, `offlineSize` (8.4 MB), `isDownloaded`, `sharedWith` `[I]`.

### 1.6 `Favorite`
`userId` 🔒, `placeId`, `createdAt`. Simple; agrupado en "Mi Lista" (`F01M`).

### 1.7 `Review` (RF-07, RF-16)
| Campo | Evidencia |
|---|---|
| `id` | `G05M` `#1049` |
| `placeId`, `authorId` 🔒 | `ADM-14` |
| `rating` (1–5 + label) | `G04M` "5.0 / Sobresaliente" |
| `body` (≤600 rec.) | `G04M` |
| `photos[]` (≤3) | `G04M` |
| `geoVerification` | `G04M` verificación de geolocalización |
| `status` | `07&08`, `ADM-15`: `PENDIENTE` \| `APROBADO` \| `RECHAZADO` \| `SOLICITAR_EDICION` |
| `rejectionCode` | `ADM-15` "Art. 1 — Respeto Ritual y Sagrado #R1" |
| `moderatorId`, `moderatedAt`, `internalNotes` | `ADM-14` (notas visibles solo staff) |
| `offlineQueuedAt` | `G05M` |
| `exif`/`rawFlag` | `07&08` "RAW o JPG con EXIF intacto" |
| `pointsAwarded` | `G10M` +40 `[ABI]` |

### 1.8 `MediaAsset` (RF-17)
`id`, `ownerId`, `kind` (foto/vídeo), `width/height`, `sizeBytes` (`4032x3024 · 3.4 MB` en `12T`), `exif` (incl. ubicación), `status` de moderación, `placeId/routeId/reviewId`, `libraryTags` (`ADM-06`), `license` `[I]` (derechos de terceros — `H07M` y `ADM-14` lo mencionan).

### 1.9 `Sponsorship` (RF-18)
`id`, `brandName`, `targetType` (`ruta`/`lugar`), `targetId`, `badgeType` (`PATROCINADO` \| `PROMOVIDO` \| `NO_PATROCINADA`), `budget`/`period` `[I]`, `status` (`ADM-12`).

### 1.10 `ModerationItem` (RF-16)
Cola única para reseñas, fotos y reportes: `type` (`REVIEW`/`PHOTO`/`REPORT`), `targetId`, `priority/urgency`, `assignedTo` (custodio), `queueMetrics` (`espera 3.4h`, `T. promedio 4.2 min`, `tasa 92.4%`), `aiRules` `[ABI]`.

### 1.11 `Consent` / `PrivacyRequest` (RF-11)
- `Consent {userId 🔒, type (telemetría|personalización|ubicación|marketing), granted, updatedAt}` — `H06M`.
- `PrivacyRequest {id, userId 🔒, kind (ACCESO|RECTIFICACIÓN|CANCELACIÓN|OPOSICIÓN|PORTABILIDAD), status, submittedAt, dueAt, channel}` — `H07M`.
- `Claim` (Libro de Reclamaciones) `{id, ruc, buyerName 🔒, address 🔒, phone 🔒, email 🔒, detail, amount, ackNumber, dueAt, response}` — `H08M`.
- `AuditLog {actorId, action, entityType, entityId, hash}` — `ADM-18` (`SHA 7e9f..3a21`), `ADM-17`.

### 1.12 `OfflinePackage` / `SyncQueue` (RF-09)
`OfflinePackage {id, kind (MAPA|RUTA|ITINERARIO), version, sizeBytes, sha256, downloadedAt}` — `11M`, `E01`, `F04`.
`SyncQueue {id, entityType, entityId, payload, attempts, lastError, state}` — `G05M`, `11M`.

### 1.13 `NotificationPreference` (ajuste **C-1**, FASE 1.7 — RF-10, flujo V-5)
`NotificationPreference {userId 🔒, channel (PWA|EMAIL), type, enabled, quietHours?}` — `H05M` ("Configurar notificaciones"), `ADM-17`. **Alcance acotado por D-07:** sólo notificaciones en **primer plano**; no se modela geofencing de segundo plano.

### 1.14 `Report` (ajuste **C-2**, FASE 1.7 — RF-16)
`Report {id, reporterId 🔒, targetType (REVIEW|PHOTO|PLACE), targetId, reasonCode, note?, status, createdAt}` — `ADM-13` (pestaña "Reportes", `ModerationItem.type=REPORT`). Un reporte crea/enriquece un `ModerationItem` de la cola. **Anti-abuso:** autenticación obligatoria + rate limit (ver §5 R13).

---

## 2. Qué queda **indeterminado** (no se inventa)

1. **Esquema físico y motor**: relacional/documental, sistema de coordenadas de almacenamiento, índice espacial `[I]` — **dirección** PostgreSQL+PostGIS aprobada en P-01; **proveedor/entorno pendiente (P-03)**.
2. **Identidad**: canal OTP = **correo adoptado (D-06)**; contrato OTP y proveedor: `16-especificacion-otp-autenticacion.md` (pendiente P-04). Siguen abiertos: SSO/social, 2FA/TOTP de consola (observado en `ADM`, pendiente de alcance).
3. **Reglas de negocio**: ordenación del mapa, límites de itinerario, umbral de rechazo, límites de subida, retención de medios (→ `18`, P-07). ~~`points`/`level` de gamificación~~ — **fuera del MVP por D-10**.
4. **Moderación**: SLA público — D-08 prohíbe prometer < 24 h sin métricas (cifra: P-16); si hay IA automática (`ADM-13` "Configurar Reglas AI") — **congelada por D-13/P-21**; quién publica inmediatamente → permisos G1/G4 en `17-matriz-rbac-propuesta.md` (P-05).
5. **Capacidad de carga**: origen del dato de 1.000 visitantes / 84% (`ADM-17`).
6. **Patrocinios**: reglas de etiquetado y tope.
7. **Multi-idioma**: si todo el contenido (reseñas, toponimia) se traduce o solo UI.
8. **Numeración/tipos de dato**: `Decimal` para coordenadas, `BIGINT` para auditoría, etc.
9. **¿El logotipo y los mock de mapa son recursos del proyecto o mock?** (`L5`).

---

## 3. Permisos (derivados de `ADM-18` + `ADM-10`)

> **FASE 1.7:** `ADM-18` fue leído **campo a campo** y la matriz completa (15 permisos × 4 roles, con la configuración observada del TIER 2 y las reglas de separación de funciones) vive ahora en **`17-matriz-rbac-propuesta.md`** (pendiente de aprobación P-05). La agrupación de abajo se conserva como referencia histórica de FASE 1.5; **ante discrepancia, manda `17`** (allí se documenta la diferencia de etiquetas — riesgo R-B10).

**5 grupos × 15 permisos**, 3 niveles (evidencia literal de `ADM-18`):

| Grupo | Permisos observados (forma literal en pantalla) |
|---|---|
| Gobernanza & Auditoría | Gestión de Usuarios, Matriz de Roles, Historial y Logs |
| Patrimonio Territorial | Parajes & Toponimia, Red de Rutas GPX, Biblioteca Multimedia |
| Publicación | Curaduría de Lugares, **Publicación de Reseñas** (modo manual), Patrocinios |
| Moderación | Aprobar/Rechazar, Capacidad de Editar Usuario |
| Seguridad | Gestión de Claves API, Alertas de Aforo |

Reglas derivadas:
- `EXPLORADOR` no publica nada: crea reseñas/itinerarios que pasan por cola (`G10M`).
- `MODERADOR_COMUNITARIO` aprueba/rechaza pero **no** edita usuarios ni toca permisos.
- `EDITOR_TOPOGRAFO` gestiona lugares/rutas/multimedia.
- `SUPER_ADMIN` gestiona usuarios, roles, claves y auditoría.
- **[ABI]** ¿puede un Moderador moderar contenido que él creó? ¿herencia efectiva instantánea ("efecto instantáneo", `ADM-18`)?

---

## 4. Requisitos de moderación (derivados)

1. Todo contenido de usuario entra por cola con estado `PENDIENTE` antes de publicarse (`G10M`, `07&08`).
2. Rechazo siempre **motivado** con código de guía ética (`ADM-15 #R1`).
3. Publicación **inmediata al aprobar** (aviso explícito en `09&10`).
4. Trazabilidad: autor, fiabilidad, notas internas solo staff, registro con hash.
5. Revisión de **fotos y reportes** además de reseñas (`ADM-13`, `ADM-16`).
6. Detección automática de "coordenadas sensibles" (`ADM-13`) → **[ABI]** qué coordenadas se ocultan (¿nidos, sitios rituales? `H04M` "salvaguarda cultural").
7. SLA declarado (inconsistente, A12).

---

## 5. Riesgos de seguridad identificados

| # | Riesgo | Evidencia | Mitigación propuesta `[REC]` |
|---|---|---|---|
| R1 | Enumeración de usuarios vía OTP | `B07M` promete no revelar afiliación | Respuesta idéntica exista o no la cuenta; rate limit por IP/cuenta |
| R2 | **Fuga de email en contenido público** | `ADM-14` muestra email del autor | No exponer email en fichas de moderación ni en reseñas públicas |
| R3 | RBAC client-side | diseño de permisos en UI | Verificación **siempre** en servidor; la UI no es control de acceso |
| R4 | Subida de archivos (GPX/media) | `ADM-08`, `ADM-06` | Validar extensión+contenido, límite de tamaño, parser aislado, antivirus, sin ejecución de XML externo (XXE en GPX) |
| R5 | Geodatos sensibles | `ADM-13` "coordenadas sensibles", `H04M` | Máscara de precisión configurable; políticas de minimización (`H06M`) |
| R6 | EXIF de ubicación en fotos | `07&08`, `ADM-16` | Opción de purga EXIF antes de publicar |
| R7 | Cola offline con reenvío | `G05M`, `11M` | Idempotencia por `clientId`, firmas y caducidad de sesión |
| R8 | Auditoría con hash | `ADM-18` | Cadena de hashes o log inmutable; no autogestión de permisos |
| R9 | Reglas "AI" de moderación | `ADM-13` | `[ABI]` transparencia y recurso de la decisión |
| R10 | Contenido de terceros/derechos | `ADM-14` "sin derechos de terceros" | Aceptación de licencia al subir; revisión humana |
| R11 | Telemetría y consentimiento | `H06M` | Nada sin consentimiento granular; borrado local efectivo |
| R12 | Claves de servicios en cliente | `ADM-18` "Gestión de Claves API" | Nunca exponer claves de tiles/OTP en el cliente; proxy propio |
| R13 *(FASE 1.7, ajuste C-2)* | **Abuso del nuevo `POST /reports`** (spam de reportes, brigading) | `ADM-13` pestaña Reportes | Autenticación obligatoria, rate limit por usuario/objetivo, motivo con código (`reasonCode`), posibilidad de sancionar reportes maliciosos (en el marco de moderación, no automática) |

---

## 6. API provisional (agrupada por dominio)

> **Formato propuesto (a confirmar):** JSON/REST sobre HTTPS con `Authorization: Bearer`, paginación por cursor, errores `{code, message, requestId}`. **No se ha elegido framework ni se ha escrito código.**

### 6.1 Públicos (invitado permitido)
| Método y ruta | Uso | Pantalla |
|---|---|---|
| `GET /places?bbox=&category=&q=` | Listado/mapa/búsqueda | `01`, `C01`, `C05M` |
| `GET /places/{id}` | Ficha | `D01`, `D02M` |
| `GET /places/{id}/reviews?cursor=` | Reseñas | `G01M` |
| `GET /routes`, `GET /routes/{id}` | Catálogo/detalle | `E01`, `E03` |
| `POST /auth/register` · `POST /auth/login` · `POST /auth/otp/request` · `POST /auth/otp/verify` · `POST /auth/password/forgot` | Auth | `B04M`, `B01M`, `B07M` |
| `GET /meta/languages` · `GET /meta/toponyms` | Idioma/toponimia | `H02M` |
| `POST /claims` | Libro de reclamaciones | `H08M` |

### 6.2 Autenticados (Explorador)
`GET/DELETE /me/favorites{,/placeId}` · `POST /itineraries` (CRUD; antes `/itinerarios` — unificado a inglés por **C-3**, nombre histórico conservado aquí) · `POST /reviews` (con `Idempotency-Key`) · `POST /media/uploads` (URL firmada) · `GET/PATCH /me/consents` · `POST /me/privacy-requests` · `GET/PATCH /me/notification-preferences` (**C-1**) · `POST /reports` (**C-2**; autenticado + rate limit R13) · `GET /me/queue` (cola offline del cliente) · `POST /sync/batch` (aplicación atómica de la cola) · `GET /packages/{id}` (descarga con URL firmada).

### 6.3 Staff
`GET /admin/places|routes|media|users` · `POST/PATCH /admin/places|routes` · `POST /admin/routes/{id}/import` (GPX/GeoJSON) · `PATCH /admin/routes/{id}/waypoints` · `GET /admin/moderation?type=` · `POST /admin/moderation/{id}/approve|request-changes|reject` · `PATCH /admin/users/{id}` · `GET/PUT /admin/roles` · `GET /admin/metrics` *(**C-4**: la entidad que produce las métricas sigue sin modelar → pendiente P-15)* · `GET /admin/audit` · `GET/POST /admin/sponsorships`. El mapeo propuesto de cada endpoint a roles está en `17-matriz-rbac-propuesta.md` §3 (pendiente P-05).

### 6.4 Contratos transversales
- **Offline:** `POST /sync/batch {clientId, ops[]}` → resultado por operación con estados `applied|conflict|rejected`; servidor **idempotente** por `clientId`.
- **Subida:** `POST /media/uploads` → `uploadUrl` firmada + `assetId`; `POST /media/{id}/commit` con `moderationStatus=PENDING`.
- **Moderación:** transiciones de estado validadas en servidor (máquina de estados `PENDIENTE → APROBADO|RECHAZADO|SOLICITAR_EDICION`), con `actorId` y `reasonCode` obligatorios.
- **Errores:** `401` sesión, `403` permiso (RBAC), `409` conflicto/offline, `413` subida, `422` validación con lista de campos, `429` rate limit (OTP, búsqueda).
- **Versionado:** `/v1/...`; cambios de contrato mínimamente versionados.

---

## 7. Preguntas del modelo — estado tras FASE 1.7 (P-06)

| # | Pregunta | Estado (2026-10-10) | Dónde |
|---|---|---|---|
| 1 | **REQ-DATA-01**: ¿este modelo como base o se revisa? | **RESPONDIDA**: aprobado como **base provisional** (P-06), con C-1…C-5 aplicados (C-4 anotado, fuente de métricas → P-15) | `11` §5.1 |
| 2 | ¿Motor y esquema de almacenamiento `[I]`? | **Dirección** (P-01: PostgreSQL+PostGIS); proveedor/entorno **pendiente** | P-03, `15` §3 |
| 3 | ¿OTP por correo o SMS (A3)? | **CERRADA** (D-06: correo; SMS ampliación). Contrato OTP: **pendiente** | `16`, P-04 |
| 4 | ¿Se implementa gamificación (A16)? | **CERRADA** (D-10: fuera del MVP) | `11` §7 |
| 5 | ¿Alcance real de balizas/geofencing (A14)? | **CERRADA** (D-07: sólo primer plano) | `11` §7 |
| 6 | ¿Retención y anonimización (reseñas/reportes/telemetría)? | **PROPUESTA entregada sin plazos** | `18`, **P-07** |
| 7 | ¿Email del autor visible en moderación (R2)? | **CERRADA** (D-12: no visible; acceso excepcional justificado/restringido/auditado en FASE 2) | `11` §7 |
