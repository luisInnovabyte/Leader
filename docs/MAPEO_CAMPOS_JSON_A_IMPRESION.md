# 📋 DOCUMENTACIÓN DE MAPEO DE CAMPOS JSON A IMPRESIÓN

**Propósito:** Este documento describe los 3 tipos diferentes de archivos JSON que el sistema recibe y cómo se mapean a los documentos de impresión.

**Archivo de impresión:** `view/Transportes/orden.php`  
**Ejemplos reales:** `view/Ordenes/descargas_procesados/20251123/*.json`

---

## 🎯 CÓMO USAR ESTE DOCUMENTO

Para solicitar un cambio en la impresión, simplemente indica:

1. **TIPO DE ORDEN:** C (Contenedor), T (Terrestre) o M (Multimodal)
2. **TIPO DE DOCUMENTO:** O (Oficina), T (Transportista), C (Cliente), E (Entréguese), etc.
3. **CAMPO A MODIFICAR:** Nombre del campo en la impresión (ej: "Ref. Consig:")
4. **NUEVO ORIGEN:** Campo del JSON que debe mostrarse (ej: `CARGADOR_REF_CARGA`)

**Ejemplo de solicitud:**
```
TIPO DE ORDEN: C
TIPO DE DOCUMENTO: O (Oficina)

CAMBIOS SOLICITADOS:
1. CAMPO: Mercancía
   - ORIGEN ACTUAL: MERCANCIA
   - NUEVO ORIGEN: LUGARES[0].LUGAR_MERCANCIA_CARGA
   - RAZÓN: El campo del lugar es más específico
```

---

## 📊 TIPOS DE JSON QUE LLEGAN AL SISTEMA

El sistema recibe **3 tipos diferentes** de archivos JSON según el tipo de transporte:

| Tipo | Identificador | Comentario Inicial | Campos Exclusivos |
|------|---------------|-------------------|-------------------|
| **C** - Contenedor | `TTE_TERRESTRE: false`<br>`TTE_MULTIMODAL: false` | "TRANSPORTE DE CONTENEDOR" | MATRICULA, TIPO_CONT, PRECINTO, RECOGER_EN, DEVOLVER_EN, datos marítimos, puertos, PCS |
| **T** - Terrestre | `TTE_TERRESTRE: true`<br>`TTE_MULTIMODAL: false` | "TRANSPORTE TERRESTRE" | LUGARES_CARGA[], LUGARES_DESCARGA[], CMR[] |
| **M** - Multimodal | `TTE_TERRESTRE: false`<br>`TTE_MULTIMODAL: true` | "TRANSPORTE MULTIMODAL" | LUGAR_COMIENZO, LUGARES_CARGA[], LUGARES_DESCARGA[], LUGAR_FIN, CMR[] |

---

## 📦 ESTRUCTURA JSON: CAMPOS COMUNES A LOS 3 TIPOS

Estos grupos aparecen en **TODOS** los tipos de JSON:

### ✅ GRUPO AGENCIA (COMÚN A TODOS)
```json
{
  "AGENCIA_CIF": "B-46828158",
  "AGENCIA_NOMBRE": "LEADER TRANSPORT S.L",
  "AGENCIA_OFICINA": "V",
  "AGENCIA_DIRECCION": "C\\ Dr. J.J.Domine, 18 1 Izq.",
  "AGENCIA_CP": "46011",
  "AGENCIA_POBLACION": "VALENCIA",
  "AGENCIA_PROVINCIA": "VALENCIA",
  "AGENCIA_PAIS": "ESPAÑA",
  "AGENCIA_TELEFONO": "96 316 41 60",
  "AGENCIA_EMAIL": "transporte@leader-transport.com"
}
```

### ✅ GRUPO ORDEN TRANSPORTE (COMÚN A TODOS)
```json
{
  "TTE_COD": 34466500,
  "TTE_RUPTOR": 0,
  "TTE_ORDEN": "344665",
  "TTE_FECHA_CARGA": "2025-09-17",
  "TTE_HORA_CARGA": "10:00:00",
  "TTE_REF_CONSIG": "",
  "TTE_FECHA_ESTIMADA_RECOGIDA": "2025-09-17",
  "TTE_FECHA_ESTIMADA_ENTREGA": "2025-09-17",
  "TTE_BORRADO": false,
  "TTE_TIPO_ORDEN": "N",
  "TTE_IMPORTACION": false,
  "TTE_TERRESTRE": false,        // ← Identifica tipo T
  "TTE_MULTIMODAL": false,       // ← Identifica tipo M
  "FECHA_CARGA_REAL": null,
  "HORA_RECOGIDA": "00:00:00",
  "HORA_ENTREGA": "12:00:00"
}
```

