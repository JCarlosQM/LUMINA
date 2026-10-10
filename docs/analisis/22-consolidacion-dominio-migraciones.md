# LUMINA — Consolidación de decisiones de dominio y plan de migraciones candidatas

> **APR = 0. Solo análisis, documentación y planificación.** Ninguna preferencia queda aprobada.
> Sin migraciones (ni creadas ni ejecutadas), sin BD, sin código, sin dependencias, sin config, sin Git.
> Estados usados: `Adoptada previamente` · `Propuesta preliminar` · `Pendiente de decisión` ·
> `Pendiente de evidencia` · `Aprobada` (solo para decisiones ya adoptadas antes de esta tarea).
> Clasificación de afirmaciones: **[DOC]** documentado con fuente · **[INF]** inferencia técnica ·
> **[PEN]** pendiente de confirmar. Las 10 preferencias de esta tarea figuran como `Propuesta preliminar`.

## 0. Resumen ejecutivo

- **Bloqueantes antes de cualquier migración de negocio**: arquitectura de proximidad (H-01, privacidad/ubicación);
  destino de `08` §6 REST vs Inertia (H-02); `users.status` + almacenamiento de roles (H-03/P-05); idiomas y
  topónimo (H-04/DD-05, P-14); taxonomía de categorías (P-CAT, ID propuesto pendiente de registro).
- **Propuestas recomendadas técnicamente** (pendientes de tu sí): híbrido de proximidad sin persistir ubicación;
  Inertia vigente + REST futura no aprobada; matriz RBAC antes que tablas; reseñas múltiples con reglas anti-abuso;
  manifiesto offline mínimo; FK explícitas + CHECK un-propietario en medios; lista única de paradas con semántica;
  cola común + estado por reporte; es+en con topónimo original (quechua abierto); contadores en lectura en piloto.
- **Riesgos principales**: aprobar polimórficas sin integridad referencial real; contadores persistidos sin
  transacciones; `migrate:rollback` entendido como reversión segura (no lo es con datos); asumir portabilidad MySQL;
  publicar plazos ARCO/Libro sin dictamen; elegir proveedor de teselas tarde (P-02 bloquea offline).
- **Acciones que requieren tu aprobación**: las 10 preguntas §2 + taxonomía, roles, notificaciones, límites de medios,
  patrocinios (P-15), retención (P-07), ARCO/Libro (P-17/P-18), dificultad, propiedad de lugares.
- **Advertencia explícita**: este documento **no autoriza la ejecución de ninguna fase** (F0–F5 ni subdivisiones).
  Solo podrán plantearse cuando se resuelvan sus bloqueos y exista aprobación expresa y previa del responsable.

## 1. Matriz de decisiones para revisión

### 1.1 Preferencias preliminares (10) — todas `Propuesta preliminar` / `Pendiente de aprobación`

**H-01 — Proximidad híbrida (cliente obtiene y autoriza; servidor consulta acotado; sin persistir ubicación).**
Relacionado: RF-01/RF-02/RF-04/RF-22, D-07, PDF §5.3/§10.9, `18` fila 9. Estado actual: contradicción
servidor (`01`) vs cliente (PDF) — `21` C-04. Evidencia **[DOC]**: PDF §10.9 (no almacenar por defecto);
`07` RF-04 modo seguir; `11` D-07. Alternativas: (a) todo cliente (descarga acotada + cálculo local);
(b) todo servidor con posición persistida; (c) híbrida propuesta. Ventajas (c): metros reales PostGIS,
mínima transferencia, sin rastro persistente. Desventajas: requiere transmitir posición temporal (TLS,
sin logs, TTL de proceso) y consentimiento explícito por uso. Impacto esquema: ninguno (sin columna de
ubicación). Privacidad/seg/op: posición en memoria, nunca en `payload` de logs ni auditoría; rate-limit por
cuenta+IP. Transporte y minimización (política pendiente, R-01/R-02, no implementada): posición solo
en cuerpo POST (nunca en parámetros de URL), revisión de access logs/proxy/app/errores/analítica,
precisión mínima necesaria por caso. Dependencias: P-14 no; P-02 (offline acota descargas). Riesgo prematuro: fijar (b) violaría
minimización. Recomendación **[INF]**: (c). **Pregunta**: ¿apruebas híbrida con posición efímera solo para
la consulta y consentimiento por uso?

