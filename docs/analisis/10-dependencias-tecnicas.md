# LUMINA — Dependencias Técnicas y Obligaciones Externas (FASE 1.5)

> **Estado:** investigación de soporte para las decisiones B4–B8. **No se contrató ningún servicio, no se crearon credenciales, no se instalaron dependencias.**
> Cada bloque separa: **HECHO** (afirmación con fuente, fecha de consulta 2026-10-09) · **RECOMENDACIÓN** (nuestra, pendiente de aprobación) · **ASESORAMIENTO** (requiere especialista).
> **ALINEACIÓN DEFINITIVA (2026-10-10):** stack adoptado **Laravel 13 + Vue 3 + TS + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01/P-03/P-05 ADOPTADAS). Base de datos **PostgreSQL/PostGIS** (no MySQL). Correo **SMTP Google** (P-04). Desarrollo **local**; producción se evaluará con **IONOS** (P-03 motor resuelto; proveedor pendiente). Detalle: `11` §10.

---

## 1. Mapas y tiles (B4) — bloquea RF-01, RF-04, RF-09

> **FASE 1.7 (2026-10-10):** comparativa final de teselas con fuentes oficiales actualizadas (MapTiler, Mapbox, Stadia, Protomaps, OSM comunitario) en **`15-fase-1-7-informe.md` §2**; ante discrepancia con las cifras de este apartado (2026-10-09), manda `15`.

**HECHOS (fuentes secundarias; re-verificar en las páginas oficiales antes de contratar):**
- **MapTiler**: plan gratuito *no comercial* con 5.000 *map sessions*/mes, 1.000 búsquedas, 100.000 peticiones; **Flex $30/mes** con 25.000 sessions y sobre-coste desde $2.50/1.000 sessions. (fuente: artículo comparativo 2026, storerocket.io)
- **Mapbox**: 50.000 cargas GL JS/mes gratis + 100.000 geocodings temporales; después **$5/1.000 cargas** y $0.75/1.000 geocodings; una carga incluye hasta 12 h de sesión. (misma fuente)
- **Stadia Maps** (renderiza con MapLibre): gratuito 200.000 créditos/mes; *Starter* $20/mes con 1.000.000 de créditos. (misma fuente)
- Los renders de Stitch usan **imágenes fijas**; la pantalla real exigirá un cliente de mapa (p. ej. MapLibre GL JS, open source) + un proveedor de tiles.
- **Aviso:** "map sessions" y "cargas" se miden de formas distintas entre proveedores; **no son comparables 1:1**.

**RECOMENDACIÓN (no aprobada):**
1. Cliente open source propio (MapLibre) para no depender del SDK de un proveedor.
2. Empezar en plan gratuito para desarrollo/demo y **calcular el coste real sólo con las métricas de uso de FASE 2**; el proveedor se decide en B4.
3. Considerar descarga de tiles para offline (RF-09): los planes gratuitos suelen **limitar** el uso intensivo desde app offline → verificar límites de *session* antes de prometer "paquetes offline" (148 MB en `E01`).

**ASESORAMIENTO:** si se usa OpenStreetMap como base de datos, revisar la **política de uso de tiles** de OSM (uso productivo vía proveedor, no servidores propios a gran escala) — no verificada aquí.

---

## 2. OTP / mensajería (B5) — bloquea RF-08 (A3)

> **ALINEACIÓN DEFINITIVA (2026-10-10):** flujo OTP **ADOPTADO** (P-04): código 6 dígitos por correo **solo en registro**; cuenta pendiente hasta validar; **SMTP con cuenta de Google** (credenciales en env vars; capturador en local). Contrato completo en **`16-especificacion-otp-autenticacion.md`**. Los datos SMS de abajo no cambian.

**HECHOS:**
- **Twilio (2026)**: coste efectivo ≈ **$0.011/SMS** (incluye *carrier fee*) + **$5–7/mes fijos** (alquiler de número ≈ $1.15, 10DLC ≈ $4). Tabla orientativa: 500 SMS ≈ $10.60/mes · 2.000 ≈ $26.95 · 10.000 ≈ $114.15. Entrante $0.0083. (fuente: textbee.dev, 2026)
- Los costes fijos **dominan en volúmenes bajos** (la propia fuente lo advierte).
- **El OTP por correo tiene coste marginal ≈ 0** si ya existe un proveedor de email transaccional.

