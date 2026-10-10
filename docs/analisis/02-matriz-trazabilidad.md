# LUMINA — Matriz de Trazabilidad Pantallas ⇄ Requisitos

> Convención de estado de la fila:
> - **C (Confirmado)**: el requisito está escrito en Stitch (designMd o pantalla existente).
> - **A (Ambiguo)**: existe evidencia pero falta definición.
> - **D (Derivado)**: se deduce del nombre de una pantalla existente; no hay especificación formal.
> - **X (Sin pantalla / hueco)**: no hay pantalla que lo cubra.
>
> Las pantallas usan el ID corto del prefijo (ver `01-informe-tecnico.md` §3).

### Estado FASE 1.5 (añadido en la validación visual)

| Código | Significado |
|---|---|
| **DOC** | Documentado en Stitch: texto literal en `designMd` o en el HTML de la pantalla |
| **VER** | Verificado visualmente en FASE 1.5 (render + HTML) — ver `05-informe-validacion-visual.md` |
| **APR** | **Aprobado por el usuario** — *hoy no hay ningún requisito en APR* |
| **REC** | Recomendación técnica pendiente de aprobación — ver `09`/`10` |
| **AMB** | Ambiguo o contradictorio: requiere decisión (IDs `C1–C4`, `A1–A16`) |
| **SIN** | Sin diseño: hueco confirmado en los 62 artefactos |

> **Convención de IDs:** `A1–A10` = ambigüedades históricas de `01-informe-tecnico.md`; `A11–A16` = nuevas en FASE 1.5 (A11 navegación inferior · A12 SLA de moderación · A13 modelo de roles · A14 balizas/geofencing · A15 plazo ARCO · A16 gamificación).

## Leyenda de requisitos

| ID | Requisito | Estado |
|---|---|---|
| REQ-UI-01 | Layout Split-Canvas: mapa full-bleed + capa editorial | C |
| REQ-UI-02 | Bottom sheet móvil con 3 detents (84px / 48vh / 94vh) | C |
| REQ-UI-03 | Panel lateral tablet 380 px (768–1024) | C — **sin pantalla** (C2) |
| REQ-UI-04 | Split desktop 12 col, guía 460–520 px | C |
| REQ-UI-05 | Design system: tokens color/tipo/espacio/elevación | C — con contradicción C1 |
| REQ-UI-06 | Componentes base (botones, chips, cards, inputs, switches) | C |
| REQ-UI-07 | Componentes de dominio (marker, indicador elevación, drawer handle) | C |
| REQ-UI-08 | Responsive real: solo 390 px y 1280 px | C (observado) |
| REQ-APP-01 | PWA instalable | D |
| REQ-APP-02 | Carga inicial / estados de sistema | D |
| REQ-APP-03 | Modo offline + gestión de caché | D |
| REQ-AUTH-01 | Login | D |
| REQ-AUTH-02 | Registro de usuario | D |
| REQ-AUTH-03 | OTP 6 dígitos | D — canal A3 |
| REQ-AUTH-04 | Guard de sesión no autenticada | D |
| REQ-MAP-01 | Exploración cartográfica principal | D |
| REQ-MAP-02 | Permisos de ubicación (concedido/denegado) | D |
| REQ-MAP-03 | Búsqueda de parajes (con estado vacío) | D — estado con resultados X (A2) |
| REQ-MAP-04 | Tarjeta rápida de lugar sobre el mapa | D |
| REQ-PLZ-01 | Ficha editorial de lugar | D |
| REQ-RUT-01 | Catálogo de rutas temáticas | D |
| REQ-RUT-02 | Detalle de ruta | D |
| REQ-RUT-03 | Modo seguir en movimiento | D |
| REQ-FAN-01 | Favoritos (con y sin datos) | D |
| REQ-FAN-02 | Itinerarios personales | D — constructor X (A8) |
| REQ-REV-01 | Listado y calificación de reseñas | D |
| REQ-REV-02 | Formulario de reseña | D |
| REQ-REV-03 | Envío con respaldo offline ante error | D |
| REQ-REV-04 | Moderación comunitaria (envío a cola) | D |
| REQ-SET-01 | Preferencias de campo / configuración | D |
| REQ-SET-02 | Idioma y toponimia | D — alcance A4 |
| REQ-SET-03 | Notificaciones y balizas | D — mecanismo A14 |
| REQ-PRV-01 | Protección de datos / salvaguarda cultural | D |
| REQ-PRV-02 | Consentimiento y telemetría | D |
| REQ-PRV-03 | Derechos ARCO | D |
| REQ-LEG-01 | Libro de Reclamaciones Virtual | D |
| REQ-ADM-01 | Login de consola | D |
| REQ-ADM-02 | Dashboard de indicadores | D |
| REQ-ADM-03 | CRUD de lugares | D |
| REQ-ADM-04 | Biblioteca multimedia | D |
| REQ-ADM-05 | CRUD de rutas + importador GPX + orden de waypoints | D |
| REQ-ADM-06 | Directorio de usuarios | D |
| REQ-ADM-07 | Curaduría de lugares destacados | D |
| REQ-ADM-08 | Rutas patrocinadas / alianzas | D — modelo de negocio A9 |
| REQ-ADM-09 | Cola y detalle de moderación de reseñas | D |
| REQ-ADM-10 | Dictamen ético (aprobar/rechazar) | D — reglas A10 |
| REQ-ADM-11 | Moderación de fotografías | D |
| REQ-ADM-12 | Métricas, informes, capacidad de carga | D — A9 |
| REQ-ADM-13 | RBAC | D — roles no enumerados |
| REQ-ADM-14 | Responsive de consola (tablet) | A (C2/C4) |
| REQ-DATA-01 | Modelo de datos / contratos de API | X — no existe |
| REQ-DARK-01 | Modo oscuro | X — A6 |
| REQ-WEB-01 | SEO local: fichas indexables (title, meta, datos estructurados), sitemap, robots, hreflang | X — PDF v5.0 §12 |
| REQ-MULTI-01 | Soporte de idiomas español e inglés (UI y contenido) | X — PDF v5.0 §6.1 |