**H-02 — `08` §6 e Inertia.** Relacionado: P-01, `08` §6.1–§6.4, código (`routes/web.php` solo Inertia, sin
`routes/api.php`). Estado actual: `08` §6 describe REST `/v1`+OpenAPI de la era Opción B. Evidencia **[DOC]**:
P-01 adoptada (Laravel+Inertia); código verificado. Alternativas: (a) anotar §6 como histórico Opción B y
referenciar rutas Inertia vigentes; (b) reescribir §6 como contratos Inertia; (c) mantener REST como objetivo.
Ventajas (a): trazabilidad sin reescritura, cero coste. Desventajas: `08` sigue sin contrato consumible.
Impacto: documental, no de esquema. Recomendación **[INF]**: (a) ahora + (b) cuando P-08 sea definitivo.
**Pregunta**: ¿anoto `08` §6 como histórico y dejo REST/OpenAPI como posibilidad futura no aprobada?

**H-03 — RBAC antes que tablas.** Relacionado: P-05, `17` matriz 15×4, RS-1…RS-9, ADM-10/18. Estado actual:
principio adoptado (D-09); matriz y reglas pendientes campo a campo. Evidencia **[DOC]**: `17` §2–§4;
R-B3 (TIER 3 íntegro propuesta), R-B5 (YubiKey operativo). Alternativas de almacenamiento (a evaluar tras la
matriz): enum en `users`, tabla `roles` + pivot, paquete externo. Ventajas del orden matriz→tablas: el esquema
sirve a permisos reales (p. ej. `users.status` activo/suspendido que `01` omite). Riesgo prematuro: migrar
roles y reescribirlos al aprobar la matriz. Recomendación **[INF]**: definir matriz completa primero; sin
elegir storage aquí. **Pregunta**: ¿apruebas el orden (matriz campo a campo → diseño de tablas) y completas
la columna TIER 3 + RS-9?

**H-05 — Reseñas múltiples por lugar y autor.** Relacionado: RF-07, `13` M8, `08` §1.7 (sin unicidad
documentada). Estado actual: `01` propone UNIQUE (lugar+autor) **[INF sin respaldo en RF]**.
Escenarios: edición de la propia reseña; visitas repetidas; spam/duplicados; historial para moderación;
métricas (histograma, media). Alternativas: (a) única + edición versionada; (b) múltiples con ventana
anti-spam (p. ej. 1 cada N días) + límite activo; (c) múltiples sin límite + moderación. Ventajas (b):
refleja visitas reales y contiene abuso. Desventajas: reglas de ventana por definir; métricas más complejas.
Impacto esquema: UNIQUE vs índice + `supersedes_id`/ventana. Recomendación **[INF]**: (b) con edición y
ventana por aprobar. **Pregunta**: ¿única+edición o múltiples con ventana? ¿ventana y editable hasta
aprobar?

**H-06 — Manifiesto offline mínimo.** Relacionado: RF-09, M4/M9 (descarga con progreso, verificación, tamaño),
`08` §1.12, `18` fila 10 (efímero). Estado actual: `01` no incluye tabla (hueco H-06 de `21`). Metadatos
candidatos: `kind` (mapa/ruta/itinerario), `target`, `version`, `size_bytes`, `sha256`, `generated_at`,
`valid_until NULL`, estado. Distinguir: manifiesto (servidor) vs archivos (origen de teselas/medios, P-02)
vs almacenamiento del dispositivo (IndexedDB/Cache API). Actualización/invalidación/eliminación por versión;
sin límite de tamaño fijado **[PEN]** (148 MB es valor observado en E01, no aprobado). Alternativas: generación
on-demand firmada sin tabla (pierde verificación e historial). Recomendación **[INF]**: tabla mínima.
**Pregunta**: ¿apruebas el manifiesto mínimo? ¿qué vigencia e invalidación?

