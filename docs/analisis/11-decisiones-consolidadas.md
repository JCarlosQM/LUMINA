# LUMINA — Decisiones Consolidadas (FASE 1.6)

> **Propósito:** registrar las decisiones adoptadas en FASE 1.6, separarlas de los **contratos técnicos todavía pendientes**, consolidar todas las preguntas abiertas (`09-decisiones-pendientes.md` + `10-dependencias-tecnicas.md` + las 7 de `08-modelo-dominio-api.md` §7) y asignar responsable de validación a cada una.
> **Regla de oro:** una decisión de producto adoptada **orienta el análisis, no cierra un contrato técnico**. Nada de este documento selecciona proveedor, framework, texto legal ni modelo de datos definitivo.

---

## 1. Estados y vocabulario

| Estado | Significado | ¿Cierra algo? |
|---|---|---|
| **ADOPTADA** | Decisión de producto adoptada en FASE 1.6 para orientar el análisis y la preparación | Cierra la *dirección*, no la *implementación* |
| **ADOPTADA-COND** | Adoptada con una condición verificada o pendiente de verificación explícita | Cierra la dirección si la condición se cumple |
| **PROPUESTA-PROV** | Recomendación nuestra, sin aprobación | No cierra nada |
| **ABIERTA** | Sin respuesta del responsable indicado | Bloquea lo que indique su fila |
| **ASESORAMIENTO** | Requiere especialista (legal, comunidad, operaciones) | No puede cerrarse internamente |
| **PREPARADA** | Corrección/artefacto preparado, pendiente de autorización para ejecutar | No se ha ejecutado |

**Lo que FASE 1.6 NO aprueba:** stack (B1–B8), proveedor alguno, modelo de datos como contrato, RBAC definitivo, textos legales, cifras de SLA, ni ninguna adquisición de servicio.

---

## 2. Decisiones adoptadas (D-01 … D-15)

> Redacción fiel al prompt de FASE 1.6, resumida sin alterar su sentido. La columna *Contrato técnico pendiente* indica qué sigue abierto pese a la adopción.

| ID | Decisión adoptada (producto) | Tipo | Qué resuelve (IDs históricos) | Contrato técnico pendiente | Responsable |
|---|---|---|---|---|---|
| **D-01** | Familias de Stitch: **ambas** se conservan; las codificadas son referencia principal de especificación visual, las numeradas material complementario; nada se elimina, fusiona ni descarta por suposición | ADOPTADA | **C3** (set vigente) | Unificación final de duplicados (`06` §3) si se decide más adelante | Usuario |
| **D-02** | Color: **base** = tokens de color de Stitch + las 4 semillas `#243B35`, `#D5A45D`, `#647D75`, `#F5F1E8`; documentar relación semilla→token; corregir contradicciones textuales **sin** alterar colores renderizados ni los 47 roles | ADOPTADA | **C1** (fuente canónica) | Contrato de los 47 roles y corrección de la prosa en Stitch (`S-1` de `14`) | Usuario + técnico |
| **D-03** | Lienzos combinados: **se conservan**; documentar vistas y estados que contienen; no separarlos automáticamente | ADOPTADA | **C4 / A1** | Normalización opcional futura (ítem `#53` de `04`) | Usuario |
| **D-04** | Tablet: el alcance de diseño cubre **768–1024 px reales**; los 1280 px **no** validan tablet; harán falta diseños específicos y criterios de aceptación responsive | ADOPTADA | **C2**, REQ-UI-03, REQ-ADM-14 | Diseños tablet (preparados como paso `S-3` de `14`) y criterios de aceptación por breakpoint | Usuario + diseño |
| **D-05** | Navegación móvil: proponer **5 destinos** `Explorar · Buscar · Rutas · Guardados · Ajustes`; verificar antes de cerrar que no contradice requisitos/flujos; registrar variantes y excepciones | ADOPTADA-COND | **A11** (5 variantes) | Cierre definitivo tras resolver las excepciones **E1–E3** (§4.1) | Usuario |
| **D-06** | Autenticación: **correo** como canal OTP inicial; **SMS** como posible ampliación; sin proveedor elegido; documentar expiración, reintentos, límites, anti-abuso, recuperación y errores antes de implementar | ADOPTADA | **A3** (canal OTP) | Contrato OTP + proveedor de email (**B5** → P-04) | Usuario + técnico |
| **D-07** | Balizas: **no prometer** detección fiable con la PWA cerrada; MVP = experiencias en **primer plano**; la funcionalidad nativa futura se evalúa aparte | ADOPTADA | **A14** (geofencing) | Copy de `H05M` y alcance de RF-10/RF-04 (fuera de 2.º plano) | Usuario |
| **D-08** | Moderación: **no publicar SLA < 24 h** sin capacidad demostrada; medir tiempos y comunicar plazos realistas; objetivo interno ≠ compromiso público | ADOPTADA | **A12** (4 cifras) | Cifra pública concreta, sólo tras métricas reales (P-16) | Operaciones |
| **D-09** | Roles: evaluar **1 rol explorador + 3 niveles internos**; no asignar privilegios por intuición; comparar los 3 modelos de Stitch; definir permisos por acción y registrar la propuesta **antes** de cerrar el RBAC | ADOPTADA-COND | **A13** (3 modelos) | Matriz 15 permisos × 3 niveles leída campo a campo y aprobada (P-05) | Usuario + técnico |
| **D-10** | Gamificación: **sin** puntos, niveles ni insignias en el MVP; indicadores de fiabilidad sólo con criterios objetivos, transparentes y verificables | ADOPTADA | **A16** (REQ-GAM-01) | Criterios del indicador de fiabilidad si se quiere conservar `ADM-14`/`12T` | Usuario |
| **D-11** | Modelo de dominio/API: `08-modelo-dominio-api.md` es **base provisional de análisis**, no contrato de producción; antes de migraciones/endpoints/permisos revisar sus 7 preguntas y comprobar coherencia con los 19 RF y los 9 flujos | ADOPTADA-COND | **REQ-DATA-01**, `08` §7 | Coherencia verificada (§4.4); contrato tras cerrar P-06/P-07 y el stack | Usuario + técnico |
| **D-12** | Datos personales: el email del autor **no** se muestra en vistas ordinarias de moderación; cualquier acceso excepcional, justificado, restringido y auditado | ADOPTADA | **DATA-2** (R2) | Diseño del acceso excepcional y su auditoría en FASE 2 | Usuario + legal |
| **D-13** | Coordenadas sensibles: **no inventar** categorías ni reglas automáticas definitivas; documentar el problema y proponer criterios para validarlos con la comunidad y responsables | ADOPTADA | **DATA-3** (R5) | Criterios finales (§4.5 son propuesta, no regla) | Comunidad + usuario |
| **D-14** | Proveedores: arquitectura **desacoplada** de mapas, teselas, medios, OTP, analítica y notificaciones; comparar alternativas, límites, atribución, costes, privacidad y migrabilidad **antes** de seleccionar | ADOPTADA | **B4–B8** (método) | Selección concreta de cada proveedor (P-01…P-04) | Usuario + técnico |
| **D-15** | Cumplimiento legal: siguen **pendientes de validación especializada** plazos ARCO, procedimiento de incidentes, consentimientos y Libro de Reclamaciones; no inventar RUC, operador, textos ni plazos | ASESORAMIENTO | **A15**, **L-CLAIM** | Dictamen legal + datos reales del operador (P-19…P-22) | Asesoría legal |