## Matriz

| Pantalla | Disp. | Requisitos cubiertos | Cobertura |
|---|---|---|---|
| A01M Bienvenida | 390 | REQ-APP-01 | Parcial |
| A02M Instalación | 390 | REQ-APP-01 | Parcial |
| A03M Carga inicial | 390 | REQ-APP-02 | OK |
| A04M Sin conexión | 390 | REQ-APP-02, REQ-APP-03 | OK |
| 11M Offline/caché | 390 | REQ-APP-03 | OK |
| B01M Login | 390 | REQ-AUTH-01 | OK |
| B02M Login con errores | 390 | REQ-AUTH-01 | OK (estado error) |
| B04M Registro | 390 | REQ-AUTH-02 | OK |
| B07M OTP | 390 | REQ-AUTH-03 | Parcial (A3) |
| B08M Sesión requerida | 390 | REQ-AUTH-04 | OK |
| 07&08 Registro OTP + Reseñas | 1280 | REQ-AUTH-03, REQ-REV-01 | Ambigua (A1) |
| C01 / 01 Exploración desktop | 1280 | REQ-MAP-01, REQ-UI-01, REQ-UI-04 | Duplicadas (C3) |
| C02M Exploración móvil | 390 | REQ-MAP-01, REQ-UI-02 | OK |
| C03M Permiso concedido | 390 | REQ-MAP-02 | OK |
| C04M Permiso denegado | 390 | REQ-MAP-02 | OK |
| C05M Búsqueda sin resultados | 390 | REQ-MAP-03 | Parcial (A2) |
| C10M / 01M&02 Tarjeta rápida | 390 | REQ-MAP-04 | Ambigua (A1) |
| D01 / 03 Ficha lugar desktop | 1280 | REQ-PLZ-01, REQ-UI-04 | Duplicadas (C3) |
| D02M Ficha lugar móvil | 390 | REQ-PLZ-01, REQ-UI-02 | OK |
| E01 Catálogo rutas | 1280 | REQ-RUT-01 | OK |
| E03 Detalle ruta | 1280 | REQ-RUT-02 | OK |
| E06M Seguir en movimiento | 390 | REQ-RUT-03 | OK |
| 04&05 Rutas + descubrimiento | 1280 | REQ-RUT-01, REQ-RUT-03 | Ambigua (A1) |
| F01M Favoritos con datos | 390 | REQ-FAN-01 | OK |
| F02M Favoritos vacío | 390 | REQ-FAN-01 | OK |
| F04 Itinerarios desktop | 1280 | REQ-FAN-02 | Parcial (A8) |
| 06M Favoritos+Itinerarios | 390 | REQ-FAN-01, REQ-FAN-02 | Ambigua (A1) |
| G01M Listado reseñas | 390 | REQ-REV-01 | OK |
| G04M Formulario reseña | 390 | REQ-REV-02 | OK |
| G05M Error + respaldo offline | 390 | REQ-REV-03 | OK |
| G10M Envío a moderación | 390 | REQ-REV-04 | OK |
| H01M Preferencias campo | 390 | REQ-SET-01 | Parcial |
| H02M Idioma/toponimia | 390 | REQ-SET-02 | Parcial (A4) |
| H04M Salvaguarda/datos | 390 | REQ-PRV-01 | OK |
| H05M Notificaciones/balizas | 390 | REQ-SET-03 | Parcial (A14) |
| H06M Consentimiento/telemetría | 390 | REQ-PRV-02 | OK |
| H07M ARCO | 390 | REQ-PRV-03 | OK |
| H08M Libro de Reclamaciones | 390 | REQ-LEG-01 | OK |
| ADM-01 Login admin | 1280 | REQ-ADM-01 | OK |
| ADM-02 Dashboard | 1280 | REQ-ADM-02 | OK |
| ADM-03/04/05 Lugares | 1280 | REQ-ADM-03 | OK |
| ADM-06 Multimedia | 1280 | REQ-ADM-04 | OK |
| ADM-07/08/09 Rutas + GPX | 1280 | REQ-ADM-05 | OK |
| ADM-10 Usuarios | 1280 | REQ-ADM-06 | OK |
| ADM-11 Curaduría | 1280 | REQ-ADM-07 | OK |
| ADM-12 Patrocinios | 1280 | REQ-ADM-08 | Parcial (A9) |
| ADM-13/14 Moderación reseñas | 1280 | REQ-ADM-09 | OK |
| ADM-15 Dictamen ético | 1280 | REQ-ADM-10 | Parcial (A10) |
| ADM-16 Fotos | 1280 | REQ-ADM-11 | OK |
| ADM-17 Métricas | 1280 | REQ-ADM-12 | Parcial (A9) |
| ADM-18 RBAC | 1280 | REQ-ADM-13 | Parcial |
| 09&10 Panel + cola (desktop) | 1280 | REQ-ADM-02, REQ-ADM-09 | Ambigua (C3) |
| 12T Panel + cola (tablet) | 1280 | REQ-ADM-14 | Parcial (C2) |
| Logotipo LUMINA | 340 | REQ-UI-05 (activo de marca) | OK |
| — | — | REQ-UI-03 (panel tablet 380) | **X — sin pantalla** |
| — | — | REQ-MAP-03 con resultados | **X — sin pantalla** |
| — | — | REQ-DATA-01 (modelo/API) | **X — sin artefacto** |
| — | — | REQ-DARK-01 | **X — sin pantalla** |

