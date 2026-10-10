# LUMINA — Especificación del Canal OTP por Correo y Proveedores de Email (FASE 1.7)

> **Estado (ALINEACIÓN DEFINITIVA 2026-10-10):** flujo OTP **ADOPTADO** (P-04). Código numérico de **6 dígitos** enviado por correo **solo durante el registro** (no en cada login, no enlace como flujo principal). Cuenta **pendiente de verificación** hasta validar. **No es 2FA para cada inicio de sesión.** Envío por **SMTP con cuenta de Google dedicada** (credenciales en env vars; capturador de correos en local). **No se ha escrito código ni se han creado credenciales.**
> **Base evidencial:** textos literales de `B04M`, `B07M`, `07&08`, `B08M`, `ADM-*` (2FA) de la evidencia de FASE 1.5 (`texto-pantallas.txt`), RF-08, `08-modelo-dominio-api.md` §5/§6, `10-dependencias-tecnicas.md` §2.
> **Regla:** los parámetros con valores concretos (10 min, 5 intentos, 60 s) son **propuestas iniciales** que deben quedar definidas en la configuración y en el contrato de autenticación. Los plazos legales no se tocan aquí (P-17…P-20 siguen abiertos).

---

## 1. Qué muestran las pantallas (hechos, sin interpretación)

| Evidencia | Texto literal relevante |
|---|---|
| `B04M` (registro) | "Registrarse con verificación OTP" · "Ingresa un formato de correo electrónico válido (ej. nombre@dominio.pe)" |
| `B04M`/`07&08` (verificación) | "Verificación OTP" · "Te enviaremos un código OTP de 6 dígitos para verificar tu identidad." · "Solicitar código de verificación OTP" |
| `B07M` (introducción del código) | `B07M-AUTH-Introducción-del-OTP-6-Dígitos` · "Hemos enviado un código numérico de 6 dígitos a …" · "256-BIT OTP" · "Ingresa el código de acceso de 6 dígitos" |
| `B08M` (login) | "Continuar con código OTP (Móvil)" · "Iniciar sesión con correo electrónico" |
| Consola `ADM` (2FA) | "Doble Factor de Autenticación (2FA / TOTP)" · "Ingrese el código dinámico de 6 dígitos generado por su dispositivo de seguridad (Google Authenticator / YubiKey)" |
| `08` §6.1 | Endpoints ya previstos: `POST /auth/register`, `/auth/login`, `/auth/otp/request`, `/auth/otp/verify`, `/auth/password/forgot` |
| `08` §5 R1 | Riesgo: enumeración de usuarios vía OTP → respuesta idéntica exista o no la cuenta + rate limit |

**Hechos:** canal de registro/login = **correo**; el código es **numérico de 6 dígitos**; existe además **TOTP 6 dígitos con dispositivo (Google Authenticator / YubiKey) para la consola administrativa** — éste es un **segundo factor para staff**, asunto distinto del OTP de registro/login (ver §7).

## 2. Alcance de esta especificación

**Dentro:** contrato funcional del OTP de **registro** (código 6 dígitos, verificación antes de acceder a funcionalidades protegidas), anti-abuso, eventos, errores, configuración **SMTP Google**.
**Fuera (separado):** OTP en cada login (no aplica), enlace de verificación como flujo principal (no aplica), SMS (D-06), TOTP de consola (§7), recuperación de contraseña y login con Google (fuera de alcance hasta autorización expresa), textos legales (P-20), ARCO (P-17).

## 3. Contrato OTP propuesto (parámetros **[PROPUESTA]** — pendientes de aprobación)

| Aspecto | Propuesta | Motivo / referencia |
|---|---|---|
| Formato del código | 6 dígitos numéricos (CSPRNG), **1 código activo por verificación** (solicitar de nuevo invalida el anterior) | Literal `B07M` "código numérico de 6 dígitos" |
| Almacenamiento | Guardar **sólo hash** del código + `expiresAt`; nunca el código en claro ni en logs | `08` §5; minimización |
| Expiración | **10 minutos** `[PROPUESTA]` | Ventana corta típica de OTP transaccional; el valor exacto lo fijas tú |
| Intentos de verificación | **5 intentos** por código → invalidar y exigir solicitar otro `[PROPUESTA]` | Fuerza bruta sobre 10⁶ combinaciones |
| Reenvío (cooldown) | **60 s** entre envíos a la misma cuenta; máx. **3** en 15 min; máx. **10** por hora por cuenta y por IP `[PROPUESTA]` | Anti-abuso + coste de proveedor |
| Rate limit global | `429` por IP+cuenta en `otp/request` y `otp/verify` (`08` §6.4) | `08` R1 |
| Anti-enumeración | Respuesta **idéntica** exista o no la cuenta/registro; mensajes genéricos ("si el correo existe…") | `B07M` promete no revelar afiliación; `08` R1 |
| Verificación de registro | El OTP verifica el correo **solo durante el registro**; la cuenta queda **pendiente de verificación** hasta validar. No se repite en cada login. | Encargo de alineación definitiva |
| Recuperación de contraseña | `POST /auth/password/forgot` → **enlace firmado de un solo uso**, caducidad **30 min** `[PROPUESTA]`; respuesta idéntica si la cuenta existe o no; cambiar la contraseña **invalida todas las sesiones** `[PROPUESTA]` | RF-08 (recuperación), enlace visible en `B02M` |
| Errores | Contrato `08` §6.4: `422` (formato), `429` (límite), `401` (código inválido/expirado) con mensajes que **no** distingan cuenta inexistente | `08` §6.4 |
| Eventos a registrar | `otp.requested`, `otp.sent`, `otp.verified`, `otp.failed`, `otp.rate_limited`, `password.reset_requested/used` con timestamp, resultado y hash de correlación — **sin** el código ni el email completo en claro en logs | `08` §5/§8 (auditoría); D-12 aplica a email |

