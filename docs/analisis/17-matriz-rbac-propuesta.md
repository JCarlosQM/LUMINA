# LUMINA — Matriz RBAC Propuesta (Explorador + 3 niveles internos) (FASE 1.7)

> **Estado:** D-09 fija el **principio** (Explorador + 3 niveles) como **ADOPTADA-COND**. Esta matriz es **PROPUESTA pendiente de tu aprobación** (P-05). **La matriz 15×3 y el "comité de tres" del planteamiento histórico NO están aprobados.** Nada de aquí se implementa (servidor, endpoints, migraciones) sin tu "sí" campo a campo.
> **Lectura campo a campo de `ADM-18` completada** en FASE 1.7 (ítem `#27` de `04-backlog.md`): se leyó la pantalla de configuración de privilegios mostrada para el **TIER 2** ("10 de 15 Permisos Activos"), con su columna *Estado de Privilegio* fila a fila.
> **Regla de lectura:** columna **OBSERVADA** = texto literal del diseño · columna **PROPUESTA** = nuestra propuesta, no aprobada.

---

## 1. Roles de partida (evidencia)

| Rol | Fuente | Estructura observada |
|---|---|---|
| `EXPLORADOR` | `ADM-10`, `B04M`, `08` §3 | Rol base: 1.420 usuarios; crea reseñas/itinerarios que pasan por cola (`G10M`); **sin** privilegios de publicación |
| **TIER 1 · Super Administrador** | `ADM-18` | "Acceso Total y Cifrado Territorial" · 2 usuarios |
| **TIER 2 · Editor de Contenido & Topógrafo** | `ADM-18` | "Gestión Cartográfica, Waypoints y Curaduría Editorial" · 6 usuarios · configuración mostrada: **10 de 15 permisos activos** |
| **TIER 3 · Moderador Comunitario / Custodio** | `ADM-18` | "Salvaguarda Ética, Reseñas y Testimonios de Campo" · 18 usuarios · **no se muestra su configuración de permisos en la evidencia** |
| "Comité de tres curadores" (`07&08`) | diseño | **No es un rol**: se modela como regla de aprobación (§4), pendiente de tu definición |

**Notación de la matriz:** `SÍ` = permiso concedido · `NO` = sin permiso · `—` = no aplicable · **(obs)** = observado en `ADM-18` para TIER 2 · *(prop.)* = propuesta nuestra.

## 2. Matriz 15 permisos × 4 roles (PROPUESTA)

