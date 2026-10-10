# LUMINA — Alcance del MVP (FASE 1.6 · estado actualizado en FASE 1.7)

> **Base:** 19 RF y 9 flujos de `07-requisitos-funcionales.md`, huecos de `02-matriz-trazabilidad.md` y `06` §4, y decisiones D-01…D-15 de `11-decisiones-consolidadas.md`.
> **Regla:** nada entra al MVP por "parecer lógico"; sólo por requisito documentado, decisión adoptada o autorización expresa. Lo que no tiene evidencia queda en *pendiente de decisión*, no se inventa.
> **Estado (FASE 1.7):** P-08 **ACEPTÓ este documento como propuesta de alcance para planificación**, **no como especificación definitiva**. La revisión SEO/offline/permisos/moderación/costes externos/funciones sin diseño está en `15-fase-1-7-informe.md` §7. **Cambios de alcance, si se proponen, se presentan antes de considerarse aprobados** (FASE 1.7 no aplicó ninguno). El alcance de consola depende de P-05 (RBAC) y el offline de P-02 (teselas).
> **ALINEACIÓN DEFINITIVA (2026-10-10):** stack adoptado: **Laravel 13 + Vue 3 + TypeScript + Inertia 3 + Filament 5 + PostgreSQL con PostGIS + MapLibre** (P-01 ADOPTADA). P-05 (Filament 5) ADOPTADA. El alcance del MVP sigue como propuesta de planificación hasta su confirmación (P-08).

---

## 1. Resumen

| Categoría | Nº | Significado |
|---|---|---|
| **Incluido** | 14 bloques | Trazable a RF con pantalla o decisión adoptada |
| **Excluido por decisión adoptada** | 5 | D-06 (SMS), D-07 (2.º plano), D-10 (gamificación) y derivados |
| **Excluido por asesoramiento** | 3 | D-15: ARCO con plazo, Libro de Reclamaciones real, textos legales |
| **Pendiente de decisión** | 7 | No hay evidencia ni decisión: A6, A9, A4, A5, SEO, cobertura, métricas de aforo |
| **Ampliaciones post-MVP** | 5 | Lo que se deja previsto sin construir |

---

## 2. Incluido en el MVP

### 2.1 Visitante — descubrimiento y consulta

| # | Funcionalidad | RF / REQ | Flujo | Pantallas de referencia | Criterio de aceptación |
|---|---|---|---|---|---|
| M1 | Exploración cartográfica con filtros por categoría, capas, geolocalización y listado lateral | RF-01, REQ-UI-01/04, REQ-MAP-01/02 | V-1 | `01`, `C01`, `C02M`, `C03M`, `C04M` | Mapa continuo al navegar; permiso concedido/denegado con recuperación; render en 390, 768–1024 y 1280 |
| M2 | Búsqueda con sugerencias y **estado con resultados** + estado sin resultados | RF-02, REQ-MAP-03 | V-1 | `C01`, `C02M`, `C05M` + pantalla nueva (A2, **diseño autorizado**) | Existen los 4 estados: resultados, carga, error y vacío |
| M3 | Ficha editorial de lugar (contenido, galería, ficha técnica, acciones) | RF-03, REQ-PLZ-01 | V-1 | `D01`, `D02M`, `03` | Guardar / añadir a itinerario / compartir / descargar offline operativos |
| M4 | Catálogo y detalle de ruta con waypoints y paquete offline descargable | RF-04, REQ-RUT-01/02 | V-2 | `E01`, `E03` + ficha móvil (**hueco, P-12**) | Descarga con progreso, verificación y tamaño mostrado |

### 2.2 Visitante — cuenta y datos propios

| # | Funcionalidad | RF / REQ | Flujo | Pantallas | Criterio de aceptación |
|---|---|---|---|---|---|
| M5 | Registro, login, **OTP por correo** y guard de sesión | RF-08, REQ-AUTH-01/02/03/04 | V-3, V-4 | `B01M`, `B02M`, `B04M`, `B07M`, `B08M` | Explicación de expiración/reintentos/límites antes de código (D-06); sin enumeración de usuarios (R1) |
| M6 | Favoritos ("Mi Lista") con estado vacío | RF-05, REQ-FAN-01 | V-3 | `F01M`, `F02M` | Invitado en sólo lectura; con sesión, sincroniza offline |
| M7 | Itinerarios: crear, listar, filtrar, detalle con métricas y notas geográficas | RF-06, REQ-FAN-02 | V-3 | `F04`, `06M` | Sin "constructor" complejo salvo que P-13 diga lo contrario |
| M8 | Reseñas: listado, formulario (≤3 fotos, casilla ética), envío con **cola offline** y estados de moderación | RF-07, REQ-REV-01…04 | V-4 | `G01M`, `G04M`, `G05M`, `G10M`, `07&08` | Reenvío idempotente; confirmación **sin prometer SLA < 24 h** (D-08); sin pts (D-10) |