**DATO NO VERIFICADO:** tarifas/registros específicos para **Perú** (algunos países exigen registros de remitente/10DLC local). La búsqueda no arrojó tarifa peruana concreta → **no afirmar precio local**.

**RECOMENDACIÓN:** OTP **por correo como primera fase** (coincide con `B07M` y `07&08`, la mayoría de la evidencia), dejando SMS opcional (A3). Evaluar coste sólo cuando haya volumen real.

**ASESORAMIENTO:** si se elige SMS, revisar con asesor local los requisitos de envío a números peruanos y la Ley de Protección de Datos Personales aplicable a la verificación por mensaje.

---

## 3. Persistencia offline y sincronización (B7) — bloquea RF-09, V-4

**HECHOS:**
- Las propias pantallas **ya nombran la tecnología**: `11M` y `H06M` mencionan **IndexedDB + ServiceWorker**; `G05M` muestra cola local con reintento.
- La caché del Service Worker **no es base de datos**: tratarla como fuente de verdad provoca pérdida de escrituras; debe ser buffer de un backend autoritativo. (fuente técnica 2026, back4app)
- **iOS es el punto débil de las PWAs**: instalación manual desde el menú Compartir, *push* condicionado y **sin background-sync**. (misma fuente y otras)

**RECOMENDACIÓN:**
1. Cola de escritura (outbox) en **IndexedDB** con `clientId` idempotente y `POST /sync/batch` (ver `08-modelo` §6.4).
2. Backend como fuente de verdad; resolución de conflictos por **última escritura + marcado de conflicto** para reseñas (nunca merge silencioso).
3. Comunicar en UI que "cola" ≠ "publicado" (estado visible en `G05M`).

**ASESORAMIENTO:** si el cliente exige sincronización en segundo plano fiable en iOS, valorar app nativa/híbrida (decisión de alcance, no técnica).

---

## 4. Almacenamiento de multimedia (B6) — bloquea RF-17

**HECHOS (fuentes secundarias 2026):**
- **Cloudflare R2**: $0.015/GB-mes y **sin coste de egress**; **Amazon S3 Standard** ≈ $0.023/GB + egress.
- Diferencia dominante: en cargas de salida altas, S3 multiplica la factura (ejemplos publicados: ~$15 vs ~$1.050/mes para 1 TB + 10 TB de descarga).

**RECOMENDACIÓN:** almacenamiento compatible con S3 con **egress gratuito** si el consumo de fotos/vídeos es alto; confirmar tras estimar peso real (`ADM-06`, `4032×3024 · 3.4 MB` por imagen ⇒ ~3 MB × nº de fotos).

**ASESORAMIENTO:** derechos de imagen y licencias (`ADM-14` exige "sin derechos de terceros") — revisión legal del mecanismo de licencia al subir.

---

## 5. Notificaciones y balizas (A14) — bloquea RF-10, V-2

**HECHOS:**
- **Web Push** con Service Worker es viable en navegadores modernos; el `designMd`/`H05M` lo asume.
- **El geofencing en segundo plano no está disponible en PWAs**; en iOS además el *push* está condicionado y no hay *background sync*.
- Por tanto: "alerta de desvío +40 m con la app cerrada" (**`H05M`**) y "aviso 45 min antes del ocaso" **no son alcanzables como está el diseño en una PWA**.

**RECOMENDACIÓN:** MVP con alertas **en primer plano** + notificaciones programadas por horario (ocaso calculado localmente ⇒ sí funciona sin geofencing); geofencing real sólo con app nativa/híbrida. Documentar la limitación en el copy para no prometer lo que no se entrega.

**ASESORAMIENTO:** decisión de alcance (B + A14) con el usuario.

---

## 6. Analítica y consentimiento (B8) — bloquea RF-11, `H06M`

**HECHOS:**
- `H06M` ya declara consentimiento granular (telemetría, personalización, ubicación) y borrado local → el diseño **asume cumplimiento por diseño**.
- Para cookies/telemetría en Perú se cita la **Opinión Consultiva 02-2022-JUS/DGTAIPD** (consentimiento previo e informado). ⚠️ **Referencia tomada de fuentes secundarias; verificar el texto original** antes de redactar el copy legal.

