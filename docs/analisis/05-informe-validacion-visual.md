# LUMINA — Informe de Validación Visual (FASE 1.5)

> **Alineación 2026-10-10:** la evidencia visual citada en este informe (capturas PNG/HTML) **ya no está accesible** (temporal limpiado). Los hallazgos del análisis siguen vigentes como conclusiones; el proyecto **Stitch** (62 pantallas) permanece intacto y es la fuente regenerable de referencia.

> **Alcance:** validación visual profunda de los recursos del proyecto Stitch `projects/10414968813285274750` ("LUMINA Tourism Platform UX/UI") y del sistema de diseño **"Andean Modern Lumina"** (`assets/651821219e48455680ed40145445196f`).
> **Fecha:** 2026-10-09. **Modo:** solo lectura sobre Stitch. No se modificó ningún recurso externo ni se seleccionó stack.
> **Documentos alterados:** ninguno en esta fase; los cambios posteriores sobre `02-matriz-trazabilidad.md` y `04-backlog.md` se listan en §7.

---

## 1. Método y base de evidencia

### 1.1 Qué se inspeccionó

| Fuente | Cantidad | Cómo se validó |
|---|---|---|
| Capturas PNG de pantallas | **62/62** descargadas | Visuales (miniatura 512 px máximo) + **10** sobre el fichero de resolución completa (móvil 780 px nativos; desktop recortes verticales de hasta 1400 px de ancho) |
| HTML exportado de pantallas | **62/62** descargados | Análisis estructural, extracción completa de texto, conteo de colores/clases/medios |
| Metadatos MCP (`list_screens`, `get_screen`) | 62 pantallas | Título, `deviceType`, ancho/largo lógico (retina 2×) |
| Metadatos de proyecto (`get_project`) | 63 instancias | Posición en lienzo (`x`,`y`), tamaño lógico, `designTheme` |
| `designMd` + `styleGuidelines` | 11.997 + 5.807 caracteres | Lectura completa (tokens de color, tipografía, espaciado, guías de estilo) |

**Pantallas inspeccionadas a resolución nativa** (puntos de decisión o contradicción):
`01`, `C01`, `03`, `D01`, `07 & 08`, `09 & 10`, `12T`, `ADM-13`, `06M`, `F04`.
Las 52 restantes se validaron con la miniatura exportada (512 px de lado máximo) **más** el HTML completo (texto y estructura íntegros), que es la fuente fiable para copy y estados.

### 1.2 Cómo se obtuvo evidencia reproducible

- Descargas de PNG a resolución completa mediante sufijo `=s0`/`=s2560` en la URL de `downloadUrl` (verificado: produce 2560×2048 donde la miniatura daba 512×410).
- Recuento de colores: normalización de todos los hexadecimales de los 62 HTML (**94 hex de 6 dígitos** distintos; se descartaron 4 abreviaturas de 3 dígitos ajenas a CSS de color).
- Similitud entre pantallas: índice de Jaccard sobre conjuntos de tokens de texto (palabras de `<body>` sin `<script>`/`<style>`).
- Posición en lienzo: `screenInstances[]` de `get_project` (63 instancias con `x`, `y`, `width`, `height`).

> **Nota de honestidad:** la inspección es de *renders estáticos*. No se ejecutó ninguna pantalla en navegador, no se probaron hovers, transiciones, scroll ni comportamiento real del mapa (los mapas de las capturas son imágenes fijas).
>
> **Evidencia pantalla a pantalla** (qué se ve en cada una de las 62, tamaño, familia, nº de vistas y estado): `06-inventario-pantallas-depurado.md`.

---

## 2. Hallazgo 1 — Existen dos familias de diseño, no un conjunto duplicado

### 2.1 Evidencia de posición en el lienzo (nueva)

Las 63 instancias se disponen en dos bloques claramente separados en `y`:

| Bloque | Filas `y` | Pantallas |
|---|---|---|
| **Familia numerada** | `0`, `1280`, `3846` | 01, 01M&02, 03, 04&05, 06M, 07&08, 09&10, 11M, 12T (+ logotipo en `y=0`) |
| **Familia codificada** | `5126` → `28854` | A(4), B(5), C(6), D(2), E(3), F(3), G(4), H(7), ADM(18) |
| Sueltos en fila inferior | `28854` | B08M, C04M, C05M, G05M |

