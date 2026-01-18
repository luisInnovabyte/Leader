<?php

class Comercial extends Conectar
{

    public function recogerJson()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `json-Logistica`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function guardarMostrarOcultar($datosJson)
    {
        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mostrarOcultarJson`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();
    }
    public function guardarDeliveredGoods($datosJson)
    {
        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainDeliveredGoods_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();
    }
    public function guardarSlider($datosJson)
    {
        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainSlider_Json`=:datosJsonParseado";



        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarDigital($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainDigitalFreight_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarClients($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainCases&Clients_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarServicios($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `ServiciosPaginas_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }

    public function guardarOpinion($datosJson)
    {



        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainServices_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarGlobalLogistics($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainGlobalLogistics_Json`=:datosJsonParseado";



        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarLogo($datosJson)
    {





        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainHeader_Json`=:datosJsonParseado";



        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarFooter($datosJson)
    {





        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainFooter_Json`=:datosJsonParseado";



        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarMenu($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainMenu_Json`=:datosJsonParseado";



        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarContacto($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainContactInformation_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarHead($datosJson)
    {





        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainHead_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarLogos($datosJson)
    {




        $datosJsonParseado = json_encode($datosJson);
        $conectar = parent::conexion();

        // Establecer la codificación de caracteres a UTF-8
        $conectar->exec("set names utf8");

        $sql = "UPDATE `json-Logistica` SET `mainHeader_Json`=:datosJsonParseado";


        $sql = $conectar->prepare($sql);
        $sql->bindParam(':datosJsonParseado', $datosJsonParseado, PDO::PARAM_STR); // Bind parameters
        $sql->execute();

        // No es necesario fetchAll() para una sentencia UPDATE
        // return $resultado = $sql->fetchAll();

    }
    public function guardarInformacion($info)
    {


        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `json-Logistica` SET mainMap_Json = JSON_SET(mainMap_Json, '$.ES.BloqueCentralMapaInfo', '$info')";
        

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function modificarMapa($mapa)
    {


        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `json-Logistica` SET mainMap_Json = JSON_SET(mainMap_Json, '$.ES.BloqueCentralMapa.IframeSrc', '$mapa')";
        
  
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
    public function modificarServicio($nombreOriginal,$nombreNuevo)
    {

        $nombreOriginal = convertirASlug($nombreOriginal);
        $nombreNuevo = convertirASlug($nombreNuevo);
        $conectar = parent::conexion();
        parent::set_names();
        $sql="UPDATE `json-Logistica` SET ServiciosPaginas_Json = REPLACE(ServiciosPaginas_Json, '$nombreOriginal', '$nombreNuevo');";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();

    }
}