## Cobertura de responsive por familia

| Familia | 390 (móvil) | 768–1024 (tablet) | 1280 (desktop) |
|---|---|---|---|
| PWA (A*) | ✅ | ❌ | ❌ |
| Auth (B*) | ✅ | ❌ (07&08 a 1280) | ❌ (solo 07&08) |
| Mapa (C*) | ✅ | ❌ | ✅ |
| Lugar (D*) | ✅ | ❌ | ✅ |
| Rutas (E*) | ✅ (solo E06M) | ❌ | ✅ |
| Favoritos (F*) | ✅ | ❌ | ✅ |
| Reseñas (G*) | ✅ | ❌ | ❌ (solo dentro de 07&08) |
| Ajustes/Priv/Legal (H*) | ✅ | ❌ | ❌ |
| Admin (ADM) | ❌ | ⚠️ solo 12T a 1280 | ✅ |

---

# Estado FASE 1.5 (validación visual)

> Fuente de cada verificación: `05-informe-validacion-visual.md` (inspección de 62 renders + 62 HTML + metadatos MCP).
> **APR (aprobado por el usuario): 0 requisitos.** Nada se da por aprobado.

## A. Estado por requisito

| REQ | FASE 1.5 | Evidencia / motivo |
|---|---|---|
| REQ-UI-01 | **DOC · VER** | `01`, `C01` (mapa a sangre + capa editorial) |
| REQ-UI-02 | **DOC** (sin verificación interactiva) | Detents declarados en `designMd`; L1 impide probarlos |
| REQ-UI-03 | **SIN** | 0 artefactos en 768–1024 (C2) |
| REQ-UI-04 | **DOC · VER** | `D01`, `E01`, `ADM-*` |
| REQ-UI-05 | **DOC · VER · AMB** | C1 resuelta técnicamente (tokens), falta aprobación de fuente canónica |
| REQ-UI-06 | **DOC · VER** | Chips, botones, inputs, switches visibles en ambas familias |
| REQ-UI-07 | **DOC · VER** | Marker, drawer handle, indicador de elevación |
| REQ-UI-08 | **DOC · VER** | 0 `@media` en 62 HTML; sólo 390 y 1280 |
| REQ-UI-09 *(nuevo)* Navegación inferior unificada | **AMB** | 5 modelos distintos (A11) |
| REQ-APP-01/02/03 | **DOC · VER** | `A01M–A04M`, `11M` |
| REQ-AUTH-01/02/04 | **DOC · VER** | `B01M`, `B02M`, `B04M`, `B08M` |
| REQ-AUTH-03 OTP | **DOC · AMB** | Canal correo vs móvil (A3) |
| REQ-AUTH-05 *(nuevo)* Recuperación de contraseña | **SIN** | Enlace en `B02M` sin pantalla destino |
| REQ-MAP-01/02/04 | **DOC · VER** | `C01`, `C02M`, `C03M`, `C04M`, `C10M` |
| REQ-MAP-03 búsqueda | **DOC · AMB · SIN** | Sólo estado vacío `C05M`; resultados sin diseño (A2) |
| REQ-PLZ-01 | **DOC · VER** | `D01`, `D02M`, `03` (contenido distinto entre familias) |
| REQ-RUT-01/02/03 | **DOC · VER** | `E01`, `E03`, `E06M`, `04&05` |
| REQ-RUT-04 *(nuevo)* Detalle de ruta en móvil | **SIN** | Sólo desktop (`E03`) y seguimiento (`E06M`) |
| REQ-FAN-01 | **DOC · VER** | `F01M`, `F02M` |
| REQ-FAN-02 itinerarios | **DOC · AMB** | Creación sin pantalla propia (A8) |
| REQ-REV-01/02/03/04 | **DOC · VER** | `G01M`, `G04M`, `G05M`, `G10M`, `07&08` |
| REQ-REV-05 *(nuevo)* SLA de moderación | **AMB** | 4 cifras incompatibles (A12) |
| REQ-SET-01/02/03 | **DOC · AMB** | `H01M`, `H02M`, `H05M`; balizas = A14 |
| REQ-PRV-01/02/03 | **DOC · AMB** | `H04M`, `H06M`, `H07M`; plazo ARCO = A15 |
| REQ-LEG-01 | **DOC · AMB** | `H08M` completo; RUC/domicilio ficticios (CONTENT-1) |
| REQ-ADM-01..11 | **DOC · VER** | `ADM-01`..`ADM-16` |
| REQ-ADM-12 métricas/capacidad | **DOC · AMB** | Umbrales 1.000/84% sin origen documentado (A9) |
| REQ-ADM-13 RBAC | **DOC · AMB** | 3 modelos de roles (A13) |
| REQ-ADM-14 responsive consola | **AMB · SIN** | `12T` está a 1280 (C2/C4) |
| REQ-ADM-15 *(nuevo)* Estados de éxito/error de CRUD | **SIN** | Sin pantallas (A7) |
| REQ-DATA-01 modelo/API | **REC** *(nueva propuesta)* | `08-modelo-dominio-api.md`, pendiente de aprobación |
| REQ-GAM-01 *(nuevo)* Gamificación | **AMB** | Presente en 4 pantallas sin estar en la lista de requisitos (A16) |
| REQ-UX-01 *(nuevo)* Perfil de usuario | **SIN** | "Perfil" en `01M&02` sin pantalla propia |
| REQ-DARK-01 modo oscuro | **SIN** | `colorMode: LIGHT` único (A6) |