No hay solapamiento entre bloques: la familia numerada ocupa `y ∈ [0, 4730]` y la codificada `y ≥ 5126`. Esto indica **dos lotes de generación separados**, no parejas puestas a propósito lado a lado para comparación.

### 2.2 Evidencia de similitud textual (Jaccard sobre texto)

| Par | Jaccard | Lectura |
|---|---|---|
| `01` vs `C01` | **0.28** | Misma pantalla-objetivo, contenido distinto |
| `01M&02` vs `C10M` | **0.36** | La relación más alta de todas: tarjeta rápida |
| `01M&02` vs `C02M` | 0.33 | Mapa móvil comparable |
| `09 & 10` vs `12T` | 0.26 | **Mismo contenido, distinto layout** (ver §2.3) |
| `09 & 10` vs `ADM-02` / `ADM-13` | 0.16 / 0.16 | Shells distintos |
| `03` vs `D01` | 0.18 | Misma función, lugar de ejemplo distinto |
| `07 & 08` vs `B07M` / `G01M` | 0.11 / 0.14 | Familiaridad baja: layouts muy diferentes |
| `11M` vs `A04M` | 0.17 | Offline: enfoques distintos |
| `04 & 05` vs `E01` / `E06M` | 0.15 / 0.20 | Rutas: catálogo vs detalle+seguimiento |

**Conclusión:** ningún par supera 0.40. **No hay duplicados textuales idénticos**; sí hay *solapamiento funcional* (pantallas que cubren el mismo objetivo de usuario con diseños distintos). Eliminar una familia por ser "duplicada" eliminaría información real.

### 2.3 Comparaciones visuales clave (resolución nativa)

| Par | Qué se ve | Veredicto |
|---|---|---|
| **01 vs C01** | Ambas: mapa a sangre + rail de filtros + panel derecho de cards. `01` usa chips "Todos / Miradores de altura / Gastronomía viva / Haciendas coloniales / Arqueología Inca"; `C01` usa "Miradores / Naturaleza / Gastronomía / Historia viva / Rutas" en top-nav y panel de "Lugares Curados / Rutas Temáticas" | **Variantes de IA distintas** (rail vs top-nav). Conservar ambas |
| **03 vs D01** | `03` = Hacienda La Florida, rejilla editorial + video "Atmósfera sensorial", pagos Yape/Plin; `D01` = Mirador Cerro San Cristóbal, breadcrumb + GPS 11°25′12″S 75°41′24″W + hoja topográfica 23-M + ficha técnica | **Misma función, contenido y componentes distintos**. No duplicado |
| **09 & 10 vs ADM-13** | `09&10` = "Cola de Moderación Patrimonial", sidebar de roles, KPIs 14/9/24/18 min, panel derecho de detalle; `ADM-13` = "Bandeja de Moderación Ética", sidebar "Curaduría Territorial", métricas de turno (92.4%, 4.2 min), custodios en línea, guías éticas de rechazo | **Dos shells administrativas distintas**. Requiere decisión (C3) |
| **12T vs 09&10** | **Mismo contenido exacto**: misma ficha `#MOD-2024-089`, mismos KPIs (14/9/24/18 min), mismos items de cola, misma usuaria Camila Ríos; cambia la navegación: superior + hamburguesa (12T) vs sidebar (09&10) | **12T es la adaptación de tabla de `09&10`**, no una pantalla nueva |
| **06M vs F04** | `06M` móvil: "Mi Cuaderno Privado" con pestañas Lugares(8)/Itinerarios(2)/Notas, itinerario activo "Día 1 de 2"; `F04` desktop: listado con filtros, "Crear Nuevo Itinerario", espacio offline 24.6 MB | Complementarias (móvil/desktop), no duplicadas |
| **07 & 08** | Dos vistas etiquetadas "Pantalla 07 · Bitácora Segura" (OTP por **correo** + consentimiento) y "Pantalla 08 · Voces del Valle" (búsqueda curada + formulario de reseña) | **Lienzo combinado** de 2 pantallas |

### 2.4 Conclusiones para C3 (set vigente) y A1 (pantallas combinadas)

