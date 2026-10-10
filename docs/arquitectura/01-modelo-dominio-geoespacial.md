# LUMINA — Modelo de dominio turístico y arquitectura geoespacial (diseño v1.0)

> **Fase: análisis y documentación (2026-10-10). Sin migraciones, sin código, sin consultas de negocio.**
> Fuente de verdad: `docs/analisis/08-modelo-dominio-api.md` (base provisional P-06), requisitos `07`,
> MVP `13`, RBAC `17`, OTP `16`, decisiones `11`, Plan Maestro. Todo lo no evidenciado se marca **[PROPUESTA]**
> (necesita aprobación) o **pendiente**. P-02 (teselas) y P-17…P-20 (legal) siguen pendientes.

## 0. Decisiones de este documento

| # | Decisión | Estado |
|---|---|---|
| DD-01 | Consolidar entidades: `route_stops` única (paradas = puntos con `place_id` opcional) en vez de waypoints + stops + beacons separados | **[PROPUESTA]** |
| DD-02 | `media_assets` polimórfica única (lugar/ruta/reseña) con una sola tubería de moderación | **[PROPUESTA]** |
| DD-03 | `moderation_items` polimórfica única (reseña/foto/reporte) | **[PROPUESTA]** (derivado de ADM-13) |
| DD-04 | `sponsorships` polimórfica (ruta/lugar), sin facturación (sin dependencia de pagos) | **[PROPUESTA]** |
| DD-05 | i18n por tablas `*_translations` (es/en) con slug único por idioma; sin traducir reseñas de usuarios | **[PROPUESTA]** |
| DD-06 | `places.geom geography(Point,4326)`; `routes.geom geometry(LineString,4326)` + columna generada `geog` | **[PROPUESTA]** |
| DD-07 | Contadores desnormalizados en `places` (`avg_rating`, `review_count`) actualizados en la transición de moderación | **[PROPUESTA]** |
| DD-08 | `Claim` (Libro) **excluido** del diseño hasta P-18; métricas con fuente sin modelar (C-4→P-15); `SyncQueue` solo cliente | **Adoptada** (alcance) |
| DD-09 | Sin gamificación (D-10), sin geofencing 2.º plano (D-07), sin SMS (D-06), sin IA de moderación (D-13) | **Adoptada** (viene de D-*) |

## 1. Diagrama entidad–relación (Mermaid)

```mermaid
erDiagram
    users ||--o{ favorites : tiene
    users ||--o{ itineraries : posee
    users ||--o{ reviews : escribe
    users ||--o{ media_assets : sube
    users ||--o{ reports : reporta
    users ||--o{ consents : otorga
    users ||--o{ privacy_requests : solicita
    users ||--o{ notification_preferences : configura
    users ||--o{ audit_logs : protagoniza
    users ||--o{ sponsorships : "gestiona (staff)" %% vía políticas, sin FK
    categories ||--o{ categories : "padre › hijas"
    categories ||--o{ places : clasifica
    categories ||--o{ category_translations : traduce
    places ||--o{ place_translations : traduce
    places ||--o{ favorites : recibe
    places ||--o{ itinerary_stops : integra
    places ||--o{ reviews : recibe
    places ||--o{ route_stops : "es parada de"
    routes ||--o{ route_translations : traduce
    routes ||--o{ route_stops : compone
    itineraries ||--o{ itinerary_stops : compone
    reviews ||--o{ moderation_items : "genera (REPORT target)"
    media_assets ||--o{ moderation_items : "genera (REPORT target)"
    reports ||--o{ moderation_items : "genera (REPORT)"
    users ||--o{ moderation_items : "resuelve (assigned/resolved)"
```

## 2. Tabla de entidades y campos

Convenciones: `id bigserial PK` salvo indicado; `timestamps created_at/updated_at`; dinero en céntimos (`integer`);
texto usuario en `*_translations` (es/en) o campos directos cuando no se traduce (reseñas: idioma original).

### 2.1 `users` — EXISTE, sin cambios
`id, name, email UNIQUE, email_verified_at NULL⇔pendiente, password, remember_token`. Roles/staff futuros
(RS) sin columnas nuevas en esta fase.

