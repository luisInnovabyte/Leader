# Registro de Modificaciones - Sistema Logística Leader

## Información del Documento
- **Fecha de creación:** 27 de enero de 2026
- **Última actualización:** 27 de enero de 2026
- **Rama:** terrestre
- **Propósito:** Documentar todas las modificaciones realizadas en el sistema

---

## Índice de Modificaciones

1. [Mejoras en Sistema de Firmas y QR](#modificación-1-mejoras-en-sistema-de-firmas-y-qr)
2. [Optimización de Canvas de Firma](#modificación-2-optimización-de-canvas-de-firma)

---

## Modificación #1: Mejoras en Sistema de Firmas y QR

**Fecha:** 27 de enero de 2026  
**Pantalla afectada:** `view/Transportes/ordenTransporte.php`  
**Tipo:** Mejora - UX / Corrección de Errores

### Descripción del Problema
- El código QR no se mostraba al abrir el modal
- Los campos de firma no eran intuitivos (canvas oculto sin explicación)
- Faltaba optimización para dispositivos móviles
- Los datos del conductor no se pre-rellenaban automáticamente

### Cambios Realizados

#### 1. Corrección del Código QR
**Archivos modificados:**
- `view/Transportes/index.js`

**Cambios:**
- Creada variable global `qrCodeInstance` para evitar problemas de scope
- Añadida validación de disponibilidad de librería `QRCodeStyling`
- Eliminada dependencia de imagen local `ojo.png`
- Añadidos logs de depuración en consola

**Código relevante:**
```javascript
// Variable global para el QR
var qrCodeInstance = null;

if (typeof QRCodeStyling !== 'undefined') {
  try {
    qrCodeInstance = new QRCodeStyling({...});
    console.log("QRCodeStyling inicializado correctamente");
  } catch (error) {
    console.error("Error al inicializar QRCodeStyling:", error);
  }
}
```

#### 2. Mensajes Informativos en Modal de Firma
**Archivos modificados:**
- `view/Transportes/modalFirma.php`

**Cambios:**
- Añadidos mensajes informativos en las 3 pestañas del modal
- Mensaje: "Complete nombre y documento para activar el área de firma"
- Los mensajes desaparecen automáticamente al completar los campos

**Código añadido:**
```html
<div id="mensajeInfoConductor" class="col-12 alert alert-info text-center mg-b-20" role="alert">
    <i class="bx bx-info-circle"></i> Complete nombre y documento para activar el área de firma
</div>
```

#### 3. Pre-rellenado Automático de Datos del Conductor
**Archivos modificados:**
- `view/Transportes/ordenTransporte.php`
- `view/Transportes/index.js`

**Cambios:**
- Añadidos inputs ocultos con datos del conductor:
  - `conductorNombreData`: Contiene `CONDUCTOR_NOMBRE`
  - `conductorNifData`: Contiene `CONDUCTOR_NIF`
- JavaScript pre-rellena automáticamente los campos al abrir el modal
- Funciona tanto al cargar la página como al abrir el modal

**Código PHP añadido:**
```php
<input id="conductorNombreData" type="hidden" value="<?php echo isset($jsonDatos['CONDUCTOR_NOMBRE']) ? $jsonDatos['CONDUCTOR_NOMBRE'] : ''; ?>">
<input id="conductorNifData" type="hidden" value="<?php echo isset($jsonDatos['CONDUCTOR_NIF']) ? $jsonDatos['CONDUCTOR_NIF'] : ''; ?>">
```

**Código JavaScript añadido:**
```javascript
$('#firma_modal').on('shown.bs.modal', function () {
  preRellenarConductor();
});
```

#### 4. Optimización para Móvil
**Archivos modificados:**
- `view/Transportes/modalFirma.php`

**Cambios:**
- Añadido `autocomplete="name"` en campos de nombre
- Añadido `autocomplete="email"` en campos de correo
- Añadido `autocomplete="off"` en campos de DNI (seguridad)
- Añadido `inputmode="text"` para campos de texto
- Añadido `inputmode="email"` para campos de email
- Cambiado `type="text"` a `type="email"` en campos de correo

#### 5. Refactorización de Código
**Archivos modificados:**
- `view/Transportes/index.js`

**Cambios:**
- Creadas funciones reutilizables:
  - `verificarCamposConductor()`
  - `verificarCamposReceptor()`
  - `verificarCamposCliente()`
- Eliminado código duplicado en función `cargarViaje()`

### Archivos Modificados (Resumen)
```
✓ view/Transportes/modalFirma.php
✓ view/Transportes/ordenTransporte.php
✓ view/Transportes/index.js
✓ docs/firma-transporte.md (documentación actualizada)
```

### Testing Realizado
- [ ] Verificar QR en servidor remoto
- [ ] Probar pre-rellenado de campos conductor
- [ ] Verificar mensajes informativos
- [ ] Probar en dispositivos móviles

---

## Modificación #2: Optimización de Canvas de Firma

**Fecha:** 27 de enero de 2026  
**Pantalla afectada:** `view/Transportes/ordenTransporte.php` - Modal de Firma  
**Tipo:** Mejora - UX / Usabilidad Móvil

### Descripción del Problema
Los canvas de firma tenían un tamaño horizontal limitado (400px), lo que dificultaba firmar cómodamente, especialmente en dispositivos móviles en orientación horizontal.

### Cambios Realizados

#### Aumento del Tamaño Horizontal de Canvas
**Archivos modificados:**
- `view/Transportes/modalFirma.php`
- `view/Transportes/index.js`

**Cambios:**
- Aumentado el ancho de todos los canvas de **400px a 600px**
- Afecta a: Canvas Conductor, Canvas Receptor, Canvas Cliente
- Mantiene altura de 300px
- Actualizado tanto en HTML como en funciones JavaScript de redimensionamiento

**Antes:**
```html
<canvas id="signaturePadConductor" width="400" height="300"></canvas>
```

**Después:**
```html
<canvas id="signaturePadConductor" width="600" height="300"></canvas>
```

**JavaScript actualizado:**
```javascript
const onResize = () => {
  $("#signaturePadConductor").attr({
    height: 200,
    width: 600, // Aumentado para mejor experiencia en móvil
  });
};
```

### Archivos Modificados (Resumen)
```
✓ view/Transportes/modalFirma.php (3 canvas actualizados)
✓ view/Transportes/index.js (3 funciones onResize actualizadas)
```

### Beneficios
- Mayor espacio para firmar en dispositivos móviles
- Mejor experiencia de usuario en tablets
- Firmas más naturales y legibles

---

## Modificaciones Pendientes

## Modificación #3: Corrección Configuración SMTP para Envío de Correos

**Fecha:** 27 de enero de 2026  
**Componente afectado:** Sistema de envío de correos electrónicos  
**Tipo:** Corrección de Error - Configuración + Scripts de Depuración

### Descripción del Problema
Al intentar enviar correos electrónicos desde el sistema (ej: enviar orden al receptor), se producía el siguiente error:
```
SMTP Error: The following recipients failed: correo@dominio.es: Relay access denied
```

**Causas detectadas:**
1. Falta configuración de cifrado SSL/TLS en `configMail.php`
2. Uso de constantes PHPMailer no disponibles en archivo de configuración incluido
3. Necesidad de verificar credenciales SMTP en base de datos

### Cambios Realizados

#### 1. Configuración SSL/TLS Corregida
**Archivos modificados:**
- `controller/configMail.php`

**Primera versión (con error):**
Intentaba usar constantes de PHPMailer que no estaban disponibles porque el archivo se incluye sin cargar la clase:
```php
// ERROR: PHPMailer::ENCRYPTION_STARTTLS no disponible
if ($smtp_port == 587) {
   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
}
```

**Versión corregida (funcional):**
Usa literales de string compatibles con PHPMailer incluido vía `require`:
```php
// Configuración de cifrado según el puerto
if ($smtp_port == 587) {
   $mail->SMTPSecure = 'tls';      // TLS para puerto 587 (STARTTLS)
} elseif ($smtp_port == 465) {
   $mail->SMTPSecure = 'ssl';      // SSL para puerto 465 (SMTPS)
}
// Puerto 25 no configura cifrado
```

**Código completo añadido:**
```php
<?php
// Configuración SMTP
if ($smtp_auth == 1) {
   $mail->SMTPAuth   = true;
} else {
   $mail->SMTPAuth   = false;
}

$mail->Host       = $smtp_host;
$mail->Username   = $smtp_username;
$mail->Password   = $smtp_pass;
$mail->Port       = $smtp_port;

// Configuración de cifrado según el puerto
if ($smtp_port == 587) {
   $mail->SMTPSecure = 'tls';      // TLS para puerto 587 (STARTTLS)
} elseif ($smtp_port == 465) {
   $mail->SMTPSecure = 'ssl';      // SSL para puerto 465 (SMTPS)
}
// Puerto 25 no configura cifrado (no recomendado para producción)
?>
```

#### 2. Script de Depuración Simple (Recomendado)
**Archivo creado:** `debug_smtp_simple.php` (raíz del proyecto)

**Características:**
- Conexión directa a BD sin dependencias de sesiones
- Lee configuración del archivo JSON del dominio
- Consulta la vista `view_empresa_config` (JOIN entre `empresa` y `tm_config`)
- Muestra configuración SMTP actual de forma segura
- Oculta parcialmente la contraseña
- Diagnóstico automático según puerto configurado
- Verifica extensiones PHP necesarias (openssl, sockets)
- Proporciona checklist para el cliente

**Uso:**
1. Subir archivo a raíz: `https://tudominio.com/logistica/debug_smtp_simple.php`
2. Acceder desde navegador
3. Copiar información mostrada
4. Enviar al cliente para validación de credenciales
5. **ELIMINAR archivo inmediatamente** después de usar (seguridad)

**Información que muestra:**
- ✓ Servidor SMTP (host)
- ✓ Puerto configurado
- ✓ Usuario SMTP
- ✓ Contraseña (parcialmente oculta: `ab******yz`)
- ✓ Autenticación activada/desactivada
- ✓ Cifrado recomendado según puerto
- ✓ IP del servidor web (para whitelist)
- ✓ Versión de PHP
- ✓ Extensiones PHP disponibles

#### 3. Script de Depuración con Sesión (Alternativo)
**Archivo creado:** `debug_smtp.php` (raíz del proyecto)

**Características:**
- Usa sesión y clase Config (igual que la aplicación)
- Requiere estar logueado
- Misma información que el script simple
- Puede dar error 500 si hay problemas de carga de clases

**Recomendación:** Usar `debug_smtp_simple.php` que es más robusto

### Verificación de PHPMailer

**Ubicación:** `public/vendor/phpmailer/phpmailer/`

**Carga:**
```php
// En controller/transportes.php línea 8
require_once '../public/vendor/autoload.php';

// Uso con namespace
use PHPMailer\PHPMailer\PHPMailer;
$mail = new PHPMailer(true);
```

✓ **PHPMailer está correctamente instalado y cargado**

✓ **PHPMailer está correctamente instalado y cargado**

### Funcionalidad del Sistema de Correo

#### Ubicación del Botón de Envío
**Pantalla:** `view/Transportes/ordenTransporte.php`  
**Modal:** "Firmar Documento" → Pestaña "Firma Receptor"  
**Botón:** Icono rojo de sobre 📧 (botón `#enviarCorreoReceptorBtn`)

#### Proceso de Envío
1. Usuario completa datos del receptor:
   - Nombre
   - DNI/Documento
   - **Correo electrónico** (obligatorio para envío)
2. Click en botón rojo del sobre (NO en "Guardar Datos")
3. JavaScript valida formato de email
4. AJAX llama a `controller/transportes.php` caso `correoEnviarOrden`
5. PHP crea instancia PHPMailer y carga configuración SMTP
6. Se incluye `controller/configMail.php` (donde ahora está el cifrado)
7. Carga plantilla HTML: `public/mailTemplate/envioClienteOrden.html`
8. Reemplaza variables: `{{numeroOrden}}`, `{{enlaceOrden}}`
9. Envía correo usando SMTP configurado
10. Retorna JSON con éxito/error

#### Contenido del Email
**Asunto:** "Orden de Transporte - Leader Transport"

**Cuerpo HTML:**
- Encabezado con logo de Leader Transport
- Mensaje: "Has recibido una nueva orden de transporte"
- Número de orden destacado
- Botón verde: "Imprimir esta orden" → Enlace directo al PDF
- Footer con información de contacto

**Plantilla:** `public/mailTemplate/envioClienteOrden.html`

#### Código JavaScript del Envío
Ubicación: `view/Transportes/index.js` líneas ~1725-1793

```javascript
function enviarCorreoDatos() {
  var emailReceptor = $('#emailReceptor').val();
  var orden = getUrlParameter('orden');
  
  // Validación de email
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(emailReceptor)) {
    swal("Advertencia!", "Ingrese un correo electrónico válido", "warning");
    return;
  }

  $.post("../../controller/transportes.php?op=correoEnviarOrden", {
    email: emailReceptor,
    orden: orden
  }, function(data) {
    // Manejo de respuesta
  });
}
```

### Datos a Proporcionar al Cliente

### Datos a Proporcionar al Cliente

Ejecutar `debug_smtp_simple.php` y enviar al cliente la siguiente información:

**Configuración Actual en BD:**
- [ ] **Servidor SMTP:** _______________
- [ ] **Puerto:** _______________
- [ ] **Usuario SMTP:** _______________
- [ ] **Contraseña:** (verificar longitud y primeros/últimos caracteres)
- [ ] **Autenticación:** Activada ☐ / Desactivada ☐
- [ ] **Cifrado aplicado:** TLS (puerto 587) ☐ / SSL (puerto 465) ☐
- [ ] **IP del servidor web:** _______________ (para whitelist si es necesario)

**Preguntas para el Cliente:**

1. **Credenciales**
   - ☐ ¿El servidor SMTP es correcto?
   - ☐ ¿El puerto es el adecuado? (587 es el más común)
   - ☐ ¿Usuario y contraseña son correctos y están activos?

2. **Configuración del Servidor SMTP**
   - ☐ ¿El servidor requiere autenticación? (normalmente sí)
   - ☐ ¿El servidor requiere cifrado TLS/SSL? (normalmente sí)
   - ☐ ¿Qué tipo de cifrado: TLS (587) o SSL (465)?

3. **Restricciones y Permisos**
   - ☐ ¿El servidor permite relay desde la IP mostrada?
   - ☐ ¿Es necesario añadir la IP a una lista blanca (whitelist)?
   - ☐ ¿Hay límite de correos por hora/día/mes?
   - ☐ ¿Hay algún firewall o restricción en el hosting?

4. **Pruebas Alternativas**
   - ☐ ¿Funciona el SMTP desde otro cliente (Outlook, Thunderbird)?
   - ☐ ¿El proveedor SMTP proporciona logs de intentos de conexión?

### Protocolo de Testing

#### Fase 1: Verificación de Configuración
1. ✓ Subir `controller/configMail.php` actualizado al servidor
2. ✓ Subir `debug_smtp_simple.php` a la raíz
3. ☐ Acceder a `https://leader-transport.com/logistica/debug_smtp_simple.php`
4. ☐ Capturar pantalla con la configuración mostrada
5. ☐ Enviar al cliente para validación de credenciales
6. ☐ Esperar confirmación del cliente

#### Fase 2: Prueba de Envío Real
1. ☐ Acceder a una orden: `Transportes/ordenTransporte.php?orden=XXXXX`
2. ☐ Seleccionar un viaje del selector
3. ☐ Click en botón "Firmar Documento"
4. ☐ Ir a pestaña "Firma Receptor"
5. ☐ Completar:
   - Nombre: `Test Receptor`
   - DNI: `12345678A`
   - Email: `correo-prueba@dominio.com` (usar email real de prueba)
6. ☐ Click en botón rojo del sobre 📧
7. ☐ Verificar notificación de éxito/error en pantalla
8. ☐ Revisar bandeja de entrada del correo de prueba
9. ☐ Verificar que el email contiene:
   - Asunto correcto
   - Número de orden correcto
   - Botón de "Imprimir esta orden" funcional

#### Fase 3: Depuración Avanzada (si falla)
1. ☐ Habilitar debug en `configMail.php`:
   ```php
   $mail->SMTPDebug = 2;
   $mail->Debugoutput = 'html';
   ```
2. ☐ Repetir envío y capturar logs completos
3. ☐ Revisar logs del servidor SMTP (solicitar al cliente)
4. ☐ Probar conexión manual al SMTP:
   ```bash
   # Para TLS (puerto 587)
   telnet smtp.servidor.com 587
   
   # Para SSL (puerto 465)
   openssl s_client -connect smtp.servidor.com:465
   ```

#### Fase 4: Limpieza
1. ☐ **ELIMINAR** `debug_smtp_simple.php` del servidor
2. ☐ **ELIMINAR** `debug_smtp.php` si existe
3. ☐ Deshabilitar `SMTPDebug` en `configMail.php` si se activó
4. ☐ Documentar resultado final en este documento

4. ☐ Documentar resultado final en este documento

### Causas Comunes del Error "Relay Access Denied"

| # | Causa | Solución | Estado |
|---|-------|----------|--------|
| 1 | **Falta cifrado SSL/TLS** | Añadir `SMTPSecure = 'tls'` o `'ssl'` | ✓ Solucionado |
| 2 | **Credenciales incorrectas** | Verificar usuario/contraseña con cliente | ☐ Pendiente verificación |
| 3 | **IP no autorizada** | Cliente debe añadir IP a whitelist del SMTP | ☐ Pendiente verificación |
| 4 | **Puerto incorrecto** | Confirmar: 587 (TLS) o 465 (SSL) | ☐ Pendiente verificación |
| 5 | **Autenticación desactivada** | Activar `SMTPAuth = true` | ✓ Ya configurado |
| 6 | **Límites excedidos** | Esperar o solicitar aumento de límite | ☐ N/A |
| 7 | **Firewall bloqueando** | Abrir puerto en firewall del servidor | ☐ Pendiente verificación |
| 8 | **Constantes PHPMailer no disponibles** | Usar strings 'tls'/'ssl' en lugar de constantes | ✓ Solucionado |

### Archivos Modificados (Resumen)

```
✓ controller/configMail.php         (configuración SSL/TLS con strings)
✓ debug_smtp_simple.php             (script diagnóstico - TEMPORAL)
✓ debug_smtp.php                    (script alternativo - TEMPORAL)
✓ docs/modificaciones.md            (este documento actualizado)
```

### Archivos Temporales a ELIMINAR Después de Testing

⚠️ **IMPORTANTE - SEGURIDAD:**
```
❌ debug_smtp_simple.php    → Contiene información sensible de configuración
❌ debug_smtp.php            → Contiene información sensible de configuración
```

**Razón:** Estos scripts muestran configuración SMTP (servidor, usuario, contraseña parcial) que no debe ser accesible públicamente.

### Estado de la Base de Datos

**Tabla:** `tm_config`  
**Vista:** `view_empresa_config` (JOIN entre `empresa` y `tm_config`)

**Campos SMTP:**
- `smtp_host` - Servidor SMTP (ej: smtp.ionos.es)
- `snto_auth` - Autenticación: 1=activada, 0=desactivada
- `smtp_username` - Usuario de autenticación
- `smtp_pass` - Contraseña (almacenada en texto plano)
- `smtp_port` - Puerto: 587 (TLS), 465 (SSL), 25 (sin cifrado)
- `smtp_receptor` - Email del remitente por defecto

**Consulta para verificar:**
```sql
SELECT smtp_host, snto_auth, smtp_username, smtp_pass, smtp_port, smtp_receptor
FROM view_empresa_config
WHERE idConfig = 1;
```

### Referencias Técnicas

**Documentación relacionada:**
- [docs/firma-transporte.md](firma-transporte.md) - Sistema completo de firmas
- Plantilla email: `public/mailTemplate/envioClienteOrden.html`
- Controlador: `controller/transportes.php` líneas 310-425 (caso `correoEnviarOrden`)
- JavaScript: `view/Transportes/index.js` líneas 1725-1793 (`enviarCorreoDatos()`)

**PHPMailer:**
- Ruta: `public/vendor/phpmailer/phpmailer/`
- Cargado en: `controller/transportes.php` línea 8
- Namespace: `PHPMailer\PHPMailer\PHPMailer`

**Valores válidos para SMTPSecure:**
- `'tls'` - STARTTLS (puerto 587) - Recomendado
- `'ssl'` - SSL/TLS (puerto 465)
- `''` o no configurar - Sin cifrado (puerto 25) - No recomendado

---

## Modificaciones Pendientes

_(Esta sección se actualizará con las próximas modificaciones solicitadas)_

---

## Notas Técnicas

### Comandos Git Útiles
```bash
# Ver estado actual
git status

# Cambiar a rama terrestre
git checkout terrestre

# Ver cambios
git diff

# Añadir archivos
git add view/Transportes/

# Commit
git commit -m "Mejoras en sistema de firmas"

# Push
git push origin terrestre
```

### Archivos a Subir al Servidor (Últimas Modificaciones)
```
view/Transportes/modalFirma.php
view/Transportes/ordenTransporte.php
view/Transportes/index.js
controller/configMail.php               (SMTP - Modificación #3)
debug_smtp_simple.php                   (TEMPORAL - Modificación #3)
```

---

## Historial de Actualizaciones del Documento

| Fecha | Modificación | Descripción |
|-------|-------------|-------------|
| 27/01/2026 | Creación del documento | Registro de modificaciones 1 y 2 |
| 27/01/2026 | Modificación #3 | Sistema de envío de correos electrónicos - Configuración SMTP |

---

*Documento actualizado automáticamente - Última modificación: 27 de enero de 2026*