### 2.1 Decisiones adoptadas que **no** están en la lista D pero quedan resueltas por autorización expresa de FASE 1.6 §2

| ID | Tratamiento | Estado |
|---|---|---|
| **CONTENT-1** | Se autoriza corregir contenidos de muestra incoherentes en Stitch, **sin inventar datos reales de lugares** | ADOPTADA → corrección **PREPARADA** (`S-6` de `14`) |
| **A2** (búsqueda con resultados) y **A7** (estados de éxito/error/carga) | Se autoriza diseñar esos estados en Stitch | ADOPTADA → **PREPARADA** (`S-4`, `S-5` de `14`) |
| **C2** (¿alcance tablet?) | Resuelto por D-04: sí, 768–1024 en alcance de diseño | ADOPTADA (diseño pendiente) |

---

## 3. Efecto sobre el registro histórico (`09-decisiones-pendientes.md`)

> El registro `09` se actualizó con estos estados. Se conservan **todos** los IDs originales (`C1–C4`, `A1–A16`, `B1–B8`) sin renumerar.

| ID | Estado en FASE 1.5 | Estado tras FASE 1.6 | Motivo |
|---|---|---|---|
| C1 | RESUELTA_TÉCNICA | **ADOPTADA** (contrato pendiente) | D-02 |
| C3 | RECOMENDADA | **ADOPTADA** | D-01 |
| C4 / A1 | RECOMENDADA | **ADOPTADA** | D-03 |
| C2 | ABIERTA | **ADOPTADA** (diseño pendiente) | D-04 |
| A11 | ABIERTA | **ADOPTADA-COND** (E1–E3) | D-05 + §4.1 |
| A3 | ABIERTA | **ADOPTADA** (proveedor pendiente) | D-06 |
| A12 | ABIERTA | **ADOPTADA** (cifra pendiente de métricas) | D-08 |
| A13 | ABIERTA | **ADOPTADA-COND** (matriz pendiente) | D-09 + §4.2 |
| A14 | ABIERTA | **ADOPTADA** | D-07 |
| A15 | ABIERTA (asesoramiento) | **ABIERTA — ASESORAMIENTO** (sin cambio) | D-15 la mantiene pendiente |
| A16 | ABIERTA | **ADOPTADA** (fuera de MVP) | D-10 |
| REQ-DATA-01 | ABIERTA | **ADOPTADA-COND** (base provisional) | D-11 |
| DATA-2 | RECOMENDADA | **ADOPTADA** (contrato de auditoría pendiente) | D-12 |
| DATA-3 | ABIERTA | **ADOPTADA** (criterios por validar) | D-13 |
| CONTENT-1 | ABIERTA | **ADOPTADA** (corrección preparada) | §2 autorización |
| L-CLAIM | ABIERTA (asesoramiento) | **ABIERTA — ASESORAMIENTO** (sin cambio) | D-15 |
| B1–B8 | ABIERTA | **PROPUESTA-PROV** en `12-comparativa-stack.md` | D-14 define método; falta aprobación |
| A1, A2, A4–A10 | ABIERTAS (históricas) | sin cambio de estado; varias entran en el alcance MVP (`13`) o en preguntas (§5) | — |

---

## 4. Verificaciones exigidas por las decisiones adoptadas

### 4.1 D-05 — Navegación unificada vs requisitos y flujos

**Comprobación** de los 5 destinos propuestos contra `07-requisitos-funcionales.md` (19 RF, 9 flujos) y `06-inventario-pantallas-depurado.md`:

| Destino | Requisito / flujo | Evidencia en Stitch | Resultado |
|---|---|---|---|
| Explorar | RF-01, V-1 | `01`, `C01`, `C02M` | ✅ sin conflicto |
| Buscar | RF-02, V-1 | `C05M` (sin resultados), `C01`/`C02M` (campo vacío), atajo `⌘K` en RF-01 | ⚠️ ver **E1** |
| Rutas | RF-04, V-2 | `E01` catálogo, `E03` detalle | ✅ sin conflicto |
| Guardados | RF-05, RF-06, V-3 | `F01M` usa literalmente "Guardados"; `06M` agrupa Lugares/Itinerarios/Notas | ✅ coherente: Itinerarios dentro de Guardados |
| Ajustes | RF-10, RF-11, V-5 | `C02M` ya tiene "Ajustes" en la bottom-nav; familia `H*` | ✅ sin conflicto |

**Variantes originales registradas (no se borran):** `01M&02` …/Perfil · `C02M` …/Ajustes · `C05M`/`C10M` Itinerarios/Guías · `F01M` Guardados · `G05M` Offline.

**Excepciones detectadas (D-05 exige registrarlas):**

