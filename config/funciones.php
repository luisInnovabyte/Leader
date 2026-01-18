<?php
// GENERAR TOKEN DE 32 POSICIONES
function generarToken($longitud = 32) {
    
    $tiempo = transformarFecha("", ["d","m","Y","H","i","s"]);
    $codigo = dividirYConvertirALetras($tiempo);
    $codigoLongitud = strlen($codigo);
    $longitud -= $codigoLongitud;
    // Genera bytes aleatorios seguros
    $bytes = random_bytes($longitud / 2);

    // Convierte los bytes en una cadena hexadecimal
    $token = bin2hex($bytes);
   
    return $codigo.$token;
}

//reemplazarComaPorPunto(12,34) => 12.34
function reemplazarComaPorPunto($cadena) //Recoge una Cadena y sustituye las "," por "."
{
    $nuevaCadena = str_replace(',', '.', $cadena); //Sistuye las "," por "."
    return $nuevaCadena; //Devolver cadena
}
//encryptNumber(12) => 985660
function encryptNumber($number) //Encriptar un numero, usado sobre todo para id que se pasan por get
{

    $key = 985648; //Llave que se usa para el cifrado

    // Cifrar el número
    $encrypted = $number ^ $key;

    // Devolver el número cifrado en formato de cadena de dígitos
    return strval($encrypted);
}
//decryptNumber(985660) => 12
function decryptNumber($encryptedNumber) //Descrifar el numero cifrado con encryptNumber()
{
    // Convertir la cadena cifrada a número
    $encrypted = intval($encryptedNumber);

    $key = 985648; //Llave que se usa para el descifrado debe coincidir con la de cifrado


    // Descifrar el número
    $decrypted = $encrypted ^ $key;

    // Devolver el número descifrado
    return $decrypted;
}

//validarTelefono(666555444) => true
function validarTelefono($numero) //Valida que el télefono tenga 9 numeros
{
    // $numero=trim($numero); // quito los espacios de delante y detrás
    $numero = str_replace(' ', '', $numero); // Quito los espacio de enmedio
    //echo ($numero) . '<br>';
    $reg = "#^\b\d{9}\b#";
    return preg_match($reg, $numero);
}


// FUNCION PARA TRANSFORMAR LOS NUMEROS EN HREF. 
// callTelf(654654654) => <a href='tel:654654654'>654654654</a>
function callTelf($tlf)
{
    $telSani = preg_replace('([^0-9])', '', $tlf); //Solo deja los números
    if (validarTelefono($telSani) == true) {
        $text = "<a href='tel:" . $telSani . "'>" . $telSani . "</a>";
        return $text;
    } else {
        return "";
    }
}



// FUNCION PARA TRANSFORMAR LOS CORREOS EN HREF. 
// callTelf('victor@efeuno.es') => <a href='mailto:victor@efeuno.es'>victor@efeuno.es</a>
function callEmail($email)
{
    $text = "<a href='mailto:" . $email . "'>" . strtolower($email) . "</a>";
    return $text;
}




// COMPROBAR FECHA VACIA
// isFechaVacia(2024-10-20) => false
function isFechaVacia($fecha)
{

    if ($fecha == '0000-00-00' || $fecha == null) {
        return true;
    } else {
        return false;
    }
}

//Para validar conraseñas
//validar_clave('') => true
function validar_clave($clave, $error)
{
    if (strlen($clave) < 6) {
        $error .= "La clave debe tener al menos 6 caracteres <br>";
        return false;
    }
    if (strlen($clave) > 16) {
        $error .= "La clave no puede tener más de 16 caracteres <br>";
        return false;
    }
    if (!preg_match('`[a-z]`', $clave)) {
        $error .= "La clave debe tener al menos una letra minúscula <br>";
        return false;
    }
    if (!preg_match('`[A-Z]`', $clave)) {
        $error .= "La clave debe tener al menos una letra mayúscula <br>";
        return false;
    }
    if (!preg_match('`[0-9]`', $clave)) {
        $error .= "La clave debe tener al menos un caracter numérico <br>";
        return false;
    }
    return true;
}


function obtenerTiempoTranscurrido($fecha)
{

    $fecha = transformarFecha($fecha,["d","-","m","-","Y"," ","H",":","i",":","s"]);
    $fecha_actual = new DateTime();

    $fecha_pasada = new DateTime($fecha);
    $diferencia = $fecha_actual->diff($fecha_pasada);

    if ($diferencia->y > 0) {
        return "Hace más de 1 año";
    } elseif ($diferencia->m > 6) {
        return "Hace más de 6 meses";
    } elseif ($diferencia->m > 0) {
        return "Hace " . $diferencia->m . " mes" . (($diferencia->m > 1) ? "es" : "");
    } elseif ($diferencia->d > 7) {
        $semanas = floor($diferencia->d / 7);
        return "Hace " . $semanas . " semana" . (($semanas > 1) ? "s" : "");
    } elseif ($diferencia->d > 0) {
        return "Hace " . $diferencia->d . " día" . (($diferencia->d > 1) ? "s" : "");
    } elseif ($diferencia->h > 0) {
        return "Hace " . $diferencia->h . " hora" . (($diferencia->h > 1) ? "s" : "");
    } elseif ($diferencia->i > 0) {
        return "Hace " . $diferencia->i . " minuto" . (($diferencia->i > 1) ? "s" : "");
    } elseif ($diferencia->s > 0) {
        return "Hace " . $diferencia->s . " segundo" . (($diferencia->s > 1) ? "s" : "");
    } else {
        return "Ahora";
    }
}
//recibe un string fecha en formado "Y-m-d  y te devuelve cuantos dias falta para esa fecha
//obtenerTiempoRestante("2023-10-20") => 273 dias (ejemplo)
function obtenerTiempoRestante($fecha)
{
    
    $fecha_actual = new DateTime();
    
    $fecha_final = new DateTime($fecha);
    $fecha_final2 = new DateTime($fecha);
    $fecha_final = $fecha_final->modify('+1 day');
    $diferencia = $fecha_actual->diff($fecha_final);
    $dias = $diferencia->d;
    $meses = $diferencia->m;
    if ($fecha_final < $fecha_actual) {

        return "Finalizado";
    } else {
        if ($dias < 1 && $meses == 0) {
            return "Finaliza hoy";
        } else if ($dias == 1 && $meses == 0) {
            return "Finaliza en " . $dias . " dia.";
        } else if ($dias > 1 && $dias <= 15 && $meses == 0) { 
            return "Finaliza en " . $dias . " dias.";
        } else {
            return "Finaliza el " . $fecha_final2->format("d/m/Y");
        }
    }
}

//recibe fecha un string en formato "AAAA-MM-DD HH:MM:SS" y tiene que devolver solo la fecha "AAAA-MM-DD"
function SoloFechaRem($fecha)
{

    $tm_fecha = new DateTime($fecha);
    $tm_fecha = $tm_fecha->format("Y-m-d");

    return $tm_fecha;
}

// esta funcion se le pasa un string con el formato 
// AAAA-MM-DD HH:MM:SS y devuelve como string DD-MM-AAAA HH:MM_SS
function FechaHoraLocal_string($fecha)
{
    // año
    $anyo = substr($fecha, 0, 4);
    //mes
    $mes = substr($fecha, 5, 2);
    //dia
    $dia = substr($fecha, 8, 2);
    //hora
    $hora = substr($fecha, 11, 8);

    $newFechaF = ' ' . $hora . ' ' . $dia . '-' . $mes . '-' . $anyo;
    return $newFechaF;
}
function FechaLocal_string($fecha)
{
    // año
    $anyo = substr($fecha, 0, 4);
    //mes
    $mes = substr($fecha, 5, 2);
    //dia
    $dia = substr($fecha, 8, 2);

    $newFechaF = ' ' . $dia . '-' . $mes . '-' . $anyo;
    return $newFechaF;
}

function HoraString($fecha)
{
    // año
    $anyo = substr($fecha, 0, 4);
    //mes
    $mes = substr($fecha, 5, 2);
    //dia
    $dia = substr($fecha, 8, 2);
    //hora
    $hora = substr($fecha, 11, 8);
    return $hora;
}



//recibe fecha en formato Mysql (Y-m-d) y la devuelve en formato local (d-m-Y)
function FechaLocal($fecha)
{

    $obj_fecha = date_create_from_format('Y-m-d', $fecha);
    $fecha_con_formato = date_format($obj_fecha, "d-m-Y");
    if ($fecha_con_formato == false) {
        return "";
    }
    return $fecha_con_formato;
}

function horaLocalSinSegundos($hora)
{
    $partes = explode(':', $hora);
    $horas = intval($partes[0]);
    $minutos = intval($partes[1]);
    $horaFormateada = str_pad($horas, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutos, 2, '0', STR_PAD_LEFT);
    return $horaFormateada;
}

