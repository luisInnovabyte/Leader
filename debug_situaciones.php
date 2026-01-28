<?php
// Script de diagnóstico para verificar la tabla situaciones-Transporte

require_once("config/conexion.php");

class DebugSituaciones extends Conectar {
    
    public function verificarTabla() {
        $conectar = parent::conexion();
        parent::set_names();
        
        echo "<h2>Diagnóstico de situaciones-Transporte</h2>";
        
        // Verificar si la tabla existe
        echo "<h3>1. Verificar existencia de la tabla:</h3>";
        $sql = "SHOW TABLES LIKE 'situaciones-Transporte'";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            echo "<p style='color:green;'>✅ La tabla 'situaciones-Transporte' existe</p>";
        } else {
            echo "<p style='color:red;'>❌ La tabla 'situaciones-Transporte' NO existe</p>";
            return;
        }
        
        // Contar todos los registros
        echo "<h3>2. Contar todos los registros:</h3>";
        $sql = "SELECT COUNT(*) as total FROM `situaciones-Transporte`";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch();
        echo "<p>Total de registros: <strong>" . $count['total'] . "</strong></p>";
        
        // Mostrar todos los registros
        echo "<h3>3. Mostrar todos los registros:</h3>";
        $sql = "SELECT * FROM `situaciones-Transporte`";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($all) > 0) {
            echo "<table border='1' cellpadding='5' style='border-collapse:collapse;'>";
            echo "<tr style='background:#ddd;'>";
            echo "<th>idSituacion</th>";
            echo "<th>nombreSituacion</th>";
            echo "<th>estSituacion</th>";
            echo "<th>fecAltaSituacion</th>";
            echo "<th>fecModiSituacion</th>";
            echo "<th>fecBajaSituacion</th>";
            echo "</tr>";
            
            foreach ($all as $row) {
                $color = $row['estSituacion'] == 1 ? 'lightgreen' : 'lightcoral';
                echo "<tr style='background:$color;'>";
                echo "<td>" . $row['idSituacion'] . "</td>";
                echo "<td>" . $row['nombreSituacion'] . "</td>";
                echo "<td>" . ($row['estSituacion'] == 1 ? 'ACTIVO' : 'INACTIVO') . "</td>";
                echo "<td>" . $row['fecAltaSituacion'] . "</td>";
                echo "<td>" . ($row['fecModiSituacion'] ?? 'NULL') . "</td>";
                echo "<td>" . ($row['fecBajaSituacion'] ?? 'NULL') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:orange;'>⚠️ No hay registros en la tabla</p>";
        }
        
        // Contar registros activos
        echo "<h3>4. Contar registros ACTIVOS (estSituacion = 1):</h3>";
        $sql = "SELECT COUNT(*) as total FROM `situaciones-Transporte` WHERE estSituacion = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $countActivos = $stmt->fetch();
        echo "<p>Total de registros activos: <strong>" . $countActivos['total'] . "</strong></p>";
        
        // Mostrar registros activos
        echo "<h3>5. Registros activos (los que debería devolver el select):</h3>";
        $sql = "SELECT * FROM `situaciones-Transporte` WHERE estSituacion = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $activos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($activos) > 0) {
            echo "<pre>" . json_encode($activos, JSON_PRETTY_PRINT) . "</pre>";
        } else {
            echo "<p style='color:red;'>❌ No hay registros activos. Necesitas ejecutar el script INSERT.</p>";
            echo "<h4>Script SQL para insertar datos:</h4>";
            echo "<pre style='background:#f0f0f0; padding:10px;'>";
            echo "INSERT INTO `situaciones-Transporte` (`nombreSituacion`, `estSituacion`, `fecAltaSituacion`, `fecModiSituacion`, `fecBajaSituacion`) 
VALUES 
('En Recogida', 1, CURDATE(), NULL, NULL),
('En Entrega', 1, CURDATE(), NULL, NULL),
('En Tránsito', 1, CURDATE(), NULL, NULL),
('Avería', 1, CURDATE(), NULL, NULL),
('Retraso', 1, CURDATE(), NULL, NULL);";
            echo "</pre>";
        }
        
        // Información de la base de datos
        echo "<h3>6. Información de conexión:</h3>";
        $sql = "SELECT DATABASE() as db_name";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        $dbInfo = $stmt->fetch();
        echo "<p>Base de datos actual: <strong>" . $dbInfo['db_name'] . "</strong></p>";
    }
}

$debug = new DebugSituaciones();
$debug->verificarTabla();
?>