**DD-02 — Medios con FK explícitas + CHECK.** Relacionado: RF-17/RF-23, ADM-06/16, R6/R10. Destinos reales
**[DOC]**: lugar, ruta, reseña (`08` §1.8; RF-07 ≤3 fotos). `place_id/route_id/review_id` anulables + CHECK
exactamente-uno es viable en PostgreSQL y da cascadas e índices reales. Ventajas: integridad referencial,
borrados predecibles, auditoría por JOIN. Desventajas: añadir un destino exige DDL (frente al morfo libre);
3 índices parciales. Si el dominio necesitara más destinos (p. ej. avatar de usuario — **[PEN]**, sin RF:
REQ-UX-01 perfil SIN diseño), cada uno suma FK + rama del CHECK. Recomendación **[INF]**: FK explícitas.
**Pregunta**: ¿apruebas FK explícitas + CHECK? ¿algún destino más (avatar/perfil)?

**DD-01 — Lista única de paradas con semántica.** Casos: (i) lugar publicado (vive en `places`; su posición
la define el lugar); (ii) punto geográfico libre (solo existe en la ruta; `geom` propio + `name`); (iii)
parada curada = (i) o (ii) + `position` + `radius_m` + `kind` dentro de una ruta. Reglas candidatas: CHECK
`place_id XOR geom`; UNIQUE `(route_id, position)`; reorden = renumeración transaccional; radio default 40 m
(H05M) solo primer plano (D-07); `trigger` de `08` (proximity/derivation/sunset) se reduce a radio + tipos de
notificación (derivation excluida D-07; sunset es aviso horario). Duplicados: mismo lugar dos veces en una
ruta → permitir con `position` distinta **[PEN]** (pregunta). Recomendación **[INF]**: una tabla con esta
semántica. **Pregunta**: ¿apruebas semántica (i/ii/iii) + CHECK + renumeración? ¿lugar repetido permitido?

**DD-03 — Cola común + estado por reporte.** Estados candidatos del ítem: `pending/in_review/approved/
rejected/changes_requested`; del reporte: `open/under_review/accepted/dismissed/closed`. Transiciones solo
servidor; `assigned_to ≠ autor` (RS-1); cierre con `resolved_by/at` + motivo; duplicados: mismo
(reporter,target) UNIQUE + reportes posteriores de otros usuarios "suscriben" el ítem abierto **[PEN]**.
Trazabilidad: auditoría por transición. Recomendación **[INF]**: cola común + doble estado. **Pregunta**:
¿apruebas estados y la regla de suscripción de duplicados?

**H-04/DD-05 — es+en con topónimo original (quechua pendiente).** Relacionado: REQ-MULTI-01 (PDF es+en),
P-14 (es-PE+quechua+topónimos), H02M, `08` `toponymOriginal`. Representación candidata: `*_translations`
(es/en) + `toponym_original` (texto, idioma de origen) + `toponym_lang` (p. ej. `qu`) + `alt_names jsonb NULL`
topónimos validados por comunidad (P-22). **No excluye el quechua**: queda **[PEN]** si `qu` es locale pleno
o solo topónimo. Recomendación **[INF]**: este modelo, con P-14 abierta. **Pregunta**: ¿es+en + topónimo
conservado? ¿quechua como locale o solo topónimos?

**DD-07 — Contadores en lectura durante el piloto.** Coste **[INF]**: con ~24 lugares y reseñas moderadas,
`COUNT/AVG` con índice B-tree `(place_id, status)` es trivial. La elección entre B-tree, GIN y GiST
depende de cada consulta y necesidad real (agregados, texto, espacial) y debe justificarse con `EXPLAIN`;
ningún índice cubre todos los casos. Consistencia: lectura
siempre exacta; desnormalizar introduce deriva (requiere transacciones + tests). Umbral futuro: p95 de ficha
o volumen regional; entonces vista materializada antes que columnas. Recomendación **[INF]**: lectura +
índice; sin columnas ni triggers. **Pregunta**: ¿apruebas lectura en piloto y reevaluar con métricas?