### ✅ GRUPO CONSIGNATARIO (COMÚN A TODOS)
```json
{
  "CONSIGNATARIO": "ERHARDT TRANSITARIOS, S.L.",
  "CONSIGNATARIO_NIF": "T326"
}
```

### ✅ GRUPO TRANSPORTISTA (COMÚN A TODOS)
```json
{
  "TRANSPORTISTA_COD": 2656,
  "TRANSPORTISTA_NOMBRE": "VICENTE RODIRGO",
  "TRANSPORTISTA_DIRECCION": "Avda LOS NARANJOS, Nº 35, planta 1 PU",
  "TRANSPORTISTA_CP": "46190",
  "TRANSPORTISTA_POBLACION": "RIBARROJA DEL TURIA",
  "TRANSPORTISTA_PROVINCIA": "VALENCIA",
  "TRANSPORTISTA_PAIS": "ESPAÑA",
  "TRANSPORTISTA_NIF": "B01834241",
  "CONDUCTOR_NOMBRE": "VICENTE RODRIGO TRAN",
  "CONDUCTOR_NIF": "B01834241",
  "CONDUCTOR_EMAIL": "trafico01@logisticarodrigo.com",
  "TRACTORA": "Pdte asignar",
  "PLATAFORMA": "Pdte asignar",
  "PLATAFORMA_TIPO": null
}
```

### ✅ GRUPO TEMPERATURA (COMÚN A TODOS)
```json
{
  "TEMP_MINIMA": 0,
  "TEMP_MAXIMA": 0,
  "TEMP_MEDIDA": null,
  "TEMP_CONECTAR": null
}
```

### ✅ GRUPO EXTRAS DIMENSIONALES (COMÚN A TODOS)
```json
{
  "EXTRA_FRONT": 0,
  "EXTRA_BACK": 0,
  "EXTRA_RIGHT": 0,
  "EXTRA_LEFT": 0,
  "EXTRA_ALTO": 0
}
```

### ✅ GRUPO IMO/ONU - Mercancía Peligrosa (COMÚN A TODOS)
```json
{
  "IMO_CLASE": "",
  "IMO_PAGINA": null,
  "IMO_VERSION": null,
  "IMO_ONU": "",
  "IMO_PORT_NOTIFICATION": ""
}
```

### ✅ GRUPO CARGADOR (COMÚN A TODOS)
```json
{
  "CARGADOR_CIF": "B38406906",
  "CARGADOR_NOMBRE": "ERHARDT TRANSITARIOS, SL.",
  "CARGADOR_DIRECCION": "C/ ERCILLA 19",
  "CARGADOR_CP": "48009",
  "CARGADOR_POBLACION": "BILBAO",
  "CARGADOR_PROVINCIA": "VIZCAYA",
  "CARGADOR_PAIS": "ESPAÑA",
  "CARGADOR_REF_CARGA": "FEX2506201 ~PG~"
}
```

### ✅ GRUPO OBSERVACIONES (COMÚN A TODOS)
```json
{
  "OBSERVACIONES": "Texto general...",
  "OBS_TRANSPORTISTA": "Observaciones para el transportista",
  "OBS_RECOGER": "Observaciones de recogida",
  "OBS_DEJAR": "Observaciones de entrega"
}
```

---

## 🚢 TIPO C - CONTENEDOR (Marítimo)

**Archivo ejemplo:** `34466500.json`  
**Identificación:** `"TTE_TERRESTRE": false, "TTE_MULTIMODAL": false`  
**Comentario inicial:** `"TRANSPORTE DE CONTENEDOR"`

### 📦 CAMPOS EXCLUSIVOS DEL TIPO C

#### GRUPO CONTENEDORES
```json
{
  "MATRICULA": "SEGU5679824",
  "TIPO_CONT": "45G1",
  "TIPO_CONT_DESC": "40 HC",
  "PRECINTO": "HLD2356640",
  "MATRICULA2": null,
  "TIPO_CONT2": null,
  "TIPO_CONT_DESC2": null,
  "PRECINTO2": null
}
```

