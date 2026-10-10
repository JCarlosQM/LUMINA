# LUMINA — Informe Técnico de Análisis

> Fuentes: proyecto Stitch **"LUMINA Tourism Platform UX/UI"** (id `10414968813285274750`, `TEXT_TO_UI_PRO`, `DESKTOP`, PRIVADO, actualizado 2026-10-10) y sistema de diseño **"Andean Modern Lumina"** (asset `assets/651821219e48455680ed40145445196f`, v1).
> Fecha del análisis: 2026-10-09. **No se modificó ningún archivo.**

---

## 1. Estado del repositorio

| Verificación | Resultado |
|---|---|
| `/Users/juancarlo/Documents/SistemasDemos/Lumina` | **Directorio vacío** (0 entradas, no es repo Git) |
| Código fuente / configuración de proyecto | **No existe** |
| `AGENTS.md` local, `package.json`, etc. | **No existen** |

**Conclusión:** no hay base de código previa que preservar ni que limitar. Toda la "especificación" materializada hoy existe únicamente en Stitch. Esto es un riesgo (ver §6) y a la vez una libertad de arquitectura, pero **ninguna decisión de stack está confirmada** por el usuario.

---

## 2. Recursos Stitch inventariados

- **1 proyecto** accesible: LUMINA Tourism Platform UX/UI.
- **63 instancias de pantalla** en el canvas.
- **62 pantallas con HTML + screenshot** exportables (`list_screens`).
- **1 asset de sistema de diseño** con `designMd` (tokens DTCG + guía de estilo).
- 1 pantalla-asset extra: "Logotipo Oficial LUMINA" (SVG, 340×70).

### 2.1 Anchos detectados (variantes responsive reales)

| Ancho | Dispositivo declarado | Observación |
|---|---|---|
| 390 px | MOBILE | Viewport lógico 780 (2x) |
| 1280 px | DESKTOP | Viewport lógico 2560 (2x). Una pantalla etiquetada "Tablet" también usa 1280. |

**No hay pantallas Stitch a 768–1024 px** pese a que el `designMd` define un rango Tablet explícito (§4.2). El "Tablet" de Stitch (07&08, 12T) es 1280 px.

---

## 3. Inventario de pantallas (63 instancias)

Prefijos usados: `A` PWA · `B` Auth · `C` Mapa/Buscar · `D` Lugar · `E` Rutas · `F` Favoritos/Itinerarios · `G` Reseñas · `H` Ajustes/Privacidad/Legal · `ADM` Consola Admin.

### 3.1 PWA / Onboarding (móvil, 390 px)
| Código | Etiqueta | Estado |
|---|---|---|
| A01M | Bienvenida a LUMINA | Primera ejecución |
| A02M | Experiencia de Instalación | Prompt de instalación |
| A03M | Estado de Carga Inicial | Loading |
| A04M | Estado Sin Conexión | Error/offline |
| 11M | Modo Offline & Gestión de Caché (PWA Mobile) | Offline + caché |

### 3.2 Autenticación (móvil, 390 px)
| Código | Etiqueta | Estado |
|---|---|---|
| B01M | Login Inicial | Default |
| B02M | Login con Errores de Validación | Error de validación |
| B04M | Registro de Usuario | Alta |
| B07M | Introducción del OTP (6 dígitos) | Verificación |
| B08M | Sesión No Autenticada / Requerida | Guard de sesión |
| 07 & 08 | Registro OTP & Reseñas de la Comunidad (Tablet/Desktop, 1280) | **Pantalla combinada** |

### 3.3 Mapa y búsqueda
| Código | Disp. | Etiqueta | Estado |
|---|---|---|---|
| C01 | 1280 | Exploración Principal Desktop | Default |
| C02M | 390 | Exploración Principal Móvil | Default |
| C03M | 390 | Solicitud de Permiso de Ubicación | Permiso pendiente |
| C04M | 390 | Permiso de Ubicación Denegado | Permiso denegado |
| C05M | 390 | Búsqueda Sin Resultados de Parajes | Vacío/error |
| C10M | 390 | Tarjeta Rápida de Lugar | Overlay peek |
| 01 | 1280 | Exploración Cartográfica Principal (Desktop) | **Solapa con C01** |
| 01M & 02 | 390 | Exploración Móvil & Tarjeta Rápida | **Pantalla combinada** |

