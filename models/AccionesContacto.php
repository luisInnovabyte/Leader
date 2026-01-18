<?php

class AccionContacto extends Conectar
{


    public function mostrarAcciones()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `accionesContacto-avisos`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarElemento($descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `accionesContacto-avisos` (`descAccion`) VALUES ('$descripcion')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarElemento($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `accionesContacto-avisos` WHERE `idAccion` = $idElemento";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarElemento($idElemento, $descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `accionesContacto-avisos` SET `descAccion` = '$descripcion' WHERE `idAccion` = $idElemento ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idElemento)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `accionesContacto-avisos` SET `estAccion` = NOT `estAccion` WHERE `idAccion` = $idElemento ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
