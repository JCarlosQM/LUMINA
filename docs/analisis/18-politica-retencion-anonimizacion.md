# LUMINA — Propuesta de Política de Retención y Anonimización (FASE 1.7)

> **Estado:** P-07 sigue **PENDIENTE DE APROBACIÓN**: **no se aprueban plazos** y **no se inventan plazos legales**. Este documento propone la **estructura** de la política (qué datos clasificar, qué columnas decidir) y una **propuesta de criterios**; toda cifra de días/meses marcada **POR DEFINIR** requiere tu decisión y, donde indiqué **[JURÍDICO]**, validación de asesoría (P-17…P-22).
> **Base:** entidades de `08-modelo-dominio-api.md`, RF-11 (consentimientos), `H06M` (borrado local), `H07M` (ARCO), `ADM-18` (auditoría), `10-dependencias-tecnicas.md` §7 y la regla D-15 (no inventar plazos ni textos legales).
> **Regla de esta propuesta:** preferimos **"mínimo necesario por finalidad"** a cifras arbitrarias; los pocos números técnicos que aparecen son parámetros propuestos, marcados como tales.

---

## 1. Método

Por cada categoría de dato se decide: **finalidad · necesidad · datos personales · ubicación (entidad/campo) · acceso (roles `17`) · retención propuesta · tratamiento al vencimiento (borrado/anonimización) · consecuencias · puntos de validación**. Las columnas de plazo quedan **POR DEFINIR** salvo que exista un criterio técnico, no jurídico.

## 2. Clasificación de datos y política propuesta

| # | Categoría | Entidad (`08`) / ubicación | Finalidad | Acceso (ref. `17`) | Retención propuesta | Al vencimiento | Consecuencias / notas |
|---|---|---|---|---|---|---|---|
| 1 | **Cuenta** | `User` (email 🔒, displayName 🔒, hash, rol, estado) | Identidad, acceso, moderación | Servidor; TIER 1 gestiona | Mientras la cuenta esté activa + **POR DEFINIR** tras baja **[JURÍDICO]** | Borrado o anonimización | Decide qué pasa con su contenido público (ver fila 4); sin cuenta no hay reseñas nuevas |
| 2 | **Autenticación** | códigos OTP (hash + `expiresAt`), intentos, sesiones, (futuro: semillas TOTP) | Seguridad del acceso | Servidor (nadie más) | **Efímera por diseño**: código OTP **POR DEFINIR** (propuesta técnica: horas, nunca claro); sesiones hasta caducidad/invalidez | Borrado automático | Minimización; nada legible para humanos; logs sin código ni email completo (D-12) |
| 3 | **Consentimientos** | `Consent` (RF-11, `H06M`) | Prueba de opt-in | Servidor; usuario lee los suyos | Mientras vigente + **POR DEFINIR** para la prueba **[JURÍDICO]** | Borrado tras perder la finalidad | Sin consentimiento registrado no se puede invocar afterwards |
| 4 | **Reseñas / testimonios** | `Review` | Contenido público | Público (aprobados); staff modera | **POR DEFINIR**: (a) mientras el usuario lo permita, (b) plazo fijo, o (c) indefinido con anonimización — **tu decisión** | Borrado físico o anonimización (quitar autoría, conservar texto si aporta al lugar) | Ponderar libertad de expresión vs derecho de supresión; marca de tiempo y moderación se conservan para trazabilidad |
| 5 | **Multimedia de usuarios** | `MediaAsset` | Contenido de reseñas/lugares | Público; TIER 2/3 cura | Igual que fila 4 (mismo criterio para autoría) | Borrado del objeto + miniaturas + copias de caché | Incluir **purga de EXIF** al subir (R6); `ADM-16` |
| 6 | **Moderación (reportes, dictámenes)** | `Report` (C-2), estados de `ModerationItem` | Decisión, recurso, disciplina | Sólo staff | **POR DEFINIR**: conservar lo mínimo para defensa del criterio **[JURÍDICO]** | Anonimizar actor si procede; conservar decisión | Si se borra todo, no hay defensa de decisiones de moderación |
| 7 | **Auditoría (cadena SHA-256)** | log append-only (`ADM-18`, `08` §6.3) | Integridad, investigación | TIER 1 (export con YubiKey) | **POR DEFINIR [JURÍDICO]** — la integridad exige conservar la cadena; el acceso, no | **No borrar** la cadena; sí restringir acceso | Borrado parcial rompe la cadena: diseño debe preverlo (hash de hueco) |
| 8 | **Solicitudes ARCO** | `PrivacyRequest` (`H07M`) | Prueba de cumplimiento | TIER 1 | **POR DEFINIR [JURÍDICO]** (conservación de la constancia, no del contenido solicitado) | Anonimizar lo accedido | El "plazo de respuesta" de la pantalla (15 días hábiles, Ley 29571 citada) es de **respuesta**, no de retención — no confundir; P-17 pendiente |
| 9 | **Telemetría / analítica** | sin entidad aún (`B8`, `H06M`) | Producto | Servidor | **POR DEFINIR**: mínima; sin identificador directo si es posible | Borrado agregando | Nada sin consentimiento (R11); borrado local efectivo en PWA |
| 10 | **Cola offline / sync** | `SyncQueue`, `OfflinePackage` | Funcionamiento | Cliente (local) + servidor transitorio | **Efímera**: hasta aplicar/rechazar la operación | Borrado automático | Local borrable por el usuario (`H06M`) |
| 11 | **Contenido editorial** (lugares, rutas, topónimia) | `Place`, `Route`, `Waypoint` | Producto | Staff edita | **No es dato personal**: retener mientras exista el catálogo; versionar cambios en auditoría | — | Toponimia Runa Simi: criterios con comunidad (P-22) |

