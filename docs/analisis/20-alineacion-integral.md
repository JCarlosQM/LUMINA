# LUMINA — Alineación Integral del Proyecto (2026-10-10)

> **Propósito:** cerrar la conciliación documental de LUMINA. Reconstruye el estado real tras FASE 1.7, resuelve la contradicción de arquitectura con el PDF v5.0, alinea requisitos de todas las fuentes, consolida las decisiones D-01…D-15 y P-01…P-24, y prepara la FASE 2 sin iniciarla.
> **Regla de lectura:** cada afirmación se marca como **[DOC]** (documento LUMINA), **[PDF]** (especificación v5.0), **[VER]** (verificado externamente con fuente y fecha), **[INF]** (inferencia técnica) o **[REC]** (recomendación, pendiente de aprobación).
> **Restricciones respetadas:** sin código, sin dependencias, sin Git, sin migraciones, sin despliegues, sin credenciales, sin cambios en Stitch, sin copia/movimiento de evidencias. **`APR = 0` durante todo el proceso.**

---

## 1. Estado real del proyecto tras FASE 1.7 (reconstruido y verificado)

| Aspecto | Estado | Fuente |
|---|---|---|
| Repositorio | Sólo `docs/` (19 documentos de análisis + `docs/referencia/`). Sin código, sin Git, sin dependencias. | Verificado 2026-10-10 |
| Decisiones de producto | D-01…D-15 adoptadas (dirección, no contrato). | `11` §1 |
| Decisiones P-01…P-08 | Respondidas con estados precisos (§3). | `11` §9 |
| Decisiones P-09…P-24 | Abiertas o pendientes de aprobación. | `11` §5 |
| Requisitos | 59 REQ trazados; **`APR = 0`**; 48 DOC, 35 VER, 17 AMB, 8 SIN, 1 REC. | `02` |
| Modelo de dominio/API | `08` = **base provisional** (P-06), con C-1…C-5 aplicados. | `08` |
| Matriz RBAC | `17` = propuesta 15×4, **no aprobada** (P-05). | `17` |
| Retención | `18` = propuesta sin plazos, **no aprobada** (P-07). | `18` |
| Alcance MVP | `13` = propuesta de planificación, **no especificación definitiva** (P-08). | `13` |
| Plan FASE 2 | `14` = propuesto, **no ejecutado**; pasos S-0…S-8 en lotes L-0…L-5. | `14` |
| Especificación OTP | `16` = propuesta, **no aprobada** (P-04). | `16` |
| Evidencia FASE 1.5 | **PERDIDA** — el directorio temporal fue limpiado por el sistema. Ver §8. | Verificado 2026-10-10 |
| Proyecto Stitch | **Intacto**: 62 pantallas (32 móviles, 29 escritorio, 1 logotipo). | `list_screens` 2026-10-10 |
| PDF v5.0 | Disponible en `docs/referencia/Lumina_Documento_Tecnico_Especificacion_v5.pdf` (9 págs., versión interna 5.0, 2026-10-09). | **[PDF]** |

### 1.1 Verificación de P-01…P-08 (lo que pediste comprobar)

| ID | Afirmación a verificar | ¿Se cumple? | Dónde |
|---|---|---|---|
| P-01 | Pendiente SSR vs prerenderizado híbrido | **Sí** — el residual está explícito en `11` §5.1 y `15` §1/§7 | `11`, `15` |
| P-02 | MapLibre adoptado; proveedor de teselas NO elegido | **Sí** — motor adoptado, proveedor PENDIENTE DE APROBACIÓN | `11` §9, `15` §2 |
| P-03 | Preferencia BD gestionada; sin proveedor ni entorno | **Sí** — preferencia registrada, comparativa entregada, pendiente | `11` §9, `15` §3 |
| P-04 | Correo adoptado; contrato y proveedor sin cerrar | **Sí** — canal adoptado, `16` entregado, valores/proveedor pendientes | `11` §9, `16` |
| P-05 | Matriz RBAC pendiente de aprobación | **Sí** — 15×3 y comité NO aprobados; 15×4 propuesta pendiente | `11` §9, `17` |
| P-06 | Base provisional con C-1…C-5 | **Sí** — aprobada como base provisional; C-1…C-5 aplicados | `08`, `11` §9 |
| P-07 | Retención sin plazos definitivos | **Sí** — propuesta sin plazos, pendiente + jurídico | `18`, `11` §9 |
| P-08 | Alcance de planificación, no autorización a desarrollar | **Sí** — aceptada como propuesta de planificación | `13`, `11` §9 |

**Conclusión:** los estados de P-01…P-08 en la documentación **son correctos y coherentes**; no requieren corrección.

---

## 2. Fuentes y su estado

