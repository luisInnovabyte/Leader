# Formulario Tipo C - OFICINA

**Tipo de Orden:** Contenedor (Marítimo)  
**Tipo de Documento:** OFICINA  
**Parámetros:** `tipoDocumento=O` & `tipoOrdenTransporte=C`

---

## 📋 Vista del Documento Impreso

```
╔═══════════════════════════════════════════════════════════════════════════════╗
║                                                                               ║
║  ┌─────────────────────────────┬────────────────────────┬──────────────────┐ ║
║  │  ORDEN DE TRANSPORTE        │  [AGENCIA_NOMBRE]      │                  │ ║
║  │                             │  [AGENCIA_DIRECCION]   │                  │ ║
║  │                             │  Tel: [AGENCIA_TELEFONO│    [QR CODE]     │ ║
║  │      OFICINA                │  Fax: 963674717        │                  │ ║
║  │                             │  [AGENCIA_CP]-         │                  │ ║
║  │                             │  [AGENCIA_POBLACION]   │                  │ ║
║  │                             │  ([AGENCIA_PROVINCIA]) │                  │ ║
║  │                             │  [AGENCIA_CIF]         │                  │ ║
║  └─────────────────────────────┴────────────────────────┴──────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ F. Carga: [TTE_FECHA_CARGA]  │ Hora: [TTE_HORA_CARGA]                   │ ║
║  │ Ref. Consig: [TTE_REF_CONSIG]                                            │ ║
║  │                                                                           │ ║
║  │ Recogida estimada: [TTE_FECHA_ESTIMADA_RECOGIDA]                         │ ║
║  │ Entrega estimada: [TTE_FECHA_ESTIMADA_ENTREGA]                           │ ║
║  │ OT Agencia: [TTE_ORDEN]                                                  │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────┬────────────────────────────────────┐ ║
║  │ Agente: [CONSIGNATARIO]             │ TRANSPORTISTA                     │ ║
║  │─────────────────────────────────────│ [TRANSPORTISTA_NOMBRE]            │ ║
║  │ Contenedores: [contenedorActivo]    │ [TRANSPORTISTA_DIRECCION]         │ ║
║  │ Tipo: [TIPO_CONT_DESC]              │ [TRANSPORTISTA_CP]                │ ║
║  │ Hlog Precintos: [precintoActivo]    │ [TRANSPORTISTA_POBLACION]         │ ║
║  │                                     │ [TRANSPORTISTA_PROVINCIA]         │ ║
║  │                                     │ [TRANSPORTISTA_NIF]               │ ║
║  │                                     │                                   │ ║
║  │                                     │ CONDUCTOR                         │ ║
║  │                                     │ [CONDUCTOR_NOMBRE]                │ ║
║  │                                     │ [CONDUCTOR_NIF]                   │ ║
║  │                                     │                                   │ ║
║  │                                     │ CABEZA                            │ ║
║  │                                     │ [TRACTORA]                        │ ║
║  │                                     │ Plataforma: [PLATAFORMA]          │ ║
║  └──────────────────────────────────────┴────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────┬────────────────────────────────────┐ ║
║  │ RETIRAR DE:                         │ ENTREGAR EN:                      │ ║
║  │ [RECOGER_EN_NOMBRE]                 │ [DEVOLVER_EN_NOMBRE]              │ ║
║  │ [RECOGER_EN_DIRECCION]              │ [DEVOLVER_EN_DIRECCION]           │ ║
║  │ [RECOGER_EN_CP]                     │ [DEVOLVER_EN_CP]                  │ ║
║  │ [RECOGER_EN_POBLACION]              │ [DEVOLVER_EN_POBLACION]           │ ║
║  │ [RECOGER_EN_PROVINCIA]              │ [DEVOLVER_EN_PROVINCIA]           │ ║
║  └──────────────────────────────────────┴────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ Mercancía: [MERCANCIA]                                                   │ ║
║  │ Bultos: [BULTOS]                                                         │ ║
║  │ Peso: [PESO_MERCANCIA] kg                                                │ ║
║  │─────────────────────────────────────────────────────────────────────────│ ║
║  │ Temp. Max: [TEMP_MAXIMA]  │  Temp. Mín: [TEMP_MINIMA]                   │ ║
║  │ Conectar: [TEMP_CONECTAR]                                                │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────┬────────────────────────────────────┐ ║
║  │ EXTRAS DIMENSIONALES                │ DATOS IMO / ONU                   │ ║
║  │─────────────────────────────────────│───────────────────────────────────│ ║
║  │ Ext. Der:    [EXTRA_RIGHT]          │ ONU:        [IMO_ONU]             │ ║
║  │ Ext. Izq:    [EXTRA_LEFT]           │ Versión:    [IMO_VERSION]         │ ║
║  │ Ext. Front:  [EXTRA_FRONT]          │ IMDG:       [IMO_PAGINA]          │ ║
║  │ Ext. Tras:   [EXTRA_BACK]           │ Clase:      [IMO_CLASE]           │ ║
║  │ Ext. Altura: [EXTRA_ALTO]           │ Notif Apv:  [IMO_PORT_NOTIFICATION│ ║
║  └──────────────────────────────────────┴────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────┬────────────────────────────────────┐ ║
║  │ DATOS MARÍTIMOS                     │ PUERTOS                           │ ║
║  │─────────────────────────────────────│───────────────────────────────────│ ║
║  │ Línea:                              │ Origen:                           │ ║
║  │ [NOMBRELINEA_DEST]                  │ [PUERTO_ORIGEN_NOMBRE]            │ ║
║  │                                     │                                   │ ║
║  │ Nº Escala:                          │ Destino:                          │ ║
║  │ [ESCALA_DEST]                       │ [PUERTO_DESTINO_NOMBRE]           │ ║
║  │                                     │                                   │ ║
║  │ Buque:                              │ Pto. Des/carga:                   │ ║
║  │ [BUQUE_DEST]                        │ [PUERTO_DESCARGA_NOMBRE]          │ ║
║  │                                     │                                   │ ║
║  │ Viaje:                              │ Tipo Orden:                       │ ║
║  │ [VIAJE]                             │ [PUERTO_TIPO_ORDEN_IMPORTACION]   │ ║
║  │                                     │                                   │ ║
║  │ Dist. Llamada:                      │                                   │ ║
║  │ [DISTINTIVO_LLAMADA]                │                                   │ ║
║  └──────────────────────────────────────┴────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────────────────────────────────────────┐ ║
║  │ Ref Carga: [CARGADOR_REF_CARGA]     │ Cargador: [CARGADOR_NOMBRE]      │ ║
║  └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌──────────────────────────────────────────────────────────────────────────┐ ║
║  │ Pif/Aduana: [PIF_NOMBRE]            │ [CARGADOR_NOMBRE]                │ ║
║  │                                     │ [CARGADOR_CIF]                   │ ║
║  │                                     │ [CARGADOR_DIRECCION]             │ ║
║  │                                     │ [CARGADOR_POBLACION]             │ ║
║  │                                     │ [CARGADOR_PROVINCIA]             │ ║
║  └──────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ Lugares Carga/Descarga:                                                  │ ║
║  │                                                                           │ ║
║  │ ┌────────────┬──────────────┬─────┬────────────┬───────────┬──────────┐ │ ║
║  │ │ Lugar      │ Dirección    │ CP  │ Población  │ Provincia │ Telf:    │ │ ║
║  │ ├────────────┼──────────────┼─────┼────────────┼───────────┼──────────┤ │ ║
║  │ │ [LUGAR_    │ [LUGAR_      │[LU- │ [LUGAR_    │ [LUGAR_   │ [LUGAR_  │ │ ║
║  │ │  NOMBRE]   │  DIRECCION]  │GAR_ │  POBLACION]│  PROVINCIA│  TELEFONO│ │ ║
║  │ │            │              │CP]  │            │  ]        │  ]       │ │ ║
║  │ ├────────────┼──────────────┼─────┼────────────┼───────────┼──────────┤ │ ║
║  │ │ ...        │ ...          │ ... │ ...        │ ...       │ ...      │ │ ║
║  │ └────────────┴──────────────┴─────┴────────────┴───────────┴──────────┘ │ ║
║  │                                                                           │ ║
║  │ * Fuente de datos: $jsonDatos['LUGARES'] (array)                         │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ FIRMA Y SELLO LEADER:          │ FIRMA Y SELLO CLIENTE:                  │ ║
║  │ [Si existe firma]              │ [Si existe firma]                       │ ║
║  │ [FirmaViajeConductor]          │ [FirmaViajeReceptor]                    │ ║
║  │ (imagen)                       │ (imagen)                                │ ║
║  │                                │                                         │ ║
║  │ [nombreViajeConductor]         │ [nombreViajeReceptor]                   │ ║
║  │ [dniViajeConductor]            │ [dniViajeReceptor]                      │ ║
║  └────────────────────────────────┴─────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ Observaciones:                                                           │ ║
║  │ BOOKING Nº: [PCS_BOOKING_NUMBER] - [OBSERVACIONES]                      │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ Fecha Emisión: [fecha actual formateada]                                 │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
║  ┌───────────────────────────────────────────────────────────────────────────┐ ║
║  │ [Texto legal RGPD - en letra pequeña]                                    │ ║
║  │ Los datos recogido en esta Orden de Tranposte son totalmente             │ ║
║  │ confidenciales y queda prohibido su uso no autorizado...                 │ ║
║  └───────────────────────────────────────────────────────────────────────────┘ ║
║                                                                               ║
╚═══════════════════════════════════════════════════════════════════════════════╝
```