### 1.2 Decisiones previas relevantes (conservar distinción)
`Adoptada previamente`: P-01 (stack) · P-03 motor (PostGIS; proveedor pendiente) · P-04 flujo OTP (SMTP real
pendiente) · P-05 Filament 5 (matriz pendiente) · D-06/D-07/D-08/D-10/D-12/D-13(método; criterios P-21)/D-16/D-17/D-18 ·
D-05/D-09/D-11(base provisional P-06)/D-15. `Pendiente de decisión`: P-02, P-07, P-08, P-09…P-24, P-CAT (ID propuesto, pendiente de registro formal:
¿quién define la lista canónica 01 vs C01?).

### 1.3 No cubiertas por las 10 que bloquean/condicionan migraciones
Tipos de notificación (cerrar lista H05M menos fondo imposible) · límites de medios (250 MB es texto
observado en diseño, no regla aprobada; proponer por kind) · patrocinios P-15 (badges manuales sí; reglas no) · consentimiento/retención P-07 · ARCO P-17/Libro
P-18 (no publicar plazos/formulario) · escala de dificultad (sin definir en ningún documento) · propiedad de
lugares (sin evidencia: ¿reclamo de ficha por negocios?) · fuente de métricas (no inventar) · SSR residual P-01 ·
IONOS · consent-log append-only (considerar para prueba de opt-in) · política `ON DELETE` por relación (§6) ·
índices concurrentes y backfills (§7) · purga OTP/sesiones, versiones objetivo y verificación de destino (§7) ·
convenciones T-02 (§8).

## 2. Plan de migraciones candidatas (ninguna lista para ejecutar)

**F0 — Infraestructura y autorización. `Bloqueada por aprobación`.** Alcance: extensiones (`pg_trgm`,
`unaccent`: decidir necesidad) · `users.status` + almacenamiento de roles/permisos (tras H-03). Depende de:
H-03/P-05, decisión de extensiones. Precondiciones: backup `pg_dump` + réplica de ensayo; `migrate:status`;
espacio; ventana. Integridad: FK/auth alineadas a matriz; GiST solo si hay columnas espaciales (aquí no).
Riesgos: reescribir roles tras aprobar matriz; extensión sin rollback `DROP EXTENSION` documentado. Pruebas:
unitarias (estados), integración (login/403 por rol), DB (constraints). Aceptación: matriz→tablas trazables;
tests 403/429; `spatial_ref_sys` intacta. Reversión: `down()` revierte esquema; **los datos no se recuperan**;
en producción, expansión/contracción, nunca `rollback` ciego.

**F1 — Taxonomías, lugares y cuenta** (nombre original conservado como agrupación; subdivisión
propuesta, no aprobada). **Subdivisiones, `Bloqueadas por aprobación`.**

**F1a — Cuenta y gobierno.** Alcance: `consents`, `privacy_requests`, `notification_preferences`, `audit_logs`.
Depende de: F0; tipos de notificación, P-07 estructura. Integridad: FK a `users` (política `ON DELETE`
pendiente, §6), UNIQUE en parejas, auditoría sin UPDATE/DELETE. Aceptación: consentimiento registrable,
solicitud ARCO registrable sin plazos publicados, preferencias persistidas, auditoría append-only.
Reversión: esquema sí; **los datos no se recuperan**.

**F1b — Taxonomías, lugares y favoritos.** Alcance: `categories(+translations)`, `places(+translations)`,
`favorites`. Depende de: F0; P-CAT, H-04/DD-05, DD-07. Integridad: FK (política `ON DELETE` §6), UNIQUE
(slugs por idioma, parejas), CHECK de estados, GiST en `places.geom`, B-tree/GIN según consulta.
Riesgos: taxonomía redefinida; traducciones refechas por P-14. Pruebas: unitarias (estados/slugs),
integración (publicado vs borrador invisible), DB (GiST usado vía `EXPLAIN` con fixture de ensayo),
privacidad (sin PII en logs), geo (puntos límite del ámbito Perú, geometría nula rechazada). Aceptación:
CRUD curaduría, ficha pública, `EXPLAIN` con índice, slugs únicos por idioma. Reversión: esquema sí;
**pérdida de catálogo si hay datos**.