**RECOMENDACIÓN:** analítica de primera parte o autoalojada (p. ej. Matomo propio) para reducir transferencias internacionales de datos; consentimiento **opt-in** por defecto.

**ASESORAMIENTO OBLIGATORIO:** el texto legal de `H04M`, `H06M`, `H07M` y `H08M` debe validarlo un especialista en derecho peruano.

---

## 7. Obligaciones legales Perú — bloquea `H07M`, `H08M`, RF-11

> **Todo este apartado requiere ASESORAMIENTO ESPECIALIZADO.** Las fuentes son artículos/secundarias consultadas el 2026-10-09; **no constituyen asesoría jurídica** y deben contrastarse con los textos normativos oficiales.
> **Alineación 2026-10-10 (verificado):** el Reglamento vigente es el **DS 016-2024-JUS** (2024-11-30, vigente desde 2025-03-30). **[VER]** Art. 34: notificación de brechas a la ANPDP y titulares en **48 h** (con condiciones: grandes volúmenes, datos sensibles o perjuicio evidente). **[VER]** Libro de Reclamaciones: **15 días hábiles** respuesta, conservación **2 años**, libro físico de respaldo (INDECOPI / DS 101-2022-PCM). **[VER]** ARCO: plazos por derecho — información 8, acceso 20, rectificación/cancelación/oposión 10 (días; hábiles/calendario por confirmar). **[VER]** ANPDP registra bancos de datos (Ley 29733 art. 29). Detalles en `20` §6.3.

| Obligación | Lo que indica la investigación | Coincidencia con Stitch | Estado |
|---|---|---|---|
| **Protección de datos personales (Ley 29733)** | Registro de bancos de datos ante la autoridad nacional; consentimiento informado; obligación de designar responsable de atender solicitudes; **respuesta ARCO máximo 20 días hábiles**; medidas de seguridad | `H06M` consentimientos y `H07M` formulario ARCO | ⚠️ **`H07M` dice "10 días hábiles"** → discrepancia → **A15** |
| **Reglamento de la Ley** | Se cita un reglamento actualizado vigente desde 2025 y notificación de incidentes de seguridad en **48 h** | No hay pantalla de incidentes | **[ABI]**: ¿procedimiento de incidentes? |
| **Libro de Reclamaciones (consumidor)** | Respuesta **máx. 15 días hábiles**; conservación **2 años**; si es virtual debe existir **respaldo físico**; INDECOPI puede requerir copias | `H08M` cita 15 días hábiles ✔ | Requiere **datos reales del operador** (RUC/domicilio actuales son ficticios) |
| **Contenido patrocinado** | Reglas de publicidad de sitios de interés económico (Ley 27336 / norma de transparencia publicitaria) | Badges "Patrocinado"/"Promovida" (`E01`, `ADM-12`) | **[ABI]** revisar obligaciones de identificación publicitaria |
| **Toponimia y salvaguarda cultural** | `H04M` menciona protección de toponimia quechua | Sin marco legal en Stitch | **ASESORAMIENTO** (posible consulta a comunidad/normativa cultural) |

---

## 8. Resumen por decisión

| Decisión | Alternativas identificadas | Coste conocido | ¿Bloquea FASE 2? |
|---|---|---|---|
| **B4** Mapas | MapTiler / Mapbox / Stadia / OSM-vía-proveedor | Gratuitos para desarrollo; desde $20–30/mes en producción | Sí (inicio del mapa) |
| **B5** OTP | Correo (≈0) vs SMS (≈$0.011/msg + $5–7/mes) | Bajo en correo | Sí, sólo si se elige SMS |
| **B7** Offline | IndexedDB + SW (ya en el diseño) + cola idempotente | Sin coste externo | No |
| **B6** Media | R2 (0 egress) vs S3 | R2 ≈ $0.015/GB-mes | No |
| **B8** Analítica | Primera parte / autoalojada / tercero | Bajo | Sí (consentimiento) |
| Legal | — | — | **Sí, para H07M/H08M** |

**Ninguna de estas alternativas está seleccionada.** Todas quedan a la espera de las decisiones en `09-decisiones-pendientes.md`.