---

## 📝 Detalle de Campos por Sección

### 1. CABECERA

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| ORDEN DE TRANSPORTE | - | Texto fijo | Título principal |
| OFICINA | - | Texto fijo | Tipo de documento |
| - | `AGENCIA_NOMBRE` | string | Nombre de la agencia |
| - | `AGENCIA_DIRECCION` | string | Dirección completa |
| Tel: | `AGENCIA_TELEFONO` | string | Teléfono |
| Fax: | - | string | Fijo: 963674717 |
| - | `AGENCIA_CP` | string | Código postal |
| - | `AGENCIA_POBLACION` | string | Población |
| - | `AGENCIA_PROVINCIA` | string | Provincia (entre paréntesis) |
| - | `AGENCIA_CIF` | string | CIF de la agencia |
| [QR CODE] | `OA_PCS_LOCATOR` | QR | Código QR generado |

### 2. DATOS GENERALES

| Label | Campo JSON/Variable | Tipo | Observaciones |
|-------|---------------------|------|---------------|
| F. Carga: | `TTE_FECHA_CARGA` | date | Formato: d-m-Y |
| Hora: | `TTE_HORA_CARGA` | time | Formato: HH:mm |
| Ref. Consig: | `TTE_REF_CONSIG` | string | Referencia consignatario |
| Recogida estimada: | `TTE_FECHA_ESTIMADA_RECOGIDA` | date | Formato: d-m-Y |
| Entrega estimada: | `TTE_FECHA_ESTIMADA_ENTREGA` | date | Formato: d-m-Y |
| OT Agencia: | `TTE_ORDEN` | string | Número de orden |