**F2 — Rutas y paradas. `Bloqueada por aprobación`.** Alcance: `routes(+translations)`, `route_stops`. Depende
de: F0, F1b; DD-01, DD-06. Integridad: `geometry(LineString,4326)` + `geog` generada, CHECK track válido (≥2
puntos, `ST_IsValid`, longitud>0), UNIQUE `(route,position)`, CHECK XOR lugar/punto, GiST. Riesgos: GPX
inválidos/CRS (validar, XXE off, topes **[PEN]**); métricas de ruta cacheadas al importar inconsistentes
(distinto de los contadores de reseñas calculados en lectura, DD-07). Pruebas: parser
(unitarias con fixtures), integración (import→publicar), geo (corredor, secuencia, radio). Aceptación:
importación validada, reorden transaccional, corredor ordenado por secuencia. Reversión: esquema sí
(como F1b); **los datos no se recuperan**.

**F3 — Reseñas, moderación, reportes. `Bloqueada por aprobación`.** Alcance: `reviews`, `moderation_items`,
`reports`. Depende de: F0, F1a (auditoría), F1b (lugares); H-05, DD-03. Integridad: UNIQUE o ventana (según H-05), FK, máquina de estados
en servidor + RS-1, UNIQUE anti-brigading. Riesgos: abuso/spam; SLA no prometido (D-08). Pruebas: estados y
transiciones, 403/429, idempotencia offline. Aceptación: cola→dictamen→publicación trazada; contadores (si
lectura) exactos. Reversión: **borrar moderación destruye defensa de decisiones** (conservar export).

**F4 — Medios** (una sola tabla; habilitación por destinos según dependencias reales).
**`Bloqueada por aprobación`.** Alcance: `media_assets`. Depende de: F1b + F2 (destinos lugar/ruta),
F3 (destino reseña); DD-02, límites. Subdivisión propuesta, no aprobada — dos alternativas:
(a) **F4a/F4b por expansión**: F4a crea la tabla con `place_id/route_id` + CHECK de transición documentado;
F4b añade `review_id` y sustituye el CHECK por el definitivo (requiere revalidar integridad);
(b) **F4 única**, bloqueada hasta resolver F3. Sin elegir alternativa por inferencia. Integridad:
FK anulables + CHECK exactamente-uno (definitivo), CHECK vídeo 15–25 s, EXIF flag, licencia. Riesgos: peso
(250 MB es texto observado en diseño, no aprobado; definir por kind), purga de copias al borrar. Pruebas:
validación por kind, moderación, borrado en cascada de derivados. Aceptación: subida→moderación→publicación;
derivados purgados al eliminar. Reversión: esquema sí; **archivos requieren purga aparte** (no la hace
`rollback`).

**F5 — Itinerarios, offline, patrocinios** (nombre original conservado; subdivisión propuesta,
no aprobada). **Subdivisiones, `Bloqueadas por aprobación`.**
**F5a — Itinerarios.** Alcance: `itineraries(+stops)`. Depende de: F1b; reglas de itinerario **[PEN]**.
Integridad: FK, UNIQUE en paradas. Aceptación: itinerario con paradas ordenadas y métricas.
**F5b — Manifiesto offline.** Alcance: `offline_packages`. Depende de: F2, F5a; H-06. Integridad:
manifiesto versionado + hash. Aceptación: descarga verificable por hash.
**F5c — Patrocinios.** Alcance: `sponsorships`. Depende de: F1b, F2; P-15 (solo badges manuales).
Aceptación: badges gestionados desde administración. Riesgos comunes: P-02 condiciona los archivos offline;
reglas de patrocinio sin definir (solo badges manuales). Pruebas: offline verificado por hash, badges desde
gestión. Reversión: esquema sí; **los datos no se recuperan**.

**Dependencias (grafo, subdivisiones propuestas, no aprobadas)**: F0 → F1a; F0 → F1b → F2 → F4a;
F1a → F3 (+F1b) → F4b (o F4 única hasta F3); F1b → F5a → F5b; F1b + F2 → F5c. Ninguna fase ejecutable
sin sus decisiones; F0 primera solo tras backup y aprobación expresa.