| # | Grupo | Permiso (literal `ADM-18`) | Condición observada (TIER 2) | TIER 1 | TIER 2 | TIER 3 | EXPLORADOR |
|---|---|---|---|---|---|---|---|
| 1 | G1 Catálogo | Crear parajes y waypoints | "Inmediato" | SÍ *(obs)* | **SÍ** (obs) | NO *(prop.)* | NO |
| 2 | G1 Catálogo | Modificar topónimos ancestrales (Runa Simi) | "Validación requerida" | SÍ *(obs)* | **SÍ** (obs, con validación) | NO *(prop.)* | NO |
| 3 | G1 Catálogo | Eliminar parajes oficiales | "Bloqueado a Super Admin" | SÍ *(obs)* | **NO** (obs) | NO *(prop.)* | NO |
| 4 | G1 Catálogo | Publicar inmediatamente en PWA | "Despliegue CDN" | SÍ *(obs)* | **SÍ** (obs) | NO *(prop.)* | NO |
| 5 | G2 Rutas | Subir trazas GPS y calcular altimetrías | "Algoritmo Douglas-Peucker auto" | SÍ *(obs)* | **SÍ** (obs) | NO *(prop.)* | NO |
| 6 | G2 Rutas | Reordenar paradas y geocercas BLE | "Radio 5 m a 50 m" | SÍ *(obs)* | **SÍ** (obs) | NO *(prop.)* | NO |
| 7 | G2 Rutas | Alterar umbrales de desvío (+40 m) y alarma SOS | "Requiere Nivel 1" | SÍ *(obs)* | **NO** (obs) | NO *(prop.)* | NO |
| 8 | G3 Multimedia | Subir vídeos 9:16 y fotos | "Límite 250 MB/archivo" | SÍ *(obs)* | **SÍ** (obs) | **SÍ** *(prop.)* | NO |
| 9 | G3 Multimedia | Ofuscar metadatos EXIF sensibles | "Mandatorio ético" | SÍ *(obs)* | **SÍ** (obs) | **SÍ** *(prop.)* | NO |
| 10 | G3 Multimedia | Eliminar material multimedia permanente | "Riesgo de pérdida documental" | SÍ *(obs)* | **SÍ** (obs, con aviso) | NO *(prop.)* | NO |
| 11 | G4 Moderación | Aprobar testimonios éticos | "Publicación feed en 5m" | SÍ *(obs)* | **SÍ** (obs) | **SÍ** *(prop.)* | NO |
| 12 | G4 Moderación | Rechazar con dictamen normativo | "Plantillas pre-aprobadas" | SÍ *(obs)* | **SÍ** (obs) | **SÍ** *(prop.)* | NO |
| 13 | G4 Moderación | Desindexar usuarios por infracciones ARCO | "Privilegio legal restringido" | SÍ *(obs)* | **NO** (obs) | NO *(prop.)* | NO |
| 14 | G5 Seguridad | Exportar auditoría SHA-256 | "Firma hardware YubiKey" | SÍ *(obs)* | **NO** (obs) | NO *(prop.)* | NO |
| 15 | G5 Seguridad | Administrar claves API y balizas físicas | "Tier 1 Exclusivo" | SÍ *(obs)* | **NO** (obs) | NO *(prop.)* | NO |

**Cuadre verificado:** TIER 2 = 10 de 15 activos (G1: 3 · G2: 2 · G3: 3 · G4: 2 · G5: 0) → **coincide exactamente con el contador "10 de 15 Permisos Activos" de la pantalla**.
**TIER 1:** la columna se deriva de la etiqueta "Acceso Total" (15/15); no hay evidencia fila a fila de TIER 1 en la captura.
**TIER 3:** **no aparece configurado en la evidencia** — su columna es íntegramente propuesta a partir de la etiqueta "Salvaguarda Ética, Reseñas y Testimonios de Campo" (moderación + testimonios de campo, sin edición estructural ni seguridad).
**EXPLORADOR:** 0/15 (sólo crea contenido en cola; `08` §3).

## 3. Acciones administrativas más allá de los 15 conmutadores (PROPUESTA)

Mapeo de los endpoints `08` §6.3 a roles:

| Acción / endpoint | TIER 1 | TIER 2 | TIER 3 | Nota |
|---|---|---|---|---|
| `GET/PATCH /admin/users` (gestión de usuarios) | SÍ | NO | NO | Edición de usuarios = TIER 1 (coherente con "el Moderador no edita usuarios", `08` §3) |
| `GET/PUT /admin/roles` (matriz de roles) | SÍ | NO | NO | Cambios de permisos: auditoría obligatoria + §4 RS-2 |
| `GET /admin/metrics` | SÍ | NO | NO | *(prop.; lectura para TIER 2 podría ampliarse — tu decisión)* |
| `GET/POST /admin/sponsorships` | SÍ | NO | NO | *(prop.; `08` §3 agrupa Patrocinios en "Publicación" — pendiente de confirmación)* |
| `GET /admin/audit` + export con firma | SÍ | NO | NO | Export = permiso 14 (YubiKey) |
| `GET /admin/moderation?type=` | SÍ | SÍ | SÍ | Lectura de cola para los 3 tiers |
| `POST /admin/moderation/{id}/approve\|request-changes\|reject` | SÍ | SÍ | SÍ | Permiso 11/12; regla RS-1 (autor ≠ aprobador) |
| `POST/PATCH /admin/places\|routes`, `.../import`, waypoints | SÍ | SÍ | NO | CRUD editorial = TIER 2; borrado de paraje oficial = permiso 3 (TIER 1) |
| `POST/PATCH /admin/media`, borrado permanente | SÍ | SÍ | NO | Permiso 10; ver RS-4 |
| `POST /reports` (nuevo, ajuste C-2) | SÍ | SÍ | SÍ | Cualquier autenticado **reporta**; la cola la lee el staff |
| `GET /admin/reports` (dentro de la cola `ADM-13`) | SÍ | SÍ | SÍ | *(prop.; la pestaña "Reportes" existe en `ADM-13`)* |