- **C3:** la evidencia **no permite determinar cuál familia es la vigente**. `get_screen`/`list_screens` **no exponen fecha por pantalla**; solo existe fecha de proyecto (`createTime 2026-10-09T13:24:18Z`, `updateTime 2026-10-10T03:17:19Z`), que cubre a ambas familias. **No se declara ninguna versión definitiva por suposición** → ver `09-decisiones-pendientes.md` (C3), donde se presentan alternativas y recomendación.
- **A1:** los lienzos combinados se interpretan como *varias vistas por lienzo*, con el número de vistas identificado por evidencia (§1 del inventario, columna *Vistas*). **No se elimina ninguna pantalla.**

---

## 3. Hallazgo 2 — La paleta no es "dos paletas en conflicto" (resolución técnica de C1)

### 3.1 Evidencia obtenida

1. `designTheme` del proyecto:
   - `customColor: #243b35` — la API de Stitch documenta este campo como *"custom theme primary color, **or a seed color for the dynamic color system**"*.
   - `overridePrimaryColor: #243b35`, `overrideSecondaryColor: #d5a45d`, `overrideTertiaryColor: #647d75`, `overrideNeutralColor: #f5f1e8` → **coinciden exactamente con la "paleta prosa"**.
   - `colorVariant: FIDELITY`, `colorMode: LIGHT`, `roundness: ROUND_EIGHT`, `spacingScale: 2`.
2. El `designMd` declara, en su front-matter YAML `colors:`, **47 roles M3 (38 hexadecimales únicos)**, donde **`primary-container: #243b35` reproduce el `#243B35` prosa**, `background/surface: #fdf9f0`, `primary: #0e2520`, `secondary: #7e5717`, `on-surface: #1c1c16`, `error: #ba1a1a`. La prosa (`## Colors`) documenta **6** colores: `#243B35`, `#D5A45D`, `#647D75`, `#F5F1E8`, `#FFFFFF`, `#263238`.
3. Recuento real en los 62 HTML:

| Color | Papel | Ocurrencias |
|---|---|---|
| `#243b35` | semilla prosa = `primary_container` | **153** |
| `#fdf9f0` | `surface`/`background` token | **193** |
| `#1c1c16` | `on_surface` token (texto) | 122 |
| `#e6e2d9` | `surface_container_highest` | 122 |
| `#7e5717` | `secondary` token | 81 |
| `#fec97e` | `secondary_container` | 74 |
| `#0e2520` | `primary` token | 67 |
| `#d5a45d` | semilla prosa secundaria | 48 |
| `#f5f1e8` | semilla prosa neutral | 10 |
| `#647d75` | semilla prosa terciaria | 15 |
| `#263238` | texto prosa | **0** |

### 3.2 Interpretación verificable

- **Las dos "paletas" son la misma en dos capas:** semillas de marca (prosa) → roles M3 generados (`FIDELITY`). No son grupos rivales; `#243b35` aparece en ambos con el mismo papel visual (rellenos verde oscuro).
- **Divergencias reales sí existen** y deben decidirse:
  - Texto: prosa `#263238` (**nunca usado**) vs token `#1c1c16` (**usado 122 veces**) → el render usa el token.
  - Lienzo: prosa `#f5f1e8` (10) vs token `#fdf9f0` (193) → el render usa el token.
  - Acento: prosa `#d5a45d` (48) vs token `secondary #7e5717` (81) + `secondary_container #fec97e` (74) → coexisten como roles distintos (acento medio vs texto oscuro vs chip claro).
- **Recomendación (no aprobada):** tomar el bloque `colors:` del `designMd` como fuente canónica *máquina* (está completo: 47 roles con pares de contraste, estados de error, contenedores y variantes fixed), registrar las 4 semillas como valores de marca, y **corregir la prosa del `designMd` en Stitch** para que documente el mapeo semilla→rol. Esto cierra C1 sin perder nada.

---

## 4. Hallazgo 3 — Los artefactos NO son responsive

Medición sobre los 62 HTML:

| Métrica | Resultado |
|---|---|
| `@media` (media queries) | **0 en los 62 archivos** |
| Anchos fijos / lienzos | ancho fijo: **390 px** (móvil) o **1280 px** (desktop) |
| `cdn.tailwindcss.com` | presente en **61/62** |
| Fuentes | `Newsreader` + `Plus Jakarta Sans` (Google Fonts) en todos |
| Clases semánticas (`bg-primary`, `text-on-surface`…) | media 182–200 por pantalla (familia codificada máx. 445) |
| Instancias de ancho lógico | 390 px (**32** pantallas), 1280 px (**29** pantallas), 340 px (logotipo) |

