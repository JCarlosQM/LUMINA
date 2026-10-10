# LUMINA — Informe de FASE 1.7 (2026-10-10)

> **Alcance:** FASE 1.7 es **sólo documental**. En este informe se registran tus decisiones P-01…P-08 con estados precisos, se entrega la comparativa final de proveedores (mapas y base de datos) con fuentes y fecha, se enlazan las propuestas de matriz RBAC y política de retención, se revisan riesgos del modelo de dominio y alcance MVP, se verifica la evidencia visual y se prepara el registro de cambios Stitch **agrupado en lotes para tu autorización explícita**.
> **No se hizo:** código, Git, dependencias, migraciones, credenciales, cuentas, servicios contratados, despliegues, copias definitivas de evidencia, ni **ninguna** edición en Stitch (incluida la in-place: sigues sin autorizarla).
> **Regla de estados usada:** *aprobada como dirección* ≠ *aprobación de implementación*; nada figura como "aprobado" por el hecho de aparecer en un documento.

---

## 1. Estado de las decisiones P-01 … P-08

| ID | Decisión | Estado preciso (FASE 1.7) | Qué quedó resuelto | Qué sigue pendiente |
|---|---|---|---|---|
| **P-01** | Stack combinado (React+TS+Vite · Node+TS · REST+OpenAPI · PostgreSQL+PostGIS · Vitest/Playwright/axe-core) | **APROBADA COMO DIRECCIÓN** | Dirección técnica del MVP; desbloquea la planificación de FASE 2 | **No autoriza** instalar dependencias ni crear proyecto. **SSR vs prerenderizado híbrido: PENDIENTE** (afecta SEO, rutas públicas, despliegue, mantenimiento) |
| **P-02** | Motor de mapas y proveedor de teselas | **PARCIAL: motor ADOPTADO (MapLibre); proveedor PENDIENTE DE APROBACIÓN** | MapLibre como motor (coherente con `designMd`) | Proveedor de teselas sin cerrar; comparativa final en §2; MapTiler sólo **candidato a desarrollo**; sin cuentas ni claves creadas |
| **P-03** | Base de datos gestionada vs VPS | **PREFERENCIA REGISTRADA + comparativa entregada → PENDIENTE DE APROBACIÓN** | Preferencia inicial por PostgreSQL+PostGIS gestionado queda registrada | Proveedor y entorno de producción sin elegir (§3); sin contratar nada |
| **P-04** | OTP por correo | **CANAL ADOPTADO + especificación entregada → PENDIENTE DE APROBACIÓN** | Canal correo confirmado (D-06); especificación en `16` (parámetros, errores, eventos, aislamiento del proveedor) | Aprobar el contrato (`16` §3), el proveedor de email (`16` §5) y el asunto 2FA/TOTP de consola (`16` §7) |
| **P-05** | Roles y permisos | **PRINCIPIO ADOPTADO (Explorador + 3 niveles) + matriz leída campo a campo y propuesta entregada → PENDIENTE DE APROBACIÓN** | `ADM-18` leído permiso a permiso (ítem `#27` cerrado); propuesta en `17` | La **matriz 15×3 y el "comité de tres" NO aprobados**: falta tu aprobación campo a campo de `17` (matriz 15×4 propuesta + reglas RS-1…RS-9) |
| **P-06** | Modelo de dominio y API (`08`) | **APROBADA COMO BASE PROVISIONAL CON CONDICIONES** | `08` es base provisional de análisis; ajustes **C-1…C-5 aplicados** (C-1 notificaciones, C-2 reportes, C-3 idioma de rutas, C-4 anotado, C-5 actualización por D-06/07/10/12) | **NO** genera migraciones, contratos definitivos ni endpoints funcionales todavía; C-4 (fuente de métricas) espera P-15; C-6/C-7 abiertas (P-03, P-07) |
| **P-07** | Retención y anonimización | **PROPUESTA ENTREGADA → PENDIENTE DE APROBACIÓN + VERIFICACIÓN JURÍDICA** | Estructura de política por categoría en `18`, sin plazos inventados | 6 puntos jurídicos de `18` §4 + criterio de reseñas; **ningún plazo aprobado** |
| **P-08** | Alcance del MVP (`13`) | **ACEPTADA COMO PROPUESTA DE PLANIFICACIÓN (provisional), NO especificación definitiva** | `13` sirve para planificar FASE 2 | Revisión SEO/offline/permisos/moderación/costes en §7; cambios de alcance, si los hubiera, se presentan antes de considerarse aprobados |

