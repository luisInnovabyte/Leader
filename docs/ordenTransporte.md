# Documentación: ordenTransporte.php

## Ubicación
`view/Transportes/ordenTransporte.php`

## Descripción General
Interfaz de visualización y gestión detallada de una orden de transporte individual. Permite consultar todos los datos de la orden, registrar viajes con firmas digitales, generar códigos QR, imprimir documentación y subir archivos relacionados.

---

## Funcionalidad Principal

### 🎯 Propósito
Proporcionar una vista completa y operativa de una orden de transporte específica, permitiendo al conductor/transportista:
- Visualizar todos los detalles de la orden
- Registrar información de cada viaje (llegada, salida, observaciones)
- Firmar digitalmente los viajes realizados
- Generar código QR para trazabilidad
- Imprimir diferentes tipos de documentos
- Gestionar incidencias
- Subir documentación relacionada

---

## Parámetros de Entrada

### GET Parameter
```php
$tokenOrden = $_GET['orden'];
```
- **Token único** que identifica la orden de transporte
- Generado al crear la orden (30 caracteres hexadecimales)
- Se utiliza para recuperar todos los datos de la orden

---

## Proceso de Carga de Datos

### 1. Inicialización
```php
require_once("../../models/Transportes.php");
$transporte = new Transporte();
```

### 2. Recuperación de Datos de la Orden
```php
$datosOrden = $transporte->recogerOrdenToken($tokenOrden);
```

**Datos obtenidos:**
- `num_transporte`: Número de orden
- `tipoOrdenTransporte`: Tipo (C, T, M)
- `contenedorActivo`: Matrícula del contenedor
- `precintoActivo`: Número de precinto/HLOD
- `jsonOrdenTransporte`: JSON completo con todos los datos
- `idOrden`: ID numérico de la orden en BD

### 3. Decodificación del JSON
```php
$jsonDatos = json_decode($datosOrden['jsonOrdenTransporte'], true);
```
Convierte el JSON almacenado en array PHP para acceder a todos los campos.

### 4. Recuperación de Viajes
```php
$datosViajes = $transporte->recogerViajesxOrden($idOrdenTabla);
```
Obtiene todos los viajes (cargas/descargas) asociados a la orden.

---

## Tipos de Orden de Transporte

El sistema soporta 3 tipos diferentes de órdenes con vistas específicas:

### 📦 Tipo C - Contenedor (Marítimo)
**Identificación:** `$tipoOrdenTransporte == 'C'`

**Datos mostrados:**
1. **Información General:**
   - Fecha de carga
   - Hora de carga
   - Referencia de consignatario
   - Recogida estimada
   - Entrega estimada
   - OT Agencia

2. **Agente y Contenedor:**
   - Agente consignatario
   - Número de contenedor (editable)
   - Tipo de contenedor
   - HLOD/Precintos (editable)

3. **Transportista y Conductor:**
   - Nombre, dirección, CP, población, provincia, NIF del transportista
   - Nombre y NIF del conductor
   - Matrícula cabeza tractora
   - Plataforma

4. **Retirada y Entrega:**
   - RETIRAR DE: Nombre, dirección, CP, población, provincia
   - ENTREGAR EN: Nombre, dirección, CP, población, provincia

5. **Mercancía:**
   - Descripción de mercancía
   - Bultos
   - Peso
   - Temperatura máxima/mínima
   - Conectar (temperatura)

6. **Dimensiones Extras:**
   - Ext. Derecha, Izquierda, Frontal, Trasera, Altura

7. **Clasificación IMO (si aplica):**
   - ONU
   - Versión IMDG
   - Página IMDG
   - Clase
   - Notificación APV

8. **Datos Marítimos:**
   - Línea naviera
   - Nº Escala
   - Buque
   - Viaje
   - Distintivo de llamada

9. **Puertos:**
   - Puerto origen
   - Puerto destino
   - Puerto descarga/carga
   - Tipo orden (importación/exportación)

