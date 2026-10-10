# LUMINA — Registro de Decisiones Pendientes (FASE 1.5 → FASE 1.6 → actualizado en FASE 1.7)

> **Alineación 2026-10-10:** la matriz maestra consolidada de decisiones (D-01…D-15, P-01…P-24) está en `20-alineacion-integral.md` §10. Este registro se mantiene como fuente de detalle por decisión.

> **Regla:** cada fila indica: pregunta, alternativas, evidencia, recomendación razonada, qué bloquea y estado. Las respuestas del usuario se registran aquí; la consolidación, con las preguntas nuevas y los 7 campos completos, está en `11-decisiones-consolidadas.md`.
> **Estado:** `ABIERTA` = sin respuesta · `RECOMENDADA` = propuesta esperando "sí/no" · `RESUELTA_TÉCNICA` = la evidencia la cierra pero requiere aprobación · **`ADOPTADA`** = decisión de producto adoptada en FASE 1.6 (orienta el análisis, **no** es contrato técnico) · **`ADOPTADA-COND`** = adoptada con condición pendiente · **`PROPUESTA-PROV`** = recomendación comparada entregada, esperando aprobación.
> Ids anteriores (`C1–C4`, `A1–A10`, `B1–B8`) se conservan para mantener la trazabilidad con `01`, `02`, `03` y `04`; los nuevos de FASE 1.5 son `A11–A16`; las preguntas consolidadas de FASE 1.6 son `P-01…P-24` (en `11`).

---

## Tema A — Evidencia de diseño y alcance visual

| ID | Pregunta | Alternativas | Evidencia | Recomendación | Bloquea | Estado (FASE 1.7) |
|---|---|---|---|---|---|---|
| **C3** | ¿Cuál es el set de pantallas vigente: familia **numerada** (9) o **codificada** (53)? | (a) Codificada es la especificación y numerada un storyboard → (b) Numerada es la vigente y codificada un exploratorio → (c) Ambas vigentes, priorizando por funcionalidad | Dos bloques separados en lienzo (`y≤4730` vs `y≥5126`); Jaccard 0.11–0.36 (no duplicados); **sin fecha por pantalla en la API**; la codificada tiene más estados (errores, vacíos, permisos) y las 18 pantallas ADM; la numerada tiene 2 pantallas únicas de alcance amplio (`07&08`, `04&05`) | **(c) ambas vigentes**, usando la codificada como base de especificación (más estados + consola completa) y la numerada como fuente de flujos/contenido; unificar al final sin borrar nada | Todas las pantallas, inventario, backlog | **ADOPTADA** (D-01) |
| **C4 / A1** | ¿Cómo tratar los lienzos combinados (`01M&02`, `04&05`, `07&08`, `09&10`, `06M`)? | (a) Separarlos en pantallas individuales en Stitch → (b) Mantenerlos y documentar nº de vistas → (c) Contarlos como 1 pantalla | Vistas identificadas por evidencia: `01M&02`=2, `04&05`=2, `07&08`=2, `09&10`=2, `06M`=3 | **(b)**; no se separan automáticamente | Conteo de pantallas, trazabilidad | **ADOPTADA** (D-03) |
| **C2** | ¿Se valida el breakpoint tablet 768–1024 (panel lateral 380 px)? | (a) Diseñar variantes tablet propias → (b) Adoptar 1280 como "tablet" → (c) Dejar tablet para FASE 2 con el usuario | `designMd` exige 768–1024 con panel 380 px; **0 artefactos** en ese rango; `07&08` y `12T` etiquetadas "Tablet" miden 1280 px | **(a)**: 768–1024 entra en el alcance de diseño; 1280 px no valida tablet | REQ-UI-03, responsive | **ADOPTADA** (D-04) — diseño pendiente: `S-3` de `14` |
| **C1** | Fuente canónica de color | (a) Bloque `colors:` del designMd → (b) Prosas `#243B35/#D5A45D/#F5F1E8` → (c) Mapeo semillas+tokens | `customColor #243b35` documentado como *seed color for the dynamic color system*; `override*` = paleta prosa; `#243b35`=153 usos y `#263238`=0; los 38 hex únicos de los 47 roles del bloque `colors:` aparecen en los HTML (38/38) | **(c)**: tokens como fuente máquina + semillas como valores de marca + corregir la prosa en Stitch | Design system, todos los componentes | **ADOPTADA** (D-02) — contrato de 47 roles pendiente (P-01/`#7`) |

