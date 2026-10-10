# LUMINA — Auditoría del modelo de dominio y arquitectura geoespacial (2026-10-10)

> **APR = 0.** Ninguna decisión pendiente queda aprobada. Sin código, migraciones, BD, dependencias,
> config, Git, Stitch ni despliegues. Solo se aplicaron 3 correcciones técnicas inequívocas en `01` (§7).

## 1. Archivos examinados (contenido real, no resúmenes)
`01-modelo-dominio-geoespacial.md` (íntegro) · `08-modelo-dominio-api.md` (íntegro) · PDF v5.0
`docs/referencia/Lumina_Documento_Tecnico_Especificacion_v5.pdf` (**leído íntegro, 9 pp.**) ·
`00-arquitectura-base.md` · Plan Maestro (estado) · `07` (íntegro) · `09` (íntegro) · `11` §9–§10 + matriz §5
· `12` (notas de estado + tablas de recomendación) · `13` (íntegro) · `17` (íntegro) · `18` (íntegro) ·
`20` §5–§7 + §10 (X-13/X-18, RF-22/23, P-14/15/17, ToS) · `02` (estados + APR) · Código: `routes/web.php`,
`app/Models/`, `database/migrations/` (listado) · BD por lectura: 6 tablas de infra intactas.

## 2. Matriz de contradicciones entre documentos

| # | Tema | Dice A | Dice B | Veredicto |
|---|---|---|---|---|
| C-01 | Archivo "v5-1" | Encargo: existe `…Especificacion_v5-1.pdf` v5.0 | `docs/referencia/` solo contiene `…_v5.pdf` | **Premisa inexistente**: se auditó el v5.pdf real. Aclarar nombre. |
| C-02 | Stack | `12`/`15`/`11`§9: React+TS+Vite · Node+TS · REST (P-01 "dirección") | `11`§10, `20`§4, Plan Maestro §4: **Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5** (P-01 ADOPTADA) | **Resuelta a favor de Laravel**: la dirección React/Node quedó *superada* (`12` líneas 5-7). Eloquent es coherente con el stack vigente; Node/REST ya no aplica. |
| C-03 | BD | PDF v5.0 §4–5: **MySQL 8.0** | P-03 ADOPTADA (motor): **PostgreSQL/PostGIS** (`11`§10, `20`§7.2) | **Resuelta a favor de PostGIS**. `01` correcto; el PDF queda como referencia histórica. |
| C-04 | Cálculo de proximidad | PDF §5.3/5.5/§12: **prioritariamente en el cliente** | `01` §3.3/§5: corredor y proximidad **en servidor** | **Contradicción abierta** (ver H-02). D-07 + PDF §10.9 (ubicación no se almacena) tensionan el diseño servidor. Requiere decisión. |
| C-05 | Endpoints | `08` §6: REST `/v1` + OpenAPI (`POST /auth/*`, `/admin/*`) | Código real: solo Inertia web (`/registro`, `/verificar`…), sin `routes/api.php` | `08` §6 **desactualizado** vs P-01 (era de la Opción B). Requiere nota de conciliación, no migraciones. |
| C-06 | OTP storage | PDF §11: Redis TTL 10 min | Implementado: `otp_codes` en PostgreSQL | Desviación **aceptable y documentada** (sin Redis en local; hash+expiry equivalen). Sin decisión que tomar salvo que se exija Redis. |
| C-07 | Auth tokens | PDF §5: Sanctum tras OTP | Implementado: sesiones web Inertia | Coherente con Inertia (sesión, no token). Solo aplica Sanctum si se abre API. Sin conflicto real. |
| C-08 | Idiomas | PDF §6.1 + REQ-MULTI-01: **es+en** | P-14 rec: **es-PE + quechua** + topónimos (`11`§5, `20` X-18: ambos registrados) | **Abierta**: `01` DD-05 solo prevé es/en e ignora quechua/topónimo (`08` `toponymOriginal`). |
| C-09 | SLA moderación | Pantallas: 12h / 2–6h / 3.4h / <30m | D-08: sin SLA < 24 h; P-16 pendiente | Resuelta como regla (D-08); cifra pública pendiente. `01` no promete SLA. Correcto. |
| C-10 | Publicación "inmediata/5m" | `ADM-18` permisos 4/11 | D-08 + RS-7 (solo staff; reseñas siempre en cola) | Conciliada en `17` RS-7. `01` §2.8 la respeta. Correcto. |

