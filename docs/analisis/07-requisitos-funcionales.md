# LUMINA — Requisitos Funcionales y Flujos (FASE 1.5)

> **Origen:** exclusivamente pantallas de Stitch y `designMd`. Cada requisito indica su fuente y su tipo de evidencia.
> **Convención:** `[DOC]` = documentado literalmente en un artefacto · `[DER]` = derivado de la estructura de la pantalla (interpretación marcada) · `[ABI]` = requiere definición, no se ha inventado respuesta.
> No se han creado reglas de negocio nuevas: cuando falta una, aparece como `[ABI]`.

---

## 1. Actores identificados (evidencia)

| Actor | Evidencia | Acceso |
|---|---|---|
| **Visitante invitado** | `B08M` "modo solo lectura" / "Sesión No Autenticada" | Explora mapa, lugares, rutas; **no** guarda ni reseña |
| **Explorador (registrado)** | `B04M`/`B07M`; "Exploradores 1,420" en `ADM-10` | Favoritos, itinerarios, reseñas, notas, descargas offline |
| **Moderador / Custodio** | `09&10` "Moderador Cultural Nivel 2"; `ADM-13` "Custodio"; "Custodios 18" | Cola de moderación, dictamen |
| **Editor / Topógrafo** | `ADM-18` "Editor de Contenido y Topógrafo"; `ADM-08` "Curador Territorial" | Alta/edición de lugares y rutas, importación GPX |
| **Super Admin** | `ADM-18` "Super Admin Criptográfico"; `ADM-02` "Super Admin Territorial"; "Super Admin 2" | RBAC, auditoría, métricas, usuarios |
| **Curador local (tercero)** | `07&08` "comité de tres curadores locales" / "curadores acreditados" | `[ABI]` si es rol de sistema o externo |

> **[ABI-ROL]** Coexisten tres modelos de roles (`09&10`, `ADM-18`, `07&08`). Ver `09-decisiones-pendientes.md` (A13).

---

## 2. Requisitos funcionales — Visitante

### RF-01 — Exploración cartográfica
- **Fuente:** `01`, `C01`, `01M&02`, `C02M`, `C10M`.
- `[DOC]` Mapa a sangre como superficie principal con capa editorial encima (REQ-UI-01).
- `[DOC]` Filtro por categorías: Todos, Miradores de altura, Gastronomía viva, Haciendas coloniales, Arqueología Inca (`01`) / Miradores, Naturaleza, Gastronomía, Historia viva, Rutas (`C01`).
- `[DOC]` Búsqueda con atajo `⌘K`, geolocalización ("Modo Seguir", `my_location`), control de capas, escala, fecha de actualización de mosaicos.
- `[DOC]` Listado lateral de lugares con: altitud (m.s.n.m.), valoración y nº de reseñas, distancia, precio o "Gratuito", badge de contenido (`Vídeo 20s`) y **badge "Patrocinado"**.
- `[ABI]` ¿Cuántos lugares por defecto y con qué ordenación? `01` dice "24 LUGARES" sin criterio. `[ABI]` ¿El patrocinio se filtra/ordena?

### RF-02 — Consulta y búsqueda
- **Fuente:** `C01`, `C02M`, `C05M`, `07&08` (panel "Voces del Valle").
- `[DOC]` Búsqueda con sugerencias y filtros (p. ej. "Desnivel > 800 m", "Idioma: Español/Quechua", "Acceso abierto todo el año").
- `[DOC]` Estado sin resultados con recomendaciones y "Consejo cartográfico" (`C05M`).
- `[DOC]` Sugerencia de autocomplete completa ("Santuario del Señor de Muruhuay y Mirador Huanuillo").
- **Hueco:** no existe pantalla de **resultados con contenido** (ver `06` §4.1). `[ABI]` diseño de resultados.
- `[ABI]` Índice de búsqueda (topónimos, sinónimos quechua) — `H02M` exige toponimia.