## B. Huecos nuevos detectados en FASE 1.5

1. Búsqueda **con resultados** (A2).
2. Perfil / gestión de cuenta.
3. Recuperación de contraseña.
4. Detalle de ruta en móvil.
5. Estados de éxito y de error de servidor en CRUD admin (A7).
6. Responsive desktop/tablet de `H*`, `G*`, `F*`, `A*` (A5).
7. Rango 768–1024 real (C2).
8. Constructor explícito de itinerarios (A8).

## C. Trazabilidad a flujos (ver `07-requisitos-funcionales.md`)

| Flujo | Requisitos principales | Estado dominante |
|---|---|---|
| V-1 Explorar → consultar | REQ-UI-01/04, REQ-MAP-01..04, REQ-PLZ-01 | DOC·VER (falta A2) |
| V-2 Seguir una ruta | REQ-RUT-01..03, REQ-APP-03, REQ-MAP-02 | DOC·VER (A14 bloqueante) |
| V-3 Favoritos e itinerarios | REQ-AUTH-04, REQ-FAN-01/02 | DOC (A8) |
| V-4 Reseñar con respaldo offline | REQ-REV-01..04, REQ-APP-03 | DOC·VER (A12) |
| V-5 Configuración/privacidad | REQ-SET-*, REQ-PRV-*, REQ-LEG-01 | DOC (A15, legal) |
| A-1 Publicar lugar | REQ-ADM-03, REQ-ADM-07, REQ-ADM-15 | DOC (falta éxito/error) |
| A-2 Importar GPX | REQ-ADM-05 | DOC·VER |
| A-3 Moderar reseña | REQ-ADM-09/10/11, REQ-ADM-13 | DOC·VER (A12, A13) |
| A-4 Usuarios y roles | REQ-ADM-06, REQ-ADM-13, REQ-ADM-12 | DOC·AMB (A13, A9) |