| ID | Excepción | Detalle | Alternativas | Recomendación |
|---|---|---|---|---|
| **E1** | "Buscar" como destino fijo **no existe en ninguna variante**; la evidencia es búsqueda *overlay* (barra flotante + `⌘K`) | Exige la pantalla de resultados con contenido (hueco A2, **ya autorizada** su diseño en §2) | (a) mantener los 5 destinos de D-05 y diseñar la pantalla de resultados · (b) sustituir "Buscar" por "Perfil" y dejar la búsqueda como overlay · (c) 4 destinos + overlay | **(a)**, porque RF-02/V-1 exigen un estado de resultados y su diseño está autorizado; requiere tu confirmación |
| **E2** | "Perfil" (`01M&02`) queda **fuera** de los 5 destinos y además no tiene pantalla propia (REQ-UX-01, hueco `06` §4.4) | Perdería acceso visible en móvil | (a) dentro de Ajustes · (b) destino propio en la nav · (c) fuera de alcance MVP | **(a)** dentro de Ajustes para MVP |
| **E3** | "Guías" (etiqueta en `C05M`/`C10M`) **no tiene RF equivalente** | Vocabulario sin requisito | (a) mapear a Rutas si "Guías" = rutas curadas · (b) retirar la etiqueta en la corrección Stitch · (c) mantenerla como contenido futuro sin requisito | **(a)** si confirmas que "Guías" son rutas; si no, **(b)** |
| **E4** *(sin decisión)* | "Offline" (`G05M`) pierde destino propio | RF-09 no exige pestaña propia | dentro de Ajustes o de Guardados | **Ajustes** (gestión de caché/espacio), sin conflicto |

**Conclusión D-05:** los 5 destinos **no contradicen** RF-01/02/04/05/06/10/11 ni los flujos V-1/V-2/V-3/V-5. El cierre definitivo depende de **E1–E3** (P-11).

### 4.2 D-09 — Los 3 modelos de roles comparados

| Modelo | Fuente | Estructura | Coherencia numérica |
|---|---|---|---|
| **M1** | `ADM-18` | 3 niveles staff: TIER 1 Super Administrador (**2** usuarios) · TIER 2 Editor de Contenido & Topógrafo (**6**) · TIER 3 Moderador Comunitario/Custodio (**18**), con **15 permisos** en 5 grupos | ✔ coincide con los contadores de M2 |
| **M2** | `ADM-10` | Exploradores **1.420** · Custodios **18** · Editores **6** · Super Admin **2** | ✔ añade el rol base **Explorador** |
| **M3** | `07&08` | "Comité de **tres** curadores locales" (gobierno colegiado) | ✖ no es un tier de sistema |

**Propuesta bajo D-09 (no cerrada):** `Explorador` (rol base, sin publicación directa) + 3 niveles internos = M1. M3 se modela como **regla de aprobación**, no como rol (quién debe avalar una decisión puntual); el caso de uso concreto requiere tu confirmación.

**Los 15 permisos, agrupados como aparecen en `ADM-18` (texto literal extraído de la evidencia):**

| Grupo | Nº | Acciones observadas |
|---|---|---|
| G1 · Catálogo de Lugares y Toponimia | 4 | Crear parajes y waypoints · Modificar topónimos ancestrales (Runa Simi) · Eliminar parajes oficiales (estado observado: "Bloqueado a Super Admin") · Publicar inmediatamente en PWA |
| G2 · Red de Rutas y GPX/GeoJSON | 3 | Subir trazas GPS y calcular altimetrías · Reordenar paradas y geocercas (radio 5–50 m) · Alterar umbrales de desvío (+40 m) y alarma SOS (estado: "Requiere Nivel 1") |
| G3 · Curaduría Multimedia | 3 | Subir vídeos 9:16 y fotos (límite 250 MB) · Ofuscar metadatos EXIF sensibles (estado: "Mandatorio ético") · Eliminar material multimedia de forma permanente |
| G4 · Moderación de Reseñas y Fotos | 3 | Aprobar testimonios éticos · Rechazar con dictamen normativo · Desindexar usuarios por infracciones ARCO (estado: "Privilegio legal restringido") |
| G5 · Seguridad y Gobernanza | 2 | Exportar auditoría SHA-256 (firma YubiKey) · Administrar claves API y balizas físicas (estado: "Tier 1 Exclusivo") |

**Pendiente (no se inventa):** la matriz *acción × nivel* exacta requiere lectura campo a campo de `ADM-18` (ítem `#27` de `04-backlog.md`); los estados citados corresponden a la configuración mostrada para el TIER 2 ("10 de 15 Permisos Activos"). Reglas derivadas ya documentadas en `08` §3 se mantienen.

### 4.3 D-02 — Relación semillas → tokens (documentada, sin alterar render)

| Capa | Contenido | Fuente |
|---|---|---|
| Semillas de marca (prosa) | `#243B35` · `#D5A45D` · `#647D75` · `#F5F1E8` = `overridePrimary/Secondary/Tertiary/NeutralColor` + `customColor #243b35` | `designTheme` del proyecto |
| Sistema dinámico | `colorVariant: FIDELITY` → genera los roles M3 | API de Stitch (documentación del campo: *seed color for the dynamic color system*) |
| Roles derivados | bloque `colors:` del `designMd`: **47 roles, 38 hex únicos** (p. ej. `primary #0e2520`, `secondary #7e5717`, `surface #fdf9f0`, `primary-container #243b35`) | `05` §3.1 |
| Uso real | 38/38 hex de los roles aparecen en los 62 HTML; divergencias prosa↔render: texto `#263238` **0 usos** vs token `#1c1c16` **122**; lienzo `#f5f1e8` 10 vs `#fdf9f0` 193 | `05` §3.1 |

**Queda pendiente (contrato):** (i) corregir la prosa del `designMd` para que documente el mapeo semilla→rol — preparado como `S-1` en `14`; (ii) congelar los 47 roles como variables en FASE 2 (ítem `#7` de `04`). **No se modifica ningún color renderizado.**

### 4.4 D-11 — Coherencia de `08-modelo-dominio-api.md` con los 19 RF y los 9 flujos

Verificación hecha en FASE 1.6 (entidad/endpoint ⇄ RF ⇄ flujo):

- **Cubren sin conflicto:** RF-01…RF-09, RF-11…RF-19 y los flujos V-1…V-5, A-1…A-4 encuentran entidad o endpoint correspondiente (`places`, `routes`, `itinerarios`, `reviews`, `favorites`, `sync/batch`, `consents`, `privacy-requests`, `claims`, `admin/*`, `audit`).
- **Decisiones de FASE 1.6 que ya cierran preguntas internas de `08`:** `phone` sólo si SMS (D-06 → hoy **fuera**), `points`/`level` (D-10 → **fuera del MVP**), `Beacon.trigger` de 2.º plano (D-07 → **sólo primer plano**), email visible en moderación (D-12 → **no visible**).

**Hallazgos de coherencia (marcados, no corregidos):**