#### GRUPO RECOGER (Lugar de recogida del contenedor)
```json
{
  "RECOGER_EN_COD": 1374,
  "RECOGER_EN_NOMBRE": "INTERCONTAINER RIBARROJA",
  "RECOGER_EN_DIRECCION": "P.I. DE RIBARROJA (EL OLIVERAL) - MANZANA C.2.4",
  "RECOGER_EN_CP": "46190",
  "RECOGER_EN_POBLACION": "RIBARROJA DEL TURIA",
  "RECOGER_EN_PROVINCIA": "VALENCIA",
  "RECOGER_EN_PAIS": null,
  "RECOGER_CODIGO_SIC": null,
  "RECOGER_NIF": "A46182978"
}
```

#### GRUPO DEVOLVER (Lugar de devolución del contenedor)
```json
{
  "DEVOLVER_EN_COD": 184,
  "DEVOLVER_EN_NOMBRE": "APM TERMINALS (TCV)",
  "DEVOLVER_EN_DIRECCION": "MOLL DE PONENT S/N",
  "DEVOLVER_EN_CP": "46024",
  "DEVOLVER_EN_POBLACION": "VALENCIA",
  "DEVOLVER_EN_PROVINCIA": "VALENCIA",
  "DEVOLVER_EN_PAIS": null,
  "DEVOLVER_CODIGO_SIC": null,
  "DEVOLVER_NIF": "A96763206"
}
```

#### GRUPO LINEA (Naviera)
```json
{
  "COD_LINEA_DEST": "HLCU",
  "NOMBRELINEA_DEST": "HAPAG LLOYD",
  "ESCALA_DEST": "1202504759",
  "BUQUE_DEST": "NICARAGUA EXPRESS",
  "VIAJE_DEST": "538W",
  "DISTINTIVO_LLAMADA_DEST": "",
  "COD_LINEA": "HLCU",
  "NOMBRELINEA": "HAPAG LLOYD",
  "ESCALA": "1202504759",
  "BUQUE": "NICARAGUA EXPRESS",
  "VIAJE": "538W",
  "DISTINTIVO_LLAMADA": ""
}
```

#### GRUPO PUERTOS
```json
{
  "PUERTO_ORIGEN_COD": "ESVLC",
  "PUERTO_ORIGEN_NOMBRE": "VALENCIA",
  "PUERTO_DESTINO_COD": "MXVER",
  "PUERTO_DESTINO_NOMBRE": "VERACRUZ",
  "PUERTO_DESCARGA_COD": "MXVER",
  "PUERTO_DESCARGA_NOMBRE": "VERACRUZ",
  "PUERTO_TIPO_ORDEN_IMPORTACION": false  // false = EXPORT, true = IMPORT
}
```

#### GRUPO PIF (Punto de Inspección Fronterizo)
```json
{
  "PIF": false,
  "PIF_COD": 0,
  "PIF_NOMBRE": null
}
```

#### GRUPO LUGARES (Array simple de lugares de carga)
```json
{
  "LUGAR_COMIENZO": 0,
  "LUGAR_COMIENZO_NOMBRE": null,
  "LUGARES": [
    {
      "LUGAR_COD": 103446650001,
      "LUGAR_NOMBRE": "SPALEX/SP BERNER CHIVA",
      "LUGAR_DIRECCION": "P.I.LA PAHILLA.C/CAÑADA PERALES 195",
      "LUGAR_CP": "",
      "LUGAR_POBLACION": "CHIVA",
      "LUGAR_PROVINCIA": "VALENCIA",
      "LUGAR_PAIS": null,
      "LUGAR_TELEFONO": null,
      "LUGAR_FECHA_CARGA": "2025-09-17",
      "LUGAR_HORA_CARGA": "10:00:00",
      "LUGAR_REF_CARGA": "93365389",
      "LUGAR_OBSERVACIONES_CARGA": null,
      "LUGAR_BULTOS_CARGA": null,
      "LUGAR_MERCANCIA_CARGA": null,
      "LUGAR_KILOS_CARGA": null,
      "LUGAR_METROS_CARGA": null,
      "LUGAR_MARCAS_CARGA": null
    }
  ],
  "LUGAR_FIN": 0,
  "LUGAR_FIN_NOMBRE": null
}
```

#### GRUPO PCS (Port Community System)
```json
{
  "PCS_DOCUMENT_NUMBER": "T32625091500202473",
  "PCS_BOOKING_NUMBER": "93365389",
  "PCS_BL_NUMBER": null
}
```

#### GRUPO ORDEN ENTREGA
```json
{
  "OE_PCS": "T07725091500640807",
  "OE_CODIGO_BARRAS": "03825012701250728753",
  "OE_PCS_LOCATOR": "RPVGUA",
  "OE_FECHA_DESDE": "2025-09-16",
  "OE_FECHA_HASTA": "2025-09-18",
  "OE_CPR": null,
  "OE_REF": null
}
```