## D. Resumen de conteo

| Estado | Nº | Requisitos |
|---|---|---|
| DOC (documentado en Stitch) | 48 | Todos los `REQ-*` anteriores excepto UI-03, UI-09, AUTH-05, RUT-04, REV-05, ADM-14, ADM-15, DATA-01, GAM-01, UX-01, DARK-01 |
| VER (verificado visualmente) | 35 | UI-01/04/05/06/07/08 · APP-01..03 · AUTH-01/02/04 · MAP-01/02/04 · PLZ-01 · RUT-01..03 · FAN-01 · REV-01..04 · ADM-01..11 |
| **APR (aprobado por usuario)** | **0** | — |
| REC (recomendación pendiente) | 1 | REQ-DATA-01 |
| AMB (ambiguo/contradictorio) | 17 | UI-05, UI-09, AUTH-03, MAP-03, FAN-02, REV-05, SET-01/02/03, PRV-01/02/03, LEG-01, ADM-12, ADM-13, ADM-14, GAM-01 |
| SIN (sin diseño) | 8 | UI-03, AUTH-05, MAP-03, RUT-04, ADM-14, ADM-15, UX-01, DARK-01 |

> Los totales no son excluyentes: un requisito puede ser a la vez DOC, VER y AMB (p. ej. REQ-UI-05). Total de requisitos trazados: **59**.

---

# Nota de coherencia FASE 1.6 (sin cambiar los estados de arriba)

