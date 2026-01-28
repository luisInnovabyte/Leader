# Monitor de Sesión - Instrucciones de Implementación

**Fecha:** 27 de enero de 2026  
**Archivo creado:** `public/js/session_monitor.js`  
**Propósito:** Detectar automáticamente cuando expira la sesión y redirigir al login

---

## 🎯 ¿Qué hace?

El monitor de sesión verifica automáticamente cada **60 segundos** si la sesión del usuario sigue activa. Si detecta que ha expirado:

1. ✓ Detiene la verificación
2. ✓ Muestra un **modal informativo**
3. ✓ Cuenta regresiva de **5 segundos**
4. ✓ Redirige automáticamente al **login**
5. ✓ Incluye botón para ir inmediatamente

---

## 📋 Cómo Implementarlo

### Opción 1: Incluir en Plantilla Global (Recomendado)

Si existe un archivo de plantilla común que se incluye en todas las páginas (ej: `mainHead.php`, `footer.php`), añadir antes del cierre de `</body>`:

```php
<!-- Monitor de Sesión - Detecta sesiones expiradas -->
<script src="../../public/js/session_monitor.js"></script>
```

**Ubicación recomendada:** `config/templates/mainFooter.php` o similar

### Opción 2: Incluir en Páginas Individuales

En cada archivo PHP donde se necesite (ej: `view/Transportes/ordenTransporte.php`), añadir antes del cierre de `</body>`:

```php
<!-- Scripts normales de la página -->
<script src="index.js"></script>

<!-- Monitor de Sesión -->
<script src="../../public/js/session_monitor.js"></script>

</body>
</html>
```

**Ajustar la ruta según la profundidad del archivo:**
- Desde `view/Transportes/`: `../../public/js/session_monitor.js`
- Desde `view/Home/`: `../../public/js/session_monitor.js`
- Desde raíz: `./public/js/session_monitor.js`

---

## 🔧 Configuración

### Tiempo de Verificación

Por defecto verifica cada **60 segundos**. Para cambiar:

```javascript
// En session_monitor.js línea 157
intervaloVerificacionSesion = setInterval(verificarSesion, 60000); // 60000 = 60 seg
```

Opciones comunes:
- `30000` = 30 segundos (más frecuente)
- `60000` = 1 minuto (recomendado)
- `120000` = 2 minutos (menos frecuente)

### Tiempo de Cuenta Regresiva

Por defecto **5 segundos** antes de redirigir. Para cambiar:

```javascript
// En session_monitor.js línea 96
let segundos = 5; // Cambiar a 3, 5, 10, etc.
```

---

## 🎨 Personalización del Modal

El modal usa clases de Bootstrap 5 y Boxicons. Para personalizar:

```javascript
// Cambiar color del header (línea 23)
<div class="modal-header bg-warning"> <!-- bg-danger, bg-info, bg-primary -->

// Cambiar icono (línea 25)
<i class="bx bx-time"></i> <!-- bx-error, bx-log-out, bx-shield-x -->

// Cambiar textos (líneas 30-33)
<h5>Su sesión ha finalizado</h5>
<p>Por motivos de seguridad...</p>
```

---

## 🧪 Pruebas

### Probar Manualmente

1. **Forzar expiración de sesión:**
   - Opción A: Ejecutar `controller/logout.php` en otra pestaña
   - Opción B: Modificar temporalmente `check_session.php` para que siempre retorne 401
   - Opción C: Esperar el timeout natural de sesión PHP

2. **Verificar en consola:**
   ```
   Monitor de sesión: Iniciado - verificación cada 60 segundos
   ```

3. **Verificar funcionamiento:**
   - Esperar a que expire la sesión
   - Debe aparecer el modal automáticamente
   - Debe contar desde 5 hasta 0
   - Debe redirigir al login

### Verificar Manualmente

Ejecutar en la consola del navegador:

```javascript
// Verificar que está activo
console.log(SessionMonitor);

// Forzar verificación inmediata
SessionMonitor.verificarAhora();

// Detener el monitor (para pruebas)
SessionMonitor.detener();

// Reiniciar el monitor
SessionMonitor.iniciar();
```

---

## 🚫 Páginas que NO Necesitan el Monitor

El script se **desactiva automáticamente** en:
- `/Login/` - Página de inicio de sesión
- `/login/` - Variante minúscula

No hace falta excluirlo manualmente.

---

## 📁 Estructura de Archivos

```
public/js/
  └── session_monitor.js          ← Archivo principal
  
config/
  └── check_session.php            ← Endpoint de verificación (ya existe)
  
controller/
  └── logout.php                   ← Cierre de sesión (ya existe)
  
docs/
  └── session_monitor_setup.md     ← Este archivo
```

---

## 🔒 Seguridad

✓ **No requiere credenciales** - Solo verifica estado de sesión  
✓ **No expone información sensible** - Solo indica si está activa o no  
✓ **Usa fetch con credentials** - Mantiene cookies de sesión  
✓ **No intercepta logout normal** - Solo detecta expiraciones

---

## 🐛 Troubleshooting

### El modal no aparece

1. Verificar que `session_monitor.js` se carga correctamente:
   ```html
   <!-- Revisar en inspector del navegador → Network → JS -->
   ```

2. Verificar en consola errores de JavaScript

3. Comprobar que Bootstrap 5 está cargado (necesario para el modal)

### Redirige a ruta incorrecta

El script intenta detectar automáticamente la profundidad. Si falla:

```javascript
// Línea 76-77 en session_monitor.js
// Cambiar manualmente:
let rutaLogin = '../Login/'; // Ajustar según necesidad
```

### Verificación muy lenta

```javascript
// Reducir tiempo de verificación (línea 157)
intervaloVerificacionSesion = setInterval(verificarSesion, 30000); // 30 seg
```

---

## 📝 Ejemplo de Implementación Completa

### En ordenTransporte.php

```php
<!doctype html>
<html lang="es">
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <!-- Otros includes... -->
</head>
<body>
    
    <!-- Contenido de la página -->
    
    <!-- Scripts al final del body -->
    <script src="../../public/assets/js/jquery.min.js"></script>
    <script src="../../public/assets/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts específicos de la página -->
    <script src="index.js"></script>
    
    <!-- ⭐ Monitor de Sesión - AÑADIR AQUÍ ⭐ -->
    <script src="../../public/js/session_monitor.js"></script>
    
</body>
</html>
```

---

## ✅ Checklist de Implementación

- [ ] Archivo `session_monitor.js` subido a `public/js/`
- [ ] Script incluido en plantilla global O en páginas individuales
- [ ] Ruta de inclusión correcta según profundidad
- [ ] Bootstrap 5 cargado (necesario para modal)
- [ ] Boxicons cargado (necesario para iconos)
- [ ] Probado forzando expiración de sesión
- [ ] Modal aparece correctamente
- [ ] Cuenta regresiva funciona
- [ ] Redirección al login correcta
- [ ] No interfiere con logout normal
- [ ] Funciona en diferentes páginas del sistema

---

## 🔄 Próximas Mejoras Opcionales

- [ ] Guardar estado antes de redirigir (para volver a la misma página)
- [ ] Advertencia previa 1 minuto antes de expirar
- [ ] Botón de "Extender sesión" haciendo ping al servidor
- [ ] Registro de eventos de expiración en log
- [ ] Sonido de notificación al expirar

---

**Autor:** Sistema  
**Versión:** 1.0.0  
**Última actualización:** 27 de enero de 2026