#### GRUPO ORDEN ADMISION
```json
{
  "OA_PCS": "T07725091200639048",
  "OA_CODIGO_BARRAS": "03825012757759595055",
  "OA_PCS_LOCATOR": "RPV3HY",
  "OA_FECHA_DESDE": "2025-09-16",
  "OA_FECHA_HASTA": "2025-09-18",
  "OA_CPR": null,
  "OA_REF": null
}
```

---

## 🚚 TIPO T - TERRESTRE

**Archivo ejemplo:** `34495400.json`  
**Identificación:** `"TTE_TERRESTRE": true, "TTE_MULTIMODAL": false`  
**Comentario inicial:** `"TRANSPORTE TERRESTRE"`

### 🛣️ CAMPOS EXCLUSIVOS DEL TIPO T

#### GRUPO LUGARES_CARGA (Array de lugares de carga)
```json
{
  "LUGARES_CARGA": [
    {
      "LUGAR_COD": 103449540001,
      "LUGAR_NOMBRE": "ZICUÑAGA",
      "LUGAR_DIRECCION": "BARRIO DE ZICUÑAGA, S/N",
      "LUGAR_CP": "20120",
      "LUGAR_POBLACION": "HERNANI",
      "LUGAR_PROVINCIA": "GUIPUZCOA",
      "LUGAR_PAIS": null,
      "LUGAR_TELEFONO": "943462600 ALEX",
      "LUGAR_FECHA_CARGA": "2025-10-03",
      "LUGAR_HORA_CARGA": null,
      "LUGAR_REF_CARGA": "2507HC05902",
      "LUGAR_OBSERVACIONES_CARGA": null,
      "LUGAR_BULTOS_CARGA": "0",
      "LUGAR_MERCANCIA_CARGA": "null",
      "LUGAR_KILOS_CARGA": "null",
      "LUGAR_METROS_CARGA": null,
      "LUGAR_MARCAS_CARGA": null
    }
  ]
}
```

#### GRUPO LUGARES_DESCARGA (Array de lugares de descarga)
```json
{
  "LUGARES_DESCARGA": [
    {
      "LUGAR_COD": 203449540001,
      "LUGAR_NOMBRE": "ARCONVERT, S.P.",
      "LUGAR_DIRECCION": "VIA DEL LINFANO, 12",
      "LUGAR_CP": "38062",
      "LUGAR_POBLACION": "ARCO (Italia)",
      "LUGAR_PROVINCIA": "ITALIA",
      "LUGAR_PAIS": null,
      "LUGAR_TELEFONO": null,
      "LUGAR_FECHA_DESCARGA": "2025-10-06",
      "LUGAR_HORA_DESCARGA": "13:00:00",
      "LUGAR_REF_DESCARGA": "2507HC05902",
      "LUGAR_OBSERVACIONES_DESCARGA": null,
      "LUGAR_BULTOS_DESCARGA": "0",
      "LUGAR_MERCANCIA_DESCARGA": "null",
      "LUGAR_KILOS_DESCARGA": "null",
      "LUGAR_METROS_DESCARGA": null,
      "LUGAR_MARCAS_DESCARGA": null
    }
  ]
}
```

#### GRUPO CMR (Array de viajes - combinaciones carga/descarga)
```json
{
  "CMR": [
    {
      "LUGAR_CARGA": {
        "LUGAR_COD": 103449540001,
        "LUGAR_NOMBRE": "ZICUÑAGA",
        "LUGAR_DIRECCION": "BARRIO DE ZICUÑAGA, S/N",
        "LUGAR_CP": "20120",
        "LUGAR_POBLACION": "HERNANI",
        "LUGAR_PROVINCIA": "GUIPUZCOA",
        "LUGAR_REF_CARGA": "2507HC05902"
      },
      "LUGAR_DESCARGA": {
        "LUGAR_COD": 203449540001,
        "LUGAR_NOMBRE": "ARCONVERT, S.P.",
        "LUGAR_DIRECCION": "VIA DEL LINFANO, 12",
        "LUGAR_CP": "38062",
        "LUGAR_POBLACION": "ARCO (Italia)",
        "LUGAR_PROVINCIA": "ITALIA"
      },
      "CONDUCTOR_NOMBRE": "SPRINT LOGISTYKA POL",
      "CONDUCTOR_NIF": "PL8512841994",
      "TRACTORA": "WGM 543SK",
      "PLATAFORMA": "WGM 42ID"
    }
  ]
}
```