### 3.4 Lugar
| Código | Disp. | Etiqueta |
|---|---|---|
| D01 | 1280 | Ficha Editorial de Lugar Desktop (5808 px alto) |
| D02M | 390 | Ficha Editorial de Lugar Móvil (4234 px) |
| 03 | 1280 | Ficha Editorial de Lugar (Desktop) (4892 px) — **solapa con D01** |

### 3.5 Rutas
| Código | Disp. | Etiqueta | Estado |
|---|---|---|---|
| E01 | 1280 | Catálogo de Rutas Temáticas Desktop | Listado |
| E03 | 1280 | Detalle de Ruta Desktop | Detalle |
| E06M | 390 | Modo Seguir en Movimiento Móvil | Navegación activa |
| 04 & 05 | 1280 | Rutas Temáticas & Descubrimiento en Movimiento | **Pantalla combinada** |

### 3.6 Favoritos e itinerarios
| Código | Disp. | Etiqueta | Estado |
|---|---|---|---|
| F01M | 390 | Mi Lista con Lugares Guardados | Con datos |
| F02M | 390 | Mi Lista Vacía | Empty |
| F04 | 1280 | Mis Itinerarios Personales Desktop (4520 px) | Listado largo |
| 06M | 390 | Favoritos & Mis Itinerarios (PWA Mobile, 4620 px) | **Combinada** |

### 3.7 Reseñas
| Código | Disp. | Etiqueta | Estado |
|---|---|---|---|
| G01M | 390 | Listado y Calificaciones de la Comunidad | Listado |
| G04M | 390 | Formulario de Calificación y Testimonio | Escritura |
| G05M | 390 | Error al Enviar y Respaldo Offline | Error + fallback offline |
| G10M | 390 | Envío a Moderación Comunitaria | Confirmación pendiente |
| 07 & 08 | 1280 | (incluye Reseñas de la Comunidad) | Combinada con Auth |

### 3.8 Ajustes, privacidad y legal (solo 390 px)
| Código | Etiqueta |
|---|---|
| H01M | Preferencias de Campo y Configuración |
| H02M | Selección de Idioma y Toponimia |
| H04M | Salvaguarda Cultural y Protección de Datos |
| H05M | Configuración de Notificaciones y Balizas |
| H06M | Gestión de Consentimiento y Telemetría |
| H07M | Derechos ARCO — Portabilidad y Supresión |
| H08M | Libro de Reclamaciones Virtual |

### 3.9 Consola administrativa (1280 px, salvo indicación)
| Código | Etiqueta |
|---|---|
| ADM-01 | Inicio de Sesión Consola Administrativa |
| ADM-02 | Dashboard con Indicadores de Gestión |
| ADM-03 | Listado de Lugares Turísticos |
| ADM-04 | Crear Lugar Turístico |
| ADM-05 | Editar Lugar Turístico |
| ADM-06 | Biblioteca y Gestión Multimedia |
| ADM-07 | Listado de Rutas Cartográficas |
| ADM-08 | Crear Nueva Ruta con Importador GPX |
| ADM-09 | Editar Ruta y Ordenar Waypoints |
| ADM-10 | Directorio y Gestión de Usuarios |
| ADM-11 | Curaduría de Lugares Destacados |
| ADM-12 | Gestión de Rutas Patrocinadas y Alianzas |
| ADM-13 | Cola de Moderación de Reseñas |
| ADM-14 | Detalle de Reseña Pendiente (1096 px alto) |
| ADM-15 | Aprobar o Rechazar Reseña y Dictamen Ético |
| ADM-16 | Moderación de Fotografías y Contenido Visual |
| ADM-17 | Métricas, Informes y Capacidad de Carga |
| ADM-18 | Gestión de Roles y Permisos (RBAC) |
| 09 & 10 | Panel Administrativo & Cola de Moderación (Desktop) — **solapa con ADM-02/13** |
| 12T | Panel Administrativo & Cola de Moderación (Tablet) — 1280 px |

---

## 4. Requisitos confirmados (proceden de fuentes existentes)

"Cofirmado" aquí = **está escrito en el proyecto Stitch** (designMd o pantalla existente). No implica aprobación de negocio.