### RF-03 — Ficha editorial de lugar
- **Fuente:** `03`, `D01`, `D02M`.
- `[DOC]` Contenido: hero fotográfico, galería con vídeo (18–22 s), ficha técnica (altitud, dificultad, duración, desnivel), estado de acceso (`lock_open` "Acceso libre"), ubicación (GPS decimal + hoja topográfica 23-M), descripción editorial, horarios y precios (`S/ 35 - 75`), medios de pago (`Yape`, `Plin`), valoración con histograma, reseñas recientes, mapa.
- `[DOC]` Acciones: "Guardar en Favoritos/Mi Lista", "Añadir a Itinerario", "Compartir", "Descargar offline" (`D02M`).
- `[DOC]` Sello de curaduría ("Curado LUMINA", "Verificado por curadores locales").
- `[ABI]` Si el acceso requiere permiso, `D01` muestra "estado en tiempo real" sin definir fuente del dato.

### RF-04 — Rutas temáticas y modo seguir
- **Fuente:** `E01`, `E03`, `E06M`, `04&05`.
- `[DOC]` Catálogo con rutas filtrables; cada ruta: distancia, desnivel acumulado, cota máxima, paradas, dificultad, duración.
- `[DOC]` Detalle con track GPX, waypoints/hitos, paquete offline descargable (148 MB) y estado de descarga.
- `[DOC]` Modo seguir: progreso (%), velocidad, siguiente waypoint, avisos de proximidad ("Te estás aproximando a un lugar · 500 m"), toggle de notificaciones, badge de patrocinio (**"Patrocinado" / "NO PATROCINADA"**).
- `[DOC]` Importación de trazas por el equipo: GPX 1.1 y GeoJSON (`ADM-08`).
- `[ABI]` Cálculo de ruta (¿solo traza subida o router de red?); `[ABI]` fuente de velocidad (GNSS del dispositivo).

### RF-05 — Favoritos ("Mi Lista")
- **Fuente:** `F01M`, `F02M`, `06M`.
- `[DOC]` Guardar/quitar lugares; listado con estado vacío (`F02M`); agrupación en "Lugares (8)".
- `[DOC]` Disponible invitado solo lectura; guardar requiere sesión (`B08M`).

### RF-06 — Itinerarios
- **Fuente:** `F04`, `06M`, `01` ("Mis Itinerarios"), `ADM-02` ("+ Crear Itinerario").
- `[DOC]` Crear, listar y filtrar por estado (`Todos(3)`, `En curso/Borradores(2)`, `Completados(1)`).
- `[DOC]` Detalle: título, descripción, paradas con horarios, métricas (paradas, distancia, desnivel, cota máxima), día 1 de 2, "Próxima: Hacienda La Florida (1.4 km)".
- `[DOC]` Descarga offline por itinerario (8.4 MB) y espacio ocupado total (24.6 MB).
- `[DOC]` Notas geográficas asociadas (`06M` "Notas", "Añadir notas geográficas").
- `[ABI]` Regla de creación (mínimo de paradas, duración máxima, ¿automático desde ruta?). `[ABI]` ¿Compartir itinerarios? (`F04` muestra icono compartir).

### RF-07 — Reseñas de la comunidad
- **Fuente:** `G01M`, `G04M`, `G05M`, `G10M`, `07&08`.
- `[DOC]` Listado con histograma 5→1, total de testimonios y filtros.
- `[DOC]` Formulario: valoración numérica con etiqueta ("5.0 / Sobresaliente"), texto largo (recomendación de 600 caracteres), **hasta 3 fotos**, casilla obligatoria de código ético, verificación de geolocalización, aviso de privacidad.
- `[DOC]` Envío a moderación con confirmación y expectativa de respuesta ("2 a 6 horas"; `07&08` dice "máximo 12 horas") → **[ABI]** cuál es el SLA real (A12).
- `[DOC]` Fallo de envío ⇒ respaldo local y reintento (`G05M`, id `#1049`).
- `[DOC]` Estados de moderación visibles: Pendiente, Aprobado, Rechazado con motivo (`07&08`, `ADM-15`).
- `[DOC]` Gamificación: "+40 pts de Explorador Ético" → **[ABI]** si es requisito (A16).
- `[ABI]` Reglas de rechazo (¿lenguaje, exactitud geográfica, derechos de imagen? `ADM-13` menciona "detección automática de coordenadas sensibles" y "Reglas AI" configurables).

