# Documentación: subirOrdenes.php

## Ubicación
`view/Transportes/subirOrdenes.php`

## Descripción General
Interfaz de usuario para la gestión masiva de órdenes de transporte mediante sincronización bidireccional con un servidor FTP del cliente. Permite tanto la descarga de nuevas órdenes desde el servidor FTP del cliente como la subida de respuestas procesadas.

---

## Funcionalidad Principal

### 🎯 Propósito
Centralizar la gestión de órdenes de transporte que provienen de un sistema externo (cliente), automatizando el proceso de:
- **Descarga:** Traer nuevas órdenes desde el FTP del cliente
- **Procesamiento:** Validar e insertar órdenes en la base de datos local
- **Carga:** Enviar respuestas/actualizaciones de vuelta al cliente

---

## Componentes Visuales

### Interfaz de Usuario
- **Breadcrumb de navegación:** Inicio > Transportes > Subir-Descargar Ordenes
- **Card principal:** Título "Subida-Descarga de Ordenes"
- **Dos botones principales:**
  - 🔽 **Descargar del FTP** (botón naranja)
  - 🔼 **Subir al FTP** (botón verde)
- **Diagrama de flujo visual:** Muestra los 6 pasos del proceso de descarga
- **Zona informativa:** Explica brevemente el proceso de carga

---

## Operativa Detallada

### 🔻 1. PROCESO DE DESCARGA DE ÓRDENES

#### Trigger
Al hacer clic en el botón "Descargar del FTP", se ejecuta:
```javascript
window.open('../Ordenes/descargarficheros.php', '_blank')
```
Abre en nueva ventana para mostrar logs en tiempo real.

#### Archivo ejecutado: `descargarficheros.php`

##### PASO 1: Configuración inicial
- **Detección de dominio:** Obtiene el dominio desde `$_SERVER['HTTP_HOST']`
- **Carga de configuración:** Lee archivo JSON desde `config/settings/{dominio}.json`
- **Variables obtenidas:**
  - Credenciales de BD: `host`, `port`, `dbname`, `username`, `password`
  - Credenciales FTP: `ipFTP`, `userFTP`, `passFTP`, `portFTP`

##### PASO 2: Conexión a Base de Datos
- Establece conexión PDO con MySQL
- Configura modo de error a excepciones
- Tiempo de ejecución ilimitado (`set_time_limit(0)`)
- Memoria aumentada a 512MB

##### PASO 3: Conexión al Servidor FTP del Cliente
- **Servidor FTP:** Configurado en JSON settings
- **Puerto:** Generalmente 21
- **Modo:** Pasivo (PASV) para evitar problemas de firewall
- **Ubicación remota:** Carpeta raíz del FTP

##### PASO 4: Listado y Descarga de Archivos JSON
- Lista todos los archivos en el FTP remoto
- Filtra solo archivos `.json`
- **Procesamiento por lotes:** 50 archivos por lote (configurable)
- **Descarga con reintentos:** Hasta 4 intentos por archivo
- **Destino local:** `view/Ordenes/descargas/`

**Validaciones de descarga:**
- Tamaño mínimo: 2KB (2048 bytes)
- Si tamaño OK → Elimina archivo del FTP remoto
- Si tamaño insuficiente → Mantiene en FTP remoto

**Control de descarga:**
- Genera JSON de control: `view/Ordenes/descargas/control_descargas/control_descarga_{timestamp}.json`
- Registra por cada archivo:
  - `nombre`, `descargado` (bool), `eliminado_remoto` (bool), `razon`, `fecha_hora_descarga`

##### PASO 5: Procesamiento de Archivos JSON

Para cada archivo descargado:

**5.1. Validación del DNI/NIF del Conductor**
```php
validarIdentificador($CONDUCTOR_NIF)
```
- **Mínimo 4 caracteres** (o se rechaza la orden)
- Valida formato DNI español (8 números + letra)
- Valida formato NIF (X/Y/Z + 7 números + letra)
- Valida formato CIF (letra + 7 números + control)
- Si no valida → Archivo a `errores_procesados/{YYYYMMDD}/`

**5.2. Validación de Email**
```php
validarCorreo($CONDUCTOR_EMAIL)
```
- Si es null o vacío → Usa `sin-email@transporte.local`
- Valida formato con `FILTER_VALIDATE_EMAIL`

**5.3. Validación de Código Postal**
- Trunca a máximo 10 caracteres
- Registra si hubo truncamiento