function FechaHoraLocal($fecha)
{
    $obj_fecha = date_create_from_format('Y-m-d H:i:s', $fecha);
    $fecha_con_formato = date_format($obj_fecha, "d-m-Y H:i");
    return $fecha_con_formato;
}
//recibe fecha en formato Mysql (Y-m-d H:i:s) y la devuelve en formato local (d-m-Y)

function FechaLocalSinHora($fecha)
{
    $obj_fecha = date_create_from_format('Y-m-d H:i:s', $fecha);
    $fecha_con_formato = date_format($obj_fecha, "d-m-Y");
    return $fecha_con_formato;
}



// para los index 
function FechaLocalD($fecha)
{
    $obj_fecha = date_create_from_format('Y-m-d H:i:s', $fecha);
    $fecha_con_formato = date_format($obj_fecha, "d-m-Y");
    return $fecha_con_formato;
}



// Se recibe fecha local (d-m-Y) y se devuelve en formato Mysql(Y-m-d)
function FechaRemota($fecha)
{
    $local = new DateTime($fecha);
    $remota = $local->format('Y-m-d');
    //$obj_fecha = date_create_from_format('d-m-Y', $fecha);
    //$fecha_con_formato = date_format($obj_fecha, "Y-m-d");
    return $remota;
}


// Dadas dos fechas nos da la diferencia en MINUTOS que hay entre ellos.
function DifFechas($fecInicio, $fecFinal)
{

    setlocale(LC_ALL, 'es_ES');
    date_default_timezone_set('Europe/Madrid');

    $totdiferencia = 0;
    if (!is_object($fecInicio)) {
        $fecInicio = new DateTime($fecInicio);
    }
    if (!is_object($fecFinal)) {
        $fecFinal = new DateTime($fecFinal);
    }


    //diferencia entre fechas en días
    $dif = $fecFinal->diff($fecInicio);


    $difHoras = $dif->format('%R%H');
    $difMin =   $dif->format('%R%i');
    /*$totdiferencia = ($difHoras * 60 + $difMin);*/

    return $difHoras;

    // Para saber la diferencia y si está en tiempo
    /* <p>Han pasado: <?php echo $dif->format('%R%a') . ' dias'?> </p>*/
    /* <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p> */
    /* <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p> */
    // https://www.php.net/manual/en/dateinterval.format.php
    // $dif es un objeto.
    /* $dif['h'] -- Diferencia en las horas */
    /* $dif['i']  Diferencia en los minutos */


    /*********************************************/
    /*********** EJEMPLO DE FUNCIONAMIENTO *******/
    /*********************************************/
    /*<?php $fechaIni = "20-05-2022 14:00:00" ?>
    <?php $fechaFin = "20-05-2022 13:59:00" ?>
    <?php $dif = DifFechas($fechaIni, $fechaFin) ?>
    <!-- Hace la diferencia entre fechaFin-fechaInicio -->
    <!-- Si da negativo es que la fecha de fin es menor que la de inicio -->
    <!-- nos puede dar todo , dias, meses, años, horas, minutos y segundos -->

    <h3>Diferencia de fechas (dias naturales)</h3>
    <p>Diferencia en días: <?php echo $dif->format('%R%a')  ?></p>
    <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p>
    <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p>
    <!-- $dif['h'] -- Diferencia en las horas -->
    <!-- $dif['i']  Diferencia en los minutos -->*/
    /*****************************************************/
    /*********** FIN DE EJEMPLO DE FUNCIONAMIENTO *******/
    /***************************************************/
};



// nos da la diferencia
//DifFechas('yyyy-mm-dd','yyyy-mm-dd'); => 5 dias
function DifFechasDia($fecInicio, $fecFinal)
{
    $totdiferencia = 0;
    if (!is_object($fecInicio)) {
        $fecInicio = new DateTime($fecInicio);
    }
    if (!is_object($fecFinal)) {
        $fecFinal = new DateTime($fecFinal);
    }


    //diferencia entre fechas en días
    $dif = $fecFinal->diff($fecInicio);


    $difDias = $dif->format('%R%a');
    return $difDias;
    // Para saber la diferencia y si está en tiempo
    /* <p>Han pasado: <?php echo $dif->format('%R%a') . ' dias'?> </p>*/
    /* <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p> */
    /* <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p> */
    // https://www.php.net/manual/en/dateinterval.format.php
    // $dif es un objeto.
    /* $dif['h'] -- Diferencia en las horas */
    /* $dif['i']  Diferencia en los minutos */






    /*********************************************/
    /*********** EJEMPLO DE FUNCIONAMIENTO *******/
    /*********************************************/
    /*<?php $fechaIni = "20-05-2022 14:00:00" ?>
    <?php $fechaFin = "20-05-2022 13:59:00" ?>
    <?php $dif = DifFechas($fechaIni, $fechaFin) ?>
    <!-- Hace la diferencia entre fechaFin-fechaInicio -->
    <!-- Si da negativo es que la fecha de fin es menor que la de inicio -->
    <!-- nos puede dar todo , dias, meses, años, horas, minutos y segundos -->

    <h3>Diferencia de fechas (dias naturales)</h3>
    <p>Diferencia en días: <?php echo $dif->format('%R%a')  ?></p>
    <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p>
    <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p>
    <!-- $dif['h'] -- Diferencia en las horas -->
    <!-- $dif['i']  Diferencia en los minutos -->*/
    /*****************************************************/
    /*********** FIN DE EJEMPLO DE FUNCIONAMIENTO *******/
    /***************************************************/
};


// nos da la diferencia
//DifFechas('yyyy-mm-dd','yyyy-mm-dd'); => 12 dias
function DifFechasDiaHoy($fecInicio)
{

    setlocale(LC_ALL, 'es_ES');
    date_default_timezone_set('Europe/Madrid');

    $totdiferencia = 0;
    if (!is_object($fecInicio)) {
        $fecInicio = new DateTime($fecInicio);
    }

    $fecFinal = new DateTime();

    //diferencia entre fechas en días
    $dif = $fecFinal->diff($fecInicio);


    $difDias = $dif->format('%R%a');

    //Creamos el JSON
    // $arr_clientes = array(
    //     'id' => $id, 'usu' => $usu, 'titulo' => $titulo,
    //     'categoria' => $categoria, 'fecha' => $fecha, 'correo' => $correo
    // );





    return $difDias;



    // Para saber la diferencia y si está en tiempo
    /* <p>Han pasado: <?php echo $dif->format('%R%a') . ' dias'?> </p>*/
    /* <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p> */
    /* <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p> */
    // https://www.php.net/manual/en/dateinterval.format.php
    // $dif es un objeto.
    /* $dif['h'] -- Diferencia en las horas */
    /* $dif['i']  Diferencia en los minutos */






    /*********************************************/
    /*********** EJEMPLO DE FUNCIONAMIENTO *******/
    /*********************************************/
    /*<?php $fechaIni = "20-05-2022 14:00:00" ?>
    <?php $fechaFin = "20-05-2022 13:59:00" ?>
    <?php $dif = DifFechas($fechaIni, $fechaFin) ?>
    <!-- Hace la diferencia entre fechaFin-fechaInicio -->
    <!-- Si da negativo es que la fecha de fin es menor que la de inicio -->
    <!-- nos puede dar todo , dias, meses, años, horas, minutos y segundos -->

    <h3>Diferencia de fechas (dias naturales)</h3>
    <p>Diferencia en días: <?php echo $dif->format('%R%a')  ?></p>
    <p>Diferencia en horas: <?php echo $dif->format('%R%H')  ?></p>
    <p>Diferencia en minutos: <?php echo $dif->format('%R%i')  ?></p>
    <!-- $dif['h'] -- Diferencia en las horas -->
    <!-- $dif['i']  Diferencia en los minutos -->*/
    /*****************************************************/
    /*********** FIN DE EJEMPLO DE FUNCIONAMIENTO *******/
    /***************************************************/
};





