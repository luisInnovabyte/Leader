# Documentación: Sistema de Órdenes de Transporte

**Archivo principal:** `view/Transportes/ordenTransporte.php`  
**Última actualización:** 26 de enero de 2026  
**Versión:** 1.0  
**Autor:** Sistema Logística Leader Transport

---

## 📋 Índice

1. [Visión General](#-visión-general)
2. [Arquitectura del Sistema](#-arquitectura-del-sistema)
3. [Tipos de Transporte](#-tipos-de-transporte)
4. [Flujo de Datos](#-flujo-de-datos)
5. [Interfaz de Usuario](#-interfaz-de-usuario)
6. [Modales del Sistema](#-modales-del-sistema)
7. [JavaScript y Funcionalidad Dinámica](#-javascript-y-funcionalidad-dinámica)
8. [Impresión de Documentos](#-impresión-de-documentos)
9. [Base de Datos](#-base-de-datos)
10. [Campos JSON por Tipo](#-campos-json-por-tipo)
11. [Estilos y CSS](#-estilos-y-css)
12. [Funcionalidades Especiales](#-funcionalidades-especiales)
13. [Archivos Relacionados](#-archivos-relacionados)
14. [Problemas Detectados y Mejoras](#-problemas-detectados-y-mejoras)

---

## 📖 Visión General

El sistema de órdenes de transporte gestiona tres tipos diferentes de operaciones logísticas:

- **Tipo C - Contenedor (Marítimo)**: Transporte de contenedores con datos marítimos completos
- **Tipo T - Terrestre**: Transporte terrestre con gestión de viajes múltiples
- **Tipo M - Multimodal**: Combinación de transporte con ubicaciones de plataforma

### Características Principales

- ✅ Visualización detallada de órdenes según tipo de transporte
- ✅ Edición en línea de contenedores (Tipo C)
- ✅ Gestión de viajes con tarjetas coloreadas (Tipos T y M)
- ✅ Generación de múltiples tipos de documentos para impresión
- ✅ Firma digital de documentos
- ✅ Generación de códigos QR para consulta
- ✅ Subida de documentos asociados (integración Gesdoc)
- ✅ Gestión de incidencias
- ✅ Registro de llegadas y salidas

---

## 🏗️ Arquitectura del Sistema

### Componentes del Sistema

```
┌─────────────────────────────────────────────┐
│        ordenTransporte.php (Vista)          │
│  - Interfaz principal                       │
│  - Renderizado condicional según tipo       │
└──────────────────┬──────────────────────────┘
                   │
                   ├─► models/Transportes.php
                   │   - recogerOrdenToken()
                   │   - recogerViajesxOrden()
                   │
                   ├─► view/Transportes/index.js
                   │   - Lógica cliente
                   │   - Impresión
                   │   - Firma digital
                   │
                   ├─► controller/transportes.php
                   │   - Procesamiento backend
                   │
                   └─► view/Transportes/orden.php
                       - Generación PDFs
```

### Archivos Principales

| Archivo | Propósito |
|---------|-----------|
| `view/Transportes/ordenTransporte.php` | Vista principal, renderiza según tipo |
| `view/Transportes/index.js` | JavaScript de funcionalidad |
| `models/Transportes.php` | Modelo de datos |
| `controller/transportes.php` | Controlador backend |
| `view/Transportes/orden.php` | Generación de documentos imprimibles |

---

## 🚢 Tipos de Transporte

### Tipo C - CONTENEDOR (Marítimo)

**Código identificador:** `'C'`  
**Líneas:** 767-1223

**Descripción:** Transporte marítimo de contenedores con información detallada de naviera, puertos y clasificación IMO.

#### Bloques de Información (10 total)

##### **BLOQUE 1: Fechas y Referencias** (Líneas 779-817)

**Campos:**
- `TTE_FECHA_CARGA`: Fecha de carga
- `TTE_HORA_CARGA`: Hora de carga
- `CARGADOR_REF_CARGA`: Referencia del consignatario
- `TTE_FECHA_ESTIMADA_RECOGIDA`: Fecha estimada de recogida
- `TTE_FECHA_ESTIMADA_ENTREGA`: Fecha estimada de entrega
- `TTE_ORDEN`: Orden de transporte de la agencia

##### **BLOQUE 2: Agente y Contenedor** (Líneas 819-908)

**Campos especiales:**
- `CONSIGNATARIO`: Nombre del agente/consignatario
- `contenedorActivo`: Número de contenedor (editable)
- `TIPO_CONT_DESC`: Descripción tipo contenedor
- `TIPO_CONT`: Código tipo contenedor
- `PRECINTO`: Número de precinto/HLOD

**Funcionalidad especial:**
- Contenedor editable con iconos (lápiz/guardar/cancelar)
- Variable `$mostrarContPrecinto` controla editabilidad
- Formato especial para contenedores: inserta '/' antes último carácter

##### **BLOQUE 2.1: Transportista y Conductor** (Líneas 909-935)

**Campos:**
- `TRANSPORTISTA_NOMBRE`, `TRANSPORTISTA_NIF`
- `TRANSPORTISTA_DIRECCION`, `TRANSPORTISTA_CP`
- `TRANSPORTISTA_POBLACION`, `TRANSPORTISTA_PROVINCIA`
- `CONDUCTOR_NOMBRE`, `CONDUCTOR_NIF`
- `TRACTORA`: Matrícula cabeza tractora
- `PLATAFORMA`: Tipo de plataforma

##### **BLOQUE 3: Ubicaciones** (Líneas 937-955)

**Secciones:**

1. **RETIRAR DE** (clase: `light-red`)
   - `RECOGER_EN_NOMBRE`
   - `RECOGER_EN_DIRECCION`
   - `RECOGER_EN_CP`, `RECOGER_EN_POBLACION`, `RECOGER_EN_PROVINCIA`

2. **ENTREGAR EN** (clase: `light-green`)
   - `DEVOLVER_EN_NOMBRE`
   - `DEVOLVER_EN_DIRECCION`
   - `DEVOLVER_EN_CP`, `DEVOLVER_EN_POBLACION`, `DEVOLVER_EN_PROVINCIA`

##### **BLOQUE 4: Mercancía** (Líneas 958-1001)

**Campos:**
- `MERCANCIA`: Descripción de la mercancía
- `BULTOS`: Número de bultos
- `PESO_MERCANCIA`: Peso total

**Temperaturas:**
- `TEMP_MAXIMA`: Temperatura máxima
- `TEMP_MINIMA`: Temperatura mínima
- `TEMP_CONECTAR`: Indicador de conexión refrigeración

##### **BLOQUE 5: Dimensiones y Clasificación IMO** (Líneas 1007-1064)

**Tabla 1 - Extensiones:**
- `EXTRA_RIGHT`: Extensión derecha
- `EXTRA_LEFT`: Extensión izquierda
- `EXTRA_FRONT`: Extensión frontal
- `EXTRA_BACK`: Extensión trasera
- `EXTRA_ALTO`: Extensión altura

**Tabla 2 - Clasificación IMO (Mercancías Peligrosas):**
- `IMO_ONU`: Número ONU
- `IMO_VERSION`: Versión IMDG
- `IMO_PAGINA`: Página IMDG
- `IMO_CLASE`: Clase IMO
- `IMO_PORT_NOTIFICATION`: Notificación APV

##### **BLOQUE 6: Datos Marítimos** (Líneas 1067-1099)

**Campos naviera:**
- `NOMBRELINEA_DEST`: Nombre línea naviera
- `ESCALA_DEST`: Número de escala
- `BUQUE_DEST`: Nombre del buque
- `VIAJE`: Número de viaje
- `DISTINTIVO_LLAMADA`: Distintivo de llamada del buque

##### **BLOQUE 7: Puertos** (Líneas 1103-1132)

**Campos:**
- `PUERTO_ORIGEN_NOMBRE`: Puerto de origen
- `PUERTO_DESTINO_NOMBRE`: Puerto de destino
- `PUERTO_DESCARGA_NOMBRE`: Puerto de descarga/carga
- `PUERTO_TIPO_ORDEN_IMPORTACION`: Tipo de orden (Import/Export)

##### **BLOQUE 8: Cargador** (Líneas 1135-1160)

**Campos:**
- `CARGADOR_REF_CARGA`: Referencia de carga
- `PIF_NOMBRE`: PIF/Aduana
- `CARGADOR_NOMBRE`: Nombre del cargador
- `CARGADOR_CIF`: CIF del cargador
- `CARGADOR_DIRECCION`: Dirección completa
- `CARGADOR_POBLACION`, `CARGADOR_PROVINCIA`

##### **BLOQUE 9: Tabla de Lugares** (Líneas 1163-1205)

**Array iterativo:** `$jsonDatos['LUGARES']`

**Columnas de la tabla:**
- `LUGAR_NOMBRE`: Nombre del lugar
- `LUGAR_DIRECCION`: Dirección
- `LUGAR_CP`: Código postal
- `LUGAR_POBLACION`: Población
- `LUGAR_PROVINCIA`: Provincia
- `LUGAR_TELEFONO`: Teléfono de contacto

**Nota:** Múltiples lugares de carga/descarga

##### **BLOQUE 10: Observaciones** (Líneas 1208-1222)

**Campos:**
- `PCS_BOOKING_NUMBER`: Número de booking
- `OBSERVACIONES`: Observaciones generales de la orden

---

### Tipo T - TERRESTRE

**Código identificador:** `'T'`  
**Líneas:** 1235-1356

**Descripción:** Transporte terrestre con gestión simplificada y múltiples viajes.

#### Estructura del Formulario

##### **Sección 1: Datos del Transportista**

**Campos:**
- `TRANSPORTISTA_NOMBRE`: Nombre de la empresa transportista
- `TRANSPORTISTA_NIF`: NIF/CIF
- `TRANSPORTISTA_DIRECCION`: Dirección completa
- `TRANSPORTISTA_POBLACION`: Población

##### **Sección 2: Conductor**

**Campos:**
- `CONDUCTOR_NOMBRE`: Nombre del conductor
- `CONDUCTOR_NIF`: DNI del conductor

##### **Sección 3: Vehículo**

**Campos:**
- `TRACTORA`: Matrícula del vehículo
- `PLATAFORMA_TIPO`: Tipo de plataforma
- `TTE_ORDEN`: Tipo de plataforma (campo adicional)

##### **Sección 4: Viajes (Iterativo)**

**Sistema de tarjetas coloreadas:**

```php
foreach ($datosViajes as $viaje) {
    if ($viaje['tipoViaje'] == 'CARGA') {
        $colorBorde = 'border-info';      // Azul
    } else if ($viaje['tipoViaje'] == 'DESCARGA') {
        $colorBorde = 'border-danger';    // Rojo
    }
}
```

**Campos por viaje:**
- `LUGAR_NOMBRE`: Empresa destino
- `LUGAR_POBLACION`: Población
- `LUGAR_DIRECCION`: Dirección
- `LUGAR_CP`: Código postal / País
- `LUGAR_TELEFONO`: Teléfono de contacto

**Clases CSS de tarjetas:**
- `.infoCard.border-info` - Viaje de CARGA (Azul)
- `.infoCard.border-danger` - Viaje de DESCARGA (Rojo)

---

### Tipo M - MULTIMODAL

**Código identificador:** `'M'`  
**Líneas:** 1358-1520

**Descripción:** Transporte combinado con características híbridas entre marítimo y terrestre.

#### Base Compartida con Tipo T

- Transportista (igual que Tipo T)
- Conductor (igual que Tipo T)
- Vehículo (igual que Tipo T)

#### Campos Exclusivos del Tipo M

##### **1. Nº Pedido Cliente** (Línea 1403)

```php
Campo: TRACTORA (reutilizado)
Label: "Nº PEDIDO CLIENTE"
```

##### **2. Tipo Plataforma** (Línea 1407)

```php
Campo: No definido en JSON actual
Label: "TIPO PLATAFORMA"
⚠️ Nota: Campo vacío en implementación actual
```

##### **3. Datos del Cliente** (Líneas 1411-1419)

```php
Campos:
- CLIENTE_NOMBRE: Nombre del cliente (vacío en JSON)
- CLIENTE_NIF: NIF del cliente (vacío en JSON)
⚠️ Nota: Campos no definidos actualmente
```

##### **4. Ubicaciones de Plataforma** (Líneas 1422-1430)

**Secciones con colores especiales:**

```php
// Verde - Recogida
LUGAR_COMIENZO_NOMBRE: "LA PLATAFORMA SE RECOGE EN"
Clase: tx-success (verde)

// Rojo - Entrega
LUGAR_FIN_NOMBRE: "LA PLATAFORMA SE DEJA EN"
Clase: tx-danger (rojo)
```

##### **5. Precio Acordado** (Líneas 1433-1436)

```php
Campo: LUGARES_DESCARGA[0]['LUGAR_IMPORTE']
Formato: Mostrado con '€'
Validación: Verifica isset() y !empty()
```

##### **Viajes Extendidos**

**Campos base (igual que Tipo T):**
- `LUGAR_NOMBRE`
- `LUGAR_POBLACION`
- `LUGAR_DIRECCION`
- `LUGAR_CP`
- `LUGAR_TELEFONO`

**Campos adicionales (Líneas 1498-1512):**
- `MERCANCIA`: Descripción mercancía
- `TTE_FECHA_CARGA`: Fecha
- ⚠️ `MERCANCIA`: Hora (posible error en código - reutiliza campo)
- `CARGADOR_REF_CARGA`: Referencia de carga

**⚠️ PROBLEMA DETECTADO (Línea 1502):**
```php
// El campo "HORA" muestra $jsonDatos['MERCANCIA']
// Esto parece ser un error de copy-paste
<label id="horajson"><?php echo $jsonDatos['MERCANCIA']; ?></label>
```

---

## 🔄 Flujo de Datos

### 1. Inicialización (Líneas 16-44)

```php
// Control de acceso
checkAccess(['0', '1']); // Solo ADMIN (1) y PROFESOR (0)

// Obtener datos de la orden
$tokenOrden = $_GET['orden'];
$transporte = new Transporte();
$datosOrden = $transporte->recogerOrdenToken($tokenOrden);

// Variables principales
$tipoOrdenTransporte = $datosOrden['tipoOrdenTransporte']; // 'C', 'T', o 'M'
$idOrden = $datosOrden['num_transporte'];
$contenedorActivo = $datosOrden['contenedorActivo'];
$hlodActivo = $datosOrden['precintoActivo'];

// Decodificar JSON de la orden
$jsonDatos = json_decode($datosOrden['jsonOrdenTransporte'], true);

// ID de la orden en la tabla
$idOrdenTabla = $datosOrden['idOrden'];

// Obtener viajes asociados
$datosViajes = $transporte->recogerViajesxOrden($idOrdenTabla);
```

### 2. Renderizado Condicional (Línea 767)

```php
<?php if ($tipoOrdenTransporte == 'C') { ?>
    <!-- Renderizar Tipo Contenedor -->
    
<?php } else if ($tipoOrdenTransporte == 'T') { ?>
    <!-- Renderizar Tipo Terrestre -->
    
<?php } else if ($tipoOrdenTransporte == 'M') { ?>
    <!-- Renderizar Tipo Multimodal -->
    
<?php } else { ?>
    <h2 class="tx-danger parpadeo">
        Problema al localizar tipo de orden. Contacte con soporte.
    </h2>
<?php } ?>
```

### 3. Flujo de Usuario

```
Usuario accede: ?orden=TOKEN
        ↓
Verifica permisos (checkAccess)
        ↓
Carga datos orden desde BD
        ↓
Decodifica JSON de la orden
        ↓
Carga viajes asociados
        ↓
Renderiza interfaz según tipo (C, T, M)
        ↓
Usuario interactúa:
- Selecciona viaje
- Registra llegada/salida
- Firma documento
- Imprime documento
- Genera QR
- Sube archivos
```

---

## 🖥️ Interfaz de Usuario

### Estructura HTML Principal

```html
<main class="page-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb">
        Inicio > Transportes > Ordenes de Transporte
    </div>
    
    <!-- Card principal -->
    <div class="card">
        <!-- Título con número de orden -->
        <h2>Ordenes de Transporte</h2>
        <h4>Nº: <?php echo $idOrden ?></h4>
        
        <!-- Campos ocultos para JS -->
        <input type="hidden" id="tokenId" value="<?php echo $tokenOrden; ?>">
        <input type="hidden" id="tipoOrdenTransporte" value="<?php echo $tipoOrdenTransporte; ?>">
        
        <!-- Contenido según tipo (C, T, M) -->
        
        <!-- Sección común: Selección de viaje -->
        <select id="selectViajes">
            <?php foreach ($datosViajes as $viaje) { ?>
                <option value="<?php echo $viaje['idViaje']; ?>">
                    <?php echo $viaje['LUGAR_NOMBRE']; ?>
                </option>
            <?php } ?>
        </select>
        
        <!-- Formulario de llegada/salida -->
        <div id="insertarDatosViaje" class="d-none">
            <input type="datetime-local" id="fechaLlegada">
            <input type="datetime-local" id="fechaSalida">
            <textarea id="ObservacionViaje"></textarea>
        </div>
        
        <!-- Botones de acción -->
        <button data-bs-target="#firma_modal">Firmar Documento</button>
        <button id="generateQR">Mostrar QR</button>
    </div>
</main>
```

### Botones Flotantes (Sidebar Derecho)

**Líneas 1696-1734**

| Botón | Posición | Color | Icono | Función |
|-------|----------|-------|-------|---------|
| 1 | `top: 61px` | `#c1c0a3` | ⚠️ | Incidencias |
| 2 | `top: 121px` | `#b2a3c1` | 🖨️ | Imprimir |
| 3 | `top: 181px` | `#a3c1be` | ☁️ | Subir Documentos |
| 4 | `top: 181px` | `#c1a7a7` | ➡️ | Salir |
| 5 | `top: 472px` | `#aed581` | ❓ | Ayuda |

---

## 📄 Modales del Sistema

### 1. Modal de Tipo de Documento (Impresión)

#### Para Tipo C: `modalTipoDocumentoExport.php`

**3 opciones de impresión:**

| Botón | Código | Color | Descripción |
|-------|--------|-------|-------------|
| CLIENTE | `E` | Rojo | Documento para el cliente final |
| OFICINA | `O` | Azul | Documento uso interno oficina |
| RECEPTOR | `X` | Verde | Documento para receptor (requiere viaje) |

#### Para Tipos T/M: `modalTipoDocumentoExportTM.php`

**6 opciones de impresión:**

| Botón | Código | Color | Descripción |
|-------|--------|-------|-------------|
| ADMÍTASE | `A` | Rojo | Autorización de admisión |
| ENTRÉGUESE | `E` | Amarillo | Orden de entrega |
| OFICINA | `O` | Azul | Documento uso interno |
| TRANSPORTISTA | `T` | Gris | Documento para transportista |
| RECEPTOR | `X` | Verde | Documento para receptor |
| CMR | `CMR` | Morado | Carta de porte internacional |

### 2. Modal de Firma Digital

**Archivo:** `modalFirma.php`

**Librerías utilizadas:**
- `jquery.signaturepad.js`
- `numeric-1.2.6.min.js`
- `bezier.js`

**Funcionalidad:**
- Canvas para firma táctil/ratón
- Botón limpiar firma
- Botón guardar firma (base64)

### 3. Modal de Código QR

**Archivo:** `modalQr.php`

**Librería:** `qr-code-styling@1.6.0-rc.1`

**Funcionalidad:**
- Genera QR con código `OA_PCS_LOCATOR`
- Tamaño: 200x200px
- Estilos personalizables

### 4. Otros Modales

| Modal | Archivo | Función |
|-------|---------|---------|
| Subida Documentos | `modalOrdenGesdoc.php` | Integración Gesdoc |
| Contenedor | `modalContenedor.php` | Edición contenedor |
| Ayuda | `modalAyuda.php` | Sistema de ayuda |
| Incidencias | `modalIncidencia.php` | Gestión incidencias |

### Carga Condicional (Líneas 1674-1679)

```php
<?php
if ($tipoOrdenTransporte == "T" || $tipoOrdenTransporte == "M") {
    include_once 'modalTipoDocumentoExportTM.php';
} else {
    include_once 'modalTipoDocumentoExport.php';
}
?>
```

---

## ⚡ JavaScript y Funcionalidad Dinámica

**Archivo principal:** `view/Transportes/index.js`

### Funciones Principales

#### 1. Impresión de Documentos (Línea 117)

```javascript
$("body").on("click", ".printDocumento", function () {
    var tipoDocumento = $(this).data("tipodocumento");
    var tokenId = $("#tokenId").val();
    var contenedorActivo = $("#contenedor").val();
    var tipoOrden = $("#tipoOrdenTransporte").val();
    
    if (tipoDocumento == "X") {
        // Requiere selección de viaje
        $("#botonesDocumentos").addClass("d-none");
        $("#seleccionarViaje").removeClass("d-none");
    } else {
        // Abre ventana de impresión
        window.open(
            "orden.php?idOrden=" + tokenId +
            "&tipoDocumento=" + tipoDocumento +
            "&contenedorActivo=" + contenedorActivo +
            "&tipoOrdenTransporte=" + tipoOrden,
            "_blank",
            "width=1920,height=1080"
        );
    }
});
```

#### 2. Selección de Viaje (Línea 268)

```javascript
$("#selectViajes").change(function () {
    var viajeSeleccionado = $(this).val();
    
    if (viajeSeleccionado !== "") {
        $("#insertarDatosViaje").removeClass("d-none");
    } else {
        $("#insertarDatosViaje").addClass("d-none");
    }
});
```

#### 3. Ocultar Tab Cliente en Tipo C (Línea 289)

```javascript
if ($("#tipoOrdenTransporte").val() == "C") {
    $(".tabCliente").addClass("d-none");
}
```

#### 4. Edición de Contenedor

**Activar modo edición:**
```javascript
$("#cambiarModoContenedor").click(function() {
    $("#contenedor").removeAttr("readonly");
    $(".edicionModeOff").addClass("d-none");
    $(".edicionModeOn").removeClass("d-none");
});
```

**Guardar cambios:**
```javascript
$("#guardarModoContenedor").click(function() {
    // AJAX para guardar
});
```

**Cancelar edición:**
```javascript
$("#cancelarModoContenedor").click(function() {
    var contenedorOriginal = $("#idContenedorSave").val();
    $("#contenedor").val(contenedorOriginal);
});
```

#### 5. Generación de QR (Línea 1130)

```javascript
$("#generateQR").click(function() {
    var codigo = $("#primerCodigo").val();
    
    const qrCode = new QRCodeStyling({
        width: 200,
        height: 200,
        data: codigo,
        dotsOptions: {
            color: "#000000",
            type: "rounded"
        }
    });
    
    qrCode.append(document.getElementById("qrcode"));
});
```

---

## 🖨️ Impresión de Documentos

### Archivo de Generación: `orden.php`

**Parámetros GET:**
```
?idOrden=TOKEN
&tipoDocumento=E|O|X|A|T|CMR
&contenedorActivo=CONTENEDOR
&tipoOrdenTransporte=C|T|M
&idViaje=ID_VIAJE (opcional, requerido para tipo X)
```

### Tipos de Documento

#### Para Tipo C (Contenedor)

| Código | Nombre | Descripción |
|--------|--------|-------------|
| `E` | CLIENTE | Documento para el cliente final |
| `O` | OFICINA | Documento uso interno oficina |
| `X` | RECEPTOR | Documento para receptor de carga |

#### Para Tipos T y M (Terrestre/Multimodal)

| Código | Nombre | Descripción |
|--------|--------|-------------|
| `A` | ADMÍTASE | Autorización de admisión |
| `E` | ENTRÉGUESE | Orden de entrega |
| `O` | OFICINA | Documento uso interno |
| `T` | TRANSPORTISTA | Documento para transportista |
| `X` | RECEPTOR | Documento para receptor |
| `CMR` | CMR | Carta de porte internacional |

### Documentación Adicional

- `docs/impresion.md` - Guía general de impresión
- `docs/MAPEO_CAMPOS_JSON_A_IMPRESION.md` - Detalle de campos

---

## 💾 Base de Datos

### Tabla Principal: `transportes`

```sql
CREATE TABLE `transportes` (
  `idOrden` INT AUTO_INCREMENT PRIMARY KEY,
  `num_transporte` VARCHAR(50),
  `tipoOrdenTransporte` TINYTEXT COMMENT 'C = CONTENEDOR / T = TERRESTRE / M = MULTIMODAL',
  `jsonOrdenTransporte` LONGTEXT,
  `contenedorActivo` VARCHAR(50),
  `precintoActivo` VARCHAR(50),
  `estado` TINYINT,
  `fechaCreacion` DATETIME,
  `fechaModificacion` DATETIME
);
```

### Tabla de Viajes: `viajes`

```sql
CREATE TABLE `viajes` (
  `idViaje` INT AUTO_INCREMENT PRIMARY KEY,
  `idOrden` INT,
  `tipoViaje` ENUM('CARGA', 'DESCARGA'),
  `LUGAR_NOMBRE` VARCHAR(255),
  `LUGAR_DIRECCION` VARCHAR(255),
  `LUGAR_CP` VARCHAR(10),
  `LUGAR_POBLACION` VARCHAR(100),
  `LUGAR_PROVINCIA` VARCHAR(100),
  `LUGAR_TELEFONO` VARCHAR(20),
  `fechaLlegada` DATETIME,
  `fechaSalida` DATETIME,
  `observaciones` TEXT,
  `firmaBase64` LONGTEXT,
  FOREIGN KEY (`idOrden`) REFERENCES `transportes`(`idOrden`)
);
```

### Métodos del Modelo

**Archivo:** `models/Transportes.php`

```php
class Transporte {
    // Obtener orden por token
    public function recogerOrdenToken($token);
    
    // Obtener viajes de una orden
    public function recogerViajesxOrden($idOrden);
    
    // Actualizar contenedor
    public function actualizarContenedor($idOrden, $contenedor);
    
    // Guardar firma digital
    public function guardarFirma($idViaje, $firmaBase64);
    
    // Registrar llegada/salida
    public function registrarLlegadaSalida($idViaje, $fechaLlegada, $fechaSalida, $observaciones);
}
```

---

## 📊 Campos JSON por Tipo

### Campos Comunes

Estos campos están presentes en todos los tipos:

```json
{
  "OA_PCS_LOCATOR": "Código QR de la orden"
}
```

### Campos Específicos Tipo C (Contenedor)

```json
{
  "TTE_FECHA_CARGA": "2026-01-26",
  "TTE_HORA_CARGA": "10:00",
  "CARGADOR_REF_CARGA": "REF123",
  "TTE_FECHA_ESTIMADA_RECOGIDA": "2026-01-27",
  "TTE_FECHA_ESTIMADA_ENTREGA": "2026-01-30",
  "TTE_ORDEN": "OT-001",
  
  "CONSIGNATARIO": "Consignatario SA",
  "TIPO_CONT_DESC": "20' DRY",
  "TIPO_CONT": "2D",
  "PRECINTO": "SEAL123456",
  
  "TRANSPORTISTA_NOMBRE": "Transportes SL",
  "TRANSPORTISTA_NIF": "B12345678",
  "TRANSPORTISTA_DIRECCION": "Calle Principal 1",
  "TRANSPORTISTA_CP": "28001",
  "TRANSPORTISTA_POBLACION": "Madrid",
  "TRANSPORTISTA_PROVINCIA": "Madrid",
  
  "CONDUCTOR_NOMBRE": "Juan Pérez",
  "CONDUCTOR_NIF": "12345678A",
  "TRACTORA": "1234-ABC",
  "PLATAFORMA": "PLAT-001",
  
  "RECOGER_EN_NOMBRE": "Almacén Central",
  "RECOGER_EN_DIRECCION": "Polígono Industrial 10",
  "RECOGER_EN_CP": "28002",
  "RECOGER_EN_POBLACION": "Madrid",
  "RECOGER_EN_PROVINCIA": "Madrid",
  
  "DEVOLVER_EN_NOMBRE": "Terminal Portuaria",
  "DEVOLVER_EN_DIRECCION": "Muelle 5",
  "DEVOLVER_EN_CP": "46024",
  "DEVOLVER_EN_POBLACION": "Valencia",
  "DEVOLVER_EN_PROVINCIA": "Valencia",
  
  "MERCANCIA": "Pallets de mercancía general",
  "BULTOS": "20",
  "PESO_MERCANCIA": "15000 kg",
  "TEMP_MAXIMA": "25°C",
  "TEMP_MINIMA": "15°C",
  "TEMP_CONECTAR": "SÍ",
  
  "EXTRA_RIGHT": "0 cm",
  "EXTRA_LEFT": "0 cm",
  "EXTRA_FRONT": "10 cm",
  "EXTRA_BACK": "0 cm",
  "EXTRA_ALTO": "0 cm",
  
  "IMO_ONU": "1234",
  "IMO_VERSION": "39-18",
  "IMO_PAGINA": "250",
  "IMO_CLASE": "3",
  "IMO_PORT_NOTIFICATION": "Sí",
  
  "NOMBRELINEA_DEST": "Maersk Line",
  "ESCALA_DEST": "ESC-2026-001",
  "BUQUE_DEST": "MV CONTAINER",
  "VIAJE": "V123",
  "DISTINTIVO_LLAMADA": "CALL123",
  
  "PUERTO_ORIGEN_NOMBRE": "Valencia",
  "PUERTO_DESTINO_NOMBRE": "Shanghai",
  "PUERTO_DESCARGA_NOMBRE": "Valencia",
  "PUERTO_TIPO_ORDEN_IMPORTACION": "Export",
  
  "PIF_NOMBRE": "PIF Valencia",
  "CARGADOR_NOMBRE": "Exportadora SA",
  "CARGADOR_CIF": "A12345678",
  "CARGADOR_DIRECCION": "Calle Comercio 25",
  "CARGADOR_POBLACION": "Valencia",
  "CARGADOR_PROVINCIA": "Valencia",
  
  "LUGARES": [
    {
      "LUGAR_NOMBRE": "Punto Carga 1",
      "LUGAR_DIRECCION": "Dirección 1",
      "LUGAR_CP": "28001",
      "LUGAR_POBLACION": "Madrid",
      "LUGAR_PROVINCIA": "Madrid",
      "LUGAR_TELEFONO": "91 123 45 67"
    }
  ],
  
  "PCS_BOOKING_NUMBER": "BOOK123456",
  "OBSERVACIONES": "Manipular con cuidado"
}
```

### Campos Específicos Tipo T (Terrestre)

```json
{
  "TRANSPORTISTA_NOMBRE": "Transportes Terrestres SL",
  "TRANSPORTISTA_NIF": "B87654321",
  "TRANSPORTISTA_DIRECCION": "Calle Transporte 10",
  "TRANSPORTISTA_POBLACION": "Barcelona",
  
  "CONDUCTOR_NOMBRE": "Pedro Martínez",
  "CONDUCTOR_NIF": "87654321B",
  
  "TRACTORA": "5678-XYZ",
  "PLATAFORMA_TIPO": "Lona",
  "TTE_ORDEN": "Tipo 1"
}
```

**Nota:** Los viajes se almacenan en la tabla `viajes`, no en el JSON.

### Campos Específicos Tipo M (Multimodal)

```json
{
  "TRANSPORTISTA_NOMBRE": "Multimodal Logistics SA",
  "TRANSPORTISTA_NIF": "B11223344",
  "TRANSPORTISTA_DIRECCION": "Avenida Principal 50",
  "TRANSPORTISTA_POBLACION": "Sevilla",
  
  "CONDUCTOR_NOMBRE": "Carlos Ruiz",
  "CONDUCTOR_NIF": "11223344C",
  
  "TRACTORA": "PEDIDO-2026-001",
  "PLATAFORMA_TIPO": "Plataforma estándar",
  
  "LUGAR_COMIENZO_NOMBRE": "Almacén Origen SA",
  "LUGAR_FIN_NOMBRE": "Terminal Destino SL",
  
  "LUGARES_DESCARGA": [
    {
      "LUGAR_IMPORTE": "1500.00"
    }
  ],
  
  "MERCANCIA": "Productos variados",
  "TTE_FECHA_CARGA": "2026-01-26",
  "CARGADOR_REF_CARGA": "REF-MULTI-001"
}
```

---

## 🎨 Estilos y CSS

### Clases de Layout de Formularios

```css
.form-layout-2 .form-group,
.form-layout-3 .form-group {
    border: 1px solid #ced4da;
    padding: 20px;
    transition: all 0.2s ease-in-out;
}

.form-layout-2 .form-group-active {
    background-color: #f8f9fa;
}
```

### Secciones de Datos con Color

```css
.seccion-de-datos {
    border-radius: 10px;
    background-color: #B2F3E6;
    padding: 20px;
}

.seccion-de-datos2 {
    border-radius: 10px;
    background-color: #D0FFC2;
    padding: 20px;
}

.seccion-de-datos3 {
    border-radius: 10px;
    background-color: #C1F2C1;
    padding: 20px;
}
```

### Animaciones CSS

```css
@keyframes slide-out-left {
    0% { transform: translateX(0); opacity: 1; }
    100% { transform: translateX(-1000px); opacity: 0; }
}

@keyframes slide-in-right {
    0% { transform: translateX(1000px); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}
```

### Botones Flotantes

```css
.botonFlotante1 { top: 61px; }
.botonFlotante2 { top: 121px; }
.botonFlotante3 { top: 181px; }
.botonFlotante4 { top: 181px; }
.botonFlotante5 { top: 472px; }

.colorBoton1 { background: #c1c0a3; }
.colorBoton2 { background: #b2a3c1; }
.colorBoton3 { background: #a3c1be; }
.colorBoton4 { background: #c1a7a7; }
.colorBoton5 { background: #aed581; }
```

---

## ⚙️ Funcionalidades Especiales

### 1. Edición de Contenedor en Línea

Solo disponible en Tipo C cuando `$mostrarContPrecinto == 1`

**Estados:**
- Modo lectura: Campo readonly con icono lápiz
- Modo edición: Campo editable con iconos guardar/cancelar
- Guardado: AJAX a controller

### 2. Formato Especial de Contenedor

Cuando no es editable, formatea el contenedor:
- `ABCD1234567` → `ABCD123456/7`

### 3. Sistema de Viajes con Tarjetas Coloreadas

- **CARGA**: Borde azul (`border-info`)
- **DESCARGA**: Borde rojo (`border-danger`)

### 4. Registro de Llegada y Salida

Al seleccionar un viaje, aparece formulario con:
- Fecha/hora de llegada
- Fecha/hora de salida
- Observaciones

### 5. Firma Digital

Sistema de captura de firma con canvas:
- Librería: `jquery.signaturepad.js`
- Guarda en base64
- Asociada a cada viaje

### 6. Generación de QR

Genera código QR con `OA_PCS_LOCATOR`:
- Tamaño: 200x200px
- Librería: `qr-code-styling`
- Personalizable

### 7. Control de Acceso

```php
checkAccess(['0', '1']);
// 0 = PROFESOR
// 1 = ADMIN
```

---

## 📁 Archivos Relacionados

### Archivos PHP

| Archivo | Ubicación | Líneas |
|---------|-----------|--------|
| `ordenTransporte.php` | `view/Transportes/` | 1777 |
| `Transportes.php` | `models/` | - |
| `transportes.php` | `controller/` | - |
| `orden.php` | `view/Transportes/` | - |

### Modales

| Archivo | Propósito |
|---------|-----------|
| `modalTipoDocumentoExport.php` | Modal impresión Tipo C |
| `modalTipoDocumentoExportTM.php` | Modal impresión Tipos T/M |
| `modalQr.php` | Código QR |
| `modalFirma.php` | Firma digital |
| `modalOrdenGesdoc.php` | Subida documentos |
| `modalContenedor.php` | Edición contenedor |
| `modalAyuda.php` | Sistema ayuda |

### JavaScript

| Archivo | Ubicación |
|---------|-----------|
| `index.js` | `view/Transportes/` |
| `jquery.signaturepad.js` | `view/Transportes/firma/` |

### Documentación

| Archivo | Contenido |
|---------|-----------|
| `impresion.md` | Guía de impresión |
| `MAPEO_CAMPOS_JSON_A_IMPRESION.md` | Mapeo de campos |
| `flujodescargaOrdenes.md` | Flujo de descarga |

---

## 🔧 Problemas Detectados y Mejoras

### ⚠️ Problemas Detectados

#### 1. Error en Campo HORA (Línea 1502)

```php
// PROBLEMA: Muestra MERCANCIA en lugar de hora
<label id="horajson"><?php echo $jsonDatos['MERCANCIA']; ?></label>

// SOLUCIÓN SUGERIDA:
<label id="horajson"><?php echo $jsonDatos['TTE_HORA_CARGA']; ?></label>
```

#### 2. Campos Vacíos en Tipo M

**Líneas con campos no definidos:**
- Línea 1407: `$jsonDatos['']` - TIPO PLATAFORMA
- Línea 1413: `$jsonDatos['']` - CLIENTE
- Línea 1417: `$jsonDatos['']` - NIF

**Solución:** Definir campos específicos en JSON:
```json
{
  "MULTIMODAL_TIPO_PLATAFORMA": "Tipo específico",
  "CLIENTE_NOMBRE": "Cliente SA",
  "CLIENTE_NIF": "B11223344"
}
```

#### 3. Código Comentado (Líneas 885-903)

Sistema de edición de precinto completamente comentado.

**Acción recomendada:** Decidir si mantener o eliminar.

### 💡 Mejoras Sugeridas

#### 1. Validación de Datos

```javascript
function validarFechas() {
    var llegada = new Date($("#fechaLlegada").val());
    var salida = new Date($("#fechaSalida").val());
    
    if (llegada > salida) {
        alert("La hora de llegada no puede ser posterior a la salida");
        return false;
    }
    return true;
}
```

#### 2. Mensajes de Confirmación

```javascript
$("#guardarModoContenedor").click(function() {
    if (confirm("¿Está seguro de modificar el contenedor?")) {
        // Proceder con guardado
    }
});
```

#### 3. Historial de Cambios

Crear tabla para auditoría:

```sql
CREATE TABLE `historial_ordenes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `idOrden` INT,
  `campo` VARCHAR(50),
  `valorAnterior` TEXT,
  `valorNuevo` TEXT,
  `usuario` INT,
  `fecha` DATETIME,
  FOREIGN KEY (`idOrden`) REFERENCES `transportes`(`idOrden`)
);
```

#### 4. Optimización de Consultas

```php
// En lugar de cargar todos los viajes, cargar solo activos
public function recogerViajesActivos($idOrden) {
    $sql = "SELECT * FROM viajes 
            WHERE idOrden = ? AND estado = 'ACTIVO' 
            ORDER BY fechaViaje ASC";
}
```

#### 5. Responsive Design

```css
/* Mejorar visualización móvil */
@media (max-width: 768px) {
    .botonFlotante1,
    .botonFlotante2,
    .botonFlotante3,
    .botonFlotante4,
    .botonFlotante5 {
        position: static;
        margin: 10px auto;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
}
```

#### 6. Notificaciones Mejoradas

```javascript
// Usar toast en lugar de alert
function mostrarNotificacion(mensaje, tipo) {
    lobibox.notify(tipo, {
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        position: 'top right',
        msg: mensaje
    });
}
```

#### 7. Cache de QR

```php
// Generar QR una vez y guardarlo
public function generarQR($codigo) {
    $filename = 'qr_' . md5($codigo) . '.png';
    $path = '../../public/qr/' . $filename;
    
    if (!file_exists($path)) {
        // Generar QR
        // Guardar en $path
    }
    
    return $filename;
}
```

---

## 📝 Checklist de Implementación

### Tipo C (Contenedor) ✓
- [x] 10 bloques de información
- [x] Edición de contenedor
- [x] Tabla de lugares múltiples
- [x] Clasificación IMO
- [x] Datos marítimos
- [x] 3 tipos de documento

### Tipo T (Terrestre) ✓
- [x] Formulario simplificado
- [x] Viajes con colores
- [x] 6 tipos de documento
- [x] Registro llegada/salida

### Tipo M (Multimodal) ⚠️
- [x] Base compartida con T
- [x] Ubicaciones plataforma
- [x] Precio acordado
- [ ] Completar campos cliente
- [ ] Completar tipo plataforma
- [ ] Corregir campo HORA

### Funcionalidades Comunes ✓
- [x] Firma digital
- [x] Generación QR
- [x] Subida documentos
- [x] Gestión incidencias
- [x] Sistema ayuda
- [x] Botones flotantes

---

## 🆘 Soporte

### Logs del Sistema

**Ubicación:** `public/log/`

### Variables de Debug

```php
// config/config.php
define('DEBUG_MODE', true);
```

### Contacto

- **Sistema:** Leader Transport Logística
- **Versión Documento:** 1.0
- **Fecha:** 26 de enero de 2026

---

**FIN DE LA DOCUMENTACIÓN**

*Este documento ha sido generado automáticamente mediante análisis completo del código fuente.*