**5.4. Gestión de Usuario-Conductor**
Tabla: `tm_usuario`
- **Si existe:** Actualiza datos (nombre, email, dirección, provincia, población, CP)
- **Si no existe:** Inserta nuevo registro con:
  - `rolUsu = 0` (conductor)
  - `estUsu = 1` (activo)
  - `senaUsu = md5(CONDUCTOR_NIF)` (contraseña hasheada)
  - `tokenUsu` (token único de 30 caracteres)
  - `idTransportista_transportistas-Transporte` (referencia cruzada)

**5.5. Gestión de Transportista**
Tabla: `transportistas-Transporte`
- Busca por `idTransportistaLeader` (NIF del conductor)
- **Si existe:** Actualiza todos los datos
- **Si no existe:** Inserta nuevo registro
- Campos clave:
  - `idUsuario_Transportista`, `nombreTransportista`, `emailTransportista`
  - `direccionTransportista`, `poblacionTransportista`, `provinciaTransportista`
  - `cpDireccionTransportista`, `nifTransportista`, `tractoraTransportista`

**5.6. Determinación del Tipo de Transporte**
```php
TTE_TERRESTRE = bool
TTE_MULTIMODAL = bool
```
- `C` (Contenedor): Ambos false
- `T` (Terrestre): TTE_TERRESTRE = true, MULTIMODAL = false
- `M` (Multimodal): TTE_TERRESTRE = false, MULTIMODAL = true
- `X` (No definido): Otros casos

**5.7. Extracción de Datos Específicos por Tipo**

| Tipo | Fecha | Lugar de Origen |
|------|-------|-----------------|
| `C` | `TTE_FECHA_ESTIMADA_RECOGIDA` | `LUGARES[0].LUGAR_NOMBRE` |
| `T` | `TTE_FECHA_CARGA` | `LUGARES_CARGA[0].LUGAR_NOMBRE` |
| `M` | `TTE_FECHA_CARGA` | `LUGAR_COMIENZO_NOMBRE` |

**5.8. Validaciones de Campos Críticos**
- **MATRICULA:** No puede estar vacía
- **PRECINTO:** No puede estar vacío
- **TTE_COD:** Identificador único de la orden (obligatorio)

**5.9. Gestión de Orden de Transporte**
Tabla: `orden-Transporte`
- Verifica si existe orden con el mismo `TTE_COD`
- **Si existe:** Actualiza datos de la orden
- **Si no existe:** Inserta nueva orden
- Genera `tokenOrden` único de 30 caracteres
- Almacena JSON completo de la orden: `$jsonOrdenTransporte`

##### PASO 6: Archivo de Resultados y Movimiento

**Archivo Procesado Correctamente:**
- Destino: `view/Ordenes/descargas_procesados/`
- Se mueve desde `descargas/`

**Archivo con Errores:**
- Destino: `view/Ordenes/errores_procesados/{YYYYMMDD}/`
- Organizado por fecha para facilitar revisión

**JSON de Control de Procesamiento:**
- Ubicación: `view/Ordenes/descargas_procesados/control_procesados/{YYYYMMDD}/RP_{timestamp}.json`
- Contenido:
  ```json
  {
    "nombre_archivo": "orden123.json",
    "procesado": true,
    "errores": [],
    "detalles": [
      "DNI validado correctamente: 12345678A",
      "Email correcto: conductor@email.com",
      "Insertado Transportista: 12345678A",
      "Insertada nueva orden: TTE123"
    ]
  }
  ```

**Estadísticas Finales:**
- `contadorRegistrosInsertados`: Total de registros creados
- `contadorArchivosConError`: Archivos rechazados
- `contadorArchivosProcesadosOk`: Archivos procesados exitosamente
- `contadorViajesInsertados`: Total de órdenes creadas/actualizadas

---

### 🔺 2. PROCESO DE SUBIDA AL FTP (CARGA)

#### Trigger
Al hacer clic en el botón "Subir al FTP", se ejecuta:
```javascript
fetch('../Ordenes/subirficheros.php')
```
Llamada AJAX al script de subida.

#### Archivo ejecutado: `subirficheros.php`

##### PASO 1: Configuración
- Carga configuración desde `config/settings/{dominio}.json`
- Obtiene credenciales FTP del cliente

##### PASO 2: Conexión FTP
- Conecta al servidor FTP del cliente
- Activa modo pasivo

##### PASO 3: Verificación de Carpeta Remota
- Nombre carpeta destino: `responsesEfeuno`
- Si no existe → La crea en el servidor FTP