function FechaFinal($dias, $diaSig, $exclFin)
{

    //////////// calcular la fecha prevista de soporte /////////////
    // FechaFinal($fechaInicio, $dias, $diaSig, $exclFin){

    // Esta función le pasamos una fecha, los días a contar desde esa fecha hasta la fecha final, 
    //$diaSig -- 1 -- El computo de la fecha limite comienza el dia siguiente al de la recepción, si se coloca 1
    //                , el horario de recepcion no se tiene en cuenta. Para que se tenga en cuanto el horario, esto debe estar a 0
    //$diaSig -- 0 -- El computo de la fecha limite comienza el mismo día de la recepcion
    // Si establezco a 1 $diaSig tiene preferencia sobre la hora limite del dia


    //$exclFin -- 1 -- Para el computo de los días se excluyen los sabados y domingos (dias habiles)
    //$exclFin -- 0 -- Para el computo de los días NO se excluyen los sabados y domingos (dias naturales)
    // y nos devuelve la fecha EN ROJO en la que ya está vencida la tarea

    setlocale(LC_ALL, 'es_ES');
    date_default_timezone_set('Europe/Madrid');

    // esta zona es para produccion //////////////////////////////////////////////
    $fechaRojo = new DateTime();
    //////////////////////////////////////////////////////////////////////////////
    // para pruebas
    //$fechaRojo = "26-05-2022 10:00:00";
    //$fechaRojo = new DateTime($fechaRojo);

    global $diaSem;
    $fechaLimite = $fechaRojo->format('d-m-Y') . " " . "14:00:00";
    $fechaLimite = new DateTime($fechaLimite, new DateTimeZone('Europe/Madrid'));




    // calcula la diferencia entre horas para ver si se ha recibido antes de las 
    // $totaldiferencia = DifFechas($fechaRojo, $fechaLimite);
    // si es negativo debe de entrar en el mismo día, si es mayor que 0 debe pasar al día siguiente

    //
    //if ($diaSig == 1) {
    //    $fechaRojo = $fechaRojo->modify('+1 day');
    //    $fechaInicio = $fechaRojo->format('d-m-Y H:i:s');
    //} else {
    //    if ($totaldiferencia > 0) {
    //        $fechaRojo = $fechaRojo->modify('+1 day'); // al dia siguiente
    //        $fechaInicio = $fechaRojo->format('d-m-Y') . " " . "09:00:00";
    //    } else {
    //        $fechaInicio = $fechaRojo->format("d-m-Y H:i:s");
    //    }
    //}


    // todos los avisos se pasan al dia siguiente
    $fechaRojo = $fechaRojo->modify('+1 day'); // al dia siguiente
    $fechaInicio = $fechaRojo->format('d-m-Y') . " " . "09:00:00";


    // vamos a colocarlo al día siguiente a las 09:00 de la mañana
    $fechaInicio = new DateTime($fechaInicio, new DateTimeZone('Europe/Madrid'));


    //**************************************************************************/
    //*************************************************************************/
    //************ 1=Lunes  ... 5=Viernes, 6=Sabado,  7 =Domingo *************/
    //************ MOVEMOS EL ORIGEN POR SI CAE EN SABADO O DOMINGO *********/
    //**********************************************************************/
    //*********************************************************************/
    $diaSem = $fechaInicio->format('N'); // Esto es una relacion numerica del dia de la SEMANA (TABLA1)
    if ($exclFin == 1) {
        if ($diaSem == 6) {
            $fechaInicio = $fechaInicio->modify('+2 day'); // TABLA 2
        } else if ($diaSem == 7) {
            $fechaInicio = $fechaInicio->modify('+1 day'); // TABLA 2
        }
    }

    // aqui tengo la verdadera fecha de inicio del cálculo $fechaInicio
    // la necesito para los días festivos
    $fecCalInicio = $fechaInicio->format('Y-m-d');

    //Creamos el JSON



    //*********************************************************************/
    //*********************************************************************/
    // FIN DE MOVER EL ORIGEN DEL SÁBADO O DOMINGO AL LUNES SIGUIENTE ****/
    //*******************************************************************/
    //******************************************************************/
    // VAMOS A MONTAR UN  NUEVO OBJETO DE FECHAFINAL
    $fechaFinal = $fechaInicio->format('d-m-Y H:i:s');
    $fechaFinal = new DateTime($fechaFinal, new DateTimeZone('Europe/Madrid'));

    $cadena = "+" . $dias . " day ";
    $fechaFinal = $fechaFinal->modify($cadena);

    $cadena = "";
    $diasSum = 0;  // Son los días a sumar si entre fechas cae un sabado o domingo.

    if ($exclFin == 1) {  // si se excluyen los fines de semana
        for ($i = 1; $i <= $dias; $i++) {
            // sumo un dia a la semana
            $cadena = "+1 day";
            $fechaInicio = $fechaInicio->modify($cadena);

            $diaSemP = $fechaInicio->format('N');
            if ($diaSemP == 6) {
                if ($i = $dias) {
                    $diasSum += 2; // es el último día y hay que pasarlo al lunes
                } else {
                    $diasSum += 1; // es un dia por enmedio
                }
            } else if ($diaSemP == 7) {
                $diasSum += 1; // es domingo
            }
        } // del for
    }
    // para producción
    $cadenaF = "+" . $diasSum . " day";
    $fechaFinal = $fechaFinal->modify($cadenaF);

    // validar un datetime y devuelve true o false
    // var_dump(validarFecha('2018-02-28 12:12:12'));
    function validarFecha($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

/* TABLA 1*/
/* Los siguientes caracteres están reconocidos en el parámetro de cadena format
Carácter de format Descripción Ejemplo de valores devueltos

Día --- ---

d Día del mes, 2 dígitos con ceros iniciales 01 a 31
D Una representación textual de un día, tres letras Mon hasta Sun
j Día del mes sin ceros iniciales 1 a 31
l ('L' minúscula) Una representación textual completa del día de la semana Sunday hasta Saturday
N Representación numérica ISO-8601 del día de la semana (añadido en PHP 5.1.0) 1 (para lunes) hasta 7 (para domingo)
S Sufijo ordinal inglés para el día del mes, 2 caracteres st, nd, rd o th. Funciona bien con j
w Representación numérica del día de la semana 0 (para domingo) hasta 6 (para sábado)
z El día del año (comenzando por 0) 0 hasta 365

Semana --- ---

W Número de la semana del año ISO-8601, las semanas comienzan en lunes Ejemplo: 42 (la 42ª semana del año)

Mes --- ---

F Una representación textual completa de un mes, como January o March January hasta December
m Representación numérica de un mes, con ceros iniciales 01 hasta 12
M Una representación textual corta de un mes, tres letras Jan hasta Dec
n Representación numérica de un mes, sin ceros iniciales 1 hasta 12
t Número de días del mes dado 28 hasta 31

Año --- ---

L Si es un año bisiesto 1 si es bisiesto, 0 si no.
o Año según el número de la semana ISO-8601. Esto tiene el mismo valor que Y, excepto que si el número de la semana ISO (W) pertenece al año anterior o siguiente, se usa ese año en su lugar. (añadido en PHP 5.1.0) Ejemplos: 1999 o 2003
Y Una representación numérica completa de un año, 4 dígitos Ejemplos: 1999 o 2003
y Una representación de dos dígitos de un año Ejemplos: 99 o 03

Hora --- ---

a Ante meridiem y Post meridiem en minúsculas am o pm
A Ante meridiem y Post meridiem en mayúsculas AM o PM
B Hora Internet 000 hasta 999
g Formato de 12 horas de una hora sin ceros iniciales 1 hasta 12
G Formato de 24 horas de una hora sin ceros iniciales 0 hasta 23
h Formato de 12 horas de una hora con ceros iniciales 01 hasta 12
H Formato de 24 horas de una hora con ceros iniciales 00 hasta 23
i Minutos con ceros iniciales 00 hasta 59
s Segundos con ceros iniciales 00 hasta 59
u Microsegundos (añadido en PHP 5.2.2). Observe que date() siempre generará 000000 ya que toma un parámetro de tipo integer, mientras que DateTime::format() admite microsegundos si DateTime fue creado con microsegundos. Ejemplo: 654321
v Milisegundos (añadido en PHP 7.0.0). La misma observación se aplica para u. Example: 654

Zona Horaria --- ---

e Identificador de zona horaria (añadido en PHP 5.1.0) Ejemplos: UTC, GMT, Atlantic/Azores
I (i mayúscula) Si la fecha está en horario de verano o no 1 si está en horario de verano, 0 si no.
O Diferencia de la hora de Greenwich (GMT) sin colon entre horas y minutos Ejemplo: +0200
P Diferencia con la hora de Greenwich (GMT) con dos puntos entre horas y minutos (añadido en PHP 5.1.3) Ejemplo: +02:00
T Abreviatura de la zona horaria Ejemplos: EST, MDT ...
Z Índice de la zona horaria en segundos. El índice para zonas horarias al oeste de UTC siempre es negativo, y para aquellas al este de UTC es siempre positivo. -43200 hasta 50400

Fecha/Hora Completa --- ---

c Fecha ISO 8601 (añadido en PHP 5) 2004-02-12T15:19:21+00:00
r Fecha con formato » RFC 2822 Ejemplo: Thu, 21 Dec 2000 16:01:07 +0200
U Segundos desde la Época Unix (1 de Enero del 1970 00:00:00 GMT) Vea también time() */



/*   TABLA 2 */
/* https://www.php.net/manual/es/datetime.formats.relative.php
Símbolos empleados
nombre del día 'sunday' | 'monday' | 'tuesday' | 'wednesday' | 'thursday' | 'friday' | 'saturday' | 'sun' | 'mon' | 'tue' | 'wed' | 'thu' | 'fri' | 'sat'

texto de día 'weekday' | 'weekdays'

número [+-]?[0-9]+

ordinal 'first' | 'second' | 'third' | 'fourth' | 'fifth' | 'sixth' | 'seventh' | 'eighth' | 'ninth' | 'tenth' | 'eleventh' | 'twelfth' | 'next' | 'last' | 'previous' | 'this'

texto relativo 'next' | 'last' | 'previous' | 'this'

espacio [ \t]+

unidad (('sec' | 'second' | 'min' | 'minute' | 'hour' | 'day' | 'fortnight' | 'forthnight' | 'month' | 'year') 's'?) | 'weeks' | texto de día


Notaciones basadas en el día

'yesterday' Medianoche de ayer "yesterday 14:00"
'midnight' La hora es establecida a 00:00:00
'today' La hora es establecida a 00:00:00
'now' Ahora - esto es simplemente ignorado
'noon' La hora es establecida a 12:00:00 "yesterday noon"
'tomorrow' Medianoche de mañana
'back of' hora 15 minutos después de la hora especificada "back of 7pm", "back of 15"
'front of' hora 15 minutos antes de la hora especificada "front of 5am", "front of 23"
'first day of' Esteblece el día al primer día del mes en curso. Esta frase se utiliza mejor seguida de un nombre de mes. "first day of January 2008"
'last day of' Esteblece el día al último día del mes en curso. Esta frase se utiliza mejor seguida de un nombre de mes. "last day of next month"
ordinal espacio nombre del día espacio 'of' Calcula el x-ésimo día de la semana del mes en curso. "first sat of July 2008"
'last' espacio nombre del día espacio 'of' Calcula el último día de la semana del mes en curso. "last sat of July 2008"
número espacio? (unidad | 'week') Trata elementos de hora relativos donde el valor es un número. "+5 weeks", "12 day", "-7 weekdays"
ordinal espacio unidad Trata elementos de hora relativos donde el valor es texto. "fifth day", "second month"
'ago' Anula todos los valores de los elementos de hora relativos encontrados anteriormente. "2 days ago", "8 days ago 14:00", "2 months 5 days ago", "2 months ago 5 days", "2 days ago"
nombre del día Avanza al siguiente día con este nombre. "Monday"
texto relativo espacio 'week' Trata el formato especial "weekday + last/this/next week". "Monday next week" */





/* FECHA CLASE */

// la fecha debe entrar en formato texto 'dd-mm-YYYY'
class FechaFormato extends DateTime
{
    protected
        $mes = [
            1 => 'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];

    public $fechaClass;

    public function __construct($fechaClass)
    {
        $this->fechaClass = new DateTime($fechaClass, new DateTimeZone('Europe/Madrid'));
    }

    // numerico del año
    public function mostrarAno()
    {
        $ano = $this->fechaClass->format('Y');
        return $ano;
    }

    // numerico del mes 1...12
    public function mostrarMes()
    {
        $mes = $this->fechaClass->format('m');
        return $mes;
    }

    // númerico del día del mes 1...31
    public function mostrarDia()
    {
        $dia = $this->fechaClass->format('d');
        return $dia;
    }

    // Llega dd-mm-YY y devuelve YY-mm-dd en formato literal
    public function fechaRemota()
    {
        $fecha = $this->fechaClass->format('Y') . "/" . $this->fechaClass->format('m') . "/" . $this->fechaClass->format('d');
        return $fecha;
    }

    // Devuelve un objeto DateTime en formato remoto,  por lo que se puede utilizar $fecha->format('Y-m-d'), etc...
    public function fechaRemotaObjeto()
    {
        $fecha = $this->fechaClass->format('Y') . "-" . $this->fechaClass->format('m') . "-" . $this->fechaClass->format('d');
        return new DateTime($fecha, new DateTimeZone('Europe/Madrid'));
    }

    // Devuelve un objeto DateTime en formato remoto,  por lo que se puede utilizar $fecha->format('Y-m-d HH:i:s'), con hora minutos y segundos
    public function fechaHoraRemotaObjeto()
    {
        $fecha = $this->fechaClass->format('Y') . "-" . $this->fechaClass->format('m') . "-" . $this->fechaClass->format('d') . " " .
            $this->fechaClass->format('H') . ":" . $this->fechaClass->format('i') . ":" . $this->fechaClass->format('s');

        return new DateTime($fecha, new DateTimeZone('Europe/Madrid'));
    }

    // Devuelve un string con formato (d-m-Y)
    public function fechaLocal()
    {
        $fecha = $this->fechaClass->format('d') . "-" . $this->fechaClass->format('m') . "-" . $this->fechaClass->format('Y');
        return $fecha;
    }


    // Devuelve un objeto DateTime en formato (d-m-Y),  por lo que se puede utilizar $fecha->format('d-m-Y'), etc...
    public function fechaLocalObjeto()
    {
        $fecha = $this->fechaClass->format('d') . "-" . $this->fechaClass->format('m') . "-" . $this->fechaClass->format('Y');
        return new DateTime($fecha, new DateTimeZone('Europe/Madrid'));
    }

    // Devuelve un formato string :  Martes, 22 de Noviembre de 2022
    public function fechaLocalLiteral()
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $diaSemanaLiteral = $dias[$this->fechaClass->format('w')];
        $mes = [
            1 => 'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];
        $mesLiteral = $mes[$this->fechaClass->format('m')];
        $fechafinal = $diaSemanaLiteral . ', ' . $this->fechaClass->format('d') . ' de ' . $mesLiteral . ' de ' . $this->fechaClass->format('Y');
        return $fechafinal;
    }

    // devuelve un string HH:mm:SS
    public function horaLocal()
    {
        $fecha = $this->fechaClass->format('H') . ":" . $this->fechaClass->format('i') . ":" . $this->fechaClass->format('s');
        return $fecha;
    }

    // devuelve un string en formato HH:mm
    public function horaLocalSinSegundos()
    {
        $fecha = $this->fechaClass->format('H') . ":" . $this->fechaClass->format('i');
        return $fecha;
    }

    // devuelve la zona horaria por defecto será siempre Europe/Madrid
    public function zonaHoraria()
    {
        $zona = $this->fechaClass->format('e');
        return $zona;
    }
}


//************************************/
// CLASE PARA LA DIFERENCIA DE FECHAS *
//************************************/
/*********************************************************/
/*** LAS FECHA DEBEN IR EN FORMATO YYYY-MM-DD H:MM:SS ***/
/*******************************************************/
class difFechas extends DateTime
{

    protected $dias, $horas, $minutos;

    public $fechaIni, $fechaFin, $precision;

    // Se pasa fecha de inicio, fecha de Fin y precisión en los calculos de los redondeos.
    public function __construct($fechaIni, $fechaFin, int $precision = 3)
    {

        if (is_object($fechaIni)) {
            $this->fechaIni = $fechaIni;
        } else {
            $this->fechaIni = new DateTime($fechaIni, new DateTimeZone('Europe/Madrid'));
        }
        // De lo anterior sale un objeto en formato YYYY-mm-dd H:m:s

        if (is_object($fechaFin)) {
            $this->fechaFin = $fechaFin;
        } else {
            $this->fechaFin = new DateTime($fechaFin, new DateTimeZone('Europe/Madrid'));
        }
        // De lo anterior sale un objeto en formato YYYY-mm-dd H:m:s
        // $this->fecIni, $this->fecFin

        $this->precision = $precision;
    }

    public function diferencia()
    {
        $dif = $this->fechaIni->diff($this->fechaFin);
        return $dif;
    }


    // recibe las fechas de inicio y final y devuelve la cuenta en días, DESPRECIA LAS HORAS Y LOS MINUTOS, SOLO DA EL RESULTADO DE LA DIFERNCIA EN DIAS
    public function difDias()
    {
        $difD = self::diferencia()->format('%R%a');
        return $difD;
    }

    // recibe las fechas de inicio y final y devuelve la cuenta en horas, 
    //TIENE EN CUENTA LOS DIAS, HORAS MINUTOS
    // devuelve 25.666 y esto son HORAS
    public function difHoras()
    {
        $dias = self::difDias();
        $horas = self::diferencia()->format('%R%H');
        $minutos = self::diferencia()->format('%R%i');

        $total = round(($dias * 24) + $horas + ($minutos / 60), $this->precision);
        return $total;
    }


    // recibe las fechas de inicio y final y devuelve la cuenta en minutos, Tiene en cuenta los días, horas y minutos.
    public function difMinutos()
    {

        $dias = self::difDias();
        $horas = self::diferencia()->format('%R%H');
        $minutos = self::diferencia()->format('%R%i');

        $total = round(($dias * 24 * 60) + ($horas * 60) + ($minutos), $this->precision);
        return $total;
    }


    public function mostrar()
    {
        echo "La fecha de INICIO es:" . $this->fechaIni->format('Y-m-d H:i:s') . '<br>';
        echo "La fecha de FIN es:" . $this->fechaFin->format('Y-m-d H:i:s') . '<br>';
        echo "la diferencia en días es:" . $this->difDias() . '<br>';
        echo 'La diferencia en horas es:' . $this->difHoras() . '<br>';
        echo 'La diferencia en minutos es:' . $this->difMinutos() . '<br>';
    }
}

/* $fechaActual = new FechaFormato('21-11-2022 18:20:21');
echo "El Año actual es:" . $fechaActual->mostrarAno() . '<br>';
echo "El Mes actual es:" . $fechaActual->mostrarMes() . '<br>';
echo "El día actual es:" . $fechaActual->mostrarDia() . '<br>';
echo "La fecha remota es:" . $fechaActual->fechaRemota() . '<br>';  //Devuelve un string
echo "La fecha local es:" . $fechaActual->fechaLocal() . '<br>';  //Devuelve un string
echo "La fecha local literal es: " . $fechaActual->fechaLocalLiteral() . '<br>';  //Devuelve un string
echo "La hora local literal es: " . $fechaActual->horaLocal() . '<br>';  //
echo "La hora local literal (sin segundos) es: " . $fechaActual->horaLocalsinSegundos() . '<br>';  //
echo "La zona horaria es: " . $fechaActual->zonaHoraria() . '<br>';  //

echo "<hr>";
echo "<hr>";



$fechaActualconZona = new FechaFormato('22-11-2022 18:20:21 Europe/Madrid');
echo "El Año actual es:" . $fechaActualconZona->mostrarAno() . '<br>';
echo "El Mes actual es:" . $fechaActualconZona->mostrarMes() . '<br>';
echo "El día actual es:" . $fechaActualconZona->mostrarDia() . '<br>';
echo "La fecha remota es:" . $fechaActualconZona->fechaRemota() . '<br>';  //Devuelve un string
echo "La fecha local es:" . $fechaActualconZona->fechaLocal() . '<br>';  //Devuelve un string
echo "La fecha local literal es: " . $fechaActualconZona->fechaLocalLiteral() . '<br>';  //Devuelve un string
echo "La hora local literal es: " . $fechaActualconZona->horaLocal() . '<br>';  //
echo "La hora local literal (sin segundos) es: " . $fechaActualconZona->horaLocalsinSegundos() . '<br>';  //
echo "La zona horaria es: " . $fechaActualconZona->zonaHoraria() . '<br>';  //


echo "<hr>";
echo "<hr>";

echo '** Vamos a clonar un objeto DATETIME **' . '<br>';
echo '** Hay que tener en cuanta que un objeto se clona por REFERENCIA, es decir si se cambia uno se cambia el otro **' . '<br>';

$fecha1 = new FechaFormato('22-11-2022');
$fecha2 = $fecha1->fechaRemotaObjeto()->modify('+2 weeks');

echo "La fecha 1 es: " . $fecha1->fechaLocal() . '<br>';
echo "La fecha 2 es: " . $fecha2->format('Y-m-d');

echo "<hr>";
echo "<hr>";


echo '** Vamos a ver la ARITMETICA de las fechas *****' . '<br>';
$fechaInicio = new FechaFormato('22-11-2022 12:00:00');
$fechaInicio = $fechaInicio->fechaHoraRemotaObjeto();


$fechaFinal = new FechaFormato('24-12-2022 16:00:00');
$fechaFinal = $fechaFinal->fechaHoraRemotaObjeto();


$dif = $fechaInicio->diff($fechaFinal);
// resta fecha2-fecha1
echo 'La fecha 1 es: ' . $fechaInicio->format('Y-m-d H:i:s') . '<br>';
echo 'La fecha 2 es: ' . $fechaFinal->format('Y-m-d H:i:s') . '<br>';



echo 'La diferencia de días es: ' . $dif->format('%R%a días') . '<br>';
// La diferencia de días es: +32 días
echo 'La diferencia en horas es: ' . $dif->format('%R%H horas') . '<br>';
// La diferencia en horas es: +04 horas
echo 'La diferencia en minutos es: ' . $dif->format('%R%i minutos') . '<br>';

// (($diff->days * 24) * 60) + ($diff->i) . ' minutes';
echo "<hr>";
echo "<hr>";


echo "*************** DESDE LA CLASE DE DIFERENCIA *********** <br>";
$fecDiferencia = new difFechas('2022-12-22 11:00:00', '2022-12-23 12:40:00');
echo $fecDiferencia->mostrar();




 */

/* Es una funcion para generar tablas en HTML del TIPO DATATABLES */
//generarTabla("nombr",["campos"],["campos"],1,1,#000000,0) => tabla
function generarTabla($nomTabla, $nomCampos, $nomCamposFooter, $cantidadGrupos, $rowsGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker)
{
    $html = "<table id='{$nomTabla}' class='table table-striped table-bordered dtAuto'>";
    $html .= '              <thead>';
    $html .= '                  <tr>';

    foreach ($nomCampos as $campo) {
        $html .= "<th class='tx-15'> {$campo} </th>";
    }

    $html .= '                   </tr>';
    $html .= '               </thead>';
    $html .= '               <tbody></tbody>';

    $html .= '               <tfoot>';
    $html .= '                   <tr>';

    foreach ($nomCamposFooter as $campoFoot) {
        $html .= "<th class='tx-15'> {$campoFoot} </th>";
    }

    $html .= '                   </tr>';
    $html .= '               </tfoot>';
    $html .= '</table>';
    switch ($cantidadGrupos) {
        case "1":
            $html .= "<input type='hidden' class='inputCantidad g1' id='g1' value='{$rowsGrupos[0]}'>";
        break;
        case "2":
            $html .= "<input type='hidden' class='inputCantidad g1' id='g1' value='{$rowsGrupos[0]}'>";
            $html .= "<input type='hidden' class='inputCantidad g2' id='g2' value='{$rowsGrupos[1]}'>";

        break;
        case "3":
            $html .= "<input type='hidden' class='inputCantidad g1' id='g1' value='{$rowsGrupos[0]}'>";
            $html .= "<input type='hidden' class='inputCantidad g2' id='g2' value='{$rowsGrupos[1]}'>";
            $html .= "<input type='hidden' class='inputCantidad g3' id='g3' value='{$rowsGrupos[2]}'>";
        break;
    }
    if (!empty($colorHEX)) {
        $html .= "<input type='hidden' class='colorAuto' id='colorAuto' value='{$colorHEX}'>";
    } else {
        $html .= "<input type='hidden' class='colorAuto' id='colorAuto' value='#3AB54A'>";
    }
    $html .= "<input type='hidden' class='idTabla' id='idTabla' value='{$nomTabla}'>";
    $html .= "<input type='hidden' class='desplegado' id='desplegado' value='{$desplegado}'>";
    $html .= "<input type='hidden' class='colorPickerView' id='colorPickerView' value='{$colorPicker}'>";
    $html .= "<input type='hidden' class='agrupacionesPersonalizadas' id='agrupacionesPersonalizadas' value='{$agrupacionesPersonalizadas}'>";
    $html .= "<input type='hidden' class='cantidadGrupos' id='cantidadGrupos' value='{$cantidadGrupos}'>";

    return $html;
}

//Obtiene la IP del cliente
function get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];

    // Lista de cabeceras que pueden contener la IP del cliente
    $cabeceras = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_X_REAL_IP'
    ];

    foreach ($cabeceras as $cabecera) {
        if (isset($_SERVER[$cabecera])) {
            $ips = explode(',', $_SERVER[$cabecera]);
            foreach ($ips as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return $ip;
                }
            }
        }
    }

    // Si se detecta una IP IPv6 loopback, cambiar a IPv4 loopback
    if ($ip === '::1') {
        return '127.0.0.1';
    }

    // Verificar si la IP es IPv4
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return $ip;
    }

    return 'IP no válida'; // O manejarlo de otra forma si no se encuentra una IPv4
}