### 3.1 Cobertura con Filament 5 (alineación definitiva)

| Necesidad | Lo cubre Filament directamente | Requiere configuración |
|---|---|---|
| CRUD, formularios, validación, tablas, notificaciones, widgets | **Sí** (recursos, formularios, tablas) | Personalización de recursos por entidad |
| Autenticación del panel | **Sí** (auth Laravel compartida) | Proteger `/admin` (middleware + autorización) |
| Roles y permisos (matriz 15×4) | Parcial (asignación) | **Políticas/Gates/middleware** por recurso; paquete complementario solo si resulta necesario |
| Autorización en servidor | Vía políticas/Gates | Aplicar en cada operación sensible (moderación, auditoría, borrados) |
| Reglas RS-1…RS-9 | — | Implementar en servidor al desarrollar (no automáticas) |

> **Filament no implementa automáticamente las reglas de negocio:** la matriz y RS-1…RS-9 deben aplicarse en servidor al implementar. `noindex` en `/admin`.

## 4. Separación de funciones (reglas propuestas, **pendientes de aprobación**)

| ID | Regla | Motivo (evidencia/riesgo) |
|---|---|---|
| **RS-1** | **Autor ≠ aprobador:** nadie aprueba/rechaza contenido que él creó (reseña, foto, lugar); el servidor lo verifica | Evita aut/publicación; `08` §3 [ABI] "¿puede un Moderador moderar contenido que él creó?" |
| **RS-2** | **Nadie modifica su propio rol ni permisos:** `PUT /admin/roles` sólo TIER 1, con registro en auditoría; idealmente segundo TIER 1 confirmante (hay 2 usuarios) | "Efecto instantáneo" de `ADM-18`; R8 de `08` |
| **RS-3** | **Moderación ≠ administración de usuarios:** TIER 3 modera pero no toca usuarios, permisos ni claves | Observado en `08` §3 y matriz (permisos 13–15) |
| **RS-4** | **Eliminaciones permanentes** (paraje oficial, multimedia) exigen confirmación explícita + evento de auditoría + respaldo previo | "Riesgo de pérdida documental" (permiso 10) |
| **RS-5** | **La auditoría no se autogestiona:** quien exporta (TIER 1 con YubiKey) queda registrado; cadena de hashes append-only | Permiso 14; `08` R8; plan `14` L2 |
| **RS-6** | **Desindexación ARCO (permiso 13):** sólo TIER 1 y sólo con procedimiento legal validado (P-17); nunca automático | "Privilegio legal restringido"; D-15 |
| **RS-7** | **Publicación inmediata ≠ moderación automática:** el permiso 4 (publicar lugares) y la "publicación en 5 min al aprobar" (permiso 11) son del **staff**; las reseñas de usuarios **siempre** pasan por cola (RF-07) | Evita que S-7 interprete "inmediato" como "sin cola" |
| **RS-8** | **Los permisos se evalúan siempre en servidor** y se reevalúan tras cada cambio (invalidar sesiones o exigir revalidación); la UI no es control de acceso | `08` R3; "efecto instantáneo" de `ADM-18` |
| **RS-9** | **"Comité de tres":** si se mantiene, se implementa como **regla de aprobación múltiple** sobre acciones concretas (p. ej. borrado de paraje o cambio de rol), **no como rol**; requiere que definas: acciones, nº de aprobadores, quiénes | `07&08`; decisión tuya (P-05) |

## 5. Riesgos identificados