| Fuente | Ubicación | Estado |
|---|---|---|
| Especificación técnica v5.0 | `docs/referencia/Lumina_Documento_Tecnico_Especificacion_v5.pdf` | **Leída** (extracción de texto; el modelo no renderiza PDF, se extrajo con `pypdf`). Versión interna 5.0, 2026-10-09. |
| Informe FASE 1.7 | `15-fase-1-7-informe.md` | Vigente; se actualiza en §8 (evidencia). |
| Evidencia visual FASE 1.5 | ruta temporal del sistema | **PERDIDA** (limpieza de temporales). El inventario `19` conserva el registro. |
| Proyecto Stitch | proyecto `10414968813285274750` | **Intacto** (62 pantallas). Es la fuente regenerable del diseño. |
| Versiones anteriores del PDF | `~/Downloads/Lumina_Documento_Tecnico_Especificacion.pdf`, `..._v3.pdf`, `actual-LUMINA.pdf` | **No usadas** (no son la v5.0). |

> **Nota de denominación:** el archivo presente se llama `..._v5.pdf` (sin el `-1` que mencionaste); interna y en la portada se identifica como **versión 5.0**. Se respeta esa distinción.

---

## 3. Matriz de contradicciones — PDF v5.0 vs FASE 1.7

| # | Tema | PDF v5.0 **[PDF]** | FASE 1.7 **[DOC]** | Tipo | Resolución |
|---|---|---|---|---|---|
| **X-1** | **Backend** | Laravel 11 (PHP) | Node.js + TypeScript | **Resuelto** | **Adoptado Laravel 13** (alineación definitiva). Ver §4. |
| **X-2** | **Frontend** | Vue 3 + Inertia.js (SSR amigable) | React + TypeScript + Vite (SPA) | **Resuelto** | **Adoptado Vue 3 + TS + Inertia 3** (SSR preferente). |
| **X-3** | **Panel admin** | Filament PHP (incluido) | App React+TS a construir (o librería) | **Resuelto** | **Adoptado Filament 5**. |
| **X-4** | **Base de datos** | MySQL 8.0 (tipos espaciales) | PostgreSQL + PostGIS | **Resuelto** | **Adoptada PostgreSQL/PostGIS** (alineación definitiva). Ver §4. |
| **X-5** | **Caché/colas/OTP** | Redis + Laravel Queues | No elegido (stack-agnostic) | **Resuelto** | Stack Laravel adoptado; Redis como servicio futuro. OTP por SMTP Google (`16`). |
| **X-6** | **Autenticación** | Laravel Sanctum (tokens) | Propia con librerías + OTP | **Resuelto** | Auth Laravel + OTP solo en registro (P-04 adoptado). |
| **X-7** | **Teselas** | Protomaps / Martin / PMTiles (autoalojado) | MapLibre adoptado; proveedor sin elegir (MapTiler candidato) | **Parcial** | MapLibre coincide en ambos. El proveedor: PDF propone Protomaps; FASE 1.7 lo evalúa como opción. Ver §5. |
| **X-8** | **Medios** | Intervention Image + FFmpeg, disco local → Cloudinary | Storage S3-compatible (R2) | **Resuelto** | Disco local en piloto (stack Laravel: Intervention + FFmpeg); Cloudinary/S3 futuro. |
| **X-9** | **Analítica** | PostHog + Google Analytics desde día 1 | Primera parte/autoalojada (Matomo) con opt-in | **Conflicto** | Pendiente (P-08/B8). Ver §7. |
| **X-10** | **Roles** | 4 perfiles: Super Admin, Editor de Contenido, Moderador, Usuario Registrado | Explorador + 3 niveles (Super Admin, Editor & Topógrafo, Moderador/Custodio) | **Diferencia de modelo** | Conciliado en `17` §7. Ver §6. |
| **X-11** | **OTP** | 6 dígitos, Redis TTL 10 min, rate limit correo+IP, cooldown 60 s (ej.), no revelar registro, eliminar al expirar/usar | 6 dígitos, TTL 10 min (prop.), 5 intentos, cooldown 60 s, anti-enumeración, recuperación | **Coincide en lo esencial** | Conciliado en `16` §9. Ver §6. |
| **X-12** | **Notificación de brechas** | 48 h a ANPDP y titulares | P-19 abierto (procedimiento) | **El PDF tiene razón** | **[VER]** DS 016-2024-JUS art. 34: 48 h confirmado (con condiciones). Ver §6. |
| **X-13** | **ARCO** | Implementar ARCO + portabilidad + desindexación | P-17 abierto (plazo 10 vs 20 días) | **Parcial** | **[VER]** Plazos por derecho: información 8, acceso 20, rectificación/cancelación/oposión 10. Ver §6. |
| **X-14** | **Libro de Reclamaciones** | Virtual conforme a INDECOPI | P-18 abierto (real vs informativo) | **El PDF tiene razón** | **[VER]** 15 días hábiles respuesta, conservación 2 años, libro físico de respaldo. Ver §6. |
| **X-15** | **Consentimiento / UGC / imagen negocios** | Checkbox no premarcado, licencia UGC, autorización de imagen | P-20 abierto (textos legales) | **El PDF tiene razón** | Requisitos legales reales; texto requiere abogado. Ver §6. |
| **X-16** | **Ubicación** | Procesada en cliente; no se almacena en servidor por defecto | RF-01/RF-02 (geolocalización) | **Coincide** | Ambos: geolocalización en cliente. |
| **X-17** | **SEO** | Cada lugar/ruta indexable: title, meta, datos estructurados (Schema.org) | Sin REQ formal; residual P-01 (SSR/prerender) | **Hueco** | Se crea REQ-WEB-01 (§5). |
| **X-18** | **Idiomas** | Español + inglés | es-PE + quechua (P-14) | **Diferencia** | El PDF pide es+en; FASE 1.7 pide es+quechua. Se registran ambos. Ver §5. |
| **X-19** | **Proximidad** | Radio 400–800 m, vista "Lo que hay en este trayecto" | RF-04 (avisos de proximidad) | **Coincide** | Se detalla en RF-22. |
| **X-20** | **Medios (video)** | 15–25 s, WebP, FFmpeg, miniatura, lazy loading | RF-17 (multimedia) | **Coincide** | Se detalla en RF-23. |

