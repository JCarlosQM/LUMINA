# LUMINA — Plan de FASE 2 (propuesto, NO ejecutado) (FASE 1.6 · actualizado en FASE 1.7)

> **Estado:** PROYECTO. Ningún paso de este plan se ha ejecutado (ni en FASE 1.6 ni en FASE 1.7). No hay código, dependencias, migraciones, credenciales ni despliegues en el repositorio (verificado 2026-10-10: sólo existe `docs/`).
> **Reglas:** pasos pequeños, verificables y reversibles · cada paso declara objetivo, archivos afectados, dependencias, resultado esperado, comprobaciones y criterio de aceptación · los pasos de implementación quedan **propuestos** · nada avanza sin el gate correspondiente (§6).
> **FASE 1.7:** P-01…P-08 tienen estado (`11` §9) y los pasos S-0…S-8 quedan **agrupados en lotes L-0…L-5** (§2.4) para tu autorización explícita; la **edición in-place** de diseños existentes sigue **sin autorizar**.
> **ALINEACIÓN DEFINITIVA (2026-10-10):** P-01/P-03/P-04/P-05 adoptadas (`11` §10); P-02, P-07, P-08 y P-09…P-24 pendientes. Gate G0 actualizado en §6.
> **ALINEACIÓN DEFINITIVA (2026-10-10):** stack adoptado **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01/P-03/P-05 ADOPTADAS). Desarrollo **local** en Mac; producción se evaluará con **IONOS** (P-03 motor resuelto; proveedor pendiente). Los pasos T/I/V se reinterpretan bajo este stack (ver `Plan_Maestro` §4/§5).

---

## 0. Convenciones

| Prefijo | Tipo | ¿Se ejecuta ya? |
|---|---|---|
| **D-n** | Cierre documental de decisiones (sólo `docs/analisis/`) | Sólo cuando tú respondas |
| **S-n** | Correcciones preparadas en Stitch (agrupadas en lotes L-0…L-5, §2.4) | **No**: requieren tu "sí" por lote (y la in-place sigue prohibida) |
| **T-n** | Preparación técnica (andamiaje del proyecto) | No — FASE 2 |
| **I-n** | Implementación por dominio | No — FASE 2 |
| **V-n** | Verificación y cierre | No — FASE 2 |

---

## 1. Fase 0 — Cierre documental (ejecutable con tus respuestas)

**D-1 · Registrar decisiones respondidas**
- **Objetivo:** pasar a `DECIDIDA` las filas que respondas en `11` §5 (empezando por P-01…P-08).
- **Archivos:** `09-decisiones-pendientes.md`, `11-decisiones-consolidadas.md`, `02-matriz-trazabilidad.md` (sólo estados afectados), `04-backlog.md`.
- **Dependencias:** tus respuestas.
- **Resultado esperado:** ningún estado `ABIERTA` que ya tenga respuesta; `APR` sigue en 0 salvo lo que apruebes explícitamente.
- **Comprobaciones:** recuento de estados en `09` §Resumen; búsqueda de IDs duplicados; que `02` no contradiga `11`.
- **Criterio de aceptación:** cada decisión con respuesta aparece con su estado nuevo y su fuente; ninguna recomendación figura como aprobada.
- **Reversibilidad:** alta (sólo texto, sin git aún).

**D-2 · Congelar el modelo provisional (tras P-06/P-07)**
- **Objetivo:** aplicar a `08-modelo-dominio-api.md` los ajustes C-1…C-5 de `11` §4.4 y marcar lo que D-06/07/10/12 ya resolvieron.
- **Archivos:** `08`, `11`, `04` (`#5`).
- **Dependencias:** P-06, P-07.
- **Resultado:** `08` sin preguntas superadas y con las restantes enlazadas a P-xx.
- **Comprobaciones:** cada RF-01…RF-19 y flujo V/A tiene endpoint o nota explícita.
- **Criterio de aceptación:** las 7 preguntas de `08` §7 quedan con estado y enlace a `11`.
- **Reversibilidad:** alta.