### 2.2 `categories` **[PROPUESTA]** — unifica las dos taxonomías (01 vs C01, sin alinear)
| Campo | Tipo | Restricción |
|---|---|---|
| `id` | bigserial PK | |
| `parent_id` | FK → `categories` NULL | árbol (raíz = NULL) |
| `slug` | text | UNIQUE, canónico interno |
| `sort` | int | default 0 |
| `active` | bool | default true |

`category_translations`: `(category_id FK cascade, locale es/en)` PK compuesta; `name`, `description NULL`,
`slug` **UNIQUE por locale** (URLs SEO). Justifica tabla propia: jerarquía + es/en + slugs estables.

### 2.3 `places` (núcleo) **[PROPUESTA]**
| Campo | Tipo | Oblig. | Notas |
|---|---|---|---|
| `category_id` | FK → `categories` | sí | clasifica (MVP M1) |
| `status` | enum `draft/published/archived` | sí | `archived` = baja/salvaguarda, nunca borrado físico |
| `geom` | `geography(Point,4326)` | sí | §3 |
| `altitude_m` | int NULL | no | |
| `difficulty` | enum NULL | no | escala por definir (P-08) |
| `duration_min` | int NULL | no | |
| `elevation_gain_m` | int NULL | no | |
| `access_status` | enum `free/restricted` NULL | no | D01 |
| `schedule` | jsonb NULL | no | estructura validada en Form Request |
| `price_min_cents/price_max_cents` | int NULL | no | |
| `payment_methods` | jsonb NULL | no | lista cerrada (Yape/Plin/…) |
| `sponsorship_id` | FK NULL | no | badge PATROCINADO/PROMOVIDO |
| `featured` | bool | sí | default false (ADM-11) |
| `wgs84_verified` | bool | sí | default false (ADM-02) |
| `verified_at/verified_by` | timestamp/FK users NULL | no | curaduría D01 |
| `topographic_sheet` | text NULL | no | ej. 23-M |
| `avg_rating` | numeric(2,1) | sí | default 0, solo vía moderación (DD-07) |
| `review_count` | int | sí | default 0, solo vía moderación (DD-07) |

`place_translations`: `(place_id FK cascade, locale)` PK; `name`, `description` (oblig.), `slug` UNIQUE por
locale, `practical_info NULL`, `meta_title/meta_description NULL` (override SEO, fallback a nombre/descripción).

### 2.4 `routes` + `route_stops` **[PROPUESTA]**
`routes`: `status draft/published/archived`, `visibility`, `geom geometry(LineString,4326)` NOT NULL,
`geog geography(LineString,4326) GENERATED ALWAYS AS (geom::geography) STORED`, `sponsorship_id NULL`,
métricas cacheadas (`distance_m`, `elevation_gain_m`, `max_elevation_m`, `duration_min`, `stops_count`) —
**calculadas en servidor al importar/reordenar, nunca en cliente**; `source_file` (ruta del GPX/GeoJSON
almacenado, no el contenido), `offline_package_size`, `safeguards` (texto, primer plano).
`route_translations`: como lugares (title/description/slug/meta).
`route_stops` (DD-01, una sola lista reordenable ADM-09): `route_id FK cascade`, `position int`,
`place_id FK NULL` (parada curada) **o** punto libre (`geom geography(Point,4326)` + `name`), `kind`
(photo/park/flag/viewpoint), `radius_m` (default 40, primer plano), UNIQUE `(route_id, position)`,
CHECK (`place_id` NOT NULL OR `geom` NOT NULL). Reordenar = renumerar `position` en transacción
(sin huecos ni decimales).

### 2.5 `itineraries` + `itinerary_stops`, `favorites` **[PROPUESTA]**
`itineraries`: `owner_id FK users cascade`, `title`, `description NULL`, `status draft/in_progress/completed`,
métricas cacheadas calculadas en servidor. `itinerary_stops`: `itinerary_id FK cascade`, `place_id FK`,
`day smallint`, `position`, `planned_time NULL`, `note NULL`; UNIQUE `(itinerary_id, day, position)`.
`favorites`: PK compuesta `(user_id, place_id)` + `created_at` (sin `id` subrogado: la pareja ES la identidad).