**Lectura:** las contradicciones centrales son **X-1…X-6 (stack)** y **X-8/X-9 (medios/analítica)**. El resto son coincidencias o diferencias de modelo conciliables. **Ninguna se resuelve por decreto:** la selección de arquitectura queda pendiente de tu aprobación.

---

## 4. Arquitectura adoptada (ALINEACIÓN DEFINITIVA 2026-10-10)

> **Decisión del proyecto:** la arquitectura objetivo es **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01/P-03/P-05 ADOPTADAS). Sustituye a la recomendación anterior (Opción B con MySQL 8). **MySQL no es la base principal ni una migración futura.**

### 4.1 Comparativa (referencia histórica)

| Dimensión | **Adoptada** (Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS) | **Opción B** (React+TS+Vite + Node+TS + PostGIS) |
|---|---|---|
| Geoespacial | **PostGIS: KNN indexado, `geography`, buffers, ~200 funciones.** | PostGIS (idéntico). |
| SEO | **Inertia = páginas server-rendered indexables** (con SSR). | SPA: requiere prerender/SSR. |
| Panel admin | **Filament 5: CRUD/moderación/métricas rápido.** | A construir. |
| Despliegue | **Monolito: un solo deploy.** | Dos servicios. |
| Auth | Laravel Auth + OTP (contrato `16`). | Librerías + OTP. |
| Medios | Intervention+FFmpeg; disco local. | Worker + S3/R2. |
| Coste | Hosting PHP + PostgreSQL: bajo. | PaaS + DB gestionada: bajo-medio. |

### 4.2 Resolución **[ADOPTADA]**

**Adoptada: Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre.**

1. **Geoespacial:** PostGIS cubre proximidad, geometrías de rutas y corredores — el corazón de LUMINA.
2. **SEO:** Inertia + SSR resuelve las fichas indexables.
3. **Panel admin:** Filament 5 resuelve CRUD/moderación/métricas rápido.
4. **Tiempo y coste:** monolito, un deploy, menor mantenimiento.

**Condiciones:** (a) versiones Laravel 13 / Filament 5 / Inertia 3 (verificadas); (b) desarrollo **local** en Mac; (c) producción se evaluará con **IONOS** (P-03 motor resuelto; proveedor pendiente); (d) SSR de Inertia para SEO. Detalle: `11` §10, `Plan_Maestro` §4/§5.

---

## 5. Alineación de requisitos funcionales

### 5.1 Cobertura de las áreas que pediste verificar