> Las decisiones de producto D-01…D-15 (`11-decisiones-consolidadas.md`) **no convierten ningún requisito en `APR`**: adoptan dirección, no contrato. **`APR` sigue en 0.** Efectos sobre esta matriz:

| REQ afectado | Efecto de la decisión | Estado en esta matriz |
|---|---|---|
| REQ-UI-03 (tablet) | D-04: 768–1024 en alcance de diseño; artefacto pendiente (`S-3`) | **SIN** se mantiene hasta generar el diseño |
| REQ-UI-09 (nav inferior) | D-05 adoptada con excepciones E1–E3 (P-09) | **AMB** se mantiene |
| REQ-AUTH-03 (OTP) | D-06: canal = correo; proveedor/contrato = P-04 | **AMB** se mantiene (falta el contrato) |
| REQ-MAP-03 (búsqueda) | Diseño de resultados autorizado (`S-4`) | **SIN** se mantiene hasta generar la pantalla |
| REQ-REV-05 (SLA) | D-08: sin SLA < 24 h; cifra concreta = P-16 | **AMB** se mantiene |
| REQ-SET-03 (notificaciones) | D-07: sólo primer plano; falta endpoint (hallazgo C-1) | **AMB** se mantiene |
| REQ-PRV-03 / REQ-LEG-01 (ARCO / Reclamaciones) | D-15: siguen a asesoramiento (P-17, P-18) | **AMB** se mantiene |
| REQ-ADM-13 (RBAC) | D-09 adoptada con condición; matriz 15×3 = P-05 | **AMB** se mantiene |
| REQ-DATA-01 (modelo/API) | D-11: base provisional adoptada; ajustes = P-06 | **REC** se mantiene |
| REQ-GAM-01 (gamificación) | D-10: **fuera del MVP**; los artefactos siguen mostrándola | **AMB** se mantiene + marca de alcance en `13` §3 |
| REQ-DARK-01 (modo oscuro) | P-10 pendiente | **SIN** se mantiene |

---

# Nota de coherencia FASE 1.7 (2026-10-10 — sin cambiar los estados de arriba)

> Las decisiones P-01…P-08 (`11-decisiones-consolidadas.md` §9) tampoco convierten ningún requisito en `APR`: **`APR` sigue en 0.** Ningún requisito cambió de estado por FASE 1.7; sólo cambió el **respaldo documental**:

| REQ afectado | Qué aportó FASE 1.7 | Estado en esta matriz |
|---|---|---|
| REQ-AUTH-03 / REQ-AUTH-0x (OTP) | Especificación de contrato OTP + proveedores comparados (`16`) — aún sin aprobar (P-04) | **AMB** se mantiene |
| REQ-ADM-13 (RBAC) | `ADM-18` leído campo a campo + matriz 15×4 propuesta (`17`) — aún sin aprobar (P-05) | **AMB** se mantiene |
| REQ-DATA-01 (modelo/API) | **P-06 aprobada como base provisional**; C-1 (notificaciones) y C-2 (reportes) añaden entidades/endpoints provisionales en `08` | **REC** se mantiene (falta contrato definitivo) |
| REQ-SET-03 (notificaciones) | Endpoint añadido en `08` (C-1), coherente con D-07 (sólo primer plano) | **AMB** se mantiene |
| REQ-PRV-01/02 (privacidad/consentimiento) | Política de retención/anonimización propuesta sin plazos (`18`) — pendiente P-07 + jurídico | **AMB** se mantiene |
| REQ-MAP-0x (mapas/tiles) | Comparativa final de proveedores con fuentes 2026-10-10 (`15` §2); proveedor sin elegir | sin cambio de estado |
| REQ-WEB-0x (SEO) | Revisión SEO híbrido en `15` §7; depende del residual SSR de P-01 | sin cambio de estado |

> **`APR = 0`** se mantiene verificado al cierre de FASE 1.7.

> **Alineación 2026-10-10:** se añaden dos requisitos trazados al PDF v5.0 (no cambian los estados de arriba): **REQ-WEB-01** (SEO local, PDF §12) y **REQ-MULTI-01** (español e inglés, PDF §6.1). Ver `20-alineacion-integral.md` §5.