**⚠️ NOTA TIPO T:** No tiene campos marítimos (MATRICULA, TIPO_CONT, PRECINTO, puertos, líneas, PCS)

---

## 🚛 TIPO M - MULTIMODAL

**Archivo ejemplo:** `34203301.json`  
**Identificación:** `"TTE_TERRESTRE": false, "TTE_MULTIMODAL": true`  
**Comentario inicial:** `"TRANSPORTE MULTIMODAL"`

### 🔄 CAMPOS EXCLUSIVOS DEL TIPO M

#### LUGAR_COMIENZO (Punto de inicio de plataforma)
```json
{
  "LUGAR_COMIENZO": 24926,
  "LUGAR_COMIENZO_NOMBRE": "R SOERIO"
}
```

#### GRUPO LUGARES_CARGA (Array de lugares de carga)
```json
{
  "LUGARES_CARGA": [
    {
      "LUGAR_COD": 103420330101,
      "LUGAR_NOMBRE": "TTES FÁTIMA BRÍGIDA",
      "LUGAR_DIRECCION": "RUA RIBEIRA DO CASAL S/N",
      "LUGAR_CP": "2025-39",
      "LUGAR_POBLACION": "AMIAIS DE BAIXO",
      "LUGAR_PROVINCIA": "PORTUGAL",
      "LUGAR_PAIS": null,
      "LUGAR_TELEFONO": null,
      "LUGAR_IMPORTE": 900,
      "LUGAR_FECHA_CARGA": null,
      "LUGAR_HORA_CARGA": null,
      "LUGAR_REF_CARGA": "null",
      "LUGAR_OBSERVACIONES_CARGA": null,
      "LUGAR_BULTOS_CARGA": "",
      "LUGAR_MERCANCIA_CARGA": "",
      "LUGAR_KILOS_CARGA": "",
      "LUGAR_METROS_CARGA": null,
      "LUGAR_MARCAS_CARGA": null
    },
    {
      "LUGAR_COD": 103420330102,
      "LUGAR_NOMBRE": "AMIAIS DE BAIXO + MARFILPE",
      "LUGAR_DIRECCION": "NASCENTE 16",
      "LUGAR_CP": "LEIRIA",
      "LUGAR_POBLACION": "BATALHA",
      "LUGAR_PROVINCIA": "PORTUGAL"
    }
  ]
}
```

#### GRUPO LUGARES_DESCARGA (Array de lugares de descarga)
```json
{
  "LUGARES_DESCARGA": [
    {
      "LUGAR_COD": 203420330101,
      "LUGAR_NOMBRE": "LA ALGUEÑA",
      "LUGAR_DIRECCION": "LA ALGUEÑA",
      "LUGAR_CP": "03668",
      "LUGAR_POBLACION": "ALGUEÑA, LA",
      "LUGAR_PROVINCIA": "ALICANTE",
      "LUGAR_PAIS": null,
      "LUGAR_TELEFONO": null,
      "LUGAR_IMPORTE": 900,
      "LUGAR_FECHA_DESCARGA": null,
      "LUGAR_HORA_DESCARGA": null,
      "LUGAR_REF_DESCARGA": "null",
      "LUGAR_OBSERVACIONES_DESCARGA": null,
      "LUGAR_BULTOS_DESCARGA": "",
      "LUGAR_MERCANCIA_DESCARGA": "",
      "LUGAR_KILOS_DESCARGA": ""
    }
  ]
}
```

#### LUGAR_FIN (Punto final de plataforma)
```json
{
  "LUGAR_FIN": 24981,
  "LUGAR_FIN_NOMBRE": "LA ALGUEÑA"
}
```

#### GRUPO CMR (Array de viajes)
```json
{
  "CMR": [
    {
      "LUGAR_CARGA": {
        "LUGAR_COD": 103420330101,
        "LUGAR_NOMBRE": "TTES FÁTIMA BRÍGIDA",
        "LUGAR_DIRECCION": "RUA RIBEIRA DO CASAL S/N",
        "LUGAR_CP": "2025-39",
        "LUGAR_POBLACION": "AMIAIS DE BAIXO",
        "LUGAR_PROVINCIA": "PORTUGAL"
      },
      "LUGAR_DESCARGA": {
        "LUGAR_COD": 203420330101,
        "LUGAR_NOMBRE": "LA ALGUEÑA",
        "LUGAR_DIRECCION": "LA ALGUEÑA",
        "LUGAR_CP": "03668",
        "LUGAR_POBLACION": "ALGUEÑA, LA",
        "LUGAR_PROVINCIA": "ALICANTE"
      },
      "CONDUCTOR_NOMBRE": "MARCEL-FLORIN BRINZA",
      "CONDUCTOR_NIF": "X4211879G",
      "TRACTORA": "0566KSF",
      "PLATAFORMA": "R2259BCY"
    },
    {
      /* Segundo viaje con mismas estructuras */
    }
  ]
}
```