##### PASO 4: Lectura de Archivos Locales
- **Directorio origen:** `view/Ordenes/envios/`
- Obtiene todos los archivos usando `glob($directorio_local . '*')`

##### PASO 5: Subida de Archivos
- Recorre cada archivo local
- Sube a FTP remoto: `responsesEfeuno/{nombreArchivo}`
- Modo: FTP_BINARY
- Registra resultado: 1 (éxito) o 0 (error)

##### PASO 6: Organización Post-Subida

**Archivos Subidos Exitosamente:**
- Destino: `view/Ordenes/envios_procesados/{YYYYMMDD}/`
- Se mueven desde `envios/`

**Archivo Log:**
- Ubicación: `view/Ordenes/envios_procesados/{YYYYMMDD}/log_{timestamp}.json`
- Formato:
  ```json
  [
    {
      "archivo": "respuesta_123.json",
      "estado": "Éxito",
      "fecha_hora": "2025-12-21 14:30:45"
    }
  ]
  ```

##### PASO 7: Respuesta al Cliente
Retorna JSON a la interfaz:
```json
{
  "status": "success",
  "message": "Archivos subidos correctamente"
}
```

---

## Estructura de Directorios

```
view/Ordenes/
├── descargas/                          # Archivos JSON descargados del FTP
├── descargas/control_descargas/        # JSONs de control de descarga
├── descargas_procesados/               # Archivos procesados exitosamente
│   └── control_procesados/
│       └── {YYYYMMDD}/                 # JSONs de registro por fecha
│           └── RP_{timestamp}.json
├── errores_procesados/                 # Archivos con errores de validación
│   └── {YYYYMMDD}/                     # Organizados por fecha
├── envios/                             # Archivos listos para subir al FTP
└── envios_procesados/                  # Archivos ya subidos al FTP
    └── {YYYYMMDD}/                     # Organizados por fecha
        └── log_{timestamp}.json        # Log de subida
```

---

## Dependencias

### Archivos JavaScript
- **subirArchivoOrdenes.js:** Maneja eventos de botones y llamadas AJAX

### Archivos PHP
- **descargarficheros.php:** Lógica completa de descarga y procesamiento
- **subirficheros.php:** Lógica de subida al FTP

### Configuración
- **config/settings/{dominio}.json:** Credenciales BD y FTP por entorno

### Tablas de Base de Datos
1. **tm_usuario:** Usuarios conductores
2. **transportistas-Transporte:** Datos de transportistas
3. **orden-Transporte:** Órdenes de transporte (datos completos de cada viaje)

---

## Funciones Auxiliares

### `validarCorreo($email)`
Valida formato de email o retorna `sin-email@transporte.local` por defecto.

### `validarIdentificador($identificador)`
Valida DNI, NIF o CIF español según reglas oficiales.

### `validarDNIOuNIF($numero, $letra)`
Calcula letra de control y verifica DNI/NIF.

### `validarCIF($numero, $control)`
Valida dígito/letra de control de CIF según tipo.

### `generarToken($longitud = 32)`
Genera token hexadecimal seguro usando `random_bytes()`.

---

## Configuración del Sistema

### Límites de Ejecución
```php
set_time_limit(0);           // Sin límite de tiempo
ini_set('memory_limit', '512M');  // 512MB de memoria
```

### Zona Horaria
```php
date_default_timezone_set('Europe/Madrid');
```

### Procesamiento por Lotes
```php
$numeroArchivosPorLote = 50;  // 50 archivos por lote
```

---

## Seguridad

### Control de Acceso
```php
checkAccess(['0', '1']);  // Solo ADMIN (1) y PROFESOR (0)
```

### Validación de Sesión
```php
if (!isset($_SESSION['usu_id']) || empty($_SESSION['usu_id'])) {
    // Redirige a login
}
```

### Contraseñas
- Se almacenan con `md5()` del DNI (⚠️ Considerar migrar a `password_hash()`)

---

## Logs y Auditoría

### Logs en Tiempo Real
El proceso de descarga muestra logs HTML en tiempo real con:
- ✅ Entradas de éxito (verde)
- ℹ️ Entradas informativas (azul)
- ⚠️ Advertencias (amarillo)
- ❌ Errores (rojo)

### Archivos de Control
- **Control de descarga:** Registro de archivos descargados del FTP
- **Registro de proceso:** Detalle de cada archivo procesado (errores, validaciones, inserciones)
- **Log de subida:** Archivos subidos al FTP con timestamp

