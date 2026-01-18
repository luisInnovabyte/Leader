<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
echo "<h2>Debug mostrarUsuarios</h2>";

try {
    echo "<p>1. Iniciando sesión...</p>";
    session_start();
    
    echo "<p>2. Incluyendo archivos...</p>";
    require_once("config/conexion.php");
    require_once("config/funciones.php");
    require_once("models/Usuario.php");
    
    echo "<p>3. Creando objeto Usuario...</p>";
    $usuario = new Usuario();
    
    echo "<p>4. Llamando a mostrarUsuarios()...</p>";
    $datos = $usuario->mostrarUsuarios();
    
    echo "<p>5. Usuarios obtenidos: " . count($datos) . "</p>";
    
    echo "<p>6. Procesando datos...</p>";
    $data = array();
    
    if (!$datos) {
        $datos = array();
    }
    
    $contador = 0;
    foreach ($datos as $row) {
        $contador++;
        echo "<p>6.{$contador} Procesando usuario ID: {$row['idUsu']}</p>";
        
        if ($row["rolUsu"] != 999) {
            $sub_array = array();
            $sub_array[] = $row["idUsu"];
            $sub_array[] = $row["nombreUsu"] . ' ' . $row["apellidosUsu"];
            $sub_array[] = $row["correoUsu"];
            
            $idTransportista = isset($row["idTransportista"]) ? $row["idTransportista"] : '-';
            if ($idTransportista == '0' || $idTransportista == 0 || empty($idTransportista) || $idTransportista == '-') {
                $sub_array[] = '-';
            } else {
                $sub_array[] = "<a href='../MntConductor/index.php?idConductor=" . $idTransportista . "'>" . $idTransportista . "</a>";
            }
            
            if ($row["rolUsu"] == 0) {
                $sub_array[] = '<span class="rol badge bg-primary">Usuario</span>';
            } else if ($row["rolUsu"] == 1) {
                $sub_array[] = '<span class="rol badge bg-info">Administrador</span>';
            }
            
            if ($row["estUsu"] == 1) {
                $sub_array[] = '<span class="badge bg-success">Activo</span>';
            } else {
                $sub_array[] = '<span class="badge bg-secondary">Inactivo</span>';
            }
            
            $sub_array[] = '<a href="../Perfil/index.php?tokenUsuario='.$row["tokenUsu"].'">Ver</a>';
            $sub_array[] = 'Botones';
            
            if (isset($row["registroInicioSesionUsu"]) && !empty($row["registroInicioSesionUsu"])) {
                try {
                    $fechaRegistro = $row["registroInicioSesionUsu"];
                    if (strlen($fechaRegistro) <= 10) {
                        $fechaRegistro .= ' 00:00:00';
                    }
                    $registroSesion = obtenerTiempoTranscurrido($fechaRegistro);
                } catch (Exception $e) {
                    $registroSesion = 'Error: ' . $e->getMessage();
                }
            } else {
                $registroSesion = 'Nunca';
            }
            $sub_array[] = $registroSesion;
            
            $data[] = $sub_array;
        }
        
        if ($contador >= 5) {
            echo "<p>Limitando a 5 usuarios para depuración...</p>";
            break;
        }
    }
    
    echo "<p>7. Generando resultado JSON...</p>";
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    
    echo "<p>8. Resultado generado correctamente</p>";
    echo "<pre>";
    echo htmlspecialchars(json_encode($results, JSON_PRETTY_PRINT));
    echo "</pre>";
    
    echo "<h3 style='color:green;'>✓ Proceso completado sin errores</h3>";
    
} catch (Exception $e) {
    echo "<h3 style='color:red;'>ERROR CAPTURADO:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
} catch (Error $e) {
    echo "<h3 style='color:red;'>ERROR FATAL:</h3>";
    echo "<p><strong>Mensaje:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "</body></html>";
