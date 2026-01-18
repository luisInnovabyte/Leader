<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Para la hora correcta
date_default_timezone_set('Europe/Madrid');

// Ruta del directorio local donde están los archivos a enviar
$directorio_local = __DIR__ . '/envios/';
// Definir la carpeta de destino para los archivos subidos correctamente
$directorio_destino = __DIR__ . '/envios_procesados/';
// Nombre de la carpeta que deseas crear en el servidor FTP
$nombre_carpeta = "responsesEfeuno"; // Cambia esto al nombre deseado


$dominioCompleto = $_SERVER['HTTP_HOST'];
// Guardar directamente el dominio o la IP completa
$nombreDominio = $dominioCompleto;
// Construir la ruta al archivo de configuración basado en el nombre del dominio
$jsonContentSettings = file_get_contents(__DIR__ . '/../../config/settings/' . $nombreDominio . '.json');
// Convertir el JSON a un arreglo asociativo de PHP
$configJsonSetting = json_decode($jsonContentSettings, true);

// Acceder a las variables de entorno FTP encontradas en archivo JSON
$ipFTP = $configJsonSetting['ftpConfig']['ipFTP'];
$userFTP = $configJsonSetting['ftpConfig']['userFTP'];
$passFTP = $configJsonSetting['ftpConfig']['passFTP'];
$portFTP = $configJsonSetting['ftpConfig']['portFTP'];

// Credenciales FTP del cliente
$ftp_server = $ipFTP;
$ftp_user = $userFTP;
$ftp_pass = $passFTP;
$ftp_port = $portFTP; // Ajusta el puerto si es necesario

// $ftp_pass = "fTp2o24efeUn0";


// Conectar al servidor FTP en el puerto especificado
$ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("No se pudo conectar a $ftp_server en el puerto $ftp_port");

// Intentar iniciar sesión con manejo de errores
if (!ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
    ftp_close($ftp_conn);
    die("Error: No se pudo iniciar sesión con las credenciales proporcionadas. FTP");
}

// Activar modo pasivo
ftp_pasv($ftp_conn, true);

//echo "Conexión FTP exitosa!";

// Activar modo pasivo
ftp_pasv($ftp_conn, true);


// Comprobar si la carpeta ya existe en el servidor FTP
$carpetas = ftp_nlist($ftp_conn, ".");
if (in_array($nombre_carpeta, $carpetas)) {
    //echo "La carpeta '$nombre_carpeta' ya existe en el servidor FTP.<br>";
} else {
    // Crear la carpeta si no existe
    if (ftp_mkdir($ftp_conn, $nombre_carpeta)) {
        //echo "Carpeta '$nombre_carpeta' creada exitosamente en el servidor FTP.<br>";
    } else {
        //echo "Error al crear la carpeta '$nombre_carpeta'.<br>";
    }
}

// Obtener todos los archivos del directorio
$archivos = glob($directorio_local . '*'); // Obtiene todos los archivos en el directorio

if (!$archivos) {
    die("No se encontraron archivos en el directorio: $directorio_local");
}

// Matriz asociativa para almacenar los resultados de la subida
$resultados = [];

// Recorrer cada archivo y subirlo al servidor FTP
foreach ($archivos as $archivo_local) {
    // Obtener el nombre del archivo (sin la ruta completa)
    $nombreDocumento = basename($archivo_local);

    // Ruta completa del archivo en el servidor FTP (incluye la carpeta)
    $archivo_remoto = 'responsesEfeuno/' . $nombreDocumento;

    // Subir el archivo al servidor FTP
    if (ftp_put($ftp_conn, $archivo_remoto, $archivo_local, FTP_BINARY)) {
        //echo "El archivo local lo coge de: <code>$archivo_local</code><br>";
        //echo "El archivo remoto lo sube a: <code>$archivo_remoto</code><br>";
        //echo "<strong>Éxito:</strong> El archivo <code>$archivo_local</code> se ha subido correctamente como <code>$archivo_remoto</code> en el servidor FTP.<br>";
        $resultados[$nombreDocumento] = 1; // Subida exitosa
    } else {
        //echo "Error al subir el archivo $archivo_local.<br>";
        $resultados[$nombreDocumento] = 0; // Error en la subida
    }
}

// Obtener la fecha actual en formato YYYYMMDD
$fecha_actual = date('Ymd');

// Crear la carpeta diaria dentro del directorio de destino
$directorio_destino_diario = $directorio_destino . $fecha_actual . '/';

// Crear la carpeta si no existe
if (!is_dir($directorio_destino_diario)) {
    if (mkdir($directorio_destino_diario, 0777, true)) {
        //echo "Carpeta diaria creada: <code>$directorio_destino_diario</code><br>";
    } else {
        die("Error al crear la carpeta diaria: <code>$directorio_destino_diario</code><br>");
    }
}

// Mostrar los resultados
echo "<br>Resultados de la subida:<br>";
foreach ($resultados as $archivo => $estado) {
    //echo "Archivo: <code>$archivo</code> - Estado: " . ($estado ? "Éxito" : "Error") . "<br>";

    // Mover los archivos con estado 1 a la carpeta de destino diaria
    if ($estado === 1) {
        $ruta_origen = $directorio_local . $archivo;
        $ruta_destino = $directorio_destino_diario . $archivo;

        if (rename($ruta_origen, $ruta_destino)) {
            //echo "Archivo <code>$archivo</code> movido a la carpeta de destino: <code>$directorio_destino_diario</code><br>";
        } else {
            //echo "Error al mover el archivo <code>$archivo</code> a la carpeta de destino.<br>";
        }
    }
}

// Cerrar la conexión FTP
ftp_close($ftp_conn);

// Obtener la fecha y hora actual para el nombre del archivo log
$fecha_hora_actual = date('Ymd_His');
$nombre_archivo_log = $directorio_destino_diario . "log_{$fecha_hora_actual}.json";

// Crear el archivo log en el directorio de destino diario
$log_data = []; // Array para almacenar los datos del log

foreach ($resultados as $archivo => $estado) {
    $estado_texto = $estado ? "Éxito" : "Error";
    $fecha_hora_traspaso = date('Y-m-d H:i:s');
    $log_data[] = [
        'archivo' => $archivo,
        'estado' => $estado_texto,
        'fecha_hora' => $fecha_hora_traspaso
    ];
}

// Convertir los datos del log a formato JSON
$json_log = json_encode($log_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Escribir el JSON en el archivo
if (file_put_contents($nombre_archivo_log, $json_log) === false) {
    die("Error al crear el archivo log JSON: <code>$nombre_archivo_log</code><br>");
}
//echo "Archivo log JSON generado en la carpeta diaria: <code>$nombre_archivo_log</code><br>";
