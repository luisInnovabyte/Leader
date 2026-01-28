# 🚀 INSTRUCCIONES: Activar Monitor de Sesión v2.0

**Fecha:** 28 de enero de 2026  
**Versión:** 2.0.0 - Con protecciones mejoradas  
**Objetivo:** Detectar automáticamente sesiones expiradas y redirigir al login

---

## 📦 ARCHIVOS A SUBIR AL SERVIDOR

### 1️⃣ OBLIGATORIOS (Sistema de Producción)

```
✓ public/js/session_monitor.js         → Subir COMPLETO
✓ config/templates/mainFooter.php      → Subir COMPLETO
```

### 2️⃣ TEMPORAL (Solo para Pruebas - ELIMINAR después)

```
⚠️ test_monitor_sesion.php             → ELIMINAR después de probar
```

---

## 🔧 MEJORAS IMPLEMENTADAS (v2.0)

### Problema Anterior
- Se ejecutaba continuamente
- Hacía el sistema inoperativo
- No había protección contra bucles infinitos

### Soluciones Aplicadas

✅ **1. Protección contra verificaciones simultáneas**
```javascript
let verificandoSesion = false; // Nueva bandera
```

✅ **2. Contador de errores con límite**
```javascript
let contadorErrores = 0;
const MAX_ERRORES = 3; // Detiene después de 3 errores
```

✅ **3. URLs absolutas en lugar de relativas**
```javascript
// Antes: ../../config/check_session.php (problemático)
// Ahora: https://dominio.com/logistica/config/check_session.php
```

✅ **4. Delay inicial de 2 segundos**
```javascript
setTimeout(verificarSesion, 2000); // No verificar inmediatamente
```

✅ **5. Detección y detención automática**
```javascript
if (contadorErrores >= MAX_ERRORES) {
    detenerMonitorSesion(); // Detiene el intervalo
}
```

✅ **6. Logs mejorados para debugging**
```javascript
console.log('Monitor: Verificando sesión en:', rutaCheckSession);
console.log('Monitor: Sesión activa ✓');
```

---

## 📋 PROTOCOLO DE IMPLEMENTACIÓN

### FASE 1: Subir Archivos (5 min)

1. **Conectar al servidor vía FTP/SFTP**
   - Host: `ftp.leader-transport.com` (o el que corresponda)
   - Usuario: `tu_usuario`
   - Contraseña: `tu_contraseña`

2. **Subir archivos MODIFICADOS:**

   ```
   LOCAL                                  →  SERVIDOR
   ========================================   =========================================
   
   public/js/session_monitor.js           →  /public_html/logistica/public/js/
   
   config/templates/mainFooter.php        →  /public_html/logistica/config/templates/
   
   test_monitor_sesion.php                →  /public_html/logistica/
   ```

3. **Verificar permisos:**
   - `session_monitor.js` → 644 (rw-r--r--)
   - `mainFooter.php` → 644 (rw-r--r--)
   - `test_monitor_sesion.php` → 644 (rw-r--r--)

---

### FASE 2: Pruebas Controladas (10 min)

#### Test 1: Página de Prueba Dedicada

1. **Acceder a:**
   ```
   https://tudominio.com/logistica/test_monitor_sesion.php
   ```

2. **Verificar estado:**
   - [ ] ¿Muestra "Estado de Sesión: ACTIVA"?
   - [ ] ¿Aparece tu usuario ID?

3. **Abrir consola del navegador (F12):**
   - [ ] Debe aparecer: `Monitor de sesión: ✓ Iniciado`
   - [ ] Esperar 2 segundos
   - [ ] Debe aparecer: `Monitor: Verificando sesión en: ...`
   - [ ] Debe aparecer: `Monitor: Sesión activa ✓`

4. **Probar expiración:**
   - Click en botón "Cerrar Sesión (nueva pestaña)"
   - Esperar máximo 60 segundos
   - [ ] ¿Apareció el modal de sesión expirada?
   - [ ] ¿Cuenta regresiva de 5 segundos funciona?
   - [ ] ¿Redirige automáticamente al login?

#### Test 2: Página Real del Sistema

1. **Iniciar sesión normalmente**

2. **Ir a cualquier página del sistema:**
   ```
   https://tudominio.com/logistica/view/Transportes/ordenTransporte.php?orden=12345
   ```

3. **Abrir consola (F12):**
   - [ ] ¿Aparece `Monitor de sesión: ✓ Iniciado`?
   - [ ] ¿NO aparece múltiples veces?
   - [ ] ¿Verifica cada 60 segundos?

4. **Cerrar sesión en otra pestaña:**
   ```
   https://tudominio.com/logistica/controller/logout.php
   ```

5. **Volver a la primera pestaña:**
   - [ ] Esperar máximo 60 segundos
   - [ ] ¿Modal aparece automáticamente?
   - [ ] ¿Redirige correctamente?

#### Test 3: Verificar NO Afecta Login

1. **Cerrar todas las pestañas**

2. **Ir directamente al login:**
   ```
   https://tudominio.com/logistica/view/Login/
   ```