## Tema B — Interacción, navegación y estados

| ID | Pregunta | Alternativas | Evidencia | Recomendación | Bloquea | Estado (FASE 1.7) |
|---|---|---|---|---|---|---|
| **A11** | ¿Cuál es la navegación inferior definitiva? | 5 variantes: `…/Perfil` (01M&02), `…/Ajustes` (C02M), `Itinerarios/Guías` (C05M/C10M), `Guardados` (F01M), `Offline` (G05M) | Texto literal de 5 pantallas | **5 destinos fijos** `Explorar · Buscar · Rutas · Guardados · Ajustes`; "Offline" dentro de Ajustes e "Itinerarios" dentro de Guardados | Navegación global, árbol de rutas | **ADOPTADA-COND** (D-05; verificación vs RF/flujos en `11` §4.1 — excepciones **E1–E3** → P-09) |
| **A3** | Canal del OTP | (a) Solo correo → (b) Solo SMS → (c) Ambos con fallback | `B07M`/`07&08` = correo; `B08M` = "OTP (Móvil)" | **(c)** comenzando por correo (sin coste por mensaje) y dejando SMS como ampliación | Auth, costes, `08-modelo` | **ADOPTADA** (D-06: correo inicial, SMS ampliación) → **FASE 1.7:** especificación OTP + proveedores entregados (`16`); proveedor/contrato **PENDIENTE DE APROBACIÓN** (P-04) |
| **A14** | ¿Se mantienen balizas de proximidad y alertas en segundo plano? | (a) Sí, requiere app nativa → (b) Solo en primer plano (app abierta) → (c) Rediseñar como recordatorios programados | `H05M` promete desvío +40 m y ocaso 45 min con Web Push + SW; PWAs **no soportan geofencing** ni sync en segundo plano en iOS | **(b) en MVP**, dejando (a) como fase posterior; comunicar la limitación al usuario | RF-10, RF-04, `10-dependencias` | **ADOPTADA** (D-07) |
| **A12** | ¿Cuál es el SLA de moderación? | 12 h (`07&08`) / 2–6 h (`G10M`) / 3.4 h de espera (`ADM-13`) / 18 min con meta <30 m (`09&10`, `12T`) | 4 cifras incompatibles | No publicar SLA < 24 h sin capacidad demostrada; medir y comunicar plazos realistas; métricas internas en `ADM-17` | RF-07, RF-16, copy | **ADOPTADA** (D-08) — cifra pública: **P-16** (tras métricas) |
| **A13** | Modelo de roles | 3 tiers (`ADM-18`) / 4 con Explorador (`ADM-10`) / comité de 3 curadores (`07&08`) | Pantallas | **Explorador + 3 niveles staff**; el "comité de tres" se modela como regla de aprobación, no como rol | RBAC, `08-modelo` | **ADOPTADA-COND** (D-09) → **FASE 1.7:** `ADM-18` leído campo a campo y matriz propuesta entregada (`17`); 15×3 y comité **NO aprobados** — pendiente P-05 |
| **A16** | ¿Se implementa gamificación (pts, niveles, badges)? | (a) Sí completo → (b) Solo visibilidad social → (c) No | `G10M` +40 pts, `H01M` 420 pts, `ADM-15` Nivel 4, `ADM-14` Fiabilidad 98%, `ADM-10` contadores | **(c) no en el MVP**; indicadores de fiabilidad sólo con criterios objetivos, transparentes y verificables | Modelo de datos, esfuerzo | **ADOPTADA** (D-10) |

## Tema C — Contenido, datos y cumplimiento