**D-3 · Actualizar backlog con FASE 1.6**
- **Objetivo:** mantener `04` coherente (hecho en FASE 1.6 §2 y §5; se itera con cada respuesta).
- **Archivos:** `04-backlog.md`.
- **Dependencias:** D-1.
- **Criterio de aceptación:** ítems `[DEC-USU]` resueltos marcados; ítems `[IMP]` con dependencias actualizadas; sin referencias rotas a `A10`/`S-x`.
- **Reversibilidad:** alta.

---

## 2. Correcciones preparadas en Stitch (S-0 … S-8)

### 2.1 Protocolo obligatorio (controlado y reversible)

1. **S-0 previo a todo:** exportar copia del estado actual: `designMd` íntegro (por `list_design_systems`), capturas PNG y HTML ya descargados, y este registro. La evidencia de FASE 1.5 está en una **ruta temporal** → necesita P-23 (copiarla a una ruta estable) antes de tocar nada.
2. **Registro por pantalla antes de editar:** ID de Stitch, estado original, problema detectado, cambio propuesto (tabla §2.2).
3. **Orden:** primero S-0/S-1 (documentación, sin efecto visual), después generaciones nuevas (S-3…S-5, S-8), al final ediciones de copy (S-6, S-7).
4. **Verificación entre pasos:** tras cada paso, `list_screens` + comprobación de que el recuento y los IDs originales siguen intactos; si algo cambia donde no debía, se detiene y se informa.
5. **No se hace** nada que exija inventar datos reales de lugares, plazos legales ni reglas de negocio.

### 2.2 Registro de cambios (ID · estado original · problema · cambio propuesto · reversibilidad)

| Paso | Lote | Objetos (ID Stitch o recurso) | Estado original | Problema detectado | Cambio propuesto | Impacto | Reversibilidad |
|---|---|---|---|---|---|---|---|
| **S-0** | **L-0** | Recurso `designMd` + 62 pantallas | Texto y capturas en repositorio/temp | La evidencia vive en una ruta temporal; sin copia, cualquier edición pierde la referencia | Archivar copia completa antes de editar (requiere **P-23**: opciones A/B en `15` §8) | **Ninguno** (sólo lectura/copia) | Alta (sólo lectura) |
| **S-1** | **L-1** | `designMd` (prosa `## Colors`) | Prosa declara `#243B35`, `#D5A45D`, `#647D75`, `#F5F1E8`, `#FFFFFF`, `#263238` | **C1**: contradice el bloque `colors:` (47 roles); `#263238` se usa 0 veces | Reescribir la prosa para documentar **semillas → roles** sin tocar valores (D-02). Texto preparado; requiere `update_design_system` (el asset tiene `version`) | **Bajo**: sólo documentación en Stitch, sin cambios visuales | Media: respaldar el `designMd` íntegro en S-0 |
| **S-2** | **L-1** | `designMd` (tokens de estado) | Sólo existe `error #ba1a1a`; en uso hay `#1b5e3a`, `#ba4e26`, `#b95835`… (53 hex sin token) | Falta documentación de tokens de estado ya presentes en los renders | **Declarar** tokens de estado (éxito/aviso/info) correspondientes a colores **ya usados**; no recolorear ninguna pantalla (D-02 prohíbe alterar renders) | **Bajo** (documentación) | Media (mismo asset) |
| **S-3** | **L-2** | Nuevas pantallas para `C01`, `C02M`, `D01`, `D02M`, `E01` (piloto) | **0 artefactos** en 768–1024 px (C2) | `designMd` exige panel tablet de 380 px; 1280 px no valida tablet (D-04) | Generar variantes tablet 768–1024 con `generate_variants`/`generate_screen_from_text` (`deviceType: TABLET`), **sin borrar** originales | **Medio**: 5 pantallas nuevas (el proyecto crece; nada existente cambia) | **Limitación MCP:** no existe `delete_screen`; una pantalla creada sólo puede retirarse manualmente en la UI de Stitch → generar de 1 en 1 y verificar |
| **S-4** | **L-3** | Nuevas pantallas de búsqueda | Sólo `C05M` (sin resultados) y campo vacío en `C01`/`C02M` | Hueco A2: no existen resultados, carga ni error (RF-02/V-1) | Crear 3–4 pantallas: resultados con contenido, carga, error de red (autorizado en §2) | **Medio**: pantallas nuevas | Igual que S-3 |
| **S-5** | **L-3** | Nuevas pantallas de consola | `ADM-03…ADM-09` sin estados de éxito/error; sin error genérico de servidor | Hueco A7 (RF-13/14, flujos A-1/A-2) | Crear estados de éxito, error de validación y error de servidor para CRUD (autorizado en §2) | **Medio**: pantallas nuevas | Igual que S-3 |
| **S-6** | **L-4** | `D01`/`G01M` vs `01`/`C01`; `H08M` | 318 vs 128 reseñas; fechas 2024/2025/2026; RUC y domicilio ficticios | CONTENT-1: incoherencia de muestra (L6) | Unificar números de muestra **marcándolos como demo**; en `H08M` usar marcadores visibles de "datos de ejemplo" sin inventar RUC real (el dato real depende de P-18) | **Bajo-medio**: copy en pantallas existentes (in-place) | Media (copy) |
| **S-7** | **L-5** | `G10M`, `07&08`, `ADM-13`, `09&10`, `12T`, `H05M`, `H01M`, bottom-navs de `01M&02`, `C02M`, `C05M`, `C10M`, `F01M`, `G05M` | 4 cifras de SLA; 3 modelos de roles; 5 bottom-nav; `H05M` promete 2.º plano; `H01M` muestra pts | A12 (D-08), A13 (D-09), A11 (D-05), A14 (D-07), A16 (D-10) | Copy alineado: sin SLA < 24 h (mostrar espera real), roles = Explorador + 3 niveles, nav unificada **si P-09 confirma**, notificaciones en primer plano, sin pts | **Alto**: copy y navegación en ~12 pantallas (in-place); afecta todos los flujos | **Requiere decisiones previas:** P-09 y confirmación de D-08/D-09 aplicados al copy |
| **S-8** | **L-3** | Nuevas pantallas con RF respaldado | Falta recuperación de contraseña (RF-08, enlace en `B02M`); falta detalle de ruta móvil (RF-04) | Flujos y estados faltantes con requisito ya documentado (autorizado en §2) | Crear esas 2 pantallas; **no** crear perfil de usuario sin P-12 | **Bajo**: 2 pantallas nuevas | Igual que S-3 |