10. **Cargador:**
    - Referencia de carga
    - PIF/Aduana
    - Nombre, CIF, dirección del cargador

11. **Lugares Carga/Descarga:**
    - Tabla con múltiples lugares
    - Para cada lugar: nombre, dirección, CP, población, provincia, teléfono

12. **Observaciones:**
    - Número de Booking
    - Observaciones adicionales

**Funcionalidad especial:**
- **Edición de contenedor:** Permite modificar el número de contenedor si `$mostrarContPrecinto == 1`
- **Edición de precinto:** Permite modificar el HLOD/precinto

---

### 🚚 Tipo T - Terrestre
**Identificación:** `$tipoOrdenTransporte == 'T'`

**Datos mostrados:**
1. **Información del Transportista:**
   - Nombre
   - NIF/DNI
   - Dirección
   - Población

2. **Conductor:**
   - Nombre
   - NIF/DNI

3. **Vehículo:**
   - Matrícula
   - Plataforma
   - Tipo de plataforma

4. **Viajes Carga/Descarga:**
   - Cards diferenciados por color:
     - **Azul (border-info):** Viajes de CARGA
     - **Rojo (border-danger):** Viajes de DESCARGA
   
   - Para cada viaje:
     - Empresa
     - Dirección
     - Población
     - CP/País
     - Teléfono

---

### 🌐 Tipo M - Multimodal
**Identificación:** `$tipoOrdenTransporte == 'M'`

**Datos mostrados:**
1. **Información del Transportista:**
   - Nombre
   - NIF/DNI
   - Dirección
   - Población

2. **Conductor:**
   - Nombre
   - NIF/DNI

3. **Vehículo:**
   - Matrícula
   - Plataforma
   - Tipo de plataforma
   - Nº Pedido Cliente

4. **Cliente:**
   - Nombre
   - NIF

5. **Ubicaciones de Plataforma:**
   - LA PLATAFORMA SE RECOGE EN (verde)
   - LA PLATAFORMA SE DEJA EN (rojo)

6. **Viajes Carga/Descarga:**
   - Cards diferenciados (igual que Tipo T)
   - Información adicional por viaje:
     - Mercancía
     - Fecha
     - Hora
     - Ref. Carga

---

## Funcionalidades Interactivas

### 1. Gestión de Viajes

#### Selección de Viaje
```html
<select class="form-control" id="selectViajes">
```
- Dropdown con todos los viajes de la orden
- Formato: `{Empresa} - {Dirección} - {CARGA/DESCARGA}`
- Al seleccionar, muestra formulario de registro

#### Registro de Viaje
Campos habilitados tras seleccionar un viaje:
```javascript
- fechaLlegada: datetime-local
- fechaSalida: datetime-local  
- ObservacionViaje: textarea
```

**Validación:**
- Hora de llegada debe ser anterior a hora de salida
- Campos obligatorios para firmar documento

---

### 2. Firma Digital

#### Sistema de Firmas
La aplicación utiliza **jQuery Signature Pad** para capturar firmas digitales.

**Tipos de firmas soportadas:**
1. **Firma del Conductor:** Quien realiza el transporte
2. **Firma del Receptor:** Quien recibe la mercancía
3. **Firma del Cliente:** Cliente final (solo en tipos T y M)

**Flujo de firma:**
```javascript
1. Usuario selecciona viaje
2. Rellena datos de llegada/salida
3. Click en "Firmar Documento"
4. Se abre modal con canvas de firma
5. Usuario firma con mouse/táctil
6. Sistema convierte firma a imagen base64
7. Se guarda junto con datos del viaje
```

**Validaciones de firma:**
```javascript
// Nombre y DNI obligatorios para habilitar firma
if ($("#nombreInputConductor").val() == "" || $("#DNIinputConductor").val() == "") {
    $("#fsignatureContainerConductor").addClass("d-none");
}
```

---

### 3. Código QR

#### Generación de QR
Utiliza librería **QR Code Styling** para generar códigos QR personalizados.