| ID | Hallazgo | Impacto | Tratamiento |
|---|---|---|---|
| **C-1** | RF-10 / flujo V-5: **no hay entidad ni endpoint** de preferencias de notificación ni suscripción push | La API no daría soporte a `H05M` | Añadir al contrato en FASE 2 (P-06) |
| **C-2** | La cola de moderación tiene pestaña **Reportes** (`ADM-13`, `ModerationItem.type=REPORT`) pero **no existe** endpoint público de creación de reportes ni entidad `Report` | Un flujo mostrado no es consumible | Añadir `POST /reports` + entidad, o documentar que los reportes entran por otro canal (P-06) |
| **C-3** | Ruta de itinerarios en **español** (`POST /itinerarios`) frente al resto en inglés (`/places`, `/reviews`) | Inconsistencia de contrato | Unificar idioma de rutas al cerrar `08` (P-06) |
| **C-4** | RF-19: hay endpoint `GET /admin/metrics` pero **no está modelada** la entidad que produce las métricas | Métricas sin origen de dato | Definir con A9 (P-15) |
| **C-5** | `08` §2 aún lista como indeterminado lo que D-06/D-07/D-10/D-12 ya decidieron | Desactualización parcial | Actualizar `08` al aprobar P-06 |
| **C-6** | `08` §7.2 (motor/esquema) depende de B1–B8 | Bloqueante conocido | P-01/P-03 |
| **C-7** | `08` §7.6 (**retención y anonimización**) no está cubierta por ninguna D-01…D-15 | Nueva decisión real | **P-07** |

**Enumeración explícita de las 7 preguntas abiertas de `08` §7 (exigido por FASE 1.6):**

| # | Pregunta de `08` §7 | Estado tras FASE 1.6 | Dónde se resuelve |
|---|---|---|---|
| 1 | ¿Este modelo como base o se revisa? (REQ-DATA-01) | **ADOPTADA-COND** como base provisional (D-11) | P-06 |
| 2 | ¿Motor y esquema de almacenamiento? (B1–B8) | **PROPUESTA-PROV** en `12` §4.4 | P-03 |
| 3 | ¿OTP por correo o SMS (A3)? | **ADOPTADA**: correo (D-06); SMS = ampliación | cerrada (contrato: P-04) |
| 4 | ¿Se implementa gamificación (A16)? | **ADOPTADA**: no en MVP (D-10) | cerrada |
| 5 | ¿Alcance real de balizas/geofencing (A14)? | **ADOPTADA**: primer plano (D-07) | cerrada |
| 6 | ¿Retención y anonimización de reseñas/reportes y telemetría? | **ABIERTA** (nueva) | **P-07** |
| 7 | ¿Se conserva el email del autor visible en moderación (R2)? | **ADOPTADA**: no visible (D-12) | cerrada (auditoría en FASE 2) |

### 4.5 D-13 — Criterios propuestos para "coordenadas sensibles" (propuesta, no regla)

1. Documentar primero **qué** debe protegerse (p. ej. sitios rituales o de residentes, según `H04M` y `ADM-13`), sin listar categorías como si fueran definitivas.
2. Proponer **máscara de precisión configurable por lugar** (mostrar coordenada redondeada en vez de suprimir) como mecanismo genérico — coherente con la minimización ya declarada en `H06M`.
3. Validar criterios con **comunidad local y responsables del producto** antes de cualquier detección automática (`ADM-13` "Reglas AI" queda congelada hasta entonces).
4. Toda ocultación automática, si algún día existe, debe ser **revisable y auditable**.

> Estado: PROPUESTA-PROV. **No es una regla de negocio aprobada.**

### 4.6 D-14 — Criterios de comparación de proveedores

Usados en `12-comparativa-stack.md`: encaje con el requisito · límite de uso y coste marginal · atribución y licencia (p. ej. ODbL de OSM) · datos personales y transferencias internacionales · portabilidad/migración (posibilidad de cambiar sin reescribir) · calidad de la capa gratuita para desarrollo · reversibilidad (qué cuesta marcharse).

---

## 5. Preguntas abiertas consolidadas

> Cada pregunta lleva: **ID · pregunta · evidencia · alternativas · recomendación · consecuencia de posponerla · qué bloquea**.
> **No se repiten** las ya respondidas por D-01…D-15 (véase §7).
> **FASE 1.7 (2026-10-10):** P-01…P-08 tienen ya estado registrado bajo cada pregunta y se consolidan en §9; P-09…P-24 siguen abiertas.

### 5.1 Prioridad 1 — stack, API, modelo de datos, autenticación, permisos, mapas, alcance del MVP

#### P-01 — Stack combinado (B1 + B2 + B3)
- **Pregunta:** ¿Se aprueba la combinación recomendada en `12-comparativa-stack.md` (frontend React + TypeScript + Vite · backend Node.js + TypeScript · PostgreSQL + PostGIS · despliegue gestionado) como stack del MVP?
- **Evidencia:** `03` §3 (ninguna decisión de stack cerrada), `08` §2.1, `12` §4.
- **Alternativas:** (a) la recomendada · (b) combinación con backend Python (FastAPI) u otro lenguaje · (c) posponer hasta tener datos de uso.
- **Recomendación:** **(a)**: un solo lenguaje (TS) para cliente y API, ecosistema MapLibre/PWA maduro, PostGIS cubre RF-01; (b) sólo si tu equipo domina otro lenguaje — dímelo y rehago la comparativa.
- **Consecuencia de posponerla:** FASE 2 no puede empezar (no hay scaffolding posible sin elegir).
- **Bloquea:** **implementación** (y con ella el modelo físico de `08`).
- **Estado (ALINEACIÓN DEFINITIVA 2026-10-10): ADOPTADA** — stack definitivo: **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre**. Versiones verificadas compatibles (Laravel 13 PHP 8.3+, Filament 5, Inertia 3, Tailwind 4). Desarrollo **local** en Mac (sin infraestructura adicional). Alojamiento de producción: **IONOS** (evaluar posteriormente, no verificado). SSR de Inertia como estrategia SEO preferente. Detalle: `Plan_Maestro` §4/§5, `20` §4.

