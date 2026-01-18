<!DOCTYPE html>
<html lang="es">

<!-- ======================================= -->
<!--  ESTO ES LOQUE SE VE EN LAS IMPRESIONES -->
<!-- ======================================= -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="efeuno.es">
    <!-- Favicon icon -->

    <!-- SESSION -->

    <?php

    require_once('../../config/templates/sesion.php');
    require_once("../../config/conexion.php");
    require_once("../../models/Comercial.php");

    $comercial = new Comercial();

    ?>

    <!-- Required meta tags -->
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">

    <!-- FICHERO CONFIG -->

    <?php require_once('../../config/config.php'); ?>
    <?php include_once '../../config/funciones.php'; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" id="faviconId" sizes="16x16" href="../../public/img/efeuno/<?php echo $favicon; ?>">

    <title><?php echo $nombreEmpresa; ?></title>
    <input type="hidden" id="colorPorDefectoBD" value="<?php echo $colorDefault; ?>">

    <!------------------>
    <!--   V. LINKS   -->
    <!------------------>
    <!--
    //? Autor: Efeuno Dev
    //* U.Versión: 1.0 05/02/2024

    ** Revisión de Links
    ** SE AÑADE SWITCHS BOOTSTRAP 30/01
    ** Darkmode 05/02
    -->

    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" type="text/css" />

    <!-- Chartist CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chartist@0.11.4/dist/chartist.min.css">

    <!-- C3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.css" integrity="sha512-cIV01rY2PfBOyU07RW1t2+aSG86RkBh1hP/MxWZPfJdu6fZOPHcEVxXuj0YZ9to8IPFN2qHBryai/4dgnsMzxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Morris CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" integrity="sha512-0yPy6PFE79l74Y76up1YkHKyVf8OsLRKXTO8R9gnYrRxlX69a6D7RfCbd1ehwFg+27vhq5Ou0S4GtG1TYT8Lrg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link href="../../public/css/styleOrder.css" rel="stylesheet">

    <!-- Style Tailwinds -->
    <!-- <link href="../../public/tailWindCss/src/output.css" rel="stylesheet"> -->

    <!-- Steps CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.css" integrity="sha512-K5kRhe9vX41EcrKmbsz+N4mLgYdGp5KY9i6Tk4c7QqPY1+Mg1OZorhBJAH7n5NUscdW/R4FCQh0MM1PhO9ZwXQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Efeuno CSS -->
    <link rel="stylesheet" href="https://efeuno.es/efeuno.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-6hQUBVkjj9uHChgh9MGxJp43xHFt3lroOZRb0TxEZugL7mIl5O/0LLcMwfhDsfLhvBojCEh1Il/BtVl8Hrrnag==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/keytable/2.9.0/css/keyTable.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.1.1/css/scroller.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.4.2/css/searchBuilder.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.jqueryui.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/staterestore/1.2.2/css/stateRestore.jqueryui.min.css" />

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" integrity="sha512-3Aqmq3ajkF3bFzM2Xrsr9Aq5cO3Txz9GLBndevT1Q0V0wr+kA8Ul16bJMiTrQ/RRlY4A0sh2fW2QHAE5xx48GQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" integrity="sha512-nMNlpuaDPrql/nI6K33ER9f0ogNKzEYEKRG+lxfDaZMAf3qlZZJozK4PRvH+8o3MafE6Qpr/xMjzMKy1RXtq3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" integrity="sha512-siarrzI1u3pCqFG2LEzi87McrBmq6Tp7juVsdmGY1Dr8Saw+ZBAzDzrGwX3vgxX1NkioYNCFOVC0GpDPss10zQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap Switch CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" integrity="sha512-i3Pr/1UGJm0XZGzceEO/S1DPOKOXbyPhplUM5sv6TLVzpMjlSA4D2ZJ/yy5Xb1MtYxdtlIh0tf7IRgZnNyyG8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Nestable CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" integrity="sha512-nV1y7TfGzEXEKNPLD5L5Y6u1m8wBP6ZDiMNT5pMrLqejmNqk2CfSpucxJUmX5M8kfiov6WQ8lvZ+1xNC4Z6j0A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Enlace a Google Fonts para la fuente manuscrita 'Caveat' -->
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .dz-error-message {
            top: 150px !important;
        }
    </style>

    <!-- 
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;family=Rubik:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap" rel="stylesheet" />
    <link href="assets/css/vendor.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    -->

    <link href="./firma/assets/jquery.signaturepad.css" rel="stylesheet">

    <?php
    require_once("../../models/Transportes.php");

    $tokenOrden = $_GET['idOrden'];
    $tipoDocumento = $_GET['tipoDocumento'];
    $idviaje = $_GET['viaje'];
    $transporte = new Transporte();

    $datosOrden = $transporte->recogerOrdenToken($tokenOrden);
    $datosViajesBD = $transporte->recogerOrdenTokenAll($tokenOrden, $idviaje);


    $idOrden = $datosOrden['num_transporte'];

    $tipoOrdenTransporte = $datosOrden['tipoOrdenTransporte'];

    $contenedorActivo = $datosOrden['contenedorActivo'];
    $precintoActivo = $datosOrden['precintoActivo'];

    $jsonDatos = json_decode($datosOrden['jsonOrdenTransporte'], true);




    // DETECTAR SI ESPECIFICA VIAJE O NO
    if (isset($_GET['viaje'])) {
        $viaje = $_GET['viaje'];
        // Aquí puedes procesar la variable $viaje como lo necesites
        $datosViajes = $transporte->recogerViajesxID($viaje);
        // Decodificar el JSON


    }

    //***FIN JSON***
    if ($idOrden == '') {
        // Redirecciona al usuario a index.php
        header("Location: index.php");
        exit; // Asegura que el script se detenga después de la redirección
    }

    //TIPO DE DOCUMENTO //
    if ($tipoDocumento == 'O') {
        $headerText = 'OFICINA';
    } elseif ($tipoDocumento == 'T') {
        $headerText = 'TRANSPORTISTA';
    } elseif ($tipoDocumento == 'C') {
        $headerText = 'RECEPTOR';
    } elseif ($tipoDocumento == 'A') {
        $headerText = 'ADMITASE';
    } elseif ($tipoDocumento == 'E') {
        $headerText = 'ENTREGUESE';
    }
    ?>

    <style>
        input {
            flex-grow: 1;
        }

        .print-label {
            display: block;
            /* Mostrar label al imprimir */
            font-size: 11px !important;
            line-height: 1;
        }

        body {
            font-family: "Courier New", Courier, monospace;
            font-weight: bold;
            color: #000000;
        }

        .tipo-letra {
            font-family: "Courier New", Courier, monospace !important;
        }

        .form-control-static,
        label.form-control-static {
            font-weight: normal;
            /* Quita la negrita */
            /* Agrega otros estilos aquí si es necesario */
        }

        .seccion-de-datos {
            border-radius: 10px;
            background-color: #B2F3E6;
            /* Color de fondo suave (gris claro) */
            padding: 20px;
            /* Espacio interno para separar el contenido */
        }

        .seccion-de-datos2 {
            border-radius: 10px;
            background-color: #D0FFC2;
            /* Color de fondo suave (gris claro) */
            padding: 20px;
            /* Espacio interno para separar el contenido */
        }

        .seccion-de-datos3 {
            border-radius: 10px;
            background-color: #C1F2C1;
            /* Color de fondo suave (gris claro) */
            padding: 20px;
            /* Espacio interno para separar el contenido */
        }



        .form-layout-footer .btn,
        .form-layout-footer .sp-container button,
        .sp-container .form-layout-footer button {
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 500;
            padding: 12px 20px;
        }


        /***** FORM LAYOUT 2 & 3 *****/
        .form-layout-2 .form-group,
        .form-layout-3 .form-group {
            position: relative;
            border: 1px solid #000000;
            padding: 20px 20px;
            margin-bottom: 0;
            height: 100%;
            transition: all 0.2s ease-in-out;
        }

        @media screen and (prefersuced-motion: reduce) {

            .form-layout-2 .form-group,
            .form-layout-3 .form-group {
                transition: none;
            }
        }

        .form-layout-2 .form-group-active,
        .form-layout-3 .form-group-active {
            background-color: #f8f9fa;
        }

        .form-layout-2 .form-control-label tx-bold,
        .form-layout-3 .form-control-label tx-bold {
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            display: block;
        }

        .form-layout-2 .form-control,
        .form-layout-2 .dataTables_filter input,
        .dataTables_filter .form-layout-2 input,
        .form-layout-3 .form-control,
        .form-layout-3 .dataTables_filter input,
        .dataTables_filter .form-layout-3 input {
            border: 0;
            padding: 0;
            background-color: transparent;
            color: #343a40;
            border-radius: 0;
            font-weight: 500;
        }

        .form-layout-2 .select2-container--default .select2-selection--single,
        .form-layout-3 .select2-container--default .select2-selection--single {
            background-color: transparent;
            border-color: transparent;
            height: auto;
        }

        .form-layout-2 .select2-container--default .select2-selection--single .select2-selection__rendered,
        .form-layout-3 .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0;
            font-weight: 500;
        }

        .form-layout-2 .select2-container--default .select2-selection--single .select2-selection__arrow,
        .form-layout-3 .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
        }

        /***** FORM LAYOUT 3 *****/
        .form-layout-3 .form-control,
        .form-layout-3 .dataTables_filter input,
        .dataTables_filter .form-layout-3 input {
            font-weight: 400;
        }

        .form-layout-3 .select2-container--default .select2-selection--single .select2-selection__rendered {
            font-weight: 400;
        }

        /***** FORM LAYOUT 4 & 5 *****/
        .form-layout-4,
        .form-layout-5 {
            padding: 30px;
            border: 1px solid #000000;
        }

        .form-layout-4 .form-control-label tx-bold,
        .form-layout-5 .form-control-label tx-bold {
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        /***** FORM LAYOUT 5 *****/
        @media (min-width: 576px) {
            .form-layout-5 .form-control-label tx-bold {
                justify-content: flex-end;
            }
        }

        /***** FORM LAYOUT 6 & 7 *****/
        .form-layout-6 .row>div,
        .form-layout-7 .row>div {
            border: 1px solid #000000;
            padding: 15px 20px;
        }

        .form-layout-6 .row>div:first-child,
        .form-layout-7 .row>div:first-child {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            border-right-width: 0;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-layout-6 .row+.row>div,
        .form-layout-7 .row+.row>div {
            border-top-width: 0;
        }

        .form-layout-6 .form-control,
        .form-layout-6 .dataTables_filter input,
        .dataTables_filter .form-layout-6 input,
        .form-layout-7 .form-control,
        .form-layout-7 .dataTables_filter input,
        .dataTables_filter .form-layout-7 input {
            border: 0;
            border-radius: 0;
            padding: 0;
        }

        /***** FORM LAYOUT 7 *****/
        .form-layout-7 .row>div:first-child {
            justify-content: flex-end;
        }


        /** MODIFICACION DEL FORM-GROUP PARA QUITAR MARGENES */

        .form-layout-2 .form-group,
        .form-layout-3 .form-group {
            padding: 1px 5px !important;
        }


        /** CLASES PERSONALIZADAS PARA EL FORMULARIO DE ORDEN TRANSPORTE */
        .text-decoration-underline {
            text-decoration: underline;
        }

        .border-right-none {
            border-right: none !important;
        }

        .border-left-none {
            border-left: none !important;
        }

        .borde-gris-derecho {
            border-right: 2px solid #000000;
        }

        .borde-gris-abajo {
            border-bottom: 2px solid #000000;
        }

        /** TABLA */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 3px;
            text-align: left;

        }

        th {
            font-weight: bold;

        }

        th:last-child,
        td:last-child {
            border-bottom: none;
        }

        .wd-200 {
            width: 200px !important;
        }

        .wd-300 {
            width: 300px !important;
        }

        .wd-85 {
            width: 85% !important;
        }

        .form-control {
            white-space: pre-wrap !important;
        }

        .auto-width {
            width: auto !important;
        }

        .wd-50-force {
            width: 50% !important;
        }

        .wd-47-force {
            width: 47% !important;
        }

        .wd-70-force {
            width: 70% !important;
        }

        @media print {

            /* Ocultar la barra de desplazamiento */
            .textAreaResize {
                overflow: visible !important;
            }

            .page-break {
                page-break-before: always;
            }


            header {
                left: 0;
                right: 0;
                background: #fff;
                text-align: center;
                z-index: 1000;
                /* Asegura que el header y footer estén por encima del contenido */

            }

            footer {
                position: fixed;
                left: 0;
                right: 0;
                background: #fff;
                text-align: center;
                z-index: 1000;
                /* Asegura que el header y footer estén por encima del contenido */

            }

            .lineaInferior {
                top: 0;
                border-bottom: 1px solid #000;
            }

            .lineaInferiorDash {
                top: 0;
                border-bottom: 1px dashed #000;

            }

            header {
                top: 0;
                height: 9cm;
                border-bottom: 1px solid #000;
            }

            footer {
                bottom: 0;
                height: 8cm;
                /* Ajuste la altura según sea necesario */
                border-top: 1px solid #000;
                padding: 0.5cm;
                /* Asegura que el texto dentro del footer no toque los bordes */
            }


            /* .pagenum:before {
                content: "Página " counter(page);
                counter-increment: page;
            } */

            @page {
                size: A4;
                margin: 1cm;
            }

            /* Asegurarse de que el contenido no se superponga con el header y footer */
            #contenido {
                margin-top: 4cm;
                margin-bottom: 4cm;
            }



        }

        .text-left {
            text-align: left;
            margin-left: 10px;
        }

        .text-right {
            text-align: right;

        }

        #contenido {
            margin-top: 0cm;
            margin-bottom: 4cm;
        }

        .bloqueOrden {
            font-size: 18px
        }

        .tableCMR td {
            vertical-align: top;
        }

        .td-num {
            width: 21.703px
        }

        .cuadradito {
            width: 10px;
            /* Ancho del cuadrado */
            height: 10px;
            /* Alto del cuadrado */
            background-color: white;
            /* Color de fondo del cuadrado */
            border: 1px solid red;
            /* Borde del cuadrado */
        }

        .striped-background {
            background: repeating-linear-gradient(0deg,
                    /* Ángulo de las líneas */
                    red,
                    /* Color de las líneas */
                    red 1px,
                    /* Inicio de la línea */
                    transparent 1px,
                    /* Espacio entre líneas */
                    transparent 4px
                    /* Fin de la línea */
                );
        }

        @media print {
            .lineaLimpio {
                background-color: white;
                /* Fondo blanco */
                position: relative;
                /* Asegura que se pueda superponer el fondo */
                z-index: 1;
                /* Asegura que esté encima del fondo de líneas */
            }

            .striped-background {
                background: repeating-linear-gradient(0deg,
                        /* Ángulo de las líneas */
                        red,
                        /* Color de las líneas */
                        red 1px,
                        /* Inicio de la línea */
                        transparent 1px,
                        /* Espacio entre líneas */
                        transparent 4px
                        /* Fin de la línea */
                    );
            }
        }

        .lineaLimpio {
            background-color: white;
            /* Fondo blanco */
            position: relative;
            /* Asegura que se pueda superponer el fondo */
            z-index: 1;
            /* Asegura que esté encima del fondo de líneas */
        }

        .logo-red-filter {
            filter: sepia(1) saturate(5) brightness(0.8) contrast(1.2);

            /* 
                hue-rotate: ajusta el tono del color.
                saturate: aumenta la saturación del color.
            */
        }


        /* CSS para un estilo de texto como si estuviese escrito con bolígrafo */
        .boli-texto {
            font-family: 'Caveat', cursive;
            /* Fuente manuscrita que imita la escritura */
            color: #2c3e50;
            /* Color azul oscuro típico de bolígrafo */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            /* Sombra ligera para un efecto más realista */
        }
    </style>

