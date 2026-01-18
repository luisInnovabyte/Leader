<?php
class Estado extends Conectar
{

    public function mostrarEstados()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `estados-avisos`";


        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

}