## 3. Clasificación de las 16 tablas: MVP / posterior / dependiente de decisión

| Tabla | Clasificación | Fundamento |
|---|---|---|
| `categories` + translations | **MVP** (M1/M13) | Filtro y CRUD la exigen; **falta la taxonomía** (01 vs C01 sin unificar → pregunta P-CAT). |
| `places` + translations | **MVP** (M1–M3/M13) | Núcleo V-1/A-1. |
| `routes` + translations, `route_stops` | **MVP** (M4/M13, V-2/A-2) | Catálogo, detalle, GPX, reorden. `trigger` reducido a radio (D-07). |
| `favorites` | **MVP** (M6) | Simple, sin dependencias. |
| `itineraries` + stops | **MVP-base** (M7) | Sin constructor complejo (P-13); reglas de creación ABIERTAS (pregunta). |
| `reviews` | **MVP** (M8/M14) | Con cola y estados; UNIQUE lugar+autor **sin respaldo** → pregunta. |
| `media_assets` | **MVP** (M3/M8/M13) | Ficha, reseñas (≤3), biblioteca; topes de tamaño ABIERTOS (pregunta). |
| `moderation_items` | **MVP** (M14) | Cola única ADM-13; máquina de estados por detallar (pregunta). |
| `reports` | **MVP** (M14, C-2/R13) | Existe pestaña; flujo de resolución por detallar (pregunta). |
| `sponsorships` | **MVP-mínimo** (M3/M4/M13) | Badges manuales (P-15); **sin reglas de ordenación** (pregunta). |
| `consents` | **MVP** (M11, RF-11) | Opt-in exigible (Ley 29733); retención POR DEFINIR (P-07). |
| `privacy_requests` | **MVP-registro** (V-5) | Registrar sin publicar plazos (P-17); formulario con plazo, **no publicar** (D-15). |
| `notification_preferences` | **MVP** (M11) | Solo primer plano (D-07); tipos de aviso SIN definir (pregunta). |
| `audit_logs` | **MVP** (M14) | Append-only; exportación YubiKey pendiente operativa (R-B5). |
| `offline_packages` (manifiesto) | **Propuesta no incluida en `01`** | M4/M9 exigen descarga verificada con tamaño/hash → **falta tabla o justificación on-demand** (bloqueo de diseño, no de BD). |
| `users.status/role` | **Hueco en `01`** | ADM-10 exige activo/suspendido + roles; `01` §2.1 no los modela → pregunta (bloquea M14). |
| `Claim` | **Excluida** (P-18) | Correcto. |
| Métricas/aforo (1.000/84%) | **Sin tabla** (P-15) | Correcto no inventar fuente; badges manuales. |

## 4. Evaluación DD-01…DD-07 (todas siguen PROPUESTA)

- **DD-01 `route_stops` única.** Resuelve: dos listas paralelas (waypoints/track vs paradas) en `08`. Ventaja:
  un reorden ADM-09, un índice espacial. Riesgo: mezcla parada curada (vive/muere con el lugar) y punto libre;
  radio ¿del stop o del lugar?; trigger sunset huérfano. Alternativa: `waypoints` (track, import) + `route_places`
  pivot. Consecuencia MVP: simplifica A-2/M4 si se fija la semántica parada≠punto≠lugar (pregunta).
- **DD-02 media polimórfica.** Ventaja: una tubería de moderación/storage. Riesgo: **sin FK real** (huérfanos
  posibles; borrado de lugar deja medios). Alternativa superior en integridad: 3 FK anulables
  (`place_id/route_id/review_id`) + CHECK exactamente-uno (aprovecha índices y cascadas). MVP: aceptable
  cualquiera con tests de huérfanos; decidir antes de migrar.
- **DD-03 moderación única.** Ventaja: una cola ADM-13. Riesgo: `reports` que "enriquecen" ítems sin máquina
  de estados del reporte (¿quién cierra un reporte desestimado?). Alternativa: estados también en `reports`.
  Decidir antes de migrar (pregunta).