### 3. AGENTE Y CONTENEDORES

| Label | Campo JSON/Variable | Tipo | Observaciones |
|-------|---------------------|------|---------------|
| Agente: | `CONSIGNATARIO` | string | Nombre del consignatario |
| Contenedores: | `contenedorActivo` | string | Variable PHP (BD) |
| Tipo: | `TIPO_CONT_DESC` | string | Descripción tipo contenedor |
| Hlog Precintos: | `precintoActivo` | string | Variable PHP (BD) |

### 4. TRANSPORTISTA Y CONDUCTOR

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| TRANSPORTISTA | - | Texto fijo | Título |
| - | `TRANSPORTISTA_NOMBRE` | string | Nombre completo |
| - | `TRANSPORTISTA_DIRECCION` | string | Dirección |
| - | `TRANSPORTISTA_CP` | string | Código postal |
| - | `TRANSPORTISTA_POBLACION` | string | Población |
| - | `TRANSPORTISTA_PROVINCIA` | string | Provincia |
| - | `TRANSPORTISTA_NIF` | string | NIF/CIF |
| CONDUCTOR | - | Texto fijo | Título |
| - | `CONDUCTOR_NOMBRE` | string | Nombre conductor |
| - | `CONDUCTOR_NIF` | string | DNI conductor |
| CABEZA | - | Texto fijo | Título |
| - | `TRACTORA` | string | Matrícula tractora |
| Plataforma: | `PLATAFORMA` | string | Matrícula plataforma |

### 5. LUGARES DE RECOGIDA Y ENTREGA

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| **RETIRAR DE:** | - | Texto fijo | Título |
| - | `RECOGER_EN_NOMBRE` | string | Nombre lugar |
| - | `RECOGER_EN_DIRECCION` | string | Dirección |
| - | `RECOGER_EN_CP` | string | Código postal |
| - | `RECOGER_EN_POBLACION` | string | Población |
| - | `RECOGER_EN_PROVINCIA` | string | Provincia |
| **ENTREGAR EN:** | - | Texto fijo | Título |
| - | `DEVOLVER_EN_NOMBRE` | string | Nombre lugar |
| - | `DEVOLVER_EN_DIRECCION` | string | Dirección |
| - | `DEVOLVER_EN_CP` | string | Código postal |
| - | `DEVOLVER_EN_POBLACION` | string | Población |
| - | `DEVOLVER_EN_PROVINCIA` | string | Provincia |