function generarLog($nombreArchivo, $accionRealizada)
{
    // Usar ruta absoluta desde la raíz del proyecto
    $logPath = dirname(__DIR__) . "/models/Log.php";
    require_once($logPath);
    
    // Obtener la IP del usuario
    $ipUsuario = get_client_ip();
    // Archivo LOG
    $nombreLog =  "ID: ".$_SESSION['usu_id'] . " - Nombre: " . $_SESSION['usu_nom'] . " - IP: " . $ipUsuario;
    $logI = new Log($nombreLog, $nombreArchivo, $accionRealizada);
    $logI->grabarLinea();
    unset($logI);
    // FIN del archivo LOG
}

/**
 * @param $numeros 0=NO 1=SI <-- espera estos valores
 * @param $letras 0=NO 1=SI <-- espera estos valores
 * @param $cantidad cantidad de caracteres del codigo
 */

/* function codigoDeSeguimiento($numeros,$letras,$cantidad){ //TODO PONER TIME STAMP

    if($numeros == 0 && $letras == 0){
        $letras = 1; //SI POR ERROR NUMEROS Y LETRAS ES 0 CAMBIAR LETRAS A 1
    }
    $caracteresNumericos = '0123456789'; //NUMEROS PERMITIDOS
    $caracteresAlfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //CARACTERES PERMITIDOS

    $caracteresPermitidos = ''; //LOS CARACTERES PERMITIDOS EN TOTAL

    if ($numeros) {
        $caracteresPermitidos .= $caracteresNumericos; //AGREGAR LOS NUMEROS SI $NUMEROS = 1
    }

    if ($letras) {
        $caracteresPermitidos .= $caracteresAlfabeticos; //AGREGAR LAS LETRAS SI $letras = 1
    }

    $codigoGenerado = ''; //CODIGO GENERADO

    $longitudCaracteresPermitidos = strlen($caracteresPermitidos); //RECOGE LA LONGITUD DE TODOS LOS CARACTERES PERMITIDOS

    for ($i = 0; $i < $cantidad; $i++) {
        $codigoGenerado .= $caracteresPermitidos[rand(0, $longitudCaracteresPermitidos - 1)]; //GENERA EL CODIGO ALEATORIO DE $cantidad CARACTERES
    }
    $fecha = time();
    $abecedario = "abcdefghijklmnopqrstuvwxyz";
    $grupos = str_split(str_pad($fecha, ceil(strlen($fecha) / 2) * 2, "0", STR_PAD_LEFT), 2);

    $resultado = "";
    foreach ($grupos as $grupo) {
        $numero = 1;
        $grupoNumero = intval($grupo);
        while($grupoNumero > strlen ($abecedario)){
            $numero += 1;
            $grupoNumero -= strlen ($abecedario);
        }
        $letra = $abecedario[$grupoNumero - 1];
        $resultado .= $numero.$letra;
    }
    return $resultado;

} */
function codigoDeSeguimientoPass($numeros,$letras,$cantidad){ //TODO PONER TIME STAMP

    if($numeros == 0 && $letras == 0){
        $letras = 1; //SI POR ERROR NUMEROS Y LETRAS ES 0 CAMBIAR LETRAS A 1
    }
    $caracteresNumericos = '0123456789'; //NUMEROS PERMITIDOS
    $caracteresAlfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; //CARACTERES PERMITIDOS

    $caracteresPermitidos = ''; //LOS CARACTERES PERMITIDOS EN TOTAL

    if ($numeros) {
        $caracteresPermitidos .= $caracteresNumericos; //AGREGAR LOS NUMEROS SI $NUMEROS = 1
    }

    if ($letras) {
        $caracteresPermitidos .= $caracteresAlfabeticos; //AGREGAR LAS LETRAS SI $letras = 1
    }

    $codigoGenerado = ''; //CODIGO GENERADO

    $longitudCaracteresPermitidos = strlen($caracteresPermitidos); //RECOGE LA LONGITUD DE TODOS LOS CARACTERES PERMITIDOS

    for ($i = 0; $i < $cantidad; $i++) {
        $codigoGenerado .= $caracteresPermitidos[rand(0, $longitudCaracteresPermitidos - 1)]; //GENERA EL CODIGO ALEATORIO DE $cantidad CARACTERES
    }
    $fecha = time();
    $abecedario = "abcdefghijklmnopqrstuvwxyz";
    $grupos = str_split(str_pad($fecha, ceil(strlen($fecha) / 2) * 2, "0", STR_PAD_LEFT), 2);

    $resultado = "";
    foreach ($grupos as $grupo) {
        $numero = 1;
        $grupoNumero = intval($grupo);
        while($grupoNumero > strlen ($abecedario)){
            $numero += 1;
            $grupoNumero -= strlen ($abecedario);
        }
        $letra = $abecedario[$grupoNumero - 1];
        $resultado .= $numero.$letra;
    }
    return $resultado;

}
function codigoDeSeguimiento()
{ //la peticion se llama codigoDeSeguimiento() => 1E4R4T2L2G3E y te devuelve un codigo unico


    $fecha = time(); //recoge la fecha en timestamp
    $numero_aleatorio1 = rand(10000, 99999); //numero aleatorio entre 10000 y 99999 - A mayor numero mayor mas variedad en los codigos
    $numero_aleatorio2 = rand(10000, 99999); //numero aleatorio entre 10000 y 99999
    $fecha = ($fecha * $numero_aleatorio1) ^ $numero_aleatorio2; //fecha multiplicada por el numero aleatorio entre 10 y 99 y cifrada con un numero entre el 1000 y el 99999
    $abecedario = "abcdefghijklmnopqrstuvwxyz"; //el abecedario
    $grupos = str_split(str_pad($fecha, ceil(strlen($fecha) / 2) * 2, "0", STR_PAD_LEFT), 2); //Separar la fecha en grupos de dos, si son impares, añadir un 0 a la izqueirda

    $resultado = "";
    foreach ($grupos as $grupo) { //Por cada grupo
        $numero = 1; //Poner el numero inicial en 1
        $grupoNumero = intval($grupo); //Pasar el grupo a numero
        while ($grupoNumero > strlen($abecedario)) { //Mientras el numero del grupo es mayor que la longitud del abecedario
            $numero += 1; //Sumar al numero inicial 1
            $grupoNumero -= strlen($abecedario); //Restar al numero del grupo la longitud del abecedario
        }
        $letra = $abecedario[$grupoNumero - 1]; //Recoger el numero del grupo restarle 1 y recoger la letra correspondiente del abecedario
        $resultado .= $numero . $letra; //Recoger el numero y la letra 1A...3H...4P...
    }
    return $resultado; //Devolver el resultado

}