### RF-08 — Registro, acceso y sesión
- **Fuente:** `B01M`, `B02M`, `B04M`, `B07M`, `B08M`, `ADM-01`.
- `[DOC]` Login con correo y contraseña, validación inline con mensajes de error (`Formato erróneo`, `campo obligatorio`), "Mantener sesión iniciada".
- `[DOC]` Registro: nombre, correo, aceptación de privacidad; verificación posterior.
- `[DOC]` OTP de 6 dígitos con temporizador y reenvío; "Código despachado… el estado de registro no revela afiliación previa" (no *enumerar* usuarios).
- **ADOPTADO (alineación definitiva, P-04):** verificación por correo con código de 6 dígitos **solo durante el registro**; la cuenta queda **pendiente de verificación** hasta validar el código; no se repite en cada login; no es 2FA por acceso. Parámetros propuestos: 10 min / 5 intentos / 60 s (a definir en configuración y contrato). Detalle: `16`.
- `[DOC]` Vías de acceso alternativas rotuladas: "DNI / Clave", "Bitácora Andina", "credencial cultural" → **[ABI]** si son reales.
- `[DOC]` Accesos sociales (Google, Facebook, Apple) en `ADM-01` → **[ABI]** si aplican al visitante.
- `[ABI]` Canal del OTP: **correo ADOPTADO** (P-04; D-06). SMS queda como ampliación futura, fuera del MVP.
- `[ABI]` Recuperación de contraseña: existe el enlace, no la pantalla. **Fuera de alcance hasta autorización expresa** (alineación definitiva).

### RF-09 — PWA, modo offline y sincronización
- **Fuente:** `A01M–A04M`, `11M`, `H06M`, `G05M`, `F04`, `E01`.
- `[DOC]` Instalable, bienvenida, estado de carga, estado sin conexión recuperable.
- `[DOC]` Paquetes descargables (mapa base, ruta, itinerario) con gestión de espacio y cola de sincronización con "Forzar envío".
- `[DOC]` Tecnologías nombradas en las pantallas: **IndexedDB** y **ServiceWorker** (`11M`, `H06M`).
- `[DOC]` Las reseñas fallidas se encolan localmente y se reenvían (`G05M`).
- `[ABI]` Política de expiración/conflicto de datos offline; `[ABI]` tamaño máximo de paquete (148 MB en `E01`).

### RF-10 — Configuración, idioma y notificaciones
- **Fuente:** `H01M`, `H02M`, `H05M`.
- `[DOC]` Preferencias de campo, idioma (Español/Quechua) y **toponimia** (nombres locales/quechua), unidad de altitud, modo de datos.
- `[DOC]` Notificaciones: nuevas reseñas, alertas de ruta, recordatorios, **balizas de proximidad** (desvío +40 m, aviso 45 min antes del ocaso) vía Web Push + Service Worker.
- `[ABI]` La capacidad de fondo de `H05M` no existe en PWA → A14 y `10-dependencias-tecnicas.md`.

### RF-11 — Privacidad, derechos ARCO y reclamaciones
- **Fuente:** `H04M`, `H06M`, `H07M`, `H08M`.
- `[DOC]` Toggles de consentimiento (telemetría, personalización, ubicación), borrado de telemetría local, portabilidad de datos, baja con supresión anonimizada, directriz de minimización de ubicación.
- `[DOC]` Derechos ARCO con formulario y plazo ("10 días hábiles" → A15, revisar a 20 según fuentes externas).
- `[DOC]` **Libro de Reclamaciones Virtual** completo (RUC, domicilio, medio, detalle, monto, plazo "15 días hábiles").
- `[ABI]` Responsable/legal a cargo (el RUC mostrado es ficticio).

---

## 3. Requisitos funcionales — Consola administrativa

### RF-12 — Acceso y dashboard
- **Fuente:** `ADM-01`, `ADM-02`.
- `[DOC]` Acceso independiente con credenciales de staff; dashboard con KPIs (parajes, rutas, moderación pendiente, favoritos), temporadas/filtros de periodo, acciones rápidas ("+ Nuevo Lugar", "+ Trazar Ruta"), estado de sincronización.

