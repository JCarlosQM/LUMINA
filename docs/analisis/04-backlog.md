# LUMINA — Backlog Revisado (FASE 1.5 · análisis — actualizado en FASE 1.6)

> **Tipos de ítem** (separados por naturaleza, no por urgencia):
> `[DEC-USU]` decisión que sólo el usuario puede tomar · `[DOC]` documentación a producir o confirmar · `[STI]` mejora **dentro de Stitch** (preparada; requiere autorización por paso) · `[IMP]` tarea de implementación futura (planificable, aún no aprobada).
> **No se estiman tiempos:** no hay requisitos aprobados ni stack elegido; cualquier estimación sería inventada.
> Los IDs `C1–C4`, `A1–A16` y `B1–B8` remiten a `09-decisiones-pendientes.md`; las preguntas consolidadas `P-01…P-24` a `11-decisiones-consolidadas.md`; los `REQ-*` a `02-matriz-trazabilidad.md`.
> Numeración original de FASE 1 conservada (`#1–#38`); los ítems nuevos continúan en `#39+` (FASE 1.5) y `#67+` (FASE 1.6).
> **Estado FASE 1.6:** las decisiones D-01…D-15 adoptadas se reflejan en la columna *Estado*; nada figura como "aprobado contractualmente".
> **Estado FASE 1.7 (2026-10-10):** los ítems afectados por P-01…P-08 llevan su actualización en la propia fila; se añaden `#78–#82` (aprobaciones pendientes). Sigue sin haber código, Git, dependencias ni cambios fuera de `docs/analisis/`.

---

## 1. Decisiones del usuario `[DEC-USU]`