> **Nada de esto se implementa hasta que apruebes el contrato (P-04).** Los valores entre corchetes son nuestra propuesta; si prefieres otros números, indícalos y quedan registrados.

## 4. Aislamiento del proveedor (exigencia D-14 y P-04)

El dominio no debe conocer al proveedor: cambiar de email transaccional no reescribe la autenticación.

1. **Puerto interno** `EmailSender` (interfaz: `send({to, template, data}) → {id}`) en la capa de aplicación; el dominio sólo invoca el puerto.
2. **Adaptadores** por proveedor (Resend/Postmark/SES/smtp) en la capa de infraestructura; se cambia por configuración, no por código de dominio.
3. **Plantillas versionadas** en el repo (asunto + texto); el proveedor sólo transporte. Datos mínimos en la plantilla (nombre, código/enlace).
4. **Credenciales** sólo en variables de entorno (`.env` local, secret manager en producción); **nunca** en código, logs ni cliente (R12 de `08`).
5. **SMS futuro (D-06):** el mismo patrón con un puerto `SmsSender` — si algún día se amplía, no se reescribe el dominio.
6. **Pruebas:** doble de memoria `EmailSender` para tests (sin red, sin coste).

## 5. Configuración de correo: SMTP con cuenta de Google (ADOPTADA)

> **Decisión (ALINEACIÓN DEFINITIVA):** envío del código OTP mediante **SMTP con una cuenta de Google dedicada** al envío de mensajes de LUMINA. La comparativa de proveedores de abajo queda como **referencia histórica** (D-14 mantiene el desacoplamiento por si el transporte cambia).

| Aspecto | Configuración |
|---|---|
| Transporte | **SMTP** (`MAIL_MAILER=smtp`) |
| Host | `smtp.gmail.com` · Puerto `587` (TLS) o `465` (SSL) |
| Usuario | Cuenta de Google dedicada (p. ej. `lumina@…`) |
| Contraseña | **App Password** de Google (no la contraseña de la cuenta) — requiere 2FA en la cuenta Google |
| Credenciales | **Solo en variables de entorno** (`MAIL_USERNAME`, `MAIL_PASSWORD`); nunca en código ni archivos versionados |
| Desarrollo local | **Capturador de correos** (p. ej. Mailpit/MailHog) para validar el flujo sin enviar mensajes reales |
| Prueba de entrega real | Configurar SMTP cuando se necesite probar con la cuenta Google |

**Condiciones de Google:** las App Passwords requieren tener 2FA activado en la cuenta Google; Google puede exigir verificación adicional según la política de seguridad de la cuenta. **No se incluyen credenciales reales.**

**Fuera de alcance (no requerido ahora):** recuperación de contraseña por correo, login con Google, flujos de notificación por correo. Cualquier flujo adicional requiere autorización expresa y se especificará aparte.

### 5.1 Referencia histórica: comparativa de proveedores transaccionales (2026-10-10)

| Proveedor | Plan gratuito | Pago de entrada | Exceso / adicional | Notas |
|---|---|---|---|---|
| **Resend** | 3.000 emails/mes, **100/día**, 3 dominios | Pro **20 US$/mes** (50.000) · 35 US$/mes (100.000) | +0,90 US$/1.000 | SOC2/GDPR, DKIM/SPF/DMARC, webhooks, multi-región *(fuente: resend.com/pricing, 2026-10-10)* |
| **Postmark** | **100/mes** (sólo prueba de integración) | Basic **15 US$/mes** (10.000) · Pro 16,50 US$/mes | +1,80 / +1,30 US$/1.000 | Retención de datos 45 días; énfasis en deliverabilidad transaccional *(postmarkapp.com/pricing, 2026-10-10)* |
| **Amazon SES** | Sin plan gratuito permanente (cuentas nuevas: modo sandbox, límite diario) | Sin mínimo; **0,10 US$/1.000** (à la carte) — el plan por defecto de cuentas nuevas es *Essentials* **0,16 US$/1.000** (0–10M/mes) | +0,12 US$/GB de adjuntos | El más barato; exige infraestructura propia (eventos, colas) y conocimiento AWS *(aws.amazon.com/ses/pricing, 2026-10-10; detalle de planes por buscador, re-verificar al contratar)* |
| **SMTP propio** | — | — | — | Deliverabilidad y reputación a cargo tuyo: **no recomendado** para MVP |