| Área | ¿Cubierta? | Requisito | Origen |
|---|---|---|---|
| Mapa interactivo | Sí | REQ-MAP-01/04, RF-01 | Stitch |
| Geolocalización | Sí | REQ-MAP-02, RF-01 | Stitch |
| Descubrimiento por proximidad/movimiento | Sí | REQ-RUT-03, RF-04, **RF-22** (nuevo) | Stitch + **[PDF]** |
| Fichas de lugares | Sí | REQ-PLZ-01, RF-03 | Stitch |
| Fotografías y vídeos breves | Sí | REQ-ADM-04/11, RF-17, **RF-23** (nuevo) | Stitch + **[PDF]** |
| Rutas temáticas | Sí | REQ-RUT-01/02, RF-04 | Stitch |
| Búsquedas y filtros | Sí | REQ-MAP-03, RF-02 | Stitch |
| Reseñas 1–5 estrellas | Sí | REQ-REV-01…04, RF-07 | Stitch |
| Moderación de comentarios | Sí | REQ-ADM-09/10/11, RF-16 | Stitch |
| Autenticación OTP por correo | Sí | REQ-AUTH-03, RF-08 | Stitch |
| PWA | Sí | REQ-APP-01/02/03, RF-09 | Stitch |
| Favoritos | Sí | REQ-FAN-01, RF-05 | Stitch |
| Itinerarios | Sí | REQ-FAN-02, RF-06 | Stitch |
| Notificaciones | Sí | REQ-SET-03, RF-10 | Stitch |
| Panel administrativo | Sí | REQ-ADM-01…14, RF-12…19 | Stitch |
| Gestión de negocios y rutas | Sí | REQ-ADM-03/05/07/08, RF-13/14/18 | Stitch |
| Analítica | Sí | REQ-ADM-12, RF-19 | Stitch |
| **SEO local** | **No (hueco)** | **REQ-WEB-01 (nuevo)** | **[PDF]** §12 |
| **Español e inglés** | **No (hueco)** | **REQ-MULTI-01 (nuevo)** | **[PDF]** §6.1 |
| Monetización (destacados/patrocinios) | Sí | REQ-ADM-07/08, RF-18 | Stitch |

### 5.2 Requisitos nuevos incorporados desde el PDF (sin eliminar ninguno)

| ID nuevo | Requisito | Fuente | Fase prevista | Estado |
|---|---|---|---|---|
| **REQ-WEB-01** | SEO local: cada lugar/ruta indexable con title, meta description y datos estructurados (Schema.org); sitemap, robots, hreflang | **[PDF]** §12 | MVP (fichas públicas) | **SIN** (hueco) |
| **REQ-MULTI-01** | Soporte de idiomas español e inglés (UI y contenido) | **[PDF]** §6.1 | MVP (UI) / FASE 2 (contenido) | **SIN** (hueco) |
| **RF-22** | Descubrimiento en movimiento: radio de proximidad configurable (400–800 m) y vista "Lo que hay en este trayecto" | **[PDF]** §5.3 | MVP | DOC (derivado de RF-04) |
| **RF-23** | Medios: imágenes WebP responsive; vídeos 15–25 s con compresión, miniatura y lazy loading | **[PDF]** §12 | MVP | DOC (derivado de RF-17) |

> **No se eliminó ningún requisito** por no aparecer en el backlog; **no se convirtió ninguna función futura en compromiso del MVP** sin justificación. Los huecos de SEO e idiomas se registran como requisitos nuevos trazados al PDF.

---

## 6. Conciliaciones de dominio

### 6.1 OTP — PDF vs `16`

| Aspecto | PDF v5.0 | `16` (propuesta) | Estado |
|---|---|---|---|
| Código | 6 dígitos | 6 dígitos | **Coincide** |
| Caducidad | Redis TTL 10 min | 10 min (PROPUESTA) | **Coincide** (valor de `16` es propuesta, no aprobado) |
| Almacenamiento | Redis | Hash + expiresAt (stack-agnostic) | Depende del stack (P-01) |
| Rate limit | Por correo e IP | Por cuenta e IP (429) | **Coincide** |
| Cooldown reenvío | 60 s (ejemplo) | 60 s (PROPUESTA) | **Coincide** (ambos son propuestas) |
| Anti-enumeración | No revelar registro | Respuesta idéntica | **Coincide** |
| Eliminación | Al expirar o usarse | Hash + expiración | **Coincide** |
| Intentos | — | 5 (PROPUESTA) | Pendiente de aprobar |
| Bloqueos / duración sesión / revocación / auditoría / recuperación / protección cuentas admin | — | Parcialmente en `16` | **Pendiente** (P-04) |

**Valores ya definidos (PDF):** 6 dígitos, TTL 10 min, rate limit, cooldown 60 s, no revelar, eliminar al expirar/usar. **Valores que son ejemplos/propuestas:** intentos, reenvíos, bloqueos, duración de sesión, revocación de tokens, auditoría, recuperación, protección de cuentas admin. **No se inventan valores definitivos.**

### 6.2 Roles — PDF vs `17`

| PDF v5.0 | `17` (P-05) | Diferencia |
|---|---|---|
| Super Admin | TIER 1 Super Administrador | Equivale |
| Editor de Contenido | TIER 2 Editor de Contenido & Topógrafo | **Nombre** (el de `17` añade "Topógrafo") |
| Moderador | TIER 3 Moderador Comunitario / Custodio | Equivale |
| Usuario Registrado | EXPLORADOR | **El PDF no distingue visitante invitado**; `07` sí (invitado solo lectura vs registrado) |

