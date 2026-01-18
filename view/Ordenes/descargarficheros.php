<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['usu_id']) || empty($_SESSION['usu_id'])) {
    // Sesión caducada o no existe
    echo "<script>
        alert('Su sesión ha expirado. Será redirigido al login.');
        if (window.opener) {
            window.close();
            window.opener.location.href = '../Login/';
        } else {
            window.location.href = '../Login/';
        }
    </script>";
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Aumentar el tiempo de ejecución del script a ilimitado
set_time_limit(0);
// Aumentar el límite de memoria a 512 MB (o más si es necesario)
ini_set('memory_limit', '512M');

date_default_timezone_set('Europe/Madrid');
// Función para enviar respuesta JSON y salir
function responder($status, $message, $data = null) {
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
 }

$directorio_localFtp = __DIR__ . '/descargas/';
$directorio_controlJson = __DIR__ . '/descargas/control_descargas/';

$numeroArchivosPorLote = 50;

$fechaActual = new DateTime();
$fecha = $fechaActual->format('Y-m-d H:i:s');

$fechaHoraActual = date('Ymd_His');
// Ruta del archivo JSON de registro
$nombreArchivoJson = $directorio_controlJson . "control_descarga_" . $fechaHoraActual . ".json";


// FUNCION LOG //
function validarCorreo($email)
{
    // Verificar si el email es null o está vacío, usar email por defecto
    if ($email === null || $email === '') {
        return 'sin-email@transporte.local';
    }
    
    $email = trim($email);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    }

    // Si no es válido, también usar el email por defecto
    return 'sin-email@transporte.local';
}

function validarIdentificador($identificador)
{
    // Eliminar espacios y convertir a mayúsculas
    $identificador = strtoupper(trim($identificador));

    // Verificar longitud
    if (strlen($identificador) != 9) {
        return false;
    }

    // Obtener la letra y los números
    $numero = substr($identificador, 0, -1);
    $control = substr($identificador, -1);

    // Verificar si es un DNI
    if (is_numeric($numero)) {
        return validarDNIOuNIF($numero, $control);
    }

    // Verificar si es un NIF
    $primeraLetra = substr($numero, 0, 1);
    $restoNumeros = substr($numero, 1);

    if (preg_match('/[XYZ]/', $primeraLetra)) {
        $numero = str_replace(['X', 'Y', 'Z'], ['0', '1', '2'], $numero);
        return validarDNIOuNIF($numero, $control);
    }

    if (preg_match('/[ABCDEFGHJKLMNPQRSUVW]/', $primeraLetra) && is_numeric($restoNumeros)) {
        return validarCIF($numero, $control);
    }

    return false;
}


function validarDNIOuNIF($numero, $letra)
{
    // Calcular la letra correcta
    $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
    $letraCalculada = $letras[intval($numero) % 23];

    // Comparar la letra calculada con la letra proporcionada
    return $letraCalculada === $letra;
}

function validarCIF($numero, $control)
{
    $letraInicial = substr($numero, 0, 1);
    $numeroCif = substr($numero, 1);
    $sumaPar = 0;
    $sumaImpar = 0;

    // Sumar valores pares e impares
    for ($i = 0; $i < strlen($numeroCif); $i++) {
        $n = intval($numeroCif[$i]);
        if ($i % 2 == 0) {
            $doble = $n * 2;
            $sumaImpar += $doble < 10 ? $doble : $doble - 9;
        } else {
            $sumaPar += $n;
        }
    }

    $sumaTotal = $sumaPar + $sumaImpar;
    $digitoControl = (10 - ($sumaTotal % 10)) % 10;

    // Verificar control
    if (preg_match('/[ABEH]/', $letraInicial)) {
        // El CIF debe tener un dígito de control
        return $control == $digitoControl;
    } elseif (preg_match('/[KPQS]/', $letraInicial)) {
        // El CIF debe tener una letra de control
        $letras = "JABCDEFGHI";
        return $control == $letras[$digitoControl];
    } else {
        // El CIF puede tener un dígito o letra de control
        $letras = "JABCDEFGHI";
        return $control == $digitoControl || $control == $letras[$digitoControl];
    }
}

function generarToken($longitud = 32)
{
    // Asegúrate de que la longitud sea siempre un número par
    if ($longitud % 2 !== 0) {
        $longitud++; // Si la longitud es impar, la incrementamos para que sea par
    }

    // Genera bytes aleatorios seguros
    $bytes = random_bytes($longitud / 2);

    // Convierte los bytes en una cadena hexadecimal
    $token = bin2hex($bytes);

    return $token;
}