> **Fuera de lo autorizado (no se hace):** separar lienzos combinados (`#53`), tocar plazos legales (A15), crear pantallas sin requisito (perfil si P-12 dice no), y cualquier borrado.

### 2.3 Pasos con sus seis campos

**S-0 · Preservar el estado actual** — *Dependencias:* P-23. *Resultado:* carpeta estable con `designMd`, 62 PNG, 62 HTML y este registro. *Comprobaciones:* recuento 62+62; `designMd` legible. *Criterio:* la evidencia ya no vive sólo en temp. *Reversibilidad:* total (sólo lectura).

**S-1 · Prosa de color** — *Dependencias:* S-0, D-02. *Archivos:* recurso `designMd` en Stitch. *Resultado:* prosa que explica semillas `#243B35/#D5A45D/#647D75/#F5F1E8` → 47 roles; sin cambios de valor. *Comprobaciones:* diff del `designMd`; capturas antes/después **idénticas** en color; 38/38 hex de roles intactos. *Criterio:* C1 documentada en la fuente y ningún render alterado. *Reversibilidad:* media (respaldo en S-0).

**S-2 · Tokens de estado declarados** — *Dependencias:* S-1. *Resultado:* documentación de tokens de estado para colores ya en uso. *Comprobaciones:* ningún hex de pantalla modificado; los tokens nuevos citan hex existentes. *Criterio:* `05` §5.1 pierde el matiz "sin tokens de estado" sin cambio visual. *Reversibilidad:* media.

**S-3 · Variantes tablet** — *Dependencias:* S-0, D-04, P-08 (alcance). *Archivos:* proyecto Stitch (pantallas nuevas). *Resultado:* piloto de 5 pantallas tablet 768–1024. *Comprobaciones:* ancho correcto de las nuevas; originales con su ID intacto; inventario `06` ampliado sin borrar filas. *Criterio:* existe al menos un artefacto 768–1024 para `C01` y `D01`. *Reversibilidad:* limitada (no hay `delete_screen` en MCP) → **se genera de 1 en 1 y se aprueba cada una**.

