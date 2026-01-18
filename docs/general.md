# Estructura General de la Aplicación - Leader Logística

## Descripción General
Esta es una aplicación web de gestión logística desarrollada en PHP con arquitectura MVC (Modelo-Vista-Controlador). Incluye gestión de transportes, conductores, órdenes, usuarios y un sistema completo de autenticación y permisos.

---

## 📁 Estructura de Carpetas

### **Raíz del Proyecto**
Contiene archivos PHP de diagnóstico, pruebas y configuración inicial:
- **index.php** - Punto de entrada principal de la aplicación
- **readme.md** - Documentación básica del proyecto
- **Scripts de diagnóstico:**
  - `check_cp_column.php` - Verificación de columnas en BD
  - `check_rol_simple.php` - Verificación de roles de usuario
  - `diagnostico_login.php` - Diagnóstico del sistema de login
  - `debug_usuarios.php` - Debug de usuarios
  - `verify_user_rol.php` - Verificación de roles de usuario
  - `test_conexion_bd.php` - Prueba de conexión a base de datos
- **Scripts de gestión:**
  - `crear_admin.php` - Creación de usuarios administradores
  - `wrapper_usuarios.php` - Wrapper para gestión de usuarios
- **Archivos JSON:** Configuraciones de dominio (idDominio1.json)

---

### **BD/** 
Contiene respaldos y exportaciones de la base de datos.