**Sobre P-09…P-24:** FASE 1.7 **no** las resuelve ni las marca; siguen registradas en `11` §5.2/§5.3 a la espera de tus respuestas.

---

## 2. Comparativa final de mapas y teselas (fuentes y fecha de consulta: **2026-10-10**)

Motor: **MapLibre (adoptado)**. Sólo cambia quién sirve las teselas:

| Proveedor | Modelo | Capa gratuita | Coste de entrada (pago) | Uso comercial | Atribución | Caché / offline | Salida |
|---|---|---|---|---|---|---|---|
| **MapTiler** | Por sesión + requests | **Free $0: sólo no comercial** (prueba/personal); cuota limitada, se pausa al agotarla | **Flex 30 US$/mes** (25 k sesiones; exceso +2,50 US$/1 k sesiones, +0,15 US$/1 k requests) | Free: **no** · Flex: sí | Obligatoria (página de precios; texto exacto: verificar términos al contratar) | términos de caché: **verificar** (PENDIENTE-VERIFICACIÓN) | Cliente estándar; datos propios exportables; sin atadura fuerte *(maptiler.com/cloud/pricing)* |
| **Mapbox** | Por "map load" | 50 k cargas/mes gratis; 1 carga incluye requests **ilimitados** de teselas | Después: 5 US$/1 k (50–100 k), 4 US$/1 k, 3 US$/1 k, 2,50 US$/1 k | Sí, con cuenta | Obligatoria (© Mapbox y OpenStreetMap) | términos de caché: **verificar** (PENDIENTE-VERIFICACIÓN) | SDK propio; salida posible con esfuerzo *(mapbox.com/pricing)* |
| **Stadia Maps** | Por créditos (1 tesela vectorial = 1 crédito) | Free: 200 k créditos/mes **sólo no comercial** | **Starter 20 US$/mes** (1 M créditos, +3 ¢/1 k) · Standard 80 US$/mes (7,5 M) · Professional 250 US$/mes (25 M) | Free: **no** · de Starter en adelante: sí | Obligatoria | existe producto "Cacheable Static Maps" con precio propio; teselas: verificar ToS (PENDIENTE) | SDK open source; sin telemetría declarada *(stadiamaps.com/pricing)* |
| **Protomaps (autoalojado)** | Sin cuota por uso: pagas tu CDN | Sin "free tier": pagas infraestructura | Calculadora oficial: **≈11,45 US$/mes en Cloudflare** y **≈119,56 US$/mes en AWS** para 625 k sesiones/1 TB (incluye Workers, R2/S3, cache hit 50 %) | Sí (tus datos) | ODbL de OSM | **Diseñado para caché/CDN**; mejor encaje con offline | Máxima: datos y CDN propios; migrar = cambiar origen *(docs.protomaps.com/deploy/cost)* |
| **OSM comunitario (`tile.openstreetmap.org`)** | Donaciones | Sólo mapeadores/vista ligera | — | La política **prohíbe** uso pesado | Obligatoria | **Prohíbe** descarga masiva y uso sin conexión; sin SLA; bloqueo sin aviso | — *(operations.osmfoundation.org/policies/tiles/)* → **no viable para producción**; afecta al offline de 148 MB de `E01` |
| **Google Maps** | Suscripciones escalonadas (fuentes secundarias citan 100/275/1.200 US$/mes) | Muy limitada | Alta | Sí | Obligatoria | restringida | **Peor salida**: resultados atados a su renderizador *(comentarios de Stadia, secundarios)* |

**Advertencias importantes:**
1. **MapTiler Free y Stadia Free son "no comerciales"**: usarlas en un proyecto con vocación comercial (incluso en desarrollo de una empresa) puede incumplir sus términos — verificarlo antes de elegir "gratis".
2. **Offline (RF-09, paquetes de 148 MB)**: OSM comunitario lo prohíbe explícitamente; Protomaps es el más compatible con caché pesada; para MapTiler/Mapbox/Stadia los términos de caché quedan **PENDIENTE DE VERIFICACIÓN** con cita de los ToS.
3. **Atribución ODbL**: todo uso de datos OSM exige atribución visible (política OSMF y licencia) — impacta en el diseño de mapas.
4. **Precios = consulta del 2026-10-10**; re-verificar al contratar (los tres primeros son páginas oficiales; el bloque AWS de Protomaps y el rango VPS de §3 mezclan fuentes oficiales y secundarias, señaladas).