---

## Flujo Completo de Trabajo

```
┌─────────────────────────────────────────────────────────────┐
│  CLIENTE (Sistema Externo)                                  │
│  └── Genera archivos JSON con órdenes                       │
│      └── Los deposita en su servidor FTP                    │
└─────────────────────────────────────────────────────────────┘
                           │
                           ↓ FTP Download
┌─────────────────────────────────────────────────────────────┐
│  LEADER LOGÍSTICA                                           │
│  1. Descarga archivos JSON del FTP del cliente              │
│  2. Valida datos (DNI, email, CP)                           │
│  3. Crea/actualiza usuarios y transportistas                │
│  4. Crea/actualiza órdenes de transporte                    │
│  5. Archiva archivos procesados                             │
│  6. Genera logs de control                                  │
└─────────────────────────────────────────────────────────────┘
                           │
                           ↓ Procesamiento interno
┌─────────────────────────────────────────────────────────────┐
│  LEADER LOGÍSTICA (Gestión interna)                         │
│  └── Gestión de órdenes, seguimiento, actualizaciones       │
│      └── Genera archivos JSON de respuesta                  │
└─────────────────────────────────────────────────────────────┘
                           │
                           ↓ FTP Upload
┌─────────────────────────────────────────────────────────────┐
│  CLIENTE (Sistema Externo)                                  │
│  └── Recibe respuestas en carpeta "responsesEfeuno"         │
│      └── Procesa actualizaciones de estado                  │
└─────────────────────────────────────────────────────────────┘
```

---

## Formato JSON de Entrada (Orden)

Estructura esperada de los archivos JSON del cliente:

```json
{
  "TTE_COD": "ORD123456",
  "TTE_ORDEN": "2024-001",
  "TRANSPORTISTA_COD": "TR001",
  "TRANSPORTISTA_NOMBRE": "Transportes ABC S.L.",
  "TRANSPORTISTA_DIRECCION": "Calle Ejemplo, 123",
  "TRANSPORTISTA_CP": "28001",
  "TRANSPORTISTA_POBLACION": "Madrid",
  "TRANSPORTISTA_PROVINCIA": "Madrid",
  "CONDUCTOR_NIF": "12345678A",
  "CONDUCTOR_NOMBRE": "Juan Pérez",
  "CONDUCTOR_EMAIL": "juan@example.com",
  "TRACTORA": "1234-ABC",
  "MATRICULA": "5678-DEF",
  "PRECINTO": "PREC-001",
  "TTE_TERRESTRE": false,
  "TTE_MULTIMODAL": false,
  "TTE_FECHA_ESTIMADA_RECOGIDA": "2025-12-25 10:00:00",
  "LUGARES": [
    {
      "LUGAR_NOMBRE": "Puerto de Valencia"
    }
  ],
  "LUGARES_CARGA": [
    {
      "LUGAR_NOMBRE": "Almacén Central"
    }
  ],
  "LUGAR_COMIENZO_NOMBRE": "Punto de Partida"
}
```

---

## Mejoras Sugeridas

### Seguridad
- ⚠️ **Migrar de MD5 a password_hash()** para contraseñas
- Implementar validación CSRF en formularios AJAX
- Sanitizar inputs antes de inserción en BD

### Performance
- Considerar procesamiento asíncrono para lotes grandes
- Implementar sistema de colas (Redis, RabbitMQ)
- Cachear conexiones FTP en memoria

### Usabilidad
- Notificaciones push cuando se complete el proceso
- Dashboard con estadísticas de sincronización
- Sistema de retry automático para archivos fallidos

### Monitorización
- Alertas automáticas por correo si hay errores críticos
- Métricas de rendimiento (tiempos de proceso)
- Histórico de sincronizaciones

---

## Notas Importantes

- ⏱️ El proceso de descarga puede tardar varios minutos dependiendo del volumen de archivos
- 🔄 Los archivos se procesan en lotes de 50 para evitar timeouts
- 📁 Los archivos erróneos se organizan por fecha para facilitar revisión
- 🔐 Los tokens generados son únicos y seguros usando `random_bytes()`
- ⚙️ La configuración FTP es multi-entorno (local, desarrollo, producción)

---

## Documentación Relacionada

- [flujodescargaOrdenes.md](flujodescargaOrdenes.md) - Diagrama detallado del flujo de descarga
- [general.md](general.md) - Estructura general de la aplicación