**⚠️ NOTA TIPO M:** Similar a Tipo T pero incluye LUGAR_COMIENZO y LUGAR_FIN para identificar los puntos de inicio/fin de la plataforma.

---

## 📊 TABLA COMPARATIVA: QUÉ CAMPOS TIENE CADA TIPO

| Grupo/Campo | Tipo C | Tipo T | Tipo M |
|-------------|--------|--------|--------|
| **COMUNES:** ||||
| AGENCIA_* | ✅ | ✅ | ✅ |
| TTE_* (Orden transporte) | ✅ | ✅ | ✅ |
| CONSIGNATARIO | ✅ | ✅ | ✅ |
| TRANSPORTISTA_* | ✅ | ✅ | ✅ |
| CONDUCTOR_* | ✅ | ✅ | ✅ |
| TRACTORA, PLATAFORMA | ✅ | ✅ | ✅ |
| TEMP_* (Temperatura) | ✅ | ✅ | ✅ |
| EXTRA_* (Dimensiones) | ✅ | ✅ | ✅ |
| IMO_* (Mercancía peligrosa) | ✅ | ✅ | ✅ |
| CARGADOR_* | ✅ | ✅ | ✅ |
| OBSERVACIONES, OBS_* | ✅ | ✅ | ✅ |
| **EXCLUSIVOS:** ||||
| MATRICULA, TIPO_CONT, PRECINTO | ✅ | ❌ | ❌ |
| RECOGER_EN_* | ✅ | ❌ | ❌ |
| DEVOLVER_EN_* | ✅ | ❌ | ❌ |
| NOMBRELINEA, BUQUE, ESCALA, VIAJE | ✅ | ❌ | ❌ |
| PUERTO_* (Puertos) | ✅ | ❌ | ❌ |
| PCS_*, OE_*, OA_* | ✅ | ❌ | ❌ |
| LUGARES[] (array simple) | ✅ | ❌ | ❌ |
| LUGARES_CARGA[] | ❌ | ✅ | ✅ |
| LUGARES_DESCARGA[] | ❌ | ✅ | ✅ |
| LUGAR_COMIENZO, LUGAR_FIN | ❌ | ❌ | ✅ |
| CMR[] (viajes) | ❌ | ✅ | ✅ |

---

## 📄 MAPEO ACTUAL: TIPO C - DOCUMENTO OFICINA

**Tipo de orden:** C (Contenedor)  
**Tipo de documento:** O (Oficina)  
**Parámetros URL:** `?tipoDocumento=O&tipoOrdenTransporte=C`