/* function transformarFecha2($fecha, $formato)   !! EN DESAROLLO
{ //Ha esta funcion le tienes que pasar una fecha Y en que formato quieres que te la devuelva, el formato se lo indicas como un Array


    // Convierte la fecha a un objeto DateTime
    $fechaObjeto = new DateTime($fecha);

    // Mapea los caracteres del formato compacto a los caracteres completos
    $mapeoFormato = [
        'Y' => 'Y',
        'y' => 'y',
        'z' => 'z',
        'm' => 'm',
        'M' => 'M',
        'F' => 'F',
        'd' => 'd',
        'j' => 'j',
        'D' => 'D',
        'l' => 'l',
        'W' => 'W',
        'H' => 'H',
        'h' => 'h',
        'G' => 'G',
        'g' => 'g',
        'i' => 'i',
        's' => 's',
        'u' => 'u',
        'a' => 'a',
        'A' => 'A',
        'e' => 'e',
        'O' => 'O',
        'P' => 'P',
        'c' => 'c',
        'I' => 'I',
    ];

    // Inicializa la cadena de fecha formateada
    $fechaFormateada = '';

    // Recorre el formato compacto y agrega la parte formateada correspondiente
    foreach ($formato as $key => $opcion) {
        $opcionCompleta = $mapeoFormato[$opcion];
        echo "$opcionCompleta <br>";
        if ($dosAnterioresValidas) {

            $fechaFormateada .= " ";
        }
        if ($opcionCompleta == "Y" || $opcionCompleta == "y" || $opcionCompleta == "m" || $opcionCompleta == "d" || $opcionCompleta == "j") {

            // Verifica si la posición es la primera
            $esPrimeraPosicion = ($key === 0);
            // Verifica si las dos anteriores posiciones han sido "Y", "y", "m", "d" o "j"
            $dosAnterioresValidas = false;
            if (!$esPrimeraPosicion && isset($formato[$key - 1]) && isset($formato[$key - 2])) {
                $anterior1 = $mapeoFormato[$formato[$key - 1]];
                $anterior2 = $mapeoFormato[$formato[$key - 2]];

                $dosAnterioresValidas = ($anterior1 == "Y" || $anterior1 == "y" || $anterior1 == "m" || $anterior1 == "d" || $anterior1 == "j") &&
                    ($anterior2 == "Y" || $anterior2 == "y" || $anterior2 == "m" || $anterior2 == "d" || $anterior2 == "j");
            }

            // Verifica si la siguiente opción también es "d", "m" o "Y"
            $siguienteOpcion = isset($formato[$key + 1]) ? $mapeoFormato[$formato[$key + 1]] : null;

            if (($siguienteOpcion == "Y" || $siguienteOpcion == "y" || $siguienteOpcion == "m" || $siguienteOpcion == "d" || $siguienteOpcion == "j" || $dosAnterioresValidas) && !$esPrimeraPosicion) {

                // Agregar -
                $fechaFormateada .= "-";
            }
        }

        $fechaFormateada .= $fechaObjeto->format($opcionCompleta);
    }

    return $fechaFormateada;
} */