</head>

<body>

    <div id="main-wrapper">


        <div class="container-fluid">

            <!-- ============================================================== -->
            <!-- CONTENIDO DE LA PÁGINA  -->
            <!-- ============================================================== -->
            <input id="primerCodigo" type="hidden" value="<?php echo $jsonDatos['OA_PCS_LOCATOR']; ?>">

            <div class="printableArea">
                <?php
                if ($tipoDocumento == "CMR") {
                ?>
                    <div class="form-layout form-layout-2 tx-danger">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6 row">
                                        <h6 class="tx-12 col-10">Ejemplar para el remitente- Exemplaire de l'expéditeur<br>Copy for sender</h6>
                                        <h2 class="col-2  tx-right boli-texto"><?php echo $idOrden; ?></h2>
                                    </div>
                                    <div class="col-6 tx-right">
                                        <h2 class="tx-bold">2081</h2>
                                    </div>
                                </div>
                                <div class="bd" style="width: 100%">
                                    <table class="tableCMR" style="border-collapse: collapse;">
                                        <tr class="bd">
                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">1</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Remitente (nombre, CIF, domicilio, país)<br>Expédur(nom, adresse, pays)<br>Sender(name, address,country)</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td><label class="tx-bold tx-10 lh-1 ">CARTA DE PORTE INTERNACIONAL<br>LETTRE DE VOITURE INTERNATIONALE<br>INTERNATIONAL CONSIGNMENT NOTE</label></td>
                                                        <td><label class="tx-9 lh-1 ">Este Transporte queda sometido, no obstante<br>toda cláusula contraria, al Convenio sobre el<br>Contrato de Transporte Internacional de<br>Mercancías por Carretera (CMR).</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label class="tx-9 lh-1 ">Ce Transport est soumis, nonobstant toute<br>clause contraire, à la Convention relative au<br>contrat de transport international de<br>marchandises par route (CMR).</label></td>
                                                        <td><label class="tx-9 lh-1 ">This carriage is subject, notwithstanding any<br>clause to the contrary, to the Convention<br>on the Contract for the international Carriage<br>of good by road (CMR).</label></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bd">
                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">2</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Consignatorio (nombre, CIF, domicilio, país)<br>Destinataire(nom, adresse, pays)<br>Consignee(name, address,country)</h6><br><br>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd" rowspan="2">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">16</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Porteador (nombre, domicilio, país)<br>Transporteur (nom, adresse, pays)<br>Carrier (name, address, country)</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">17</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Portadores sucesivos (nombre, domicilio, país)<br>Transporteurs successifs (nom, adresse, pays)<br>Successive carriers (name, address, country)</h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="lh-1 tx-20 boli-texto"><?php echo $jsonDatos['CMR'][0]['PLATAFORMA']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $jsonDatos['CMR'][0]['TRACTORA']; ?><br></p>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr class="bd">

                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">3</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Lugar de entrega de la mercancía(lugar, país)<br>Lieu prévu pour la livraison de la marchandise(lieu, pays)<br>Place of delivery of the goods(place, country)</h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="lh-1 tx-20 boli-texto"><?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_NOMBRE']; ?><br><?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_DIRECCION']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_CP']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_POBLACION']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_PROVINCIA']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_PAIS']; ?><br></p>
                                                            </div>

                                                        </td>

                                                    </tr>
                                                    <tr>

                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bd">
                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">4</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Lugar y fechad e carga de la mercancía(lugar, país, fecha)<br>Lieu et date de la prise en charge de la marchandise(lieu, pays, date)<br>Place and date of taking over the goods(place, country, date)</h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="lh-1 tx-20 boli-texto"><?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_NOMBRE']; ?><br><?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_DIRECCION']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_CP']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_POBLACION']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_PROVINCIA']; ?> <?php echo $jsonDatos['CMR'][0]['LUGAR_CARGA']['LUGAR_PAIS']; ?><br></p>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd" rowspan="2">

                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">18</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Reservas y observaciones del portador<br>Réserves et observations du transportuer<br>Carrier's reservations and observations</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bd">
                                            <td class="bd">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">5</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Documentos anexos<br>Documents annexés<br> Documents attached</h6><br><br>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>

                                    </table>
                                    <table class="tableCMR" style="border-collapse: collapse;">
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">6</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Marcas y números<br>Marques et numéros<br>Marks and Nos</h6>
                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20">7</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Números de bultos<br>Nombre des colis<br>Number of packages</h6>
                                                            </div>
                                                            <div class="col-12">
                                                                <p class="lh-1 tx-20 boli-texto"><?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_BULTOS_DESCARGA']; ?><br></p>
                                                            </div>
                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20">8</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Clase de embalaje<br>Mode d'emballage<br>Method of packing</h6>
                                                        </td>
                                                        <td class="td-num "><label class="tx-bold tx-20">9</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Naturaleza de la mercancía<br>Nature de la marchandise<br>Nature of the goods</h6>
                                                                <p class="lh-1  boli-texto"><?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_MERCANCIA_DESCARGA']; ?></p>

                                                            </div>

                                                        </td>

                                                    </tr>


                                                    <tr class="pd-0-force mg-0-force bd">
                                                        <td class="td-num"><label class="tx-bold tx-20"></label></td>
                                                        <td>
                                                            <h6 class="tx-9">Classe<br>Class</h6>
                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20"></label></td>
                                                        <td>
                                                            <h6 class="tx-9">Chiffre<br>Number</h6>
                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20"></label></td>
                                                        <td>
                                                            <h6 class="tx-9">Lettre<br>Letter</h6>
                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20"></label></td>
                                                        <td>
                                                            <h6 class="tx-9">(ADR)*</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd" rowspan="10">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">10</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Nº estadistico<br>No. statistique<br>Statistical number</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd" rowspan="10">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">11</label></td>
                                                        <td class="row">
                                                            <div class="col-12">
                                                                <h6 class="tx-9">Peso bruto, Kg.<br>Poids brut, Kg.<br>Gross weight in Kg.</h6>
                                                                <h3 class="lh-1  boli-texto"><?php echo $jsonDatos['CMR'][0]['LUGAR_DESCARGA']['LUGAR_KILOS_DESCARGA']; ?></h3>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="bd" rowspan="10">
                                                <table>
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">12</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Volumen m.³<br>Cubage m.³<br>Volume in m.³</h6>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <table class="tableCMR" style="border-collapse: collapse; width: 100%;">
                                        <tr class="bd">
                                            <td class="bd" style="width: 50%;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">13</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Instrucciones del remitente<br>Instructions de l'expéditeur<br>Sender's instructions</h6>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </td>
                                            <td class="bd" rowspan="3" style="width: 50%; vertical-align: top;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">19</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Estipulaciones particulares/Conventions particulières/Special agreements</h6>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <h6 class="tx-9">

                                                                <table style="width: 100%;">

                                                                    <tr>
                                                                        <td style="width: 50%;">
                                                                            <table style="width: 100%;">
                                                                                <tr class="bd">
                                                                                    <td class="td-num"><label class="tx-bold tx-20">20 <h6 class="tx-9">A pagar por:<br>To be paid by:</h6></label></td>
                                                                                    <td class="bd" colspan="2">
                                                                                        <h6 class="tx-9">Remitente<br>Senders</h6>
                                                                                    </td>
                                                                                    <td class="bd" colspan="2">
                                                                                        <h6 class="tx-9">Moneda<br>Currency</h6>
                                                                                    </td>
                                                                                    <td class="bd" colspan="2">
                                                                                        <h6 class="tx-9">Consignatario<br>Consignee</h6>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="bd">
                                                                                    <td>
                                                                                        <h6 style="font-size: 8px">Precio del transporte:<br>Carriage charges:<br>Descuentos:<br>Deductions:</h6>
                                                                                    </td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                </tr>
                                                                                <tr class="bd">
                                                                                    <td>
                                                                                        <h6 style="font-size: 8px">Líquido/Balance<br>Suplementos:<br>Supplem, charges<br>Gastos accesorios<br>Other charges</h6>
                                                                                    </td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                </tr>
                                                                                <tr class="bd">
                                                                                    <td>
                                                                                        <h6 style="font-size: 8px">Total:</h6>
                                                                                    </td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                    <td class="bd"></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>

                                                                </table>


                                                            </h6>
                                                        </td>
                                                    </tr>
                                                    <tr class="striped-background">
                                                        <td class="td-num lineaLimpio"><label class="tx-bold tx-20">15</label></td>
                                                        <td class="mg-0 pd-0">
                                                            <h6 class="tx-9 lineaLimpio mg-0 pd-0 wd-80p">Reembolso / Remboursement / Cash on delivery</h6>
                                                            <div class="lineaLimpio wd-80p" style="height:25%">&nbsp;</div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bd">
                                            <td class="bd">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">14</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Forma de pago<br>Prescriptions d'affranchissement<br>Instructions as to payment fort carriage</h6>
                                                            <div class="d-flex">
                                                                <div class="cuadradito"></div>
                                                                <label class="tx-9">Porte pagado / Franco / Carriage paid</label>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="cuadradito"></div>
                                                                <label class="tx-9">Porte debido / Non franco / Carriage forward</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bd">
                                            <td class="bd">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">21</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Formalizado en&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a<br>Etabli à&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20<br>Established in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;on</h6>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>


                                    <table class="tableCMR" style="border-collapse: collapse; width: 100%;">

                                        <tr class="bd">
                                            <td class="bd">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td class="td-num"><label class="tx-bold tx-20">22</label></td>
                                                        <td>
                                                            <h6 class="tx-9 mg-b-20" style="width:300px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6><br><br><br><br>
                                                            <h6 class="tx-9">Firma y sello del remitente<br>Signatura et timbre de l'expéditeur<br>Signatura and stamp of the sender</h6>

                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20">23</label></td>
                                                        <td>
                                                            <h6 class="tx-9" style="width:300px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6><br>
                                                            <img src="../../public/assets/images/efeuno/logotipoWhite.png" alt="" width="200px" height="75px" class="logo-red-filter"><br>
                                                            <h6 class="tx-9">Firma y sello del transportista<br>Signatura et timbre du transporteur<br>Signatura and stamp of the carrier</h6>


                                                        </td>
                                                        <td class="td-num"><label class="tx-bold tx-20">24</label></td>
                                                        <td>
                                                            <h6 class="tx-9">Recibo de la mercacía / Marchandises reçues / Goodos received.</h6><br>
                                                            <h6 class="tx-9">Lugar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a<br>Lieu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;20<br>Place&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;on</h6><br>
                                                            <br>
                                                            <h6 class="tx-9">Firma y sello del consignatario<br>Signatura et timbre du destinataire<br>Signatura and stamp of the consignee</h6>


                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php





                } else {

                ?>

                    <?php if ($tipoOrdenTransporte == 'C') { ?>
                        <!-- ============================================================== -->
                        <!-- CONTENIDO ORDEN DE TRANSPORTE -->
                        <!-- ============================================================== -->
                        <div class="form-layout form-layout-2">
                            <div class="row no-gutters bd d-flex" data-select2-id="31">
                                <div class="col-5">
                                    <div class="form-group border-right-none">
                                        <h2 class="form-control-label tx-bold mg-10 tipo-letra print-27">ORDEN DE TRANSPORTE</h2>
                                        <br>
                                        <div class="tx-center">
                                            <h3 class="form-control-label tx-bold tx-center text-decoration-underline "><?php echo $headerText ?></h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-group border-left-none border-right-none">
                                        <label class="form-control-label tx-bold"><?php echo $jsonDatos['AGENCIA_NOMBRE']; ?></label><br>
                                        <label class="form-control-label"><?php echo $jsonDatos['AGENCIA_DIRECCION']; ?></label><br>
                                        <label class="form-control-label">Tel: <?php echo $jsonDatos['AGENCIA_TELEFONO']; ?> Fax: 963674717</label><br>
                                        <label class="form-control-label"><?php echo $jsonDatos['AGENCIA_CP']; ?>-<?php echo $jsonDatos['AGENCIA_POBLACION']; ?> (<?php echo $jsonDatos['AGENCIA_PROVINCIA']; ?>)</label><br>
                                        <label class="form-control-label"><?php echo $jsonDatos['AGENCIA_CIF']; ?></label>
                                    </div>

                                </div>
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <div class="mg-r-70 wd-100">
                                        <div id="qrcode" class="wd-100 mg-5" style="width: 100%; height: auto;"></div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="form-group col-12">
                                        <table class="">
                                            <tbody>
                                                <tr>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">F. Carga: </label>
                                                            <input class="form-control" type="text" readonly name="fechaCarga" value="<?php echo transformarFecha($jsonDatos['TTE_FECHA_CARGA'], ['d', '-', 'm', '-', 'Y']); ?>">
                                                        </div>
                                                    </th>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">Hora: </label>
                                                            <input class=" form-control" type="text" readonly name="fechaCarga" value="<?php echo $jsonDatos['TTE_HORA_CARGA']; ?>">
                                                        </div>
                                                    </th>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">Ref. Consig: </label>
                                                            <!-- <input class=" form-control" type="text" readonly name="RefConsig" value="<?php echo $jsonDatos['TTE_REF_CONSIG']; ?>"> -->
                                                            <!-- 2025-12-21 -->
                                                            <input class=" form-control" type="text" readonly name="RefConsig" value="<?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?>">
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">Recogida estimada: </label>
                                                            <input class="form-control wd-47-force" type="text" readonly name="recogidaEstimada" value="<?php echo transformarFechaVacia($jsonDatos['TTE_FECHA_ESTIMADA_RECOGIDA'], ["d", "-", "m", "-", "Y"]); ?>">
                                                        </div>
                                                    </th>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">Entrega estimad: </label>
                                                            <input class=" form-control wd-50-force" type="text" readonly name="entregaEstimada" value="<?php echo transformarFechaVacia($jsonDatos['TTE_FECHA_ESTIMADA_ENTREGA'], ["d", "-", "m", "-", "Y"]); ?>">
                                                        </div>
                                                    </th>
                                                    <th class="tx-bold">
                                                        <div class="form-inline">
                                                            <label class="mg-r-8 mg-b-8 tx-bold">OT Agencia: </label>
                                                            <input class=" form-control wd-50-force" type="text" readonly name="OTAgencia" value="<?php echo $jsonDatos['TTE_ORDEN']; ?>">
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>


                                </div>

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group">

                                        <div class="row">


                                            <div class="col-6 borde-gris-derecho row">
                                                <div class="col-12 d-flex align-items-start borde-gris-abajo" style="height: 40%">
                                                    <label class="form-control-label mg-l-5 tx-bold mr-2 mg-t-7">Agente:</label>
                                                    <input class="form-control" type="text" readonly name="agente" title="<?php echo $jsonDatos['CONSIGNATARIO']; ?>" value="<?php echo $jsonDatos['CONSIGNATARIO']; ?>">

                                                </div>
                                                <div class="col-12 row">
                                                    <div class="col-4">
                                                        <label class="form-control-label tx-bold">Contenedores:</label>

                                                        <input class="form-control" type="text" readonly name="contenedores" title="<?php echo $contenedorActivo; ?>" value="<?php echo $contenedorActivo; ?>">
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-control-label tx-bold">Tipo:</label>
                                                        <!-- <input class="form-control" type="text" readonly name="tipo" title="<?php ##echo $jsonDatos['TIPO_CONT_DESC']; ?>" value="<?php ##echo $jsonDatos['TIPO_CONT_DESC']; ?>"> -->
                                                        <!-- 2025-12-21 -->
                                                        <input class="form-control" type="text" readonly name="tipo" title="<?php echo $jsonDatos['TIPO_CONT_DESC'].' '.$jsonDatos['TIPO_CONT']; ?>" value="<?php echo $jsonDatos['TIPO_CONT_DESC'].' '.$jsonDatos['TIPO_CONT']; ?>">
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-control-label tx-bold">Hlog Precintos:</label>
                                                        <input class="form-control" type="text" readonly name="hlogPrecintos" title="<?php echo $jsonDatos['PRECINTO']; ?>" value="<?php echo $jsonDatos['PRECINTO']; ?>">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-6 ">
                                                <table class="">
                                                    <tr>
                                                        <th class="tx-bold">Transportista</th>
                                                        <th class="tx-bold">Conductor</th>
                                                        <th class="tx-bold">Cabeza</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="wd-400">
                                                            <?php echo $jsonDatos['TRANSPORTISTA_NOMBRE'] . '<br>' . $jsonDatos['TRANSPORTISTA_DIRECCION'] . ' <br>' . $jsonDatos['TRANSPORTISTA_CP'] . ' ' . $jsonDatos['TRANSPORTISTA_POBLACION'] . ' ' . $jsonDatos['TRANSPORTISTA_PROVINCIA'] . ' ' . $jsonDatos['TRANSPORTISTA_NIF']; ?>
                                                        </td>
                                                        <td class="wd-300">
                                                            <?php echo $jsonDatos['CONDUCTOR_NOMBRE'] . '<br>' . $jsonDatos['CONDUCTOR_NIF']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $jsonDatos['TRACTORA']; ?>
                                                            <br>
                                                            Plataforma: <?php echo $jsonDatos['PLATAFORMA']; ?>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>

                                        </div>



                                    </div>

                                </div>
                                <!-- FIN ROW -->

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group">

                                        <div class="row">

                                            <div class="col-6 borde-gris-derecho row  ">
                                                <table class="mg-5">
                                                    <tr>
                                                        <th class="tx-bold borde-gris-derecho">Retirar De:</th>
                                                        <th class="tx-bold">Entregar En:</th>

                                                    </tr>
                                                    <tr>
                                                        <td class="wd-300 borde-gris-derecho">

                                                            <?php echo $jsonDatos['RECOGER_EN_NOMBRE'] . '<br>' . $jsonDatos['RECOGER_EN_DIRECCION'] . ' <br>' . $jsonDatos['RECOGER_EN_CP'] . ' ' . $jsonDatos['RECOGER_EN_POBLACION'] . ' ' . $jsonDatos['RECOGER_EN_PROVINCIA']; ?>

                                                        </td>
                                                        <td class="wd-300">
                                                            <?php echo $jsonDatos['DEVOLVER_EN_NOMBRE'] . '<br>' . $jsonDatos['DEVOLVER_EN_DIRECCION'] . ' <br>' . $jsonDatos['DEVOLVER_EN_CP'] . ' ' . $jsonDatos['DEVOLVER_EN_POBLACION'] . ' ' . $jsonDatos['DEVOLVER_EN_PROVINCIA']; ?>

                                                        </td>

                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="col-6 ">
                                                <div class="row mg-5">
                                                    <div class="col-12 ">
                                                        <table class="borde-gris-abajo">
                                                            <tr>
                                                                <th class="tx-bold">Mercancía: </th>
                                                                <th class="tx-bold">Bultos: </th>
                                                                <th class="tx-bold">Peso:</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="">
                                                                    <?php echo $jsonDatos['LUGARES'][0]['LUGAR_MERCANCIA_CARGA']; ?>
                                                                </td>
                                                                <td class="">
                                                                    <?php echo $jsonDatos['LUGARES'][0]['LUGAR_BULTOS_CARGA']; ?>
                                                                </td>
                                                                <td class="">
                                                                    <?php echo $jsonDatos['LUGARES'][0]['LUGAR_KILOS_CARGA']; ?>kg
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                </div>
                                                <div class="row mg-5">

                                                    <div class="col-4 form-inline">
                                                        <label class="form-control-label tx-bold mr-2">Temp. Max: </label>
                                                        <input class="form-control wd-30-force" type="text" readonly name="" value="<?php echo $jsonDatos['TEMP_MAXIMA']; ?>">
                                                    </div>

                                                    <div class="col-4  form-inline">
                                                        <label class=" form-control-label tx-bold mr-2">Temp. Mín: </label>
                                                        <input class=" form-control wd-30-force" type="text" readonly name="" value="<?php echo $jsonDatos['TEMP_MINIMA']; ?>">
                                                    </div>

                                                    <div class="col-4  form-inline">
                                                        <label class=" form-control-label tx-bold mr-2">Conectar: </label>
                                                        <input class=" form-control wd-30-force" type="text" readonly name="" value="<?php echo $jsonDatos['TEMP_CONECTAR']; ?>">
                                                    </div>

                                                </div>


                                            </div>

                                        </div>



                                    </div>

                                </div>
                                <!-- FIN ROW -->

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group">

                                        <div class="row">

                                            <div class="col-6 borde-gris-derecho row  ">
                                                <table class="mg-5">
                                                    <tr>
                                                        <th class="tx-bold tx-center">Ext. Der</th>
                                                        <th class="tx-bold tx-center">Ext. Izq</th>
                                                        <th class="tx-bold tx-center">Ext. Front</th>
                                                        <th class="tx-bold tx-center">Ext. Tras</th>
                                                        <th class="tx-bold tx-center">Ext. Altura</th>
                                                    </tr>
                                                    <tr>
                                                        <td class=" tx-center ">
                                                            <?php echo $jsonDatos['EXTRA_RIGHT']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['EXTRA_LEFT']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['EXTRA_FRONT']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['EXTRA_BACK']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['EXTRA_ALTO']; ?>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </div>

                                            <div class="col-6 row  ">
                                                <table class="mg-5">
                                                    <tr>
                                                        <th class="tx-bold tx-center">ONU</th>
                                                        <th class="tx-bold  tx-center">Versión</th>
                                                        <th class="tx-bold  tx-center">IMDG</th>
                                                        <th class="tx-bold  tx-center">Clase</th>
                                                        <th class="tx-bold tx-center">Notif Apv</th>
                                                    </tr>
                                                    <tr>
                                                        <td class=" tx-center ">
                                                            <?php echo $jsonDatos['IMO_ONU']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['IMO_VERSION']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['IMO_PAGINA']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['IMO_CLASE']; ?>
                                                        </td>

                                                        <td class=" tx-center">
                                                            <?php echo $jsonDatos['IMO_PORT_NOTIFICATION']; ?>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- FIN ROW -->

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group">

                                        <div class="row">

                                            <div class="col-6 borde-gris-derecho row ">

                                                <table class="mg-l-10">
                                                    <tbody>
                                                        <tr>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Línea:</label>
                                                                    <textarea class="form-control wd-70-force d-flex align-items-flex-end" readonly name="linea" rows="2" style="resize:none;"><?php echo $jsonDatos['NOMBRELINEA_DEST']; ?></textarea>
                                                                </div>
                                                            </th>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Nº Escala:</label>
                                                                    <input class="form-control wd-50-force" type="text" readonly name="numeroEscala" value="<?php echo $jsonDatos['ESCALA_DEST']; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Buque:</label>
                                                                    <input class="form-control" type="text" readonly name="buque" value="<?php echo $jsonDatos['BUQUE_DEST']; ?>">
                                                                </div>
                                                            </th>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Viaje:</label>
                                                                    <input class="form-control wd-50-force" type="text" readonly name="viaje" value="<?php echo $jsonDatos['VIAJE']; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Dist. Llamada:</label>
                                                                    <input class="form-control" type="text" readonly name="distLlamada" value="<?php echo $jsonDatos['DISTINTIVO_LLAMADA']; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="col-6 row mg-l-10">

                                                <table class="mg-l-10">
                                                    <tbody>
                                                        <tr>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Origen:</label>
                                                                    <input class="form-control" type="text" readonly name="origen" readonly value="<?php echo $jsonDatos['PUERTO_ORIGEN_NOMBRE']; ?>">
                                                                </div>
                                                            </th>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Destino:</label>
                                                                    <input class="form-control" type="text" readonly name="numeroEscala" readonly value="<?php echo $jsonDatos['PUERTO_DESTINO_NOMBRE']; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Pto. Des/carga:</label>
                                                                    <input class="form-control" type="text" readonly name="Ptodescarga" readonly value="<?php echo $jsonDatos['PUERTO_DESCARGA_NOMBRE']; ?>">
                                                                </div>
                                                            </th>
                                                            <th class="tx-bold">
                                                                <div class="form-inline">
                                                                    <label class="mg-r-8 mg-b-8 tx-bold">Tipo Orden:</label>
                                                                    <input class="form-control" type="text" readonly name="tipoOrden" readonly value="<?php echo $jsonDatos['PUERTO_TIPO_ORDEN_IMPORTACION'] ? 'IMPORT' : 'EXPORT'; ?>">
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>



                                        </div>

                                    </div>

                                </div>
                                <!-- FIN ROW -->

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group col-12">

                                        <div class="row">


                                            <div class="col-7 borde-gris-derecho d-flex justify-content-start  form-inline ">


                                                <label class=" form-control-label tx-bold mr-2">Ref Carga: </label>
                                                <input class=" form-control" type="text" readonly name="refCarga" value="<?php echo $jsonDatos['LUGARES'][0]['LUGAR_REF_CARGA']; ?>">

                                            </div>
                                            <div class="col-4  form-inline ">

                                                <label class=" form-control-label tx-bold mr-2">Cargador: </label>

                                                <input class=" form-control" type="text" readonly name="refCarga" value="<?php echo $jsonDatos['CARGADOR_NOMBRE']; ?>">


                                            </div>


                                        </div>

                                    </div>

                                </div>
                                <!-- FIN ROW -->

                                <!-- UN ROW -->
                                <div class="col-12 ">

                                    <div class="form-group col-12">

                                        <div class="row">

                                            <div class="col-7 borde-gris-derecho d-flex justify-content-start form-inline d-flex align-items-start form-inline ">

                                                <label class="form-control-label tx-bold mr-2 ">Pif/Aduana:</label>
                                                <input class="form-control wd-85" type="text" readonly name="aduana" readonly value="<?php echo $jsonDatos['PIF_NOMBRE']; ?>">

                                            </div>
                                            <div class="col-4  form-inline ">

                                                <label for=""><?php echo $jsonDatos['CARGADOR_NOMBRE'] . '<br>' . $jsonDatos['CARGADOR_CIF'] . ' ' . $jsonDatos['CARGADOR_DIRECCION'] . '<br> ' . $jsonDatos['CARGADOR_POBLACION'] . ' ' . $jsonDatos['CARGADOR_PROVINCIA']; ?></label>


                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <!-- UN ROW VIAJES-->
                                <?php if ($tipoDocumento != 'A' && $tipoDocumento != 'E') { ?>

                                    <div class="col-12 ">

                                        <div class="form-group">

                                            <div class="row">

                                                <div class="col-12  form-inline">
                                                    <label class="form-control-label tx-bold mr-2 ">Lugares Carga/Descarga:</label>
                                                    <!-- <input class="form-control" type="text" readonly name="linea" readonly value="HAPAG LLLOYD*****"> -->
                                                </div>

                                                <div class="col-12">

                                                    <table class="">
                                                        <thead>
                                                            <tr class="borde-gris-abajo">
                                                                <th class="tx-bold">Lugar</th>
                                                                <th class="tx-bold">Dirección</th>
                                                                <th class="tx-bold">CP</th>
                                                                <th class="tx-bold">Población</th>
                                                                <th class="tx-bold">Provincia</th>
                                                                <th class="tx-bold">Telf:</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody class>

                                                            <?php if (isset($_GET['viaje'])) {
                                                                // Ejemplo de cómo recorrer los datos de viajes obtenidos
                                                                foreach ($datosViajes as $viaje) { ?>
                                                                    <tr>
                                                                        <td class=""><?php echo $viaje['LUGAR_NOMBRE']; ?></td>
                                                                        <td class=""><?php echo $viaje['LUGAR_DIRECCION']; ?></td>
                                                                        <td class=""><?php echo $viaje['LUGAR_CP']; ?></td>
                                                                        <td class=""><?php echo $viaje['LUGAR_POBLACION']; ?></td>
                                                                        <td class=""><?php echo $viaje['LUGAR_PROVINCIA']; ?></td>
                                                                        <td class=""><?php echo $viaje['LUGAR_TELEFONO']; ?></td>
                                                                    </tr>
                                                                <?php }
                                                            } else {

                                                                foreach ($jsonDatos['LUGARES'] as $lugar) { ?>
                                                                    <tr>
                                                                        <td class=""><?php echo $lugar['LUGAR_NOMBRE']; ?></td>
                                                                        <td class=""><?php echo $lugar['LUGAR_DIRECCION']; ?></td>
                                                                        <td class=""><?php echo $lugar['LUGAR_CP']; ?></td>
                                                                        <td class=""><?php echo $lugar['LUGAR_POBLACION']; ?></td>
                                                                        <td class=""><?php echo $lugar['LUGAR_PROVINCIA']; ?></td>
                                                                        <td class=""><?php echo $lugar['LUGAR_TELEFONO']; ?></td>
                                                                    </tr>
                                                            <?php }
                                                            } ?>
                                                        </tbody>
                                                    </table>

                                                </div>


                                            </div>

                                        </div>

                                    </div>
                                <?php } ?>
                                <!-- FIN ROW -->


                                <!-- UN ROW -->
                                <div class="row">

                                    <div class="col-12">


                                        <div class="form-group ">
                                            <div class="row"><br>
                                                <div class="col-12 form-inline d-flex align-items-start"><br>

                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-start">
                                                <?php if (!empty($datosOrden['dniViajeReceptor'])) {
                                                ?>
                                                    <div class="col-3 row">
                                                        <div class="col-12 form-inline d-flex align-items-start">
                                                            <label class="form-control-label tx-bold mr-2 mg-b-0">FIRMA Y SELLO LEADER:</label>


                                                            <img src="<?php echo $datosOrden["FirmaViajeConductor"]; ?>" style="max-height: 125px" alt="">

                                                            <p class="form-control" readonly><?php echo  $datosOrden['nombreViajeConductor'] . ", " . $datosOrden['dniViajeConductor'] ?></p>

                                                        </div>

                                                    </div>
                                                    <div class="col-3 row">
                                                        <div class="col-12 form-inline d-flex align-items-start">
                                                            <label class="form-control-label tx-bold mr-2 mg-b-0">FIRMA Y SELLO CLIENTE:</label>


                                                            <img src="<?php echo $datosOrden["FirmaViajeReceptor"]; ?>" style="max-height: 125px" alt="">


                                                            <p class="form-control" readonly><?php echo  $datosOrden['nombreViajeReceptor'] . ", " . $datosOrden['dniViajeReceptor'] ?></p>


                                                        </div>

                                                    </div>
                                                <?php } ?>

                                                <div class="col-6">
                                                    <div class="row "><br>
                                                        <div class="col-12 form-inline d-flex align-items-start"><br>
                                                            <label class="form-control-label tx-bold mr-2 ">Observaciones:</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row col-12">

                                                            <div class="col-12 form-inline d-flex align-items-start">
                                                                <label class="print-label" id="printLabel"> BOOKING Nº: <?php echo $jsonDatos['PCS_BOOKING_NUMBER'] . ' - ' . trim($jsonDatos['OBSERVACIONES']); ?></label>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12  form-inline">
                                                    <?php
                                                    //TIPO DE DOCUMENTO //
                                                    if ($tipoDocumento == 'A') { ?>

                                                        <label class="form-control-label tx-bold mr-2 ">Loc. Admisión: <?php echo $jsonDatos['OA_PCS_LOCATOR']; ?></label><br>
                                                        <label class="form-control-label tx-bold mr-2 ">Ref. Sic: <?php echo $jsonDatos['OA_PCS']; ?></label> <!-- A -->

                                                    <?php } elseif ($tipoDocumento == 'E') { ?>

                                                        <label class="form-control-label tx-bold mr-2 ">Loc. Entrega: <?php echo $jsonDatos['OE_PCS_LOCATOR']; ?></label><br>
                                                        <label class="form-control-label tx-bold mr-2 ">Ref. Sic: <?php echo $jsonDatos['OE_PCS']; ?></label> <!-- E -->

                                                    <?php } ?>


                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-12  form-inline">
                                                    <label class="form-control-label tx-bold mr-2 ">Fecha Emisión: </label>
                                                    <input class="form-control" type="text" readonly name="linea" readonly value="<?php echo transformarFecha("", ["d", "-", "m", "-", "Y", " ", "H", ":", "i", ":", "s"]); ?>">
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-12 mg-t-0 mg-b-0" style="line-height: 1; word-spacing: -1px;">

                                                    <small class="form-control-label tx-bold mr-2 tx-5 ">Los datos recogido en esta Orden de Tranposte son totalmente confidenciales y queda prohibido su uso no autorizado. En cumplimiento de la normativa de Protección de Datos Personales, informamos que estos datos tratados por LEADER TRANSPORT SL, para cumplir con los servicios solicitados y con las obligaciones tributarias derivadas. Podrá ejercer los derechos reconocidos en dicha normativa enviado solicitud a nuestra dirección arriba indicada o mediante correo-e a patricio@consigmar.com adjuntado copia de su documento de identidad. Puede solicitar más información, sobre cómo tratamos sus datos, dirigiéndose a la dirección de correo arriba mencionada.</small>
                                                </div>

                                            </div>

                                        </div>


                                    </div>
                                    <!-- FIN ROW -->

                                    <!-- UN ROW -->
                                    <div class="col-6 d-none">

                                        <div class="form-group">

                                            <div class="row">

                                                <div class="col-6 row form-inline d-flex align-items-start">



                                                </div>

                                                <div class="col-6 row form-inline d-flex align-items-start">

                                                    <div class="row col-12 ">
                                                        <!--  <div class="col-12 form-inline d-flex align-items-start">
                                                            <label class="form-control-label tx-bold mr-2 ">Observaciones:</label>
                                                            <textarea class="form-control textAreaResize col-12" name="" id="" >Lorem ipsum dolor si
                                                            </textarea>
                                                        </div> -->
                                                    </div>

                                                </div>



                                            </div>



                                        </div>


                                    </div>


                                </div>
                            </div>
                            <!-- FIN ROW -->



                        </div>

                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->


                        <!-- ============================================================== -->
                        <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                        <!-- ============================================================== -->
                    <?php } else if ($tipoOrdenTransporte == 'T') { ?>
                        <!-- ============================================================== -->
                        <!-- CONTENIDO ORDEN DE TRANSPORTE T -->
                        <!-- ============================================================== -->
                        <?php
                        function insertHeader($jsonDatos)
                        {
                            echo '
                                <header>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-6 text-center tx-20">
                                            <img src="../../public/assets/images/leadertransport.png" width="50%" height="50%" alt="Leader Transport s.l." class="img-fluid">
                                        </div>
                                        <div class="col-6">
                                            <h3 class="tx-bold tx-30">ORDEN DE CARGA</h3>
                                            <h4 class="tx-bold tx-26">Nº ' . $jsonDatos['TTE_ORDEN'] . '</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-4 tx-16 lineaInferior">
                                        <div class="col-5 text-left tx-10">
                                            <label>
                                                ' . $jsonDatos['AGENCIA_DIRECCION'] . ', ' . $jsonDatos['AGENCIA_CP'] . ', ' . $jsonDatos['AGENCIA_POBLACION'] . ', ' . $jsonDatos['AGENCIA_PROVINCIA'] . '<br>
                                                TEL: ' . $jsonDatos['AGENCIA_TELEFONO'] . '<br>
                                                EMAIL: ' . $jsonDatos['AGENCIA_EMAIL'] . '<br>
                                                NIF: ' . $jsonDatos['AGENCIA_CIF'] . '
                                            </label>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span class="pagenum"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-4 text-left tx-14" style="line-height: 8px">
                                        <div class="col-6">
                                            <p>Transportista: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_NOMBRE'] . '</span></p>
                                            <p>Dirección: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_DIRECCION'] . '</span></p>
                                            <p>Conductor: <span style="font-weight: normal">' . $jsonDatos['CONDUCTOR_NOMBRE'] . '</span></p>
                                            <p>Matrícula: <span style="font-weight: normal">' . $jsonDatos['TRACTORA'] . '</span></p>
                                            <p>Precio acordado: <span style="font-weight: normal"></span></p>
                                        </div>
                                        <div class="col-6">
                                            <p>Identificación Transportista: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_NIF'] . '</span></p>
                                            <p>Población: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_POBLACION'] . '</span></p>
                                            <p>Identificación Conductor: <span style="font-weight: normal">' . $jsonDatos['CONDUCTOR_NIF'] . '</span></p>
                                            <p>Plataforma: <span style="font-weight: normal">' . $jsonDatos['PLATAFORMA'] . '</span></p>
                                            <p>Tipo Plataforma: <span style="font-weight: normal">' . $jsonDatos['PLATAFORMA_TIPO'] . '</span></p>
                                        </div>
                                    </div>
                                </header>';
                        }

                        insertHeader($jsonDatos);
                        ?>


                        <div id="contenido">
                            <?php


                            $contador = 0; // SALTO DE PAGINA
                            foreach ($datosViajesBD as $viaje) {
                                $viajeJson = json_decode($viaje['jsonOrdenTransporte'], true);


                                // Cada 3 bloques, añadir un "page-break" y un espacio
                                if ($contador == 2) {
                                    echo '<div class="page-break"></div>';
                                    insertHeader($jsonDatos);
                                    $contador = 0;
                                }
                                if ($viaje['tipoViaje'] == 'CARGA') {

                            ?>


                                    <div class="row bloqueOrden">
                                        <label class="bold col-12 tx-center">LUGARES DE CARGA 📥</label>
                                    </div>
                                    <div class="row mt-4 text-left tx-16 lineaInferiorDash bloqueOrden" style="line-height: 8px">
                                        <div class="col-12 row">
                                            <div class="col-6">
                                                <p>Empresa: <span style="font-weight: normal"><?php echo $viaje['LUGAR_NOMBRE']; ?>
                                                    </span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Población: <span style="font-weight: normal"><?php echo $viaje['LUGAR_POBLACION']; ?></span></p>
                                            </div>
                                            <div class="col-12">
                                                <p>Dirección: <span style="font-weight: normal"><?php echo $viaje['LUGAR_DIRECCION']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Teléfono: <span style="font-weight: normal"><?php echo $viaje['LUGAR_TELEFONO']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>CP: <span style="font-weight: normal"><?php echo $viaje['LUGAR_CP']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Fecha: <span style="font-weight: normal"><?php echo $viaje['TTE_FECHA_CARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Hora: <span style="font-weight: normal"><?php echo $viaje['TTE_HORA_CARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Mercancia: <span style="font-weight: normal"><?php echo $jsonDatos['MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Ref. carga: <span style="font-weight: normal"><?php echo $viaje['LUGAR_REF_CARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Bultos: <span style="font-weight: normal"><?php echo $jsonDatos['BULTOS']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Metros: <span style="font-weight: normal"><?php //echo $jsonDatos['BULTOS']; 
                                                                                                ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Kilos: <span style="font-weight: normal"><?php echo $jsonDatos['PESO_MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Observaciones: <span style="font-weight: normal"><?php echo $viaje['LUGAR_OBSERVACIONES_CARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Cliente: <img src="<?php echo $viaje["FirmaViajeReceptor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Cliente: <br><br><label><?php echo $viaje["nombreViajeReceptor"] . ", " . $viaje["dniViajeReceptor"]; ?></label></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Transportista: <img src="<?php echo $viaje["FirmaViajeConductor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Transportista: <br><br><label><?php echo $viaje["nombreViajeConductor"] . ", " . $viaje["dniViajeConductor"]; ?></label></p>
                                            </div>
                                        </div>
                                    </div>


                                <?php
                                } else {


                                ?>


                                    <div class="row bloqueOrden">
                                        <label class="bold col-12 tx-center">LUGARES DE DESCARGA 📤</label>
                                    </div>

                                    <div class="row mt-4 text-left tx-16 lineaInferiorDash bloqueOrden" style="line-height: 8px">
                                        <div class="col-12 row">
                                            <div class="col-6">
                                                <p>Empresa: <span style="font-weight: normal"><?php echo $viaje['LUGAR_NOMBRE']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Población: <span style="font-weight: normal"><?php echo $viaje['LUGAR_POBLACION']; ?></span></p>
                                            </div>
                                            <div class="col-12">
                                                <p>Dirección: <span style="font-weight: normal"><?php echo $viaje['LUGAR_DIRECCION']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Teléfono: <span style="font-weight: normal"><?php echo $viaje['LUGAR_TELEFONO']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>CP: <span style="font-weight: normal"><?php echo $viaje['LUGAR_CP']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Fecha: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_FECHA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Hora: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_HORA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Mercancia: <span style="font-weight: normal"><?php echo $jsonDatos['MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Ref. carga: <span style="font-weight: normal"><?php echo $viaje['LUGAR_REF_DESCARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Bultos: <span style="font-weight: normal"><?php echo $jsonDatos['BULTOS']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Metros: <span style="font-weight: normal"><?php //echo $jsonDatos['BULTOS']; 
                                                                                                ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Kilos: <span style="font-weight: normal"><?php echo $jsonDatos['PESO_MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Observaciones: <span style="font-weight: normal"><?php echo $viaje['LUGAR_OBSERVACIONES_DESCARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Cliente: <img src="<?php echo $viaje["FirmaViajeReceptor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Cliente: <br><br><label><?php echo $viaje["nombreViajeReceptor"] . ", " . $viaje["dniViajeReceptor"]; ?></label></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Transportista: <img src="<?php echo $viaje["FirmaViajeConductor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Transportista: <br><br><label><?php echo $viaje["nombreViajeConductor"] . ", " . $viaje["dniViajeConductor"]; ?></label></p>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }


                                $contador++;
                            }
                            ?>





                        </div>

                        <footer <?php if ($tipoDocumento != "E") { ?> style="height:5cm" <?php } ?>>
                            <?php
                            if ($tipoDocumento == "E") { ?>

                                <div class="row">
                                    <div class="col-4 bd" style="height: 110px; position: relative;">
                                        <label class="tx-bold">FIRMA Y SELLO CLIENTE</label><br>
                                        <img src="<?php echo $datosOrden['firmaCliente']; ?>" style="max-height: 50px" alt=""><br>
                                        <label class="tx-bold mg-t-10" style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;"><?php echo $datosOrden['nombreCliente']  . ", " . $datosOrden['dniCliente']; ?></label>
                                    </div>
                                    <div class="col-4"><label class="tx-bold"></label></div>
                                    <div class="col-4 bd" style="height: 110px; position: relative;">
                                        <label class="tx-bold">FIRMA Y SELLO TRANSPORTISTA</label><br>
                                        <img src="<?php echo $datosOrden['FirmaViajeConductor']; ?>" style="max-height: 50px" alt=""><br>
                                        <label class="tx-bold mg-t-10" style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;"><?php echo $datosOrden['nombreViajeConductor']  . ", " . $datosOrden['dniViajeConductor']; ?></label>
                                    </div>
                                </div>


                            <?php }
                            ?>

                            <div class="mg-t-20" style="text-align: center;font-size: 10px;line-height: 1;">
                                <?php echo $jsonDatos['AGENCIA_NOMBRE'] . " " . $jsonDatos['AGENCIA_DIRECCION'] . "," . $jsonDatos['AGENCIA_CP'] . "," . $jsonDatos['AGENCIA_POBLACION'] . "," . $jsonDatos['AGENCIA_PROVINCIA'] ?><br>
                                Tel.: <?php echo $jsonDatos['AGENCIA_TELEFONO'] ?> Email: <?php echo $jsonDatos['AGENCIA_EMAIL'] ?><br>
                                Registro Mercantil de Valencia Tomo 2986 General 302 de la Secc. General del Libro de Sociedades Folio 58. Hoja nº V-4381. N.I.F.: B46828158<br><br>
                                <b style="font-size: 7px;">
                                    Los datos recogidos en esta Orden de Transporte son totalmente confidenciales y su único propósito es su uso autorizado. En cumplimiento de la normativa de Protección de Datos Personales, informamos que estos datos son
                                    tratados por LEADER TRANSPORT S.L. para cumplir con los servicios solicitados y con las obligaciones que hubiera demandado. Puede ejercer los derechos reconocidos en dicha normativa, enviando solicitud a nuestra
                                    dirección arriba indicada o mediante correo a e-patricia@congimbar.com adjuntando copia de su documento de identidad. Puede solicitar más información, sobre cómo tratamos sus datos, dirigiéndose a la dirección de
                                    correo arriba mencionada.
                                </b>
                            </div>
                        </footer>


                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->


                    <?php } else if ($tipoOrdenTransporte == 'M') { ?>

                        <!-- ============================================================== -->
                        <!-- CONTENIDO ORDEN DE TRANSPORTE M -->
                        <!-- ============================================================== -->
                        <?php
                        function insertHeader($jsonDatos)
                        {
                            echo '
                                    <header>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-6 text-center tx-20">
                                                <img src="../../public/assets/images/leadertransport.png" width="50%" height="50%" alt="Leader Transport s.l." class="img-fluid">
                                            </div>
                                            <div class="col-6">
                                                <h3 class="tx-bold tx-30">ORDEN DE CARGA</h3>
                                                <h4 class="tx-bold tx-26">Nº ' . $jsonDatos['TTE_ORDEN'] . '</h4>
                                            </div>
                                        </div>
                                        <div class="row mt-4 tx-16 lineaInferior">
                                            <div class="col-5 text-left tx-10">
                                                <label>
                                                    ' . $jsonDatos['AGENCIA_DIRECCION'] . ', ' . $jsonDatos['AGENCIA_CP'] . ', ' . $jsonDatos['AGENCIA_POBLACION'] . ', ' . $jsonDatos['AGENCIA_PROVINCIA'] . '<br>
                                                    TEL: ' . $jsonDatos['AGENCIA_TELEFONO'] . '<br>
                                                    EMAIL: ' . $jsonDatos['AGENCIA_EMAIL'] . '<br>
                                                    NIF: ' . $jsonDatos['AGENCIA_CIF'] . '
                                                </label>
                                            </div>
                                            <div class="col-6 text-right">
                                                <span class="pagenum"></span>
                                            </div>
                                        </div>
                                        <div class="row mt-4 text-left tx-14" style="line-height: 8px">
                                            <div class="col-6">
                                                <p>Transportista: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_NOMBRE'] . '</span></p>
                                                <p>Dirección: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_DIRECCION'] . '</span></p>
                                                <p>Conductor: <span style="font-weight: normal">' . $jsonDatos['CONDUCTOR_NOMBRE'] . '</span></p>
                                                <p>Matrícula: <span style="font-weight: normal">' . $jsonDatos['TRACTORA'] . '</span></p>
                                                <p>Precio acordado: <span style="font-weight: normal"></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Transportista: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_NIF'] . '</span></p>
                                                <p>Población: <span style="font-weight: normal">' . $jsonDatos['TRANSPORTISTA_POBLACION'] . '</span></p>
                                                <p>Identificación Conductor: <span style="font-weight: normal">' . $jsonDatos['CONDUCTOR_NIF'] . '</span></p>
                                                <p>Plataforma: <span style="font-weight: normal">' . $jsonDatos['PLATAFORMA'] . '</span></p>
                                                <p>Tipo Plataforma: <span style="font-weight: normal">' . $jsonDatos['PLATAFORMA_TIPO'] . '</span></p>
                                            </div>
                                        </div>
                                    </header>';
                        }

                        insertHeader($jsonDatos);
                        ?>


                        <div id="contenido">

                            <div class="col-12">
                                <p>LA PLATAFORMA SE RECOGE EN: <span style="font-weight: normal"><?php echo $jsonDatos['LUGAR_COMIENZO_NOMBRE']; ?></span></p>
                            </div>
                            <hr style="line-height: 8px">

                            <?php

                            $contador = 0; // SALTO DE PAGINA
                            echo "<div class='page'>";
                            foreach ($datosViajesBD as $viaje) {
                                $viajeJson = json_decode($viaje['jsonOrdenTransporte'], true);
                                // Cada 3 bloques, añadir un "page-break" y un espacio
                                if ($contador == 2) {
                                    echo "</div>";
                                    echo '<div class="page-break"></div>';

                                    insertHeader($jsonDatos);
                                    echo "<div class='page'>";
                                    $contador = 0;
                                }

                                if ($viaje['tipoViaje'] == 'CARGA') {

                            ?>


                                    <div class="row bloqueOrden">
                                        <label class="bold col-12 tx-center">LUGARES DE CARGA 📥</label>

                                    </div>
                                    <div class="row mt-4 text-left tx-16 lineaInferiorDash bloqueOrden" style="line-height: 8px">
                                        <div class="col-12 row">
                                            <div class="col-6">
                                                <p>Empresa: <span style="font-weight: normal"><?php echo $viaje['LUGAR_NOMBRE']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Población: <span style="font-weight: normal"><?php echo $viaje['LUGAR_POBLACION']; ?></span></p>
                                            </div>
                                            <div class="col-12">
                                                <p>Dirección: <span style="font-weight: normal"><?php echo $viaje['LUGAR_DIRECCION']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Teléfono: <span style="font-weight: normal"><?php echo $viaje['LUGAR_TELEFONO']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>C.P./PAIS: <span style="font-weight: normal"><?php echo $viaje['LUGAR_CP']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Fecha: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_FECHA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Hora: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_HORA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Mercancia: <span style="font-weight: normal"><?php echo $jsonDatos['MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Ref. carga: <span style="font-weight: normal"><?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Cliente: <img src="<?php echo $viaje["FirmaViajeReceptor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Cliente: <br><br><label><?php echo $viaje["nombreViajeReceptor"] . ", " . $viaje["dniViajeReceptor"]; ?></label></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Transportista: <img src="<?php echo $viaje["FirmaViajeConductor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Transportista: <br><br><label><?php echo $viaje["nombreViajeConductor"] . ", " . $viaje["dniViajeConductor"]; ?></label></p>
                                            </div>

                                        </div>
                                    </div>

                                <?php
                                } else {
                                ?>

                                    <div class="row bloqueOrden">
                                        <label class="bold col-12 tx-center">LUGARES DE DESCARGA 📤</label>
                                    </div>
                                    <div class="row mt-4 text-left tx-16 lineaInferiorDash bloqueOrden" style="line-height: 8px">
                                        <div class="col-12 row">
                                            <div class="col-6">
                                                <p>Empresa: <span style="font-weight: normal"><?php echo $viaje['LUGAR_NOMBRE']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Población: <span style="font-weight: normal"><?php echo $viaje['LUGAR_POBLACION']; ?></span></p>
                                            </div>
                                            <div class="col-12">
                                                <p>Dirección: <span style="font-weight: normal"><?php echo $viaje['LUGAR_DIRECCION']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Teléfono: <span style="font-weight: normal"><?php echo $viaje['LUGAR_TELEFONO']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>C.P./PAIS: <span style="font-weight: normal"><?php echo $viaje['LUGAR_CP']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Fecha: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_FECHA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Hora: <span style="font-weight: normal"><?php //echo $jsonDatos['TTE_HORA_CARGA']; 
                                                                                            ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Mercancia: <span style="font-weight: normal"><?php echo $jsonDatos['MERCANCIA']; ?></span></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Ref. carga: <span style="font-weight: normal"><?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?></span></p>

                                            </div>
                                            <div class="col-6">
                                                <p>Firma Cliente: <img src="<?php echo $viaje["FirmaViajeReceptor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Cliente: <br><br><label><?php echo $viaje["nombreViajeReceptor"] . ", " . $viaje["dniViajeReceptor"]; ?></label></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Firma Transportista: <img src="<?php echo $viaje["FirmaViajeConductor"]; ?>" style="max-height: 50px" alt=""></p>
                                            </div>
                                            <div class="col-6">
                                                <p>Identificación Transportista: <br><br><label><?php echo $viaje["nombreViajeConductor"] . ", " . $viaje["dniViajeConductor"]; ?></label></p>
                                            </div>

                                        </div>
                                    </div>

                            <?php
                                }
                                $contador++;
                            }
                            echo "</div>";
                            ?>

                            <div class="col-12 mg-10">
                                <p>LA PLATAFORMA SE DEJA EN: <span style="font-weight: normal"><?php echo $jsonDatos['LUGAR_FIN_NOMBRE']; ?></span></p>
                <p>Precio acordado: <span style="font-weight: normal"><?php echo (isset($jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE']) && !empty($jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE'])) ? $jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE'] . ' €' : ''; ?></span></p>
                        <footer <?php if ($tipoDocumento != "E") { ?> style="height:4cm" <?php } ?>>
                            <?php
                            if ($tipoDocumento == "E") { ?>

                                <div class="row">
                                    <div class="col-4 bd" style="height: 110px; position: relative;">
                                        <label class="tx-bold">FIRMA Y SELLO CLIENTE</label><br>
                                        <img src="<?php echo $datosOrden['firmaCliente']; ?>" style="max-height: 50px" alt=""><br>
                                        <label class="tx-bold mg-t-10" style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;"><?php echo $datosOrden['nombreCliente']  . ", " . $datosOrden['dniCliente']; ?></label>
                                    </div>
                                    <div class="col-4"><label class="tx-bold"></label></div>
                                    <div class="col-4 bd" style="height: 110px; position: relative;">
                                        <label class="tx-bold">FIRMA Y SELLO TRANSPORTISTA</label><br>
                                        <img src="<?php echo $datosOrden['FirmaViajeConductor']; ?>" style="max-height: 50px" alt=""><br>
                                        <label class="tx-bold mg-t-10" style="position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;"><?php echo $datosOrden['nombreViajeConductor']  . ", " . $datosOrden['dniViajeConductor']; ?></label>
                                    </div>
                                </div>

                            <?php }
                            ?>
                            <div class="mg-t-20" style="text-align: center;font-size: 10px;line-height: 1;">
                                <?php echo $jsonDatos['AGENCIA_NOMBRE'] . " " . $jsonDatos['AGENCIA_DIRECCION'] . "," . $jsonDatos['AGENCIA_CP'] . "," . $jsonDatos['AGENCIA_POBLACION'] . "," . $jsonDatos['AGENCIA_PROVINCIA'] ?><br>
                                Tel.: <?php echo $jsonDatos['AGENCIA_TELEFONO'] ?> Email: <?php echo $jsonDatos['AGENCIA_EMAIL'] ?><br>
                                Registro Mercantil de Valencia Tomo 2986 General 302 de la Secc. General del Libro de Sociedades Folio 58. Hoja nº V-4381. N.I.F.: B46828158<br><br>
                                <b style="font-size: 7px;">
                                    Los datos recogidos en esta Orden de Transporte son totalmente confidenciales y su único propósito es su uso autorizado. En cumplimiento de la normativa de Protección de Datos Personales, informamos que estos datos son
                                    tratados por LEADER TRANSPORT S.L. para cumplir con los servicios solicitados y con las obligaciones que hubiera demandado. Puede ejercer los derechos reconocidos en dicha normativa, enviando solicitud a nuestra
                                    dirección arriba indicada o mediante correo a e-patricia@congimbar.com adjuntando copia de su documento de identidad. Puede solicitar más información, sobre cómo tratamos sus datos, dirigiéndose a la dirección de
                                    correo arriba mencionada.
                                </b>
                            </div>
                        </footer>


                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->




                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->

                <?php }
                } ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>


        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->

    <?php include_once '../../config/templates/mainJs.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.min.js"></script>

    <script src="./firma/jquery.signaturepad.js"></script>
    <script src="./firma/assets/numeric-1.2.6.min.js"></script>
    <script src="./firma/assets/bezier.js"></script>
    <script>
        // GENERAR QR //
        $(document).ready(function() {
            var qrCode = new QRCodeStyling({
                width: 150,
                height: 150,
                dotsOptions: {
                    color: "#000000",
                    type: "rounded",
                },
                backgroundOptions: {
                    color: "#E9EDF3",
                },
                imageOptions: {
                    crossOrigin: "anonymous", // Asegúrate de que la imagen esté configurada correctamente para CORS
                    margin: 5, // Reduce este valor para hacer el ícono más grande
                },
            });

            var inputText = $('#primerCodigo').val(); // Recoger el valor del input
            console.log(inputText);
            $("#qrcode").empty(); // Limpiar cualquier código QR existente

            // Validar que el texto no esté vacío
            if (inputText.trim() === "") {

                /*         alert("Please enter some text to generate the QR code.");
                 */
                return;
            }


            // Actualizar el texto del código QR
            qrCode.update({
                data: inputText,
                image: "logoLeader.png", // Asegúrate de que esta URL sea accesible
            });

            // Adjuntar el código QR al div
            qrCode.append(document.getElementById("qrcode"));

            /* setTimeout(function(){
                printar()
            }, 100); */
            if ($("#inputAduana").val() == "") {
                $("#inputAduana").css("height", "0px");
            }
        });

        // Esperar a que la ventana cargue completamente antes de imprimir
        /*  function printar(){
             setTimeout(function(){
                 window.close();
              }, 3000);
         }  */

        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('.form-control-input-textarea');

            textareas.forEach(textarea => {
                // Ajuste inicial si el textarea ya tiene contenido al cargar la página
                autoResize.call(textarea);

                // Ajuste al escribir en el textarea
                textarea.addEventListener('input', autoResize);
            });

            function autoResize() {
                this.style.height = 'auto'; // Resetea la altura
                this.style.height = this.scrollHeight + 'px'; // Ajusta la altura según el contenido
            }
        });

        window.addEventListener('beforeprint', function() {
            const textareas = document.querySelectorAll('.form-control-input-textarea');
            const labels = document.querySelectorAll('.print-label');

            textareas.forEach((textarea, index) => {
                labels[index].textContent = textarea.value; // Copia el contenido del textarea al label
            });
        });


        // Cerrar la ventana después de 2 segundos (2000 milisegundos)
        setTimeout(function() {

            // Activar el modal de impresión automáticamente
            window.print();
            window.close();
        }, 1000);


        /* 
                function imprimirPagina() {
                    if (typeof window.print === 'function') {
                        console.log("window.print() is supported.");
                        window.print();
                    } else {
                        console.log("window.print() is not supported by this browser.");
                        alert("La función de impresión no es soportada por su navegador.");
                    }
                }

                function abrirEnChrome() {
                    var userAgent = navigator.userAgent.toLowerCase();
                    var isChrome = /chrome/.test(userAgent) && !/edge|edg|opr/.test(userAgent);

                    if (isChrome) {
                        imprimirPagina();
                    } else {
                        alert("Para una mejor experiencia, por favor abra este enlace en Google Chrome.");
                        window.location.href = "https://www.google.com/chrome/";
                    }
                } */



        /*  function updatePageNumbers() {
             var totalPages = $('.page').length;
             $('.page').each(function(index){
                 var pageNum = index + 1;
                 $(this).closest('body').find('header .pagenum').text('Página ' + pageNum + ' de ' + totalPages);
             });
         }

         $(window).on('beforeprint', function(){$('.pagenum').each(function(index) {

                $(this).text(index + 1);
            });

            $('#header, #footer').hide();
         });

         // Inicialmente actualizar los números de página
         updatePageNumbers(); */


        $('.pagenum').each(function(index) {

            $(this).text("Página " + (parseInt(index) + 1) + " de " + $('.pagenum').length);
        });
    </script>

    </script>

</body>

</html>