3. **Abrir consola:**
   - [ ] ¿Aparece `Monitor de sesión: No iniciado (página de login)`?
   - [ ] ✓ CORRECTO: El monitor NO debe funcionar en login

---

### FASE 3: Monitoreo en Producción (30 min)

#### Durante los primeros 30 minutos:

1. **Pedir a 2-3 usuarios que usen el sistema normalmente**

2. **Preguntarles:**
   - [ ] ¿El sistema va lento?
   - [ ] ¿Se congela o bloquea?
   - [ ] ¿Ven alertas o mensajes extraños?
   - [ ] ¿Pueden trabajar con normalidad?

3. **Revisar consola en varias páginas:**
   - [ ] Solo debe aparecer 1 mensaje cada 60 segundos
   - [ ] NO deben aparecer errores continuos
   - [ ] NO debe haber bucles infinitos

---

## ⚠️ SEÑALES DE PROBLEMAS

### 🚨 DETENER INMEDIATAMENTE SI:

❌ **El sistema se pone lento o inoperativo**
❌ **Aparecen errores continuos en consola**
❌ **El monitor verifica más de 1 vez por minuto**
❌ **Los usuarios no pueden trabajar**

### 🛑 ROLLBACK URGENTE (Revertir cambios)

Si hay problemas, ejecutar inmediatamente:

1. **Desactivar el monitor:**
   ```
   Editar: config/templates/mainFooter.php
   
   Comentar la línea:
   <!-- <script src="../../public/js/session_monitor.js"></script> -->
   
   Subir archivo modificado al servidor
   ```

2. **Limpiar caché de navegadores:**
   ```
   Ctrl + Shift + R  (Windows/Linux)
   Cmd + Shift + R   (Mac)
   ```

3. **Verificar que el sistema vuelve a funcionar normal**

---

## ✅ SEÑALES DE ÉXITO

### Todo OK si:

✅ Sistema funciona con normalidad  
✅ Solo 1 verificación cada 60 segundos  
✅ Modal aparece cuando sesión expira  
✅ Usuarios no notan ningún problema  
✅ No hay errores en consola (excepto verificaciones)  

---

## 🧹 LIMPIEZA POST-PRUEBAS

Una vez confirmado que TODO funciona:

1. **ELIMINAR archivo de prueba del servidor:**
   ```bash
   rm /public_html/logistica/test_monitor_sesion.php
   ```

2. **Razón:** Contiene código de debugging que no debe estar en producción

---

## 📊 REGISTRO DE CAMBIOS

| Archivo | Cambio Realizado | Razón |
|---------|------------------|-------|
| `session_monitor.js` | Añadida bandera `verificandoSesion` | Evitar verificaciones simultáneas |
| `session_monitor.js` | Contador de errores (max 3) | Detener monitor si hay muchos errores |
| `session_monitor.js` | URLs absolutas | Evitar errores de rutas relativas |
| `session_monitor.js` | Delay inicial de 2 seg | No verificar durante carga de página |
| `session_monitor.js` | Logs mejorados | Facilitar debugging |
| `mainFooter.php` | Añadida línea `<script>` | Cargar monitor en todas las páginas |
| `test_monitor_sesion.php` | Archivo nuevo | Página dedicada para pruebas |

---

## 🔍 DEBUGGING AVANZADO

### Si hay problemas, revisar en consola:

**Comandos útiles:**
```javascript
// Ver estado del monitor
console.log(SessionMonitor);

// Verificar si está cargado
console.log(window.SessionMonitorCargado);

// Forzar verificación
SessionMonitor.verificarAhora();

// Detener monitor
SessionMonitor.detener();
```

**Logs esperados (cada 60 seg):**
```
Monitor de sesión: ✓ Iniciado - verificación cada 60 segundos
Monitor: Verificando sesión en: https://...
Monitor: Sesión activa ✓
```

**Logs cuando expira:**
```
Monitor: Sesión expirada detectada por status code: 401
=== SESIÓN EXPIRADA - PROCESANDO ===
Intervalo detenido
Ruta login calculada: https://.../view/Login/
Modal mostrado
```

---

## 📞 CONTACTO

**Desarrollador:** Innovabyte  
**Fecha implementación:** 28 de enero de 2026  
**Versión:** 2.0.0

**En caso de problemas urgentes:**
1. Revertir cambios (comentar script en mainFooter.php)
2. Documentar el error en consola (captura de pantalla)
3. Reportar al equipo de desarrollo

---

## ✨ RESUMEN EJECUTIVO

**¿Qué hace?**
- Verifica cada 60 segundos si la sesión sigue activa
- Muestra modal cuando expira
- Redirige automáticamente al login

**¿Qué se mejoró?**
- Protección contra ejecuciones continuas
- Contador de errores con límite
- URLs absolutas más robustas
- Mejor manejo de errores

**¿Cómo probar?**
1. Subir 2 archivos al servidor
2. Probar con test_monitor_sesion.php
3. Monitorear 30 minutos
4. Si todo OK, eliminar archivo de prueba

**¿Cómo revertir?**
- Comentar 1 línea en mainFooter.php
- Subir archivo modificado

---

**✅ Sistema listo para implementar**
