<?php

class OtroConcepto extends Conectar
{


    public function mostrarConceptos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `conceptos-avisos`";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function agregarConcepto($descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "INSERT INTO `conceptos-avisos` (`descrConcepto`) VALUES ('$descripcion')";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cargarConceptos($idConcepto)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `conceptos-avisos` WHERE `idConcepto` = $idConcepto";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function editarConcepto($idConcepto, $descripcion)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `conceptos-avisos` SET `descrConcepto` = '$descripcion' WHERE `idConcepto` = $idConcepto ";

        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    public function cambiarEstado($idConcepto)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "UPDATE `conceptos-avisos` SET `estConcepto` = NOT `estConcepto` WHERE `idConcepto` = $idConcepto ";
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
}