| # | Ítem | Bloquea | Criterio de "hecho" | Estado (FASE 1.6) |
|---|---|---|---|---|
| 1 | **C3**: ¿set vigente, numerado o codificado? (recomendación: ambos, codificado como base) | Inventario, todas las pantallas, planificación | Respuesta única registrada en `09` | **ADOPTADA** (D-01) |
| 2 | **C1**: fuente canónica de color (recomendación: tokens + semillas, corregir prosa) | Design system, P1 | "Sí, tokens" escrito en `09` | **ADOPTADA** (D-02) — contrato de 47 roles pendiente (`#7`) |
| 4 | **A1/C4**: trato de lienzos combinados (recomendación: documentar nº de vistas) | Rutas y flujos | Decisión registrada | **ADOPTADA** (D-03) |
| 5 | **REQ-DATA-01**: ¿se aprueba `08-modelo-dominio-api.md` como base? | Todo el modelado de FASE 2 | "Aprobado/Revisado/Rechazado" | **ADOPTADA-COND** (D-11) → **FASE 1.7: P-06 APROBADA como base provisional** (C-1…C-5 aplicados); retención **P-07** (`18`) |
| 3 | **C2**: ¿se exige tablet 768–1024 con artefacto propio? | REQ-UI-03, responsive | Decisión + alcance | **ADOPTADA** (D-04) — diseño `S-3` |
| 40 | **A11**: navegación inferior (5 variantes) — `Explorar·Buscar·Rutas·Guardados·Ajustes` | Arbol de rutas | Elección única | **ADOPTADA-COND** (D-05) — excepciones **P-09** |
| 41 | **A3**: canal OTP (correo / SMS / ambos) | Auth, coste, `08-modelo` | Elección + proveedor | **ADOPTADA** (P-04: OTP 6 dígitos solo en registro; **SMTP Google**; `16`) |
| 42 | **A12**: SLA de moderación público (4 cifras incompatibles) | Copy de `G10M`/`07&08`, métricas ADM | Una cifra oficial | **ADOPTADA** (D-08: sin SLA < 24 h) — cifra **P-16** |
| 43 | **A13**: modelo de roles (3 tiers / 4 / comité) | RBAC, `08-modelo` | Modelo único | **ADOPTADA (Filament 5)** (P-05): matriz 15×4 conservada (`17`); autorización en servidor vía políticas/Gates/middleware |
| 44 | **A14**: balizas en segundo plano — ¿PWA en primer plano (recomendado) o app nativa? | RF-10, RF-04, alcance | Alcance decidido | **ADOPTADA** (D-07: primer plano) |
| 45 | **A16**: ¿se implementa gamificación? | `08-modelo`, esfuerzo | Sí/No | **ADOPTADA** (D-10: no en MVP) |
| 46 | **B1–B8**: stack, tiles, OTP, media, offline, analítica | P1 completo | Cada B respondido | **ALINEACIÓN DEFINITIVA:** B1/B2/B3 ADOPTADAS (P-01/P-03: Laravel 13 + Vue 3 + Inertia 3 + Filament 5 + PostgreSQL/PostGIS; local); B4 pendiente (P-02); B5 ADOPTADA (P-04: SMTP Google); B6–B8 siguen `PROPUESTA-PROV` |
| 47 | **DATA-2**: ¿se muestra el email del autor en moderación? | `08-modelo` R2 | Sí/No | **ADOPTADA** (D-12: no visible) |
| 48 | **CONTENT-1**: ¿se corrige el contenido de muestra antes de mostrar Stitch? | Reputación de la demo | Sí/No | **ADOPTADA** (autorización §2) — corrección `S-6` preparada |
| 67 | **P-09**: excepciones de navegación E1 (Buscar como destino), E2 (Perfil en Ajustes), E3 (etiqueta "Guías") | `S-7`, arbol de rutas | Confirmación de las 3 | **ABIERTA** |
| 68 | **P-07**: retención y anonimización de reseñas/reportes/telemetría (`08` §7.6) | Esquema, política de privacidad | Política escrita | **FASE 1.7:** propuesta entregada sin plazos (`18`) → pendiente de aprobación + jurídico |
| 69 | **P-10 / A6**: ¿modo oscuro? | Design system, `REQ-DARK-01` | Sí/No | **ABIERTA** |
| 70 | **P-11 / A5**: cobertura responsive restante (desktop de `H*`/`G*`/`F*`, móvil ADM) | `02` §cobertura | Lista de pantallas a crear | **ABIERTA** |
| 71 | **P-12**: ¿se diseña perfil de usuario (sin RF)? | `06` §4.4, `REQ-UX-01` | Sí/No | **ABIERTA** (recuperación de contraseña y detalle de ruta móvil: **autorizados** → `S-8`) |
| 72 | **P-13 / A8**: ¿constructor de itinerarios? | RF-06 | Sí/No + alcance | **ABIERTA** |
| 73 | **P-14 / A4**: catálogo de idiomas y topónimos por lugar | i18n, `08` | Lista de idiomas | **ABIERTA** |
| 74 | **P-15 / A9**: reglas de patrocinios y origen de "capacidad de carga" | RF-18, RF-19 | Reglas escritas | **ABIERTA** |
| 75 | **P-23**: preservar la evidencia de FASE 1.5 (está en ruta temporal) | Trazabilidad, regresión visual (`V-3`) | Copia en ruta estable | **ALINEACIÓN 2026-10-10: evidencia PERDIDA** (temporal limpiado; 0 archivos inspeccionados). Redefinido: regenerar capturas desde Stitch (intacto) — ver `20` §8/§9 |
| 76 | **P-24**: autorizar la ejecución de las correcciones `S-0…S-8` en Stitch | Diseño (`14` §2) | Sí por paso | **FASE 1.7:** agrupadas en lotes L-0…L-5 (`15` §9); in-place sigue prohibido; **nada ejecutado** → pendiente autorización por lote |

## 2. Documentación `[DOC]`