**Recomendación (PROPUESTA, pendiente de P-02):** MapLibre + **candidato MapTiler para desarrollo** *sólo si tu actividad se considera no comercial*, o un plan de entrada (MapTiler Flex 30 US$/mes o Stadia Starter 20 US$/mes) si es comercial; decisión de proveedor de pago **sólo con métricas reales**; evaluar **Protomaps** si el offline pesado se confirma (coste bajo de CDN pero operación propia). **No se ha creado ninguna cuenta ni clave.**

---

## 3. Comparativa de base de datos gestionada frente a VPS propio (consulta **2026-10-10**)

| Dimensión | **Gestionado (Neon / Supabase)** | **VPS propio (p. ej. Hetzner)** |
|---|---|---|
| Coste inicial | **Neon**: plan gratuito permanente (≈1 GB/proyecto, sin tarjeta; escala a cero en reposo) · **Supabase**: gratuito 500 MB (los proyectos gratuitos se pausan por inactividad; de pago no). De pago: facturación por uso (Neon: CU ≈4 GB RAM, se factura por hora, sin mínimo — p. ej. 0,106 US$/CU-hora + 0,35 US$/GB-mes en Launch) o **Supabase Pro 25 US$/mes** con cómputo aparte (≈10 US$/mes por proyecto pequeño) | Servidor pequeño ≈ **5–20 €/mes** (fuente secundaria *Northflank*, competidora — blog de subidas de precios de Hetzner del 15/06/2026: CPX22 7,99→19,49 €/mes; **re-verificar en la calculadora oficial de Hetzner**, con IPv4 y almacenamiento aparte) |
| Copias de seguridad | Automáticas del proveedor (Supabase: diarias con retención del plan; Neon: restauración instantánea + snapshots de pago ≈0,09 US$/GB-mes) | **Tú** diseñaslas: frecuencia, retención, cifrado, **fuera del mismo servidor** |
| Restauración | Ejercitable desde el panel; coste del snapshot conocido | Debes probarla y mantenerla tú: alto riesgo de "backup nunca restaurado" |
| Actualizaciones de seguridad | A cargo del proveedor (Postgres, parches, OS) | **A cargo tuyo**: parches, upgrades de PostGIS, ventana de mantenimiento |
| Disponibilidad | SLA según plan (Neon Scale / Supabase Team); el gratuito es mejor esfuerzo | **Best-effort** sin SLA del proveedor; alta disponibilidad = tu diseño (réplicas, failover) |
| Mantenimiento | Bajo: escalado, restauración y métricas incluidas en el producto | Alto: backups, monitoreo, certificados, limpieza, crecimiento |
| PostGIS | Soportado (Neon: extensiones como PostGIS entre las disponibles) | Total libertad de versión |
| Residencia de datos | Región elegible; verificar política del proveedor | Elección total del datacenter (p. ej. UE) |
| Salida | Dump estándar de Postgres = portabilidad alta | Total |

**Lectura para LUMINA:** el MVP tiene **bajo tráfico esperable** y **una sola base relacional con consultas espaciales**; el gestionado elimina operación a cambio de un techo de coste algo mayor. **Recomendación (PROPUESTA, pendiente de P-03):** gestionado (Neon o Supabase, comparando límites exactos al contratar) para desarrollo y MVP; revisar en VPS sólo si el coste a escala o la residencia lo exigen. **Sin contratar ni desplegar nada.**

---

## 4. Matriz RBAC propuesta (resumen — detalle y aprobación en `17-matriz-rbac-propuesta.md`)