**S-4 · Estados de búsqueda** — *Dependencias:* S-0, autorización §2. *Resultado:* pantallas de resultados/carga/error. *Comprobaciones:* mismo design system; sin datos reales inventados (muestras marcadas). *Criterio:* RF-02 deja de estar `SIN` en `02`. *Reversibilidad:* limitada (misma nota).

**S-5 · Estados CRUD** — *Dependencias:* S-0, autorización §2. *Resultado:* éxito/error/validación para `ADM-03…09`. *Comprobaciones:* coherencia con máquina de estados de `08` §6.4. *Criterio:* A7 deja de estar `SIN`. *Reversibilidad:* limitada.

**S-6 · Contenido de muestra** — *Dependencias:* S-0, CONTENT-1 decidido. *Resultado:* cifras y fechas coherentes; `H08M` con marcadores de demo. *Comprobaciones:* grep de "318"/"128"/RUC tras el cambio. *Criterio:* sin contradicciones L6. *Reversibilidad:* media (copy).

**S-7 · Alineación de copy** — *Dependencias:* **P-09** (nav) + confirmación de aplicación de D-08/D-09/D-07/D-10 al copy. *Resultado:* SLA sin promesa < 24 h, roles unificados, nav unificada, `H05M` sin 2.º plano, sin pts. *Comprobaciones:* grep de "12 horas", "2 a 6 horas", "40 pts", "420 pts", "Nivel 4"; recuento de variantes de bottom-nav. *Criterio:* una sola cifra pública y una sola nav. *Reversibilidad:* media.

**S-8 · Pantallas faltantes con requisito** — *Dependencias:* S-0. *Resultado:* recuperación de contraseña y detalle de ruta móvil. *Comprobaciones:* trazabilidad RF-08/RF-04 en `02`. *Criterio:* huecos 2 y 4 de `06` §4 cerrados. *Reversibilidad:* limitada.

### 2.4 Lotes de autorización (FASE 1.7) — **nada autorizado todavía**

> Los pasos S-n quedan agrupados para que autorices **cada lote por separado**. Los lotes L-1, L-4 y L-5 contienen **edición in-place** de diseños existentes, que **sigue sin estar autorizada**; si algún día la autorizas, se ejecuta igualmente con registro previo y verificación posterior.

| Lote | Pasos | Naturaleza | Condición previa | Estado |
|---|---|---|---|---|
| **L-0** | S-0 | Sólo lectura (copia de evidencia) | **P-23** (elegir opción A o B de `15` §8) | No ejecutado |
| **L-1** | S-1, S-2 | In-place en `designMd` (asset versionado) | Autorización explícita de in-place | No autorizado |
| **L-2** | S-3 | Pantallas nuevas (tablet, piloto de 5) | Autorización del lote; generar 1 en 1 | No autorizado |
| **L-3** | S-4, S-5, S-8 | Pantallas nuevas con respaldo RF | Autorización del lote (sin perfil: P-12) | No autorizado |
| **L-4** | S-6 | In-place (copy de muestra; bloque legal con P-18) | Autorización de in-place + P-18 | No autorizado |
| **L-5** | S-7 | In-place (copy y navegación) | Autorización de in-place + **P-09** + **P-16** | No autorizado |

> **Inspección de solo lectura de FASE 1.7 (2026-10-10):** `list_screens` = **62 pantallas intactas** (32 móviles, 29 escritorio, 1 logotipo), idéntico al baseline de FASE 1.5.

---

## 3. Preparación técnica (T-1 … T-6) — PROPUESTA, NO EJECUTADA

**T-1 · Inicializar repositorio y guardrails**
- Objetivo: git, estructura de carpetas, `.env.example`, validación de entorno, CI básica (lint+test).
- Archivos: `README`, `.gitignore`, `.env.example`, `package.json` (o equivalente según P-01), `.github/workflows/ci.yml`.
- Dependencias: **P-01** (stack).
- Resultado: `npm run lint && npm run test` en verde con un test de humo.
- Comprobaciones: sin secretos en el árbol; CI pasa en rama de prueba.
- Criterio: T-2 sólo empieza con repo verde y decisiones D-1 aplicadas.
- Reversibilidad: alta (rama, sin producción).