**Configuración:**
```javascript
var qrCode = new QRCodeStyling({
    width: 200,
    height: 200,
    dotsOptions: {
        color: "#01612A",
        type: "rounded"
    },
    backgroundOptions: {
        color: "#e9ebee"
    }
});
```

**Datos codificados:**
```php
$jsonDatos['OA_PCS_LOCATOR']
```
- Localizador único de la orden
- Permite trazabilidad desde dispositivos móviles

**Funcionalidad:**
- Click en botón "Mostrar QR"
- Genera QR con localizador de orden
- Puede ser escaneado para acceso rápido
- Si no hay localizador, muestra mensaje de error

---

### 4. Impresión de Documentos

#### Tipos de Documentos
El sistema permite imprimir diferentes variantes del documento:

**Modal de selección:**
```javascript
data-bs-target="#tipoDocumentoModal"
```

**Tipos disponibles:**
- **Orden completa:** Documento con todos los datos
- **Documento cliente:** Versión simplificada para cliente
- **Documento por viaje:** Específico de un viaje

**Generación:**
```javascript
window.open(
    "orden.php?idOrden=" + tokenId + 
    "&tipoDocumento=" + tipoDocumento +
    "&contenedorActivo=" + contenedorActivo +
    "&tipoOrdenTransporte=" + tipoOrden,
    "_blank",
    "width=1920,height=1080,scrollbars=yes"
);
```

---

### 5. Gestión de Incidencias

#### Acceso a Incidencias
```html
<a href="incidencias?orden=<?php echo $tokenOrden; ?>">
    <i class="fa-solid fa-triangle-exclamation"></i>
</a>
```

**Funcionalidad:**
- Permite reportar problemas con la orden
- Registro de incidencias durante el transporte
- Seguimiento de resolución

---

### 6. Subida de Documentación

#### Modal Gesdoc
```html
data-bs-target="#modalOrdenGesdoc"
```

**Permite subir:**
- CMR (Carta de Porte)
- Albaranes
- Facturas
- Fotografías de mercancía
- Documentación aduanera
- Otros documentos relacionados

**Almacenamiento:**
- Archivos vinculados al token de la orden
- Accesibles desde panel de administración
- Organizados por tipo de documento

---

## Botones Flotantes (Sidebar)

Sistema de acciones rápidas mediante botones flotantes personalizados:

### Botón 1 - Incidencias (botonFlotante1)
```html
<aside class="customizer botonFlotante1">
    <a href="incidencias?orden=<?php echo $tokenOrden; ?>" 
       class="colorBoton1">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </a>
</aside>
```
- **Color:** Gris (`#c1c0a3`)
- **Posición:** Superior
- **Función:** Abrir gestión de incidencias

### Botón 2 - Imprimir (botonFlotante2)
```html
<aside class="customizer botonFlotante2">
    <a data-bs-toggle="modal" data-bs-target="#tipoDocumentoModal" 
       class="colorBoton2">
        <i class="fa-solid fa-print"></i>
    </a>
</aside>
```
- **Color:** Morado (`#b2a3c1`)
- **Posición:** 60px desde arriba
- **Función:** Abrir modal de impresión

### Botón 3 - Subir Archivos (botonFlotante3)
```html
<aside class="customizer botonFlotante3">
    <a data-bs-toggle="modal" data-bs-target="#modalOrdenGesdoc" 
       class="colorBoton3">
        <i class="fa-solid fa-cloud-arrow-up"></i>
    </a>
</aside>
```
- **Color:** Turquesa (`#a3c1be`)
- **Posición:** 120px desde arriba
- **Función:** Subir documentación

### Botón 4 - Salir (botonFlotante4)
```html
<aside class="customizer botonFlotante4">
    <a href="./" class="colorBoton4">
        <i class="fa-solid fa-right-from-bracket"></i>
    </a>
</aside>
```
- **Color:** Rosa (`#c1a7a7`)
- **Posición:** 180px desde arriba
- **Función:** Volver al listado de órdenes