- **DD-04 sponsorships polimórfica.** Ventaja: un CRUD ADM-12. Riesgo: mismo que DD-02 + reglas de
  etiquetado/ordenación ABIERTAS (P-15). Sin reglas, la tabla solo guarda badges manuales: suficiente para MVP.
- **DD-05 i18n `*_translations` es/en.** Ventaja: slugs/SEO por idioma, reseñas sin traducir. Riesgo: **omite
  quechua y topónimo original** (H02M, P-14, `08`): si el quechua es locale o campo cambia el esquema.
  Bloquea el diseño de traducciones hasta P-14 (pregunta).
- **DD-06 `geography`/`geometry` + SRID 4326 + GiST.** Ventaja: metros reales, KNN, buffers (supera a MySQL
  según `20` §7.2). Riesgo: bajo con PostGIS adoptado; columna generada `geog` acopla escritura. Alternativa:
  solo `geography` (renunciar a ops planares) o solo `geometry`+cálculos con cast. No bloquea: es coherente
  con P-03; la elección fina puede ir en la migración.
- **DD-07 contadores desnormalizados.** Ventaja: ficha rápida sin agregados. Riesgo: deriva si la moderación
  falla a mitad (exige transacción + tests). Alternativa: vista materializada o conteo en lectura (piloto
  pequeño lo permite). No bloquea con tests.

**DD-08/DD-09 (adoptadas):** consistentes con D-06/D-07/D-10/D-13, P-18, P-15. Matiz: DD-08 omite el manifiesto
offline (ver `offline_packages` arriba); DD-09 correcta. La mención `18` C-7/P-07 es exacta.

## 5. Geoespacial: corrección de los patrones según motor
Con **PostGIS adoptado** (P-03 motor), los patrones de `01` §3.3 son válidos con 3 correcciones aplicadas o
pendientes: (a) **aplicada**: `ST_Intersects` mixto → cast a `geometry` en ambos lados + nota; (b) **aplicada**:
`pg_trgm`/`unaccent` requieren `CREATE EXTENSION`; (c) `ORDER BY geom <-> punto` + `LIMIT` usa índice solo con
estadísticas al día (`ANALYZE` tras cargas). Distinguir: proximidad/KNN/buffer/orden-por-secuencia son
**conceptos generales**; `<->`, `ST_DWithin`, `ST_Buffer`, `ST_LineLocatePoint`, `ST_Covers` son
**específicos PostGIS** (no portables a MySQL: sin KNN indexado ni `geography`, `20` §7.2). Casos extremos:
radio 0/negativo, punto inválido, ruta sin track, empate de distancia (desempate por `id`), página más allá
del total, ancho de corredor > tope. **Si se reabriera el motor (MySQL), todo §3.3 quedaría pendiente**; con
P-03 vigente, no es bloqueo.

## 6. Separación requisitos / adoptado / propuestas / pendientes
`01` la respeta (etiquetas **[PROPUESTA]**, "sin ejecutar", pendientes nombrados). Faltas detectadas:
RBAC (matriz P-05 campo a campo; rol TIER 3 íntegro propuesta R-B3; YubiKey R-B5; comité RS-9 sin definir) ·
OTP (contrato P-04; 2FA consola fuera de alcance) · ARCO/plazos (P-17, sin inventar; `privacy_requests.due_at`
correcto sin valores) · notificaciones (tipos sin definir; H05M promete fondo imposible → D-07 manda) ·
métricas (P-15; no modelar fuente) · **propiedad de lugares: sin evidencia en ningún documento** (ausencia
registrada; preguntas: ¿puede un negocio reclamar/gestionar su ficha? ¿flujo y permisos?) · subidas (250 MB es
valor mock observado, no aprobado; exFAT/EXIF R6; parser GPX R4/XXE) · dificultad (escala sin definir en
ningún documento) · consentimiento (checkbox no premarcado PDF §10.1; historial vs estado → considerar log
append-only para prueba de opt-in).

## 7. Hallazgos (severidad · impacto · recomendación · base)