**T-2 · Design tokens y componentes base**
- Objetivo: variables CSS desde el bloque `colors:` (47 roles) + semillas documentadas (D-02), tipografía Newsreader/Plus Jakarta, espaciado 8, radios, 4 elevaciones.
- Archivos: `tokens.css` (o equivalente), carpeta de componentes base.
- Dependencias: P-01, D-02.
- Resultado: componentes Button/Chip/Card/Input/Switch idénticos a `REQ-UI-06` en 390 y 1280.
- Comprobaciones: tests visuales en 3 anchos; contraste AA de los pares ya declarados en `designMd`.
- Criterio: `REQ-UI-05/06/07` pasan de DOC a verificado en código.
- Reversibilidad: alta.

**T-3 · Contrato de API y esquema**
- Objetivo: volcar `08` (ya ajustado en D-2) a OpenAPI + migraciones iniciales del esquema (sin datos).
- Archivos: `openapi.yaml`, `db/migrations/*`, módulos de entidades.
- Dependencias: D-2, P-03.
- Resultado: servidor con endpoints públicos de sólo lectura (`GET /places`, `GET /routes`) respondiendo con datos de ejemplo cargados por seed.
- Comprobaciones: tests de contrato; `bbox` y ordenación por distancia con PostGIS; migración aplicable y **reversible** en local.
- Criterio: RF-01/RF-03 consultables por API.
- Reversibilidad: alta (migraciones hacia atrás en local; nada en producción).

**T-4 · Autenticación y autorización**
- Objetivo: registro, login, OTP por correo con el contrato de D-06/P-04, RBAC por acción (P-05), auditoría encadenada.
- Archivos: módulos auth/rbac/audit, tests.
- Dependencias: P-04, P-05, T-3.
- Resultado: sesión + OTP limitado + 15 permisos verificados en servidor.
- Comprobaciones: tests negativos (403), rate limit (429), no enumeración (respuesta idéntica).
- Criterio: RF-08/RF-15 con evidencia de prueba; ninguna comprobación sólo en cliente.
- Reversibilidad: media (implica esquema de usuarios).

**T-5 · Mapa y exploración**
- Objetivo: shell SPA con MapLibre, capa de filtros y listado (M1).
- Archivos: módulo de mapa, cliente de tiles tras P-02.
- Dependencias: P-02, T-2, T-3.
- Resultado: `C01`/`C02M` reproducidos con datos reales de ejemplo.
- Comprobaciones: rendimiento en gama baja (presupuesto de carga), navegación sin recargar el mapa.
- Criterio: flujo V-1 hasta la ficha.
- Reversibilidad: alta (cliente desacoplado por D-14).

**T-6 · Offline y cola**
- Objetivo: Workbox + IndexedDB + `POST /sync/batch` idempotente (V-4).
- Archivos: SW, módulo outbox, endpoint `sync/batch`.
- Dependencias: T-3, T-4.
- Resultado: reseña enviada sin red se reenvía una sola vez.
- Comprobaciones: prueba con red cortada y reenvío doble; manejo de conflicto marcado.
- Criterio: RF-09 con evidencia; "cola ≠ publicado" visible (G05M).
- Reversibilidad: media.

---

## 4. Implementación por dominio (I-1 … I-5) — PROPUESTA, NO EJECUTADA

| Paso | Alcance | Pantallas/rutas | Dependencias | Criterio de aceptación |
|---|---|---|---|---|
| **I-1** | Visitante núcleo (M1–M4) | `01`, `C01`, `C02M`, `D01`, `D02M`, `E01`, `E03` | T-1…T-5, P-08 | V-1 y V-2 completos en 3 anchos |
| **I-2** | Cuenta y datos (M5–M8) | `B*`, `F*`, `G*`, `06M` | T-4, T-6, P-04 | V-3 y V-4 con offline |
| **I-3** | Ajustes, privacidad, PWA (M9–M11) | `A*`, `11M`, `H*` | T-2, D-07, P-17…P-20 | V-5 completo; sin copy ilegal |
| **I-4** | Consola admin (M13–M14) | `ADM-01…ADM-18` | T-3, T-4, P-05 | A-1…A-4 con RBAC y auditoría |
| **I-5** | Tablet (M12) | variantes S-3 + breakpoints | D-04, S-3 | 768–1024 real, panel 380 px |

> Cada `I-n` se descompone en tareas del `04-backlog.md` (`#11`…`#65`) con sus criterios ya escritos; **no se estima duración**.

