<?php

class Config extends Conectar
{

   public function get_datos_empresa(){

   $conectar = parent::conexion();
   parent::set_names();
   $sql = "SELECT * FROM tm_config WHERE `idConfig` = 1";

   $sql = $conectar->prepare($sql);
   $sql->execute();
   return $resultado = $sql->fetchAll();

   }
   public function get_datos_empresaConfig(){

   $conectar = parent::conexion();
   parent::set_names();
   $sql = "SELECT * FROM `view_empresa_config` WHERE `idConfig` = 1";
$json_string = json_encode($sql);
$file = 'BFS.json';
file_put_contents($file, $json_string);
   $sql = $conectar->prepare($sql);
   $sql->execute();
   return $resultado = $sql->fetchAll();
   
   }
   public function get_datos_suscripcion() {
    $conectar = parent::conexion();
    parent::set_names();

    // Obtener el dominio
    $dominio = $_SERVER['HTTP_HOST'];
    $dominio_md5 = md5($dominio);

    // Preparar y guardar la consulta SQL
    $sql = "SELECT * FROM `tm_suscripcion` WHERE `idSoftware` = '$dominio_md5'";
    file_put_contents('HRSA.json', json_encode($sql));

    // Ejecutar consulta
    $stmt = $conectar->prepare($sql);
    $stmt->execute();

    // Obtener resultados
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Guardar resultado en JSON para depuración
    file_put_contents('resultado_suscripcion.json', json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return $resultado;
	}
   
}
