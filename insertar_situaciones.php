<?php
// Script para insertar situaciones en el servidor

require_once("config/conexion.php");

class InsertarSituaciones extends Conectar {
    
    public function insertarDatos() {
        $conectar = parent::conexion();
        parent::set_names();
        
        echo "<h2>Insertar Situaciones de Transporte</h2>";
        
        // Verificar si ya existen datos
        $sql = "SELECT COUNT(*) as total FROM `situaciones-Transporte`";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch();
        
        echo "<p>Registros actuales en la tabla: <strong>" . $count['total'] . "</strong></p>";
        
        if ($count['total'] > 0) {
            echo "<p style='color:orange;'>⚠️ Ya existen " . $count['total'] . " registros. ¿Quieres continuar?</p>";
            echo "<p>Si continúas, se insertarán registros adicionales (no se borrarán los existentes)</p>";
        }
        
        try {
            // Insertar las situaciones
            $sql = "INSERT INTO `situaciones-Transporte` (`nombreSituacion`, `estSituacion`, `fecAltaSituacion`, `fecModiSituacion`, `fecBajaSituacion`) 
            VALUES 
            ('En Recogida', 1, CURDATE(), NULL, NULL),
            ('En Entrega', 1, CURDATE(), NULL, NULL),
            ('En Tránsito', 1, CURDATE(), NULL, NULL),
            ('Avería', 1, CURDATE(), NULL, NULL),
            ('Retraso', 1, CURDATE(), NULL, NULL)";
            
            $stmt = $conectar->prepare($sql);
            $resultado = $stmt->execute();
            
            if ($resultado) {
                echo "<p style='color:green; font-size:20px;'>✅ Situaciones insertadas correctamente</p>";
                
                // Mostrar los registros insertados
                echo "<h3>Registros en la tabla ahora:</h3>";
                $sql = "SELECT * FROM `situaciones-Transporte` WHERE estSituacion = 1 ORDER BY idSituacion DESC";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
                echo "<tr style='background:#4CAF50; color:white;'>";
                echo "<th>ID</th>";
                echo "<th>Nombre Situación</th>";
                echo "<th>Estado</th>";
                echo "<th>Fecha Alta</th>";
                echo "</tr>";
                
                foreach ($registros as $row) {
                    echo "<tr style='background:lightgreen;'>";
                    echo "<td>" . $row['idSituacion'] . "</td>";
                    echo "<td><strong>" . $row['nombreSituacion'] . "</strong></td>";
                    echo "<td>ACTIVO</td>";
                    echo "<td>" . $row['fecAltaSituacion'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                echo "<br><p style='background:#e8f5e9; padding:15px; border-left:4px solid #4CAF50;'>";
                echo "<strong>✓ El select de situaciones ahora debería funcionar correctamente.</strong><br>";
                echo "Recarga la página de incidencias y prueba a abrir el modal nuevamente.";
                echo "</p>";
                
            } else {
                echo "<p style='color:red;'>❌ Error al insertar los datos</p>";
                print_r($stmt->errorInfo());
            }
            
        } catch (PDOException $e) {
            echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
            
            // Si el error es por duplicados, mostrar los datos existentes
            if ($e->getCode() == 23000) {
                echo "<p style='color:orange;'>Parece que algunos registros ya existen.</p>";
                echo "<h3>Registros actuales:</h3>";
                $sql = "SELECT * FROM `situaciones-Transporte` ORDER BY idSituacion";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<pre>" . json_encode($registros, JSON_PRETTY_PRINT) . "</pre>";
            }
        }
    }
}

$insertar = new InsertarSituaciones();
$insertar->insertarDatos();
?>
