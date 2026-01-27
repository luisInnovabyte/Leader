# 📄 Documentación: Formularios de Impresión de Órdenes de Transporte

**Archivo:** `view/Transportes/orden.php`  
**Última actualización:** 27 de enero de 2026  
**Versión:** 1.0  
**Autor:** Sistema Logística Leader Transport

---

## 📋 Índice

1. [Visión General](#visión-general)
2. [Parámetros de Acceso](#parámetros-de-acceso)
3. [Tipo Contenedor (C)](#tipo-contenedor-c)
4. [Tipo Terrestre (T)](#tipo-terrestre-t)
5. [Tipo Multimodal (M)](#tipo-multimodal-m)
6. [CMR - Carta de Porte Internacional](#cmr---carta-de-porte-internacional)
7. [Tamaños de Impresión](#tamaños-de-impresión)
8. [Cómo Modificar un Formulario](#cómo-modificar-un-formulario)

---

## 🔍 Visión General

El sistema gestiona **13 formularios de impresión diferentes** organizados por tipo de transporte:

| Tipo Transporte | Formularios Disponibles | Total |
|----------------|------------------------|-------|
| **Contenedor (C)** | Cliente, Oficina, Receptor | 3 |
| **Terrestre (T)** | Admítase, Entréguese, Oficina, Transportista, Receptor, CMR | 6 |
| **Multimodal (M)** | Admítase, Entréguese, Oficina, Transportista, Receptor, CMR | 6 |

---

## 🔗 Parámetros de Acceso

### URL de Generación

```
orden.php?idOrden=TOKEN&tipoDocumento=TIPO&contenedorActivo=CONT&tipoOrdenTransporte=C|T|M&viaje=ID
```

### Parámetros GET

| Parámetro | Tipo | Descripción | Requerido |
|-----------|------|-------------|-----------|
| `idOrden` | string | Token único de la orden | ✅ Sí |
| `tipoDocumento` | string | Código del tipo de documento (ver tabla abajo) | ✅ Sí |
| `contenedorActivo` | string | Número de contenedor (solo tipo C) | ⚠️ Condicional |
| `tipoOrdenTransporte` | string | `C` = Contenedor, `T` = Terrestre, `M` = Multimodal | ✅ Sí |
| `viaje` | int | ID del viaje específico (solo para receptor 'X') | ⚠️ Condicional |

### Códigos de Tipo de Documento

| Código | Nombre | Aplicable a | Header Text | Línea PHP |
|--------|--------|-------------|-------------|-----------|
| `E` | CLIENTE / ENTRÉGUESE | C, T, M | ENTREGUESE | 184-185 |
| `O` | OFICINA | C, T, M | OFICINA | 176-177 |
| `X` / `C` | RECEPTOR | C, T, M | RECEPTOR | 180-181 |
| `A` | ADMÍTASE | T, M | ADMITASE | 182-183 |
| `T` | TRANSPORTISTA | T, M | TRANSPORTISTA | 178-179 |
| `CMR` | Carta de Porte Internacional | T, M | (especial) | 680 |

**Ubicación del código:** Líneas 176-186

```php
if ($tipoDocumento == 'O') {
    $headerText = 'OFICINA';
} elseif ($tipoDocumento == 'T') {
    $headerText = 'TRANSPORTISTA';
} elseif ($tipoDocumento == 'C') {
    $headerText = 'RECEPTOR';
} elseif ($tipoDocumento == 'A') {
    $headerText = 'ADMITASE';
} elseif ($tipoDocumento == 'E') {
    $headerText = 'ENTREGUESE';
}
```

---

## 🚢 Tipo Contenedor (C)

**Identificador:** `$tipoOrdenTransporte == 'C'`  
**Líneas:** 947-1640  
**Formularios:** 3 (Cliente, Oficina, Receptor)

### 🔍 Condición de Identificación

```php
<?php if ($tipoOrdenTransporte == 'C') { ?>
    <!-- CONTENIDO TIPO C -->
<?php } ?>
```

### 📐 Estructura del Formulario

#### **Header - Encabezado Principal** (Líneas 950-976)

```
┌─────────────────────────────────────────────────────────┐
│ Col-5: "ORDEN DE TRANSPORTE"                           │
│        [Subtítulo: $headerText]                         │
├──────────────────────────────────┬──────────────────────┤
│ Col-4: Datos Agencia             │ Col-3: QR Code       │
│ - AGENCIA_NOMBRE                 │ <div id="qrcode">    │
│ - AGENCIA_DIRECCION              │                      │
│ - AGENCIA_TELEFONO               │                      │
│ - AGENCIA_CP, POBLACION, PROV    │                      │
│ - AGENCIA_CIF                    │                      │
└──────────────────────────────────┴──────────────────────┘
```

**Identificador sección:**
```html
<div class="col-5">
    <h2 class="form-control-label tx-bold mg-10 tipo-letra print-27">ORDEN DE TRANSPORTE</h2>
    <h3 class="form-control-label tx-bold tx-center text-decoration-underline "><?php echo $headerText ?></h3>
</div>
```

#### **Bloque 1: Fechas y Referencias** (Líneas 977-1024)

**Identificador:**
```html
<div class="col-12">
    <div class="form-group col-12">
        <table class="" style="padding-left: 15px;">
```

**Campos (Fila 1):**
- `TTE_FECHA_CARGA` - Fecha de carga
- `TTE_HORA_CARGA` - Hora
- `CARGADOR_REF_CARGA` - Ref. Consig

**Campos (Fila 2):**
- `TTE_FECHA_ESTIMADA_RECOGIDA` - Recogida estimada
- `TTE_FECHA_ESTIMADA_ENTREGA` - Entrega estimada
- `TTE_ORDEN` - OT Agencia

#### **Bloque 2: Agente y Contenedor** (Líneas 1027-1093)

**Identificador:**
```html
<div class="col-6 borde-gris-derecho row" style="padding-left: 25px;">
    <div class="col-12 d-flex align-items-start borde-gris-abajo">
        <label>Agente:</label>
```

**Sección 2.1: Agente**
- `CONSIGNATARIO` - Nombre del agente

**Sección 2.2: Contenedores** (columna 3)
- `contenedorActivo` - Número de contenedor
- `TIPO_CONT_DESC` + `TIPO_CONT` - Tipo
- `PRECINTO` - Hlog Precintos

**Sección 2.3: Transportista** (Tabla derecha)
- Columna 1: Transportista
  - `TRANSPORTISTA_NOMBRE`
  - `TRANSPORTISTA_DIRECCION`
  - `TRANSPORTISTA_CP`, `TRANSPORTISTA_POBLACION`, `TRANSPORTISTA_PROVINCIA`
  - `TRANSPORTISTA_NIF`
- Columna 2: Conductor
  - `CONDUCTOR_NOMBRE`
  - `CONDUCTOR_NIF`
- Columna 3: Cabeza
  - `TRACTORA` - Matrícula
  - `PLATAFORMA` - Tipo plataforma

#### **Bloque 3: Ubicaciones** (Líneas 1097-1126)

**Identificador:**
```html
<div class="col-6 borde-gris-derecho row">
    <table class="mg-5">
        <tr>
            <th class="tx-bold borde-gris-derecho">Retirar De:</th>
```

**Campos:**
- **Retirar De:**
  - `RECOGER_EN_NOMBRE`
  - `RECOGER_EN_DIRECCION`
  - `RECOGER_EN_CP`, `RECOGER_EN_POBLACION`, `RECOGER_EN_PROVINCIA`
  
- **Entregar En:**
  - `DEVOLVER_EN_NOMBRE`
  - `DEVOLVER_EN_DIRECCION`
  - `DEVOLVER_EN_CP`, `DEVOLVER_EN_POBLACION`, `DEVOLVER_EN_PROVINCIA`

#### **Bloque 4: Mercancía y Temperatura** (Líneas 1127-1177)

**Identificador:**
```html
<div class="col-6">
    <div class="row mg-5">
        <div class="col-12">
            <table class="borde-gris-abajo">
                <tr>
                    <th>Mercancía:</th>
```

**Campos:**
- `LUGARES[0]['LUGAR_MERCANCIA_CARGA']` - Mercancía
- `LUGARES[0]['LUGAR_BULTOS_CARGA']` - Bultos
- `LUGARES[0]['LUGAR_KILOS_CARGA']` - Peso (kg)
- `TEMP_MAXIMA` - Temperatura máxima
- `TEMP_MINIMA` - Temperatura mínima
- `TEMP_CONECTAR` - Conectar

#### **Bloque 5: Dimensiones Extras** (Líneas 1182-1222)

**Identificador:**
```html
<div class="col-6 borde-gris-derecho row">
    <table class="mg-5">
        <tr>
            <th class="tx-bold tx-center">Ext. Der</th>
```

**Campos (Extensiones):**
- `EXTRA_RIGHT` - Ext. Der
- `EXTRA_LEFT` - Ext. Izq
- `EXTRA_FRONT` - Ext. Front
- `EXTRA_BACK` - Ext. Tras
- `EXTRA_ALTO` - Ext. Altura

**Campos (IMO):**
- `IMO_ONU` - ONU
- `IMO_VERSION` - Versión
- `IMO_PAGINA` - IMDG
- `IMO_CLASE` - Clase
- `IMO_PORT_NOTIFICATION` - Notif Apv

#### **Bloque 6: Datos Marítimos** (Líneas 1267-1349)

**Identificador:**
```html
<div class="col-6 borde-gris-derecho row">
    <table class="mg-l-10">
        <tbody>
            <tr>
                <th><label>Línea:</label></th>
```

**Sección Izquierda:**
- `NOMBRELINEA_DEST` - Línea
- `ESCALA_DEST` - Nº Escala
- `BUQUE_DEST` - Buque
- `VIAJE` - Viaje
- `DISTINTIVO_LLAMADA` - Dist. Llamada

**Sección Derecha:**
- `PUERTO_ORIGEN_NOMBRE` - Origen
- `PUERTO_DESTINO_NOMBRE` - Destino
- `PUERTO_DESCARGA_NOMBRE` - Pto. Des/carga
- `PUERTO_TIPO_ORDEN_IMPORTACION` - Tipo Orden (IMPORT/EXPORT)

#### **Bloque 7: Referencias** (Líneas 1356-1386)

**Identificador:**
```html
<div class="col-7 borde-gris-derecho d-flex justify-content-start form-inline">
    <label>Ref Carga:</label>
```

**Campos:**
- `LUGARES[0]['LUGAR_REF_CARGA']` - Ref Carga
- `CARGADOR_NOMBRE` - Cargador

#### **Bloque 8: PIF/Aduana y Cargador** (Líneas 1392-1415)

**Identificador:**
```html
<div class="col-7 borde-gris-derecho d-flex justify-content-start form-inline">
    <label>Pif/Aduana:</label>
```

**Campos:**
- `PIF_NOMBRE` - Pif/Aduana
- Datos completos cargador (derecha)

#### **Bloque 9: Lugares Carga/Descarga** (Líneas 1422-1498)

**Identificador y Condición:**
```php
<?php if ($tipoDocumento != 'A' && $tipoDocumento != 'E') { ?>
    <div class="col-12">
        <div class="form-group">
            <label>Lugares Carga/Descarga:</label>
            <table>
                <thead>
                    <tr class="borde-gris-abajo">
                        <th>Lugar</th>
```

**⚠️ IMPORTANTE:** Esta sección NO se muestra para documentos tipo ADMÍTASE (A) y ENTRÉGUESE (E)

**Campos de la Tabla:**
- `LUGAR_NOMBRE` - Lugar
- `LUGAR_DIRECCION` - Dirección
- `LUGAR_CP` - CP
- `LUGAR_POBLACION` - Población
- `LUGAR_PROVINCIA` - Provincia
- `LUGAR_TELEFONO` - Telf

**Fuente de datos:**
- Si `$_GET['viaje']` existe → `$datosViajes` (viaje específico)
- Si no → `$jsonDatos['LUGARES']` (todos los lugares)

#### **Bloque 10: Firmas y Observaciones** (Líneas 1503-1587)

**Identificador:**
```html
<div class="col-12">
    <div class="form-group">
        <div class="row d-flex align-items-start">
```

**Sección Firmas** (condicional - si existen):
```php
<?php if (!empty($datosOrden['dniViajeReceptor'])) { ?>
```

- **FIRMA Y SELLO LEADER:**
  - `FirmaViajeConductor` - Imagen firma
  - `nombreViajeConductor`, `dniViajeConductor` - Identificación

- **FIRMA Y SELLO CLIENTE:**
  - `FirmaViajeReceptor` - Imagen firma
  - `nombreViajeReceptor`, `dniViajeReceptor` - Identificación

**Sección Observaciones:**
- `PCS_BOOKING_NUMBER` - Booking Nº
- `OBSERVACIONES` - Observaciones

**Sección Tipo Documento** (condicional):
```php
if ($tipoDocumento == 'A') {
    // ADMÍTASE
    - OA_PCS_LOCATOR - Loc. Admisión
    - OA_PCS - Ref. Sic
} elseif ($tipoDocumento == 'E') {
    // ENTRÉGUESE
    - OE_PCS_LOCATOR - Loc. Entrega
    - OE_PCS - Ref. Sic
}
```

**Fecha Emisión:**
- Fecha/hora actual del sistema

**Aviso Legal:**
- Texto de protección de datos (línea 1585)

### 🎨 Características Especiales Tipo C

1. **QR Code:** Se genera dinámicamente en el header
2. **Contenedor Editable:** Variable `$mostrarContPrecinto` controla editabilidad
3. **Tabla de Lugares:** Soporta múltiples ubicaciones
4. **Formato Contenedor:** Inserta '/' antes del último carácter
5. **Firmas Digitales:** Imágenes base64 de firmas

---

## 🚛 Tipo Terrestre (T)

**Identificador:** `$tipoOrdenTransporte == 'T'`  
**Líneas:** 1650-1905  
**Formularios:** 6 (Admítase, Entréguese, Oficina, Transportista, Receptor, CMR)

### 🔍 Condición de Identificación

```php
<?php } else if ($tipoOrdenTransporte == 'T') { ?>
    <!-- CONTENIDO TIPO T -->
<?php } ?>
```

### 📐 Estructura del Formulario

#### **Header - Función PHP** (Líneas 1655-1699)

**Identificador:**
```php
function insertHeader($jsonDatos) {
    echo '<header>
```

**Layout del Header:**

```
┌────────────────────────────────────────────────────────┐
│ Row 1:                                                 │
│ ├─ Col-6: Logo Leader Transport (50%)                 │
│ └─ Col-6: "ORDEN DE CARGA"                            │
│           Nº TTE_ORDEN                                 │
├────────────────────────────────────────────────────────┤
│ Row 2: Línea inferior                                  │
│ ├─ Col-5: Datos Agencia                               │
│ │  - AGENCIA_DIRECCION, CP, POBLACION, PROVINCIA      │
│ │  - TEL: AGENCIA_TELEFONO                            │
│ │  - EMAIL: AGENCIA_EMAIL                             │
│ │  - NIF: AGENCIA_CIF                                 │
│ └─ Col-6: <span class="pagenum">                      │
├────────────────────────────────────────────────────────┤
│ Row 3: Datos Transporte (2 columnas)                  │
│ ├─ Col-6 (Izquierda):                                 │
│ │  - Transportista: TRANSPORTISTA_NOMBRE              │
│ │  - Dirección: TRANSPORTISTA_DIRECCION               │
│ │  - Conductor: CONDUCTOR_NOMBRE                      │
│ │  - Matrícula: TRACTORA                              │
│ │  - Precio acordado: (vacío)                         │
│ └─ Col-6 (Derecha):                                   │
│    - Identificación Transportista: TRANSPORTISTA_NIF  │
│    - Población: TRANSPORTISTA_POBLACION               │
│    - Identificación Conductor: CONDUCTOR_NIF          │
│    - Plataforma: PLATAFORMA                           │
│    - Tipo Plataforma: PLATAFORMA_TIPO                 │
└────────────────────────────────────────────────────────┘
```

**Características:**
- Se llama como función: `insertHeader($jsonDatos);`
- Se repite en cada salto de página (cada 2 viajes)
- Estilos inline para impresión

#### **Contenido - Bloques de Viajes** (Líneas 1703-1860)

**Identificador del Contenedor:**
```html
<div id="contenido">
    <?php
    $contador = 0; // SALTO DE PAGINA
    foreach ($datosViajesBD as $viaje) {
```

**Sistema de Paginación:**
```php
if ($contador == 2) {
    echo '<div class="page-break"></div>';
    insertHeader($jsonDatos);
    $contador = 0;
}
```

##### **Bloque CARGA** (Líneas 1720-1783)

**Identificador:**
```php
if ($viaje['tipoViaje'] == 'CARGA') {
```

**Header del Bloque:**
```html
<div class="row bloqueOrden">
    <label class="bold col-12 tx-center">LUGARES DE CARGA 📥</label>
</div>
```

**Estructura de Campos:**

```
┌─────────────────────────────────────────────────────┐
│ LUGARES DE CARGA 📥                                 │
├──────────────────────┬──────────────────────────────┤
│ Empresa              │ Población                    │
│ LUGAR_NOMBRE         │ LUGAR_POBLACION              │
├──────────────────────┴──────────────────────────────┤
│ Dirección: LUGAR_DIRECCION                          │
├──────────────────────┬──────────────────────────────┤
│ Teléfono             │ CP                           │
│ LUGAR_TELEFONO       │ LUGAR_CP                     │
├──────────────────────┼──────────────────────────────┤
│ Fecha                │ Hora                         │
│ TTE_FECHA_CARGA      │ TTE_HORA_CARGA               │
├──────────────────────┼──────────────────────────────┤
│ Mercancia            │ Ref. carga                   │
│ MERCANCIA            │ LUGAR_REF_CARGA              │
├──────────────────────┼──────────────────────────────┤
│ Bultos               │ Metros                       │
│ BULTOS               │ (vacío)                      │
├──────────────────────┴──────────────────────────────┤
│ Kilos: PESO_MERCANCIA                               │
├──────────────────────┬──────────────────────────────┤
│ Observaciones        │ Firma Cliente                │
│ LUGAR_OBSERVACIONES_ │ [Imagen]                     │
│ CARGA                │ FirmaViajeReceptor           │
├──────────────────────┼──────────────────────────────┤
│ Identificación       │ Firma Transportista          │
│ Cliente              │ [Imagen]                     │
│ nombreViajeReceptor  │ FirmaViajeConductor          │
│ dniViajeReceptor     │                              │
├──────────────────────┼──────────────────────────────┤
│                      │ Identificación               │
│                      │ Transportista                │
│                      │ nombreViajeConductor         │
│                      │ dniViajeConductor            │
└──────────────────────┴──────────────────────────────┘
```

**Campos completos:**
- `LUGAR_NOMBRE` - Empresa
- `LUGAR_POBLACION` - Población
- `LUGAR_DIRECCION` - Dirección
- `LUGAR_TELEFONO` - Teléfono
- `LUGAR_CP` - CP
- `TTE_FECHA_CARGA` - Fecha (del viaje)
- `TTE_HORA_CARGA` - Hora (del viaje)
- `$jsonDatos['MERCANCIA']` - Mercancía (del JSON principal)
- `LUGAR_REF_CARGA` - Ref. carga
- `$jsonDatos['BULTOS']` - Bultos
- Metros - (vacío, comentado)
- `$jsonDatos['PESO_MERCANCIA']` - Kilos
- `LUGAR_OBSERVACIONES_CARGA` - Observaciones
- `FirmaViajeReceptor` - Firma Cliente (imagen)
- `nombreViajeReceptor`, `dniViajeReceptor` - Identificación Cliente
- `FirmaViajeConductor` - Firma Transportista (imagen)
- `nombreViajeConductor`, `dniViajeConductor` - Identificación Transportista

##### **Bloque DESCARGA** (Líneas 1793-1854)

**Identificador:**
```php
} else {
    // Es descarga
```

**Header del Bloque:**
```html
<div class="row bloqueOrden">
    <label class="bold col-12 tx-center">LUGARES DE DESCARGA 📤</label>
</div>
```

**Campos (idénticos a CARGA, excepto):**
- `LUGAR_REF_DESCARGA` (en lugar de LUGAR_REF_CARGA)
- `LUGAR_OBSERVACIONES_DESCARGA` (en lugar de LUGAR_OBSERVACIONES_CARGA)
- Fecha y Hora están comentados (no se muestran)

#### **Footer** (Líneas 1870-1905)

**Identificador:**
```html
<footer <?php if ($tipoDocumento != "E") { ?> style="height:5cm" <?php } ?>>
```

##### **Sección Firmas Finales** (Solo para tipo ENTRÉGUESE)

**Condición:**
```php
<?php if ($tipoDocumento == "E") { ?>
```

**Layout:**
```
┌──────────────────────┬────────┬──────────────────────┐
│ FIRMA Y SELLO        │        │ FIRMA Y SELLO        │
│ CLIENTE              │  (4)   │ TRANSPORTISTA        │
├──────────────────────┤        ├──────────────────────┤
│ [Imagen]             │        │ [Imagen]             │
│ firmaCliente         │        │ FirmaViajeConductor  │
├──────────────────────┤        ├──────────────────────┤
│ nombreCliente        │        │ nombreViajeConductor │
│ dniCliente           │        │ dniViajeConductor    │
└──────────────────────┴────────┴──────────────────────┘
```

**Campos:**
- `firmaCliente` - Firma Cliente (imagen)
- `nombreCliente`, `dniCliente` - Identificación Cliente
- `FirmaViajeConductor` - Firma Transportista (imagen)
- `nombreViajeConductor`, `dniViajeConductor` - Identificación Transportista

##### **Pie de Página Legal** (Siempre se muestra)

**Contenido:**
- Datos completos de la agencia
- Registro mercantil
- Aviso legal de protección de datos

### 🎨 Características Especiales Tipo T

1. **Bloques Repetitivos:** Cada viaje (carga/descarga) es un bloque
2. **Paginación Automática:** Inserta `page-break` cada 2 bloques
3. **Header Repetitivo:** Se inserta en cada página nueva
4. **Iconos Visuales:** 📥 para carga, 📤 para descarga
5. **Firmas por Viaje:** Cada viaje tiene sus propias firmas
6. **Footer Condicional:** Altura diferente para tipo E

---

## 🌐 Tipo Multimodal (M)

**Identificador:** `$tipoOrdenTransporte == 'M'`  
**Líneas:** 1920-2153  
**Formularios:** 6 (Admítase, Entréguese, Oficina, Transportista, Receptor, CMR)

### 🔍 Condición de Identificación

```php
<?php } else if ($tipoOrdenTransporte == 'M') { ?>
    <!-- CONTENIDO TIPO M -->
<?php } ?>
```

### 📐 Estructura del Formulario

#### **Header - Función PHP** (Líneas 1925-1969)

**Identificador:**
```php
function insertHeader($jsonDatos) {
    echo '<header>
```

**Estructura:** Idéntica al Tipo Terrestre (T)

Ver [Header Tipo Terrestre](#header---función-php-líneas-1655-1699) para detalles completos.

#### **Contenido - Información de Plataforma + Viajes** (Líneas 1976-2106)

##### **Sección Plataforma Inicial** (Línea 1976-1979)

**Identificador:**
```html
<div class="col-12">
    <p>LA PLATAFORMA SE RECOGE EN: <span>
```

**Campo:**
- `LUGAR_COMIENZO_NOMBRE` - Ubicación inicial de la plataforma

```
┌─────────────────────────────────────────────────────┐
│ LA PLATAFORMA SE RECOGE EN: LUGAR_COMIENZO_NOMBRE  │
└─────────────────────────────────────────────────────┘
<hr>
```

##### **Bloques de Viajes** (Líneas 1983-2103)

**Identificador del Loop:**
```php
echo "<div class='page'>";
foreach ($datosViajesBD as $viaje) {
    // Sistema de paginación
    if ($contador == 2) {
        echo "</div>";
        echo '<div class="page-break"></div>';
        insertHeader($jsonDatos);
        echo "<div class='page'>";
        $contador = 0;
    }
```

**Bloque CARGA** (Líneas 1999-2045)

**Identificador:**
```php
if ($viaje['tipoViaje'] == 'CARGA') {
```

**Header:**
```html
<div class="row bloqueOrden">
    <label class="bold col-12 tx-center">LUGARES DE CARGA 📥</label>
</div>
```

**Estructura de Campos:**

```
┌─────────────────────────────────────────────────────┐
│ LUGARES DE CARGA 📥                                 │
├──────────────────────┬──────────────────────────────┤
│ Empresa              │ Población                    │
│ LUGAR_NOMBRE         │ LUGAR_POBLACION              │
├──────────────────────┴──────────────────────────────┤
│ Dirección: LUGAR_DIRECCION                          │
├──────────────────────┬──────────────────────────────┤
│ Teléfono             │ C.P./PAIS                    │
│ LUGAR_TELEFONO       │ LUGAR_CP                     │
├──────────────────────┼──────────────────────────────┤
│ Fecha                │ Hora                         │
│ (comentado)          │ (comentado)                  │
├──────────────────────┼──────────────────────────────┤
│ Mercancia            │ Ref. carga                   │
│ MERCANCIA            │ CARGADOR_REF_CARGA           │
├──────────────────────┼──────────────────────────────┤
│ Firma Cliente        │ Identificación Cliente       │
│ [Imagen]             │ nombreViajeReceptor          │
│ FirmaViajeReceptor   │ dniViajeReceptor             │
├──────────────────────┼──────────────────────────────┤
│ Firma Transportista  │ Identificación               │
│ [Imagen]             │ Transportista                │
│ FirmaViajeConductor  │ nombreViajeConductor         │
│                      │ dniViajeConductor            │
└──────────────────────┴──────────────────────────────┘
```

**⚠️ Diferencias con Tipo T:**
- ❌ NO tiene: Bultos, Metros, Kilos
- ❌ NO tiene: Observaciones
- ❌ Fecha y Hora están comentados (vacíos)
- ✅ SÍ tiene: C.P./PAIS (en lugar de solo CP)
- ✅ Usa: `CARGADOR_REF_CARGA` del JSON principal (no del viaje)

**Campos:**
- `LUGAR_NOMBRE` - Empresa
- `LUGAR_POBLACION` - Población
- `LUGAR_DIRECCION` - Dirección
- `LUGAR_TELEFONO` - Teléfono
- `LUGAR_CP` - C.P./PAIS
- Fecha - (comentado, vacío)
- Hora - (comentado, vacío)
- `$jsonDatos['MERCANCIA']` - Mercancia
- `$jsonDatos['CARGADOR_REF_CARGA']` - Ref. carga (del JSON principal)
- `FirmaViajeReceptor` - Firma Cliente (imagen)
- `nombreViajeReceptor`, `dniViajeReceptor` - Identificación Cliente
- `FirmaViajeConductor` - Firma Transportista (imagen)
- `nombreViajeConductor`, `dniViajeConductor` - Identificación Transportista

**Bloque DESCARGA** (Líneas 2051-2100)

**Identificador:**
```php
} else {
```

**Header:**
```html
<div class="row bloqueOrden">
    <label class="bold col-12 tx-center">LUGARES DE DESCARGA 📤</label>
</div>
```

**Campos:** Idénticos al bloque de CARGA del Multimodal

##### **Sección Plataforma Final** (Líneas 2106-2108)

**Identificador:**
```html
<div class="col-12 mg-10">
    <p>LA PLATAFORMA SE DEJA EN:
```

**Campos:**
- `LUGAR_FIN_NOMBRE` - Ubicación final de la plataforma
- `LUGARES_DESCARGA[0]['LUGAR_IMPORTE']` - Precio acordado (opcional)

```
┌─────────────────────────────────────────────────────┐
│ LA PLATAFORMA SE DEJA EN: LUGAR_FIN_NOMBRE         │
│ Precio acordado: LUGAR_IMPORTE €                    │
└─────────────────────────────────────────────────────┘
```

#### **Footer** (Líneas 2110-2153)

**Estructura:** Idéntica al Tipo Terrestre (T)

Ver [Footer Tipo Terrestre](#footer-líneas-1870-1905) para detalles completos.

### 🎨 Características Especiales Tipo M

1. **Plataforma Origen/Destino:** Información adicional al inicio y final
2. **Precio Acordado:** Campo específico al final del documento
3. **Menos Campos por Viaje:** No incluye bultos, metros, kilos, observaciones
4. **Paginación:** Sistema igual que tipo T (cada 2 bloques)
5. **Header Repetitivo:** Se repite en cada página

### 🔄 Diferencias entre Tipo T y M

| Característica | Tipo T (Terrestre) | Tipo M (Multimodal) |
|----------------|-------------------|---------------------|
| **Header** | ✅ Idéntico | ✅ Idéntico |
| **Plataforma Inicio/Fin** | ❌ No | ✅ Sí |
| **Campos por Viaje** | 14 campos | 8 campos |
| **Bultos, Metros, Kilos** | ✅ Sí | ❌ No |
| **Observaciones Viaje** | ✅ Sí | ❌ No |
| **Fecha/Hora Viaje** | ✅ Mostrado | ❌ Comentado |
| **Ref. Carga** | Del viaje | Del JSON principal |
| **Precio Acordado** | ❌ No | ✅ Al final |
| **Footer** | ✅ Idéntico | ✅ Idéntico |

---

## 📜 CMR - Carta de Porte Internacional

**Identificador:** `$tipoDocumento == "CMR"`  
**Líneas:** 680-943  
**Aplicable a:** Tipo Terrestre (T) y Multimodal (M)

### 🔍 Condición de Identificación

```php
<?php if ($tipoDocumento == "CMR") { ?>
    <!-- CONTENIDO CMR -->
<?php } else { ?>
    <!-- CONTENIDO NORMAL (C, T, M) -->
<?php } ?>
```

⚠️ **IMPORTANTE:** El CMR tiene su propia estructura completamente independiente, se muestra ANTES de la lógica de tipos C, T, M.

### 📐 Estructura del Formulario CMR

#### **Estilos Específicos** (Líneas 682-689)

```css
.cmr-table { width: 100%; border-collapse: collapse; font-size: 9px; }
.cmr-table td { border: 1px solid #000; padding: 3px; vertical-align: top; }
.cmr-num { font-weight: bold; font-size: 11px; width: 20px; }
.cmr-label { color: #006400; font-size: 7px; line-height: 1.2; }
.cmr-data { font-size: 10px; padding-top: 2px; }
```

#### **Header del Documento** (Líneas 693-701)

```
┌─────────────────────────────────────┬─────────────┐
│ Ejemplar para el porteador          │ Nº Orden    │
│ Exemplaire pour le transporteur     │ $idOrden    │
│ Copy for the carrier                │             │
└─────────────────────────────────────┴─────────────┘
```

#### **Tabla CMR Principal** (Líneas 703-938)

##### **Sección 1-2: Remitente y Consignatario** (Líneas 704-739)

**Campo 1 - Remitente:**
```html
<td style="width: 45%;">
    <span class="cmr-num">1</span>
    <div class="cmr-label">Remitente (nombre, dirección, país)<br>
                           Expéditeur (nom, adresse, pays)<br>
                           Sender (name, address, country)</div>
</td>
```

**Campo 2 - Consignatario:**
```html
<span class="cmr-num">2</span>
<div class="cmr-label">Consignatario (nombre, dirección, país)<br>
                       Destinataire (nom, adresse, pays)<br>
                       Consignee (name, address, country)</div>
```

**Título Central:**
```
┌────────────────────────────────────────────┐
│ CARTA DE PORTE INTERNACIONAL               │
│ LETTRE DE VOITURE INTERNATIONALE           │
│ INTERNATIONAL CONSIGNMENT NOTE             │
├────────────────────────────────────────────┤
│ Texto del Convenio CMR (3 idiomas)        │
└────────────────────────────────────────────┘
```

##### **Sección 3: Lugar de Entrega** (Líneas 742-755)

**Campo 3:**
```html
<span class="cmr-num">3</span>
<div class="cmr-label">Lugar de entrega de la mercancía (lugar, país)<br>
                       Lieu prévu pour la livraison de la marchandise (lieu, pays)<br>
                       Place of delivery of the goods (place, country)</div>
```

**Datos:**
```php
$lugar_desc = $jsonDatos['CMR'][0]['LUGAR_DESCARGA'];
- LUGAR_COD - LUGAR_NOMBRE
- LUGAR_DIRECCION
- LUGAR_CP - LUGAR_POBLACION (LUGAR_PROVINCIA)
- LUGAR_PAIS
```

##### **Sección 4: Lugar de Carga** (Líneas 779-792)

**Campo 4:**
```html
<span class="cmr-num">4</span>
<div class="cmr-label">Lugar y fecha de carga de la mercancía (lugar, país, fecha)<br>
                       Lieu et date de la prise en charge de la marchandise (lieu, pays, date)<br>
                       Place and date of taking over the goods (place, country, date)</div>
```

**Datos:**
```php
$lugar_carga = $jsonDatos['CMR'][0]['LUGAR_CARGA'];
- LUGAR_COD - LUGAR_NOMBRE
- LUGAR_DIRECCION
- LUGAR_CP - LUGAR_POBLACION (LUGAR_PROVINCIA)
- LUGAR_PAIS
```

##### **Sección 5: Documentos Anexos** (Líneas 796-801)

**Campo 5:**
```html
<span class="cmr-num">5</span>
<div class="cmr-label">Documentos anexos<br>
                       Documents annexés<br>
                       Documents attached</div>
```

##### **Sección 16-17: Porteador** (Líneas 757-776)

**Campo 16:**
```html
<span class="cmr-num">16</span>
<div class="cmr-label">Porteador (nombre, dirección, país)<br>
                       Transporteur (nom, adresse, pays)<br>
                       Carrier (name, address, country)</div>
```

**Campo 17:**
```html
<span class="cmr-num">17</span>
<div class="cmr-label">Porteadores sucesivos (nombre, dirección, país)<br>
                       Transporteurs successifs (nom, adresse, pays)<br>
                       Successive carriers (name, address, country)</div>
```

**Datos:**
```php
$jsonDatos['CMR'][0]['TRACTORA'] - $jsonDatos['CMR'][0]['PLATAFORMA']
```

##### **Sección 6-12: Descripción de Mercancías** (Líneas 805-859)

**Tabla de Campos:**

| Nº | Campo (ES/FR/EN) | Dato PHP |
|----|------------------|----------|
| 6 | Marcas y números / Marques et numéros / Marks and Nos. | (vacío) |
| 7 | Número de bultos / Nombre de colis / Number of packages | `LUGAR_BULTOS_DESCARGA` |
| 8 | Clase de embalaje / Mode d'emballage / Method of packing | (vacío) |
| 9 | Naturaleza de la mercancía / Nature de la marchandise / Nature of the goods | `LUGAR_MERCANCIA_DESCARGA` |
| 10 | Nº estadístico / No. statistique / Statistical No. | (vacío) |
| 11 | Peso bruto, kg / Poids brut, kg / Gross weight, kg | `LUGAR_KILOS_DESCARGA` |
| 12 | Volumen m³ / Cubage m³ / Volume m³ | (vacío) |

**Estructura Visual:**
```
┌────┬─────┬──────┬───────────┬─────┬──────┬────────┐
│ 6  │  7  │  8   │     9     │ 10  │  11  │   12   │
│Mar-│Bul- │Emba- │Naturaleza │Est- │Peso  │Volumen │
│cas │tos  │laje  │Mercancía  │adís-│bruto │  m³    │
│    │     │      │           │tico │  kg  │        │
└────┴─────┴──────┴───────────┴─────┴──────┴────────┘
```

##### **Sección 13: Instrucciones del Remitente** (Líneas 864-869)

**Campo 13:**
```html
<span class="cmr-num">13</span>
<div class="cmr-label">Instrucciones del remitente<br>
                       Instructions de l'expéditeur<br>
                       Sender's instructions</div>
```

##### **Sección 14: Forma de Pago** (Líneas 874-883)

**Campo 14:**
```html
<span class="cmr-num">14</span>
<div class="cmr-label">Forma de pago<br>
                       Prescriptions d'affranchissement<br>
                       Instructions as to payment for carriage</div>
```

**Opciones (checkboxes):**
- ☐ Porte pagado / Franco / Carriage paid
- ☐ Porte debido / Non franco / Carriage forward

##### **Sección 15: Reembolso** (Líneas 888-893)

**Campo 15:**
```html
<span class="cmr-num">15</span>
<div class="cmr-label">Reembolso<br>
                       Remboursement<br>
                       Cash on delivery</div>
```

##### **Sección 19-20: Estipulaciones y Pagos** (Líneas 870-916)

**Campo 19 - Estipulaciones particulares:**
```html
<span class="cmr-num">19</span>
<div class="cmr-label">Estipulaciones particulares<br>
                       Conventions particulières<br>
                       Special agreements</div>
```

**Campo 20 - Tabla de Pagos:**

```
┌──────────────────────┬─────────┬────────┬─────────────┐
│ A pagar por /        │Remitente│Moneda  │Consignatario│
│ To be paid by        │Sender   │Currency│Consignee    │
├──────────────────────┼─────────┼────────┼─────────────┤
│ Precio del transporte│         │        │             │
│ Carriage charges     │         │        │             │
├──────────────────────┼─────────┼────────┼─────────────┤
│ Suplementos          │         │        │             │
│ Supplements          │         │        │             │
├──────────────────────┼─────────┼────────┼─────────────┤
│ Gastos accesorios    │         │        │             │
│ Other charges        │         │        │             │
├──────────────────────┼─────────┼────────┼─────────────┤
│ Total                │         │        │             │
└──────────────────────┴─────────┴────────┴─────────────┘
```

##### **Sección 21: Lugar y Fecha** (Líneas 896-901)

**Campo 21:**
```html
<span class="cmr-num">21</span>
<div class="cmr-label">Formalizado en _________________ a ______________<br>
                       Établi à _________________ le ______________<br>
                       Established in _________________ on ______________</div>
```

##### **Sección 22-23: Firmas Remitente y Transportista** (Líneas 905-916)

**Campo 22:**
```html
<span class="cmr-num">22</span>
<div class="cmr-label">Firma y sello del remitente<br>
                       Signature et timbre de l'expéditeur<br>
                       Signature and stamp of the sender</div>
```

**Campo 23:**
```html
<span class="cmr-num">23</span>
<div class="cmr-label">Firma y sello del transportista<br>
                       Signature et timbre du transporteur<br>
                       Signature and stamp of the carrier</div>
```

##### **Sección 18-24: Observaciones y Recepción** (Líneas 921-937)

**Campo 18 - Reservas del Porteador:**
```html
<span class="cmr-num">18</span>
<div class="cmr-label">Reservas y observaciones del porteador<br>
                       Réserves et observations du transporteur<br>
                       Carrier's reservations and observations</div>
```

**Campo 24 - Recibo de Mercancía:**
```html
<span class="cmr-num">24</span>
<div class="cmr-label">Recibo de la mercancía<br>
                       Marchandises reçues<br>
                       Goods received<br><br>
                       Lugar _________________ a ______________<br>
                       Signature et timbre du destinataire<br>
                       Signature and stamp of the consignee</div>
```

### 🎨 Características Especiales CMR

1. **Formato Internacional:** Textos en 3 idiomas (Español, Francés, Inglés)
2. **Numeración Oficial:** 24 campos numerados según estándar CMR
3. **Estilo Compacto:** Fuentes pequeñas para caber en A4
4. **Bordes Completos:** Tabla con todos los bordes visibles
5. **Color Verde:** Etiquetas en color verde (#006400) para destacar
6. **Datos desde CMR[0]:** Usa estructura `$jsonDatos['CMR'][0]`
7. **Campos Vacíos:** Muchos campos en blanco para rellenar manualmente
8. **Page Break:** `page-break-after: always;` garantiza página completa

### 📊 Fuente de Datos CMR

**Estructura JSON:**
```php
$jsonDatos['CMR'][0] = [
    'LUGAR_CARGA' => [
        'LUGAR_COD',
        'LUGAR_NOMBRE',
        'LUGAR_DIRECCION',
        'LUGAR_CP',
        'LUGAR_POBLACION',
        'LUGAR_PROVINCIA',
        'LUGAR_PAIS'
    ],
    'LUGAR_DESCARGA' => [
        'LUGAR_COD',
        'LUGAR_NOMBRE',
        'LUGAR_DIRECCION',
        'LUGAR_CP',
        'LUGAR_POBLACION',
        'LUGAR_PROVINCIA',
        'LUGAR_PAIS',
        'LUGAR_BULTOS_DESCARGA',
        'LUGAR_MERCANCIA_DESCARGA',
        'LUGAR_KILOS_DESCARGA'
    ],
    'TRACTORA',
    'PLATAFORMA'
];
```

---

## 📏 Tamaños de Impresión

### 🖨️ Configuración de Página

**Formato:** A4 Vertical (210mm x 297mm)  
**Mínimo:** 1 página A4 por formulario  
**Orientación:** Portrait (Vertical)

### 📐 Márgenes y Padding

#### Tipo Contenedor (C)

```css
/* Padding general */
.container-fluid { padding: 15px; }

/* Formulario principal */
.form-layout { 
    min-height: 297mm; /* A4 vertical completo */
}

/* Espaciado entre bloques */
.form-group { margin-bottom: 1rem; }
```

**Tamaño estimado:** 1-2 páginas A4
- Sin viajes: 1 página
- Con tabla de viajes completa: hasta 2 páginas

#### Tipo Terrestre (T) y Multimodal (M)

```css
/* Página completa */
.page {
    min-height: 297mm;
    page-break-after: always;
}

/* Header */
header { height: auto; min-height: 8cm; }

/* Footer */
footer { 
    height: 5cm; /* Normal */
    height: 4cm; /* Para tipo E en Multimodal */
}

/* Contenido */
#contenido { 
    min-height: calc(297mm - 8cm - 5cm); 
}
```

**Sistema de Paginación:**
- **Header:** ~8cm por página
- **Contenido:** Variable según número de viajes
- **Footer:** 4-5cm
- **Salto de Página:** Cada 2 bloques de viaje

**Tamaño estimado:**
- 1-2 viajes: 1 página
- 3-4 viajes: 2 páginas
- 5-6 viajes: 3 páginas

#### CMR

```css
/* Contenedor principal */
div[style*="padding: 10mm"] {
    padding: 10mm;
    page-break-after: always;
}

/* Tabla CMR */
.cmr-table {
    width: 100%;
    font-size: 9px;
}
```

**Tamaño:** Exactamente 1 página A4 (garantizado por `page-break-after`)

### 🎨 Media Queries de Impresión

```css
@media print {
    /* Ocultar elementos no imprimibles */
    .no-print { display: none !important; }
    
    /* Forzar saltos de página */
    .page-break { page-break-before: always; }
    
    /* Ajustar tamaños de fuente */
    body { font-size: 10pt; }
    
    /* Eliminar márgenes del navegador */
    @page {
        margin: 0;
        size: A4 portrait;
    }
}
```

### 📊 Tabla Resumen de Tamaños

| Formulario | Páginas Min | Páginas Max | Factores Variables |
|------------|-------------|-------------|-------------------|
| **Contenedor - Cliente** | 1 | 2 | Número de lugares |
| **Contenedor - Oficina** | 1 | 2 | Número de lugares |
| **Contenedor - Receptor** | 1 | 1 | Viaje específico |
| **Terrestre - Admítase** | 1 | ∞ | Número de viajes |
| **Terrestre - Entréguese** | 1 | ∞ | Número de viajes + firmas finales |
| **Terrestre - Oficina** | 1 | ∞ | Número de viajes |
| **Terrestre - Transportista** | 1 | ∞ | Número de viajes |
| **Terrestre - Receptor** | 1 | 1 | Viaje específico |
| **Terrestre - CMR** | 1 | 1 | Fijo |
| **Multimodal - (todos)** | 1 | ∞ | Igual que Terrestre |

**Cálculo de páginas (T y M):**
```
Páginas = ceil(número_viajes / 2)
```

Cada 2 viajes (carga o descarga) = 1 página

---

## 🔧 Cómo Modificar un Formulario

### 📍 Paso 1: Identificar el Tipo de Orden

**Buscar la condición principal:**

```php
// Línea 680 - Primero verifica si es CMR
if ($tipoDocumento == "CMR") {
    // Código CMR (líneas 680-943)
}

// Línea 947 - Luego verifica tipo de orden
if ($tipoOrdenTransporte == 'C') {
    // Código Contenedor (líneas 947-1640)
} else if ($tipoOrdenTransporte == 'T') {
    // Código Terrestre (líneas 1650-1905)
} else if ($tipoOrdenTransporte == 'M') {
    // Código Multimodal (líneas 1920-2153)
}
```

### 📍 Paso 2: Identificar el Tipo de Documento

**Dentro de cada tipo, buscar condiciones por tipoDocumento:**

```php
// Para mostrar/ocultar secciones
if ($tipoDocumento != 'A' && $tipoDocumento != 'E') {
    // Esta sección NO se muestra en Admítase ni Entréguese
}

if ($tipoDocumento == 'A') {
    // Contenido específico ADMÍTASE
} elseif ($tipoDocumento == 'E') {
    // Contenido específico ENTRÉGUESE
}
```

### 📍 Paso 3: Identificar la Sección Específica

#### Para Tipo Contenedor (C):

**Usar comentarios como guía:**
```html
<!-- UN ROW -->
<div class="col-12">
    <!-- AQUÍ ESTÁ TU SECCIÓN -->
</div>
<!-- FIN ROW -->
```

**O buscar por etiquetas:**
```html
<label class="form-control-label tx-bold mr-2">Agente:</label>
```

#### Para Tipo Terrestre (T) y Multimodal (M):

**Buscar por función:**
```php
function insertHeader($jsonDatos) {
    // Modificar header
}
```

**Buscar por tipo de viaje:**
```php
if ($viaje['tipoViaje'] == 'CARGA') {
    // Modificar bloque de carga
} else {
    // Modificar bloque de descarga
}
```

**Buscar por etiquetas visuales:**
```html
<label class="bold col-12 tx-center">LUGARES DE CARGA 📥</label>
```

#### Para CMR:

**Buscar por número de campo:**
```html
<span class="cmr-num">13</span>
<div class="cmr-label">Instrucciones del remitente<br>
```

### 📍 Paso 4: Identificar Campos Individuales

**Buscar el nombre del campo en PHP:**
```php
<?php echo $jsonDatos['CAMPO_A_MODIFICAR']; ?>
```

**O en inputs:**
```html
<input class="form-control" type="text" readonly 
       name="nombreCampo" 
       value="<?php echo $jsonDatos['CAMPO']; ?>">
```

### 🛠️ Ejemplos de Modificación

#### Ejemplo 1: Cambiar texto de etiqueta en Contenedor

**Ubicación:** Bloque 2, Línea 1038

**Antes:**
```html
<label class="form-control-label mg-l-5 tx-bold mr-2 mg-t-7">Agente:</label>
```

**Después:**
```html
<label class="form-control-label mg-l-5 tx-bold mr-2 mg-t-7">Consignatario:</label>
```

#### Ejemplo 2: Agregar campo nuevo en Terrestre - CARGA

**Ubicación:** Línea 1760 (después de Kilos)

**Código a insertar:**
```html
<div class="col-6">
    <p>Campo Nuevo: <span style="font-weight: normal"><?php echo $viaje['CAMPO_NUEVO']; ?></span></p>
</div>
```

#### Ejemplo 3: Ocultar sección de temperaturas en Contenedor

**Ubicación:** Líneas 1155-1169

**Opción A - Comentar:**
```php
<?php /* 
<div class="row mg-5">
    <div class="col-12 col-sm-4 form-inline">
        <label>Temp. Max:</label>
        ...
    </div>
</div>
*/ ?>
```

**Opción B - Condición:**
```php
<?php if (false) { // Nunca se mostrará ?>
<div class="row mg-5">
    ...
</div>
<?php } ?>
```

#### Ejemplo 4: Cambiar orden de campos en CMR

**Ubicación:** Líneas 805-859 (Tabla de mercancías)

**Para intercambiar columnas 7 y 11:**

1. Localizar td de columna 7 (Bultos)
2. Localizar td de columna 11 (Peso)
3. Intercambiar el contenido completo de ambos `<td>`

#### Ejemplo 5: Modificar footer solo para tipo OFICINA

**Ubicación:** Línea 1897 (Terrestre/Multimodal)

**Código:**
```php
<?php if ($tipoDocumento == "O") { ?>
    <div class="mg-t-20">
        <!-- Contenido específico para OFICINA -->
    </div>
<?php } ?>
```

### 🔍 Herramientas de Búsqueda

#### Búsqueda por Tipo de Documento

| Buscar | Para encontrar |
|--------|----------------|
| `if ($tipoDocumento ==` | Condiciones específicas por tipo |
| `$headerText` | Texto del encabezado |
| `!= 'A' && != 'E'` | Secciones ocultas en Admítase/Entréguese |

#### Búsqueda por Campo de Datos

| Buscar | Para encontrar |
|--------|----------------|
| `$jsonDatos['NOMBRE_CAMPO']` | Uso del campo en el formulario |
| `$viaje['NOMBRE_CAMPO']` | Campos de viajes (T y M) |
| `$datosOrden['campo']` | Datos de firma/receptor |

#### Búsqueda por Sección Visual

| Buscar | Para encontrar |
|--------|----------------|
| `tx-bold` | Etiquetas en negrita |
| `borde-gris` | Secciones con bordes |
| `col-6` | Columnas de 6/12 (50%) |
| `form-inline` | Campos en línea |
| `bloqueOrden` | Bloques de viajes (T y M) |

### ⚠️ Precauciones al Modificar

1. **No modificar PHP sin cerrar correctamente:**
   ```php
   <?php echo "correcto"; ?>
   <?php echo "correcto" // ❌ FALTA ; ?>
   ```

2. **Mantener estructura de divs:**
   ```html
   <div class="col-6">
       <!-- Contenido -->
   </div> <!-- ✅ Cerrar siempre -->
   ```

3. **Respetar saltos de página en T y M:**
   ```php
   if ($contador == 2) {
       echo '<div class="page-break"></div>';
       // ⚠️ No modificar esta lógica
   }
   ```

4. **Verificar que campos existan:**
   ```php
   <?php echo isset($campo) ? $campo : ''; ?>
   // ✅ Evita errores si campo no existe
   ```

5. **Mantener clases CSS:**
   ```html
   <div class="col-12"> <!-- ⚠️ No quitar clases de Bootstrap -->
   ```

### 🧪 Testing de Modificaciones

**Checklist después de modificar:**

- [ ] El formulario se ve correctamente en pantalla
- [ ] La impresión ocupa mínimo 1 página A4
- [ ] No hay errores PHP en logs
- [ ] Los datos se muestran correctamente
- [ ] Las condiciones por tipo funcionan
- [ ] El footer aparece en todas las páginas (T y M)
- [ ] Los saltos de página funcionan correctamente
- [ ] Las firmas se muestran si existen

---

## 📚 Referencia Rápida

### Archivos Relacionados

| Archivo | Función |
|---------|---------|
| `view/Transportes/orden.php` | **Generación de todos los formularios** |
| `view/Transportes/modalTipoDocumentoExport.php` | Modal selección tipo C |
| `view/Transportes/modalTipoDocumentoExportTM.php` | Modal selección tipos T/M |
| `view/Transportes/index.js` | Controlador JS impresión |
| `models/Transportes.php` | Modelo de datos |
| `public/css/styleOrder.css` | Estilos de impresión |

### Variables Clave

| Variable | Descripción |
|----------|-------------|
| `$tipoOrdenTransporte` | 'C', 'T', o 'M' |
| `$tipoDocumento` | 'E', 'O', 'X'/'C', 'A', 'T', 'CMR' |
| `$jsonDatos` | Array con todos los datos de la orden |
| `$datosViajesBD` | Array de viajes (solo T y M) |
| `$datosOrden` | Datos adicionales (firmas, etc.) |
| `$headerText` | Texto del encabezado según tipo |
| `$idOrden` | Número de orden |
| `$tokenOrden` | Token único de la orden |

### Funciones Auxiliares

| Función | Uso |
|---------|-----|
| `transformarFecha()` | Formatear fechas |
| `transformarFechaVacia()` | Formatear fechas permitiendo vacío |
| `insertHeader()` | Generar header (solo T y M) |

---

## 📞 Soporte

Para modificaciones complejas o dudas:
1. Revisar este documento
2. Buscar en el código por el identificador específico
3. Probar en entorno de desarrollo
4. Verificar impresión en PDF

---

**Última actualización:** 27 de enero de 2026  
**Mantenedor:** Sistema Logística Leader Transport  
**Versión del documento:** 1.0