#### Subcarpetas:
- **20251123/** - Exportación de base de datos del 23 de noviembre de 2025
  - `Exportacion_20251123.sql`
  
- **20251125_Servidor/** - Exportación del servidor del 25 de noviembre
  - `newproject.sql`
  
- **BD del servidor de Strato/** - Base de datos del servidor de producción Strato
  - `newproject_strato.sql`

---

### **config/**
Configuración global de la aplicación.

#### Archivos principales:
- **check_session.php** - Verificación de sesiones activas
- **conexion.php** - Configuración de conexión a base de datos
- **config.php** - Configuración general de la aplicación
- **funciones.php** - Funciones auxiliares globales

#### Subcarpetas:

##### **modalAyudas/**
Sistema de ayuda contextual:
- `botonAyuda.php` - Botón de ayuda
- `filtroActivo.php` - Filtros activos
- `modalAyuda.php` - Modal de ayuda
- **ayuda/** - Contenido de las ayudas

##### **settings/**
Configuraciones por entorno/dominio:
- `_efeuno.json` - Configuración para EfeUno
- `_leader-transport.json` - Configuración Leader Transport
- `_local_192.168.31.35.json` - Configuración local IP
- `_localhost.json` - Configuración localhost
- `192.168.31.19.json` - Configuración servidor local
- `leader.innovabyte.es.json` - Configuración producción

##### **templates/**
Plantillas reutilizables de la interfaz:
- `comunDataTables.js` - Configuración común de DataTables
- `mainFooter.php` - Footer principal
- `mainHead.php` - Cabecera HTML
- `mainHeader.php` - Header de navegación
- `mainJs.php` - JavaScript principal
- `mainSidebar.php` - Barra lateral de navegación
- `mainThemeCustomization.php` - Personalización de temas
- `mainVersiones.php` - Información de versiones
- `searchModal.php` - Modal de búsqueda
- `sesion.php` - Gestión de sesión

---

### **controller/**
Controladores que manejan la lógica de negocio y peticiones.

#### Controladores principales:
- **accionesContacto.php** - Gestión de contactos
- **asistencia.php** - Control de asistencias
- **conductores.php** - Gestión de conductores
- **configMail.php** - Configuración de correos
- **empresa.php** - Gestión de empresas
- **googleLogin.php** - Autenticación con Google
- **guardarFicheros.php** - Subida de archivos
- **logout.php** - Cierre de sesión
- **mntPreinscripciones.php** - Mantenimiento de preinscripciones
- **otrosConceptos.php** - Otros conceptos (gastos, etc)
- **subirDocumentoJson.php** - Subida de documentos en JSON
- **subirImagen.php** - Subida de imágenes
- **tickets.php** - Gestión de tickets/incidencias
- **trabajadores.php** - Gestión de trabajadores
- **transportes.php** - Gestión de transportes
- **usuario.php** - Gestión de usuarios

#### Subcarpetas:
- **JSON/** - Archivos JSON con datos diversos (A1.json, A2.json, etc.)
  - Contiene respuestas de API, configuraciones y datos temporales

---

### **models/**
Modelos de datos que representan las entidades del sistema.

#### Modelos:
- **AccionesContacto.php** - Modelo de acciones de contacto
- **Asistencia.php** - Modelo de asistencias
- **Comercial.php** - Modelo de gestión comercial
- **Conductores.php** - Modelo de conductores
- **Config.php** - Modelo de configuración
- **Empresa.php** - Modelo de empresas
- **Estados.php** - Modelo de estados (órdenes, tickets, etc)
- **Log.php** - Modelo de registro de logs
- **OtrosConceptos.php** - Modelo de otros conceptos
- **Tickets.php** - Modelo de tickets/incidencias
- **Trabajadores.php** - Modelo de trabajadores
- **Transportes.php** - Modelo de transportes
- **Usuario.php** - Modelo de usuarios

---

### **public/**
Recursos públicos accesibles (CSS, JavaScript, imágenes, documentos).

#### Archivos principales:
- **composer.json** - Dependencias PHP (Composer)
- **espanol.json** - Traducciones al español

#### Subcarpetas:
- **assets/css/** - Hojas de estilo y recursos
- **css/** - CSS personalizado
- **documentos/** - Documentos subidos por usuarios
- **firmas/** - Firmas digitales
- **img/** - Imágenes de la aplicación
- **incidencias/** - Archivos relacionados con incidencias
- **js/** - JavaScript personalizado
- **log/** - Archivos de logs
- **mailTemplate/** - Plantillas de correo electrónico
- **publicSing/** - Firmas públicas
- **vendor/** - Librerías de terceros (Composer)

---

### **view/**
Vistas de la aplicación (interfaz de usuario).

#### Módulos de vistas:
- **CambiarPass/** - Cambio de contraseña
- **Email/** - Gestión de emails
- **Empresa/** - Vista de empresas
- **Home/** - Página de inicio/dashboard
- **Login/** - Página de inicio de sesión
- **Logs/** - Visualización de logs
- **MntConductor/** - Mantenimiento de conductores
- **MntUsuarios/** - Mantenimiento de usuarios
- **Ordenes/** - Gestión de órdenes de transporte
- **Perfil/** - Perfil de usuario
- **Personalizar/** - Personalización de la aplicación
- **RecuperarPass/** - Recuperación de contraseña
- **Registro/** - Registro de nuevos usuarios
- **SMTP/** - Configuración SMTP
- **SUPER/** - Panel de superadministrador
- **Transportes/** - Gestión de transportes

---

### **docs/**
Documentación del proyecto.

#### Documentos:
- **flujodescargaOrdenes.md** - Flujo de descarga de órdenes
- **general.md** - Este documento (estructura general)

---

## 🏗️ Arquitectura de la Aplicación

### Patrón MVC
La aplicación sigue el patrón Modelo-Vista-Controlador:

1. **Models (models/)** - Capa de datos y lógica de negocio
2. **Views (view/)** - Capa de presentación (HTML/PHP)
3. **Controllers (controller/)** - Capa de control (procesa peticiones)

### Flujo de Trabajo
```
Usuario → index.php → Controller → Model → Base de Datos
                          ↓
                        View → Usuario
```

### Componentes Clave
- **Configuración multi-entorno** (config/settings/)
- **Sistema de plantillas** (config/templates/)
- **Gestión de sesiones** (check_session.php)
- **Sistema de ayuda contextual** (modalAyudas/)
- **Logs y auditoría** (models/Log.php, public/log/)

---

## 🔐 Seguridad
- Verificación de sesiones en cada petición
- Control de roles y permisos
- Scripts de diagnóstico para debugging seguro
- Configuraciones por entorno separadas

---

## 📊 Funcionalidades Principales
1. **Gestión de Transportes** - Órdenes, rutas, seguimiento
2. **Gestión de Personal** - Conductores, trabajadores, asistencia
3. **Sistema de Tickets** - Incidencias y soporte
4. **Gestión Empresarial** - Empresas, contactos, comercial
5. **Sistema de Usuarios** - Autenticación, roles, permisos
6. **Configuración SMTP** - Envío de correos electrónicos
7. **Logs y Auditoría** - Registro de acciones

---

## 🛠️ Tecnologías Utilizadas
- **Backend:** PHP
- **Base de Datos:** MySQL/MariaDB
- **Frontend:** HTML, CSS, JavaScript
- **DataTables:** Tablas interactivas
- **Composer:** Gestión de dependencias
- **Google OAuth:** Autenticación con Google

---

## 📝 Notas
- Múltiples entornos soportados (local, producción, desarrollo)
- Sistema de configuración basado en JSON por dominio
- Estructura modular y escalable
- Respaldos de BD organizados por fechas