// Funcion que recibe todo tipo de fecha y te devuelve la fecha en el formato indicado
// transformarFecha('2024-01-27 14:30:45',  ['l', ' de ', 'F', ' del ', 'Y',' ', 'H',':','i',':', 's'])  => Resultado: Sábado de Enero del 2024 14:30:45
function transformarFecha($fecha, $formato)
{
    /**
     * Formatos aceptados:
     * ---DIA---
     * d -> nº dia con 0 al inicio del numero => 01, 02..
     * D -> nombre del dia abreviado => Mon,Tue
     * j -> nº dia sin 0 al inicio del numero => 1,2...
     * l -> nombre del dia completo => Monday, Tuesday
     * N -> Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
     * S -> Sufijo ordinal inglés para el día del mes, 2 caracteres st, nd, rd o th. Funciona bien con j
     * w -> Representación numérica del día de la semana 0 (para domingo) hasta 6 (para sábado)
     * z -> Dia del año => 0-365
     * ---------
     * ---SEM---
     * W -> numero de la semana del año => 0-52
     * ---------
     * ---MES---
     * F -> nombre més completo => January, February
     * m -> nº mes => 1-12
     * M -> nombre més abreviado => Jan,Feb
     * n -> Representación numérica de un mes, sin ceros iniciales 1 hasta 12
     * t -> Número de días del mes dado 28 hasta 31
     * ---------
     * ---AÑO---
     * Y -> Año con 4 digitos => 2024
     * y -> Año con 2 digitos => 24
     * L -> Si es un año bisiesto 1 si es bisiesto, 0 si no.
     * o -> Año según el número de la semana ISO-8601. Esto tiene el mismo valor que Y, excepto que si el número de la semana ISO (W) pertenece al año anterior o siguiente, se usa ese año en su lugar. (añadido en PHP 5.1.0) Ejemplos: 1999 o 2003
     * ---------
     * ---HORA--
     * H -> Hora formato 24hr => 12,13,14,15....
     * h -> Hora formato 12hr => 12,01,02,03....
     * a -> AM o PM en minusculas => 11am - 11pm
     * A -> AM o PM en mayusculas => 11AM - 11PM
     * B -> Hora Internet 000 hasta 999
     * G -> Hora formato de 24 horas sin 0 al inicio del numero => 23,24,1,2....
     * g -> Hora formato de 12 horas sin 0 al inicio del numero => 12,1,2,3....
     * i -> Minuto => 0-59
     * s -> Segundo => 0-59
     * u -> Microsegundos => 0-999999
     * v -> Milisegundos => 0-999
     * ---------
     * ---ZONA--
     * e -> Identificador de la zona horaria => UTC
     * I -> Te devuelve 1 si estamos en horario de verano y 0 si no
     * O -> Diferencia de tiempo con respecto a GMT/UTC => +0200
     * P -> Similar a `O` pero con dos puntos entre horas y minutos => +02:00
     * T -> Abreviatura de la zona horaria Ejemplos: EST, MDT ...
     * Z -> Índice de la zona horaria en segundos. El índice para zonas horarias al oeste de UTC siempre es negativo, y para aquellas al este de UTC es siempre positivo. -43200 hasta 50400
     * ---------
     * -COMPLEJA-
     * c -> Fecha formato ISO 8601 => 2024-01-23T14:30:45+00:00
     * r -> Fecha con formato » RFC 2822 Ejemplo: Thu, 21 Dec 2000 16:01:07 +0200
     * U -> Segundos desde la Época Unix (1 de Enero del 1970 00:00:00 GMT)
     * ----------
     */
    // Convierte la fecha a un objeto DateTime
    
    date_default_timezone_set('Europe/Madrid');
    if(empty($fecha)){
        $fechaObjeto = new DateTime();
    } else {
        $fechaObjeto = new DateTime($fecha);
    }

    $diasNombre = [  //Aray para traducir los nombres de la semana
        'Mon' => 'Lu',
        'Tue' => 'Ma',
        'Wed' => 'Mi',
        'Thu' => 'Ju',
        'Fri' => 'Vi',
        'Sat' => 'Sá',
        'Sun' => 'Do',
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo',
    ];
    $mesesNombre = [ //Array para traducir los nombres de los meses
        'Jan' => 'Ene',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'Apr' => 'Abr',
        'May' => 'May',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Ago',
        'Sep' => 'Sep',
        'Oct' => 'Oct',
        'Nov' => 'Nov',
        'Dec' => 'Dic',
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre',
    ];

    // Inicializa la cadena de fecha formateada
    $fechaFormateada = '';

    // Recorre el formato proporcionado y agrega la parte formateada correspondiente
    foreach ($formato as $opcion) {
        if (strlen($opcion) > 1) { //Si tiene mas de 1 caracter no se formatea solo se muestra, por ejemplo 'del' 'de'....

            $fechaFormateada .= $opcion;
        } else {
            if($opcion == "D" || $opcion == "l"){ //Si la opcion de formato es D o l traducir nombre del dia de la semana
                $diaIngles = $fechaObjeto->format($opcion);
                $fechaFormateada .= $diasNombre[$diaIngles];
            } else if($opcion == "M" || $opcion == "F"){ //Si la opcion de formato es M o F traducir nombre del mes
                $mesIngles = $fechaObjeto->format($opcion);
                $fechaFormateada .= $mesesNombre[$mesIngles];
            }else{
                $fechaFormateada .= $fechaObjeto->format($opcion);
            }
        }
    }
   

    return $fechaFormateada;
}
function transformarFechaVacia($fecha, $formato)
{
    /**
     * Formatos aceptados:
     * ---DIA---
     * d -> nº dia con 0 al inicio del numero => 01, 02..
     * D -> nombre del dia abreviado => Mon,Tue
     * j -> nº dia sin 0 al inicio del numero => 1,2...
     * l -> nombre del dia completo => Monday, Tuesday
     * N -> Representación numérica ISO-8601 del día de la semana 1 (para lunes) hasta 7 (para domingo)
     * S -> Sufijo ordinal inglés para el día del mes, 2 caracteres st, nd, rd o th. Funciona bien con j
     * w -> Representación numérica del día de la semana 0 (para domingo) hasta 6 (para sábado)
     * z -> Dia del año => 0-365
     * ---------
     * ---SEM---
     * W -> numero de la semana del año => 0-52
     * ---------
     * ---MES---
     * F -> nombre més completo => January, February
     * m -> nº mes => 1-12
     * M -> nombre més abreviado => Jan,Feb
     * n -> Representación numérica de un mes, sin ceros iniciales 1 hasta 12
     * t -> Número de días del mes dado 28 hasta 31
     * ---------
     * ---AÑO---
     * Y -> Año con 4 digitos => 2024
     * y -> Año con 2 digitos => 24
     * L -> Si es un año bisiesto 1 si es bisiesto, 0 si no.
     * o -> Año según el número de la semana ISO-8601. Esto tiene el mismo valor que Y, excepto que si el número de la semana ISO (W) pertenece al año anterior o siguiente, se usa ese año en su lugar. (añadido en PHP 5.1.0) Ejemplos: 1999 o 2003
     * ---------
     * ---HORA--
     * H -> Hora formato 24hr => 12,13,14,15....
     * h -> Hora formato 12hr => 12,01,02,03....
     * a -> AM o PM en minusculas => 11am - 11pm
     * A -> AM o PM en mayusculas => 11AM - 11PM
     * B -> Hora Internet 000 hasta 999
     * G -> Hora formato de 24 horas sin 0 al inicio del numero => 23,24,1,2....
     * g -> Hora formato de 12 horas sin 0 al inicio del numero => 12,1,2,3....
     * i -> Minuto => 0-59
     * s -> Segundo => 0-59
     * u -> Microsegundos => 0-999999
     * v -> Milisegundos => 0-999
     * ---------
     * ---ZONA--
     * e -> Identificador de la zona horaria => UTC
     * I -> Te devuelve 1 si estamos en horario de verano y 0 si no
     * O -> Diferencia de tiempo con respecto a GMT/UTC => +0200
     * P -> Similar a `O` pero con dos puntos entre horas y minutos => +02:00
     * T -> Abreviatura de la zona horaria Ejemplos: EST, MDT ...
     * Z -> Índice de la zona horaria en segundos. El índice para zonas horarias al oeste de UTC siempre es negativo, y para aquellas al este de UTC es siempre positivo. -43200 hasta 50400
     * ---------
     * -COMPLEJA-
     * c -> Fecha formato ISO 8601 => 2024-01-23T14:30:45+00:00
     * r -> Fecha con formato » RFC 2822 Ejemplo: Thu, 21 Dec 2000 16:01:07 +0200
     * U -> Segundos desde la Época Unix (1 de Enero del 1970 00:00:00 GMT)
     * ----------
     */
    // Convierte la fecha a un objeto DateTime
    
    date_default_timezone_set('Europe/Madrid');
    if(empty($fecha)){
        return "Sin fecha";
    } else {
        $fechaObjeto = new DateTime($fecha);

    $diasNombre = [  //Aray para traducir los nombres de la semana
        'Mon' => 'Lu',
        'Tue' => 'Ma',
        'Wed' => 'Mi',
        'Thu' => 'Ju',
        'Fri' => 'Vi',
        'Sat' => 'Sá',
        'Sun' => 'Do',
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo',
    ];
    $mesesNombre = [ //Array para traducir los nombres de los meses
        'Jan' => 'Ene',
        'Feb' => 'Feb',
        'Mar' => 'Mar',
        'Apr' => 'Abr',
        'May' => 'May',
        'Jun' => 'Jun',
        'Jul' => 'Jul',
        'Aug' => 'Ago',
        'Sep' => 'Sep',
        'Oct' => 'Oct',
        'Nov' => 'Nov',
        'Dec' => 'Dic',
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre',
    ];

    // Inicializa la cadena de fecha formateada
    $fechaFormateada = '';

    // Recorre el formato proporcionado y agrega la parte formateada correspondiente
    foreach ($formato as $opcion) {
        if (strlen($opcion) > 1) { //Si tiene mas de 1 caracter no se formatea solo se muestra, por ejemplo 'del' 'de'....

            $fechaFormateada .= $opcion;
        } else {
            if($opcion == "D" || $opcion == "l"){ //Si la opcion de formato es D o l traducir nombre del dia de la semana
                $diaIngles = $fechaObjeto->format($opcion);
                $fechaFormateada .= $diasNombre[$diaIngles];
            } else if($opcion == "M" || $opcion == "F"){ //Si la opcion de formato es M o F traducir nombre del mes
                $mesIngles = $fechaObjeto->format($opcion);
                $fechaFormateada .= $mesesNombre[$mesIngles];
            }else{
                $fechaFormateada .= $fechaObjeto->format($opcion);
            }
        }
    }
   

    return $fechaFormateada;
}
}
//Convierte textos a slugs
// convertirASlug("Hola mundo") => hola-mundo
function convertirASlug($texto) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $texto), '-'));
    return $slug;
}
function numero_a_letras($numero) {
    $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud_letras = strlen($letras);

    if ($numero <= $longitud_letras) {
        return $letras[$numero - 1];
    } else {
        $remainder = ($numero - 1) % $longitud_letras;
        $cociente = floor(($numero - 1) / $longitud_letras);

        if ($remainder == 0) {
            return $letras[$longitud_letras - 1] . $cociente;
        } else {
            return $letras[$remainder - 1] . ($cociente + 1) . 'A';
        }
    }
}
function dividirYConvertirALetras($numero) {
    // Dividir el número en grupos de 2
    $grupos = str_split(str_pad($numero, ceil(strlen($numero) / 2) * 2, '0', STR_PAD_LEFT), 2);
    
    // Convertir cada grupo a letras
    $letras = '';
    foreach ($grupos as $grupo) {
        $letras .= convertirALetras($grupo);
    }
    
    return $letras;
}