**Diferencias reales:** (1) el PDF no modela el visitante invitado; (2) el nombre del TIER 2. **No son conflictos de fondo.** La matriz conciliada en `17` §7 distingue **leer / crear / editar / publicar / aprobar / eliminar / administrar** y mantiene mínimo privilegio. **Sigue sin aprobarse** (P-05).

### 6.3 Retención y legal — PDF vs `18`

| Tema | PDF v5.0 | Estado verificado |
|---|---|---|
| Consentimiento expreso, previo, informado (checkbox no premarcado) | Sí | **[VER]** Ley 29733 + DS 016-2024-JUS |
| Política de Privacidad (art. 18) | Sí | **[VER]** |
| Registro Banco de Datos ante ANPDP antes del piloto | Sí | **[VER]** Ley 29733 art. 29 |
| ARCO + portabilidad + desindexación | Sí | **[VER]** Plazos: información 8, acceso 20, rectificación/cancelación/oposión 10 (días; hábiles/calendario por confirmar) |
| Libro de Reclamaciones Virtual (INDECOPI) | Sí | **[VER]** 15 días hábiles respuesta; conservación 2 años; libro físico de respaldo; multas 50–450 UIT |
| Licencia UGC (no exclusiva) | Sí | **[PDF]** (texto requiere abogado) |
| Autorización de imagen/logotipo de negocios | Sí | **[PDF]** (texto requiere abogado) |
| **Notificación de brechas: 48 h** | Sí | **[VER]** DS 016-2024-JUS art. 34: **48 h confirmado** (a ANPDP y a titulares; con condiciones: grandes volúmenes, datos sensibles o perjuicio evidente) |
| Ubicación procesada en cliente, no en servidor | Sí | **[PDF]** + RF-01/02 |
| Oficial de Datos Personales | — | **[VER]** DS 016-2024-JUS: ODP obligatorio para grandes empresas (desde 2025-11-30); LUMINA evaluará |

**Conciliación:** el PDF tiene razón en las obligaciones legales; `18` las recoge como categorías. **Se verifica que el plazo de 48 h del PDF está respaldado por el DS 016-2024-JUS art. 34** (con condiciones). Los plazos ARCO exactos (8/20/10) y la distinción hábiles/calendario requieren confirmación jurídica profesional. **No se inventan plazos de retención ni textos legales.**

---

## 7. Cartografía, base de datos y alojamiento

### 7.1 Teselas — verificación de restricciones (2026-10-10)

| Proveedor | Uso comercial | Caché / offline | Fuente |
|---|---|---|---|
| **MapTiler** | Free: **no comercial**; Flex: sí | **[VER]** Caché de dispositivo permitido (§47); **exportar/offline prohibido** sin acuerdo (§51); descarga masiva prohibida (§52); caché servidor prohibida (§57) | maptiler.com/terms/cloud |
| **Mapbox** | Sí (con cuenta) | **[VER]** Caché en dispositivo hasta 30 días (§2.8.1); SDK offline nativo (6.000 teselas); **redistribución prohibida** | mapbox.com Product Terms 2026 |
| **Stadia Maps** | Free: no comercial; Starter+: sí | Verificar ToS (pendiente) | stadiamaps.com/pricing |
| **Protomaps/Martin** | Sí (tus datos) | **[VER]** Autoalojado: tú sirves y cacheas; sin restricción de exportación | docs.protomaps.com |
| **OSM comunitario** | — | **[VER]** Prohíbe uso pesado, descarga masiva y offline; sin SLA | operations.osmfoundation.org |

**Conclusión:** para los **paquetes offline de 148 MB (RF-09)**, MapTiler los prohíbe sin acuerdo; Mapbox permite caché de dispositivo (30 días) pero no redistribución; **Protomaps es el más compatible** (autoalojado). El servicio comunitario OSM **no es apto** para producción ni offline. **El proveedor sigue sin elegir (P-02).**

### 7.2 Base de datos — MySQL 8 vs PostgreSQL/PostGIS

| Necesidad LUMINA | MySQL 8.0 | PostgreSQL + PostGIS |
|---|---|---|
| Puntos, bbox, distancia | Sí (tipos espaciales, SRID, índices R-tree) | Sí |
| **KNN indexado (lugares más cercanos)** | **No** | **Sí** |
| **Matemática esférica (`geography`)** | **No** (plana) | **Sí** |
| **Buffers de ruta ("en este trayecto")** | Limitado | **Sí** |
| Funciones / agregados espaciales | ~limitadas | **~200** |
| Escala piloto Tarma (~24 lugares) | **Suficiente** | **Suficiente** |
| Expansión regional | Justo | **Mejor** |

**[INF]** Para el piloto, MySQL 8 es suficiente; para el producto geoespacial que LUMINA quiere ser, **PostGIS es la elección correcta**. Esto es una inferencia técnica, no un hecho de mercado.

