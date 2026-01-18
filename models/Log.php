<?php

class Log
{
    public $fecha,$priPos,$segPos,$terPos,$fechaActual,$horaActual;
  

    public function __construct($priPos, $segPos, $terPos)
    {
        date_default_timezone_set("Europe/Madrid");
        setlocale(LC_ALL, 'es_ES');
        $this->priPos = $priPos;
        $this->segPos = $segPos;
        $this->terPos = $terPos;
        $this->fechaActual = date('d-m-Y');
        $this->horaActual = date('H:i:s');
    }

    public function nombreFichero()
    {
        date_default_timezone_set("Europe/Madrid");
        setlocale(LC_ALL, 'es_ES');

        $fechaActualNombre = date('Ymd'); //devuelve un string 
        // Usar ruta absoluta desde la raíz del proyecto
        $baseDir = dirname(__DIR__);
        $nombreFinal = $baseDir . '/public/log/' . $fechaActualNombre . '.log';

        return trim($nombreFinal);
    }


    public function grabarLinea()
    {
        $nombreFic = $this->nombreFichero();

        // Verificar que el directorio existe, si no, crearlo
        $dirLog = dirname($nombreFic);
        if (!is_dir($dirLog)) {
            @mkdir($dirLog, 0777, true);
        }

        $archivo = @fopen($nombreFic, 'a+');
        if ($archivo === false) {
            // Si no se puede abrir el archivo, salir silenciosamente
            return false;
        }
        
        fwrite($archivo, $this->priPos);
        fwrite($archivo, '; Archivo: ');
        fwrite($archivo, $this->segPos);
        fwrite($archivo, '; Acción: ');
        fwrite($archivo, $this->terPos);
        fwrite($archivo, '; Fecha: ');
        fwrite($archivo, $this->fechaActual);
        fwrite($archivo, '; Hora: ');
        fwrite($archivo, $this->horaActual);
        // baja una linea 
        fwrite($archivo, "\n");
        fclose($archivo);
        
        return true;
    }
}