## 3. Revisión geoespacial específica (PostgreSQL/PostGIS, SRID 4326)
Tipos: puntos en `geography` (lugares, stops libres), tracks en `geometry` + `geog` generada; áreas solo
derivadas (corredor efímero, no persistido **[INF]**). GiST en toda columna espacial; B-tree/GIN
complementarios. Funciones por requisito: `ST_DWithin`+`<->` (RF-22 proximidad), `ST_Buffer`+`ST_Intersects`+
`ST_LineLocatePoint` (trayecto), `ST_IsValid`/longitud/rango (importación RF-14), `ST_AsGeoJSON` (salida
Inertia). Restricciones compatibles (CHECK escalares; FK solo sobre `id`, nunca sobre geometrías).
`pg_trgm`/`unaccent`: necesidad real **[INF]** para RF-02/H02M (autocompletado, sinónimos quechua) pero
requieren decisión de extensión. Portabilidad MySQL: **no asumir** (sin KNN indexado, sin `geography`, sin
`ST_LineLocatePoint` equivalente; `20` §7.2). Casos de prueba: radio 0/negativo/sobre-tope, punto inválido o
fuera de rango, lugar sin geometría (rechazo NOT NULL), track inválido/1 punto/longitud 0, empate de distancia
(desempate `id`), página vacía, orden de paradas tras reorden. Rendimiento: `EXPLAIN (ANALYZE, BUFFERS)` con
datos representativos (el piloto de 24 filas no prueba planes; generar fixture volumétrico solo en entorno de
ensayo, nunca en `lumina`).

## 4. Registro de discrepancias y trazabilidad
| # | Discrepancia | Fuente | Decisión afectada | Documento a actualizar tras aprobación |
|---|---|---|---|---|
| D-01 | Proximidad servidor vs cliente | `01` §3.3/§5 vs PDF §5.3/§12/§10.9 | H-01 | `01` §3.3/§5 + nota en `08` |
| D-02 | `08` §6 REST vs Inertia vigente | `08` §6 vs `routes/web.php`, P-01 | H-02 | `08` §6 (nota histórica) |
| D-03 | Roles/status sin modelar | `01` §2.1 vs ADM-10/`17` | H-03/P-05 | `01` §2.1 + futura migración F0 |
| D-04 | es/en vs quechua/topónimo | `01` §2.x vs P-14/H02M/`08` | H-04/DD-05 | `01` §2.x + traducciones F1 |
| D-05 | UNIQUE reseñas sin respaldo | `01` §2.6 vs `07`/`08` | H-05 | `01` §2.6 + migración F3 |
| D-06 | Manifiesto offline ausente | M4/M9 vs `01` | H-06 | `01` + migración F5 |
| D-07 | v5-1 inexistente | encargo vs `docs/referencia/` | — (aclaratoria) | nombre de referencia |
| D-08 | Taxonomía 01 vs C01 | `07` RF-01 vs `01` §2.2 | P-CAT (ID propuesto, pendiente de registro) | `01` §2.2 + seeds (ensayo/dev) F1b |

## 5. Conteos (sin mezclar categorías)
Preferencias preliminares de esta tarea: **10** (todas `Pendiente de aprobación`). Adoptadas previamente
citadas: **P-01/P-03/P-04/P-05 + D-05…D-18 pertinentes** (conservo su estado; listo sus pendientes residuales).
Pendientes preexistentes tocadas: P-02/P-07/P-08/P-09…P-24, P-CAT (ID propuesto, pendiente de registro).
Fases candidatas: **F0–F5** (con subdivisiones propuestas F1a/F1b, F4a/F4b, F5a/F5b/F5c), todas
`Bloqueada por aprobación`.

## 6. Política de integridad referencial `ON DELETE` (pendiente de decisión, R-03/R-04)

Ninguna opción se impone; cada fila requiere aprobación ligada a P-07/retención y RS-4/RS-5.