function convertirALetras($numero) {
    $abecedario = 'abcdefghijklmnopqrstuvwxyz';
    $letra = '';
    // Convertir el número a letra
    while ($numero > 0) {
        if ($numero <= 26) {
            $letra .= $abecedario[$numero - 1];
            break;
        } else {
            $letra .= '1';
            $numero -= 26;
        }
    }
    return $letra;
}

//29/05/24 se añade la funcion resizeImage

function resizeImage($sourcePath, $newWidth)
{
   
    if (!file_exists($sourcePath)) {
        /*JSON - TODO:BORRAR*/
        $json_string = json_encode("Error: La imagen no existe en la ruta especificada.");
        $file = 'ERROR1.json';
        file_put_contents($file, $json_string);
        //***FIN JSON***
    }

    list($width, $height, $type) = getimagesize($sourcePath);
    if (!$width || !$height) {
        /*JSON - TODO:BORRAR*/
        $json_string = json_encode("Error: No se pudo obtener el tamaño de la imagen.");
        $file = 'ERROR2.json';
        file_put_contents($file, $json_string);
        //***FIN JSON***
    }

    $ratio = $newWidth / $width;
    $newHeight = $height * $ratio;

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($sourcePath);
            if (!$src) {
                /*JSON - TODO:BORRAR*/
                $json_string = json_encode("Error: No se pudo crear la imagen desde el archivo JPEG.");
                $file = 'ERROR3.json';
                file_put_contents($file, $json_string);
                //***FIN JSON***
            }
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($sourcePath);
            if (!$src) {
                /*JSON - TODO:BORRAR*/
                $json_string = json_encode("Error: No se pudo crear la imagen desde el archivo PNG.");
                $file = 'ERROR4.json';
                file_put_contents($file, $json_string);
                //***FIN JSON***
            }
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($sourcePath);
            if (!$src) {
                /*JSON - TODO:BORRAR*/
                $json_string = json_encode("Error: No se pudo crear la imagen desde el archivo GIF.");
                $file = 'ERROR5.json';
                file_put_contents($file, $json_string);
                //***FIN JSON***
            }
            break;
        default:
            /*JSON - TODO:BORRAR*/
            $json_string = json_encode("Error: Tipo de imagen no soportado.");
            $file = 'ERROR6.json';
            file_put_contents($file, $json_string);
            //***FIN JSON***
    }

    $dst = imagecreatetruecolor($newWidth, $newHeight);
    if (!$dst) {
        /*JSON - TODO:BORRAR*/
        $json_string = json_encode("Error: No se pudo crear una imagen nueva.");
        $file = 'ERROR7.json';
        file_put_contents($file, $json_string);
        //***FIN JSON***
    }

    if (!imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height)) {
        /*JSON - TODO:BORRAR*/
        $json_string = json_encode("Error: No se pudo redimensionar la imagen.");
        $file = 'ERROR8.json';
        file_put_contents($file, $json_string);
        //***FIN JSON***
    }

    ob_start(); // Start output buffering
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($dst);
            break;
        case IMAGETYPE_PNG:
            imagepng($dst);
            break;
        case IMAGETYPE_GIF:
            imagegif($dst);
            break;
    }
    $imageData = ob_get_contents(); // Get the image data
    ob_end_clean(); // End output buffering

    imagedestroy($src);
    imagedestroy($dst);

    return $imageData;
}

    // TRANSPORTES //
  // Función para transformar el número según las reglas especificadas
  function transformarNumero($numero) {
    if (substr($numero, -2) == '00') {
        // Si termina en 00, eliminar los últimos dos ceros
        return substr($numero, 0, -2);
    } else {
        // Si no termina en 00, agregar una barra antes de los dos últimos dígitos
        return substr($numero, 0, -2) . '/' . substr($numero, -2);
    }
}
/*
                $width1 = 400;
                $width2 = 800;
                $width3 = 1200;


                $sourcePath = rutaWebRelativa() . "private/editor/doc/" . $sCarpeta . "/" . $aDatosFile[ "renombre" ] . $aDatosFile[ "extension" ];
                $fileExt = pathinfo($sourcePath, PATHINFO_EXTENSION);

                $imageData1 = resizeImage($sourcePath, $width1);
                $imageData2 = resizeImage($sourcePath, $width2);
                $imageData3 = resizeImage($sourcePath, $width3);

                file_put_contents(rutaWebRelativa() . "private/editor/doc/" . $sCarpeta . "/" . $aDatosFile[ "renombre" ] . "_{$width1}." . $aDatosFile[ "extension" ], $imageData1);
                file_put_contents(rutaWebRelativa() . "private/editor/doc/" . $sCarpeta . "/" . $aDatosFile[ "renombre" ] . "_{$width2}." . $aDatosFile[ "extension" ], $imageData2);   
                file_put_contents(rutaWebRelativa() . "private/editor/doc/" . $sCarpeta . "/" . $aDatosFile[ "renombre" ] . "_{$width3}." . $aDatosFile[ "extension" ], $imageData3);*/