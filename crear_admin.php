<?php
/**
 * Script para crear usuario administrador
 * Email: luiscarlos@innovabyte.es
 * Contraseña: Leader2022@
 * Rol: Administrador (1)
 * 
 * IMPORTANTE: Ejecutar este script solo una vez y luego eliminarlo por seguridad
 */

require_once("config/conexion.php");

class CrearAdmin extends Conectar {
    
    public function crearUsuarioAdmin() {
        $conectar = parent::conexion();
        parent::set_names();
        
        // Datos del administrador
        $email = 'luiscarlos@innovabyte.es';
        $password = 'Leader2022@';
        $passwordHash = md5($password); // 5f4dcc3b5aa765d61d8327deb882cf99
        $rol = 1; // Administrador
        $estado = 1; // Activo
        $nombre = 'Luis Carlos';
        $apellidos = 'Administrador';
        
        try {
            // Verificar si el usuario ya existe
            $sqlCheck = "SELECT * FROM tm_usuario WHERE correoUsu = :email";
            $stmtCheck = $conectar->prepare($sqlCheck);
            $stmtCheck->bindParam(':email', $email);
            $stmtCheck->execute();
            
            if ($stmtCheck->rowCount() > 0) {
                echo "⚠️ El usuario ya existe en la base de datos.\n";
                echo "Email: " . $email . "\n";
                return false;
            }
            
            // Insertar nuevo usuario administrador
            $sql = "INSERT INTO tm_usuario (
                correoUsu, 
                senaUsu, 
                nombreUsu, 
                apellidosUsu, 
                rolUsu, 
                estUsu,
                fecAltaUsu
            ) VALUES (
                :email,
                :password,
                :nombre,
                :apellidos,
                :rol,
                :estado,
                NOW()
            )";
            
            $stmt = $conectar->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':estado', $estado);
            
            if ($stmt->execute()) {
                echo "✅ Usuario administrador creado exitosamente!\n\n";
                echo "📧 Email: " . $email . "\n";
                echo "🔑 Contraseña: " . $password . "\n";
                echo "👤 Rol: Administrador (1)\n";
                echo "📅 Fecha: " . date('Y-m-d H:i:s') . "\n\n";
                echo "⚠️ IMPORTANTE: Elimina este archivo (crear_admin.php) por seguridad.\n";
                return true;
            } else {
                echo "❌ Error al crear el usuario.\n";
                return false;
            }
            
        } catch (PDOException $e) {
            echo "❌ Error de base de datos: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

// Ejecutar la creación del administrador
$admin = new CrearAdmin();
$admin->crearUsuarioAdmin();

?>