#### P-02 — Proveedor de mapas y teselas (B4)
- **Pregunta:** ¿Qué proveedor de tiles usamos tras el periodo de desarrollo gratuito?
- **Evidencia:** `designMd` cita **MapLibre**; `10` §1 (precios secundarios, a reverificar); RF-01/RF-04; paquetes offline de 148 MB (`E01`).
- **Alternativas:** MapTiler (Free 5 k sesiones/mes, Flex 30 US$/mes con 25 k) · Mapbox (50 k cargas gratis, después ~5 US$/1 k) · Stadia Maps (créditos mensuales, desde 20 US$/mes) · Protomaps/OSM autoalojado (sin cuota, más operación) · Google Maps (caro y con atadura fuerte).
- **Recomendación:** **cliente MapLibre** (ya citado por el diseño) + **MapTiler Free durante desarrollo**, decisión de pago sólo con métricas reales; valorar Protomaps si el offline pesado se confirma.
- **Consecuencia de posponerla:** el mapa puede desarrollarse con la capa gratuita; se bloquea la estimación de costes y la estrategia offline de tiles.
- **Bloquea:** **implementación** (no el diseño ni la arquitectura, gracias al desacople de D-14).
- **Estado (FASE 1.7): PARCIAL** — **MapLibre ADOPTADO** como motor; **proveedor de teselas PENDIENTE DE APROBACIÓN**: comparativa final con fuentes y fecha (2026-10-10) en `15` §2 (MapTiler · Mapbox · Stadia · Protomaps · OSM comunitario). MapTiler sólo **candidato a desarrollo** (advertencia: sus planes gratis son no comerciales). **Sin cuentas ni claves creadas.**

#### P-03 — Persistencia y despliegue (B2 + B3)
- **Pregunta:** ¿Base de datos y hosting gestionados o autoalojados?
- **Evidencia:** `08` §2.1 (motor indeterminado), RF-01 (consultas espaciales), RF-09 (offline), `12` §4.5/§4.16.
- **Alternativas:** Postgres+PostGIS gestionado (Neon/Supabase/RDS) · VPS autoalojado (Docker) · servidorless. **Costes:** planes gratuitos con límites pequeños (Supabase Free 500 MB, Neon Free con pausa en reposo) desde 0 US$/mes; planes de entrada ~19–25 US$/mes; VPS ≈ 4–10 US$/mes (estimación 2026, a reverificar).
- **Recomendación:** **Postgres+PostGIS gestionado** para MVP (copias, restauración y escalado sin operación propia); migrar a VPS propio sólo si el coste o la residencia de datos lo exigen.
- **Consecuencia de posponerla:** no hay esquema físico ni entorno de desarrollo.
- **Bloquea:** **implementación** y parte del modelo (`08` §2.1).
- **Estado (ALINEACIÓN DEFINITIVA 2026-10-10): ADOPTADA (motor)** — **PostgreSQL con PostGIS** desde el entorno de desarrollo local. Necesidades geoespaciales (proximidad, geometrías, índices espaciales, corredores de ruta) cubiertas por PostGIS. **No se propone MySQL como base principal ni migración desde MySQL.** El proveedor de alojamiento/BD gestionada de producción se **evaluará posteriormente con IONOS** (sub-decisión pendiente, no verificada). Detalle: `Plan_Maestro` §4/§5.

#### P-04 — Autenticación: contrato OTP y proveedor de email (B5 + D-06)
- **Pregunta:** Además del canal ya decidido (correo), ¿se aprueba el contrato OTP (expiración, reintentos, límite por IP/cuenta, anti-abuso, recuperación de contraseña, errores) y el proveedor de email transaccional?
- **Evidencia:** `B07M`, `07&08` (OTP por correo), `B08M` (SMS sólo como ampliación), `08` R1 (enumeración), RF-08, `10` §2.
- **Alternativas:** proveedor de email transaccional (Resend/Postmark/SendGrid/SES, planes con volumen inicial gratuito) · SMTP propio (más operación y deliverabilidad) · SMS posterior (≈0,011 US$/mensaje + 5–7 US$/mes fijos, `10` §2).
- **Recomendación:** **email transaccional con plan gratuito**, contrato OTP documentado en FASE 2 antes de código; SMS fuera del MVP (D-06).
- **Consecuencia de posponerla:** RF-08 no puede implementarse; el registro y la recuperación de contraseña quedan bloqueados.
- **Bloquea:** **implementación** (autenticación).
- **Estado (ALINEACIÓN DEFINITIVA 2026-10-10): ADOPTADA (flujo definido)** — OTP numérico de 6 dígitos enviado por correo **solo durante el registro** (no en cada login, no enlace como flujo principal). Cuenta pendiente de verificación hasta validar. Propuestas: caducidad 10 min, 5 intentos, cooldown 60 s. Envío por **SMTP con cuenta de Google dedicada** (credenciales en env vars; capturador de correos en local). **No es 2FA para cada inicio de sesión.** Recuperación de contraseña y login con Google: fuera de alcance hasta que se autorice. Detalle: `16`.

#### P-05 — Permisos RBAC: matriz por acción (A13 / D-09)
- **Pregunta:** ¿Se aprueba el modelo `Explorador + 3 niveles internos` con la propuesta de permisos por acción de §4.2, para cerrar la matriz 15 × 3?
- **Evidencia:** `ADM-18` (15 permisos, 5 grupos), `ADM-10` (contadores), `07&08` (comité), `08` §3.
- **Alternativas:** (a) modelo de §4.2 · (b) 3 tiers sin rol Explorador · (c) añadir un cuarto nivel interno · (d) comité como rol.
- **Recomendación:** **(a)**, previa lectura campo a campo de `ADM-18` (ítem `#27`) y decisión sobre el "comité de tres" (regla, no rol).
- **Consecuencia de posponerla:** la autorización (RF-15, A-4) y la moderación (RF-16, A-3) se implementarían con permisos inventados.
- **Bloquea:** **implementación** (autorización); no el diseño.
- **Estado (ALINEACIÓN DEFINITIVA 2026-10-10): ADOPTADA (Filament 5)** — panel administrativo con **Filament 5**; comparte auth/modelos/sesiones Laravel. La **matriz RBAC 15×4 se conserva** (no se inventan roles nuevos ni se reducen permisos). Autorización en servidor vía políticas/Gates/middleware. Detalle: `17`.