| ID | Riesgo | Impacto | Mitigación propuesta |
|---|---|---|---|
| **R-B1** | Escalada por autorización sólo en cliente (los 15 conmutadores son UI en `ADM-18`) | Compromiso total | RS-8 + tests negativos (`403`) por permiso en T-4 |
| **R-B2** | Equipo pequeño (2 TIER 1): si comparten credenciales, la segregación es ficticia | Sin separación real | Cuentas individuales + 2FA TOTP (§7) + auditoría por `actorId` |
| **R-B3** | TIER 3 **no está definido en la evidencia**; su columna es propuesta | Permisos inventados si se implementa sin revisión | Aprobación campo a campo de la columna TIER 3 |
| **R-B4** | Desindexación ARCO por vía de moderación | Riesgo legal (P-17) | RS-6: TIER 1 + procedimiento validado |
| **R-B5** | Export de auditoría exige **YubiKey** (hardware) | Privilegio inoperativo sin dispositivo, o peor, desactivado sin control | Decisión de operación: adquirir hardware o definir alternativa firmada; **no inventar** |
| **R-B6** | "Efecto instantáneo" de permisos sin invalidación de sesión | Ventana con privilegios obsoletos | RS-8 |
| **R-B7** | "Publicación en 5m" / "inmediato" en copy vs **D-08** (sin SLA < 24 h) | Promesa incumplible en `S-7` | RS-7 + revisar copy en S-7 (P-16) |
| **R-B8** | La pestaña **Reportes** no tenía entidad/endpoint (C-2) | Flujo no consumible | Añadido provisional en `08` (`POST /reports`); confirmar rol lector |
| **R-B9** | El planteamiento histórico pedía "matriz 15×3" y "comité de tres" **aprobados**; aquí se proponen 15×4 (con Explorador) y comité como regla | Semántica de aprobación confusa | Explicitar en P-05 qué apruebas: 15×4 y RS-9, o variantes |
| **R-B10** | `08` §3 agrupa los permisos con **etiquetas distintas** (13 ítems listados bajo "5 grupos × 15") frente a la agrupación G1–G5 leída en `ADM-18` | Documentación incoherente | Alinear `08` §3 a esta matriz (hecho con esta entrega) |

## 6. Inconsistencia detectada y alineada

`08-modelo-dominio-api.md` §3 listaba grupos con otras etiquetas ("Gobernanza & Auditoría", "Patrimonio Territorial"…) y 13 acciones frente a las 15 leídas en `ADM-18`. Con esta entrega, `08` §3 **apunta a esta matriz** como fuente única de permisos; la agrupación histórica se conserva como referencia, sin borrar IDs.

## 7. Estado tras la alineación definitiva (P-05 ADOPTADA — Filament 5)

> La matriz §2 (15×4) y las reglas RS-1…RS-9 se **conservan** (sin roles nuevos ni reducción de permisos). El panel se construye con **Filament 5**. Pendiente de alcance: 2FA/TOTP de consola y firma de exportación (YubiKey o alternativa).

## 8. Conciliación con los roles del PDF v5.0 (Alineación 2026-10-10)

| PDF v5.0 | `17` (P-05) | Diferencia |
|---|---|---|
| Super Admin | TIER 1 Super Administrador | Equivale |
| Editor de Contenido | TIER 2 Editor de Contenido & Topógrafo | **Nombre** (`17` añade "Topógrafo") |
| Moderador | TIER 3 Moderador Comunitario / Custodio | Equivale |
| Usuario Registrado | EXPLORADOR | **El PDF no distingue visitante invitado**; `07` sí (invitado solo lectura vs registrado) |

**Diferencias reales:** (1) el PDF no modela el visitante invitado; (2) el nombre del TIER 2. **No son conflictos de fondo.** La matriz conciliada en §2–§3 distingue **leer / crear / editar / publicar / aprobar / eliminar / administrar** y mantiene mínimo privilegio. **Sigue sin aprobarse** (P-05). Detalle en `20-alineacion-integral.md` §6.2.