### 4.1 Identidad visual (`designMd`)
- Filosofía "Andean Modern": editorial de viaje + custodia cultural + cartografía; referencia al valle de Tarma (Junín, Perú).
- Tipografía: **Newsreader** (titulares/lugares) + **Plus Jakarta Sans** (UI/métricas) + estilo `carto-code` (etiquetas cartográficas en mayúsculas trackeadas).
- Escala tipográfica completa (display/headline/title/body/label + variantes `*-mobile` + `carto-code`).
- Espaciado en base 8 px (`space-xs` 0.25rem … `space-xl` 2.5rem), gutters/margins de 1/1.5/2/3rem.
- Radios: sm 0.25, 0.5, md 0.75, lg 1, xl 1.5rem, full; fórmula de radio anidado `R_inner = R_outer − padding`.
- 4 capas de elevación con sombras tintadas en verde bosque (opacidad 0.06–0.12); overlay de modales `rgba(36,59,53,0.40)` + blur 4 px.

### 4.2 Responsive (`designMd`)
| Rango | Patrón |
|---|---|
| `< 768px` | Bottom sheet con **3 detents**: peek 84 px, half 48vh, full 94vh; controles flotantes con margen seguro ≥16 px |
| `768–1024px` | Panel lateral izquierdo deslizante **380 px** fijo, gutter 24 px |
| `> 1024px` | Split de 12 columnas: guía izquierda **460–520 px** + mapa restante con clusters de controles flotantes |

### 4.3 Dominio (inferido de los nombres de pantalla, todos existentes)
Mapa con ubicación del dispositivo (con permisos concedido/denegado), ficha editorial de lugar, catálogo/detalle/modo seguimiento de rutas, favoritos con estado vacío, itinerarios personales, reseñas con moderación comunitaria y respaldo offline, PWA instalable con caché offline, autenticación con registro + OTP 6 dígitos, ajustes de idioma/toponimia/notificaciones/telemetría, derechos ARCO, libro de reclamaciones, y consola admin con CRUD de lugares/rutas (importador GPX), curaduría, patrocinios, moderación, métricas y RBAC.

### 4.4 Componentes reutilizables confirmados (`designMd` §Components)
1. Buttons: Primary / Secondary-curado / Ghost.
2. Chips & Filter Pills: inactivo / activo (con punto ocre) / badge "Curated Heritage".
3. Cards de lugar/waypoint (16:10 o 1:1, tags pill, título Newsreader).
4. Floating search bar + trigger de filtros de capas.
5. Checkboxes / Radios / Switches con acentos de verificación ocre.
6. **Map Marker Waypoints** (pin con halo ocre para nodos curados).
7. **Elevation & Distance Indicator** (altitud, tiempo a pie/coche, dificultad en `carto-code`).
8. **Editorial Drawer Handle** (36×4 px) para bottom sheets.

---

## 5. Ambigüedades y contradicciones (NO resueltas; requieren confirmación)

### 5.1 Contradicciones
| # | Contradicción | Detalle |
|---|---|---|
| C1 | **Paleta: prosa vs tokens** | `styleGuidelines` declara `#243B35` (primary), `#D5A45D` (secondary), `#647D75` (tertiary), `#F5F1E8` (canvas), `#263238` (texto). El bloque `colors` del designMd declara `primary: #0e2520`, `secondary: #7e5717`, `surface: #fdf9f0`, `on-surface: #1c1c16`. Las semillas `override*` sí coinciden con la prosa. **Cuál es la fuente de verdad debe confirmarse.** |
| C2 | **Breakpoint Tablet vs pantallas** | designMd define Tablet 768–1024 px; las pantallas etiquetadas "Tablet" (07&08, 12T) miden 1280 px. No existe ningún artefacto en el rango 768–1024. |
| C3 | **Dos familias de pantallas** | Existe un set numerado (01, 03, 04&05, 06M, 07&08, 09&10, 11M, 12T) y otro codificado (C01, D01, E01…). Varias se solapan funcionalmente (01 vs C01; 03 vs D01; 09&10 vs ADM-02/ADM-13). **No se puede determinar cuál es vigente.** |
| C4 | **"Tablet/Desktop" combinado** | La pantalla 07&08 se etiqueta Tablet/Desktop pero solo existe a 1280 px. |