**Implicación:** Stitch entrega *mockups*, no HTML productivo. Cualquier breakpoint real (incluido el tablet 768–1024 del `designMd`, REQ-UI-03) **debe diseñarse/implementarse en FASE 2**: no existe artefacto intermedio que copiar.

**Etiquetas "Tablet" que no corresponden:** `07 & 08` y `12T` están etiquetadas Tablet pero miden **1280 px** (ancho desktop). `designMd` define tablet como 768–1024 px con panel lateral de 380 px → **sin ningún artefacto** (C2).

---

## 5. Hallazgo 4 — Huecos y carencias del design system

1. **Hexadecimales no declarados:** 94 hex de 6 dígitos en uso; **los 38 hex únicos de los 47 roles del bloque `colors:` aparecen todos (38/38)**, pero hay **53 adicionales sin token**, entre ellos:
   - Estados semánticos de moderación: `#1b5e3a` (aprobar), `#ba4e26` / `#b95835` (rechazar/advertencia) — **no existen tokens de estado en el `designMd`** (solo `error #ba1a1a`).
   - Azules ajenos a la marca (`#1565c0`, `#2962ff`) y verdes (`#34a853`) → probablemente iconografía/ilustraciones.
   - Escalas neutras no tokenizadas (`#e8e4da`, `#c8c2b4`, `#b8c2bc`…).
2. **Sin tokens de estado (éxito/aviso/info/peligro)** más allá de `error` → afecta a toda la consola ADM.
3. **Sin breakpoints ni variantes tablet** (§4).
4. **Sistema de diseño no inspeccionado visualmente:** el asset `Andean Modern Lumina` **no expone URL de captura** por MCP (`list_design_systems` devuelve solo `designMd`/`styleGuidelines`); se leyó íntegro (tokens + guías) pero **no se vio renderizado**. Limitación registrada (§6).
5. **Instancia extra en el lienzo:** 63 instancias = 62 pantallas + 1 `undefined` de 960×540 (probablemente la instancia del sistema de diseño) — no es una pantalla funcional.

---

## 6. Limitaciones de la inspección (registro obligatorio)

| ID | Limitación | Consecuencia |
|---|---|---|
| **L1** | Renders estáticos; sin navegador ni interacción | No se verificaron hovers, scroll, bottom-sheet con 3 detents, transiciones, ni mapa real |
| **L2** | Miniaturas de 512 px para 52 pantallas | Copy legido en HTML, no en la imagen; posibles detalles visuales finos no apreciados |
| **L3** | Sin fecha por pantalla en la API de Stitch | Imposible determinar qué familia es la vigente (C3) |
| **L4** | Asset de sistema de diseño sin captura disponible | Validación solo textual de tokens/guías |
| **L5** | Imágenes de mapa/fotografía son mock | No se valida calidad ni origen de medios |
| **L6** | Contenido de ejemplo inconsistente entre pantallas | `Mirador Cerro San Cristóbal`: 318 reseñas (D01/G01M) vs 128 (01/C01); fechas 2024/2025/2026 mezcladas; RUC y domicilio ficticios en H08M. **Son datos de muestra, no requisitos** |
| **L7** | Sin prueba de accesibilidad real (contraste/teclado/lector) | Solo se revisó semántica y foco en el HTML |

---

## 7. Contradicciones y ambigüedades detectadas (cierre documental)