| ID | Pregunta | Alternativas | Evidencia | Recomendación | Bloquea | Estado (FASE 1.7) |
|---|---|---|---|---|---|---|
| **A15** | Plazo de respuesta ARCO | 10 días hábiles (`H07M`) / 20 días hábiles (fuentes externas Ley 29733) | Pantalla vs fuentes secundarias | **Verificar con asesoría legal** antes de fijar copy; no publicar plazo por cuenta propia | H07M, legal | **ABIERTA — ASESORAMIENTO** (D-15) → P-17 |
| **L-CLAIM** | ¿Se implementa Libro de Reclamaciones Virtual real? | (a) Sí con integración/registro oficial → (b) Formulario informativo → (c) Enlace a canal externo | `H08M` pide RUC, domicilio, hoja, medio, monto y cita "15 días hábiles"; datos son ficticios | Decidir con asesoría legal + datos reales del operador; **no implementar con RUC inventado** | H08M, legal | **ABIERTA — ASESORAMIENTO** (D-15) → P-18 |
| **REQ-DATA-01** | ¿Se aprueba el modelo de datos/API propuesto? | (a) Aprobar como base provisional → (b) Revisar → (c) Rechazar y redefinir | `08-modelo-dominio-api.md` | **(a)** con sus 7 preguntas abiertas y los ajustes de coherencia C-1…C-5 de `11` §4.4 | Toda FASE 2 | **ADOPTADA-COND** (D-11) → **FASE 1.7: P-06 APROBADA como base provisional** con condiciones; **C-1…C-5 aplicados** en `08`; retención (C-7) sigue en **P-07** (`18`) |
| **DATA-2** | ¿Se muestra el email del autor en moderación? | (a) Sí (mock actual) → (b) No, alias/ID | `ADM-14` muestra email completo | **(b)** (riesgo R2); acceso excepcional justificado, restringido y auditado | `08-modelo` | **ADOPTADA** (D-12) — contrato de auditoría en FASE 2 |
| **DATA-3** | ¿Qué significa "coordenadas sensibles" que hay que ocultar? | (a) Lugares rituales/sagrados → (b) Datos de personas → (c) Nada automático | `ADM-13`, `H04M` | No inventar categorías; criterios propuestos en `11` §4.5 a validar con la comunidad | RF-16 | **ADOPTADA** (D-13: método) — criterios finales: **P-21** |
| **CONTENT-1** | ¿Unificar el contenido de ejemplo (318 vs 128 reseñas, años 2024/2025/2026, RUC ficticio)? | (a) Corregir en Stitch → (b) Ignorar como mock | `L6` del informe | **(a)** sin inventar datos reales de lugares | Reputación de la demo | **ADOPTADA** (autorización FASE 1.6 §2) — corrección **PREPARADA** (`S-6` de `14`) |

## Tema D — Decisiones de arquitectura (heredadas B1–B8)

| ID | Pregunta | Bloquea | Estado (FASE 1.7) |
|---|---|---|---|
| **B1** | Frontend: PWA SPA (¿framework?) | Todo el código cliente | **ADOPTADA** (P-01: Vue 3 + TS + Inertia 3; SSR preferente para SEO) |
| **B2** | Backend: lenguaje/framework y modelo de despliegue | API, colas, auth | **ADOPTADA** (P-01: Laravel 13; monolito; desarrollo local) |
| **B3** | Base de datos y almacenamiento geoespacial | Modelo `08-modelo` | **ADOPTADA (motor)** (P-03: PostgreSQL con PostGIS desde local); proveedor de producción: **pendiente (IONOS por evaluar)** |
| **B4** | Proveedor de mapas/tiles y coste | RF-01, offline | **PARCIAL**: motor MapLibre adoptado; proveedor de teselas **PENDIENTE DE APROBACIÓN** (`15` §2, fuentes 2026-10-10) |
| **B5** | Proveedor OTP/mensajería y coste | RF-08 | **ADOPTADA** (P-04: OTP 6 dígitos solo en registro; **SMTP Google**; capturador en local — `16`) |
| **B6** | Almacenamiento de media y CDN | RF-17, coste | **PROPUESTA-PROV** (fuera del combo aprobado en P-01; decidir con P-02/CDN) |
| **B7** | Estrategia offline/sync y librerías | RF-09 | **PROPUESTA-PROV** (acotada por D-07); condicionada por el proveedor de teselas (P-02) |
| **B8** | Analítica y consentimiento | RF-11, `H06M` | **PROPUESTA-PROV** (P-08 = alcance de planificación); telemetría: fila 9 de `18` (P-07/consentimiento) |