| CAMPO EN IMPRESIÓN | CAMPO JSON ORIGEN | LÍNEA APROX | ESTADO |
|-------------------|------------------|-------------|---------|
| **F. Carga** | `TTE_FECHA_CARGA` | ~450 | ✅ |
| **Hora** | `TTE_HORA_CARGA` | ~450 | ✅ |
| **Ref. Consig** | `TTE_REF_CONSIG` | ~460 | ✅ |
| **Recogida estimada** | `TTE_FECHA_ESTIMADA_RECOGIDA` | ~465 | ✅ |
| **Entrega estimada** | `TTE_FECHA_ESTIMADA_ENTREGA` | ~470 | ✅ |
| **OT Agencia** | `TTE_ORDEN` | ~475 | ✅ |
| **Agente** | `CONSIGNATARIO` | ~490 | ✅ |
| **Contenedores** | `MATRICULA` o `contenedorActivo` (param) | ~500 | ✅ |
| **Tipo** | `TIPO_CONT_DESC` | ~505 | ✅ |
| **Hlog Precintos** | `PRECINTO` o `precintoActivo` (param) | ~510 | ✅ |
| **TRANSPORTISTA - Nombre** | `TRANSPORTISTA_NOMBRE` | ~520 | ✅ |
| **TRANSPORTISTA - Dirección** | `TRANSPORTISTA_DIRECCION` | ~525 | ✅ |
| **TRANSPORTISTA - CP** | `TRANSPORTISTA_CP` | ~530 | ✅ |
| **TRANSPORTISTA - Población** | `TRANSPORTISTA_POBLACION` | ~535 | ✅ |
| **TRANSPORTISTA - Provincia** | `TRANSPORTISTA_PROVINCIA` | ~540 | ✅ |
| **TRANSPORTISTA - NIF** | `TRANSPORTISTA_NIF` | ~545 | ✅ |
| **CONDUCTOR - Nombre** | `CONDUCTOR_NOMBRE` | ~560 | ✅ |
| **CONDUCTOR - NIF** | `CONDUCTOR_NIF` | ~565 | ✅ |
| **CABEZA** | `TRACTORA` | ~575 | ✅ |
| **Plataforma** | `PLATAFORMA` | ~580 | ✅ |
| **RETIRAR DE - Nombre** | `RECOGER_EN_NOMBRE` | ~600 | ✅ |
| **RETIRAR DE - Dirección** | `RECOGER_EN_DIRECCION` | ~605 | ✅ |
| **RETIRAR DE - CP** | `RECOGER_EN_CP` | ~610 | ✅ |
| **RETIRAR DE - Población** | `RECOGER_EN_POBLACION` | ~615 | ✅ |
| **RETIRAR DE - Provincia** | `RECOGER_EN_PROVINCIA` | ~620 | ✅ |
| **ENTREGAR EN - Nombre** | `DEVOLVER_EN_NOMBRE` | ~640 | ✅ |
| **ENTREGAR EN - Dirección** | `DEVOLVER_EN_DIRECCION` | ~645 | ✅ |
| **ENTREGAR EN - CP** | `DEVOLVER_EN_CP` | ~650 | ✅ |
| **ENTREGAR EN - Población** | `DEVOLVER_EN_POBLACION` | ~655 | ✅ |
| **ENTREGAR EN - Provincia** | `DEVOLVER_EN_PROVINCIA` | ~660 | ✅ |
| **Mercancía** | `LUGARES[0].LUGAR_MERCANCIA_CARGA` | ~680 | ✅ |
| **Bultos** | `LUGARES[0].LUGAR_BULTOS_CARGA` | ~685 | ✅ |
| **Peso (kg)** | `LUGARES[0].LUGAR_KILOS_CARGA` | ~690 | ✅ |
| **Temp. Max** | `TEMP_MAXIMA` | ~710 | ✅ |
| **Temp. Mín** | `TEMP_MINIMA` | ~715 | ✅ |
| **Conectar** | `TEMP_CONECTAR` | ~720 | ✅ |
| **Ext. Der** | `EXTRA_RIGHT` | ~740 | ✅ |
| **Ext. Izq** | `EXTRA_LEFT` | ~745 | ✅ |
| **Ext. Front** | `EXTRA_FRONT` | ~750 | ✅ |
| **Ext. Tras** | `EXTRA_BACK` | ~755 | ✅ |
| **Ext. Altura** | `EXTRA_ALTO` | ~760 | ✅ |
| **ONU** | `IMO_ONU` | ~780 | ✅ |
| **Versión** | `IMO_VERSION` | ~785 | ✅ |
| **IMDG** | `IMO_PAGINA` | ~790 | ✅ |
| **Clase** | `IMO_CLASE` | ~795 | ✅ |
| **Notif Apv** | `IMO_PORT_NOTIFICATION` | ~800 | ✅ |
| **Línea** | `NOMBRELINEA_DEST` o `NOMBRELINEA` | ~820 | ✅ |
| **Nº Escala** | `ESCALA_DEST` o `ESCALA` | ~825 | ✅ |
| **Buque** | `BUQUE_DEST` o `BUQUE` | ~830 | ✅ |
| **Viaje** | `VIAJE_DEST` o `VIAJE` | ~835 | ✅ |
| **Dist. Llamada** | `DISTINTIVO_LLAMADA_DEST` | ~840 | ✅ |
| **Puerto Origen** | `PUERTO_ORIGEN_NOMBRE` | ~860 | ✅ |
| **Puerto Destino** | `PUERTO_DESTINO_NOMBRE` | ~865 | ✅ |
| **Pto. Des/carga** | `PUERTO_DESCARGA_NOMBRE` | ~870 | ✅ |
| **Tipo Orden** | `PUERTO_TIPO_ORDEN_IMPORTACION` | ~875 | ✅ (false=Export, true=Import) |
| **Ref Carga** | `LUGARES[0].LUGAR_REF_CARGA` | ~890 | ✅ |
| **Cargador** | `CARGADOR_NOMBRE` | ~895 | ✅ |

---