| # | Ítem | Referencia | Criterio de aceptación |
|---|---|---|---|
| 5 | Definir modelo de datos + contratos (base propuesta ya entregada) | `08-modelo` | §7 de ese documento con respuestas (tras **P-06**/**P-07**) |
| 12 | Definir estado de búsqueda **con resultados** (A2) | hueco | Ficha de resultados: campos, ordenación, filtros — **diseño autorizado** (`S-4`) |
| 18 | Alcance de "descubrimiento en movimiento": `04&05` vs `E06M` | — | Un flujo con pasos |
| 20 | ¿Existe "constructor de itinerarios"? (A8) | `designMd` §capa 3 | Sí/No + alcance (**P-13**) |
| 22 | Mecanismo de notificaciones y balizas (A14) | `H05M` | Comportamiento por plataforma documentado (**D-07 adoptada**: primer plano) |
| 23 | Catálogo de idiomas y toponimia (A4) | `H02M` | Lista de idiomas + si la toponimia es dato por lugar (**P-14**) |
| 27 | Roles y 15 permisos exactos del RBAC (A13) | `ADM-18` | Matriz permiso × rol aprobada | **FASE 1.7:** lectura campo a campo **HECHA** (cuadre "10 de 15" verificado); matriz propuesta en `17` → aprobación pendiente (**P-05**) |
| 31 | Modelo de rutas patrocinadas (A9) | `ADM-12` | Reglas de etiquetado y tope (**P-15**) |
| 32 | Definición de métricas y "capacidad de carga" (A9) | `ADM-17` | Origen del dato 1.000/84% (**P-15**) |
| 33 | Requisitos jurídicos de privacidad y salvaguarda cultural | `H04M` | Dictamen de asesoría `[ASES]` (**P-20**, **P-22**) |
| 35 | Flujo ARCO: plazo real (10 vs 20 días, A15), identidad, supresión vs portabilidad | `H07M` | Dictamen + copy aprobado `[ASES]` (**P-17**) |
| 36 | Libro de Reclamaciones: formato legal peruán y datos reales del operador | `H08M` | Dictamen + datos reales `[ASES]` (**P-18**) |
| 37 | ¿Se requiere modo oscuro? (A6) | `colorMode: LIGHT` | Sí/No (**P-10**) |
| 38 | Cobertura responsive faltante (A5): H\*/G\*/F\*/A\* sin desktop, ADM sin móvil | matriz §cobertura | Lista de pantallas a añadir (**P-11**) |
| 49 | **Nuevos huecos FASE 1.5**: perfil de usuario, recuperación de contraseña, detalle de ruta móvil, estados de éxito/error CRUD (A7) | `06` §4, `02` §B | ¿Se añaden o quedan fuera de alcance? → A7 y recuperación/detalle **autorizados** (`S-5`, `S-8`); **perfil pendiente** (P-12) |
| 50 | Política de conflictos offline y retención de datos | `08-modelo` §2 | Reglas escritas (retención: **P-07**) |
| 51 | Procedimiento de incidentes de seguridad (fuentes citan 48 h) | `10` §7 | Procedimiento `[ASES]` (**P-19**) |
| 77 | **D-2**: aplicar a `08` los ajustes de coherencia C-1…C-5 (notificaciones, reportes, idioma de rutas, métricas, D-06/07/10/12) | `11` §4.4 | `08` sin preguntas superadas; cada RF y flujo con endpoint o nota | **FASE 1.7: APLICADO** (P-06) — C-1, C-2, C-3 y C-5 aplicados; **C-4 anotado** (fuente de métricas → P-15); `08` §7 con estado por pregunta |
| 78 | **[DOC]** Contrato OTP: parámetros (10 min / 5 intentos / 60 s) y SMTP Google (`16` §3/§5) + 2FA/TOTP de consola (`16` §7) | T-4 (auth) | Flujo y transporte adoptados (P-04); 2FA de consola pendiente de alcance | **ADOPTADA (flujo)** (P-04) |
| 79 | **[DOC]** RBAC: matriz `17` (15×4, TIER 3, RS-1…RS-9) con Filament 5 | I-4, T-4 | Matriz conservada; autorización en servidor | **ADOPTADA (Filament 5)** (P-05) |
| 80 | **[DOC]** Retención: resolver estructura `18` §2 + puntos [JURÍDICO] `18` §4 | Esquema de purga, privacidad | Política con plazos decididos por ti/legal | **PENDIENTE** (P-07 + P-17…P-20) |
| 81 | **[DOC]** SSR de Inertia (estrategia preferente, D-16) | SEO, despliegue, rutas públicas | Servidor SSR configurado; HTML inspeccionable en staging | **ADOPTADA (dirección)** (P-01/D-16; ejecución por comprobar) |
| 82 | **[DOC]** Proveedor de teselas (P-02) y producción IONOS (P-03 proveedor) con fuentes 2026-10-10 (`15` §2/§3) | Costes, offline, despliegue | Elección registrada | **PENDIENTE** (P-02, P-03 proveedor) |

## 3. Mejoras en Stitch `[STI]` — PREPARADAS, requieren tu autorización paso a paso

> El registro completo (ID de pantalla, estado original, problema, cambio propuesto, **impacto** y reversibilidad) vive en **`14-plan-fase-2.md` §2.2**, con los pasos agrupados en FASE 1.7 en los **lotes L-0…L-5** (resumen en `15` §9). **No se ha modificado Stitch; la edición in-place sigue sin autorizarse.**
> **Limitaciones MCP verificadas en FASE 1.6:** existe `edit_screens` (edición in-place, **sin** versionado ni deshacer por pantalla), `generate_screen_from_text` y `generate_variants` (creación de pantallas nuevas), `update_design_system` (el asset sí expone `version`); **no existe** `duplicate_screen` ni `delete_screen` → una pantalla creada no puede retirarse por MCP y una editada no se puede restaurar por MCP (sólo con la copia de `S-0`).

| # | Mejora | Paso | Por qué | Riesgo |
|---|---|---|---|---|
| 52 | Corregir la prosa de color del `designMd` para que documente el mapeo semilla→rol (C1) | **S-1** | Evita contradicción permanente en la fuente | Requiere `update_design_system` (asset versionado) |
| 53 | Separar los lienzos combinados en pantallas individuales (A1) | **no ejecutar** | **D-03 decide conservarlos** | — |
| 54 | Añadir variantes 768–1024 (panel 380 px) | **S-3** | Cierra C2/REQ-UI-03 | Pantallas nuevas sin `delete_screen` |
| 55 | Unificar bottom-nav (A11) en todas las móviles | **S-7** | Elimina 5 modelos contradictorios | Depende de **P-09** |
| 56 | Declarar tokens de estado (éxito/aviso/info) y documentar los ~53 hex sin token | **S-2** | Cierra hueco del design system sin alterar renders | Sólo documentación de colores ya usados |
| 57 | Unificar contenido de muestra (reseñas, años, RUC) | **S-6** | Evita confusión en demos | Cosmético |
| 58 | Crear las pantallas `SIN` de `02` §B (resultados, recuperación, detalle móvil, errores CRUD, tablet) | **S-4**, **S-5**, **S-8** | Completa cobertura | Amplía el alcance; **perfil excluido hasta P-12** |
| 59 | Alinear cifras de SLA (A12) y modelos de rol (A13) dentro de Stitch | **S-7** | Elimina contradicciones internas | Depende de D-08/D-09 aplicadas al copy |

## 4. Tareas de implementación planificables `[IMP]` — sólo tras los gates de `14` (G0–G5)

### P1 · Fundación
| # | Tarea | Dependencias | Criterio de aceptación |
|---|---|---|---|
| 6 | Elegir stack frontend/consola/backend y proveedor de tiles (B1–B5) | **P-01, P-02, P-03, P-04** | Decisión escrita en `09`/`11` |
| 7 | Design tokens como variables CSS desde el bloque `colors:` | D-02 adoptada (ítem 2) | 38 roles mapeados + semillas documentadas |
| 8 | Componentes base (Button, Chip, Card, Input, Switch) | #7 | Coinciden con `REQ-UI-06` en 390 y 1280 |
| 9 | Componentes de dominio (MapMarker, ElevationDistanceIndicator, DrawerHandle) | #8 | `REQ-UI-07` verificado |
| 10 | Shell con los 3 patrones (bottom sheet 3 detents / panel 380 / split 460–520) | #9, ítem 40 + **P-09** | Los 3 detents funcionan en dispositivo real |

### P2 · MVP visitante
| # | Tarea | Dependencias | Criterio de aceptación |
|---|---|---|---|
| 11 | Exploración cartográfica + permisos de ubicación | #6, #10 | `C01/C02M/C03M/C04M` reproducidos |
| 13 | Tarjeta rápida sobre el mapa | #11 | `C10M` |
| 14 | Ficha editorial de lugar | #11 | `D01`/`D02M` |
| 15 | Auth: login, registro, OTP, guard de sesión | **P-04** (contrato OTP), #6 | `B01M/B02M/B04M/B07M/B08M` + rate limit |
| 16 | PWA: instalación, carga, sin conexión, caché | #10 | `A01M–A04M`, `11M`; instalable en iOS y Android |

### P3 · Completitud visitante
| # | Tarea | Dependencias | Criterio de aceptación |
|---|---|---|---|
| 17 | Catálogo + detalle de ruta | #11 | `E01`, `E03` (+ ficha móvil `S-8`) |
| 19 | Favoritos + itinerarios | #15 | `F01M`, `F02M`, `F04`, `06M` sincronizan offline |
| 21 | Reseñas: listado, formulario, cola offline, confirmación | #15, #6 (offline) | `G01M/G04M/G05M/G10M`; reenvío idempotente; **sin SLA < 24 h** (D-08) y **sin pts** (D-10) |
| 60 | Ajustes: preferencias, idioma/toponimia, consentimientos | **P-14** | `H01M`, `H02M`, `H06M` |
| 61 | Notificaciones (primer plano) | D-07 adoptada | `H05M` sin prometer geofencing no disponible; añadir endpoint (C-1) |

### P4 · Consola administrativa
| # | Tarea | Dependencias | Criterio de aceptación |
|---|---|---|---|
| 24 | Login + shell + dashboard | **P-05** (roles) | `ADM-01`, `ADM-02` |
| 25 | CRUD lugares + biblioteca multimedia | #24, #6 (media) | `ADM-03..06` con estados de éxito/error (`S-5`) |
| 26 | CRUD rutas + importador GPX + waypoints | #24 | `ADM-07/08/09`; parser validado (formato, límite) |
| 28 | Usuarios, curaduría | #27 | `ADM-10`, `ADM-11` |
| 29 | Moderación de reseñas + dictamen ético | **P-16** (SLA), **P-05** | `ADM-13/14/15` con máquina de estados en servidor |
| 30 | Moderación de fotografías | #29 | `ADM-16` |
| 62 | Patrocinios | **P-15** | `ADM-12` + badges públicos |
| 63 | Métricas y capacidad de carga | **P-15** | `ADM-17` con origen del dato documentado |
| 64 | RBAC + auditoría con hash | #27, **P-05** | `ADM-18`; permisos verificados en servidor |

### P5 · Legal, privacidad y residuales
| # | Tarea | Dependencias | Criterio de aceptación |
|---|---|---|---|
| 34 | Consentimiento y telemetría | #33 | `H06M` con opt-in y borrado efectivo |
| 65 | ARCO + Libro de Reclamaciones con datos reales | **P-17**, **P-18**, `ASES` | `H07M`, `H08M` con plazos y datos validados |
| 66 | Auditoría de seguridad y de accesibilidad (contraste, teclado, lector) | P2–P4 completados | Informe con hallazgos y severidades |

## 5. Riesgos ligados a hitos

- **R2** (set de pantallas, C3) → **mitigado**: D-01 fija la base (codificada) sin borrar la numerada.
- **R3** (color, C1) → **mitigado en dirección** (D-02): sigue abierto hasta congelar tokens en `#7`.
- **R7** (legal) → P5 entero no avanzable sin insumos jurídicos (`#33`, `#35`, `#36` → P-17…P-20).
- **R8** (conflicto offline) → golpea `#21` (cola de reseñas) y `#19` (itinerarios); reglas en **P-07** y `08` §6.4.
- **R-nuevo** (alcance PWA vs nativo, A14) → **mitigado**: D-07 fija primer plano; si algún día se exige 2.º plano, cambia el alcance de P2/P3 completo.
- **R-nuevo (stack)** → si P-01…P-04 no responden, no arranca `14` T-1 (gate G0).

## 6. Verificación de este documento

Todas las filas son trazables a: etiquetas de pantalla de Stitch, textos del `designMd`, HTML exportado, huecos documentados en `01`, `02`, `05` y `06`, o decisiones D-01…D-15 de `11-decisiones-consolidadas.md`. **No se añadieron funcionalidades sin pantalla ni texto de origen.** No se han ejecutado builds, tests ni código (no existe código): este backlog es un artefacto de análisis. **FASE 1.6 no modificó Stitch ni ningún archivo fuera de `docs/analisis/`.**