---

## Resumen de estado (tras FASE 1.6)

| Estado | Nº | IDs |
|---|---|---|
| **ADOPTADA** (decisión de producto, contrato pendiente) | 12 | C1, C3, C4/A1, C2, A3, A12, A14, A16, REQ-DATA-01*, DATA-2, DATA-3, CONTENT-1 |
| **ADOPTADA-COND** (con condición/verificación pendiente) | 3 | A11 (E1–E3), A13 (matriz 15×3), REQ-DATA-01 (como base provisional) |
| **PROPUESTA-PROV** (recomendación comparada, esperando aprobación) | 8 | B1–B8 |
| **ABIERTA — ASESORAMIENTO** | 2 | A15, L-CLAIM |
| *(siguen abiertas fuera de este registro)* | — | **todas** las preguntas consolidadas `P-01…P-24` siguen esperando tu respuesta → `11` §5 |

## Resumen de estado (tras FASE 1.7 — 2026-10-10)

> La columna de estado de arriba corresponde al cierre de FASE 1.6. Los efectos de FASE 1.7 sobre las decisiones de este registro:

| Efecto FASE 1.7 | IDs | Detalle |
|---|---|---|
| **APROBADA COMO DIRECCIÓN** (stack) | B1, B2 (parcial) | P-01; residual SSR/prerender pendiente |
| **Dirección dada, proveedor pendiente** | B3 (P-03), B4 (P-02) | comparativas finales en `15` §2/§3 |
| **Contrato entregado, pendiente** | A3, B5 | `16` (OTP + email) → P-04 |
| **Propuesta entregada, pendiente campo a campo** | A13, B7* | `17` (RBAC, `#27` cerrado) → P-05 |
| **APROBADA como base provisional** | REQ-DATA-01 | P-06: C-1…C-5 aplicados en `08` |
| **Propuesta sin plazos, pendiente + jurídico** | (P-07, nuevo registro) | `18` |
| **Alcance aceptado para planificación** | B8 (en parte) | P-08: `13` provisional; revisión en `15` §7 |
| **Sin cambio** | C1–C4, A11–A12, A14–A16, DATA-2/3, CONTENT-1, A15, L-CLAIM, P-09…P-24 | siguen con su estado |

\* B7 cambia sólo por el acotado de D-07; su elección de librerías sigue dentro de P-01 (dirección) sin cerrar contratos.

\* `REQ-DATA-01` aparece en ambas filas a propósito: la **dirección** (usar `08` como base) está adoptada; el **contrato** sigue condicionado a P-06.

> **Convención de IDs:** `A1–A10` = ambigüedades históricas de `01-informe-tecnico.md` (A1 combinadas · A2 búsqueda sin resultados · **A3 canal OTP** · A4 toponimia · A5 cobertura responsive · A6 modo oscuro · A7 estados CRUD · A8 constructor de itinerarios · A9 modelo de negocio · A10 sin especificación de datos). Las nuevas de FASE 1.5 son **A11–A16**. Las preguntas consolidadas de FASE 1.6 son **P-01…P-24** (`11-decisiones-consolidadas.md` §5); **P-01…P-08 tienen estado desde FASE 1.7** (`11` §9).
> **Total de decisiones registradas en este archivo:** 24 (más B1–B8 desglosadas arriba).

> **Ninguna decisión adoptada equivale a aprobación de un contrato técnico.** Las adopciones (D-01…D-15) fijan dirección de producto; desde FASE 1.7, **P-01…P-08** añaden direcciones aprobadas y propuestas entregadas, pero **stack definitivo, proveedores, modelo, RBAC, retención, textos legales y cifras públicas siguen pendientes de tu respuesta explícita.** Ver `15-fase-1-7-informe.md` §10 para la lista concreta de aprobaciones esperadas.
