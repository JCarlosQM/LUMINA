# LUMINA — Inventario Depurado de Pantallas (FASE 1.5)

> **Alineación 2026-10-10:** la evidencia capturada (PNG/HTML) **ya no está accesible** (temporal limpiado); este inventario sigue siendo el registro de referencia y el proyecto **Stitch** (62 pantallas) permanece intacto.

> **Regla aplicada:** ninguna pantalla se elimina. Cada recurso queda con ID de Stitch, familia, tamaño lógico, posición en lienzo, nº de vistas, estado de validación y relación con requisitos.
> Fuente: `list_screens` + `get_project.screenInstances` (63 instancias) + 62 PNG + 62 HTML validados.
> Ver `05-informe-validacion-visual.md` para el método.

## 0. Reconciliación de conteos

| Concepto | Cantidad |
|---|---|
| Instancias en el lienzo | **63** |
| Pantallas funcionales | **62** |
| Instancia no funcional (`undefined`, 960×540, sin captura) | 1 → probable instancia del sistema de diseño |
| Familia numerada | **9** (01–12, con etiquetas "&" y "M"/"T") |
| Familia codificada | **52** (A/B/C/D/E/F/G/H/ADM) + **1** logotipo = 53 |
| Total | 9 + 53 = **62 pantallas** |

---

## 1. Familia numerada (filas `y = 0 / 1280 / 3846`)