### 2.3 Visitante — PWA, ajustes y privacidad

| # | Funcionalidad | RF / REQ | Flujo | Pantallas | Criterio de aceptación |
|---|---|---|---|---|---|
| M9 | PWA instalable: bienvenida, carga, sin conexión recuperable y gestión de caché | RF-09, REQ-APP-01/02/03 | V-1, V-2, V-4 | `A01M–A04M`, `11M` | Instalable en iOS y Android; IndexedDB + SW como nombran las pantallas |
| M10 | Navegación móvil unificada (5 destinos) | RF-01/02/04/05/10, REQ-UI-09 | V-1, V-3, V-5 | variantes A11 + `F01M`, `C02M` | Sólo tras confirmar excepciones E1–E3 (P-09) |
| M11 | Ajustes: preferencias, idioma/toponimia, notificaciones **en primer plano**, consentimientos | RF-10, REQ-SET-01/02/03, REQ-PRV-02 | V-5 | `H01M`, `H02M`, `H05M`, `H06M` | Sin geofencing ni avisos con la app cerrada (D-07); sin gamificación en `H01M` (D-10) |
| M12 | Navegación, roles y experiencia en **tablet 768–1024** | REQ-UI-03, REQ-ADM-14 | todos | **sin artefactos hoy** (C2) | Panel lateral 380 px real; los 1280 px no cuentan como tablet (D-04) |

### 2.4 Consola administrativa

| # | Funcionalidad | RF / REQ | Flujo | Pantallas | Criterio de aceptación |
|---|---|---|---|---|---|
| M13 | Acceso + dashboard + CRUD lugares/rutas (importador GPX) + biblioteca multimedia | RF-12…RF-14, RF-17 | A-1, A-2 | `ADM-01…ADM-09`, `ADM-11` | Parser GPX aislado y validado (R4); estados de éxito/error/carga añadidos (A7, diseño autorizado) |
| M14 | Usuarios, **RBAC por acción**, moderación (reseñas/fotos/reportes) con máquina de estados, dictamen motivado, auditoría con hash y métricas de cola | RF-15, RF-16, REQ-ADM-06/09/10/13 | A-3, A-4 | `ADM-10`, `ADM-13…ADM-16`, `ADM-18`, `09&10`, `12T` | Autorización **siempre en servidor** (R3); email del autor **no visible** en vistas ordinarias (D-12); matriz 15×4 propuesta en `17`, pendiente de aprobación (P-05) |

---

## 3. Excluido del MVP por decisión adoptada

| Ítem | Decisión | Detalle |
|---|---|---|
| SMS como canal OTP | **D-06** | Sólo correo; SMS queda como ampliación documentada |
| Alertas con la PWA en 2.º plano / geofencing / balizas de desvío | **D-07** | MVP = primer plano + recordatorios programados; `H05M` se corrige para no prometer lo no disponible |
| Gamificación (puntos, niveles, insignias) | **D-10** | `G10M` +40 pts, `H01M` 420 pts, `ADM-15` Nivel 4 → fuera; campo `points/level` de `08` queda fuera del esquema MVP |
| Reglas automáticas de moderación ("Reglas AI") | **D-13** + 4.5 de `11` | Sin detección automática de coordenadas sensibles hasta validar criterios con la comunidad |
| App nativa / híbrida | **D-07** (evaluación aparte) | Cualquier nativo futuro se evalúa como proyecto separado |

---

## 4. Excluido del MVP por asesoramiento pendiente (D-15)

| Ítem | Pantalla | Qué falta |
|---|---|---|
| Formulario ARCO con **plazo publicado** | `H07M` | Dictamen del plazo (A15: 10 vs 20 días) — P-17 |
| Libro de Reclamaciones **operativo** | `H08M` | Decisión + datos reales del operador (RUC/domicilio ficticios) — P-18 |
| Textos legales y consentimientos | `H04M`, `H06M` | Validación especializada — P-20 |