### 6. MERCANCÍA

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Mercancía: | `MERCANCIA` | string | Descripción mercancía |
| Bultos: | `BULTOS` | int | Cantidad de bultos |
| Peso: | `PESO_MERCANCIA` | decimal | Peso en kg |
| Temp. Max: | `TEMP_MAXIMA` | decimal | Temperatura máxima |
| Temp. Mín: | `TEMP_MINIMA` | decimal | Temperatura mínima |
| Conectar: | `TEMP_CONECTAR` | string | Instrucción conexión |

### 7. EXTRAS DIMENSIONALES

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Ext. Der: | `EXTRA_RIGHT` | decimal | Extensión derecha |
| Ext. Izq: | `EXTRA_LEFT` | decimal | Extensión izquierda |
| Ext. Front: | `EXTRA_FRONT` | decimal | Extensión frontal |
| Ext. Tras: | `EXTRA_BACK` | decimal | Extensión trasera |
| Ext. Altura: | `EXTRA_ALTO` | decimal | Extensión altura |

### 8. DATOS IMO / ONU (Mercancía Peligrosa)

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| ONU: | `IMO_ONU` | string | Código ONU |
| Versión: | `IMO_VERSION` | string | Versión normativa |
| IMDG: | `IMO_PAGINA` | string | Página IMDG |
| Clase: | `IMO_CLASE` | string | Clase de peligrosidad |
| Notif Apv: | `IMO_PORT_NOTIFICATION` | string | Notificación puerto |

### 9. DATOS MARÍTIMOS

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Línea: | `NOMBRELINEA_DEST` | string | Línea naviera (textarea) |
| Nº Escala: | `ESCALA_DEST` | string | Número de escala |
| Buque: | `BUQUE_DEST` | string | Nombre del buque |
| Viaje: | `VIAJE` | string | Número de viaje |
| Dist. Llamada: | `DISTINTIVO_LLAMADA` | string | Distintivo de llamada |

### 10. PUERTOS

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Origen: | `PUERTO_ORIGEN_NOMBRE` | string | Puerto de origen |
| Destino: | `PUERTO_DESTINO_NOMBRE` | string | Puerto de destino |
| Pto. Des/carga: | `PUERTO_DESCARGA_NOMBRE` | string | Puerto descarga |
| Tipo Orden: | `PUERTO_TIPO_ORDEN_IMPORTACION` | string | Tipo orden (Import/Export) |

### 11. CARGADOR

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Ref Carga: | `CARGADOR_REF_CARGA` | string | Referencia carga |
| Cargador: | `CARGADOR_NOMBRE` | string | Nombre cargador |
| - | `CARGADOR_CIF` | string | CIF cargador |
| - | `CARGADOR_DIRECCION` | string | Dirección |
| - | `CARGADOR_POBLACION` | string | Población |
| - | `CARGADOR_PROVINCIA` | string | Provincia |
| Pif/Aduana: | `PIF_NOMBRE` | string | Nombre PIF/Aduana |

### 12. TABLA DE LUGARES (Viajes)

**Nota:** Solo se muestra si `tipoDocumento != 'A' && tipoDocumento != 'E'`

| Columna | Campo JSON Array | Tipo | Observaciones |
|---------|------------------|------|---------------|
| Lugar | `LUGARES[].LUGAR_NOMBRE` | string | Nombre del lugar |
| Dirección | `LUGARES[].LUGAR_DIRECCION` | string | Dirección completa |
| CP | `LUGARES[].LUGAR_CP` | string | Código postal |
| Población | `LUGARES[].LUGAR_POBLACION` | string | Población |
| Provincia | `LUGARES[].LUGAR_PROVINCIA` | string | Provincia |
| Telf: | `LUGARES[].LUGAR_TELEFONO` | string | Teléfono contacto |

**Fuente de datos:**
- Array: `$jsonDatos['LUGARES']`
- Se recorren todos los elementos del array

### 13. FIRMAS

**Nota:** Solo se muestran si existen en la base de datos

| Label | Campo BD | Tipo | Observaciones |
|-------|----------|------|---------------|
| FIRMA Y SELLO LEADER: | - | Texto fijo | Título |
| - | `FirmaViajeConductor` | image | URL de la imagen |
| - | `nombreViajeConductor` | string | Nombre conductor |
| - | `dniViajeConductor` | string | DNI conductor |
| FIRMA Y SELLO CLIENTE: | - | Texto fijo | Título |
| - | `FirmaViajeReceptor` | image | URL de la imagen |
| - | `nombreViajeReceptor` | string | Nombre receptor |
| - | `dniViajeReceptor` | string | DNI receptor |