#### P-06 — Base de datos de dominio: aprobación de `08` con ajustes C-1…C-5 (REQ-DATA-01 / D-11)
- **Pregunta:** ¿Se aprueba `08-modelo-dominio-api.md` como base provisional con los ajustes de coherencia C-1 (notificaciones), C-2 (reportes), C-3 (idioma de rutas), C-4 (métricas) y C-5 (actualización por D-06/07/10/12)?
- **Evidencia:** §4.4 de este documento; `08` completo.
- **Alternativas:** (a) aprobar con ajustes · (b) revisar antes (indica qué) · (c) redefinir.
- **Recomendación:** **(a)**: el modelo ya está marcando lo derivable de lo indeterminado; los 5 ajustes son aditivos y de coherencia, no cambian el enfoque.
- **Consecuencia de posponerla:** ninguna migración ni contrato de API puede redactarse; crece el riesgo R10.
- **Bloquea:** **implementación** (API y esquema) — es la aprobación de una **base provisional**, no de un contrato de producción.
- **Estado (FASE 1.7): APROBADA COMO BASE PROVISIONAL CON CONDICIONES** — ajustes **C-1…C-5 aplicados** en `08` (C-1 notificaciones, C-2 reportes, C-3 idioma de rutas, C-4 anotado → P-15, C-5 actualización por D-06/07/10/12); §7 de `08` queda con estado por pregunta. **No autoriza** migraciones, contratos definitivos ni endpoints funcionales. C-6 → P-03; C-7 → P-07/`18`.

#### P-07 — Retención y anonimización de datos (08 §7.6)
- **Pregunta:** ¿Cuánto tiempo se conservan reseñas, reportes, telemetría y medios, y qué se anonimiza en lugar de borrarse?
- **Evidencia:** `08` §7.6 y §2.3; `H06M` (borrado local), RF-11; obligaciones legales en `10` §7 (Libro de Reclamaciones: conservación 2 años citada como fuente secundaria).
- **Alternativas:** (a) retención mínima operativa + borrado a solicitud · (b) plazos fijos por tipo de dato · (c) indefinido con anonimización para métricas.
- **Recomendación:** **(a)** para MVP, con la revisión de un asesor legal para lo que sea obligación (reclamaciones, consentimientos) — no fijar plazos por cuenta propia.
- **Consecuencia de posponerla:** la política de privacidad y el esquema (campos de purga) quedan sin definir.
- **Bloquea:** **publicación** y diseño de datos (no el desarrollo temprano).
- **Estado (FASE 1.7): PROPUESTA ENTREGADA SIN PLAZOS → PENDIENTE DE APROBACIÓN + VERIFICACIÓN JURÍDICA** — `18-politica-retencion-anonimizacion.md` clasifica 11 categorías con finalidad, acceso, retención **POR DEFINIR**, tratamiento y consecuencias; 6 puntos marcados [JURÍDICO] (P-17…P-20). **Ningún plazo aprobado ni inventado.**

#### P-08 — Aprobación del alcance del MVP (`13-alcance-mvp.md`)
- **Pregunta:** ¿Se aprueba el reparto incluido/excluido/condicional del MVP propuesto en `13`?
- **Evidencia:** `13`; decisiones D-01…D-15; huecos de `02` §B y `06` §4.
- **Alternativas:** (a) aprobar · (b) mover alguna ampliación al MVP · (c) recortar más.
- **Recomendación:** **(a)**: incluye todo lo trazable a RF con pantalla y deja fuera lo decidido en D-07/D-10 y lo que depende de asesoramiento (D-15).
- **Consecuencia de posponerla:** el plan de FASE 2 (paso S-10) no puede fijar su alcance; riesgo de arrastrar ambigüedades al código.
- **Bloquea:** **implementación y publicación**.
- **Estado (FASE 1.7): ACEPTADA COMO PROPUESTA DE PLANIFICACIÓN (provisional)** — `13` sirve para planificar FASE 2, **no es especificación definitiva**. Revisión SEO híbrido/offline/permisos/moderación/costes externos/funciones sin diseño en `15` §7. **Cambios de alcance, si los hubiera, se presentan antes de considerarse aprobados** (ninguno propuesto en FASE 1.7).

### 5.2 Prioridad 2 — diseño, navegación, contenido

| ID | Pregunta | Evidencia | Alternativas | Recomendación | Si se pospone | Bloquea |
|---|---|---|---|---|---|---|
| **P-09** (E1–E3) | ¿Se confirman las 3 excepciones de la navegación (Buscar como destino, Perfil dentro de Ajustes, destino "Guías")? | §4.1; `09` A11; D-05 | Confirmar todas / ajustar una a una | Confirmar **(a)** de E1 + Perfil en Ajustes + Guías→Rutas si confirmas su significado | La bottom-nav unificada (`S-7`) no puede redactarse | Diseño |
| **P-10** (A6) | ¿Se requiere modo oscuro? | `colorMode: LIGHT` único; `02` REQ-DARK-01 = SIN | Sí / No / postergado a FASE 3 | **No en MVP** (no hay evidencia de requisito), dejar previsto en tokens | El design system debe dejar la puerta abierta | Diseño |
| **P-11** (A5) | ¿Se diseñan variantes desktop de `H*`, `G*`, `F*`, `A*` y móvil de consola ADM? | `02` §cobertura | Diseñar ahora / sólo tablet (D-04) / fuera de alcance | Sólo lo que el alcance MVP exija (ver `13`) | Huecos de cobertura conocidos | Diseño / implementación |
| **P-12** (huecos `06` §4) | ¿Se diseñan perfil de usuario y detalle de ruta móvil? | `06` §4.2/§4.4; RF-08 menciona recuperación de contraseña | Sí / no / uno de los dos | Recuperación de contraseña **sí** (la exige RF-08 y el enlace existe en `B02M`); **perfil** requiere tu decisión porque no tiene RF | Quedan pantallas `SIN` | Diseño |
| **P-13** (A8) | ¿Existe "constructor de itinerarios"? | `designMd` capa 3; `F04`, `06M`; RF-06 `[ABI]` | Sí concreto / no (sólo añadir paradas) | **No constructor complejo** en MVP: crear itinerario y añadir paradas, como muestra `06M` | RF-06 queda ambiguo | Diseño / implementación |
| **P-14** (A4) | ¿Catálogo de idiomas y si la toponimia es dato por lugar? | `H02M` (Español/Quechua), `08` §2.7 | Sólo UI / UI + topónimos por lugar / multiidioma completo | **UI es-PE + quechua y topónimos por lugar** (ya hay campo `toponymOriginal` en `08`) | i18n y `08` quedan abiertos | Modelo / diseño |
| **P-15** (A9) | Reglas de patrocinios (etiquetado, tope, ordenación) y origen de "capacidad de carga" (1.000 / 84%) | `ADM-12`, `ADM-17`, `E01` badges | Definir reglas / MVP con badges fijos sin reglas | **Badges manuales en admin sin algoritmo de ordenación** hasta que definas reglas | RF-18/RF-19 siguen `[ABI]` | Implementación |
| **P-16** (A12 / D-08) | Mientras se miden los tiempos, ¿qué copy publicamos en `G10M`/`07&08`? | 4 cifras incompatibles | (a) borrar la promesa y mostrar espera real (`ADM-13`) · (b) fijar 24 h ya · (c) dejar cifras actuales | **(a)**: es lo único compatible con D-08 sin esperar métricas | Las pantallas mantienen promesas incumplibles | Diseño / publicación |

