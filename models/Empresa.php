<?php

class Empresa extends Conectar
{

    public function listarEmpresa()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM empresa ORDER BY idEmpresa DESC LIMIT 1;";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    public function insertarEmpresa($nombreEmpresa,$dirEmpresa,$poblaEmpresa,$cpEmpresa,$provEmpresa,$paisEmpresa,$webEmpresa,$telfEmpresa,$emailEmpresa,$nifEmpresa,$regEmpresa, $inputfactPro, $inputfact, $inputfactNeg,$prefijoPro,$prefijoFact)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `empresa`(`descrEmpresa`, `dirEmpresa`, `poblaEmpresa`, `cpEmpresa`, `provEmpresa`, `paisEmpresa`, `webEmpresa`, `tlfEmpresa`, `emailEmpresa`, `nifEmpresa`, `regEmpresa`, `numFacturaPro`, `numFactura`, `numFacturaNeg`, `prefijoPro`, `prefijoFact`) 
        VALUES ('$nombreEmpresa','$dirEmpresa','$poblaEmpresa','$cpEmpresa','$provEmpresa','$paisEmpresa','$webEmpresa','$telfEmpresa','$emailEmpresa','$nifEmpresa','$regEmpresa',$inputfactPro,$inputfact,null,'$prefijoPro','$prefijoFact')";

        $sql = $conectar->prepare($sql);
        $sql->execute();

    }

    public function editarEmpresa($idEmpresa,$nombreEmpresa,$dirEmpresa,$poblaEmpresa,$cpEmpresa,$provEmpresa,$paisEmpresa,$webEmpresa,$telfEmpresa,$emailEmpresa,$nifEmpresa,$regEmpresa, $inputfactPro, $inputfact, $inputfactNeg,$prefijoPro,$prefijoFact)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empresa SET descrEmpresa = '$nombreEmpresa', dirEmpresa = '$dirEmpresa', poblaEmpresa = '$poblaEmpresa', cpEmpresa = '$cpEmpresa', provEmpresa = '$provEmpresa', paisEmpresa = '$paisEmpresa', webEmpresa = '$webEmpresa', tlfEmpresa = '$telfEmpresa', emailEmpresa = '$emailEmpresa', nifEmpresa = '$nifEmpresa', regEmpresa = '$regEmpresa',numFacturaPro = $inputfactPro,numFactura = $inputfact,numFacturaNeg = null, prefijoPro = '$prefijoPro',prefijoFact = '$prefijoFact' WHERE idEmpresa =  $idEmpresa";
      
        $sql = $conectar->prepare($sql);
        $sql->execute();
    }


    public function activarAula($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aulas`
         SET `fecModiAula`= CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid') ,
         `fecBajaAula`= null,
         `estAula`= 1 
         WHERE `idAula`= $idAula";
        
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }

    public function desactivarAula($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_aulas`
        SET `fecModiAula`= CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid') ,
        `fecBajaAula`= CONVERT_TZ(NOW(), 'UTC', 'Europe/Madrid') ,
        `estAula`= 0 
        WHERE `idAula`= $idAula";
         
         
        $sql = $conectar->prepare($sql);
        $sql->execute();
        
    }

    public function get_aula_x_id($idAula)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_aulas` WHERE idAula = $idAula";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

        
    }
    public function sumar1factprofactreal($idEmpresa){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empresa SET numFacturaPro = numFacturaPro +1, numFactura = numFactura +1 WHERE idEmpresa = $idEmpresa";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    public function sumar1factabono($idEmpresa){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE empresa SET numFacturaNeg = numFacturaNeg +1 WHERE idEmpresa = $idEmpresa";

        $sql = $conectar->prepare($sql);
        $sql->execute();
    }
    /////////////////////////////
   ///// ACTUALIZAR CONFIG ////
   ///////////////////////////
    public function listarOpciones(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `tm_config` WHERE `idConfig` = 1";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }

    public function actualizarConfig($tabla,$estado){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `tm_config` SET $tabla = '$estado' WHERE `idConfig` = 1";
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }


    public function actualizarModulo($modulo,$estado){
        $conectar = parent::conexion();
        parent::set_names();
        $dominio = $_SERVER['HTTP_HOST'];

        $sql = "UPDATE `tm_suscripcion` SET $modulo = $estado WHERE `nombreDominio` = '$dominio'";
       
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }

    public function consultarCodigo(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT codigoPuertaLocal FROM `tm_config` WHERE `idConfig` = 1";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function aumentarNumFacturaPro(){
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `empresa` SET `numFacturaPro` = `numFacturaPro` + 1";
    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

   

    

}