### Botón 5 - Ayuda (botonFlotante5)
```html
<aside class="customizer botonFlotante5">
    <a data-bs-toggle="modal" data-bs-target="#ayuda_modal" 
       class="colorBoton5">
        <i class="fa-solid fa-circle-question"></i>
    </a>
</aside>
```
- **Color:** Verde claro (`#aed581`)
- **Posición:** 470px desde arriba
- **Función:** Mostrar ayuda contextual

---

## Modales Incluidos

### 1. modalAgregar.php
Modal para agregar nuevos elementos (dependiendo del contexto).

### 2. modalEditar.php
Modal para editar información existente.

### 3. modalQr.php
Modal que contiene el código QR generado dinámicamente.

### 4. modalFirma.php
Modal con canvas de firma digital y campos de identificación.

### 5. modalAyuda.php
Modal con ayuda contextual específica de la página.

### 6. modalOrdenGesdoc.php
Modal para subir documentación relacionada con la orden.

### 7. modalContenedor.php
Modal para editar número de contenedor (si está habilitado).

### 8. modalTipoDocumentoExport.php / modalTipoDocumentoExportTM.php
Modal para seleccionar tipo de documento a imprimir:
- Versión para tipo C (contenedor)
- Versión para tipos T y M (terrestre/multimodal)

---

## Edición de Contenedor y Precinto

### Funcionalidad de Edición
Solo disponible si `$mostrarContPrecinto == 1`.

#### Edición de Contenedor
```javascript
#cambiarModoContenedor    // Activar modo edición
#cancelarModoContenedor   // Cancelar cambios
#guardarModoContenedor    // Guardar nuevo valor
```

**Flujo:**
1. Click en icono de lápiz (rojo)
2. Input se habilita para edición
3. Aparecen botones X (cancelar) y ✓ (guardar)
4. Al guardar, se actualiza en BD

#### Edición de Precinto
```javascript
#cambiarModoPrecinto      // Activar modo edición
#cancelarModoPrecinto     // Cancelar cambios
#guardarModoPrecinto      // Guardar nuevo valor
```

**Validaciones:**
- Los valores originales se guardan en inputs hidden
- Al cancelar, restaura valor original
- Al guardar, realiza llamada AJAX al controlador

---

## Estructura de Datos JSON

### Campos Comunes (todos los tipos)
```json
{
  "TTE_COD": "Código único",
  "TTE_ORDEN": "Número de orden",
  "TRANSPORTISTA_NOMBRE": "Nombre",
  "TRANSPORTISTA_NIF": "NIF",
  "TRANSPORTISTA_DIRECCION": "Dirección",
  "TRANSPORTISTA_CP": "CP",
  "TRANSPORTISTA_POBLACION": "Población",
  "TRANSPORTISTA_PROVINCIA": "Provincia",
  "CONDUCTOR_NOMBRE": "Nombre",
  "CONDUCTOR_NIF": "NIF",
  "CONDUCTOR_EMAIL": "Email",
  "TRACTORA": "Matrícula",
  "PLATAFORMA": "Plataforma"
}
```