### 7.3 Alojamiento — estimaciones (supuestos, fecha, fuentes)

| Opción | Supuesto | Coste/mes | Fuente/fecha |
|---|---|---|---|
| Gestionado (Neon/Supabase) | Plan de entrada, piloto | 0–25 US$ | neon.com, supabase.com 2026-10-10 |
| VPS (Hetzner) | 1 vCPU/2 GB + IPv4 + backups | 5–20 € | Northflank (secundaria) 2026-10-10 |
| PaaS frontend (Vercel/Netlify) | Plan entrada | 0–20 US$ | 2026-10-10 |
| **Total estimado MVP** | Piloto | **≈0–55 US$/mes** | ESTIMACIÓN 2026-10-10 |

**No se crean cuentas ni se contrata nada. La elección de proveedor/entorno sigue pendiente (P-03).**

---

## 8. Estado de Stitch y evidencias

### 8.1 Stitch — intacto

`list_screens` (2026-10-10): **62 pantallas** (32 móviles, 29 escritorio, 1 logotipo) = baseline FASE 1.5. **Es la fuente regenerable del diseño.**

### 8.2 Evidencia FASE 1.5 — PERDIDA

| Concepto | Registrado (`19`) | Efectivamente inspeccionado (2026-10-10) |
|---|---|---|
| screens/ (62 PNG + 62 HTML) | 124 | **0 — directorio vacío** |
| screens-full/ | 62 | **0** |
| crops/ | 38 | **0** |
| texto-pantallas.txt | 1 | **0** |
| **Total** | **226 (≈63 MB)** | **0** |

**Hallazgo:** el directorio temporal del sistema fue limpiado entre sesiones; los ~63 MB de capturas **ya no están accesibles**. No se encontró copia en el disco. **Implicaciones:**
- **P-23 (conservación):** la premisa "copiar de la ruta temporal" queda **sin objeto** — no queda nada que copiar. Se redefine en §9.
- **V-3 (regresión visual):** ya no hay capturas de referencia; la regresión futura debe **regenerarse desde Stitch** (que sí está intacto) antes de cualquier cambio.
- El inventario `19` se conserva como **registro histórico** de lo que existió.

---

## 9. Plan de preparación de la FASE 2 (sin iniciarla)

> **No se crean sprints ejecutables** mientras las decisiones esenciales sigan pendientes. Secuencia de preparación con criterios de entrada/salida.

| Paso | Actividad | Criterio de entrada | Criterio de salida | Bloquea |
|---|---|---|---|---|
| **P-01 (adoptado)** | Stack Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS | Tu decisión ya tomada | Preparación del entorno local | Desarrollo local |
| **P-02** | Elegir proveedor de teselas (con métricas o plan de entrada) | P-01 (adoptado) | Proveedor registrado | Costes, offline |
| **P-03 (motor adoptado)** | Producción: evaluar IONOS (no verificado) | P-01 | Proveedor registrado | Despliegue producción |
| **P-04 (flujo adoptado)** | 2FA de consola: decidir alcance | `16` | Alcance 2FA decidido | Consola (2FA) |
| **P-05 (adoptado)** | YubiKey o alternativa de firma: decidir operación | `17` | Firma decidida | Auditoría (export) |
| **P-07** | Aprobar retención + 6 puntos jurídicos | `18` + abogado | Política con plazos | Esquema de purga |
| **P-08** | Confirmar alcance definitivo del MVP | `13` + revisión | Alcance cerrado | I-1…I-5 |
| **P-23 (redefinido)** | **Regenerar evidencia desde Stitch** (capturas frescas) | Tu autorización (P-24) | Nueva evidencia en ruta estable | V-3 (regresión) |
| **P-24** | Autorizar lotes L-0…L-5 en Stitch | P-23 + decisiones de diseño | Lotes autorizados | Mejora de diseño |
| **P-09…P-22** | Resolver diseño/legal pendiente | — | — | Diseño, publicación |

**Preparación futura del entorno:** una vez elegido el proveedor (P-02/P-03), crear cuentas, dominio, DNS, certificados, secretos y pipeline CI/CD — **todo tras tu aprobación, nada ahora.**

---

## 10. Matriz maestra de decisiones (consolidada, sin renumerar)

### 10.1 Decisiones adoptadas D-01…D-15 (dirección; contrato pendiente)