### RF-13 — Gestión de lugares (CRUD)
- **Fuente:** `ADM-03`, `ADM-04`, `ADM-05`, `ADM-11`.
- `[DOC]` Listado con filtros y estados; alta con formulario completo; edición; **curaduría de destacados**.
- `[ABI]` Campos obligatorios y validaciones concretas (no se derivan de la miniatura; requiere lectura campo a campo en FASE 2).

### RF-14 — Gestión de rutas e importación GPX
- **Fuente:** `ADM-07`, `ADM-08`, `ADM-09`.
- `[DOC]` Listado de rutas; asistente de 4 pasos: (1) subir GPX/GeoJSON con parseo (`GPX 1.1`, `1,420 nodos`, 348 KB) y validación, (2) metadatos y dificultad, (3) hitos y **balizas de proximidad**, (4) salvaguarda y alertas; "Guardar Borrador" / "Validar y Publicar".
- `[DOC]` Edición posterior con reordenación de waypoints (arrastrar) e inserción entre hitos (`ADM-09`).
- `[ABI]` Validaciones del parser (tamaño, número de puntos, CRS, reproyección).

### RF-15 — Gestión de usuarios y RBAC
- **Fuente:** `ADM-10`, `ADM-18`.
- `[DOC]` Directorio con contadores por rol y estados (activo/suspendido); matriz de permisos por tier (15 permisos × 3 niveles) con "Guardar Cambios", "Restablecer por defecto" y registro de auditoría con hash.
- `[ABI]` Definición exacta de cada permiso y herencia entre tiers.

### RF-16 — Moderación de contenido
- **Fuente:** `ADM-13`, `ADM-14`, `ADM-15`, `ADM-16`, `09&10`, `12T`, `G10M`.
- `[DOC]` Cola con pestañas (Reseñas / Fotos / Reportes), orden por urgencia, espera actual, asignación a custodios y "Revisar Siguiente en Cola".
- `[DOC]` Detalle con contenido propuesto, autor y fiabilidad, foto adjunta con resolución/peso, ubicación, notas internas visibles solo para curaduría.
- `[DOC]` Acciones: **Aprobar & Publicar** (con aviso de publicación inmediata), **Solicitar Corrección**, **Rechazar con Motivo** (guías éticas con códigos `#R1`…), dictamen ético.
- `[DOC]` Métricas de cola: pendientes, fotos por verificar, tiempo medio, tasa de aprobación ética.
- `[ABI]` SLA (A12), reglas automáticas ("Reglas AI") y quién puede saltarse la cola.

### RF-17 — Multimedia
- **Fuente:** `ADM-06`, `ADM-16`.
- `[DOC]` Biblioteca con subida, clasificación y moderación de fotos/vídeos; control de metadatos EXIF.
- `[ABI]` Límites de tamaño/formato y política de EXIF de ubicación (menudo conflicto con privacidad).

### RF-18 — Patrocinios y alianzas
- **Fuente:** `ADM-12`, `E01`, `04&05`, `01`.
- `[DOC]` Gestión de rutas patrocinadas/alianzas; los badges públicos ("Patrocinado", "NO PATROCINADA", "Ruta Promovida") deben provenir de esta gestión.
- `[ABI]` Reglas de etiquetado y límite de patrocinios visibles.

### RF-19 — Métricas e informes
- **Fuente:** `ADM-17`, `ADM-02`.
- `[DOC]` Informes de uso, distribución de exploradores y **capacidad de carga** con umbrales (máximo 1.000 visitantes, alerta al 84%).
- `[ABI]` Origen de los datos de capacidad (¿aforo? ¿GNSS anónimo?) y cadencia de los informes.

---

## 4. Flujos principales