---

## 5. Verificación y cierre (V-1 … V-5) — PROPUESTA

| Paso | Qué verifica | Herramienta | Criterio |
|---|---|---|---|
| **V-1** | Unidades de reglas de negocio | Vitest (o la elegida) | Verde en CI |
| **V-2** | Flujos V-1…V-5, A-1…A-4 | Playwright | Sin fallos en los 3 anchos |
| **V-3** | Regresión visual vs Stitch | Screenshots + evidencia de S-0 | Diferencias revisadas y aceptadas una a una |
| **V-4** | Accesibilidad y seguridad | axe-core + revisión manual + auditoría (`#66`) | Sin críticos/serios |
| **V-5** | Operación: copia, restauración, logs, secretos | Ejercicio de restauración | RPO/RTO acordados (P-19) documentados |

---

## 6. Gates: condiciones para avanzar

| Gate | Condición | Desbloquea | Estado (FASE 1.7) |
|---|---|---|---|
| **G0** | Respondidas P-01…P-08 (stack, tiles, BD, OTP, RBAC, modelo, retención, alcance) | T-1 | **Actualizado (alineación definitiva):** P-01/P-03/P-04/P-05 adoptadas; P-02 proveedor, P-07, P-08 y P-09…P-24 pendientes |
| **G1** | D-1 y D-2 aplicados en `docs/analisis/` sin estados contradictorios | T-2, T-3 | **D-2 aplicado** (C-1…C-5 en `08`); D-1 aplicado en lo respondido; sin contradicciones detectadas |
| **G2** | P-23 (evidencia archivada) y autorización explícita por cada paso S-x | Ejecución de S-1…S-8 | **No satisfecho:** sin copia (P-23) y sin autorización de lotes (P-24) |
| **G3** | S-3/S-4/S-5 verificadas (originales intactos) | I-1 (usa esos diseños) | No satisfecho (nada ejecutado) |
| **G4** | P-17…P-20 resueltos o decisión de publicar sin esas pantallas | I-3 y cualquier despliegue público | No satisfecho |
| **G5** | V-1…V-5 en verde + criterios de aceptación global de `13` §8 | Publicación / anuncio de MVP | No satisfecho |

### 6.1 Preparación de la FASE 2 (Alineación 2026-10-10) — sin sprints ejecutables

> Mientras las decisiones esenciales sigan pendientes, **no se crean sprints ejecutables**. Secuencia de preparación con criterios de entrada/salida:

| Paso | Actividad | Entrada | Salida | Bloquea |
|---|---|---|---|---|
| **P-01 (adoptado)** | Stack Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS | Decisión registrada en `11` §10 | Desarrollo local |
| **P-02 / P-03 proveedor** | Proveedor de teselas y producción IONOS (motor PostgreSQL adoptado) | P-01 | Proveedores registrados | Costes, offline, despliegue |
| **P-04 alcance / P-05 operación** | 2FA de consola y firma de exportación | `16`, `17` | Alcance decidido | Consola, auditoría |
| **P-07 / P-08** | Retención + alcance definitivo | `18`, `13` | Aprobados | Esquema, I-1…I-5 |
| **P-23 (redefinido)** | Regenerar evidencia desde Stitch | Tu autorización (P-24) | Nueva evidencia estable | V-3 |
| **P-24** | Autorizar lotes L-0…L-5 | P-23 + decisiones diseño | Lotes autorizados | Mejora diseño |

**Preparación del entorno (tras tu aprobación):** cuentas, dominio, DNS, certificados, secretos, CI/CD. **Nada de esto se ejecuta ahora.**

---

## 7. Qué NO se hace sin autorización explícita

1. Ejecutar cualquier paso S-x en Stitch (incluida la simple corrección de prosa).
2. Borrar, fusionar o renumerar pantallas de Stitch.
3. Instalar dependencias, crear repositorio git con historia, generar migraciones o desplegar (T/I/V).
4. Contratar servicios, crear credenciales o generar claves.
5. Modificar archivos fuera de `docs/analisis/` (incluida la evidencia temporal: requiere P-23).
6. Publicar copy legal, cifras de SLA o RUC/DNI reales o ficticios presentados como reales.
7. Avanzar a FASE 2 sin tu autorización explícita tras revisar este plan.