$errorText = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descarga de Órdenes FTP - Proceso en Tiempo Real</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .log-entry {
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            border-left: 4px solid;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .log-entry.success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .log-entry.info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }

        .log-entry.warning {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }

        .log-entry.error {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        .log-entry strong {
            font-weight: 600;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 2px solid #e9ecef;
        }

        h3, h4 {
            color: #333;
            margin: 20px 0 10px 0;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,.1);
            border-radius: 50%;
            border-top-color: #667eea;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
            font-size: 13px;
            line-height: 1.6;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .badge.success { background-color: #28a745; color: white; }
        .badge.info { background-color: #17a2b8; color: white; }
        .badge.warning { background-color: #ffc107; color: #333; }
        .badge.error { background-color: #dc3545; color: white; }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Descarga de Órdenes desde FTP</h1>
            <p>Proceso en tiempo real - <?php echo date('d/m/Y H:i:s'); ?></p>
        </div>
        
        <div class="content">

        <?php
        // TRY CONEXION //
        //ob_start();

        echo "<div class='log-entry info'><strong>🚀 INICIO DEL PROCESO</strong><span class='badge info'>" . date('H:i:s') . "</span></div>";
        flush();

        try {
               echo "<div class='log-entry info'><strong>PASO 1:</strong> Detectando dominio...</div>";
               flush();
               // Obtener el dominio completo (por ejemplo, "efeuno.es" o "www.efeuno.es")
                $dominioCompleto = $_SERVER['HTTP_HOST'];
                
                // Usar el dominio completo directamente (incluyendo IP si es el caso)
                $nombreDominio = $dominioCompleto;
                
            echo "<div class='log-entry success'>✅ Dominio: <strong>$nombreDominio</strong></div>";
            echo "<div class='log-entry info'>📁 Archivo config: settings/$nombreDominio.json</div>";
            flush();
            
            // Construir la ruta al archivo de configuración basado en el nombre del dominio
            echo "<div class='log-entry info'><strong>PASO 2:</strong> Cargando configuración...</div>";
            flush();
            $jsonContentSettings = file_get_contents(__DIR__ . '/../../config/settings/' . $nombreDominio . '.json');

            // Convertir el JSON a un arreglo asociativo de PHP
            $configJsonSetting = json_decode($jsonContentSettings, true);
            echo "<div class='log-entry success'>✅ Configuración cargada correctamente</div>";
            flush();

            // Acceder a las variables de entorno de la base de datos
            $dbHost = $configJsonSetting['database']['host'];
            $dbPort = $configJsonSetting['database']['port'];
            $dbName = $configJsonSetting['database']['dbname'];
            $dbUser = $configJsonSetting['database']['username'];
            $dbPassword = $configJsonSetting['database']['password'];



            // CONEXION A LA BASE DE DATOS //
            echo "<div class='log-entry info'><strong>PASO 3:</strong> Conectando a la base de datos...</div>";
            echo "<div class='log-entry info'>🗄️ Host: <strong>$dbHost:$dbPort</strong> | DB: <strong>$dbName</strong></div>";
            flush();
            $conectar = new PDO("mysql:host=" . $dbHost . ";port=" . $dbPort . ";dbname=" . $dbName . "", "" . $dbUser . "", "" . $dbPassword . "");

            // Establecer el modo de error de PDO para que lance excepciones en caso de error
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<div class='log-entry success'>✅ Conexión a BD establecida correctamente</div>";
            flush();
            $ipFTP = $configJsonSetting['ftpConfig']['ipFTP'];
            $userFTP = $configJsonSetting['ftpConfig']['userFTP'];
            $passFTP = $configJsonSetting['ftpConfig']['passFTP'];
            $portFTP = $configJsonSetting['ftpConfig']['portFTP'];

            // Credenciales FTP del cliente
            $ftp_server = $ipFTP;
            $ftp_user = $userFTP;
            $ftp_pass = $passFTP;
            $ftp_port = $portFTP; // Ajusta el puerto si es necesario

            echo "<div class='log-entry info'><strong>PASO 4:</strong> Conectando al servidor FTP...</div>";
            echo "<div class='log-entry info'>🌐 Servidor: <strong>$ftp_server:$ftp_port</strong> | Usuario: <strong>$ftp_user</strong></div>";
            flush();
            
            $ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("❌ ERROR: No se pudo conectar a $ftp_server en el puerto $ftp_port");
            echo "<div class='log-entry success'>✅ Conexión FTP establecida</div>";
            echo "<div class='log-entry info'>🔐 Iniciando sesión...</div>";
            flush();
            
            // Intentar iniciar sesión con manejo de errores
            if (!ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
                ftp_close($ftp_conn);
                echo "<div class='log-entry error'>❌ ERROR: No se pudo iniciar sesión</div>";
                responder('error', 'No se pudo iniciar sesión con las credenciales proporcionadas en el servidor FTP.');
            }
       
            echo "<div class='log-entry success'>✅ Login FTP exitoso</div>";
            flush();

            ftp_pasv($ftp_conn, true);
            echo "<div class='log-entry success'>✅ Modo pasivo activado</div>";
            flush();
          
            echo "<div class='log-entry info'><strong>PASO 5:</strong> Listando archivos en el servidor FTP...</div>";
            flush();
            $archivosFtp = ftp_nlist($ftp_conn, ".");
            
            if ($archivosFtp === false || empty($archivosFtp)) {
                echo "<div class='log-entry warning'>⚠️ No se encontraron archivos en el servidor FTP</div>";
                ftp_close($ftp_conn);
                responder('info', 'No hay archivos para descargar');
            }
            
            // Restar 1 para excluir el directorio "." del conteo
            $totalArchivos = count($archivosFtp) - 1;
            echo "<div class='log-entry success'>✅ Se encontraron <strong>$totalArchivos archivos</strong> en el servidor</div>";
            flush();
            
            $lotesArchivos = array_chunk($archivosFtp, $numeroArchivosPorLote);
            $totalLotes = count($lotesArchivos);
            echo "<div class='log-entry info'>📦 Divididos en <strong>$totalLotes lotes</strong> de $numeroArchivosPorLote archivos</div>";
            flush();

            // Procesar cada lote
            foreach ($lotesArchivos as $loteIndex => $lote) {
                $loteNum = $loteIndex + 1;
                echo "<hr><div class='log-entry info'><strong>📦 PROCESANDO LOTE $loteNum de $totalLotes</strong></div>";
                flush();

                // Abrir conexión FTP para este lote
                $ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("No se pudo conectar a $ftp_server en el puerto $ftp_port");
                if (!ftp_login($ftp_conn, $ftp_user, $ftp_pass)) {
                    ftp_close($ftp_conn);
                    responder('error', 'No se pudo iniciar sesión con las credenciales proporcionadas.');
                }
                ftp_pasv($ftp_conn, true);





                foreach ($lote as $archivo) {
                    if (pathinfo($archivo, PATHINFO_EXTENSION) === 'json') {
                        $ruta_local = $directorio_localFtp . $archivo;
                        //echo "Ruta local para guardar el archivo: $ruta_local<br>";
                        //flush();

                        // Descargar el archivo con reintentos
                        $maxReintentos = 4;
                        $reintento = 1;
                        $descargado = false;

                        while ($reintento <= $maxReintentos && !$descargado) {
                            //echo "Intentando descargar el archivo $archivo (Intento $reintento)...<br>";
                            if (@ftp_get($ftp_conn, $ruta_local, $archivo, FTP_BINARY)) {
                                //echo "Archivo $archivo descargado exitosamente en $ruta_local.<br>";
                                //flush();

                                // Verificar el tamaño del archivo descargado
                                if (filesize($ruta_local) >= 2048) {
                                    //echo "El archivo $archivo tiene un tamaño válido (>= 2 KB).<br>";

                                    // Eliminar el archivo del servidor remoto
                                    if (ftp_delete($ftp_conn, $archivo)) {
                                        //echo "Archivo $archivo eliminado del servidor remoto.<br>";
                                        $controlDescarga['archivos'][] = [
                                            'nombre' => $archivo,
                                            'descargado' => true,
                                            'eliminado_remoto' => true,
                                            'razon' => 'Se ha borrado el archivo del servidor remoto',
                                            'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                                        ];
                                    } else {
                                        //echo "Error al intentar eliminar el archivo $archivo del servidor remoto.<br>";
                                        $controlDescarga['archivos'][] = [
                                            'nombre' => $archivo,
                                            'descargado' => true,
                                            'eliminado_remoto' => false,
                                            'razon' => 'No se ha podido borrar del servidor remoto',
                                            'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                                        ];
                                    }

                                    // $controlDescarga['archivos'][] = [
                                    //     'nombre' => $archivo,
                                    //     'descargado' => true,
                                    //     'eliminado_remoto' => true,
                                    //     'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                                    // ];
                                } else {
                                    //echo "El archivo $archivo es demasiado pequeño (< 2 KB). No se elimina del servidor remoto.<br>";
                                    $controlDescarga['archivos'][] = [
                                        'nombre' => $archivo,
                                        'descargado' => true,
                                        'eliminado_remoto' => false,
                                        'razon' => 'Tamaño insuficiente',
                                        'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                                    ];
                                }

                                $descargado = true;
                            } else {
                                // Continuar con el reintento hasta un máximo de 3
                                $reintento++;
                                //echo "Error al descargar el archivo $archivo. Reintento $reintento de $maxReintentos.<br>";
                                //flush();
                            }
                        }

                        // Si después de todos los reintentos no se pudo descargar el archivo
                        if (!$descargado) {
                            //echo "No se pudo descargar el archivo $archivo tras múltiples intentos.<br>";
                            //flush();
                            $controlDescarga['archivos'][] = [
                                'nombre' => $archivo,
                                'descargado' => false,
                                'eliminado_remoto' => false,
                                'razon' => 'Error en la descarga tras múltiples intentos',
                                'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                            ];
                        }
                    } else {
                        //echo "El archivo $archivo no es un archivo JSON. Se omite.<br>";
                        //flush();
                        $controlDescarga['archivos'][] = [
                            'nombre' => $archivo,
                            'descargado' => false,
                            'eliminado_remoto' => false,
                            'razon' => 'Error en la descarga no es un JSON',
                            'fecha_hora_descarga' => date('Y-m-d H:i:s') // Añadir fecha y hora de descarga
                        ];
                    }
                }

                // Guardar archivo JSON de control después de procesar el lote
                file_put_contents($nombreArchivoJson, json_encode($controlDescarga, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                // Cerrar conexión FTP para este lote
                ftp_close($ftp_conn);
            }

            echo "<hr><div class='log-entry info'><strong>PASO 6:</strong> Procesando archivos descargados...</div>";
            flush();
            
            // Obtener todos los archivos JSON en el directorio
            $jsonFiles = glob($directorio_localFtp . "*.json");
            
            echo "<div class='log-entry info'>📂 Buscando archivos JSON en: <strong>$directorio_localFtp</strong></div>";
            flush();
        
            if (empty($jsonFiles)) {
               echo "<div class='log-entry warning'>⚠️ No se detectaron archivos válidos del tipo JSON en el directorio</div>";
               responder('error', 'No se detectaron archivos válidos del tipo JSON en el directorio.<br>');

            }
            
            $totalJsonFiles = count($jsonFiles);
            echo "<div class='log-entry success'>✅ Se encontraron <strong>$totalJsonFiles archivos JSON</strong> para procesar</div>";
            flush();

            if ($jsonFiles === false) {
                responder('error', 'Error al obtener la lista de archivos JSON.<br>');
            }

           $registroProceso = [];
           
            // Contadores para el resumen final
            $contadorRegistrosInsertados = 0;
            $contadorArchivosConError = 0;
            $contadorArchivosProcesadosOk = 0;
            $contadorViajesInsertados = 0;

            // Crear un directorio con el formato YYYYMMDD si no existe
            $directorioFecha = __DIR__ . '/descargas_procesados/control_procesados/' . date('Ymd');
            if (!is_dir($directorioFecha)) {
                if (mkdir($directorioFecha, 0777, true)) {
                    //echo "Directorio creado: $directorioFecha<br>";
                } else {
                    //echo "Error al crear el directorio: $directorioFecha<br>";
                }
            } else {
                //echo "El directorio ya existe: $directorioFecha<br>";
            }
            $directorio_controlJson_proceso = $directorioFecha . "/";
            $nombreArchivoProcesoJson = $directorio_controlJson_proceso  . "RP_" . date('Ymd_His') . ".json";

            $contador = 0;
            foreach ($jsonFiles as $archivo) {
                $contador++; // Incrementar al inicio para que continue no lo salte
                
                // Mostrar progreso solo cada 10 archivos o en el último
                if ($contador % 10 == 0 || $contador == $totalJsonFiles) {
                    echo "<div class='log-entry info'><strong>📄 Procesando archivo $contador/$totalJsonFiles...</strong></div>";
                    flush();
                }
                
                $contenido = file_get_contents($archivo);

                $contenido = preg_replace('/\x{FEFF}/u', '', $contenido);
                // Decodificar el contenido JSON
                $datos = json_decode($contenido, true);
                $registroArchivo = [
                    'nombre_archivo' => basename($archivo),
                    'procesado' => false,
                    'errores' => [],
                    'detalles' => []
                ];

                $CONDUCTOR_NIF = ''; // Inicializar como cadena vacía en lugar de null

                if (isset($datos['CONDUCTOR_NIF']) && !empty($datos['CONDUCTOR_NIF'])) {
                    $CONDUCTOR_NIF = strtoupper(trim($datos['CONDUCTOR_NIF']));
                } else {
                    $registroArchivo['errores'][] = 'El campo CONDUCTOR_NIF no esta definido o esta vacio en el archivo JSON.';
                }


                // EL DNI DEBE DE TENER UN MINIMO DE 4 CARACTERES, NO SE CREA ORDEN
                if (strlen($CONDUCTOR_NIF ?? '') < 4) {
                    $error = 'ORDEN NO CREADA. EL DNI DEBE DE TENER MAS DE 4 POSICIONES. ARCHIVO: ' . basename($archivo) . ' DNI: ' . $CONDUCTOR_NIF;
                   
                    $registroArchivo['errores'][] = $error;
                    $registroArchivo['procesado'] = false;
                    $contadorArchivosConError++;

                    $registroProceso[] = $registroArchivo;

                    $directorioDiaErrores = __DIR__ . '/errores_procesados/' . date('Ymd');

                    $jsonvariable = json_encode($directorioDiaErrores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    $archivoJson = __DIR__ . '/archivo_error.json'; // NOMBRE DEL ARCHIVO json A guardar
                    file_put_contents($archivoJson, $jsonvariable);


                    if (!is_dir($directorioDiaErrores)) {
                        if (mkdir($directorioDiaErrores, 0777, true)) {
                            $registroArchivo['detalles'][] = 'Directorio creado: ' . $directorioDiaErrores;
                        } else {
                            $registroArchivo['errores'][] = 'Error al crear el directorio: ' . $directorioDiaErrores;
                        }
                    }

                    // Mover el archivo al directorio del día
                    $destino = $directorioDiaErrores . '/' . basename($archivo);
                    if (rename($archivo, $destino)) {
                        $registroArchivo['detalles'][] = 'Archivo movido exitosamente a ' . $destino;
                    } else {
                        $registroArchivo['errores'][] = 'Error al mover el archivo a ' . $destino;
                    }

                    // Guardar el registro del proceso en un archivo JSON
                    file_put_contents($nombreArchivoProcesoJson, json_encode($registroProceso, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                    // Si el DNI tiene menos de 4 posiciones la orden no se crea en el caso de que no  se quiera validar se omite el continue;
                    continue;
                } else {
           
                    $registroArchivo['detalles'][] = 'DNI validado correctamente: ' . $CONDUCTOR_NIF;
                    $TRANSPORTISTA_COD = $datos['TRANSPORTISTA_COD'];
                    $TRANSPORTISTA_NOMBRE = $datos['TRANSPORTISTA_NOMBRE'];
                    $TRANSPORTISTA_DIRECCION = $datos['TRANSPORTISTA_DIRECCION'];
                    
                    // Validar y truncar código postal a máximo 10 caracteres
                    $TRANSPORTISTA_CP_ORIGINAL = $datos['TRANSPORTISTA_CP'] ?? '';
                    $TRANSPORTISTA_CP = substr(trim($TRANSPORTISTA_CP_ORIGINAL), 0, 10);
                    
                    $TRANSPORTISTA_POBLACION = $datos['TRANSPORTISTA_POBLACION'];
                    $TRANSPORTISTA_PROVINCIA = $datos['TRANSPORTISTA_PROVINCIA'];
                    $CONDUCTOR_NIF = strtoupper(trim($datos['CONDUCTOR_NIF']));
                    $CONDUCTOR_NOMBRE = $datos['CONDUCTOR_NOMBRE'];
                    $CONDUCTOR_EMAIL = $datos['CONDUCTOR_EMAIL'];
                    $TRACTORA = $datos['TRACTORA'];
                    
                    if ($TRANSPORTISTA_CP_ORIGINAL != $TRANSPORTISTA_CP) {
                        $registroArchivo['detalles'][] = "CP truncado de '$TRANSPORTISTA_CP_ORIGINAL' a '$TRANSPORTISTA_CP'";
                    }

                    $correoCuenta = validarCorreo($CONDUCTOR_EMAIL);

                    if (strpos($correoCuenta, 'Error') === 0) {
                     
                        $registroArchivo['errores'][] = 'No hay email valido para el CONDUCTOR.';
                    } else {
                      
                        $registroArchivo['detalles'][] = 'Email correcto: ' . $correoCuenta;

                        //--------------------------------------------------------------------------//
                        //--------------------  USUARIO - CONDUCTOR  -------------------------------//
                        //--------------------------------------------------------------------------//

                        $usuarioConductorCreadoExist = "SELECT COUNT(*) as count FROM `tm_usuario` WHERE `idTransportista_transportistas-Transporte` = :idTransportistaLeader";
                        $usuarioConductorCreadoExist = $conectar->prepare($usuarioConductorCreadoExist);
                        $usuarioConductorCreadoExist->bindParam(':idTransportistaLeader', $CONDUCTOR_NIF);
                        $usuarioConductorCreadoExist->execute();
                        $usuarioConductorCreadoExist = $usuarioConductorCreadoExist->fetch(PDO::FETCH_ASSOC);

                        $exists = $usuarioConductorCreadoExist['count'] > 0;
                        if ($exists) {
                            //echo 'CUENTA DE USUARIO-CONDUCTOR EXISTE YA <br>';
                            $registroArchivo['detalles'][] = 'Cuenta de usuario-conductor ya existe: ' . $CONDUCTOR_NIF;
                            // Variables de ejemplo (deben ser definidas previamente en tu script)
                            $CONDUCTOR_NOMBRE = $TRANSPORTISTA_NOMBRE;
                            $correoCuenta = $CONDUCTOR_EMAIL;
                            $TRANSPORTISTA_PROVINCIA = $TRANSPORTISTA_PROVINCIA;
                            $TRANSPORTISTA_POBLACION = $TRANSPORTISTA_POBLACION;
                            $TRANSPORTISTA_CP = $TRANSPORTISTA_CP;
                            $TRANSPORTISTA_DIRECCION = $TRANSPORTISTA_DIRECCION;

                            // Consulta SQL para actualizar con prepared statement
                            $sql = "UPDATE `tm_usuario` 
                        SET `nombreUsu` = :nombreUsu, 
                            `correoUsu` = :correoUsu, 
                            `provinciaUsu` = :provinciaUsu, 
                            `ciudadPuebloUsu` = :ciudadPuebloUsu, 
                            `codigoPostalUsu` = :codigoPostalUsu, 
                            `direccionFacturacionUsu` = :direccionFacturacionUsu, 
                            `rolUsu` = 0, 
                            `estUsu` = 1, 
                            `fecAltaUsu` = now(), 
                            `identificacionFiscalUsu` = :identificacionFiscalUsu
                        WHERE `idTransportista_transportistas-Transporte` = :idTransportista";
                        
                            $stmtUpdate = $conectar->prepare($sql);
                            $stmtUpdate->execute([
                                ':nombreUsu' => $CONDUCTOR_NOMBRE,
                                ':correoUsu' => $correoCuenta,
                                ':provinciaUsu' => $TRANSPORTISTA_PROVINCIA,
                                ':ciudadPuebloUsu' => $TRANSPORTISTA_POBLACION,
                                ':codigoPostalUsu' => $TRANSPORTISTA_CP,
                                ':direccionFacturacionUsu' => $TRANSPORTISTA_DIRECCION,
                                ':identificacionFiscalUsu' => $CONDUCTOR_NIF,
                                ':idTransportista' => $CONDUCTOR_NIF
                            ]);

                            $registroArchivo['detalles'][] = 'Actualizado usuario-conductor: ' . $CONDUCTOR_NIF;
                        } else {
                          
                            $tokenUsu = generarToken(30);
                      
                            $sql = "INSERT INTO `tm_usuario` (`nickUsu`,`nombreUsu`, `apellidosUsu`, `telefonoUsu`, `movilUsu`, `correoUsu`, `senaUsu`,`avatarUsu`, `paisUsu`, `provinciaUsu`, `ciudadPuebloUsu`, `codigoPostalUsu`, `direccionFacturacionUsu`, `rolUsu`, `estUsu`, `fecAltaUsu`, `identificacionFiscalUsu`, `tokenUsu`, `idTransportista_transportistas-Transporte`) 
                    VALUES ('','$CONDUCTOR_NOMBRE','','','','$correoCuenta',md5('$CONDUCTOR_NIF'),'userLeader.png','','$TRANSPORTISTA_PROVINCIA','$TRANSPORTISTA_POBLACION','$TRANSPORTISTA_CP','$TRANSPORTISTA_DIRECCION',0, 1, now(),'$CONDUCTOR_NIF','$tokenUsu','$CONDUCTOR_NIF')";


                            $sql = $conectar->prepare($sql);
                            $sql->execute();
                            $json_string = json_encode($sql);

                            $resultadoUsu = $sql->fetch(PDO::FETCH_ASSOC);
                     
                            $registroArchivo['detalles'][] = 'Insertado usuario-conductor: ' . $CONDUCTOR_NIF;
                        }

                     
                        // Verificar si CONDUCTOR-TRANSPORTISTA ya existe
                        $conductorCreadoExist = "SELECT idTransportista, COUNT(*) as count FROM `transportistas-Transporte`  WHERE idTransportistaLeader = :idTransportistaLeader GROUP BY idTransportista";

                        $conductorCreadoExist = $conectar->prepare($conductorCreadoExist);
                        $conductorCreadoExist->bindParam(':idTransportistaLeader', $CONDUCTOR_NIF);
                        $conductorCreadoExist->execute();
                        $conductorCreadoExist = $conductorCreadoExist->fetch(PDO::FETCH_ASSOC);


                        if ($conductorCreadoExist && isset($conductorCreadoExist['idTransportista'])) {
                            $idUsuarioTransportista = $conductorCreadoExist['idTransportista'];

                            $registroArchivo['detalles'][] = 'IdUsuarioTransportista - Transportista: ' . $idUsuarioTransportista;

                            $idTransportistaSelect = $idUsuarioTransportista;

                            $exists = $conductorCreadoExist['count'] > 0;
                        } else {
                            $idUsuarioTransportista = 0; // Es la primera vez que se incopora La siguiente vez se actualizará.
                            $idTransportistaSelect = null; // Inicializar para evitar undefined
                            $exists = false; // No existe el conductor

                            $registroArchivo['detalles'][] = 'IdUsuarioTransportista - Transportista: ' . $idUsuarioTransportista;
                        }

                        if ($exists) {
                            //echo 'EXISTE EL CONDUCTOR <br>';

                            $sql = "UPDATE `transportistas-Transporte`
                SET 
                    `idTransportistaLeader` = :idTransportistaLeader,
                    `idUsuario_Transportista` = :idUsuarioTransportista,
                    `emailTransportista` = :emailTransportista,
                    `nombreTransportista` = :nombreTransportista,
                    `direccionTransportista` = :direccionTransportista,
                    `poblacionTransportista` = :poblacionTransportista,
                    `provinciaTransportista` = :provinciaTransportista,
                    `cpDireccionTransportista` = :cpDireccionTransportista,
                    `nifTransportista` = :nifTransportista,
                    `tractoraTransportista` = :tractoraTransportista
                WHERE 
                    `idTransportistaLeader` = :idTransportistaSelect";
                    
                            $stmtUpdateTrans = $conectar->prepare($sql);
                            $stmtUpdateTrans->execute([
                                ':idTransportistaLeader' => $CONDUCTOR_NIF,
                                ':idUsuarioTransportista' => $idUsuarioTransportista,
                                ':emailTransportista' => $CONDUCTOR_EMAIL,
                                ':nombreTransportista' => $CONDUCTOR_NOMBRE,
                                ':direccionTransportista' => $TRANSPORTISTA_DIRECCION,
                                ':poblacionTransportista' => $TRANSPORTISTA_POBLACION,
                                ':provinciaTransportista' => $TRANSPORTISTA_PROVINCIA,
                                ':cpDireccionTransportista' => $TRANSPORTISTA_CP,
                                ':nifTransportista' => $CONDUCTOR_NIF,
                                ':tractoraTransportista' => $TRACTORA,
                                ':idTransportistaSelect' => $idTransportistaSelect
                            ]);

                            $resultado = $stmtUpdateTrans->fetch(PDO::FETCH_ASSOC);
                            //echo "Transportista updateado correctamente.";
                            flush();

                            $registroArchivo['detalles'][] = 'Actualizado Transportista: ' . $CONDUCTOR_NIF;
                        } else {

                            //echo 'NO EXISTE EL CONDUCTOR <br>';
                            flush();
                            // Preparar la consulta

                            $sql = "INSERT INTO `transportistas-Transporte` 
                                (`idUsuario_Transportista`, `idTransportistaLeader`, `emailTransportista`, `nombreTransportista`, 
                                `direccionTransportista`, `poblacionTransportista`, `provinciaTransportista`, `cpDireccionTransportista`, 
                                `nifTransportista`, `tractoraTransportista`) 
                                VALUES 
                                (:idUsuarioTransportista, :idTransportistaLeader, :emailTransportista, :nombreTransportista,
                                :direccionTransportista, :poblacionTransportista, :provinciaTransportista, :cpDireccionTransportista,
                                :nifTransportista, :tractoraTransportista)";

                            $stmtInsertTrans = $conectar->prepare($sql);
                            $stmtInsertTrans->execute([
                                ':idUsuarioTransportista' => $idUsuarioTransportista,
                                ':idTransportistaLeader' => $CONDUCTOR_NIF,
                                ':emailTransportista' => $CONDUCTOR_EMAIL,
                                ':nombreTransportista' => $CONDUCTOR_NOMBRE,
                                ':direccionTransportista' => $TRANSPORTISTA_DIRECCION,
                                ':poblacionTransportista' => $TRANSPORTISTA_POBLACION,
                                ':provinciaTransportista' => $TRANSPORTISTA_PROVINCIA,
                                ':cpDireccionTransportista' => $TRANSPORTISTA_CP,
                                ':nifTransportista' => $CONDUCTOR_NIF,
                                ':tractoraTransportista' => $TRACTORA
                            ]);

                            $resultado = $stmtInsertTrans->fetch(PDO::FETCH_ASSOC);
                            //echo "Transportista insertado correctamente.";
                            flush();
                            $registroArchivo['detalles'][] = 'Insertado Transportista: ' . $CONDUCTOR_NIF;
                        }

                        $TTE_COD = $datos['TTE_COD'];
                        $numeroTransporte = $datos['TTE_ORDEN'];
                        $textoNumeroOrden = $datos['TTE_ORDEN'];
                        $idTransportista = $CONDUCTOR_NIF;
                        $idCliente = 00;
                        $nombreTransportista = $datos['CONDUCTOR_NOMBRE'];
                        date_default_timezone_set('Europe/Madrid');
                        $fechaActual = date('Y-m-d H:i:s');


                        // Uso de la función para generar un token de 30 caracteres
                        $tokenOrden = generarToken(30);

                        // Verificar y mostrar el valor de 'TTE_TERRESTRE'
                        $TTE_TERRESTRE = $datos['TTE_TERRESTRE'];

                        // Verificar y mostrar el valor de 'TTE_MULTIMODAL'
                        $TTE_MULTIMODAL = $datos['TTE_MULTIMODAL'];

                        // Determinar el tipo de orden de transporte
                        // C = CONTENEDOR / T = TERRESTRE / M = MULTIMODAL / X = NO DEFINIDO
                        if ($TTE_TERRESTRE === false && $TTE_MULTIMODAL === false) {
                            $tipoOrdenTransporte = 'C';
                        } elseif ($TTE_TERRESTRE === true && $TTE_MULTIMODAL === false) {
                            $tipoOrdenTransporte = 'T';
                        } elseif ($TTE_TERRESTRE === false && $TTE_MULTIMODAL === true) {
                            $tipoOrdenTransporte = 'M';
                        } else {
                            $tipoOrdenTransporte = 'X'; // Caso de valor indefinido
                        }

                        //echo 'El TIPO TRANSPORTE ES: ' . $tipoOrdenTransporte . '<br>';
                        $registroArchivo['detalles'][] = 'Detectado tipo de transporte: ' . $tipoOrdenTransporte;


                        // Mostrar el resultado para verificación de MATRICULA
                        if (empty($datos['MATRICULA'])) {
                            //echo "Error: La matrícula no esta definida o esta vacia.<br>";
                            flush();
                            $registroArchivo['errores'][] = 'MATRICULA no esta definida o esta vacia.';
                        } else {
                            $contenedorActivo = $datos['MATRICULA'];

                            //echo "MATRICULA válida: " . $datos['MATRICULA'] . "<br>";
                            flush();
                            $registroArchivo['detalles'][] = 'MATRICULA validada correctamente: ' . $datos['MATRICULA'];
                        }


                        // Mostrar el resultado para verificación de PRECINTO
                        if (empty($datos['PRECINTO'])) {
                            //echo "Error: El precinto no esta definido o esta vacio.<br>";
                            flush();
                            $registroArchivo['errores'][] = 'PRECINTO no esta definido o esta vacio.';
                        } else {
                            $precintoActivo = $datos['PRECINTO'];

                            //echo "PRECINTO válido: " . $datos['PRECINTO'] . "<br>";
                            flush();
                            $registroArchivo['detalles'][] = 'PRECINTO validado correctamente: ' . $datos['PRECINTO'];
                        }

                        $tipoContenedor = '';

                        if ($tipoOrdenTransporte == 'C') {

                            $fechaEstimada = $datos['TTE_FECHA_ESTIMADA_RECOGIDA'];

                            // Verificar si hay datos en LUGARES_CARGA
                            if (isset($datos['LUGARES']) && count($datos['LUGARES']) > 0) {
                                // Obtener el primer objeto de LUGARES_CARGA
                                $primerLugar = $datos['LUGARES'][0];

                                // Obtener el valor de LUGAR_NOMBRE
                                $puerto_origen = $primerLugar['LUGAR_NOMBRE'];

                                //echo "El primer LUGAR_NOMBRE es: " . $puerto_origen;
                                $registroArchivo['detalles'][] = 'El primer lugar de carga es: ' . $puerto_origen;
                            } else {
                                $puerto_origen = 'No Indicado';
                                //echo "No hay datos en LUGARES_CARGA.";
                                $registroArchivo['errores'][] = 'No hay datos en LUGARES_CARGA.';
                            }
                        } else if ($tipoOrdenTransporte == 'T') {

                            $fechaEstimada = $datos['TTE_FECHA_CARGA'];

                            // Verificar si hay datos en LUGARES_CARGA
                            if (isset($datos['LUGARES_CARGA']) && count($datos['LUGARES_CARGA']) > 0) {
                                // Obtener el primer objeto de LUGARES_CARGA
                                $primerLugar = $datos['LUGARES_CARGA'][0];

                                // Obtener el valor de LUGAR_NOMBRE
                                $puerto_origen = $primerLugar['LUGAR_NOMBRE'];
                                //echo "El primer LUGAR_NOMBRE es: " . $puerto_origen;
                                $registroArchivo['detalles'][] = 'El primer lugar de carga es: ' . $puerto_origen;
                            } else {
                                $puerto_origen = 'No Indicado';
                                //echo "No hay datos en LUGARES_CARGA.";
                                $registroArchivo['errores'][] = 'No hay datos en LUGARES_CARGA.';
                            }
                        } else {

                            $fechaEstimada = $datos['TTE_FECHA_CARGA'];
                            $puerto_origen = $datos['LUGAR_COMIENZO_NOMBRE'];
                            //echo 'El primer LUGAR_NOMBRE: ' . $puerto_origen;
                            $registroArchivo['detalles'][] = 'El primer lugar de carga es: ' . $puerto_origen;
                        }

                        if ($TTE_COD == NULL || $TTE_COD == '') {
                            $errorText = 'Error: Faltan datos en el archivo: ' . $archivo . ' <br>';
                            $registroArchivo['errores'][] = 'Faltan datos en el archivo: ' . $archivo;
                        } else {

                            // Convertir el array en formato JSON
                            $jsonOrdenTransporte = json_encode($datos);

                            // Verificar si TTE_COD ya existe
                            /*                     $sqlCheck = "SELECT idOrden, COUNT(*) as count FROM `orden-Transporte` WHERE `TTE_COD` = :tte_cod";
 */
                            $sqlCheck = "SELECT idOrden, COUNT(*) as count  FROM `orden-Transporte` WHERE `TTE_COD` = :tte_cod GROUP BY idOrden";

                            $stmtCheck = $conectar->prepare($sqlCheck);
                            $stmtCheck->bindParam(':tte_cod', $TTE_COD);
                            $stmtCheck->execute();
                            $selectOrdenExist = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                            // Verificar que $selectOrdenExist no sea false antes de acceder a sus índices
                            if ($selectOrdenExist && is_array($selectOrdenExist)) {
                                $exists = $selectOrdenExist['count'] ?? 0;
                                $lastId = $selectOrdenExist['idOrden'] ?? null;
                            } else {
                                $exists = 0;
                                $lastId = null;
                            }

                            //echo 'EXISTE: ' . $exists . '<br>'; // Esto es solo para depuración, puedes eliminarlo después de verificar que funciona correctamente

                            //=====================================================//
                            //=====================================================//
                            //=============== AÑADIR ORDEN C Y T ==================//
                            //=====================================================//
                            //=====================================================//


                            if ($exists) {
                                // Realizar UPDATE

                                $sqlUpdateOrder = "UPDATE `orden-Transporte` 
                                SET `TTE_COD` = :TTE_COD, 
                                    `textoNumeroOrden` = :textoNumeroOrden, 
                                    `jsonOrdenTransporte` = :jsonOrdenTransporte, 
                                    `id_Transportista` = :idTransportista, 
                                    `nombreTransportista_ordenTransporte` = :nombreTransportista, 
                                    `puerto_origen` = :puerto_origen, 
                                    `fechaUpdate` = :fechaActual, 
                                    `tipoOrdenTransporte` = :tipoOrdenTransporte, 
                                    `tokenOrden` = :tokenOrden , 
                                    `LUGAR_COMIENZO` = :LUGAR_COMIENZO_NOMBRE , 
                                    `LUGAR_FIN` = :LUGAR_FIN_NOMBRE,
                                    `fechaOrdenViaje` = :fechaOrdenViaje  
                                WHERE `num_transporte` = :numeroTransporte";

                                $stmt = $conectar->prepare($sqlUpdateOrder);

                                // Bind de parámetros
                                $stmt->bindParam(':TTE_COD', $TTE_COD);
                                $stmt->bindParam(':textoNumeroOrden', $textoNumeroOrden);
                                $stmt->bindParam(':jsonOrdenTransporte', $jsonOrdenTransporte);
                                $stmt->bindParam(':idTransportista', $idTransportista);
                                $stmt->bindParam(':nombreTransportista', $nombreTransportista);
                                $stmt->bindParam(':puerto_origen', $puerto_origen);
                                $stmt->bindParam(':fechaActual', $fechaActual);
                                $stmt->bindParam(':tipoOrdenTransporte', $tipoOrdenTransporte); // Este valor debe ser definido correctamente
                                $stmt->bindParam(':tokenOrden', $tokenOrden);
                                $stmt->bindParam(':numeroTransporte', $numeroTransporte);
                                $stmt->bindParam(':LUGAR_COMIENZO_NOMBRE', $LUGAR_COMIENZO_NOMBRE);
                                $stmt->bindParam(':LUGAR_FIN_NOMBRE', $LUGAR_FIN_NOMBRE);
                                $stmt->bindParam(':fechaOrdenViaje', $fechaEstimada);

                                //echo 'EDITANDO ORDEN NUMERO: ' . $TTE_COD . '<br>';
                                // Ejecutar la consulta
                                $stmt->execute();

                                $registroArchivo['detalles'][] = 'Editando orden: ' . $TTE_COD;
                            } else {

                                // Realizar INSERT
                                $sqlInsertOrder = "INSERT INTO `orden-Transporte` 
                        (`TTE_COD`, `num_transporte`, `textoNumeroOrden`, `jsonOrdenTransporte`, `id_Transportista`, `contenedorActivo`, `precintoActivo`,`tipoContenedor`, `nombreTransportista_ordenTransporte`, `puerto_origen`, `fechaCreacion`, `fechaInactivo`, `fechaUpdate`, `tipoOrdenTransporte`, `estOrden`, `tokenOrden`, `LUGAR_COMIENZO`, `LUGAR_FIN`, `fechaOrdenViaje`, `nombreCliente`, `correoCliente`, `dniCliente`, `firmaCliente`) 
                        VALUES 
                        (:TTE_COD, :numeroTransporte, :textoNumeroOrden, :jsonOrdenTransporte, :idTransportista, :contenedorActivo, :precintoActivo, :tipoContenedor, :nombreTransportista, :puerto_origen, :fechaActual, null, null, :tipoOrdenTransporte, '1', :tokenOrden, :LUGAR_COMIENZO, :LUGAR_FIN, :fechaOrdenViaje, :nombreCliente, :correoCliente, :dniCliente, :firmaCliente)";

                                $stmt = $conectar->prepare($sqlInsertOrder);

                                // Bind de parámetros
                                $stmt->bindParam(':TTE_COD', $TTE_COD);
                                $stmt->bindParam(':numeroTransporte', $numeroTransporte);
                                $stmt->bindParam(':textoNumeroOrden', $textoNumeroOrden);
                                $stmt->bindParam(':jsonOrdenTransporte', $jsonOrdenTransporte);
                                $stmt->bindParam(':idTransportista', $idTransportista);
                                $stmt->bindParam(':contenedorActivo', $contenedorActivo);
                                $stmt->bindParam(':precintoActivo', $precintoActivo);
                                $stmt->bindParam(':tipoContenedor', $tipoContenedor);
                                $stmt->bindParam(':nombreTransportista', $nombreTransportista);
                                $stmt->bindParam(':puerto_origen', $puerto_origen);
                                $stmt->bindParam(':fechaActual', $fechaActual);
                                $stmt->bindParam(':tipoOrdenTransporte', $tipoOrdenTransporte);
                                $stmt->bindParam(':tokenOrden', $tokenOrden);
                                $stmt->bindParam(':LUGAR_COMIENZO', $LUGAR_COMIENZO_NOMBRE);
                                $stmt->bindParam(':LUGAR_FIN', $LUGAR_FIN_NOMBRE);
                                $stmt->bindParam(':fechaOrdenViaje', $fechaEstimada);
                                $stmt->bindValue(':nombreCliente', null, PDO::PARAM_STR);
                                $stmt->bindValue(':correoCliente', null, PDO::PARAM_STR);
                                $stmt->bindValue(':dniCliente', null, PDO::PARAM_STR);
                                $stmt->bindValue(':firmaCliente', null, PDO::PARAM_STR);

                                // Obtener el último ID insertado
                                //echo ' INSERTANDO ORDEN NUEVA NUMERO: ' . $TTE_COD . '<br>';

                                $registroArchivo['detalles'][] = 'INSERTANDO orden: ' . $TTE_COD;

                                // Ejecutar la consulta
                                $stmt->execute();
                                $lastId = $conectar->lastInsertId();
                            }
                            //=====================================================//
                            //=====================================================//
                            //=====================================================//
                            //=====================================================//


                            $contenedorActivo = '';
                            $precintoActivo = '';
                            $tipoContenedor = '';



                            // Imprimir el último ID para verificar
                            //echo "El último ID insertado es: " . $lastId . '<br>';
                            $viajeOrden = 1; // ES INDICATIVO PARA SABER QUE NUMERO DE VIAJE ES, EL VIAJE 1..2..3..4

                            // ELIMINAMOS LOS VIAJES PARA IMPORTARLOS DE NUEVO

                            // Procesar los datos de LUGARES_CARGA
                            // DEPENDIENDO DEL TIPO DE ARCHIVO, LOS LUGARES ESTÁN ESCRITO DIFERENTES. 
                            if ($tipoOrdenTransporte == 'C') {

                                /* $sqlEliminarViajes = "DELETE FROM `viaje-Transporte` WHERE id_OrdenViajeTransporte = $lastId;";
                    $sqlEliminarViajes = $conectar->prepare($sqlEliminarViajes);
                    $sqlEliminarViajes->execute();
                    echo "Eliminando viaje de Orden ".$lastId; */

                                if (isset($datos['LUGARES']) && is_array($datos['LUGARES'])) {
                                    foreach ($datos['LUGARES'] as $lugar) {
                                        $LUGAR_COD = isset($lugar['LUGAR_COD']) ? $lugar['LUGAR_COD'] : null;
                                        $LUGAR_NOMBRE = isset($lugar['LUGAR_NOMBRE']) ? $lugar['LUGAR_NOMBRE'] : '';
                                        $LUGAR_DIRECCION = isset($lugar['LUGAR_DIRECCION']) ? $lugar['LUGAR_DIRECCION'] : '';
                                        $LUGAR_CP = isset($lugar['LUGAR_CP']) ? $lugar['LUGAR_CP'] : '';
                                        $LUGAR_POBLACION = isset($lugar['LUGAR_POBLACION']) ? $lugar['LUGAR_POBLACION'] : '';
                                        $LUGAR_PROVINCIA = isset($lugar['LUGAR_PROVINCIA']) ? $lugar['LUGAR_PROVINCIA'] : '';
                                        $LUGAR_TELEFONO = isset($lugar['LUGAR_TELEFONO']) ? $lugar['LUGAR_TELEFONO'] : '';

                                        // Verificar si el viaje ya existe
                                        $sqlCheckViaje = "SELECT COUNT(*) as count  FROM `viaje-Transporte` WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";
                                        $stmtCheckViaje = $conectar->prepare($sqlCheckViaje);
                                        $stmtCheckViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                        $stmtCheckViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                        $stmtCheckViaje->execute();
                                        $selectViajeExist = $stmtCheckViaje->fetch(PDO::FETCH_ASSOC);

                                        $viajeExists = $selectViajeExist['count'];

                                        if ($viajeExists) {
                                            // Realizar UPDATE
                                            $sqlUpdateViaje = "UPDATE `viaje-Transporte` 
                                                SET `LUGAR_NOMBRE` = :LUGAR_NOMBRE, 
                                                    `LUGAR_DIRECCION` = :LUGAR_DIRECCION, 
                                                    `LUGAR_CP` = :LUGAR_CP, 
                                                    `LUGAR_POBLACION` = :LUGAR_POBLACION, 
                                                    `LUGAR_PROVINCIA` = :LUGAR_PROVINCIA, 
                                                    `LUGAR_TELEFONO` = :LUGAR_TELEFONO 
                                                WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";

                                            $stmtUpdateViaje = $conectar->prepare($sqlUpdateViaje);
                                            $stmtUpdateViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtUpdateViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtUpdateViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtUpdateViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtUpdateViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtUpdateViaje->bindParam(':id_OrdenViajeTransporte', $lastId);

                                            $stmtUpdateViaje->execute();
                                            //echo ' ACTUALIZANDO VIAJE<br>';

                                            $registroArchivo['detalles'][] = 'TIPO  C -> ACTUALIZANDO viaje: ' . $LUGAR_COD;
                                        } else {
                                            // Realizar INSERT
                                            $sqlInsertViaje = "INSERT INTO `viaje-Transporte`
                                                    (`id_OrdenViajeTransporte`,	`numeroOrdenViaje`, `fechaLlegadaViaje`, `fechaSalidaViaje`, `ObservacionViaje`, `FirmaViajeReceptor`, `documentoManual`, `LUGAR_COD`, `LUGAR_NOMBRE`, `LUGAR_DIRECCION`, `LUGAR_CP`, `LUGAR_POBLACION`, `LUGAR_PROVINCIA`, `LUGAR_TELEFONO`, `ordenViaje`, `tipoViaje`)
                                                    VALUES
                                                    (:id_OrdenViajeTransporte,:numeroTransporte, null, null, null, null, null, :LUGAR_COD, :LUGAR_NOMBRE, :LUGAR_DIRECCION, :LUGAR_CP, :LUGAR_POBLACION, :LUGAR_PROVINCIA, :LUGAR_TELEFONO, :ordenViaje, null)";

                                            $stmtInsertViaje = $conectar->prepare($sqlInsertViaje);
                                            $stmtInsertViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                            $stmtInsertViaje->bindParam(':numeroTransporte', $numeroTransporte);
                                            $stmtInsertViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtInsertViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtInsertViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtInsertViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtInsertViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtInsertViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtInsertViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtInsertViaje->bindParam(':ordenViaje', $viajeOrden);

                                            $stmtInsertViaje->execute();
                                            //echo ' INSERTANDO VIAJE<br> ';
                                            $contadorViajesInsertados++;

                                            $registroArchivo['detalles'][] = 'TIPO C -> INSERTANDO viaje: ' . $LUGAR_COD;
                                        }

                                        $viajeOrden++;
                                    }
                                } else {
                                    //echo 'El JSON no contiene el array "LUGARES" o no es válido.<br>';

                                    $registroArchivo['errores'][] = 'JSON en LUGARES no es valido.';
                                }
                            } else if ($tipoOrdenTransporte == 'T' || $tipoOrdenTransporte == 'M') {

                                //echo 'T DE TERRESTREE<br>';

                                /* $sqlEliminarViajes = "DELETE FROM `viaje-Transporte` WHERE id_OrdenViajeTransporte = $lastId;";
                    $sqlEliminarViajes = $conectar->prepare($sqlEliminarViajes);
                    $sqlEliminarViajes->execute();
                    echo "Eliminando viaje de Orden ".$lastId; */


                                if (isset($datos['LUGARES_CARGA']) && is_array($datos['LUGARES_CARGA'])) {
                                    foreach ($datos['LUGARES_CARGA'] as $lugar) {
                                        $LUGAR_COD = isset($lugar['LUGAR_COD']) ? $lugar['LUGAR_COD'] : null;
                                        $LUGAR_NOMBRE = isset($lugar['LUGAR_NOMBRE']) ? $lugar['LUGAR_NOMBRE'] : '';
                                        $LUGAR_DIRECCION = isset($lugar['LUGAR_DIRECCION']) ? $lugar['LUGAR_DIRECCION'] : '';
                                        $LUGAR_CP = isset($lugar['LUGAR_CP']) ? $lugar['LUGAR_CP'] : '';
                                        $LUGAR_POBLACION = isset($lugar['LUGAR_POBLACION']) ? $lugar['LUGAR_POBLACION'] : '';
                                        $LUGAR_PROVINCIA = isset($lugar['LUGAR_PROVINCIA']) ? $lugar['LUGAR_PROVINCIA'] : '';
                                        $LUGAR_TELEFONO = isset($lugar['LUGAR_TELEFONO']) ? $lugar['LUGAR_TELEFONO'] : '';

                                        // Verificar si el viaje ya existe
                                        $sqlCheckViaje = "SELECT COUNT(*) as count FROM `viaje-Transporte` WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";
                                        $stmtCheckViaje = $conectar->prepare($sqlCheckViaje);
                                        $stmtCheckViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                        $stmtCheckViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                        $stmtCheckViaje->execute();
                                        $selectViajeExist = $stmtCheckViaje->fetch(PDO::FETCH_ASSOC);

                                        $viajeExists = $selectViajeExist['count'];

                                        if ($viajeExists) {
                                            // Realizar UPDATE
                                            $sqlUpdateViaje = "UPDATE `viaje-Transporte` 
                                                SET `LUGAR_NOMBRE` = :LUGAR_NOMBRE, 
                                                    `LUGAR_DIRECCION` = :LUGAR_DIRECCION, 
                                                    `LUGAR_CP` = :LUGAR_CP, 
                                                    `LUGAR_POBLACION` = :LUGAR_POBLACION, 
                                                    `LUGAR_PROVINCIA` = :LUGAR_PROVINCIA, 
                                                    `LUGAR_TELEFONO` = :LUGAR_TELEFONO 
                                                WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";

                                            $stmtUpdateViaje = $conectar->prepare($sqlUpdateViaje);
                                            $stmtUpdateViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtUpdateViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtUpdateViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtUpdateViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtUpdateViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtUpdateViaje->bindParam(':id_OrdenViajeTransporte', $lastId);

                                            $stmtUpdateViaje->execute();
                                            //echo ' ACTUALIZANDO VIAJE LUGARES_CARGA<br>';

                                            $registroArchivo['detalles'][] = 'TIPO T-M -> ACTUALIZANDO VIAJE LUGARES_CARGA: ' . $LUGAR_COD;
                                        } else {
                                            // Realizar INSERT
                                            $sqlInsertViaje = "INSERT INTO `viaje-Transporte`
                                                    (`id_OrdenViajeTransporte`,`numeroOrdenViaje`, `fechaLlegadaViaje`, `fechaSalidaViaje`, `ObservacionViaje`, `FirmaViajeReceptor`, `documentoManual`, `LUGAR_COD`, `LUGAR_NOMBRE`, `LUGAR_DIRECCION`, `LUGAR_CP`, `LUGAR_POBLACION`, `LUGAR_PROVINCIA`, `LUGAR_TELEFONO`, `ordenViaje`, `tipoViaje`)
                                                    VALUES
                                                    (:id_OrdenViajeTransporte,:numeroTransporte, null, null, null, null, null, :LUGAR_COD, :LUGAR_NOMBRE, :LUGAR_DIRECCION, :LUGAR_CP, :LUGAR_POBLACION, :LUGAR_PROVINCIA, :LUGAR_TELEFONO, :ordenViaje, 'CARGA')";

                                            $stmtInsertViaje = $conectar->prepare($sqlInsertViaje);
                                            $stmtInsertViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                            $stmtInsertViaje->bindParam(':numeroTransporte', $numeroTransporte);
                                            $stmtInsertViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtInsertViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtInsertViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtInsertViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtInsertViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtInsertViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtInsertViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtInsertViaje->bindParam(':ordenViaje', $viajeOrden);

                                            $stmtInsertViaje->execute();
                                            $contadorViajesInsertados++;
                                            //echo ' INSERTANDO VIAJE LUGARES_CARGA<br> ';

                                            $registroArchivo['detalles'][] = 'TIPO T-M -> INSERTANDO VIAJE LUGARES_CARGA: ' . $LUGAR_COD;
                                        }

                                        $viajeOrden++;
                                    }
                                } else {
                                    //echo 'El JSON no contiene el array "LUGARES_CARGA" o no es válido.<br>';

                                    $registroArchivo['errores'][] = 'JSON en LUGARES no es valido.';
                                }

                                if (isset($datos['LUGARES_DESCARGA']) && is_array($datos['LUGARES_DESCARGA'])) {
                                    foreach ($datos['LUGARES_DESCARGA'] as $lugar) {
                                        $LUGAR_COD = isset($lugar['LUGAR_COD']) ? $lugar['LUGAR_COD'] : null;
                                        $LUGAR_NOMBRE = isset($lugar['LUGAR_NOMBRE']) ? $lugar['LUGAR_NOMBRE'] : '';
                                        $LUGAR_DIRECCION = isset($lugar['LUGAR_DIRECCION']) ? $lugar['LUGAR_DIRECCION'] : '';
                                        $LUGAR_CP = isset($lugar['LUGAR_CP']) ? $lugar['LUGAR_CP'] : '';
                                        $LUGAR_POBLACION = isset($lugar['LUGAR_POBLACION']) ? $lugar['LUGAR_POBLACION'] : '';
                                        $LUGAR_PROVINCIA = isset($lugar['LUGAR_PROVINCIA']) ? $lugar['LUGAR_PROVINCIA'] : '';
                                        $LUGAR_TELEFONO = isset($lugar['LUGAR_TELEFONO']) ? $lugar['LUGAR_TELEFONO'] : '';

                                        // Verificar si el viaje ya existe
                                        $sqlCheckViaje = "SELECT COUNT(*) as count FROM `viaje-Transporte` WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";
                                        $stmtCheckViaje = $conectar->prepare($sqlCheckViaje);
                                        $stmtCheckViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                        $stmtCheckViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                        $stmtCheckViaje->execute();
                                        $selectViajeExist = $stmtCheckViaje->fetch(PDO::FETCH_ASSOC);

                                        $viajeExists = $selectViajeExist['count'];

                                        if ($viajeExists) {
                                            // Realizar UPDATE
                                            $sqlUpdateViaje = "UPDATE `viaje-Transporte` 
                                                SET `LUGAR_NOMBRE` = :LUGAR_NOMBRE, 
                                                    `LUGAR_DIRECCION` = :LUGAR_DIRECCION, 
                                                    `LUGAR_CP` = :LUGAR_CP, 
                                                    `LUGAR_POBLACION` = :LUGAR_POBLACION, 
                                                    `LUGAR_PROVINCIA` = :LUGAR_PROVINCIA, 
                                                    `LUGAR_TELEFONO` = :LUGAR_TELEFONO 
                                                WHERE `LUGAR_COD` = :LUGAR_COD AND `id_OrdenViajeTransporte` = :id_OrdenViajeTransporte";

                                            $stmtUpdateViaje = $conectar->prepare($sqlUpdateViaje);
                                            $stmtUpdateViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtUpdateViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtUpdateViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtUpdateViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtUpdateViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtUpdateViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtUpdateViaje->bindParam(':id_OrdenViajeTransporte', $lastId);

                                            $stmtUpdateViaje->execute();
                                            //echo ' ACTUALIZANDO VIAJE LUGARES_DESCARGA<br>';
                                            $registroArchivo['detalles'][] = 'TIPO T-M -> ACTUALIZANDO VIAJE LUGARES_CARGA: ' . $LUGAR_COD;
                                        } else {
                                            // Realizar INSERT
                                            $sqlInsertViaje = "INSERT INTO `viaje-Transporte`
                                                    (`id_OrdenViajeTransporte`, `numeroOrdenViaje`, `fechaLlegadaViaje`, `fechaSalidaViaje`, `ObservacionViaje`, `FirmaViajeReceptor`, `documentoManual`, `LUGAR_COD`, `LUGAR_NOMBRE`, `LUGAR_DIRECCION`, `LUGAR_CP`, `LUGAR_POBLACION`, `LUGAR_PROVINCIA`, `LUGAR_TELEFONO`, `ordenViaje`, `tipoViaje`)
                                                    VALUES
                                                    (:id_OrdenViajeTransporte,:numeroOrdenViaje, null, null, null, null, null, :LUGAR_COD, :LUGAR_NOMBRE, :LUGAR_DIRECCION, :LUGAR_CP, :LUGAR_POBLACION, :LUGAR_PROVINCIA, :LUGAR_TELEFONO, :ordenViaje, 'DESCARGA')";

                                            $stmtInsertViaje = $conectar->prepare($sqlInsertViaje);
                                            $stmtInsertViaje->bindParam(':id_OrdenViajeTransporte', $lastId);
                                            $stmtInsertViaje->bindParam(':numeroOrdenViaje', $numeroTransporte);
                                            $stmtInsertViaje->bindParam(':LUGAR_COD', $LUGAR_COD);
                                            $stmtInsertViaje->bindParam(':LUGAR_NOMBRE', $LUGAR_NOMBRE);
                                            $stmtInsertViaje->bindParam(':LUGAR_DIRECCION', $LUGAR_DIRECCION);
                                            $stmtInsertViaje->bindParam(':LUGAR_CP', $LUGAR_CP);
                                            $stmtInsertViaje->bindParam(':LUGAR_POBLACION', $LUGAR_POBLACION);
                                            $stmtInsertViaje->bindParam(':LUGAR_PROVINCIA', $LUGAR_PROVINCIA);
                                            $stmtInsertViaje->bindParam(':LUGAR_TELEFONO', $LUGAR_TELEFONO);
                                            $stmtInsertViaje->bindParam(':ordenViaje', $viajeOrden);

                                            $stmtInsertViaje->execute();
                                            $contadorViajesInsertados++;
                                            //              echo ' INSERTANDO VIAJE LUGARES_DESCARGA<br> ';
                                            $registroArchivo['detalles'][] = 'TIPO T-M -> INSERTANDO VIAJE LUGARES_DESCARGA: ' . $LUGAR_COD;
                                        }

                                        $viajeOrden++;
                                    }
                                } else {
                                    //        echo 'El JSON no contiene el array "LUGARES_CARGA" o no es válido.<br>';
                                    $registroArchivo['errores'][] = 'JSON en LUGARES no es valido.';
                                }
                            }

                            //  echo '<p style="font-family: Arial, sans-serif; color: #800080; font-size: 15px; margin-bottom: 5px;">' . $numeroTransporte . ' - Orden Añadida BD: ' . $archivo . ' SQL: ' . $sqlInsertOrder . '</p><br>';

                            $registroArchivo['detalles'][] = 'Orden insertada en la BD: ' . $numeroTransporte;
                        }


                        //==============================================================//
                        //==============================================================//
                        //==============================================================//

                        //==============================================================//
                        //  Mover el archivo a la carpeta de destino una vez finalizado //
                        //==============================================================//

                        // Crear un directorio con el formato YYYYMMDD si no existe
                        $directorioDia = __DIR__ . '/descargas_procesados/' . date('Ymd');
                        if (!is_dir($directorioDia)) {
                            if (mkdir($directorioDia, 0777, true)) {
                                $registroArchivo['detalles'][] = 'Directorio creado: ' . $directorioDia;
                            } else {
                                $registroArchivo['errores'][] = 'Error al crear el directorio: ' . $directorioDia;
                            }
                        }

                        // Mover el archivo al directorio del día
                        $destino = $directorioDia . '/' . basename($archivo);
                        if (rename($archivo, $destino)) {
                            $registroArchivo['detalles'][] = 'Archivo movido exitosamente a ' . $destino;
                        } else {
                            $registroArchivo['errores'][] = 'Error al mover el archivo a ' . $destino;
                        }


                        // $destino = __DIR__ . '/descargas_procesados/' . basename($archivo);
                        // if (rename($archivo, $destino)) {
                        //     $registroArchivo['detalles'][] = 'Archivo movido exitosamente a ' . $destino;
                        // } else {
                        //     $registroArchivo['errores'][] = 'Error al mover el archivo a ' . $destino;
                        // }

                        //==============================================================//
                        //==============================================================//
                        //==============================================================//

                    }
                }

                // Marcar el archivo como procesado exitosamente
                $registroArchivo['procesado'] = true;
                
                // Incrementar contadores según resultado
                // Los archivos que llegan aquí ya pasaron la validación del DNI
                if (empty($registroArchivo['errores'])) {
                    $contadorArchivosProcesadosOk++;
                    $contadorRegistrosInsertados++;
                }
                // Nota: Los archivos con errores en esta sección no incrementan contador
                // porque pueden ser errores menores que no impiden el procesamiento

                // Agregar el registro del archivo al registro general
                $registroProceso[] = $registroArchivo;


                $contador++;
            }


            // Guardar el registro del proceso en un archivo JSON
            file_put_contents($nombreArchivoProcesoJson, json_encode($registroProceso, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Contar archivos en directorio de errores
            $directorioErrores = __DIR__ . '/errores_procesados/' . date('Ymd');
            $archivosEnErrores = 0;
            if (is_dir($directorioErrores)) {
                $archivosEnErrores = count(glob($directorioErrores . '/*.json'));
            }
            
            // Crear resumen del proceso
            $archivosProcesadosCorrectamente = $totalArchivos - $contadorArchivosConError;
            
            echo "<hr>";
            echo "<div class='log-entry success'><strong>📊 RESUMEN DEL PROCESO</strong></div>";
            echo "<div class='log-entry info'>📥 Archivos recogidos del FTP: <strong>$totalArchivos</strong></div>";
            echo "<div class='log-entry info'>✅ Archivos procesados correctamente: <strong>$archivosProcesadosCorrectamente</strong></div>";
            echo "<div class='log-entry warning'>⚠️ Archivos con errores: <strong>$contadorArchivosConError</strong></div>";
            flush();
            
            // Crear JSON de control en ./Ordenes/descargasProcesados/control_procesados/
            $directorioControlProcesados = __DIR__ . '/descargasProcesados/control_procesados';
            if (!is_dir($directorioControlProcesados)) {
                mkdir($directorioControlProcesados, 0777, true);
            }
            
            $fechaHoraResumen = date('Ymd_His');
            $archivoControlJson = $directorioControlProcesados . '/' . $fechaHoraResumen . '.json';
            
            $datosControl = [
                'fecha' => date('Y-m-d'),
                'hora' => date('H:i:s'),
                'timestamp' => date('Y-m-d H:i:s'),
                'archivos_recogidos_ftp' => $totalArchivos,
                'archivos_procesados_correctamente' => $archivosProcesadosCorrectamente,
                'archivos_con_error' => $contadorArchivosConError
            ];
            
            file_put_contents($archivoControlJson, json_encode($datosControl, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            echo "<div class='log-entry success'>✅ JSON de control guardado: <strong>" . basename($archivoControlJson) . "</strong></div>";
            flush();

            //ob_end_flush();

            // Redirigir a la misma página después de completar el proceso
            //header("Location: ../Transportes/subirOrdenes.php");
            //exit;

            //===========================================//
            // FUERA DE LA CONEXIÓN - SI FALLA CONEXION //
            //===========================================//

        } catch (PDOException $e) {
            // Captura y maneja cualquier excepción PDO
            echo "<div class='log-entry error'><strong>❌ ERROR DE BASE DE DATOS</strong></div>";
            echo "<div class='log-entry error'><pre>" . htmlspecialchars($e->getMessage()) . "</pre></div>";
            echo "<div class='log-entry error'><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div>";
            flush();
            responder('error', 'Error de conexión a la base de datos: ' . $e->getMessage());
            generarLog('ERROR', $e->getMessage());
        } catch (Exception $e) {
            echo "<div class='log-entry error'><strong>❌ ERROR GENERAL</strong></div>";
            echo "<div class='log-entry error'><pre>" . htmlspecialchars($e->getMessage()) . "</pre></div>";
            echo "<div class='log-entry error'><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre></div>";
            flush();
            responder('error', 'Error: ' . $e->getMessage());
        }
        ?>

    </div>

    <script>
        // Verificar sesión cada 30 segundos durante el proceso
        let intervaloSesion = setInterval(function() {
            fetch('../../config/check_session.php')
                .then(response => {
                    if (response.status === 401 || !response.ok) {
                        // Sesión expirada
                        clearInterval(intervaloSesion);
                        alert('Su sesión ha expirado. Será redirigido al login.');
                        if (window.opener) {
                            window.close();
                            window.opener.location.href = '../Login/';
                        } else {
                            window.location.href = '../Login/';
                        }
                    }
                    return response.text();
                })
                .then(data => {
                    if (data.includes('session_expired')) {
                        clearInterval(intervaloSesion);
                        alert('Su sesión ha expirado. Será redirigido al login.');
                        if (window.opener) {
                            window.close();
                            window.opener.location.href = '../Login/';
                        } else {
                            window.location.href = '../Login/';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al verificar sesión:', error);
                });
        }, 30000); // Verificar cada 30 segundos

        // Limpiar el intervalo cuando se cierra la ventana
        window.addEventListener('beforeunload', function() {
            clearInterval(intervaloSesion);
        });
    </script>

</body>

</html>

<?php
// Al final del archivo, después de completar el proceso
//$response = [
//    'status' => 'success',
//    'message' => 'Descarga completada correctamente.',
//    'processedFiles' => count($registroProceso), // Número de archivos procesados
//];
//
//header('Content-Type: application/json');
//echo json_encode($response);
//exit;
