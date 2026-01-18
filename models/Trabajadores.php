<?php

class Trabajador extends Conectar
{


    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `view_trabajadores_usuario`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($nombre, $profesiones)
    {
        // Conexión a la base de datos
        $conectar = parent::conexion();
        parent::set_names();

        // Convertir array de profesiones a JSON
        $profesiones = json_encode($profesiones);

        // Verificar si el idUsuario_trabajador ya existe
        $sql = "SELECT COUNT(*) as count FROM `trabajadores-avisos` WHERE `idUsuario_trabajador` = $nombre[0]";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $result = $sql->fetch();

        if ($result['count'] > 0) {
            // Si existe, realizar un UPDATE
            $sql = "UPDATE `trabajadores-avisos` SET `arrayProfesiones_trabajador` = '$profesiones' WHERE `idUsuario_trabajador` = $nombre[0]";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();
        } else {
            // Si no existe, realizar un INSERT
            $sql = "INSERT INTO `trabajadores-avisos` (`idUsuario_trabajador`, `arrayProfesiones_trabajador`) VALUES ($nombre[0], '$profesiones')";
            $sql = $conectar->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();
        }
    }

    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `trabajadores-avisos` WHERE `idTrabajador` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `trabajadores-avisos` SET `descAccion` = '$descripcion' WHERE `idAccion` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `trabajadores-avisos` SET `estTrabajador` = NOT `estTrabajador` WHERE `idTrabajador` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function profesionesTrabajador($idProfesion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `profesiones-avisos` WHERE `idProfesion` = $idProfesion";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