| ID | Conflicto | Evidencia |
|---|---|---|
| **C1** Paleta | Semillas prosa vs roles M3 | §3: **resuelta técnicamente**, requiere aprobación de fuente canónica |
| **C2** Tablet | `designMd` exige 768–1024; no hay artefacto; "Tablet" = 1280 px | §4 |
| **C3** Set vigente | Dos familias separadas en lienzo, sin fechas por pantalla | §2.1 / §2.4 |
| **C4** Pantallas combinadas | 01M&02, 04&05, 07&08, 09&10, 06M con varias vistas | Inventario §1 (columna *Vistas*) |
| **A1** | Idem C4 — número de vistas por lienzo identificado | Inventario §1 (columna *Vistas*) |
| **A3** OTP canal | `B07M`/`07&08` = OTP **por correo**; `B08M` = "Continuar con código OTP (**Móvil**)" → SMS implícito | Texto de pantallas |
| **A11** *(nuevo)* Navegación inferior | `01M&02`: …Favoritos/**Perfil**; `C02M`: …Favoritos/**Ajustes**; `C05M/C10M`: **Itinerarios**/**Guías**; `F01M`: **Guardados**; `G05M`: **Offline** | 5 modelos de bottom-nav distintos |
| **A12** *(nuevo)* SLA de moderación | `07&08`: "máximo 12 horas" · `G10M`: "2 a 6 horas" · `ADM-13`: espera actual 3.4 h · `09&10`/`12T`: 18 min promedio (meta <30 m) | Cuatro cifras incompatibles |
| **A13** *(nuevo)* Modelo de roles | `09&10`: Super/Editor/**Mod. Nivel 2** ("Moderador Cultural") · `ADM-18`: 3 tiers (Super Admin / Editor de Contenido y Topógrafo / Moderador Comunitario) × 15 permisos · `07&08`: "comité de **tres** curadores locales" | Tres modelos distintos |
| **A14** *(nuevo)* Balizas/geolocalización | `H05M` promete alertas de desvío (+40 m) y aviso 45 min antes del ocaso con Web Push + Service Worker; las PWAs **no soportan geofencing en segundo plano** (§5 de `10-dependencias-tecnicas.md`) | Requisito vs capacidad de plataforma |
| **A15** *(nuevo)* Plazo ARCO | `H07M`: "10 días hábiles (Art. 19 del Reglamento)" · fuentes externas: **20 días hábiles** (Ley 29733 / Reglamento) | Requiere asesoría legal |
| **A16** *(nuevo)* Gamificación | Presente sin declarar: "+40 pts Explorador Ético" (G10M), "420 pts · Explorador Ético" (H01M), "Nivel 4 · 24 contribuciones" (ADM-15), "Fiabilidad: 98%" (12T) | **No estaba en la lista de requisitos previa** → nuevo requisito a confirmar |

> **Convención de IDs (importante):** `A1–A10` son las ambigüedades históricas definidas en `01-informe-tecnico.md` §5.2 (A1 combinadas · A2 búsqueda sin resultados · A3 canal OTP · A4 idioma/toponimia · A5 cobertura responsive · A6 modo oscuro · A7 estados CRUD · A8 constructor de itinerarios · A9 modelo de negocio · A10 sin especificación de datos). Las nuevas de esta fase son **A11–A16**. (Nota: `04-backlog.md` referenciaba A10 para "mecanismo de notificaciones"; se corrige a **A14**.)

---

## 8. Conclusión

1. Los 62 recursos son **válidos y consistentes con el designMd**, pero representan **dos familias complementarias** (no duplicados) y **dos anchos** (390/1280) sin tablet intermedia.
2. **C1 queda técnicamente resuelta** (semillas → roles) pendiente de aprobación de fuente canónica.
3. **C2, C3, C4/A1 y A3/A11–A16 requieren decisión explícita**: no hay evidencia en Stitch para resolverlas sin asumir.
4. Ningún artefacto quedó sin inspeccionar; las limitaciones (L1–L7) están registradas y ninguna afecta al recuento de pantallas.

---

## 9. Cambios realizados en los documentos de esta fase

| Documento | Cambio |
|---|---|
| `05-informe-validacion-visual.md` | **Nuevo** (este) |
| `06-inventario-pantallas-depurado.md` | **Nuevo**: inventario de 62 pantallas con IDs, tamaños, lienzo, familia y estado |
| `07-requisitos-funcionales.md` | **Nuevo**: requisitos + flujos con actores, pasos, errores y dependencias |
| `08-modelo-dominio-api.md` | **Nuevo**: modelo de entidades y contrato API provisional |
| `09-decisiones-pendientes.md` | **Nuevo**: registro de decisiones con alternativas y recomendación |
| `10-dependencias-tecnicas.md` | **Nuevo**: dependencias externas con hechos verificados, recomendaciones y asesoramiento |
| `02-matriz-trazabilidad.md` | **Actualizado**: estados ampliados (DOC/VER/APR/REC/AMB/SIN) y trazabilidad a flujos |
| `04-backlog.md` | **Actualizado**: separado por tipo (DEC/DOC/STI/IMP) con dependencias y criterios de aceptación |
| `01-informe-tecnico.md`, `03-arquitectura-propuesta.md` | **Sin cambios** (hallazgos conservados) |