> Si la asesoría no llega a tiempo, la opción mínima es **no publicar esas pantallas** en producción (mejor ausente que incorrecta). La decisión es tuya en P-08.

---

## 5. Pendiente de decisión (no se inventa, no se incluye aún)

| ID | Asunto | Si se incluye / excluye |
|---|---|---|
| A6 | Modo oscuro | Excluir por defecto (P-10) si no lo pides |
| A9 | Reglas de patrocinios y métricas de aforo (1.000 / 84%) | MVP con badges manuales sin algoritmo (P-15) |
| A4 | Catálogo amplio de idiomas y traducción de contenido | MVP: es-PE + quechua en UI y topónimos (P-14) |
| A5 | Cobertura responsive restante (desktop de `H*`/`G*`/`F*`, móvil ADM) | Según lo que apruebes en P-11 |
| — | SEO de fichas públicas | Si apruebas el híbrido en P-01 (residual), entra (REQ-WEB-01) |
| A8 | Constructor de itinerarios complejo | Recomendación: no (P-13) |
| A2 | Pantalla de perfil de usuario | Sin RF → sólo si lo apruebas (P-12) |

---

## 6. Ampliaciones previstas (post-MVP, se dejan diseñadas en el código)

1. SMS como segundo canal OTP (D-06).
2. Geofencing y notificaciones nativas (D-07, evaluación aparte).
3. Gamificación con criterios objetivos y verificables (D-10).
4. Modo oscuro (A6) — los tokens deben prepararlo aunque no se use (P-10).
5. Offline ampliado (descargas de región completa) una vez medido el almacenamiento real en iOS.

---

## 7. Dependencias del alcance

| Dependencia | De qué bloquea | Referencia |
|---|---|---|
| Aprobación de stack (P-01…P-04) | Todo lo construible | `12` |
| Aprobación del modelo provisional (P-06) + retención (P-07) | M13/M14, esquema | `08` §7 |
| Diseños tablet 768–1024 (D-04, paso `S-3`) | M12 | `14` |
| Diseño de resultados de búsqueda y estados CRUD (autorizados, `S-4`/`S-5`) | M2, M13 | `14` |
| Excepciones de navegación (P-09) | M10 | `11` §4.1 |
| Matriz de permisos (P-05) | M14 | `11` §4.2 |
| Asesoría legal (P-17…P-20) | §4 de este documento | `10` §7 |
| Proveedor de tiles (P-02) | Coste de M1/M4 y offline | `12` §4.7 |
| Preservar la evidencia (P-23) | Regresión visual futura | `11` §5.3 |

---

## 8. Criterios de aceptación globales del MVP

Un "MVP terminado" exige **todo** esto, sin excepciones:

1. **Flujos completos:** V-1, V-2, V-3, V-4 y V-5 del visitante; A-1…A-4 de consola.
2. **Responsive real en 390 / 768–1024 / 1280**, con el panel tablet de 380 px (D-04).
3. **PWA instalable** en iOS y Android, con offline de shell + contenido visitado + cola de reseñas reenviada idempotentemente.
4. **Sin promesas incumplibles:** ningún SLA < 24 h (D-08), ninguna alerta con la app cerrada (D-07), ningún sistema de puntos (D-10).
5. **Autorización en servidor** verificada por tests para los 15 permisos × 3 niveles (tras P-05) y auditoría encadenada por hash.
6. **Datos personales:** email del autor no visible en moderación ordinaria (D-12); consentimientos opt-in efectivos.
7. **Accesibilidad:** sin hallazgos críticos/serios con axe-core y revisión de teclado y lector en los flujos principales.
8. **Pruebas:** unidades de reglas de negocio, e2e de V-1 y V-4, y captura visual en los 3 anchos comparada con las referencias de Stitch.
9. **Operación:** copia restaurada al menos una vez en un entorno de ensayo; sin secretos en el repositorio; logs con `requestId`.
10. **Sin regresiones de análisis:** `02`, `04`, `06`, `07`, `08`, `09` y `11` siguen coherentes tras cada cambio de alcance.

---

## 9. Fuera del alcance de este documento

- Estimaciones de esfuerzo o fechas: **no se estiman tiempos** (regla de FASE 1).
- Selección de proveedores: vive en `12` y en las preguntas P-01…P-04.
- Contenido real de lugares: no se inventa; el material de muestra se corrige sólo para ser coherente (CONTENT-1).