**Condición:** `if (!empty($datosOrden['dniViajeReceptor']))`

### 14. OBSERVACIONES

| Label | Campo JSON | Tipo | Observaciones |
|-------|------------|------|---------------|
| Observaciones: | - | Texto fijo | Título |
| BOOKING Nº: | `PCS_BOOKING_NUMBER` | string | Número booking |
| - | `OBSERVACIONES` | text | Observaciones generales |

### 15. PIE DE PÁGINA

| Label | Campo/Función | Tipo | Observaciones |
|-------|---------------|------|---------------|
| Fecha Emisión: | `transformarFecha("", [...])` | datetime | Fecha actual formateada |
| - | Texto legal RGPD | text | Texto fijo sobre protección datos |

---

## 🔍 Condiciones de Visualización

### Campos que se ocultan según tipo:

| Campo/Sección | Condición de visualización |
|---------------|---------------------------|
| Tabla de Lugares | `tipoDocumento != 'A' && tipoDocumento != 'E'` |
| Firmas | `!empty($datosOrden['dniViajeReceptor'])` |
| Localizador Admisión | Solo si `tipoDocumento == 'A'` |
| Localizador Entrega | Solo si `tipoDocumento == 'E'` |

### Diferencias Tipo C - OFICINA vs otros tipos:

**OFICINA (O):**
- ✅ Muestra todos los lugares
- ✅ Sin restricción de viajes
- ✅ Información completa

**Diferente a:**
- CLIENTE (C): Requiere viaje específico
- ENTREGUESE (E): Oculta tabla lugares, añade firmas especiales
- ADMITASE (A): Oculta tabla lugares, muestra localizador admisión

---

## 📐 Dimensiones y Formato

- **Tamaño papel:** A4
- **Márgenes:** 1cm (definido en @media print)
- **Fuente:** Courier New, Courier, monospace
- **Peso fuente:** Bold por defecto
- **Tamaño fuente:** Variable según sección (11px - 27px)
- **Bordes:** 1px solid #000000
- **QR Code:** 150x150px

---

## 🎨 Clases CSS Aplicadas

| Clase | Aplicación | Efecto |
|-------|-----------|--------|
| `.form-layout-2` | Contenedor general | Estructura base del formulario |
| `.form-group` | Cada bloque | Border, padding, margin |
| `.borde-gris-derecho` | Divisiones verticales | Border-right: 2px solid #000 |
| `.borde-gris-abajo` | Divisiones horizontales | Border-bottom: 2px solid #000 |
| `.form-control` | Inputs/labels | Sin border, padding: 0, bg transparent |
| `.tx-bold` | Textos importantes | Font-weight: bold |
| `.print-label` | Labels impresos | Display: block, font-size: 11px |

---

## 🔄 Flujo de Generación

1. **Carga de URL:** `orden.php?idOrden=TOKEN&tipoDocumento=O&tipoOrdenTransporte=C`
2. **Consulta BD:** Modelo `Transporte->recogerOrdenToken($tokenOrden)`
3. **Decodificación JSON:** `json_decode($datosOrden['jsonOrdenTransporte'])`
4. **Renderizado HTML:** Bloque tipo C (líneas 1099-1819)
5. **Generación QR:** JavaScript con QRCodeStyling
6. **Auto-impresión:** Timeout 1 segundo → `window.print()` → `window.close()`

---

## 📋 Checklist de Datos Requeridos

### Campos obligatorios mínimos:

- [x] `AGENCIA_*` (todos los campos)
- [x] `TTE_FECHA_CARGA`
- [x] `TTE_HORA_CARGA`
- [x] `TTE_ORDEN`
- [x] `CONSIGNATARIO`
- [x] `TRANSPORTISTA_*` (todos)
- [x] `CONDUCTOR_*` (todos)
- [x] `TRACTORA`
- [x] `PLATAFORMA`
- [x] `RECOGER_EN_*` (todos)
- [x] `DEVOLVER_EN_*` (todos)
- [x] `MERCANCIA`

### Campos opcionales:

- [ ] Temperaturas (para refrigerados)
- [ ] Extras dimensionales (para cargas especiales)
- [ ] Datos IMO (para mercancía peligrosa)
- [ ] Firmas (se añaden después)
- [ ] Observaciones adicionales

---

**Última actualización:** 21 de diciembre de 2025