### Campos Específicos Tipo C (Contenedor)
```json
{
  "TTE_FECHA_CARGA": "Fecha",
  "TTE_HORA_CARGA": "Hora",
  "TTE_REF_CONSIG": "Referencia",
  "TTE_FECHA_ESTIMADA_RECOGIDA": "Fecha",
  "TTE_FECHA_ESTIMADA_ENTREGA": "Fecha",
  "CONSIGNATARIO": "Nombre",
  "TIPO_CONT_DESC": "Tipo contenedor",
  "RECOGER_EN_NOMBRE": "Nombre",
  "RECOGER_EN_DIRECCION": "Dirección",
  "RECOGER_EN_CP": "CP",
  "RECOGER_EN_POBLACION": "Población",
  "RECOGER_EN_PROVINCIA": "Provincia",
  "DEVOLVER_EN_NOMBRE": "Nombre",
  "DEVOLVER_EN_DIRECCION": "Dirección",
  "DEVOLVER_EN_CP": "CP",
  "DEVOLVER_EN_POBLACION": "Población",
  "DEVOLVER_EN_PROVINCIA": "Provincia",
  "MERCANCIA": "Descripción",
  "BULTOS": "Cantidad",
  "PESO_MERCANCIA": "Peso en KG",
  "TEMP_MAXIMA": "Temperatura",
  "TEMP_MINIMA": "Temperatura",
  "TEMP_CONECTAR": "Sí/No",
  "EXTRA_RIGHT": "Medida",
  "EXTRA_LEFT": "Medida",
  "EXTRA_FRONT": "Medida",
  "EXTRA_BACK": "Medida",
  "EXTRA_ALTO": "Medida",
  "IMO_ONU": "Código",
  "IMO_VERSION": "Versión",
  "IMO_PAGINA": "Página",
  "IMO_CLASE": "Clase",
  "IMO_PORT_NOTIFICATION": "Notificación",
  "NOMBRELINEA_DEST": "Línea",
  "ESCALA_DEST": "Escala",
  "BUQUE_DEST": "Buque",
  "VIAJE": "Viaje",
  "DISTINTIVO_LLAMADA": "Distintivo",
  "PUERTO_ORIGEN_NOMBRE": "Puerto",
  "PUERTO_DESTINO_NOMBRE": "Puerto",
  "PUERTO_DESCARGA_NOMBRE": "Puerto",
  "PUERTO_TIPO_ORDEN_IMPORTACION": "Tipo",
  "CARGADOR_REF_CARGA": "Referencia",
  "PIF_NOMBRE": "PIF/Aduana",
  "CARGADOR_NOMBRE": "Nombre",
  "CARGADOR_CIF": "CIF",
  "CARGADOR_DIRECCION": "Dirección",
  "CARGADOR_POBLACION": "Población",
  "CARGADOR_PROVINCIA": "Provincia",
  "LUGARES": [
    {
      "LUGAR_NOMBRE": "Nombre",
      "LUGAR_DIRECCION": "Dirección",
      "LUGAR_CP": "CP",
      "LUGAR_POBLACION": "Población",
      "LUGAR_PROVINCIA": "Provincia",
      "LUGAR_TELEFONO": "Teléfono"
    }
  ],
  "PCS_BOOKING_NUMBER": "Booking",
  "OBSERVACIONES": "Texto",
  "OA_PCS_LOCATOR": "Localizador QR"
}
```

### Campos Específicos Tipo T (Terrestre)
```json
{
  "TTE_FECHA_CARGA": "Fecha",
  "PLATAFORMA_TIPO": "Tipo",
  "LUGARES_CARGA": [
    {
      "LUGAR_NOMBRE": "Nombre",
      "LUGAR_DIRECCION": "Dirección",
      "LUGAR_CP": "CP",
      "LUGAR_POBLACION": "Población",
      "LUGAR_PROVINCIA": "Provincia",
      "LUGAR_TELEFONO": "Teléfono"
    }
  ]
}
```

### Campos Específicos Tipo M (Multimodal)
```json
{
  "LUGAR_COMIENZO_NOMBRE": "Lugar inicio",
  "LUGAR_FIN_NOMBRE": "Lugar fin",
  "MERCANCIA": "Descripción",
  "TTE_FECHA_CARGA": "Fecha",
  "CARGADOR_REF_CARGA": "Referencia"
}
```

---

## Tablas de Base de Datos Relacionadas

### 1. orden-Transporte
Tabla principal de órdenes.

**Campos clave:**
- `idOrden`: ID autoincremental
- `num_transporte`: Número de orden
- `tipoOrdenTransporte`: C, T o M
- `tokenOrden`: Token único de 30 caracteres
- `jsonOrdenTransporte`: JSON completo con todos los datos
- `contenedorActivo`: Matrícula del contenedor
- `precintoActivo`: HLOD/Precinto
- `estOrden`: Estado de la orden

### 2. viajes-Orden
Tabla de viajes asociados a órdenes.