- **`ADM-18` leído campo a campo** (ítem `#27` cerrado): 15 permisos en 5 grupos; la configuración mostrada corresponde a **TIER 2 con "10 de 15 Permisos Activos"** — el cuadre por permiso es exacto (G1: 3 · G2: 2 · G3: 3 · G4: 2 · G5: 0).
- **Propuesta `17`:** matriz **15 × 4** (TIER 1 = 15/15 según etiqueta "Acceso Total"; TIER 2 = observado; **TIER 3 = propuesto** porque la evidencia no muestra su configuración; EXPLORADOR = 0/15) + mapeo de acciones administrativas a endpoints + **reglas de separación de funciones RS-1…RS-9** (autor ≠ aprobador, nadie edita su propio rol, eliminaciones con doble control, auditoría no autogestión, desindexación ARCO sólo TIER 1, permisos evaluados en servidor) + **10 riesgos R-B1…R-B10**.
- **NO aprobado:** la matriz 15×3 del planteamiento histórico, el "comité de tres" como rol (se propone como regla de aprobación RS-9) y la columna TIER 3. Todo espera tu aprobación campo a campo (P-05).

---

## 5. Propuesta de retención y anonimización (resumen — detalle en `18-politica-retencion-anonimizacion.md`)

- **Sin plazos inventados ni aprobados.** `18` clasifica 11 categorías de dato (cuenta, autenticación, consentimientos, reseñas, multimedia, moderación, auditoría, solicitudes ARCO, telemetría, cola offline, contenido editorial) con finalidad, acceso (según `17`), retención **POR DEFINIR**, tratamiento (borrado vs anonimización) y consecuencias.
- **6 puntos marcados [JURÍDICO]** quedan para asesoría (P-17…P-20): plazos de cuenta, reseñas ante supresión, conservación de moderación/auditoría, pruebas de consentimiento/ARCO, telemetría y Libro de Reclamaciones.
- Se aclara que el "plazo de 15 días hábiles" que aparece en `H08M` es de **respuesta**, no de retención — no se reutiliza como política.

---

## 6. Riesgos y ajustes del modelo de dominio y API (P-06)

**Ajustes aplicados en `08` (bajo tu aprobación condicional de P-06):**

| Ajuste | Qué se hizo en `08` |
|---|---|
| **C-1** | Nueva entidad `NotificationPreference` + endpoints `GET/PATCH /me/notification-preferences` (RF-10 / flujo V-5 / `H05M`), coherente con D-07 (sólo primer plano) |
| **C-2** | Nueva entidad `Report` + `POST /reports` (la pestaña "Reportes" de `ADM-13` ahora tiene origen de dato) |
| **C-3** | Rutas unificadas a inglés: `POST /itineraries` (antes `/itinerarios`); el nombre histórico queda anotado |
| **C-4** | `GET /admin/metrics` queda **anotado** con "fuente de métricas sin modelar → P-15"; no se inventa entidad |
| **C-5** | §2 actualizada: OTP por correo (D-06), notificaciones primer plano (D-07), gamificación fuera del MVP (D-10), email no visible en moderación (D-12) |

**Coherencia verificada:** RF-01…RF-19 y los flujos V-1…V-5 / A-1…A-4 conservan entidad o endpoint (verificación de `11` §4.4); los huecos C-1/C-2 quedan cerrados con entidades provisionales; **siguen abiertos**: fuente de métricas (C-4 → P-15), motor/esquema físico (C-6 → resuelto en dirección por P-01, pendiente de P-03) y retención (C-7 → `18`, pendiente P-07).

**Riesgos vigentes del modelo (además de R1–R12 de `08` §5):**
1. **Autorización sin matriz aprobada** (P-05): implementar T-4 con permisos inventados → riesgo R-B1.
2. **OTP sin contrato aprobado** (P-04): T-4 bloqueado hasta aprobar `16` §3.
3. **Métricas sin origen** (C-4): no prometer `ADM-17` hasta P-15.
4. **Reportes anti-abuso**: `POST /reports` necesitará rate limit y anti-spam al implementarse (se anota en `08`).
5. **Retención sin campos de purga** (C-7): el esquema de FASE 2 deberá prever `deletedAt`/`anonymizedAt` según `18`.

---

## 7. Revisión del alcance del MVP y del enfoque SEO (P-08)

`13-alcance-mvp.md` queda marcado como **propuesta de alcance para planificación**. Puntos revisados:

| Punto | Revisión |
|---|---|
| **SEO híbrido** | El mapa full-bleed con shell SPA (MapLibre) no sirve HTML de contenido por sí solo. Las **rutas públicas de lugar/ruta** necesitarán **SSR o prerenderizado híbrido** → depende de la decisión residual de **P-01**; sin ella, no se garantiza indexación de fichas. SEO técnico básico (sitemap, meta, OG, robots, canonical) es compatible con ambas opciones y no bloquea la planificación |
| **Offline** | RF-09 con paquetes de 148 MB: los términos del proveedor de teselas lo condicionan (§2, advertencia 2); OSM comunitario lo prohíbe. Mantener el MVP offline **pendiente de P-02** |
| **Permisos / consola** | La consola (I-4) depende de **P-05**: sin matriz aprobada no se implementa autorización |
| **Moderación** | Cola aprobada (RF-07); copy de SLA pendiente (**P-16**, D-08); "Reglas AI" congeladas (D-13/P-21) |
| **Costes externos** | Estimación de arranque **ESTIMACIÓN, no compromiso**: teselas 0–30 US$/mes · email 0 US$/mes (planes gratuitos) · BD 0–25 US$/mes → **≈0–55 US$/mes** con planes de entrada |
| **Funciones sin diseño completo** | perfil (P-12), tablet (S-3), estados de búsqueda (S-4), estados CRUD (S-5), recuperación de contraseña y detalle de ruta móvil (S-8), modo oscuro (P-10), cobertura responsive (P-11) |

**Cambios de alcance propuestos: ninguno nuevo.** La revisión no identifica recortes obligatorios; los puntos anteriores son **pendientes de decisión**, no modificaciones aplicadas a `13`.

---

## 8. Estado y plan de conservación de la evidencia visual (P-23)

**Verificación (2026-10-10):**

| Ubicación (ruta temporal) | Contenido | Archivos | Tamaño |
|---|---|---|---|
| `…/T/opencode/lumina-evidence/screens/` | captura viewport + HTML por pantalla | **124 (62 PNG + 62 HTML)** ✔ esperado | 7,0 MB |
| `…/screens-full/` | PNG de página completa | 62 | 43 MB |
| `…/crops/` | recortes de región citados en `05` | 38 | 13 MB |
| `…/texto-pantallas.txt` | texto extraído (citas literales) | 1 | 164 KB |
| **Total** | | **226** | **≈63 MB** |

- Cada archivo lleva `<ID pantalla>__<ID de Stitch>` en el nombre; **inventario completo PNG/HTML ↔ ID Stitch generado en `19-inventario-evidencia-fase1-5.md`** (62/62 parejas completas).
- **Inspección de solo lectura del proyecto Stitch:** `list_screens` devuelve **62 pantallas** (32 móviles, 29 escritorio, 1 logotipo) = baseline de FASE 1.5 intacto; nada añadido, editado ni eliminado.
- **Riesgo:** la ruta está bajo temporales del sistema → se pierde con la limpieza.

**Plan de conservación (NO ejecutado — pendiente de tu autorización P-23):**

| Opción | Ruta propuesta | Espacio | Efecto |
|---|---|---|---|
| **A (recomendada)** | `/Users/juancarlo/Documents/SistemasDemos/Lumina-evidencia-fase1-5/` (carpeta externa estable, hermana del proyecto) | **≈63 MB** | No infla el futuro repositorio; originales temporales intactos |
| **B (alternativa)** | `/Users/juancarlo/Documents/SistemasDemos/Lumina/evidencia/fase1-5/` (dentro del proyecto) | **≈+63 MB al repo** | Todo junto; habrá que excluirlo del versionado o asumirlo |

- Copia con `cp -R` (**duplicado, sin mover ni sobrescribir**); el manifiesto `19` viaja junto para verificación posterior (recuento y hashes de nombre).
- **Ruta y espacio informados arriba; sin tu "sí" (y elección de A o B), no se copia nada.**

> **Estado 2026-10-10 (Alineación integral):** la evidencia **ya no está accesible** — el directorio temporal del sistema fue limpiado entre sesiones (0 archivos inspeccionados). Las opciones A/B **quedan sin objeto**; P-23 se redefine como *regenerar capturas desde Stitch* (intacto). Ver `20-alineacion-integral.md` §8.

---

## 9. Cambios de Stitch propuestos — SIN EJECUTAR, agrupados en lotes (P-24)

**Ningún cambio se ha ejecutado.** La edición **in-place** de diseños existentes **sigue sin estar autorizada** (restricción tuya vigente); los lotes quedan listos para que autorices cada uno por separado. El registro detallado (ID de pantalla, estado original, problema, solución, impacto y reversión) vive en `14-plan-fase-2.md` §2.2 (ampliado con impacto y lote).