### Flujo V-1 — Explorar → consultar → decidir
| Campo | Contenido |
|---|---|
| Actor | Invitado o Explorador |
| Precondición | App cargada; si no hay red, datos en caché (`A04M`/`11M`) |
| Pasos | 1. Ver mapa con capas y listado (`01`/`C01`) · 2. Filtrar categoría · 3. Buscar (`⌘K`) · 4. Abrir card → ficha (`D01`) · 5. Explorar galería, ficha técnica y estado |
| Resultado esperado | Lugar consultado con datos completos; acciones guardado/itinerario visibles |
| Errores/estados | Sin resultados (`C05M`), permiso de ubicación denegado (`C04M`), sin conexión (`A04M`) |
| Dependencias | RF-01, RF-02, RF-03; servicios: mapas, geocodificación, media |
| `[ABI]` | Ordenación por defecto; qué pasa si el lugar está cerrado/privado |

### Flujo V-2 — Seguir una ruta
| Campo | Contenido |
|---|---|
| Actor | Explorador |
| Precondición | Sesión; ruta descargada para uso sin red (`E01`) |
| Pasos | 1. Catálogo → detalle (`E03`) · 2. Descargar paquete · 3. Activar "Modo Seguir" (`E06M`/`04&05`) · 4. Recibir avisos de proximidad · 5. Finalizar y ver resumen |
| Resultado esperado | Navegación con progreso, velocidad y siguiente waypoint |
| Errores | Permiso de ubicación denegado (`C04M`), pérdida de red (sigue con caché), `balizas` no disponibles en segundo plano → A14 |
| Dependencias | RF-04, RF-09; servicios: tiles, GNSS, notificaciones |
| `[ABI]` | Comportamiento si se desvía +40 m en iOS/PWA |

### Flujo V-3 — Favoritos e itinerarios
| Campo | Contenido |
|---|---|
| Actor | Explorador (requiere sesión: `B08M`) |
| Precondición | Sesión iniciada |
| Pasos | 1. Guardar lugar desde ficha · 2. Abrir Mi Lista (`F01M`) · 3. Crear itinerario (`F04`) · 4. Agregar paradas con horarios · 5. Descargar offline · 6. Marcar "En curso" (`06M`) |
| Resultado esperado | Itinerario con métricas y notas sincronizadas |
| Errores | Invitado → pantalla de sesión requerida (`B08M`); conflicto offline |
| Dependencias | RF-05, RF-06, RF-08, RF-09 |
| `[ABI]` | Reglas de creación de itinerario |

### Flujo V-4 — Reseñar con respaldo offline
| Campo | Contenido |
|---|---|
| Actor | Explorador |
| Precondición | Sesión; lugar visitado (verificación geográfica en `G04M`) |
| Pasos | 1. Abrir reseñas (`G01M`) · 2. Escribir (`G04M`: valoración + texto + ≤3 fotos + casilla ética) · 3. Enviar · 4. Confirmación "enviada a moderación" (`G10M`) · 5. Esperar dictamen (`07&08`) |
| Resultado esperado | Reseña publicada tras aprobación o rechazo motivado |
| Errores | Sin red ⇒ cola local con reintento (`G05M`); error de validación; rechazo con motivo |
| Dependencias | RF-07, RF-08, RF-16; servicios: storage, notificaciones, cola offline |
| `[ABI]` | SLA (A12), límite de fotos/peso, moderación automática |

### Flujo V-5 — Configuración, privacidad y ARCO
| Campo | Contenido |
|---|---|
| Actor | Explorador |
| Pasos | 1. Ajustes (`H01M`) · 2. Idioma/toponimia (`H02M`) · 3. Notificaciones (`H05M`) · 4. Consentimientos (`H06M`) · 5. Solicitud ARCO (`H07M`) · 6. Libro de reclamaciones (`H08M`) |
| Resultado esperado | Preferencias persistidas; solicitudes registradas con acuse y plazo |
| Errores | Fallo de envío de la solicitud; falta de consentimiento bloquea telemetría |
| Dependencias | RF-10, RF-11; obligaciones legales → `10-dependencias-tecnicas.md` |
| `[ABI]` | Plazo ARCO (A15), responsable de atención, canal de verificación |