| ID | Decisión | Estado | Contrato pendiente |
|---|---|---|---|
| D-01 | Ambas familias Stitch se conservan | ADOPTADA | Unificación final de duplicados |
| D-02 | Color: tokens + 4 semillas | ADOPTADA | 47 roles + corrección prosa (`S-1`) |
| D-03 | Lienzos combinados se conservan | ADOPTADA | Normalización opcional |
| D-04 | Tablet 768–1024 en alcance | ADOPTADA | Diseños tablet (`S-3`) |
| D-05 | Navegación 5 destinos | ADOPTADA-COND | Cierre tras E1–E3 (P-09) |
| D-06 | OTP por correo | ADOPTADA | Contrato OTP + proveedor (P-04) |
| D-07 | Balizas sólo primer plano | ADOPTADA | Copy `H05M` |
| D-08 | Sin SLA < 24 h | ADOPTADA | Cifra pública (P-16) |
| D-09 | Explorador + 3 niveles | ADOPTADA-COND | Matriz aprobada (P-05) |
| D-10 | Sin gamificación en MVP | ADOPTADA | Criterios fiabilidad |
| D-11 | `08` base provisional | ADOPTADA-COND | Contrato tras P-06/P-07 |
| D-12 | Email no visible en moderación | ADOPTADA | Auditoría FASE 2 |
| D-13 | No inventar coordenadas sensibles | ADOPTADA | Criterios (P-21) |
| D-14 | Arquitectura desacoplada | ADOPTADA | Selección proveedores (P-01…P-04) |
| D-15 | Legal pendiente validación | ASESORAMIENTO | Dictamen (P-17…P-22) |

### 10.2 Decisiones P-01…P-24 (estado, opciones, recomendación, cierre)

| ID | Estado | Opciones | Recomendación | Consecuencia de no cerrar | Qué la cierra |
|---|---|---|---|---|---|
| **P-01** | **ADOPTADA** (alineación definitiva) | Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS + MapLibre; local en Mac | — | — | Encargo explícito (`11` §10) |
| **P-02** | Parcial (MapLibre adoptado); proveedor pendiente | MapTiler/Mapbox/Stadia/Protomaps | Decidir con métricas; Protomaps si offline pesado | Costes y offline sin definir | Elección de proveedor |
| **P-03** | **ADOPTADA (motor)**; proveedor de producción pendiente | PostgreSQL/PostGIS en local; producción IONOS por evaluar | — | Esquema físico en local desbloqueado | Proveedor IONOS por evaluar |
| **P-04** | **ADOPTADA (flujo)** | OTP 6 dígitos solo en registro; SMTP Google; 10 min / 5 intentos / 60 s | — | — | Encargo explícito (`16`) |
| **P-05** | **ADOPTADA (Filament 5)** | Matriz 15×4 conservada; autorización en servidor | — | — | Encargo explícito (`17` + `11` §10) |
| **P-06** | Base provisional aprobada (C-1…C-5) | — | — | — | (contrato definitivo tras P-01/P-03) |
| **P-07** | Propuesta sin plazos; pendiente + jurídico | Aprobar `18` + 6 puntos | Aprobar estructura; plazos con abogado | Esquema de purga sin definir | Aprobación + dictamen |
| **P-08** | Alcance de planificación aceptado | Confirmar `13` o cambios | Confirmar como definitivo | I-1…I-5 sin alcance cerrado | Confirmación del alcance |
| **P-09** | Abierta (E1–E3 navegación) | Confirmar/ajustar excepciones | Confirmar E1+Perfil en Ajustes+Guías | `S-7` no se redacta | Tu confirmación |
| **P-10** | Abierta (modo oscuro) | Sí/No/Postergar | No en MVP | Design system sin modo oscuro | Tu decisión |
| **P-11** | Abierta (cobertura responsive) | Diseñar ahora/sólo tablet/fuera | Sólo lo que exija el MVP | Huecos de cobertura | Tu decisión |
| **P-12** | Abierta (perfil usuario) | Sí/No | No (sin RF) | Pantalla `SIN` | Tu decisión |
| **P-13** | Abierta (constructor itinerarios) | Sí/No | No constructor complejo | RF-06 ambiguo | Tu decisión |
| **P-14** | Abierta (idiomas) | Sólo UI/UI+topónimos/completo | es-PE + quechua + topónimos por lugar | i18n abierto | Tu decisión |
| **P-15** | Abierta (patrocinios/aforo) | Reglas/badges manuales | Badges manuales sin algoritmo | RF-18/19 ambiguos | Tu decisión |
| **P-16** | Abierta (copy SLA) | (a) borrar promesa/(b) 24 h/(c) dejar | (a) mostrar espera real | Promesas incumplibles | Tu decisión |
| **P-17** | Abierta (plazo ARCO) | 10 vs 20 días | No publicar plazo; dictamen | Copy `H07M` ilegal | Dictamen legal |
| **P-18** | Abierta (Libro Reclamaciones) | Real/informativo/enlace | Decidir con asesoría; nunca RUC inventado | Copy `H08M` ilegal | Dictamen + datos reales |
| **P-19** | Abierta (incidentes) | Redactar procedimiento | Redactar con asesoría | Sin procedimiento | Dictamen + procedimiento |
| **P-20** | Abierta (textos legales) | Validar con abogado | Validación obligatoria | Publicación ilegal | Dictamen legal |
| **P-21** | Abierta (coordenadas sensibles) | Validar criterios | Validar con comunidad | Moderación automática | Comunidad + usuario |
| **P-22** | Abierta (salvaguarda cultural) | Marco normativo/consulta | Consulta + asesoría | Copy `H04M` ilegal | Comunidad + asesoría |
| **P-23** | **Redefinida: evidencia PERDIDA** | Regenerar desde Stitch | Regenerar capturas (P-24) | Sin regresión visual (V-3) | Tu autorización |
| **P-24** | Abierta (lotes Stitch) | Autorizar lote a lote | Autorizar tras P-23 | Mejora de diseño congelada | Tu autorización por lote |