| Relación | Opciones candidatas | Consecuencias |
|---|---|---|
| Traducciones → padre; paradas → ruta; favoritos y listados propios | `CASCADE` | El dependiente no sobrevive sin su padre; sin impacto en auditoría |
| `route_stops.place_id`, `reviews.place_id`, `itinerary_stops.place_id` | `RESTRICT` (apoyarse en archivado, no borrado físico) | Protege catálogo e historial; el borrado físico de lugares queda reservado a TIER 1 con respaldo (permiso 3, RS-4) |
| `reviews.author_id`, `media.owner_id`, `reports.reporter_id` | `CASCADE` vs anonimizar vs `RESTRICT` — **pendiente (P-07)** | `CASCADE` pierde defensa de moderación (`18` fila 6) y contradice anonimización (fila 4); anonimizar conserva texto/reportes sin autoría; `RESTRICT` bloquea bajas |
| `moderation_items.assigned_to/resolved_by`, `audit_logs.actor_id` | `SET NULL` (dictamen/auditoría sobreviven) o `RESTRICT` en auditoría | Append-only: el registro nunca se reescribe; gestionar el display del actor dado de baja |
| `consents`, `privacy_requests`, `notification_preferences` | `CASCADE` vs conservar prueba — **pendiente (P-07)** | Conservar prueba de opt-in/ARCO puede exigir retención tras la baja |
| Destinos polimórficos/morfos (`sponsorships`, `reports`, `moderation_items`, manifiesto) | Heredan la decisión DD-02 (FK explícitas vs morfo) | Sin FK real no hay `ON DELETE` aplicable; solo borrado aplicativo auditado |

**Advertencia XOR**: con FK anulables + CHECK exactamente-uno, `SET NULL` sobre la única FK no nula viola
el CHECK salvo que otra rama se ajuste en la misma operación; preferir `RESTRICT` o transición explícita
documentada. Preguntas: ¿política por fila? ¿anonimización de autor con qué display público?

## 7. Operativa pendiente (estrategias, sin implementar; R-05/R-06/R-07/T-01)

- **Índices concurrentes (R-05, recomendación)**: `CREATE INDEX CONCURRENTLY` no corre dentro de la
  transacción DDL de las migraciones (Laravel: `$withinTransaction = false` + `DB::statement`); documentar
  `lock_timeout` por sentencia; justificar cada índice con `EXPLAIN`. Decisión por aprobar.
- **Backfills (R-05, recomendación)**: antes de `NOT NULL`/`UNIQUE` en tablas pobladas, rellenar por lotes
  observables; patrón `ADD CONSTRAINT ... NOT VALID` + `VALIDATE CONSTRAINT`. Decisión por aprobar.
- **Purga OTP/sesiones (R-06, pendiente)**: definir y verificar política de purga programada según
  seguridad/retención (`18` fila 2); sin schedulers ni borrados en esta fase.
- **Versiones objetivo (P1, pendiente)**: base propuesta PG 18.x/PostGIS 3.6.x (observados en local); exigir
  misma familia en ensayo/producción (colaciones ICU incluidas); producción (IONOS) pendiente de confirmación.
- **Destino (P1, precondición)**: antes de cualquier escritura futura, verificar conexión (host/puerto/BD,
  descarte de producción), `migrate:status`, backup y ventana. No ejecutado aquí.
- **Verificaciones en ensayo (R-07/T-01, pendientes de evidencia, no realizadas)**: volatilidad de
  `unaccent()` y de la función de cast para columnas generadas e índices funcionales; creación de prueba de
  `geog` generada + GiST. No se afirma ninguna como ejecutada.

## 8. Convenciones T-02 por decidir (no son requisitos aprobados)

Estados como `varchar+CHECK` (extensible) frente a enum PG nativo; `timestamptz`/UTC (auditoría/legal);
desempates deterministas (`id`); fixtures volumétricos solo en ensayo (nunca en `lumina`); backup explícito
por fase; esquemas validados para `alt_names`/schedule/pagos; GPX (traversal, sniffing de contenido, XXE off,
topes por aprobar); EXIF (¿purgar al subir o al publicar?; original); export ARCO transversal; seeds solo en
ensayo/dev; throttle + caché en lecturas públicas.
