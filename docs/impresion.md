# Documentación del Archivo `orden.php`

**Archivo:** `view/Transportes/orden.php`  
**Propósito:** Generación de documentos imprimibles de órdenes de transporte  
**Última actualización:** 21 de diciembre de 2025

---

## 📋 Índice

1. [Descripción General](#descripción-general)
2. [Parámetros de Entrada](#parámetros-de-entrada)
3. [Tipos de Orden](#tipos-de-orden)
4. [Tipos de Documento](#tipos-de-documento)
5. [Estructura del Archivo](#estructura-del-archivo)
6. [Flujo de Datos](#flujo-de-datos)
7. [Secciones de Impresión](#secciones-de-impresión)
8. [Estilos CSS](#estilos-css)
9. [JavaScript](#javascript)
10. [Variables Importantes](#variables-importantes)

---

## 🎯 Descripción General

`orden.php` es el archivo responsable de generar documentos imprimibles de órdenes de transporte. Este archivo se abre en una **nueva ventana** desde `ordenTransporte.php` y muestra un formato optimizado para impresión en papel A4.

### Características principales:
- ✅ Generación de diferentes tipos de documentos (Oficina, Transportista, Cliente, etc.)
- ✅ Soporte para 3 tipos de orden: **Contenedor (C)**, **Terrestre (T)**, **Multimodal (M)**
- ✅ Generación automática de código QR
- ✅ Diseño responsive adaptado a impresión
- ✅ Paginación automática para órdenes con múltiples viajes
- ✅ Firma digital integrada
- ✅ Auto-impresión al cargar

---

## 📥 Parámetros de Entrada

El archivo recibe los siguientes parámetros por **GET**:

| Parámetro | Tipo | Obligatorio | Descripción |
|-----------|------|-------------|-------------|
| `idOrden` | string | ✅ | Token único de la orden de transporte |
| `tipoDocumento` | string | ✅ | Tipo de documento a generar (O, E, X, C, A, CMR) |
| `viaje` | int | ❌ | ID del viaje específico (solo para tipo C con viaje) |
| `contenedorActivo` | string | ❌ | Número de contenedor activo |
| `tipoOrdenTransporte` | string | ✅ | Tipo de orden (C, T, M) |

### Ejemplo de URL:
```php
orden.php?idOrden=ABC123TOKEN&tipoDocumento=O&contenedorActivo=MSKU1234567&tipoOrdenTransporte=C
```

---

## 📦 Tipos de Orden

### 1. **Tipo C - Contenedor (Marítimo)**
Orden de transporte marítimo con contenedores.

**Datos específicos:**
- Contenedores y precintos
- Información de buques y escalas
- Puertos de origen/destino
- Datos IMO/ONU para mercancía peligrosa
- Líneas navieras
- Temperaturas (para refrigerados)

### 2. **Tipo T - Terrestre**
Orden de transporte por carretera.

**Características:**
- Header y footer en todas las páginas
- Listado de lugares de carga/descarga
- Paginación automática (cada 2 viajes)
- Firmas por cada viaje
- Sin datos marítimos

### 3. **Tipo M - Multimodal**
Combinación de transporte marítimo y terrestre.

**Particularidades:**
- Incluye lugar de inicio y fin de plataforma
- Lugares de carga y descarga intermedios
- Formato similar al tipo T pero con datos adicionales

---

## 📄 Tipos de Documento

El parámetro `tipoDocumento` determina qué versión del documento se genera:

| Código | Nombre | Descripción | Header Text |
|--------|--------|-------------|-------------|
| **O** | Oficina | Documento interno para oficina | OFICINA |
| **T** | Transportista | Documento para el transportista | TRANSPORTISTA |
| **C** | Receptor/Cliente | Documento para el cliente (con viaje específico) | RECEPTOR |
| **E** | Entréguese | Documento de entrega con firmas | ENTREGUESE |
| **A** | Admítase | Documento de admisión | ADMITASE |
| **CMR** | Carta de Porte | Carta de porte internacional CMR | - |

### Diferencias entre tipos:

#### Tipo "O" (Oficina) / "T" (Transportista) / "X":
- Muestra todos los lugares de carga/descarga
- Sin restricción de viajes
- Información completa

#### Tipo "C" (Cliente/Receptor):
- Requiere parámetro `viaje`
- Muestra solo el viaje seleccionado
- Información limitada al viaje específico

#### Tipo "E" (Entréguese):
- Incluye sección de firmas en el footer
- Firma del cliente y del transportista
- Específico para confirmación de entrega

#### Tipo "A" (Admítase):
- Muestra localizador de admisión (`OA_PCS_LOCATOR`)
- Incluye referencia SIC

#### Tipo "CMR":
- Carta de porte internacional completa
- Formato específico CMR con 24 campos numerados
- Diseño especial con tablas

---

## 🏗️ Estructura del Archivo

```
orden.php
│
├── HEAD (líneas 1-126)
│   ├── Meta tags y configuración
│   ├── Inclusión de librerías CSS
│   ├── Configuración PHP
│   └── Conexión a Base de Datos
│
├── PHP - Obtención de datos (líneas 127-180)
│   ├── Recepción de parámetros GET
│   ├── Consulta a base de datos (Modelo Transporte)
│   ├── Decodificación del JSON
│   └── Determinación del headerText
│
├── ESTILOS CSS (líneas 181-656)
│   ├── Estilos generales
│   ├── Estilos de formularios
│   ├── Estilos para impresión (@media print)
│   └── Estilos específicos (CMR, tablas, etc.)
│
├── BODY (líneas 657-2468)
│   │
│   ├── Área Imprimible (printableArea)
│   │   │
│   │   ├── Formato CMR (si tipoDocumento == "CMR")
│   │   │   └── Carta de porte completa (líneas 673-1093)
│   │   │
│   │   └── Otros formatos
│   │       │
│   │       ├── TIPO C - Contenedor (líneas 1099-1819)
│   │       │   ├── Cabecera con logo y QR
│   │       │   ├── Datos generales (fechas, referencias)
│   │       │   ├── Agente y contenedores
│   │       │   ├── Transportista y conductor
│   │       │   ├── Lugares (Retirar/Entregar)
│   │       │   ├── Mercancía
│   │       │   ├── Tablas técnicas (Extras, IMO)
│   │       │   ├── Datos marítimos (Buque, escala)
│   │       │   ├── Puertos
│   │       │   ├── Cargador
│   │       │   ├── Tabla de lugares (viajes)
│   │       │   ├── Firmas (si existen)
│   │       │   └── Observaciones y datos legales
│   │       │
│   │       ├── TIPO T - Terrestre (líneas 1820-2066)
│   │       │   ├── Función insertHeader() (reutilizable)
│   │       │   ├── Header (cada página)
│   │       │   ├── Contenido (bucle de viajes)
│   │       │   │   ├── Lugares de CARGA
│   │       │   │   └── Lugares de DESCARGA
│   │       │   └── Footer
│   │       │       ├── Firmas (si tipo E)
│   │       │       └── Datos legales
│   │       │
│   │       └── TIPO M - Multimodal (líneas 2067-2368)
│   │           ├── Similar a Tipo T
│   │           ├── Lugar inicio plataforma
│   │           ├── Bucle de viajes
│   │           └── Lugar fin plataforma
│   │
│   └── Scripts JavaScript (líneas 2369-2492)
│       ├── Generación de QR
│       ├── Auto-impresión
│       └── Numeración de páginas
│
└── FIN
```

---

## 🔄 Flujo de Datos

### 1. Entrada de datos
```
URL con parámetros GET
    ↓
Validación de parámetros
    ↓
Consulta a Base de Datos (modelo Transporte)
```

### 2. Procesamiento
```php
// Línea 133-143
$tokenOrden = $_GET['idOrden'];
$tipoDocumento = $_GET['tipoDocumento'];
$idviaje = $_GET['viaje'];

$datosOrden = $transporte->recogerOrdenToken($tokenOrden);
$datosViajesBD = $transporte->recogerOrdenTokenAll($tokenOrden, $idviaje);

$jsonDatos = json_decode($datosOrden['jsonOrdenTransporte'], true);
```

### 3. Determinación del flujo
```php
// Línea 671-672
if ($tipoDocumento == "CMR") {
    // Renderizar CMR
} else {
    if ($tipoOrdenTransporte == 'C') {
        // Renderizar Contenedor
    } else if ($tipoOrdenTransporte == 'T') {
        // Renderizar Terrestre
    } else if ($tipoOrdenTransporte == 'M') {
        // Renderizar Multimodal
    }
}
```

### 4. Generación del documento
```
Renderizado HTML con datos PHP
    ↓
Aplicación de estilos CSS
    ↓
Ejecución de JavaScript (QR, impresión)
    ↓
Auto-impresión y cierre de ventana
```

---

## 🖨️ Secciones de Impresión

### TIPO C - Contenedor

#### Cabecera (Header)
```php
// Líneas 1099-1147
- Título: "ORDEN DE TRANSPORTE"
- Subtítulo con tipo de documento (OFICINA/TRANSPORTISTA/RECEPTOR)
- Datos de la agencia
- Código QR generado dinámicamente
```

**Campos:**
- Fecha de carga
- Hora
- Ref. Consignatario
- Recogida estimada
- Entrega estimada
- OT Agencia

#### Bloque 1: Agente y Contenedores
```php
// Líneas 1148-1175
- Agente/Consignatario
- Número(s) de contenedor(es)
- Tipo de contenedor (TIPO_CONT_DESC)
- Hlog/Precintos
```

#### Bloque 2: Transportista y Conductor
```php
// Líneas 1176-1198
Tabla con 3 columnas:
1. Transportista (nombre, dirección, NIF)
2. Conductor (nombre, NIF)
3. Cabeza tractora y plataforma
```

#### Bloque 3: Lugares
```php
// Líneas 1199-1225
Tabla dividida:
- RETIRAR DE: lugar de recogida
- ENTREGAR EN: lugar de entrega
```

#### Bloque 4: Mercancía
```php
// Líneas 1226-1252
- Descripción de la mercancía
- Bultos
- Peso en kg
- Temperaturas (Máx, Mín, Conectar)
```

#### Bloque 5: Extras Dimensionales
```php
// Líneas 1253-1279
Tabla con:
- Ext. Derecha
- Ext. Izquierda
- Ext. Frontal
- Ext. Trasera
- Ext. Altura
```

#### Bloque 6: Datos IMO (Mercancía Peligrosa)
```php
// Líneas 1280-1306
- ONU
- Versión
- IMDG (página)
- Clase
- Notificación Apv
```

#### Bloque 7: Datos Marítimos
```php
// Líneas 1307-1355
- Línea naviera
- Nº Escala
- Buque
- Viaje
- Distintivo de llamada
```

#### Bloque 8: Puertos
```php
// Líneas 1356-1385
- Puerto Origen
- Puerto Destino
- Puerto Descarga
- Tipo Orden
```

#### Bloque 9: Cargador
```php
// Líneas 1386-1431
- Referencia de carga
- Nombre del cargador
- CIF, dirección, población
- PIF/Aduana
```

#### Bloque 10: Tabla de Lugares (Viajes)
```php
// Líneas 1432-1492
Solo si tipoDocumento != 'A' y != 'E'

Tabla con columnas:
- Lugar
- Dirección
- CP
- Población
- Provincia
- Teléfono

Fuente de datos:
- Si hay parámetro 'viaje': $datosViajes (solo ese viaje)
- Si no: $jsonDatos['LUGARES'] (todos los lugares)
```

#### Bloque 11: Firmas y Observaciones
```php
// Líneas 1493-1625
- Firma y sello Leader (si existe)
- Firma y sello Cliente (si existe)
- Observaciones
- Booking Nº
- Localizador (según tipo A/E)
- Fecha de emisión
- Texto legal (RGPD)
```

---

### TIPO T - Terrestre

#### Función insertHeader()
```php
// Líneas 1830-1879
Función reutilizable que genera el header en cada página:
- Logo de la empresa
- Título: "ORDEN DE CARGA"
- Número de orden
- Datos de la agencia
- Datos del transportista y conductor
```

#### Estructura de página
```php
// Líneas 1886-2024
<header>
    insertHeader($jsonDatos)
</header>

<div id="contenido">
    // Bucle de viajes
    foreach ($datosViajesBD as $viaje) {
        if (tipoViaje == 'CARGA') {
            // Bloque de CARGA
        } else {
            // Bloque de DESCARGA
        }
        
        // Control de paginación (cada 2 bloques)
        if ($contador == 2) {
            <page-break>
            insertHeader($jsonDatos) // Nuevo header
        }
    }
</div>

<footer>
    // Firmas (si tipoDocumento == 'E')
    // Datos legales
</footer>
```

#### Bloque de CARGA/DESCARGA
Campos comunes:
- Empresa
- Población
- Dirección
- Teléfono
- CP
- Fecha de carga/descarga
- Hora
- Mercancía
- Ref. carga
- Bultos
- Metros
- Kilos
- Observaciones
- Firma Cliente (imagen)
- Identificación Cliente (nombre + DNI)
- Firma Transportista (imagen)
- Identificación Transportista (nombre + DNI)

---

### TIPO M - Multimodal

Estructura similar al Tipo T, pero con:

#### Diferencias específicas:
```php
// Línea 2148
Antes del bucle:
"LA PLATAFORMA SE RECOGE EN: [LUGAR_COMIENZO_NOMBRE]"

// Línea 2361
Después del bucle:
"LA PLATAFORMA SE DEJA EN: [LUGAR_FIN_NOMBRE]"
```

#### Campos adicionales en lugares:
- C.P./PAIS (en lugar de solo CP)
- Sin fecha/hora específicas
- Menos campos que Tipo T

---

### Formato CMR

Documento especial con **24 campos numerados** según normativa CMR internacional.

#### Estructura principal:
```php
// Líneas 682-1093
Cabecera CMR:
- Ejemplar para remitente
- Número de orden
- Código 2081

Campos CMR:
1. Remitente
2. Consignatario
3. Lugar de entrega
4. Lugar y fecha de carga
5. Documentos anexos
6. Marcas y números
7. Número de bultos
8. Clase de embalaje
9. Naturaleza de la mercancía
10. Nº estadístico
11. Peso bruto en Kg
12. Volumen en m³
13. Instrucciones del remitente
14. Forma de pago (Porte pagado/debido)
15. Reembolso
16. Porteador
17. Portadores sucesivos (tractora y plataforma)
18. Reservas y observaciones
19. Estipulaciones particulares
20. A pagar por (tabla de precios)
21. Formalizado en/fecha
22. Firma y sello remitente
23. Firma y sello transportista (con logo)
24. Recibo de la mercancía / Firma consignatario
```

---

## 🎨 Estilos CSS

### Estilos generales
```css
/* Líneas 181-199 */
body {
    font-family: "Courier New", Courier, monospace;
    font-weight: bold;
    color: #000000;
}
```

### Estilos de formulario
```css
/* Líneas 224-380 */
.form-layout-2 .form-group {
    position: relative;
    border: 1px solid #000000;
    padding: 20px 20px;
    margin-bottom: 0;
    height: 100%;
}
```

### Clases personalizadas
```css
/* Líneas 398-450 */
.borde-gris-derecho { border-right: 2px solid #000000; }
.borde-gris-abajo { border-bottom: 2px solid #000000; }
.border-right-none { border-right: none !important; }
.border-left-none { border-left: none !important; }
```

### Estilos para impresión
```css
/* Líneas 470-556 */
@media print {
    header {
        position: fixed;
        top: 0;
        height: 9cm;
        border-bottom: 1px solid #000;
    }
    
    footer {
        position: fixed;
        bottom: 0;
        height: 8cm;
        border-top: 1px solid #000;
    }
    
    @page {
        size: A4;
        margin: 1cm;
    }
    
    #contenido {
        margin-top: 4cm;
        margin-bottom: 4cm;
    }
    
    .page-break {
        page-break-before: always;
    }
}
```

### Estilos específicos CMR
```css
/* Líneas 575-650 */
.tableCMR td {
    vertical-align: top;
}

.cuadradito {
    width: 10px;
    height: 10px;
    background-color: white;
    border: 1px solid red;
}

.striped-background {
    background: repeating-linear-gradient(0deg,
        red,
        red 1px,
        transparent 1px,
        transparent 4px
    );
}

.boli-texto {
    font-family: 'Caveat', cursive;
    color: #2c3e50;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}
```

---

## ⚙️ JavaScript

### Generación de código QR
```javascript
// Líneas 2390-2427
$(document).ready(function() {
    var qrCode = new QRCodeStyling({
        width: 150,
        height: 150,
        dotsOptions: {
            color: "#000000",
            type: "rounded",
        },
        backgroundOptions: {
            color: "#E9EDF3",
        },
        imageOptions: {
            crossOrigin: "anonymous",
            margin: 5,
        },
    });

    var inputText = $('#primerCodigo').val(); // Valor del localizador
    
    qrCode.update({
        data: inputText,
        image: "logoLeader.png",
    });
    
    qrCode.append(document.getElementById("qrcode"));
});
```

**Datos del QR:**
- Para tipo C: `$jsonDatos['OA_PCS_LOCATOR']`
- Dimensiones: 150x150px
- Tipo: Rounded dots
- Logo: logoLeader.png

### Auto-impresión y cierre
```javascript
// Líneas 2481-2486
setTimeout(function() {
    window.print(); // Abre diálogo de impresión
    window.close(); // Cierra la ventana
}, 1000); // 1 segundo de delay
```

### Numeración de páginas
```javascript
// Líneas 2488-2492
$('.pagenum').each(function(index) {
    $(this).text("Página " + (parseInt(index) + 1) + " de " + $('.pagenum').length);
});
```

---

## 📊 Variables Importantes

### Variables PHP principales

```php
// Parámetros de entrada
$tokenOrden          // Token único de la orden
$tipoDocumento       // Tipo de documento (O, E, X, C, A, CMR)
$idviaje             // ID del viaje (opcional)

// Datos de la orden
$datosOrden          // Array con datos generales de la orden
$datosViajesBD       // Array con todos los viajes de la orden
$jsonDatos           // Array con datos decodificados del JSON

// Campos específicos
$idOrden             // Número de orden (num_transporte)
$tipoOrdenTransporte // Tipo de orden (C, T, M)
$contenedorActivo    // Contenedor(es) activo(s)
$precintoActivo      // Precinto(s) activo(s)
$headerText          // Texto del header según tipoDocumento
```

### Campos del $jsonDatos (JSON)

#### Datos de la Agencia
```php
$jsonDatos['AGENCIA_NOMBRE']
$jsonDatos['AGENCIA_DIRECCION']
$jsonDatos['AGENCIA_CP']
$jsonDatos['AGENCIA_POBLACION']
$jsonDatos['AGENCIA_PROVINCIA']
$jsonDatos['AGENCIA_TELEFONO']
$jsonDatos['AGENCIA_EMAIL']
$jsonDatos['AGENCIA_CIF']
```

#### Datos del Transporte
```php
$jsonDatos['TTE_FECHA_CARGA']
$jsonDatos['TTE_HORA_CARGA']
$jsonDatos['TTE_REF_CONSIG']
$jsonDatos['TTE_FECHA_ESTIMADA_RECOGIDA']
$jsonDatos['TTE_FECHA_ESTIMADA_ENTREGA']
$jsonDatos['TTE_ORDEN']
```

#### Transportista y Conductor
```php
$jsonDatos['TRANSPORTISTA_NOMBRE']
$jsonDatos['TRANSPORTISTA_DIRECCION']
$jsonDatos['TRANSPORTISTA_CP']
$jsonDatos['TRANSPORTISTA_POBLACION']
$jsonDatos['TRANSPORTISTA_PROVINCIA']
$jsonDatos['TRANSPORTISTA_NIF']

$jsonDatos['CONDUCTOR_NOMBRE']
$jsonDatos['CONDUCTOR_NIF']

$jsonDatos['TRACTORA']
$jsonDatos['PLATAFORMA']
$jsonDatos['PLATAFORMA_TIPO']
```

#### Contenedor (solo tipo C)
```php
$jsonDatos['CONSIGNATARIO']
$jsonDatos['TIPO_CONT_DESC']  // Descripción del tipo
$jsonDatos['TIPO_CONT']        // Código del tipo (ej: 20DC)
```

#### Lugares
```php
$jsonDatos['RECOGER_EN_NOMBRE']
$jsonDatos['RECOGER_EN_DIRECCION']
$jsonDatos['RECOGER_EN_CP']
$jsonDatos['RECOGER_EN_POBLACION']
$jsonDatos['RECOGER_EN_PROVINCIA']

$jsonDatos['DEVOLVER_EN_NOMBRE']
$jsonDatos['DEVOLVER_EN_DIRECCION']
$jsonDatos['DEVOLVER_EN_CP']
$jsonDatos['DEVOLVER_EN_POBLACION']
$jsonDatos['DEVOLVER_EN_PROVINCIA']

// Array de lugares (para tabla)
$jsonDatos['LUGARES'][0]['LUGAR_NOMBRE']
$jsonDatos['LUGARES'][0]['LUGAR_DIRECCION']
$jsonDatos['LUGARES'][0]['LUGAR_CP']
$jsonDatos['LUGARES'][0]['LUGAR_POBLACION']
$jsonDatos['LUGARES'][0]['LUGAR_PROVINCIA']
$jsonDatos['LUGARES'][0]['LUGAR_TELEFONO']
```

#### Mercancía
```php
$jsonDatos['MERCANCIA']
$jsonDatos['BULTOS']
$jsonDatos['PESO_MERCANCIA']
$jsonDatos['TEMP_MAXIMA']
$jsonDatos['TEMP_MINIMA']
$jsonDatos['TEMP_CONECTAR']
```

#### Extras Dimensionales
```php
$jsonDatos['EXTRA_RIGHT']
$jsonDatos['EXTRA_LEFT']
$jsonDatos['EXTRA_FRONT']
$jsonDatos['EXTRA_BACK']
$jsonDatos['EXTRA_ALTO']
```

#### Datos IMO (Mercancía Peligrosa)
```php
$jsonDatos['IMO_ONU']
$jsonDatos['IMO_VERSION']
$jsonDatos['IMO_PAGINA']
$jsonDatos['IMO_CLASE']
$jsonDatos['IMO_PORT_NOTIFICATION']
```

#### Datos Marítimos (solo tipo C)
```php
$jsonDatos['NOMBRELINEA_DEST']
$jsonDatos['ESCALA_DEST']
$jsonDatos['BUQUE_DEST']
$jsonDatos['VIAJE']
$jsonDatos['DISTINTIVO_LLAMADA']

$jsonDatos['PUERTO_ORIGEN_NOMBRE']
$jsonDatos['PUERTO_DESTINO_NOMBRE']
$jsonDatos['PUERTO_DESCARGA_NOMBRE']
$jsonDatos['PUERTO_TIPO_ORDEN_IMPORTACION']
```

#### Cargador
```php
$jsonDatos['CARGADOR_REF_CARGA']
$jsonDatos['CARGADOR_NOMBRE']
$jsonDatos['CARGADOR_CIF']
$jsonDatos['CARGADOR_DIRECCION']
$jsonDatos['CARGADOR_POBLACION']
$jsonDatos['CARGADOR_PROVINCIA']
```

#### PIF/Aduana
```php
$jsonDatos['PIF_NOMBRE']
```

#### Observaciones
```php
$jsonDatos['PCS_BOOKING_NUMBER']
$jsonDatos['OBSERVACIONES']
```

#### Localizadores (tipos A y E)
```php
$jsonDatos['OA_PCS_LOCATOR']  // Localizador Admisión
$jsonDatos['OA_PCS']           // Ref. SIC Admisión
$jsonDatos['OE_PCS_LOCATOR']  // Localizador Entrega
$jsonDatos['OE_PCS']           // Ref. SIC Entrega
```

#### Multimodal (solo tipo M)
```php
$jsonDatos['LUGAR_COMIENZO_NOMBRE']
$jsonDatos['LUGAR_FIN_NOMBRE']
```

#### CMR (solo tipoDocumento CMR)
```php
$jsonDatos['CMR'][0]['PLATAFORMA']
$jsonDatos['CMR'][0]['TRACTORA']
$jsonDatos['CMR'][0]['LUGAR_CARGA']
$jsonDatos['CMR'][0]['LUGAR_DESCARGA']
$jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_BULTOS_DESCARGA']
$jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_MERCANCIA_DESCARGA']
$jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_KILOS_DESCARGA']
```

### Campos de $datosViajes (para viajes individuales)

```php
$viaje['idViaje']
$viaje['tipoViaje']  // 'CARGA' o 'DESCARGA'
$viaje['LUGAR_NOMBRE']
$viaje['LUGAR_DIRECCION']
$viaje['LUGAR_CP']
$viaje['LUGAR_POBLACION']
$viaje['LUGAR_PROVINCIA']
$viaje['LUGAR_TELEFONO']
$viaje['TTE_FECHA_CARGA']
$viaje['TTE_HORA_CARGA']

// Firmas
$viaje['FirmaViajeReceptor']      // URL imagen
$viaje['nombreViajeReceptor']     // Nombre cliente
$viaje['dniViajeReceptor']        // DNI cliente
$viaje['FirmaViajeConductor']     // URL imagen
$viaje['nombreViajeConductor']    // Nombre conductor
$viaje['dniViajeConductor']       // DNI conductor
```

### Campos de $datosOrden (firmas generales)

```php
// Para tipo E (Entréguese)
$datosOrden['firmaCliente']
$datosOrden['nombreCliente']
$datosOrden['dniCliente']
$datosOrden['FirmaViajeConductor']
$datosOrden['nombreViajeConductor']
$datosOrden['dniViajeConductor']

// Para tipo C con firmas
$datosOrden['FirmaViajeReceptor']
$datosOrden['nombreViajeReceptor']
$datosOrden['dniViajeReceptor']
```

---

## 🔧 Funciones Importantes

### transformarFecha()
```php
// Función de config/funciones.php
transformarFecha($fecha, ['d', '-', 'm', '-', 'Y']);
// Convierte formato de fecha
```

### transformarFechaVacia()
```php
// Función de config/funciones.php
transformarFechaVacia($fecha, ["d", "-", "m", "-", "Y"]);
// Como transformarFecha pero permite valores vacíos
```

### insertHeader() (Tipo T y M)
```php
// Líneas 1830-1879 y 2084-2133
function insertHeader($jsonDatos) {
    // Genera el header HTML para cada página
    // Incluye: logo, título, datos agencia, transportista
}
```

---

## 📝 Notas de Desarrollo

### Modificaciones frecuentes

1. **Agregar nuevo campo al JSON:**
   - Añadir en la base de datos (campo `jsonOrdenTransporte`)
   - Acceder con `$jsonDatos['NUEVO_CAMPO']`
   - Insertar en la sección correspondiente

2. **Cambiar formato de impresión:**
   - Modificar estilos en sección `@media print`
   - Ajustar márgenes de header/footer
   - Modificar `#contenido { margin-top/bottom }`

3. **Añadir nuevo tipo de documento:**
   - Añadir case en línea 167-178
   - Crear nueva sección de renderizado
   - Actualizar modal de selección

4. **Modificar paginación (Tipo T/M):**
   - Cambiar valor de `$contador` en línea 1900/2158
   - Ajustar condición `if ($contador == 2)`

### Problemas comunes

1. **QR no se genera:**
   - Verificar valor de `$jsonDatos['OA_PCS_LOCATOR']`
   - Revisar ruta de logo: `logoLeader.png`

2. **Auto-impresión no funciona:**
   - Bloqueador de pop-ups activado
   - Aumentar timeout en línea 2481

3. **Saltos de página incorrectos:**
   - Ajustar altura de header/footer en CSS
   - Modificar `margin-top/bottom` de `#contenido`

4. **Firmas no se muestran:**
   - Verificar que existan en base de datos
   - Comprobar permisos de carpeta `firmas/`

---

## 🚀 Mejoras Futuras

- [ ] Implementar sistema de plantillas dinámicas
- [ ] Añadir opción de vista previa sin impresión
- [ ] Mejorar responsive para otros tamaños de papel
- [ ] Cachear generación de QR
- [ ] Optimizar consultas SQL (reducir llamadas)
- [ ] Añadir más tipos de documento personalizables
- [ ] Implementar firma digital avanzada
- [ ] Exportación directa a PDF sin impresión

---

## 📞 Contacto y Soporte

Para modificaciones en este archivo, consultar con el equipo de desarrollo.

**Última actualización:** 21 de diciembre de 2025  
**Versión:** 1.0