| ID pantalla | ID Stitch | Lógico | Vistas | Observación validada |
|---|---|---|---|---|
| `01` Exploración Cartográfica Principal | `e76f2f3ce08a4e3a9caa1f18aa703a80` | 1280×1024 | 1 | Mapa a sangre + rail de filtros + panel de 24 lugares con badge "Patrocinado" |
| `01M & 02` Exploración Móvil & Tarjeta Rápida | `4e2bfdd0735141f8a4d0c529a095ec06` | 390×884 | **2** | (a) mapa móvil con bottom-nav "Perfil" (b) tarjeta rápida expandida |
| `03` Ficha Editorial de Lugar | `c07b0442476342c8a21453805e014be9` | 1280×2446 | 1 | Hacienda La Florida; pagos Yape/Plin; video "Atmósfera sensorial"; "Añadir a Itinerario" |
| `04 & 05` Rutas Temáticas & Descubrimiento en Movimiento | `80c99449f5ae464794a83bcbe72e7d17` | 1280×1024 | **2** | (a) detalle de ruta con badge "NO PATROCINADA" (b) modo seguir: 56%, 42 km/h, aviso a 500 m |
| `06M` Favoritos & Mis Itinerarios (PWA) | `896d7fa3081f46e99f25564565b26686` | 390×2310 | **3** | (a) Mi Cuaderno: pestañas Lugares/Itinerarios/Notas (b) itinerario activo "Día 1 de 2" (c) notas geográficas |
| `07 & 08` Registro OTP & Reseñas (Tablet/Desktop) | `422b24b4f6434016b274852102790639` | 1280×1855 | **2** | (a) "Bitácora Segura": OTP **por correo** + consentimiento (b) "Voces del Valle": búsqueda curada + formulario de reseña |
| `09 & 10` Panel Administrativo & Cola de Moderación | `897d942667e74ef585541c0e778f49ae` | 1280×1024 | **2** | (a) dashboard KPIs 14/9/24/18min + sidebar "Mod. Nivel 2" (b) detalle de item con EXIF y hash SHA-256 |
| `11M` Modo Offline & Gestión de Caché (PWA) | `84dbf0f1eb88421490f92a04b112a5d7` | 390×884 | 1 | Menciona **IndexedDB + ServiceWorker**, cola de sincronización con "Forzar envío" |
| `12T` Panel Administrativo & Cola de Moderación (Tablet) | `d874611759d643d58304649f6c09db11` | **1280**×1024 | 1 | **Mismo contenido que 09&10** (ficha #MOD-2024-089, mismos KPIs); navegación superior + hamburguesa |

**Relación entre parejas de la familia numerada:** `12T` = adaptación de tabla de `09&10`; `07&08` = OTP + reseñas que en la familia codificada se separan en `B07M`/`B08M` + `G01M`/`G04M`.

---

## 2. Familia codificada (filas `y = 5126` → `28854`)

### A — PWA (y=5126)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `A01M` Bienvenida | `6e4cbffcc28145ea8ff43c4da40883c8` | 390×884 | 1 | Onboarding |
| `A02M` Experiencia de instalación | `5e6b66b212ab4fbb83da65b047a79b1f` | 390×884 | 1 | Instalación de la PWA |
| `A03M` Estado de carga inicial | `94b31ffc3c97498f9216f39c5ea91263` | 390×884 | 1 | Splash/carga |
| `A04M` Estado sin conexión | `23ca8a149bb64718a9cca777b1e084af` | 390×884 | 1 | Offline (complementa `11M`) |

### B — Autenticación (y=6266; `B08M` desplazada a y=28854)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `B01M` Login inicial | `796841e09ead41adbe09c7523c35c818` | 390×**972** | 1 | Único móvil con alto distinto de 884 |
| `B02M` Login con errores de validación | `444ee8b0775d46a890531a330178795c` | 390×884 | 1 | Estados de error inline ("Formato erróneo", "campo obligatorio") + "credencial cultural" |
| `B04M` Registro de usuario | `dcf52e7aec93440386690003025e9e39` | 390×884 | 1 | Nombre, correo, aceptación de privacidad |
| `B07M` OTP 6 dígitos | `ce8500ea09e04ac5821f018d4710611b` | 390×884 | 1 | **OTP por correo** (muestra `anto…@patrimonio.pe`, "Cambiar dirección de correo") |
| `B08M` Sesión requerida / invitado | `69648e3c55ba43a294ec134f024cdbfe` | 390×884 | 1 | Invitado = solo lectura; botón "Continuar con código OTP (**Móvil**)" → canal SMS implícito |

### C — Mapa y búsqueda (y=7494; `C04M`/`C05M` en y=28854)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `C01` Exploración principal desktop | `0900f17da6bd4372a814500957e3cf00` | 1280×1024 | 1 | Top-nav de categorías; "Lugares Curados / Rutas Temáticas" |
| `C02M` Exploración principal móvil | `1c9c0dd516cf4beba5a6e96ad2536f1e` | 390×884 | 1 | Bottom-nav con **Ajustes** |
| `C03M` Solicitud de permiso de ubicación | `63a522b103da4b9d8027fa95b59f67a9` | 390×884 | 1 | Estado concedido |
| `C04M` Permiso denegado | `f722f8906d1a41b8b6cf174ad4dd31c8` | 390×884 | 1 | Estado denegado con recuperación |
| `C05M` Búsqueda sin resultados | `e73faa477c804ed9ae40052f502e1f40` | 390×884 | 1 | Empty state + filtros ("Desnivel > 800 m") + recomendaciones |
| `C10M` Tarjeta rápida de lugar | `d46572a2f5824ec5ab8e2ae583d30541` | 390×884 | 1 | Equivalente móvil a la vista (b) de `01M&02` |

### D — Ficha de lugar (y=8774)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `D01` Ficha editorial desktop | `a9ecc003439841b0bd13b78342e5c58f` | 1280×2904 | 1 | GPS 11°25′12″S 75°41′24″W, hoja 23-M, ficha técnica, estado en tiempo real, descarga offline |
| `D02M` Ficha editorial móvil | `4622d01f71264acc97067c6324b87df5` | 390×2117 | 1 | Carrusel 1/6, "Video 18s", ficha técnica compacta |

### E — Rutas (y=11934)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `E01` Catálogo de rutas desktop | `0cfba3d9b3624db1bb16a5050b1a1a9b` | 1280×2264 | 1 | "Ruta Patrocinada Oficial" y "Ruta Promovida · Colectivo Floricultor Tarma 2025"; paquete offline 148 MB; track GPX |
| `E03` Detalle de ruta desktop | `8814c514a8db4d1797e43bb5355ca94e` | 1280×1024 | 1 | Waypoints, desnivel, dificultad |
| `E06M` Modo seguir móvil | `5c5b523f17a74773ba617a62ddea60ed` | 390×884 | 1 | Navegación en movimiento |

### F — Favoritos e itinerarios (y=14454)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `F01M` Mi lista (con contenido) | `b3562dc0bc2c4bba85c42b2e6594218f` | 390×884 | 1 | Bottom-nav "Guardados" |
| `F02M` Mi lista vacía | `81f3a4f8345b4bf2aa2339bd903d7a2a` | 390×884 | 1 | Empty state |
| `F04` Mis itinerarios desktop | `d046aa6911e64fd5ada2f72d5a4bcc2d` | 1280×2260 | 1 | "Crear Nuevo Itinerario", filtros por estado, espacio offline 24.6 MB, métricas (paradas/distancia/desnivel/cota) |

### G — Reseñas (y=16970; `G05M` en y=28854)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `G01M` Listado y calificaciones | `4ee9587923494e7985adc8b46a690c09` | 390×1891 | 1 | Histograma 5→1, 318 testimonios, filtros |
| `G04M` Formulario de testimonio | `ec200cd4a53e4855b50a15621ae57608` | 390×1252 | 1 | Valoración, texto (600 car. recomendados), **hasta 3 fotos**, casilla de ética, verificación geográfica |
| `G05M` Error de envío + respaldo offline | `e9f5fb4a3d91426e858d155472c3dd7a` | 390×1116 | 1 | Cola local con reintento |
| `G10M` Envío a moderación | `28760493f4b74d1191da34e28c7c12a2` | 390×1171 | 1 | Confirmación, SLA "2 a 6 horas", **+40 pts Explorador Ético** |

### H — Ajustes, idioma, privacidad y legal (y=19117 y y=21319)
| ID | Stitch ID | Lógico | Vistas | Observación |
|---|---|---|---|---|
| `H01M` Preferencias de campo | `d8b7bc9ff10147f89b350b9c42b9cf0a` | 390×1922 | 1 | Gamificación ("420 pts · Explorador Ético"), preferencias |
| `H02M` Idioma y toponimia | `5b37e1b1703a48e98c62ca79dc0a1454` | 390×1213 | 1 | i18n + topónimos quechua |
| `H04M` Salvaguarda cultural y datos | `51b08aedb8e74d8b987d7bbed1c321bf` | 390×1946 | 1 | Política cultural + protección de datos |
| `H05M` Notificaciones y balizas | `f972d63c85e541dca74684a996749ada` | 390×1629 | 1 | Web Push + Service Worker; alertas de desvío (+40 m) y ocaso (45 min) → ver A14 |
| `H06M` Consentimiento y telemetría | `b2cd001205bd4132a1e068de4034abbb` | 390×1810 | 1 | Toggles de consentimiento; menciona **IndexedDB** |
| `H07M` Derechos ARCO | `57445442aa924577a7b44ea1207e5d7c` | 390×884 | 1 | Portabilidad/supresión; "10 días hábiles" → ver A15 |
| `H08M` Libro de Reclamaciones Virtual | `06a204f581014d28b46829816ca1b6f8` | 390×2087 | 1 | Formulario completo (RUC, domicilio, hoja, detalle, monto, medios); "15 días hábiles"; datos ficticios |

### ADM — Consola administrativa (y=23662 → 27574)
| ID | Stitch ID | Lógico | Observación |
|---|---|---|---|
| `ADM-01` Inicio de sesión consola | `8245c92710cf42c091a721e0bd65b227` | 1280×1024 | Acceso administrativo separado |
| `ADM-02` Dashboard de indicadores | `f1d1263637714b7999a9ccfa458857e6` | 1280×1024 | KPIs territoriales, "Moderación Ética 43", temporadas, "GNSS RTK ±0.4m" |
| `ADM-03` Listado de lugares | `9c9d66edee774d38b5f0be13b0d9d27d` | 1280×1024 | Tabla con filtros |
| `ADM-04` Crear lugar | `5965bd5028a8405cb7155e359f54c38a` | 1280×1024 | Formulario de alta |
| `ADM-05` Editar lugar | `45013566d165443bbe64399d4fed523e` | 1280×1024 | Formulario de edición |
| `ADM-06` Biblioteca multimedia | `002c81da051d447b9a331a2dd5c36b75` | 1280×1024 | Gestión de fotos/vídeos |
| `ADM-07` Listado de rutas | `27b7a5e683eb44adab75e00b341ab395` | 1280×1024 | Tabla de rutas |
| `ADM-08` Crear ruta + importador GPX | `8543603324084dd282265d6cf83c3299` | 1280×1024 | Asistente 4 pasos: importación (GPX 1.1 / GeoJSON, "Parseado OK, 1,420 nodos WGS84"), metadatos, **hitos y balizas de proximidad**, salvaguarda y alertas |
| `ADM-09` Editar ruta y ordenar waypoints | `f7b9b7c51b364402af9c8c730a4eb3a5` | 1280×1024 | Reordenación de hitos |
| `ADM-10` Directorio de usuarios | `f82a5ece0e43450998d94bfe83351308` | 1280×1024 | Conteos por rol: Exploradores 1,420 / Custodios 18 / Editores 6 / Super Admin 2 |
| `ADM-11` Curaduría de destacados | `2c5c633460b547d192d47bf7e27dfb3c` | 1280×1024 | Selección editorial |
| `ADM-12` Rutas patrocinadas y alianzas | `2db6ea331f304893a2159e2f2d27e860` | 1280×1024 | Gestión de patrocinios (contraparte de los badges de `E01`/`04&05`) |
| `ADM-13` Cola de moderación | `c6401e3716e54aef9672a0c02a449aee` | 1280×1024 | Espera 3.4 h, pestañas Reseñas/Fotos/Reportes, "Configurar Reglas AI", guías éticas de rechazo |
| `ADM-14` Detalle de reseña pendiente | `feb94ae6d160442eae3480a63891e5d9` | 1280×**1096** | Único alto ADM no 1024 |
| `ADM-15` Aprobar/rechazar + dictamen | `2bfda35148e0482bbf0f3079c1fb09cb` | 1280×1024 | Acciones con motivo; "Exploradora Nivel 4" |
| `ADM-16` Moderación de fotografías | `11d206372bf84d8894b29d7f7d3f8b00` | 1280×1024 | Cola visual |
| `ADM-17` Métricas y capacidad de carga | `2bb8502520c44abab6e18138ed6955b0` | 1280×1024 | Informes; umbrales de capacidad (máx. 1.000 visitantes, alerta al 84%) |
| `ADM-18` Roles y permisos RBAC | `cc27a881e9e54a769617ecfa1884f2ed` | 1280×1024 | 3 tiers × 15 permisos en 5 grupos; auditoría "SHA 7e9f..3a21" |

### Otros
| ID | Stitch ID | Lógico | Observación |
|---|---|---|---|
| `Logotipo Oficial LUMINA` | `1be7cbe42662498991010ddb4676f411` | 340×78 | Wordmark + isotipo; es el logotipo del proyecto |

---

## 3. Estado de "duplicados" declarados en FASE 1

| Par | Relación verificada | Decisión de inventario |
|---|---|---|
| `01` ↔ `C01` | Jaccard 0.28, IA distinta (rail vs top-nav) | **Ambas se conservan**; candidatas a unificación bajo C3 |
| `03` ↔ `D01` | Jaccard 0.18, lugar de ejemplo y componentes distintos | **Ambas** |
| `09&10` ↔ `ADM-02`/`ADM-13` | Jaccard 0.16, shells distintos | **Ambas** |
| `09&10` ↔ `12T` | Jaccard 0.26, **contenido idéntico**, layout distinto | `12T` = variante de tabla → **se conserva como variante responsive** |
| `01M&02` ↔ `C02M`/`C10M` | 0.33 / 0.36 | **Ambas** |
| `04&05` ↔ `E01`/`E06M` | 0.15 / 0.20 | **Ambas** |
| `06M` ↔ `F01M`/`F04` | complementarias móvil/desktop | **Ambas** |
| `07&08` ↔ `B07M`/`G01M` | 0.11 / 0.14 | **Ambas** |
| `11M` ↔ `A04M` | 0.17, enfoques distintos de offline | **Ambas** |

---

## 4. Cobertura de pantallas faltantes detectada (sin diseño)

Estos objetivos de usuario **no tienen pantalla** en ninguna familia (huecos reales, no omisiones del inventario):

1. **Búsqueda con resultados** (existe solo `C05M` sin resultados y `C01`/`C02M` con el campo vacío).
2. **Detalle de ruta en móvil** (hay `E03` desktop y `E06M` seguimiento, pero no ficha móvil).
3. **Listado de favoritos/itinerarios desktop con contenido de notas** (`06M` las muestra solo en móvil).
4. **Perfil de usuario / gestión de cuenta** (aparece "Perfil" en `01M&02` pero sin pantalla propia).
5. **Recuperación de contraseña** ("¿Olvidaste tu contraseña?" existe como enlace en `B02M` sin pantalla destino).
6. **Escritorio/tablet de Ajustes, Privacidad, ARCO y Libro de Reclamaciones** (solo móviles H*).
7. **Tablet 768–1024 real** (REQ-UI-03): sin artefacto (C2).
8. **Confirmación de error de servidor / 404 / mantenimiento** en visitante (solo offline A04M).