### Flujo A-1 — Publicar un lugar
Actor: Editor/Topógrafo. Pasos: `ADM-01` → `ADM-03` → "+ Nuevo Lugar" (`ADM-04`) → rellenar → guardar borrador/publicar → revisión de curaduría (`ADM-11`) → visible en mapa. Errores: validación de formulario, permiso insuficiente (RBAC `ADM-18`), duplicado `[ABI]`.

### Flujo A-2 — Importar una ruta GPX
Actor: Editor/Topógrafo. Pasos: `ADM-07` → `ADM-08` → subir archivo → parseo y validación → metadatos → hitos/balizas → salvaguarda → "Validar y Publicar" → editar orden de waypoints (`ADM-09`). Errores: archivo inválido (formato/nodo), fuera de la región, exceso de tamaño `[ABI]`.

### Flujo A-3 — Moderar una reseña
Actor: Moderador/Custodio. Precondición: ítem en cola (estado Pendiente). Pasos: `ADM-13`/`09&10` → abrir detalle (`ADM-14`) → revisar contenido, autor y ubicación → **Aprobar & Publicar** / **Solicitar Corrección** / **Rechazar con Motivo** (`ADM-15`) → queda registro en métricas (`ADM-17`). Errores: conflicto de asignación, ítem ya resuelto por otro custodio `[ABI]`.

### Flujo A-4 — Administrar usuarios y roles
Actor: Super Admin. Pasos: `ADM-10` (directorio, altas/bajas) → `ADM-18` (matriz de permisos) → guardar → auditoría con hash. Errores: intento de auto-degradación, permiso denegado `[ABI]`.

---

## 5. Matriz requisito ⇄ pantalla ⇄ flujo

| Requisito | Pantallas | Flujo |
|---|---|---|
| RF-01 Exploración | `01`, `C01`, `01M&02`, `C02M`, `C10M` | V-1 |
| RF-02 Búsqueda | `C05M`, `07&08`, `C01` | V-1 |
| RF-03 Ficha de lugar | `03`, `D01`, `D02M` | V-1 |
| RF-04 Rutas/seguimiento | `E01`, `E03`, `E06M`, `04&05` | V-2 |
| RF-05 Favoritos | `F01M`, `F02M`, `06M` | V-3 |
| RF-06 Itinerarios | `F04`, `06M` | V-3 |
| RF-07 Reseñas | `G01M`, `G04M`, `G05M`, `G10M`, `07&08` | V-4 |
| RF-08 Auth/OTP | `B01M`, `B02M`, `B04M`, `B07M`, `B08M`, `ADM-01` | V-3, V-4 |
| RF-09 Offline | `A01M–A04M`, `11M`, `H06M` | V-1, V-2, V-4 |
| RF-10 Ajustes/i18n/notifs | `H01M`, `H02M`, `H05M` | V-5 |
| RF-11 Privacidad/ARCO/reclamos | `H04M`, `H06M`, `H07M`, `H08M` | V-5 |
| RF-12 Dashboard | `ADM-01`, `ADM-02` | A-1..A-4 |
| RF-13 Lugares CRUD | `ADM-03`, `ADM-04`, `ADM-05`, `ADM-11` | A-1 |
| RF-14 Rutas + GPX | `ADM-07`, `ADM-08`, `ADM-09` | A-2 |
| RF-15 Usuarios + RBAC | `ADM-10`, `ADM-18` | A-4 |
| RF-16 Moderación | `ADM-13`, `ADM-14`, `ADM-15`, `ADM-16`, `09&10`, `12T` | A-3 |
| RF-17 Multimedia | `ADM-06`, `ADM-16` | A-1, A-3 |
| RF-18 Patrocinios | `ADM-12`, `E01`, `01` | A-1 |
| RF-19 Métricas/capacidad | `ADM-17`, `ADM-02` | A-4 |
| RF-22 Descubrimiento en movimiento: radio de proximidad configurable (400–800 m) y vista "Lo que hay en este trayecto" | `E06M`, `04&05` | V-2 |
| RF-23 Medios: imágenes WebP responsive; vídeos 15–25 s con compresión, miniatura y lazy loading | `ADM-06`, `ADM-16` | A-1, A-3 |
