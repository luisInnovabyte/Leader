<?php
require_once(__DIR__ . '/config/conexion.php');

$correoUsuario = 'software@efeuno.es';

echo "<h2>Verificación de Usuario - Base de Datos</h2>";

try {
    // Verificar datos directos en BD
    $sql = "SELECT idUsu, correoUsu, nombreUsu, apellidosUsu, rolUsu, estUsu, senaUsu FROM tm_usuario WHERE correoUsu = :correo";
    $stmt = $conectar->prepare($sql);
    $stmt->bindParam(':correo', $correoUsuario, PDO::PARAM_STR);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario) {
        echo "<h3>✅ Usuario encontrado en BD:</h3>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Campo</th><th>Valor</th><th>Tipo</th></tr>";
        foreach ($usuario as $campo => $valor) {
            if ($campo !== 'senaUsu') { // No mostrar contraseña
                echo "<tr><td><strong>$campo</strong></td><td>$valor</td><td>" . gettype($valor) . "</td></tr>";
            } else {
                echo "<tr><td><strong>$campo</strong></td><td>***HASH***</td><td>string</td></tr>";
            }
        }
        echo "</table>";
        
        echo "<h3>🔍 Análisis de rolUsu:</h3>";
        echo "<ul>";
        echo "<li><strong>Valor:</strong> " . $usuario['rolUsu'] . "</li>";
        echo "<li><strong>Tipo PHP:</strong> " . gettype($usuario['rolUsu']) . "</li>";
        echo "<li><strong>Es igual a 1?:</strong> " . ($usuario['rolUsu'] == 1 ? 'SÍ' : 'NO') . "</li>";
        echo "<li><strong>Es idéntico a 1?:</strong> " . ($usuario['rolUsu'] === 1 ? 'SÍ' : 'NO') . "</li>";
        echo "<li><strong>Es igual a '1'?:</strong> " . ($usuario['rolUsu'] == '1' ? 'SÍ' : 'NO') . "</li>";
        echo "<li><strong>Es igual a 0?:</strong> " . ($usuario['rolUsu'] == 0 ? 'SÍ' : 'NO') . "</li>";
        echo "</ul>";
        
        // Verificar contraseña con MD5
        echo "<h3>🔐 Verificación de contraseña:</h3>";
        $passTest = 'Leader2022@';
        $md5Pass = md5($passTest);
        echo "<ul>";
        echo "<li><strong>Contraseña de prueba:</strong> $passTest</li>";
        echo "<li><strong>MD5 de prueba:</strong> $md5Pass</li>";
        echo "<li><strong>MD5 en BD:</strong> " . $usuario['senaUsu'] . "</li>";
        echo "<li><strong>¿Coinciden?:</strong> " . ($usuario['senaUsu'] === $md5Pass ? '✅ SÍ' : '❌ NO') . "</li>";
        echo "</ul>";
        
        // Simular la consulta de login
        echo "<h3>🔄 Simulación de Login:</h3>";
        $sqlLogin = "SELECT * FROM tm_usuario WHERE correoUsu = :correo AND senaUsu = MD5(:pass)";
        $stmtLogin = $conectar->prepare($sqlLogin);
        $stmtLogin->bindParam(':correo', $correoUsuario, PDO::PARAM_STR);
        $stmtLogin->bindParam(':pass', $passTest, PDO::PARAM_STR);
        $stmtLogin->execute();
        $resultLogin = $stmtLogin->fetch(PDO::FETCH_ASSOC);
        
        if ($resultLogin) {
            echo "✅ Login exitoso con contraseña '$passTest'<br><br>";
            echo "<strong>rolUsu devuelto por query:</strong> " . $resultLogin['rolUsu'] . " (tipo: " . gettype($resultLogin['rolUsu']) . ")<br>";
        } else {
            echo "❌ Login falló - Contraseña no coincide<br>";
        }
        
    } else {
        echo "<p>❌ No se encontró el usuario con email: $correoUsuario</p>";
    }
    
    // Verificar estructura de la tabla
    echo "<h3>📊 Estructura del campo rolUsu:</h3>";
    $sqlDesc = "DESCRIBE tm_usuario";
    $stmtDesc = $conectar->prepare($sqlDesc);
    $stmtDesc->execute();
    $fields = $stmtDesc->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    foreach ($fields as $field) {
        if ($field['Field'] === 'rolUsu') {
            echo "<tr style='background-color: yellow;'>";
            echo "<td><strong>" . $field['Field'] . "</strong></td>";
            echo "<td>" . $field['Type'] . "</td>";
            echo "<td>" . $field['Null'] . "</td>";
            echo "<td>" . $field['Key'] . "</td>";
            echo "<td>" . $field['Default'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
