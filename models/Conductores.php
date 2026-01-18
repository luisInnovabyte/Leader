<?php
class Conductor extends Conectar
{

    public function mostrarElementos()
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "SELECT * FROM `transportistas-Transporte`";


    
        $sql = $conectar->prepare($sql);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }
    
}