| # | Hallazgo | Sev. | Recomendación |
|---|---|---|---|
| H-01 | C-04: proximidad servidor (`01`) vs cliente (PDF §5.3/§12) + §10.9 (ubicación no se almacena) | **Alta** | **BLOQUEO previo a migraciones espaciales**: decidir arquitectura de proximidad (servidor con posición efímera y consentimiento, o cliente con descarga acotada) + conciliar D-07. Requiere aprobación. |
| H-02 | `08` §6 REST/OpenAPI vs Inertia implementado (C-05) | Alta | **BLOQUEO documental**: nota de conciliación en `08` o archivar §6 como histórico Opción B. No migrar API hasta P-08/definitivo. Requiere aprobación. |
| H-03 | `users.status` + modelo de roles ausentes en `01` | Alta | **BLOQUEO parcial** (M14): definir `status` y almacenamiento de roles (enum/tabla/pivot) antes de migraciones de usuarios-staff. Requiere aprobación (P-05). |
| H-04 | DD-05 ignora quechua/topónimo (C-08) | Media | No migrar traducciones hasta P-14. Requiere aprobación. |
| H-05 | UNIQUE reseña lugar+autor sin respaldo en RF | Media | Confirmar política (única+edición vs múltiples) antes de migrar. Requiere aprobación. |
| H-06 | Manifiesto offline ausente (M4/M9) | Media | Añadir `offline_packages` mínimo o justificar generación on-demand. Requiere aprobación. |
| H-07 | Polimórficas sin FK (DD-02/03/04) | Media | Elegir morfo vs FK-anulables+CHECK antes de migrar. Requiere aprobación (técnica). |
| H-08 | Máquina de estados de `reports` sin detallar | Media | Diferible a diseño de moderación, antes de su migración. |
| H-09 | Tipos de notificación, escala de dificultad, topes de subida, reglas patrocinio, propiedad de lugares | Baja/Media | Preguntas de producto; diferibles por tabla; no bloquean el modelo base. |
| H-10 | `08` §6.4 errores `401` vs implementado (302+errores en Inertia) | Baja | Conciliar al actualizar `08` (H-02). Diferible. |

## 8. Correcciones aplicadas (solo inequívocas, sin aprobar nada)
1. `01` §3.3: `ST_Intersects(p.geom::geometry, c.area::geometry)` + nota (tipos mixtos inválidos).
2. `01` §3.2: `pg_trgm`/`unaccent` requieren `CREATE EXTENSION` (no "sin instalar").
3. `01` §2.4: CHECK (`place_id` NOT NULL OR `geom` NOT NULL) + renumeración transaccional.
No se tocó alcance, decisiones, código, BD ni config.

## 9. Decisiones que requieren tu aprobación (priorizadas)
1. **H-01**: arquitectura de proximidad servidor vs cliente (bloquea migraciones espaciales y V-2).
2. **H-02**: destino de `08` §6 (conciliar con Inertia o mantener REST futura) — afecta contratos y P-08.
3. **DD-01…DD-07**, una a una (en especial DD-01 semántica, DD-02/DD-04 integridad, DD-05 idiomas).
4. **H-03**: `status` + roles de usuario (P-05 campo a campo; TIER 3).
5. **H-05/H-06**: unicidad de reseñas; manifiesto offline.
6. **Preguntas**: taxonomía de categorías (P-CAT), tipos de notificación, escala de dificultad, topes de subida,
   reglas de patrocinio (P-15), propiedad de lugares, consent-log, métricas (P-15), ARCO/Libro (P-17/P-18),
   nombre del PDF "v5-1".
Diferibles tras el modelo base: H-08, H-09 (por tabla), H-10, SSR/SEO (residual P-01), P-02, IONOS, P-07/P-10…P-24.

## 10. Verificación de no-cambios
BD por lectura: `migrations, users, otp_codes, sessions, password_reset_tokens, spatial_ref_sys` (0 tablas de
negocio; `spatial_ref_sys` tratada solo como sistema PostGIS). Repositorio: solo `01` (3 ediciones §7) +
este informe (`docs/analisis/21-*`). Sin PHP/config/env/dependencias/Git/Stitch/despliegues. **APR = 0.**