**Campos:**
- `idViaje`: ID autoincremental
- `idOrden`: FK a orden-Transporte
- `tipoViaje`: 'CARGA' o 'DESCARGA'
- `LUGAR_NOMBRE`: Empresa
- `LUGAR_DIRECCION`: Dirección
- `LUGAR_CP`: Código postal
- `LUGAR_POBLACION`: Población
- `LUGAR_PROVINCIA`: Provincia
- `LUGAR_TELEFONO`: Teléfono
- `fechaLlegada`: Timestamp llegada
- `fechaSalida`: Timestamp salida
- `observaciones`: Texto libre
- `firmaConductor`: Imagen base64
- `firmaReceptor`: Imagen base64
- `firmaCliente`: Imagen base64 (solo T y M)

---

## Seguridad y Control de Acceso

### Verificación de Roles
```php
checkAccess(['0', '1']);
```
- **Rol 0:** PROFESOR (conductores)
- **Rol 1:** ADMIN (administradores)

Solo estos roles pueden acceder a la vista de órdenes.

### Inputs Hidden
```html
<input type="hidden" id="tokenId" value="<?php echo $tokenOrden; ?>">
<input type="hidden" id="tipoOrdenTransporte" value="<?php echo $tipoOrdenTransporte; ?>">
<input type="hidden" id="idOrden" value="<?php echo $idOrden; ?>">
<input type="hidden" id="primerCodigo" value="<?php echo $jsonDatos['OA_PCS_LOCATOR']; ?>">
```

Almacenan datos sensibles necesarios para operaciones JavaScript sin exponerlos visualmente.

---

## Estilos CSS Personalizados

### Secciones de Datos
```css
.seccion-de-datos  { background-color: #B2F3E6; }
.seccion-de-datos2 { background-color: #D0FFC2; }
.seccion-de-datos3 { background-color: #C1F2C1; }
```
Diferenciación visual de secciones.

### Animaciones
```css
.slide-out-left   /* Deslizar a la izquierda */
.slide-in-right   /* Deslizar desde derecha */
.slide-in-left    /* Deslizar desde izquierda */
.slide-out-right  /* Deslizar a la derecha */
```
Transiciones suaves para cambios de vista.

### Galería de Imágenes
```css
.image-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr); /* 5 columnas en desktop */
}

@media (max-width: 1024px) { /* 3 columnas en tablet */ }
@media (max-width: 768px)  { /* 2 columnas en móvil */ }
```

Diseño responsive para visualización de documentos adjuntos.

---

## JavaScript y Dependencias

### Librerías Utilizadas

1. **jQuery Signature Pad**
   ```html
   <script src="./firma/jquery.signaturepad.js"></script>
   ```
   - Captura de firmas digitales
   - Conversión a imagen

2. **QR Code Styling**
   ```html
   <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.min.js"></script>
   ```
   - Generación de códigos QR
   - Personalización visual

3. **Lobibox (Notificaciones)**
   ```html
   <script src="../../public/assets/plugins/notifications/js/lobibox.min.js"></script>
   ```
   - Notificaciones visuales
   - Alertas de éxito/error

4. **Bezier.js**
   ```html
   <script src="./firma/assets/bezier.js"></script>
   ```
   - Suavizado de trazos de firma

### Archivo JavaScript Principal
```html
<script src="index.js"></script>
```

**Variables globales:**
```javascript
var idDatatables = "ordenes_table";
var phpPrincipal = "transportes.php";
var viajeSeleccionado = "";
var datosJson = "";
```

---

## Flujo de Trabajo Típico

### Para Conductor (Rol 0)

```
1. Accede mediante token de orden
   ↓
2. Visualiza detalles completos de la orden
   ↓
3. Selecciona viaje a realizar (carga o descarga)
   ↓
4. Registra hora de llegada
   ↓
5. Realiza la carga/descarga
   ↓
6. Registra hora de salida
   ↓
7. Añade observaciones si es necesario
   ↓
8. Firma digitalmente el viaje
   ↓
9. Solicita firma del receptor
   ↓
10. Guarda viaje completado
    ↓
11. Repite para cada viaje de la orden
    ↓
12. Sube documentación (CMR, fotos, etc.)
    ↓
13. Finaliza orden
```