> **P-09…P-22 permanecen abiertas** (no hay evidencia válida de resolución). **Ninguna se cierra para que la documentación parezca terminada.**

---

## 11. Decisiones concretas que necesitas tomar (lista numerada)

1. **Stack definitivo:** **ADOPTADO** (alineación definitiva) — Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL/PostGIS + MapLibre.
2. **Proveedor de teselas:** MapTiler, Mapbox, Stadia o Protomaps (con plan de entrada si es comercial). **Sigue pendiente (P-02).**
3. **Producción:** evaluar **IONOS** (no verificado). **Motor PostgreSQL/PostGIS adoptado (P-03); proveedor pendiente.**
4. **Contrato OTP:** **flujo adoptado (P-04)** — falta confirmar parámetros (10 min / 5 intentos / 60 s) como configuración + decidir alcance del 2FA de consola.
5. **Matriz RBAC:** **adoptada con Filament 5 (P-05)** — falta decidir firma de exportación (YubiKey o alternativa).
6. **Retención:** aprobar estructura `18` §2, criterio de reseñas y los 6 puntos jurídicos.
7. **Alcance MVP:** confirmar `13` como definitivo (o cambios).
8. **Evidencia:** autorizar regeneración de capturas desde Stitch (P-23 redefinido) y lotes L-0…L-5 (P-24).
9. **P-09…P-16:** navegación (E1–E3), modo oscuro, cobertura responsive, perfil, constructor itinerarios, idiomas, patrocinios/métricas, copy SLA.
10. **P-17…P-22:** plazos legales (ARCO, brechas), Libro de Reclamaciones, textos legales, incidentes, coordenadas sensibles, salvaguarda cultural.

---

## 12. Registro de archivos y verificaciones

### 11.1 Archivos creados / modificados en esta alineación

| Archivo | Acción |
|---|---|
| `docs/referencia/Lumina_Documento_Tecnico_Especificacion_v5.pdf` | **Movido** desde la raíz del proyecto (sólo documentación) |
| `20-alineacion-integral.md` | **Creado** (este documento) |
| `02`, `07`, `08`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `04`, `05`, `06`, `09` | **Actualizados** (correcciones y conciliaciones puntuales) |

### 11.2 Verificaciones realizadas

| Verificación | Método | Resultado |
|---|---|---|
| Estructura del proyecto | `find` | Sólo `docs/`; sin código/Git/dependencias |
| PDF v5.0 | Extracción de texto (`pypdf`) | 9 págs., versión 5.0, 2026-10-09 |
| Evidencia FASE 1.5 | `ls`/`find`/`mdfind` | **PERDIDA** (temporal limpiado) |
| Proyecto Stitch | `list_screens` (MCP, solo lectura) | 62 pantallas intactas |
| P-01…P-08 | Lectura de `11`/`15` | Correctos |
| C-1…C-5 en `08` | Lectura | Aplicados correctamente |
| Plazo brechas 48 h | DS 016-2024-JUS art. 34 | **Verificado** (con condiciones) |
| Plazos ARCO | DS 016-2024-JUS / fuentes | 8/20/10 (hábiles/calendario por confirmar) |
| Libro de Reclamaciones | INDECOPI (gob.pe) | 15 días, 2 años, físico de respaldo |
| MapTiler ToS | maptiler.com/terms/cloud | Free no comercial; offline prohibido sin acuerdo |
| Mapbox ToS | mapbox.com Product Terms 2026 | Caché dispositivo 30 días; redistribución prohibida |
| MySQL 8 espacial | dev.mysql.com | SRID sí; sin KNN/geography |
| Precios tiles/BD/email | Fuentes oficiales 2026-10-10 | Verificados (ver `15` §2/§3, `16` §5) |

> **No se marcó como verificada ninguna comprobación no realizada.** Stadia ToS quedó pendiente (URL 404); se señaló.