### 5.2 Ambigüedades
| # | Ambigüedad | Por qué importa |
|---|---|---|
| A1 | Pantallas combinadas (`01M & 02`, `07 & 08`, `04 & 05`, `09 & 10`, `06M`): ¿una pantalla con dos estados o dos pantallas fusionadas? | Define el conteo real de rutas/pantallas. |
| A2 | No existe pantalla de **búsqueda con resultados** ni de **mapa con resultados**; solo `C05M` (sin resultados). | Falta el estado intermedio central del flujo de búsqueda. |
| A3 | OTP: canal de envío (SMS/email/WhatsApp) y proveedor no definidos. | Dependencia externa y costo. |
| A4 | Multi-idioma/toponimia (H02M): ¿qué idiomas? ¿la toponimia es dato por lugar? | Modelado de datos + i18n. |
| A5 | Cobertura responsive: prácticamente todo el flujo de usuario existe solo en 390 y 1280; H*, G*, F01/F02, A* no tienen variante desktop; ADM no tiene variante móvil. | ¿Es intencional o faltan pantallas? |
| A6 | Sin modo oscuro: `colorMode: LIGHT` es la única variante. | ¿Es requerido? |
| A7 | Sin pantallas de **estado de éxito** para CRUD admin, ni de **pantalla de error de red** genérica, más allá de los estados puntuales listados. | Cobertura de estados. |
| A8 | Itinerarios: existe F04 (desktop) y 06M (móvil combinado) pero no un "constructor de itinerarios" explícito, aunque el designMd menciona "Itinerary Builders" en la capa 3. | Alcance del feature. |
| A9 | `ADM-12` (rutas patrocinadas) y `ADM-17` (capacidad de carga) sugieren modelo de negocio/publicación no documentado. | Requisitos de negocio pendientes. |
| A10 | No hay **especificación de datos** (modelo, API, reglas de negocio de moderación/dictamen ético) en ninguna fuente. | Bloqueante de estimación. |

---

## 6. Dependencias y riesgos

### 6.1 Dependencias técnicas identificadas (implícitas en el diseño)
| Dependencia | Origen | Estado |
|---|---|---|
| Motor de mapas (designMd cita **MapLibre** + tiles vectoriales) | Guía de estilo | Proveedor de tiles/API key **no definido** |
| Service worker / caché offline | A01M–A04M, 11M, G05M | Estrategia de caché y cuota no definida |
| Gateway OTP (SMS/email) | B07M, 07&08 | Proveedor no definido |
| Almacenamiento + moderación de fotografías | ADM-06, ADM-16 | Infra no definida |
| Telemetría/analítica con consentimiento | H06M | Proveedor no definido |
| Libro de Reclamaciones Virtual (formato legal PE) | H08M | Conformidad legal a verificar |
| RBAC | ADM-18 | Roles más allá de "admin" no enumerados |
| Importador GPX | ADM-08 | Validación/sanitización de archivos por definir |
| Notificaciones/balizas (beacons) | H05M | Mecanismo (push/geofencing) no definido |

### 6.2 Riesgos
| Riesgo | Severidad | Nota |
|---|---|---|
| **R1** Repositorio vacío: no hay código, tests ni CI que preservar; todo se construye desde cero | Media | No hay regresión posible, pero tampoco anclas |
| **R2** Ambigüedad de fuente de verdad (C3): dos familias de pantallas pueden llevar a implementar 2× pantallas | Alta | Bloqueante de planificación |
| **R3** Contradicciones de tokens de color (C1): implementar la paleta equivocada obliga a refactor visual global | Alta | Bloqueante de design system |
| **R4** 63 pantallas sin especificación de datos/API: esfuerzo no estimable con rigor | Alta | Estimaciones serían inventadas |
| **R5** Cobertura tablet real ausente (C2): riesgo de diseñar a medida el rango 768–1024 sin referencia | Media | |
| **R6** Contenido generado (reseñas, fotos) + moderación: riesgo legal/contenido ilícito sin política documentada | Alta | |
| **R7** ARCO + telemetría + libro de reclamaciones: obligaciones legales (Perú) sin requisitos jurídicos adjuntos | Alta | |
| **R8** Offline-first parcial: conflicto de sincronización (reseñas enviadas offline, favoritos) sin reglas de resolución | Media | |
| **R9** Mapa full-bleed + sheets en móvil: riesgo de rendimiento en gama baja | Media | |
| **R10** Sin contratos de API: cualquier arquitectura propuesta es provisional | Alta | Ver §3 de `03-arquitectura-propuesta.md` |

---

## 7. Verificación ejecutada (y no ejecutada)

- **Ejecutada:** `ls -la` del directorio de trabajo (vacío); `stitch.list_projects`; `stitch.list_screens` (62 pantallas); `stitch.list_design_systems`.
- **No ejecutada:** ninguna build/test/lint (no hay código). No se abrieron los 62 HTML exportados uno a uno: el inventario se basa en títulos/etiquetas y metadatos del proyecto, no en inspección pixel a pixel de cada artefacto. Ninguna aseveración de este informe es "inferida de render"; todas son de metadatos, salvo el análisis de tokens (`designMd`), que sí se leyó completo.