### Para Administrador (Rol 1)

```
1. Accede a orden desde listado
   ↓
2. Revisa todos los datos
   ↓
3. Puede editar contenedor/precinto si está habilitado
   ↓
4. Genera código QR para trazabilidad
   ↓
5. Imprime documentación necesaria
   ↓
6. Revisa viajes completados y firmas
   ↓
7. Gestiona incidencias si existen
   ↓
8. Revisa documentación adjunta
   ↓
9. Cierra orden si todo está correcto
```

---

## Validaciones y Reglas de Negocio

### Viajes
- No se puede firmar sin seleccionar viaje
- Fecha de llegada debe ser anterior a fecha de salida
- Observaciones son opcionales
- Firma obligatoria para completar viaje

### Edición de Contenedor/Precinto
- Solo disponible para órdenes tipo C
- Requiere permisos específicos (`$mostrarContPrecinto`)
- Cambios se registran en logs
- Validación de formato en backend

### Código QR
- Solo se genera si existe `OA_PCS_LOCATOR`
- Muestra error si no está disponible
- QR reutilizable para toda la orden

### Documentación
- Formatos permitidos: PDF, JPG, PNG
- Tamaño máximo configurable
- Organización por tipo de documento
- Vinculación automática a orden

---

## Respuestas del Sistema

### Éxito
```javascript
toastr.success("Viaje guardado correctamente");
```

### Error
```javascript
toastr.error("Debe seleccionar un viaje");
toastr.error("El QR no está disponible en esta orden");
```

### Advertencia
```javascript
toastr.warning("Complete todos los campos obligatorios");
```

### Información
```javascript
toastr.info("Procesando firma digital...");
```

---

## Mejoras Sugeridas

### Funcionalidad
- ✅ Geolocalización automática en llegada/salida
- ✅ Firma offline con sincronización posterior
- ✅ Fotografías obligatorias de mercancía
- ✅ Chat en tiempo real con dispatcher
- ✅ Navegación GPS integrada a lugares de entrega

### UX/UI
- ✅ Modo offline para conductores sin conexión
- ✅ Vista simplificada para móviles
- ✅ Accesos directos para acciones frecuentes
- ✅ Tutorial interactivo para nuevos usuarios
- ✅ Widgets de estado en tiempo real

### Seguridad
- ✅ Verificación biométrica para firmas
- ✅ Encriptación de firmas digitales
- ✅ Trazabilidad completa de cambios
- ✅ Backup automático de documentación

### Performance
- ✅ Carga lazy de imágenes de documentos
- ✅ Cache de datos de orden
- ✅ Compresión de firmas antes de guardar
- ✅ Optimización de consultas a BD

---

## Notas Importantes

- 📱 La interfaz es **responsive** y se adapta a móviles/tablets
- 🔒 Todas las operaciones críticas requieren **autenticación**
- 📊 Los cambios quedan **registrados en logs** para auditoría
- ⚡ Las firmas se guardan en **formato base64** optimizado
- 🌐 El código QR permite **acceso rápido** desde cualquier dispositivo
- 📄 La impresión genera **PDFs** con formato profesional
- 🎨 Los colores de viajes facilitan **identificación visual** rápida
- 🔄 El sistema soporta **múltiples viajes** por orden
- ✍️ Las firmas digitales tienen **validez legal** en formato base64

---

## Documentación Relacionada

- [subir_ordenes.md](subir_ordenes.md) - Cómo se crean las órdenes desde FTP
- [general.md](general.md) - Estructura general de la aplicación
- **Model:** `models/Transportes.php` - Lógica de negocio
- **Controller:** `controller/transportes.php` - Procesamiento de peticiones
- **View:** `view/Transportes/` - Todas las vistas de transportes