### 5.3 Prioridad 3 — legal, comunidad y operaciones

| ID | Pregunta | Evidencia | Recomendación | Quién resuelve | Bloquea |
|---|---|---|---|---|---|
| **P-17** (A15) | Plazo ARCO: 10 días (`H07M`) vs 20 (fuentes Ley 29733) | `10` §7 | No publicar plazo hasta dictamen; corregir copy después | Asesoría legal | Publicación de `H07M` |
| **P-18** (L-CLAIM) | ¿Libro de Reclamaciones real o informativo? y datos reales del operador (RUC/domicilio ficticios) | `H08M`, `10` §7 | Decidir con asesoría; **nunca RUC inventado** | Asesoría legal + usuario | Publicación de `H08M` |
| **P-19** | Procedimiento de incidentes (fuentes citan 48 h) | `10` §7 | Redactarlo con asesoría antes de producción | Asesoría legal + técnico | Publicación |
| **P-20** | Textos legales de `H04M`, `H06M`, `H07M`, `H08M` y consentimientos | `10` §6/§7 | Validación especializada obligatoria | Asesoría legal | Publicación |
| **P-21** (DATA-3) | Criterios de "coordenadas sensibles" con la comunidad | `ADM-13`, `H04M`, §4.5 | Validar criterios (§4.5) antes de cualquier regla automática | Comunidad + usuario | Moderación automática |
| **P-22** (A4/`H04M`) | Salvaguarda cultural y toponimia: ¿marco normativo o consulta a comunidad? | `10` §7 | Consulta a comunidad + asesoría | Comunidad + asesoría | Publicación de `H04M` |
| **P-23** | Preservación de la evidencia de FASE 1.5 (carpeta temporal de capturas y HTML) | ruta temporal del sistema | Copiarla a una ruta estable **fuera** de `docs/analisis/`; opciones A (externa, ≈63 MB, recomendada) y B (en el repo, +63 MB) en `19` §5 y `15` §8 — **sin copia ejecutada** | Usuario (autorización: opción A o B) | Nada de implementación; sí la trazabilidad futura |
| **P-24** | Ejecución de las correcciones Stitch preparadas (`S-0`…`S-8` de `14`) | §2 de este prompt; `14` | En FASE 1.7 se agruparon en **lotes L-0…L-5** (`15` §9, `14` §2.2 con impacto); **nada ejecutado**; la edición **in-place** sigue sin autorizarse | Usuario (autorización lote a lote) | Diseño (mejora), no implementación |

---

## 6. Responsables de validación

| Responsable | Preguntas |
|---|---|
| **Usuario (producto)** | P-01…P-06, P-08…P-16, P-23, P-24 |
| **Asesoría legal (Perú)** | P-07 (en parte), P-17…P-20, P-22 |
| **Comunidad local / curadores** | P-21, P-22 (toponimia) |
| **Operaciones / equipo técnico** | D-08 (métricas de SLA), P-19 (incidentes), copias y observabilidad de `14` |
| **Diseño** | E1–E3, P-10…P-12, D-04 (tablet) |
| **Auditoría externa (FASE 2)** | accesibilidad y seguridad (`#66` de `04`) |

---

## 7. Lo que ya está respondido (no volver a preguntar)

- **C1** → D-02 · **C3** → D-01 · **C4/A1** → D-03 · **C2 (alcance)** → D-04 · **A11 (base)** → D-05 · **A3 (canal)** → D-06 · **A14** → D-07 · **A12 (criterio)** → D-08 · **A13 (base)** → D-09 · **A16** → D-10 · **REQ-DATA-01 (base)** → D-11 · **DATA-2** → D-12 · **DATA-3 (método)** → D-13 · **método de proveedores** → D-14 · **alcance legal** → D-15 · **CONTENT-1** y **diseño de estados de búsqueda/carga/error** → autorización FASE 1.6 §2.
- Ninguna de ellas está "aprobada como contrato": todas conservan el pendiente indicado en §2.

---

## 8. Correcciones en Stitch

> El registro por pantalla (ID, estado original, problema detectado, cambio propuesto, impacto y reversibilidad) está en `14-plan-fase-2.md`, pasos **S-0…S-8**, agrupados en FASE 1.7 en los **lotes L-0…L-5** para tu autorización explícita (`15` §9). **No se ha editado Stitch en FASE 1.6 ni en FASE 1.7**; la edición in-place sigue sin autorizarse. Inspección de solo lectura (2026-10-10): `list_screens` = 62 pantallas intactas (32 móviles, 29 escritorio, 1 logotipo).

---

## 9. Registro de FASE 1.7 (2026-10-10)

> **Alcance:** sólo documentación en `docs/analisis/`. Sin código, Git, dependencias, migraciones, credenciales, servicios contratados, despliegues ni cambios en Stitch.
> **Nuevos estados usados:** **APROBADA COMO DIRECCIÓN** = aprueba la dirección técnica, no la implementación · **PROVISIONAL/PROPUESTA ENTREGADA** = entregada, esperando tu aprobación · **PENDIENTE DE VERIFICACIÓN** = requiere comprobación (ToS, jurídico, métricas).

### 9.1 Decisiones recibidas y su efecto