## 3. Mecanismos de tratamiento (propuesta)

| Mecanismo | Cuándo | Cómo |
|---|---|---|
| **Borrado físico** | Datos sin obligación de conservar y sin trazabilidad necesaria | DELETE + purga de copias/caché/CDN |
| **Anonimización** | Contenido que aporta al producto pero cuya autoría no debe persistir | Quitar/quemar vínculo con `User` (autor → "usuario eliminado"), conservar texto/medio si la política lo decide |
| **Pseudonimización** | Auditoría y moderación | Referencias por `actorId` opaco; email nunca en vistas ordinarias (D-12) |
| **Exportación** | Solicitud del usuario (portabilidad, RF-11/ARCO) | Endpoint ya previsto en `08` (`POST /me/privacy-requests`) |
| **Cascada** | Baja de cuenta | Definir: contenido público → ¿borrado o anonimización? (fila 4); reportes y auditoría **no** se borran |

## 4. Puntos que deben validarse (jurídico/decisión) — **sin plazos inventados**

1. Plazo de conservación de **cuenta** tras baja (fila 1) — **[JURÍDICO]**.
2. Tratamiento de **reseñas** ante supresión: ¿borrado o anonimización? y qué prevalece en disputa (fila 4) — **[JURÍDICO]** + producto.
3. Conservación de **moderación** y **auditoría** para defensa de decisiones (filas 6–7) — **[JURÍDICO]**.
4. **Consentimientos** y **solicitudes ARCO**: plazos de conservación de la prueba (filas 3, 8) — **[JURÍDICO]** (P-17…P-20).
5. **Telemetría**: qué se mide con consentimiento y cuánto se guarda (fila 9) — producto + legal.
6. **Libro de Reclamaciones** (si se implementa, P-18): sus obligaciones de conservación — **[JURÍDICO]**.

> **Ningún plazo de este documento es un compromiso publicable** hasta tu aprobación y el dictamen legal. El copy de privacidad (`H04M`, `H06M`) se redacta después, no antes.

## 5. Consecuencias de diseño (sin migraciones ni código)

- `08` §7.6 queda **parcialmente respondida**: la política existe como propuesta (este documento); los plazos siguen abiertos.
- El esquema futuro deberá prever `deletedAt` / `anonymizedAt` y borrado en cascada — **se concreta en FASE 2, no ahora**.
- La cola offline y los paquetes se diseñan efímeros por defecto (sin política nueva).
- Compatibilidad: RF-11 (consentimientos borrables) y `H06M` quedan cubiertos por el mecanismo de exportación/borrado.

## 6. Decisiones que requieren tu aprobación (P-07)

1. Aceptar la **estructura** §2 como base de la política (sí/no + correcciones).
2. Resolver los **6 puntos §4** (con asesoría donde marque [JURÍDICO]).
3. Elegir el criterio de **reseñas** (fila 4: borrado vs anonimización).
4. Confirmar que **auditoría no se borra** y cómo se manejan huecos en la cadena (fila 7).
5. Decidir alcance de **telemetría** (fila 9) para enlazar con P-08/B8.

## 7. Conciliación con los requisitos legales del PDF v5.0 (Alineación 2026-10-10)

| Tema | PDF v5.0 | Verificado |
|---|---|---|
| Consentimiento expreso, previo, informado (checkbox no premarcado) | Sí | **[VER]** Ley 29733 + DS 016-2024-JUS |
| Política de Privacidad (art. 18) | Sí | **[VER]** |
| Registro Banco de Datos ante ANPDP antes del piloto | Sí | **[VER]** Ley 29733 art. 29 |
| ARCO + portabilidad + desindexación | Sí | **[VER]** Plazos: información 8, acceso 20, rectificación/cancelación/oposición 10 (días; hábiles/calendario por confirmar) |
| Libro de Reclamaciones Virtual (INDECOPI) | Sí | **[VER]** 15 días hábiles respuesta; conservación 2 años; libro físico de respaldo; multas 50–450 UIT |
| Licencia UGC (no exclusiva) | Sí | **[PDF]** (texto requiere abogado) |
| Autorización de imagen/logotipo de negocios | Sí | **[PDF]** (texto requiere abogado) |
| **Notificación de brechas: 48 h** | Sí | **[VER]** DS 016-2024-JUS art. 34: **48 h confirmado** (a ANPDP y titulares; con condiciones) |
| Ubicación procesada en cliente, no en servidor | Sí | **[PDF]** + RF-01/02 |
| Oficial de Datos Personales | — | **[VER]** DS 016-2024-JUS: ODP obligatorio para grandes empresas (desde 2025-11-30) |

**El PDF tiene razón en las obligaciones legales.** El plazo de 48 h está respaldado por el DS 016-2024-JUS art. 34 (con condiciones). Los plazos ARCO exactos y la distinción hábiles/calendario requieren confirmación jurídica profesional. **No se inventan plazos de retención ni textos legales.** Detalle en `20-alineacion-integral.md` §6.3.