| Lote | Pasos | Objetos (ID) | Impacto | Reversión | Estado |
|---|---|---|---|---|---|
| **L-0** | S-0 | Evidencia + `designMd` (sólo lectura) | Ninguno (copia) | Total | Bloqueado por **P-23** (elegir opción A/B) |
| **L-1** | S-1, S-2 | `designMd` (prosa de color; tokens de estado) | Sólo documentación en Stitch; **sin cambios visuales** | Media (respaldar `designMd` en S-0) | **No autorizado**: es edición in-place del recurso |
| **L-2** | S-3 | 5 pantallas tablet 768–1024 nuevas (`C01`, `C02M`, `D01`, `D02M`, `E01`) | Pantallas nuevas (sin `delete_screen` en MCP) | Limitada (retirada manual) | Pendiente de autorización; 1 en 1 |
| **L-3** | S-4, S-5, S-8 | Pantallas nuevas con respaldo RF (búsqueda, estados CRUD, recuperación contraseña, detalle de ruta móvil) | Pantallas nuevas | Limitada | Pendiente de autorización; **perfil excluido** (P-12) |
| **L-4** | S-6 | `D01`/`G01M` vs `01`/`C01`; `H08M` (cifras de muestra, RUC ficticio) | Copy en pantallas existentes (in-place) | Media | **No autorizado**: in-place; requiere además P-18 para el bloque legal |
| **L-5** | S-7 | `G10M`, `07&08`, `ADM-13`, `09&10`, `12T`, `H05M`, `H01M`, 6 bottom-navs | Copy y navegación (in-place) | Media | **No autorizado**: in-place; además depende de **P-09** (nav) y **P-16** (SLA) |

**Regla por lote:** antes de ejecutar, registro por pantalla del estado original; entre pasos, verificación con `list_screens` (recuento e IDs intactos); ninguna pantalla se borra ni fusiona; nada que exija inventar datos reales, plazos legales ni reglas de negocio.

---

## 10. Decisiones concretas que requieren tu aprobación

| # | Decisión | Dónde se decide | Bloquea |
|---|---|---|---|
| 1 | **SSR vs prerenderizado híbrido** (residual P-01) | `11` P-01 | SEO de rutas públicas, despliegue |
| 2 | **Proveedor de teselas** (comparativa §2) + verificar ToS de caché | `11` P-02 | Costes, offline |
| 3 | **BD gestionada (Neon/Supabase) o VPS + entorno de producción** (§3) | `11` P-03 | Esquema físico, T-3 |
| 4 | **Contrato OTP** (`16` §3), **proveedor de email** (`16` §5) y **2FA/TOTP de consola** (`16` §7) | `16` / P-04 | T-4 (auth) |
| 5 | **Matriz RBAC campo a campo** (`17` §2–§4: matriz 15×4, acciones administrativas, RS-1…RS-9, YubiKey) | `17` / P-05 | Consola, autorización |
| 6 | **Política de retención**: estructura `18` §2, criterio de reseñas y los 6 puntos [JURÍDICO] `18` §4 | `18` / P-07 | Esquema de purga, privacidad |
| 7 | **Alcance del MVP**: confirmar `13` como base de planificación y cualquier cambio de alcance de la revisión §7 | `11` P-08 | I-1…I-5 |
| 8 | **Conservación de evidencia**: opción **A** (externa, 63 MB) u **B** (en el repo, +63 MB) | P-23 / `19` | Copia definitiva |
| 9 | **Lotes de Stitch L-1…L-5** (§9): autorizar lote a lote; la edición in-place sigue prohibida salvo que autorices L-1/L-4/L-5 explícitamente | P-24 / `14` | Mejora de diseño |
| 10 | P-09…P-22 (navegación, diseño, legal): siguen abiertas sin cambios de FASE 1.7 | `11` §5.2/§5.3 | Diseño, publicación |

> **Documentos nuevos de FASE 1.7:** `15` (este informe), `16` (OTP), `17` (RBAC), `18` (retención), `19` (inventario de evidencia). Actualizados: `02`, `04`, `08`, `09`, `10`, `11`, `12`, `13`, `14`. **Fuera de `docs/analisis/` no se tocó nada** (verificado: el árbol del proyecto sólo contiene `docs/`).