## 📝 PLANTILLA PARA SOLICITAR CAMBIOS

Copia y rellena esta plantilla para solicitar modificaciones:

```
TIPO DE ORDEN: [C / T / M]
TIPO DE DOCUMENTO: [O / T / C / E / X / A]

CAMBIOS SOLICITADOS:

1. CAMPO: [Nombre del campo en impresión]
   - ORIGEN ACTUAL: [Campo JSON actual]
   - NUEVO ORIGEN: [Nuevo campo JSON]
   - RAZÓN: [Explicación del cambio]

2. REORDENAR CAMPO: [Nombre del campo]
   - POSICIÓN ACTUAL: [Descripción de dónde está]
   - NUEVA POSICIÓN: [Descripción de dónde debe ir]
   - RAZÓN: [Explicación del cambio]

3. AÑADIR CAMPO NUEVO: [Nombre del campo nuevo]
   - ORIGEN JSON: [Campo del JSON]
   - POSICIÓN: [Dónde debe aparecer]
   - FORMATO: [Cómo debe mostrarse]
```

---

## 🔧 VARIABLES ESPECIALES Y LÓGICA

### Variables Procesadas en PHP
- `contenedorActivo`: Parámetro GET o `MATRICULA`
- `precintoActivo`: Parámetro GET o `PRECINTO`
- `tipoOrdenTransporte`: 'C', 'T' o 'M' calculado según flags

### Lógica Condicional TIPO C
```php
// Determinar Import/Export
if ($jsonDatos['PUERTO_TIPO_ORDEN_IMPORTACION'] == false) {
    echo "EXPORT";
} else {
    echo "IMPORT";
}

// Acceso a primer lugar de carga
$mercancia = $jsonDatos['LUGARES'][0]['LUGAR_MERCANCIA_CARGA'];
$bultos = $jsonDatos['LUGARES'][0]['LUGAR_BULTOS_CARGA'];
$kilos = $jsonDatos['LUGARES'][0]['LUGAR_KILOS_CARGA'];
```

### Lógica Condicional TIPO T y M
```php
// Iterar lugares de carga
foreach ($jsonDatos['LUGARES_CARGA'] as $lugarCarga) {
    echo $lugarCarga['LUGAR_NOMBRE'];
    echo $lugarCarga['LUGAR_DIRECCION'];
}

// Iterar lugares de descarga
foreach ($jsonDatos['LUGARES_DESCARGA'] as $lugarDescarga) {
    echo $lugarDescarga['LUGAR_NOMBRE'];
}

// Iterar viajes CMR
foreach ($jsonDatos['CMR'] as $viaje) {
    echo $viaje['LUGAR_CARGA']['LUGAR_NOMBRE'];
    echo $viaje['LUGAR_DESCARGA']['LUGAR_NOMBRE'];
}
```

### Lógica Específica TIPO M
```php
// Punto inicio y fin de plataforma
$puntoInicio = $jsonDatos['LUGAR_COMIENZO_NOMBRE'];
$puntoFin = $jsonDatos['LUGAR_FIN_NOMBRE'];
```

---

## 🎨 TIPOS DE DOCUMENTO SOPORTADOS

| Código | Nombre | Descripción | Aplicable a |
|--------|--------|-------------|-------------|
| **O** | Oficina | Documento interno completo | C, T, M |
| **T** | Transportista | Para el conductor | C, T, M |
| **C** | Cliente/Receptor | Para el destinatario | C (con viaje específico) |
| **E** | Entréguese | Documento de entrega con firmas | C, T, M |
| **X** | CMR | Documento CMR estándar | T, M |
| **A** | Aviso previo | Notificación | C |

---

## 📌 NOTAS IMPORTANTES

1. **Campos null:** Si un campo JSON es `null`, se muestra vacío
2. **Arrays vacíos:** Validar siempre con `isset()` y `!empty()`
3. **Primer elemento:** Usar `[0]` para acceder al primer elemento: `$jsonDatos['LUGARES'][0]['CAMPO']`
4. **Tipo C usa LUGARES[]:** Array simple con lugares de carga del contenedor
5. **Tipo T/M usan LUGARES_CARGA[] y LUGARES_DESCARGA[]:** Arrays separados
6. **CMR solo en T/M:** Array de viajes con combinaciones carga-descarga
7. **Datos marítimos solo en C:** MATRICULA, puertos, líneas, buques, PCS

---

**Fecha de creación:** 18 de enero de 2026  
**Última actualización:** 18 de enero de 2026  
**Versión:** 2.0 - Separación completa por tipos de JSON