**Lectura para LUMINA:** el volumen de OTP es mínimo (sólo registro); **cualquier plan gratuito basta para desarrollo y arranque**. Criterios de elección, por este orden: (1) entregabilidad real del OTP (no promocional), (2) límites diarios suficientes sin tarjeta, (3) webhooks/registros para auditoría de envíos, (4) salida sin atadura (adaptador §4), (5) coste.

> **Recomendación (ADOPTADA):** **SMTP con cuenta de Google dedicada** (ver tabla de arriba). Desarrollo local con capturador de correos; entrega real con SMTP. El puerto `EmailSender` (§4) se mantiene para desacoplar el transporte. **No se ha creado ninguna cuenta.**

## 6. Relación con el resto de documentación

| Documento | Relación |
|---|---|
| `08-modelo-dominio-api.md` §6.1 | Endpoints de auth ya listados; este documento define su **contrato de comportamiento** (parámetros, errores, eventos) |
| `10-dependencias-tecnicas.md` §2 | Investigación previa (B5); esta comparativa la actualiza con fuentes y fecha 2026-10-10 |
| `11-decisiones-consolidadas.md` P-04 | Esta propuesta es la respuesta técnica pendiente de tu aprobación |
| `14-plan-fase-2.md` T-4 | La implementación (auth + rate limit + tests negativos) depende de aprobar este contrato |

## 7. Asunto observado y **fuera** de este contrato: 2FA/TOTP de consola

La evidencia (`ADM`) muestra "Doble Factor de Autenticación (2FA / TOTP)" con código de 6 dígitos de **Google Authenticator / YubiKey** para personal administrativo. Es un requisito **observado en diseños**, distinto del OTP por correo de RF-08.

- **Estado:** registrado aquí; **no se decide en este documento**. RF-15/RF-08 no lo mencionan explícitamente → figura como **pendiente de decisión de alcance** (¿entra en el MVP de administración o se pospone?). Si lo apruebas, se especificará aparte con el mismo método (parámetros, errores, recuperación de códigos perdidos, hardening de cuentas TIER 1).

## 8. Decisiones pendientes tras la alineación definitiva

1. **Contrato OTP**: confirmar las propuestas (caducidad 10 min, 5 intentos, coenvío 60 s) como valores de configuración — o indicar alternativos.
2. **2FA/TOTP de consola** (§7): ¿en el MVP o fuera? (sigue pendiente de alcance).
3. **Recuperación de contraseña y login con Google**: fuera de alcance hasta autorización expresa.
4. Confirmar que **SMS queda fuera** del MVP (D-06) y sólo como ampliación futura.

## 9. Comparación con el PDF v5.0 (Alineación 2026-10-10)

| Aspecto | PDF v5.0 | `16` (propuesta) | Estado |
|---|---|---|---|
| Código | 6 dígitos | 6 dígitos | **Coincide** |
| Caducidad | Redis TTL 10 min | 10 min (PROPUESTA) | **Coincide** (propuesta, no aprobado) |
| Almacenamiento | Redis | Hash + expiresAt (stack-agnostic) | Depende del stack (P-01) |
| Rate limit | Por correo e IP | Por cuenta e IP (429) | **Coincide** |
| Cooldown reenvío | 60 s (ejemplo) | 60 s (PROPUESTA) | **Coincide** (propuesta) |
| Anti-enumeración | No revelar registro | Respuesta idéntica | **Coincide** |
| Eliminación | Al expirar o usarse | Hash + expiración | **Coincide** |
| Intentos / bloqueos / sesión / revocación / auditoría / recuperación / admin | — | Parcialmente en `16` | **Pendiente** (P-04) |

**Valores ya definidos (PDF):** 6 dígitos, TTL 10 min, rate limit, cooldown 60 s, no revelar, eliminar al expirar/usar. **Valores que son ejemplos/propuestas:** intentos, reenvíos, bloqueos, duración de sesión, revocación de tokens, auditoría, recuperación, protección de cuentas admin. **No se inventan valores definitivos.** Detalle en `20-alineacion-integral.md` §6.1.