| P | Decisión del usuario (resumen literal) | Estado registrado | Efecto documental |
|---|---|---|---|
| P-01 | Aprueba React+TS+Vite · Node+TS · REST+OpenAPI · PostgreSQL+PostGIS · Vitest/Playwright/axe-core; sin instalar nada; SSR vs prerender pendiente | **APROBADA COMO DIRECCIÓN** (+ residual pendiente) | `12` actualizado · `15` §1 · `09` B1–B2 |
| P-02 | MapLibre como motor; proveedor sin cerrar; comparar 4 alternativas; MapTiler sólo candidato a desarrollo; sin cuentas/claves | **PARCIAL: motor adoptado; proveedor PENDIENTE DE APROBACIÓN** | `15` §2 (comparativa final con fuentes y fecha) · `12` §4.7 |
| P-03 | Preferencia inicial gestionado; comparar con VPS; sin contratar ni desplegar | **PREFERENCIA REGISTRADA + comparativa entregada → PENDIENTE DE APROBACIÓN** | `15` §3 · `12` §4.4 |
| P-04 | Correo como OTP inicial adoptado; implementación desacoplable; especificar antes de desarrollar; comparar proveedores | **CANAL ADOPTADO + especificación entregada → PENDIENTE DE APROBACIÓN** | `16` completo · `10` §2 |
| P-05 | Explorador + 3 niveles aceptado como dirección provisional; 15×3 y comité NO aprobados; revisar permiso a permiso | **PRINCIPIO ADOPTADO + matriz propuesta → PENDIENTE DE APROBACIÓN** | `17` completo (`#27` de `04` cerrado) · `08` §3 |
| P-06 | Aprueba `08` como base provisional sujeto a C-1…C-5 y preguntas abiertas; comprobar coherencia; sin migraciones/contratos/endpoints | **APROBADA COMO BASE PROVISIONAL CON CONDICIONES** | `08` ajustado (C-1…C-5) · `04` `#77` |
| P-07 | No aprueba plazos; preparar política que clasifique datos sin plazos inventados; marcar validación jurídica | **PROPUESTA ENTREGADA SIN PLAZOS → PENDIENTE DE APROBACIÓN + JURÍDICO** | `18` completo |
| P-08 | Acepta `13` como propuesta de alcance para planificación, NO especificación definitiva; revisar SEO, offline, permisos, moderación, costes y funciones sin diseños | **ACEPTADA COMO PROPUESTA DE PLANIFICACIÓN (provisional)** | `13` (estado) · `15` §7 |

### 9.2 Entregables y verificaciones de FASE 1.7

| Artefacto | Contenido |
|---|---|
| `15-fase-1-7-informe.md` | Informe con los 10 apartados exigidos |
| `16-especificacion-otp-autenticacion.md` | Contrato OTP propuesto + comparativa de email (fuentes 2026-10-10) |
| `17-matriz-rbac-propuesta.md` | Matriz 15×4, acciones administrativas, RS-1…RS-9, R-B1…R-B10 |
| `18-politica-retencion-anonimizacion.md` | 11 categorías, sin plazos inventados, 6 puntos [JURÍDICO] |
| `19-inventario-evidencia-fase1-5.md` | Evidencia verificada (124 archivos + extras, ≈63 MB) e inventario PNG/HTML ↔ ID Stitch |
| Verificaciones | Evidencia 62 PNG + 62 HTML completas · inventario 62/62 parejas · `list_screens` = 62 pantallas intactas · árbol del proyecto sólo contiene `docs/` · `APR = 0` en `02` · `08` §7 con estado por pregunta |

> **Nada de FASE 1.7 equivale a aprobación de implementación.** Las decisiones de §9.1 fijan dirección y documentación; los contratos (OTP, RBAC, retención), los proveedores, los lotes de Stitch y la copia de evidencia esperan tu respuesta explícita (§10 de `15`).

---

## 10. Alineación definitiva (2026-10-10) — decisiones resueltas por encargo explícito

> **Origen:** instrucciones explícitas del responsable del proyecto (encargo de alineación definitiva). Se actualiza el estado de las decisiones afectadas conforme al sistema de estados de este documento. **No se marcó como aprobada ninguna decisión no cubierta por el encargo.**

| Decisión | Estado nuevo | Justificación |
|---|---|---|
| **P-01** (stack) | **ADOPTADA** | Stack definitivo: **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre**. Versiones verificadas compatibles (Laravel 13 PHP 8.3+, Filament 5, Inertia 3, Tailwind 4). Desarrollo local en Mac. |
| **P-03** (persistencia) | **ADOPTADA (motor)** | **PostgreSQL con PostGIS** desde desarrollo local. No MySQL como base principal ni migración desde MySQL. Proveedor de alojamiento/BD gestionada: **pendiente de evaluación con IONOS** (no verificado). |
| **P-04** (OTP) | **ADOPTADA (flujo)** | OTP 6 dígitos por correo **solo en registro** (no en cada login, no enlace). Cuenta pendiente hasta validar. 10 min / 5 intentos / 60 s (propuestas). **SMTP Google** (credenciales en env vars). No es 2FA por login. |
| **P-05** (RBAC) | **ADOPTADA (Filament 5)** | Panel admin con Filament 5; comparte auth/modelos/sesiones Laravel. Matriz 15×4 conservada (sin roles nuevos ni reducción). Autorización en servidor. |
| **P-02** (teselas) | **PENDIENTE** (sin cambio) | Permite pendiente hasta selección expresa del proveedor de mapas. |
| **P-07** (retención) | **PENDIENTE** (sin cambio) | Propuesta sin plazos; requiere aprobación + jurídico. |
| **P-08** (alcance) | **PENDIENTE** (sin cambio) | Propuesta de planificación; requiere confirmación como definitivo. |

### 10.1 Decisiones nuevas derivadas del encargo

| ID | Decisión | Estado |
|---|---|---|
| **D-16** | Estrategia SEO: Inertia + SSR como solución preferente; páginas públicas indexables (fichas de lugar/ruta) con título/meta dinámicos, canonical, Open Graph, Schema.org, sitemap, robots, hreflang es/en; áreas privadas (auth, admin Filament) no indexables | **ADOPTADA** (dirección) |
| **D-17** | Entorno de desarrollo: **local en Mac**, reproducible, sin infraestructura adicional. Docker opcional para PostgreSQL/PostGIS. Alojamiento producción: **IONOS** (evaluar posteriormente, no verificado) | **ADOPTADA** (dirección) |
| **D-18** | Correo transaccional: **SMTP con cuenta de Google dedicada**; credenciales en variables de entorno; capturador de correos en local para dev. Sin credenciales reales en archivos. Recuperación de contraseña y login Google: fuera de alcance hasta autorización | **ADOPTADA** (dirección) |

> **Trazabilidad:** la arquitectura objetivo (Laravel/Vue/Inertia/Filament/PostgreSQL) sustituye a la recomendación anterior con MySQL 8. Los documentos `12`, `Plan_Maestro` §4/§5 y `20` §4 se actualizan para reflejar PostgreSQL/PostGIS como base de datos adoptada. **Stitch intacto** (sin cambios de pantallas).