### 2.6 `reviews` (1 por usuario y lugar) **[PROPUESTA]**
`place_id FK`, `author_id FK`, `rating smallint 1–5`, `body varchar(600)`, `status`
`pending/approved/rejected/changes_requested`, `rejection_code NULL` (obligatorio si `rejected`, #R1),
`moderator_id NULL`, `moderated_at NULL`, `internal_notes NULL` (staff), `geo_verified bool default false`.
UNIQUE `(place_id, author_id)` (edición permitida, duplicado no). Fotos: `media_assets` (máx. 3 en validación).
`pointsAwarded` excluido (D-10).

### 2.7 `media_assets` (DD-02) **[PROPUESTA]**
`owner_id FK`, target polimórfico (`target_type place/route/review`, `target_id`) + índice compuesto,
`kind photo/video`, `path` (disco local; sin proveedor externo obligatorio), `width/height/size_bytes NULL`,
`duration_s NULL` (**vídeo 15–25 s validado en servidor**), `status` de moderación, `exif_purged bool default
false` (R6), `license_accepted_at` (R10), `tags jsonb NULL` (ADM-06).

### 2.8 `moderation_items` (DD-03) + `reports` **[PROPUESTA]**
`moderation_items`: `type review/photo/report`, target polimórfico + índice, `status pending/in_review/
approved/rejected/changes_requested`, `priority`, `assigned_to FK users NULL`, `resolved_by/at NULL`,
`resolution_note NULL`. Transiciones solo en servidor (máquina de estados `08` §6.4).
`reports`: `reporter_id FK`, target polimórfico (review/photo/place), `reason_code` (lista cerrada),
`note NULL`, `status`; UNIQUE `(reporter_id, target_type, target_id)` anti-brigading + rate limit (R13).

### 2.9 `sponsorships` (DD-04), `consents`, `privacy_requests`, `audit_logs`, `notification_preferences` **[PROPUESTA]**
`sponsorships`: target polimórfico (route/place) + índice, `brand_name`, `badge_type`,
`status`, `starts_at/ends_at NULL`; **sin importes** (sin pagos). `consents`: UNIQUE `(user_id, type)`,
`granted`, historial vía `audit_logs`. `privacy_requests`: `user_id FK`, `kind`, `status`, `due_at NULL`
(plazos = P-17, sin valores inventados), `channel`, `resolved_at NULL`. `Claim` excluido (P-18).
`audit_logs`: `actor_id FK NULL` (sistema), `action`, entidad polimórfica, `payload jsonb NULL` (sin PII
innecesaria, D-12), `hash` (cadena, R8); **sin update/delete** (append-only por política).
`notification_preferences`: UNIQUE `(user_id, channel, type)`, `enabled`, `quiet_hours NULL`; solo primer
plano (D-07).

## 3. Modelo geoespacial PostGIS (conceptual, sin ejecutar)

### 3.1 Qué lleva geometría y qué no
- **Geometría**: `places.geom` (punto), `routes.geom/geog` (track), `route_stops.geom` (puntos libres).
- **Solo referencia**: itinerarios/favoritos/reseñas usan FK a lugares (heredan posición por JOIN, sin duplicar
  coordenadas — nada de `lat/lon` sueltos salvo el punto libre de `route_stops`).
- **`geography` vs `geometry`**: `geography` para distancias reales en metros (lugares, radios, corredor);
  `geometry` para el track (operaciones planares: simplificación Douglas-Peucker al importar, `ST_LineLocatePoint`
  para ordenar por secuencia). SRID siempre **4326**.

### 3.2 Índices (estrategia)
GiST en `places.geom`, `routes.geog`, `route_stops.geom`; B-tree en FK/estados/slugs; compuesto en
`(target_type, target_id)` polimórficos; GIN `pg_trgm` (+ `unaccent`, presentes en el servidor pero
requieren `CREATE EXTENSION` en la migración) para autocompletado de nombres. Métricas de cardinalidad del piloto (≈24 lugares): los índices se justifican por
crecimiento regional, no por el piloto.

### 3.3 Consultas conceptuales (patrones, no ejecutados)

```sql
-- Cercanos a un punto: radio acotado + KNN, solo publicados, paginación por cursor
SELECT p.id, ST_Distance(p.geom, :pto::geography)::int AS metros
FROM places p
WHERE p.status = 'published'
  AND ST_DWithin(p.geom, :pto::geography, LEAST(:radio, 50000))
ORDER BY p.geom <-> :pto::geography, p.id
LIMIT 20;
```

```sql
-- «Lo que hay en este trayecto»: corredor sobre el track + orden por secuencia
WITH corredor AS (
  SELECT ST_Buffer(r.geog, LEAST(:ancho, 2000)) AS area, r.geom AS track
  FROM routes r WHERE r.id = :ruta AND r.status = 'published'
)
SELECT p.id, ST_LineLocatePoint(c.track, p.geom::geometry) AS secuencia
FROM places p, corredor c
WHERE p.status = 'published' AND ST_Intersects(p.geom::geometry, c.area::geometry)
ORDER BY secuencia
LIMIT 50;
```

> Nota técnica: `c.area` es `geography` (devuelve `ST_Buffer` sobre `geog`); se castea a `geometry`
> porque `ST_Intersects` no admite tipos mixtos `geometry/geography`.

Reglas: entrada siempre acotada (punto+radio con tope, o ruta+ancho con tope); **el frontend nunca recibe el
catálogo para filtrar** (recibe página + total aproximado); validación de geometrías al importar
(`ST_IsValid`, track ≥ 2 puntos, longitud > 0, coordenadas en rango); unidades en metros; precisión WGS84
nativa sin reproyecciones.

### 3.4 Eloquent / migraciones / Inertia / MapLibre (cómo se conectará)
- Migraciones futuras: `geography(Point,4326)` vía `DB::statement` (el grammar no tiene tipo nativo) +
  GiST con `CREATE INDEX … USING gist`; todo reversible (`dropIfExists`); **prohibido** tocar
  `users/otp_codes/sessions` y demás infra.
- Eloquent: value object `Point(lat,lon)` + casts de lectura/escritura, scopes `published()`, `nearby()`,
  `inCorridor()`; bindings siempre (nunca interpolación); contadores solo vía eventos de moderación.
- Controladores finos → Acciones (`ImportRouteFromGpx`, `SearchNearby`, `TrayectoPlaces`) → Form Requests
  (bbox/radio/toponimia validados); respuestas Inertia con GeoJSON (`ST_AsGeoJSON`) ya serializado.
- MapLibre **renderiza** lo que entrega el servidor (P-02 pendiente; sin URL ni claves en código).
- SEO/i18n: slugs por idioma, `hreflang`, JSON-LD servido por el backend; SSR **no implementado ni validado**.

## 4. Autorización del modelo (referencia RS-1…RS-9, sin roles nuevos)
Escritura solo verificados; lugares/rutas/medios: staff editor; moderación: asignado ≠ autor (RS-1),
transiciones auditadas (RS-4/5/8); usuarios/roles/auditoría: super-admin; ARCO: procedimiento P-17;
email nunca en vistas públicas ni de moderación (D-12/R2); EXIF purgable (R6); `POST /reports` autenticado
con rate limit (R13). Filament reutiliza las mismas políticas (RS-8); nada se autoriza solo en cliente (R3).

## 5. Criterios de aceptación (para las futuras migraciones)
1. `migrate` crea las 16 tablas + índices GiST/B-tree/GIN y `migrate:rollback` las revierte sin tocar infra.
2. Constraints reales: FK con cascade donde se indica, UNIQUE (slugs por idioma, `place+author` en reseñas,
   pareja en favoritos, `(route,position)`), CHECK (`rating 1–5`, `duration_s 15–25`, estados válidos).
3. Tests Feature: proximidad ordenada por distancia, corredor ordenado por secuencia, estados de publicación
   (borrador invisible en público), moderación con transiciones y contadores, 403/429 donde toca, slugs es/en
   únicos, anti-enumeración intacta.
4. `db:show` sin tablas fuera de las 16 + infra; 0 filas seed en local; `spatial_ref_sys` intacta.
