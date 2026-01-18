<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<!-- ===================================== -->
<!--  ESTO ES LOQUE SE VE EN LAS PANTALLAS -->
<!-- ===================================== -->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <link href="./firma/assets/jquery.signaturepad.css" rel="stylesheet">

    <link rel="stylesheet" href="../../public/assets/plugins/notifications/css/lobibox.min.css">

    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['0', '1']);

    require_once("../../models/Transportes.php");

    $tokenOrden = $_GET['orden'];

    $transporte = new Transporte();

    $datosOrden = $transporte->recogerOrdenToken($tokenOrden);

    $tipoOrdenTransporte = $datosOrden['tipoOrdenTransporte'];

    $idOrden = $datosOrden['num_transporte'];

    $contenedorActivo = $datosOrden['contenedorActivo'];
    $hlodActivo = $datosOrden['precintoActivo'];

    $jsonDatos = json_decode($datosOrden['jsonOrdenTransporte'], true);

    $idOrdenTabla = $datosOrden['idOrden'];

    $datosViajes = $transporte->recogerViajesxOrden($idOrdenTabla);


    //***FIN JSON***


    ?>
    <!--end head-->

    <style>
        .slide-out-left {
            -webkit-animation: slide-out-left 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
            animation: slide-out-left 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
        }

        @-webkit-keyframes slide-out-left {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                -webkit-transform: translateX(-1000px);
                transform: translateX(-1000px);
                opacity: 0;
            }
        }

        @keyframes slide-out-left {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                -webkit-transform: translateX(-1000px);
                transform: translateX(-1000px);
                opacity: 0;
            }
        }

        .slide-in-right {
            -webkit-animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            animation: slide-in-right 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        @-webkit-keyframes slide-in-right {
            0% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-right {
            0% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-in-left {
            -webkit-animation: slide-in-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
            animation: slide-in-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        }

        @-webkit-keyframes slide-in-left {
            0% {
                -webkit-transform: translateX(-1000px);
                transform: translateX(-1000px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slide-in-left {
            0% {
                -webkit-transform: translateX(-1000px);
                transform: translateX(-1000px);
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }
        }

        .slide-out-right {
            -webkit-animation: slide-out-right 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
            animation: slide-out-right 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both;
        }

        @-webkit-keyframes slide-out-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0;
            }
        }

        @keyframes slide-out-right {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                -webkit-transform: translateX(1000px);
                transform: translateX(1000px);
                opacity: 0;
            }
        }

        @media (max-width: 992px) {
            .galery_d-none {
                display: none !important;
            }
        }

        /* Estilos para pantallas grandes */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* 5 columnas de igual tamaño */
            gap: 10px;
            /* Espacio entre las imágenes */
            justify-content: center;
        }

        .image-grid img {
            width: 100%;
            /* Las imágenes ocuparán todo el espacio disponible en sus celdas */
            height: auto;
            /* Mantener la proporción de las imágenes */
        }

        /* Estilos para pantallas menores a lg */
        @media (max-width: 1024px) {
            .image-grid {
                grid-template-columns: repeat(3, 1fr);
                /* 3 columnas de igual tamaño */
            }
        }

        @media (max-width: 768px) {
            .image-grid {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columnas de igual tamaño */
            }
        }

        @media (max-width: 480px) {
            .image-grid {
                grid-template-columns: repeat(2, 1fr);
                /* 2 columnas de igual tamaño */
            }
        }


        .hoverImage {
            transition: transform 0.3s ease;
        }

        .hoverImage:hover {
            transform: scale(1.1);
            /* Aumenta el tamaño de la imagen al pasar el ratón */
            z-index: 10;
            /* Asegúrate de que la imagen sobresalga por encima de otras */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Añade una sombra para destacar la imagen */
        }

        @media (max-width: 1024px) {
            .hoverImage:hover {
                transform: scale(1.2);
                /* 3 columnas de igual tamaño */
            }
        }

        @media (max-width: 768px) {
            .hoverImage:hover {
                transform: scale(1.2);
                /* 2 columnas de igual tamaño */
            }
        }

        @media (max-width: 480px) {
            .hoverImage:hover {
                transform: scale(1.2);
                /* 2 columnas de igual tamaño */
            }
        }

        /* Estilos generales */
        .galeria_inputfile {
            display: none;
        }

        .galeria_label {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            background-color: #0D6EFD;
            font-family: Arial, sans-serif;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .galeria_label:hover {
            background-color: #0D6EFD;
        }

        .galeria_label .fa-image {
            margin-right: 8px;
        }

        .galeria_span {
            vertical-align: middle;
        }

        .tx-25 {
            font-size: 25px;
        }

        .btn-icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100px;
            width: 125px;
            margin: 10px;
            text-align: center;
            font-size: 15px;
        }

        .btn-icon-text i {
            font-size: 12px;
            margin-bottom: 5px;
        }


        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }



        /*******************************/
        /* APARTADO BOTONES FLOTANTES */
        /*******************************/

        /************************************/
        /************************************/
        /************************************/
        .form-control-personalizado-static,
        label.form-control-personalizado-static {
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

        /************************************/
        /************** css FORM ************/
        /************************************/


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
            border: 1px solid #ced4da;
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

        .form-layout-2 .form-control-personalizado-label tx-bold,
        .form-layout-3 .form-control-personalizado-label tx-bold {
            margin-bottom: 8px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            display: block;
        }

        .form-layout-2 .form-control-personalizado,
        .form-layout-2 .dataTables_filter input,
        .dataTables_filter .form-layout-2 input,
        .form-layout-3 .form-control-personalizado,
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
        .form-layout-3 .form-control-personalizado,
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
            border: 1px solid #ced4da;
        }

        .form-layout-4 .form-control-personalizado-label tx-bold,
        .form-layout-5 .form-control-personalizado-label tx-bold {
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        /***** FORM LAYOUT 5 *****/
        @media (min-width: 576px) {
            .form-layout-5 .form-control-personalizado-label tx-bold {
                justify-content: flex-end;
            }
        }

        /***** FORM LAYOUT 6 & 7 *****/
        .form-layout-6 .row>div,
        .form-layout-7 .row>div {
            border: 1px solid #ced4da;
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

        .form-layout-6 .form-control-personalizado,
        .form-layout-6 .dataTables_filter input,
        .dataTables_filter .form-layout-6 input,
        .form-layout-7 .form-control-personalizado,
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

        .form-control-personalizado {
            display: inline !important;
        }



        .botonFlotante2 {
            top: 61px;

        }

        .botonFlotante3 {
            top: 121px;
        }

        .botonFlotante4 {
            top: 181px;
        }

        .botonFlotante5 {
            top: 472px;
        }

        .colorBoton1 {
            background: #c1c0a3 !important;
        }

        .colorBoton2 {
            background: #b2a3c1 !important;
        }

        .colorBoton3 {
            background: #a3c1be !important;
        }

        .colorBoton4 {
            background: #c1a7a7 !important;
        }

        .colorBoton5 {
            background: #aed581 !important;
        }

        .shadow-base {
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.21);
        }


        /** ORDEN DISEÑO */

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
            border-right: 2px solid #CED4DA;
        }

        .borde-gris-abajo {
            border-bottom: 2px solid #CED4DA;
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
            font-weight: 700 !important;


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

        .form-control-personalizado {
            white-space: pre-wrap !important;
        }

        .auto-width {
            width: auto !important;
        }

        label {
            margin-bottom: -0.5rem !important;
        }

        .tipo-letra {
            font-family: "Courier New", Courier, monospace;
        }

        /** FIRMA DIGITAL */
        fieldset {
            position: absolute;
            border: 5px solid #a3c1be;
            background: #aaa;
            right: 0px;
            bottom: 0px;
        }

        canvas {
            outline: 5px solid #a3c1be;
            background: #fff;
        }

        input[type=submit],
        input[type=reset] {
            font-size: larger;
        }

        .no-gutters {
            margin-right: 0;
            margin-left: 0;
        }

        /*QR*/
        /* Estilos para el contenedor del código QR */
        #qrcode {
            width: 200px;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }

        /* Asegurar que la imagen ocupe todo el espacio del contenedor */
        #qrcode img {
            width: 100% !important;
            height: 100% !important;
            max-width: 100%;
            max-height: 100%;
            padding: 0;
            margin: 0;
        }



        /* FORM PERSO */
        .form-control-perso {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
</head>



<body>

    <!--start mainHeader-->
    <?php include("../../config/templates/mainHeader.php"); ?>
    <!--end mainHeader-->


    <!--start sidebar-->
    <?php include("../../config/templates/mainSidebar.php"); ?>
    <!--end sidebar-->

    <!-- **************************************** -->
    <!--                BREADCUM                  -->
    <!-- **************************************** -->
    <!-- <span class="breadcrumb-item active">Mantenimiento</span> -->
    <!-- **************************************** -->
    <!--                FIN DEL BREADCUM                  -->
    <!-- **************************************** -->

    <!-- ***************************************************** -->
    <!--                CABECERA DE LA PAGINA                  -->
    <!-- ***************************************************** -->
    <input id="tokenId" value="<?php echo $tokenOrden; ?>" type="hidden">
    <input id="tipoOrdenTransporte" value="<?php echo $tipoOrdenTransporte; ?>" type="hidden">
    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Transportes</li>
                        <li class="breadcrumb-item active" aria-current="page">Ordenes de Transporte</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">


            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">Ordenes de Transporte</h2>
                    <div class="my-3 border-top"></div>
                    <div class="d-flex tx-bold justify-content-center">
                        <h4 class="tx-bold ">Nº&nbsp; </h4>
                        <h4 class="tx-bold tx-success"> <?php echo $idOrden ?></h4>
                        <input type="hidden" value="<?php echo $idOrden ?>" id="idOrden">
                    </div>
                </div>


                <!--============= MODO TRANSPORTE NORMAL=================-->
                <?php if ($tipoOrdenTransporte == 'C') { ?>
                    <!--==========================================================-->
                    <!--     CONTENIDO DE LA ORDEN   - TIPO C - SCREEN           --->
                    <!--==========================================================-->

                    <div class="row no-gutters " data-select2-id="31">
                        
                        <!-- ======================================= -->
                        <!--            PRIMER BLOQUE                -->
                        <!-- ======================================= -->
                        <div class="col-12 form-layout form-layout-2">
                            <div class="form-group col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="fCarga">F. Carga:</label>
                                        <label id="fCarga" class="form-control-personalizado tx-break text-reset"><?php echo FechaLocal($jsonDatos['TTE_FECHA_CARGA']); ?></label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="hora">Hora:</label>
                                        <label id="hora" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TTE_HORA_CARGA']; ?></label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="refConsig">Ref. Consig:</label>
                                        <!-- <label id="refConsig" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TTE_REF_CONSIG']; ?></label> -->
                                        <label id="refConsig" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?></label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="recEstimada">Recogida estimada:</label>
                                        <label id="recEstimada" class="form-control-personalizado tx-break text-reset"><?php echo FechaLocal($jsonDatos['TTE_FECHA_ESTIMADA_RECOGIDA']); ?></label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="entEstimada">Entrega estimada:</label>
                                        <label id="entEstimada" class="form-control-personalizado tx-break text-reset"><?php echo FechaLocal($jsonDatos['TTE_FECHA_ESTIMADA_ENTREGA']); ?></label>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-control-personalizado-label tx-bold" for="otAgencia">OT Agencia: </label>
                                        <label id="otAgencia" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TTE_ORDEN']; ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ======================================= -->
                        <!--            SEGUNDO BLOQUE                -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-12  row  mg-b-20">
                                        <div class="col-12 mg-b-5 mg-l-5 tx-center borde-gris-abajo">
                                            <label class="form-control-personalizado-label tx-bold" for="agente">Agente:</label>
                                            <label id="agente" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CONSIGNATARIO']; ?></label>
                                        </div>

                                        <div class="col-12 row">
                                            <div class="col-12 col-lg-6">
                                                <label class="form-control-personalizado-label tx-bold" for="cotenedores">Contenedores:</label>

                                                <div class="row ">

                                                    <?php if ($mostrarContPrecinto == 1) {
                                                    ?>
                                                        <div class="col-9 col-md-7 mg-l-10">
                                                            <input id="contenedor" class="form-control-perso tx-break text-reset " readonly value="<?php echo $contenedorActivo; ?>">
                                                        </div>
                                                        <div class="col-2 edicionModeOff">
                                                            <label class="tx-20 mg-5 " id="cambiarModoContenedor"><i class="tx-danger fa-solid fa-pencil"></i></label>
                                                        </div>
                                                        <div class="col-3 row d-none edicionModeOn">
                                                            <label class="tx-20 col-6" id="cancelarModoContenedor"><i class="tx-warning fa-solid  fa-xmark"></i></label>
                                                            <input type="hidden" id="idContenedorSave" value="<?php echo $contenedorActivo; ?>">
                                                            <label class="tx-20 col-6" id="guardarModoContenedor"><i class="tx-success fa-solid  fa-check"></i></label>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        // Verifica que la variable no esté vacía y tiene al menos un carácter
                                                        if (!empty($contenedorActivo) && strlen($contenedorActivo) > 1) {
                                                            // Inserta '/' antes del último carácter
                                                            $contenedorModificado = substr($contenedorActivo, 0, -1) . '/' . substr($contenedorActivo, -1);
                                                        } else {
                                                            // Si la variable está vacía o tiene solo un carácter, simplemente asigna el mismo valor
                                                            $contenedorModificado = $contenedorActivo;
                                                        }
                                                        // Muestra el valor modificado
                                                    ?>

                                                        <div class="col-9 col-md-7 mg-l-10">
                                                            <label id="contenedor" class="tx-12 form-control-personalizado tx-break text-reset"><?php echo $contenedorModificado; ?></label>
                                                        </div>
                                                    <?php
                                                    } ?>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-control-personalizado-label tx-bold" for="tipo">Tipo:</label>
                                                <label id="tipo" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TIPO_CONT_DESC'] . ' / ' . $jsonDatos['TIPO_CONT']; ?></label>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-control-personalizado-label tx-bold" for="hlog">Hlog Precintos:</label>
                                                <label id="hlog" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PRECINTO'] ?></label>
                                                <div class="row ">
                                                    <!-- <?php if ($mostrarContPrecinto == 1) {
                                                    ?>
                                                        <div class="col-9 col-md-7 mg-l-10">
                                                            <input id="hlogPrecinto" class="form-control-perso tx-break text-reset " readonly value="<?php echo $hlodActivo; ?>">
                                                        </div>
                                                        <div class="col-2 edicionModePrecintoOff">
                                                            <label class="tx-20 mg-5 " id="cambiarModoPrecinto"><i class="tx-danger fa-solid fa-pencil"></i></label>
                                                        </div>
                                                        <div class="col-3 row d-none edicionModePrecintoOn">
                                                            <label class="tx-20 col-6" id="cancelarModoPrecinto"><i class="tx-warning fa-solid  fa-xmark"></i></label>
                                                            <input type="hidden" id="idPrecintoSave" value="<?php echo $hlodActivo; ?>">
                                                            <label class="tx-20 col-6" id="guardarModoPrecinto"><i class="tx-success fa-solid  fa-check"></i></label>
                                                        </div>
                                                    <?php
                                                    } else {

                                                    ?>

                                                        <div class="col-9 col-md-7 mg-l-10">
                                                            <label id="hlogPrecinto" class="tx-12 form-control-personalizado tx-break text-reset"><?php echo $hlodActivo; ?></label>
                                                        </div>
                                                    <?php
                                                    } ?> -->


                                                </div>
                                                <label id="hlog" class="form-control-personalizado tx-break text-reset"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ======================================= -->
                                    <!--            SEGUNDO BLOQUE - 2.1         -->
                                    <!-- ======================================= -->
                                    <div class="col-12 row">
                                        <div class="col-12 row">
                                            <div class="col-12  col-sm-6">
                                                <label class="form-control-personalizado-label tx-bold" for="transportista">Transportista:</label>
                                                <label id="transportista" class="tx-12 form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_NOMBRE'] . '<br>' . $jsonDatos['TRANSPORTISTA_DIRECCION'] . ' <br>' . $jsonDatos['TRANSPORTISTA_CP'] . ' ' . $jsonDatos['TRANSPORTISTA_POBLACION'] . ' ' . $jsonDatos['TRANSPORTISTA_PROVINCIA'] . '<br>' . $jsonDatos['TRANSPORTISTA_NIF']; ?></label>

                                            </div>
                                            <div class="col-12  col-sm-6">
                                                <label class="form-control-personalizado-label tx-bold" for="conductor">Conductor:</label>
                                                <label id="conductor" class="tx-12 form-control-personalizado tx-break text-reset "><?php echo $jsonDatos['CONDUCTOR_NOMBRE'] . '<br>' . $jsonDatos['CONDUCTOR_NIF']; ?></label>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-control-personalizado-label tx-bold" for="cabeza">Cabeza:</label>
                                                <label id="cabeza" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRACTORA']; ?></label>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label class="form-control-personalizado-label tx-bold" for="cabeza">Plataforma:</label>
                                                <label id="cabeza" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PLATAFORMA']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--       FIN DEL SEGUNDO BLOQUE - 2.1      -->
                        <!-- ======================================= -->

                        <!-- ======================================= -->
                        <!--             TERCER BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row  mg-b-20">
                                        <div class="col-12 col-sm-6  mg-b-20 ">
                                            <label class="form-control-personalizado-label light-red tx-bold" for="retirar">RETIRAR DE:</label>
                                            <label id="retirarDe" class="form-control-personalizado tx-break text-reset"><?php echo '<br>' . $jsonDatos['RECOGER_EN_NOMBRE'] . '<br>' . $jsonDatos['RECOGER_EN_DIRECCION'] . ' <br>' . $jsonDatos['RECOGER_EN_CP'] . ' ' . $jsonDatos['RECOGER_EN_POBLACION'] . ' ' . $jsonDatos['RECOGER_EN_PROVINCIA']; ?></label>
                                        </div>
                                        <div class="col-12  col-sm-6   ">
                                            <label class="form-control-personalizado-label light-green tx-bold" for="retirar">ENTREGAR EN:</label>
                                            <label id="retirarDe" class="form-control-personalizado tx-break text-reset"><?php echo '<br>' . $jsonDatos['DEVOLVER_EN_NOMBRE'] . '<br>' . $jsonDatos['DEVOLVER_EN_DIRECCION'] . ' <br>' . $jsonDatos['DEVOLVER_EN_CP'] . ' ' . $jsonDatos['DEVOLVER_EN_POBLACION'] . ' ' . $jsonDatos['DEVOLVER_EN_PROVINCIA']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================== -->
                        <!--             FIN DE TERCER BLOQUE               -->
                        <!-- ============================================== -->


                        <!-- ======================================= -->
                        <!--             CUARTO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row  mg-b-20">
                                        <div class="col-12 mg-b-5 mg-l-5 tx-center borde-gris-abajo">
                                            <label class="form-control-personalizado-label tx-bold" for="mercancia">Mercancía:</label>
                                            <label id="mercancia" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['MERCANCIA']; ?></label>
                                        </div>
                                        <div class="col-6  mg-b-20">
                                            <label class="form-control-personalizado-label tx-bold" for="bultos">Bultos:</label>
                                            <label id="bultos" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['BULTOS']; ?></label>
                                        </div>
                                        <div class="col-6  mg-b-20">
                                            <label class="form-control-personalizado-label tx-bold" for="peso">Peso:</label>
                                            <label id="peso" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PESO_MERCANCIA']; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12  row  mg-b-20  d-flex justify-content-center">
                                        <div class="col-4 ">
                                            <label class="form-control-personalizado-label tx-bold" for="tempMax">Temp. Max:</label>
                                            <label id="tempMax" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TEMP_MAXIMA']; ?></label>

                                        </div>
                                        <div class="col-4 ">
                                            <label class="form-control-personalizado-label tx-bold" for="tempMin">Temp. Mín:</label>
                                            <label id="tempMin" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TEMP_MINIMA']; ?></label>

                                        </div>
                                        <div class="col-4 ">
                                            <label class="form-control-personalizado-label tx-bold" for="conectar">Conectar:</label>
                                            <label id="conectar" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TEMP_CONECTAR']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN CUARTO BLOQUE            -->
                        <!-- ======================================= -->


                        <!-- ======================================= -->
                        <!--             QUINTO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row  mg-b-20">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" scope="col">Ext. Der</th>
                                                        <th class="text-center" scope="col">Ext. Izq</th>
                                                        <th class="text-center" scope="col">Ext. Front</th>
                                                        <th class="text-center" scope="col">Ext. Tras</th>
                                                        <th class="text-center" scope="col">Ext. Altura</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center"><?php echo $jsonDatos['EXTRA_RIGHT']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['EXTRA_LEFT']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['EXTRA_FRONT']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['EXTRA_BACK']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['EXTRA_ALTO']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive  d-flex justify-content-center">
                                            <table class="table text-center tx-center">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" scope="col">Onu</th>
                                                        <th class="text-center" scope="col">Versión</th>
                                                        <th class="text-center" scope="col">IMDG</th>
                                                        <th class="text-center" scope="col">Clase</th>
                                                        <th class="text-center" scope="col">Notif Apv</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center"><?php echo $jsonDatos['IMO_ONU']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['IMO_VERSION']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['IMO_PAGINA']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['IMO_CLASE']; ?></td>
                                                        <td class="text-center"><?php echo $jsonDatos['IMO_PORT_NOTIFICATION']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN QUINTO BLOQUE            -->
                        <!-- ======================================= -->


                        <!-- ======================================= -->
                        <!--              SEXTO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row ">
                                        <div class="col-12 col-sm-6 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="linea">Línea:</label>
                                            <label id="linea" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['NOMBRELINEA_DEST']; ?></label>
                                        </div>
                                        <div class="col-12 col-sm-6  mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="escala">Nº Escala:</label>
                                            <label id="escala" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['ESCALA_DEST']; ?></label>
                                        </div>
                                        <div class="col-12 col-sm-6  mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="buque">Buque:</label>
                                            <label id="buque" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['BUQUE_DEST']; ?></label>
                                        </div>
                                        <div class="col-12 col-sm-6  mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="viaje">Viaje:</label>
                                            <label id="viaje" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['VIAJE']; ?></label>
                                        </div>
                                        <div class="col-12 col-sm-6  mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="viaje">Dist. Llamada:</label>
                                            <label id="viaje" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['DISTINTIVO_LLAMADA']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN SEXTO BLOQUE             -->
                        <!-- ======================================= -->



                        <!-- ======================================= -->
                        <!--            SEPTIMO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row ">
                                        <div class="col-6 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="origen">Origen:</label>
                                            <label id="origen" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PUERTO_ORIGEN_NOMBRE']; ?></label>
                                        </div>
                                        <div class="col-6 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="destino">Destino:</label>
                                            <label id="destino" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PUERTO_DESTINO_NOMBRE']; ?></label>
                                        </div>
                                        <div class="col-6 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="ptoDescarga">Pto. Des/Carga:</label>
                                            <label id="ptoDescarga" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PUERTO_DESCARGA_NOMBRE']; ?></label>
                                        </div>
                                        <div class="col-6 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="tipoOrden">Tipo Orden:</label>
                                            <label id="tipoOrden" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PUERTO_TIPO_ORDEN_IMPORTACION']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN SEPTIMO BLOQUE           -->
                        <!-- ======================================= -->


                        <!-- ======================================= -->
                        <!--             OCTAVO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group ">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12 row">
                                        <div class="col-12 mg-b-5 mg-l-5 tx-center borde-gris-abajo">
                                            <label class="form-control-personalizado-label tx-bold" for="refCarga">Ref Carga:</label>
                                            <label id="refCarga" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?></label>
                                        </div>
                                        <div class="col-12 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="pifAduana">Pif/Aduana:</label>
                                            <label id="pifAduana" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PIF_NOMBRE']; ?></label>
                                        </div>
                                        <div class="col-12 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="cargador">Cargador:</label>
                                            <label id="cargador" class="form-control-personalizado tx-break tx-12 text-reset"><?php echo '<br>' . $jsonDatos['CARGADOR_NOMBRE'] . '<br>' . $jsonDatos['CARGADOR_CIF'] . ' ' . $jsonDatos['CARGADOR_DIRECCION'] . '<br> ' . $jsonDatos['CARGADOR_POBLACION'] . ' ' . $jsonDatos['CARGADOR_PROVINCIA']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN OCTAVO BLOQUE           -->
                        <!-- ======================================= -->


                        <!-- ======================================= -->
                        <!--             NOVENO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-12  row ">
                                        <div class="col-12 mg-b-5 mg-l-5 tx-center borde-gris-abajo">
                                            <label class="form-control-personalizado-label tx-bold" for="lugaresCargaDescarga">Lugares Carga/Descarga</label>
                                            <label id="lugaresCargaDescarga" class="form-control-personalizado tx-break text-reset"></label>
                                        </div>
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="tx-bold" scope="col">Lugar</th>
                                                            <th class="tx-bold" scope="col">Dirección</th>
                                                            <th class="tx-bold" scope="col">CP</th>
                                                            <th class="tx-bold" scope="col">Población</th>
                                                            <th class="tx-bold" scope="col">Provincia</th>
                                                            <th class="tx-bold" scope="col">Teléfono</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($jsonDatos['LUGARES'] as $lugar) { ?>
                                                            <tr>
                                                                <td class=""><?php echo $lugar['LUGAR_NOMBRE']; ?></td>
                                                                <td class=""><?php echo $lugar['LUGAR_DIRECCION']; ?></td>
                                                                <td class=""><?php echo $lugar['LUGAR_CP']; ?></td>
                                                                <td class=""><?php echo $lugar['LUGAR_POBLACION']; ?></td>
                                                                <td class=""><?php echo $lugar['LUGAR_PROVINCIA']; ?></td>
                                                                <td class=""><?php echo $lugar['LUGAR_TELEFONO']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN NOVENO BLOQUE            -->
                        <!-- ======================================= -->


                        <!-- ======================================= -->
                        <!--             DECIMO BLOQUE               -->
                        <!-- ======================================= -->
                        <div class="col-12 mg-t-20 form-layout form-layout-2">
                            <div class="form-group ">
                                <div class="row  d-flex justify-content-center">
                                    <div class="col-12  row ">
                                        <div class="col-12 mg-b-5">
                                            <label class="form-control-personalizado-label tx-bold" for="obsOrden">Observaciones:</label>
                                            <label id="obsOrden" class="autoArea form-control-personalizado tx-break text-reset ">BOOKING Nº: <?php echo $jsonDatos['PCS_BOOKING_NUMBER'] . ' - ' . $jsonDatos['OBSERVACIONES']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ======================================= -->
                        <!--            FIN DECIMO BLOQUE           -->
                        <!-- ======================================= -->
                    </div>

                    <!--============= MODO TRANSPORTE TERRESTRE=================-->
                <?php } else if ($tipoOrdenTransporte == 'T') { ?>
                    <!--=========================================-->
                    <!--     CONTENIDO DE LA ORDEN              --->
                    <!--------------------------------------------->
                    <div class="row no-gutters " data-select2-id="31">

                        <div class="form-group col-12 mg-b-20">
                            <div class="row">

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="transportistaJson">TRANSPORTISTA:</label><br>
                                    <label id="transportistaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_NOMBRE']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="nifJson">NIF / DNI:</label><br>
                                    <label id="nifJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_NIF']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="direccionJson">DIRECCIÓN:</label><br>
                                    <label id="direccionJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_DIRECCION']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="poblacionJson">POBLACIÓN:</label><br>
                                    <label id="poblacionJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_POBLACION']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="conductorJson">CONDUCTOR:</label><br>
                                    <label id="conductorJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CONDUCTOR_NOMBRE']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="nifConductor">NIF / DNI: </label><br>
                                    <label id="nifConductor" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CONDUCTOR_NIF']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="matriculaJson">MATRICULA:</label><br>
                                    <label id="matriculaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRACTORA']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="plataformaJson">PLATAFORMA: </label><br>
                                    <label id="plataformaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PLATAFORMA_TIPO']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">

                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="tipoJson">Tipo Plataforma: </label><br>
                                    <label id="tipoJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TTE_ORDEN']; ?></label>
                                </div>
                            </div>
                        </div>

                        <!-- CARGAR VIAJES -->
                        <?php foreach ($datosViajes as $viaje) { ?>

                            <?php

                            if ($viaje['tipoViaje'] == 'CARGA') {
                                $colorBorde = 'border-info';
                            } else if ($viaje['tipoViaje'] == 'DESCARGA') {
                                $colorBorde = 'border-danger';
                            }

                            ?>

                            <div class="infoCard bg-light-grey card border-bottom border-0 border-4 shadow-sm <?php echo $colorBorde; ?>">
                                <div class="card-body text-center">


                                    <div class="row">

                                        <div class="col-12 d-flex justify-content-center">
                                            <label class="form-control-personalizado-label mg-b-20 tx-bold underline" for="tituloViaje">LUGARES DE <?php echo $viaje['tipoViaje']; ?></label><br>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="empresaViaje">EMPRESA</label><br>
                                            <label id="empresaViaje" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_NOMBRE']; ?></label>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="nifJson">POBLACIÓN</label><br>
                                            <label id="nifJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_POBLACION']; ?></label>
                                        </div>
                                        <hr>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="direccionJson">DIRECCIÓN:</label><br>
                                            <label id="direccionJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_DIRECCION']; ?></label>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="poblacionJson">CP / PAÍS:</label><br>
                                            <label id="poblacionJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_CP']; ?></label>
                                        </div>
                                        <hr>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="conductorJson">TELÉFONO:</label><br>
                                            <label id="conductorJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_TELEFONO']; ?></label>
                                        </div>


                                    </div>



                                </div>
                            </div>



                        <?php } ?>

                    </div>
                    <hr>
                    <!--============= MODO TRANSPORTE MULTIMODAL =================-->
                <?php } else if ($tipoOrdenTransporte == 'M') { ?>
                    <!--=========================================-->
                    <!--     CONTENIDO DE LA ORDEN              --->
                    <!--------------------------------------------->
                    <div class="row no-gutters " data-select2-id="31">

                        <div class="form-group col-12 mg-b-20">
                            <div class="row">

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="transportistaJson">TRANSPORTISTA:</label><br>
                                    <label id="transportistaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_NOMBRE']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="nifJson">NIF / DNI:</label><br>
                                    <label id="nifJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_NIF']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="direccionJson">DIRECCIÓN:</label><br>
                                    <label id="direccionJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_DIRECCION']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="poblacionJson">POBLACIÓN:</label><br>
                                    <label id="poblacionJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRANSPORTISTA_POBLACION']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="conductorJson">CONDUCTOR:</label><br>
                                    <label id="conductorJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CONDUCTOR_NOMBRE']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="nifConductor">NIF / DNI: </label><br>
                                    <label id="nifConductor" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CONDUCTOR_NIF']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="matriculaJson">MATRICULA:</label><br>
                                    <label id="matriculaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRACTORA']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="plataformaJson">PLATAFORMA: </label><br>
                                    <label id="plataformaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['PLATAFORMA_TIPO']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="matriculaJson">Nº PEDIDO CLIENTE:</label><br>
                                    <label id="matriculaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['TRACTORA']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="tipoJson">TIPO PLATAFORMA: </label><br>
                                    <label id="tipoJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['']; ?></label>
                                </div>
                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="matriculaJson">CLIENTE:</label><br>
                                    <label id="matriculaJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['']; ?></label>
                                </div>

                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold" for="nifJson">NIF: </label><br>
                                    <label id="nifJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['']; ?></label>
                                </div>

                                <hr>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold tx-success" for="plataformaserecogeJson">LA PLATAFORMA SE RECOGE EN:</label>
                                    <label id="plataformaserecogeJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['LUGAR_COMIENZO_NOMBRE']; ?></label>
                                </div>
                                <div class="col-6">
                                    <label class="form-control-personalizado-label tx-bold tx-danger" for="plataformaserecogeJson">LA PLATAFORMA SE DEJA EN:</label>
                                    <label id="plataformaserecogeJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['LUGAR_FIN_NOMBRE']; ?></label>
                                </div>

                                <hr>
                            <div class="col-12">
                                <label class="form-control-personalizado-label tx-bold" for="precioAcordadoJson">Precio acordado:</label>
                                <label id="precioAcordadoJson" class="form-control-personalizado tx-break text-reset"><?php echo (isset($jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE']) && !empty($jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE'])) ? $jsonDatos['LUGARES_DESCARGA'][0]['LUGAR_IMPORTE'] . ' €' : ''; ?></label>
                            </div>

                            <hr>
                        </div>
                    </div>

                    <!-- CARGAR VIAJES -->
                    <?php foreach ($datosViajes as $viaje) { ?>

                        <?php

                        if ($viaje['tipoViaje'] == 'CARGA') {
                            $colorBorde = 'border-info';
                        } else if ($viaje['tipoViaje'] == 'DESCARGA') {
                            $colorBorde = 'border-danger';
                        }

                        ?>

                            <div class="infoCard bg-light-grey card border-bottom border-0 border-4 shadow-sm <?php echo $colorBorde; ?>">
                                <div class="card-body text-center">


                                    <div class="row">

                                        <div class="col-12 d-flex justify-content-center">
                                            <label class="form-control-personalizado-label mg-b-20 tx-bold underline" for="tituloViaje">LUGARES DE <?php echo $viaje['tipoViaje']; ?></label><br>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="empresaViaje">EMPRESA</label><br>
                                            <label id="empresaViaje" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_NOMBRE']; ?></label>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="nifJson">POBLACIÓN</label><br>
                                            <label id="nifJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_POBLACION']; ?></label>
                                        </div>
                                        <hr>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="direccionJson">DIRECCIÓN:</label><br>
                                            <label id="direccionJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_DIRECCION']; ?></label>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="poblacionJson">CP / PAÍS:</label><br>
                                            <label id="poblacionJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_CP']; ?></label>
                                        </div>
                                        <hr>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="conductorJson">TELÉFONO:</label><br>
                                            <label id="conductorJson" class="form-control-personalizado tx-break text-reset"><?php echo $viaje['LUGAR_TELEFONO']; ?></label>
                                        </div>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="conductorJson">MERCANCIA:</label><br>
                                            <label id="conductorJson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['MERCANCIA']; ?></label>
                                        </div>
                                        <hr>

                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="fechajson">FECHA:</label><br>
                                            <label id="fechajson" class="form-control-personalizado tx-break text-reset"><?php echo FechaLocal($jsonDatos['TTE_FECHA_CARGA']); ?></label>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="horajson">HORA:</label><br>
                                            <label id="horajson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['MERCANCIA']; ?></label>
                                        </div>
                                        <hr>
                                        <div class="col-6">
                                            <label class="form-control-personalizado-label tx-bold" for="horajson">REF.CARGA:</label><br>
                                            <label id="horajson" class="form-control-personalizado tx-break text-reset"><?php echo $jsonDatos['CARGADOR_REF_CARGA']; ?></label>
                                        </div>
                                    </div>



                                </div>
                            </div>



                        <?php } ?>

                    </div>
                    <!--============= FIN MODO TRANSPORTE MULTIMODAL =================-->

                <?php } else { ?>


                    <h2 class="tx-danger parpadeo">Problema al localizar tipo de orden. Contacte con soporte.</h2>

                <?php } ?>
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->

                <div class="mg-5 mg-t-20 card border-info ">

                    <div class="mg-t-10 d-flex tx-bold justify-content-center">
                        <h3>Orden De Transporte</h3>
                    </div>
                    <!-- ============================================================== -->
                    <!-- CONTENIDO DE LA PÁGINA  -->
                    <!-- ============================================================== -->

                    <div class="mg-5 ">



                        <!---------------------------------------------------------------->
                        <!----------------------- FORMULARIO  ---------------------------->
                        <!---------------------------------------------------------------->

                        <div class="printableArea">


                            <!-- ============================================================== -->
                            <!-- CONTENIDO ORDEN DE TRANSPORTE -->
                            <!-- ============================================================== -->

                            <div class="">


                                <div class="row no-gutters " data-select2-id="31">

                                    <div class="col-12 ">

                                        <div class="form-group col-12">

                                            <div class="row mb-b-50">
                                                <div class="col-12">
                                                    <p class="tx-15" for="exampleFormControlSelect1">Viaje:</p>
                                                    <select class="form-control" id="selectViajes">
                                                        <option value="">Selecciona una opción</option>
                                                        <?php
                                                        // Recorremos los datos de los viajes y creamos las opciones
                                                        foreach ($datosViajes as $viaje) {
                                                            echo "<option value='{$viaje['idViaje']}'>{$viaje['LUGAR_NOMBRE']} - {$viaje['LUGAR_DIRECCION']} - {$viaje['tipoViaje']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row d-none insertarDatosViaje" id="insertarDatosViaje">
                                                <div class="col-12">
                                                    <p class="form-control-label  tx-bold mr-2 text-decoration-underline">Reflejen hora exacta de llegada y salida de sus intalaciones</p>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="dateopen" class="control-label col-form-label">Hora de Llegada</label>
                                                        <input id="fechaLlegada" type="datetime-local" class="datosViaje form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="datefixe" class="control-label col-form-label">Hora de Salida</label>
                                                        <input id="fechaSalida" type="datetime-local" class="datosViaje form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-12 mg-b-30">
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="control-label col-form-label">Observaciones</label><br>
                                                        <textarea class="wd-100p form-control datosViaje" id="ObservacionViaje" style=" max-inline-size: 100%;" placeholder="Escribe aquí las observaciones necesarias sobre la entrega"></textarea>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <input id="primerCodigo" type="hidden" value="<?php echo $jsonDatos['OA_PCS_LOCATOR']; ?>">
                                                <div class="col-sm-6 insertarDatosViaje d-none col-12 mg-t-10 mg-b-30">
                                                    <button type="button" onclick="" data-bs-toggle="modal" data-bs-target="#firma_modal" class="btn waves-effect  wd-100p tx-bold waves-light btn-block btn-info">Firmar Documento</button>
                                                </div>
                                                <div class="col-sm-6 col-12 mg-t-10 mg-b-30">
                                                    <button type="button" title="Consultar QR" data-bs-toggle="modal" id="generateQR" data-bs-target="#qr_modal" class="btn waves-effect tx-bold waves-light   wd-100p btn-block btn-success">Mostrar QR</button>
                                                </div>

                                            </div>


                                        </div>


                                    </div>


                                </div>


                                <!-- ============================================================== -->
                                <!-- ============================================================== -->
                                <!-- ============================================================== -->

                                <!-- ============================================================== -->
                                <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                                <!-- ============================================================== -->

                                <!---------------------------------------------------------------->
                                <!---------------------------------------------------------------->
                                <!---------------------------------------------------------------->

                            </div>
                            <!-- ============================================================== -->
                            <!-- End Container fluid  -->
                            <!-- ============================================================== -->



                        </div>
                        <!-- ============================================================== -->
                        <!-- End Page wrapper  -->
                        <!-- ============================================================== -->


                    </div>

                </div>

    </main>
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->
    <div class="d-none dropzone" id="dropzoneGesdoc"></div>


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>

    <!-- MODALS -->
    <?php include_once 'modalQr.php'; ?>

    <?php include_once 'modalFirma.php'; ?>
    <?php include_once 'modalAyuda.php'; ?>

    <?php include_once 'modalOrdenGesdoc.php'; ?>
    <?php include_once 'modalContenedor.php'; ?>
    <?php
    if ($tipoOrdenTransporte == "T" || $tipoOrdenTransporte == "M") {
        include_once 'modalTipoDocumentoExportTM.php';
    } else {
        include_once 'modalTipoDocumentoExport.php';
    }
    ?>


    <!----------------------------------------->
    <!----------------------------------------->
    <!----------------------------------------->
    <!----------------------------------------->
    <!----------------------------------------->

    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->
    <aside class="customizer botonFlotante1 ">
        <a href="incidencias?orden=<?php echo $tokenOrden; ?>" class="service-panel-toggle colorBoton1 tx-20">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </a>
    </aside>
    <?php if ($tipoOrdenTransporte == 'C') { ?>
        <aside class="customizer botonFlotante2">
            <a href="javascript:void(0)" title="Imprimir Documento" data-bs-toggle="modal" data-bs-target="#tipoDocumentoModal" class="service-panel-toggle colorBoton2 tx-20">
                <i class="fa-solid fa-print"></i>
            </a>
        </aside>
    <?php } else { ?>
        <aside class="customizer botonFlotante2">
            <a href="javascript:void(0)" title="Imprimir Documento" data-bs-toggle="modal" data-bs-target="#tipoDocumentoModal" class="service-panel-toggle colorBoton2 tx-20">
                <i class="fa-solid fa-print"></i>
            </a>
        </aside>
    <?php } ?>

    <aside class="customizer botonFlotante3">
        <a href="javascript:void(0)" class="service-panel-toggle colorBoton3 tx-20" data-bs-toggle="modal" data-bs-target="#modalOrdenGesdoc">
            <i class="fa-solid fa-cloud-arrow-up"></i>
        </a>
    </aside>

    <aside class="customizer botonFlotante4">
        <a href="./" class="service-panel-toggle colorBoton4  tx-20">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </aside>

    <aside class="customizer botonFlotante5">
        <a href="javascript:void(0)" title="Mostrar Ayuda" data-bs-toggle="modal" data-bs-target="#ayuda_modal" class="service-panel-toggle colorBoton5 tx-20">
            <i class="fa-solid fa-circle-question"></i>
        </a>
    </aside>

    <?php include("../../config/templates/searchModal.php"); ?>



    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->
    <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.6.0-rc.1/lib/qr-code-styling.min.js"></script>


    <script src="./firma/jquery.signaturepad.js"></script>
    <script src="./firma/assets/numeric-1.2.6.min.js"></script>
    <script src="./firma/assets/bezier.js"></script>

    <!-- IMPRESION -->
    <script>

    </script>
    <script src="./firma/assets/json2.min.js"></script>


    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>

    <!--notification js -->
    <script src="../../public/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="../../public/assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="../../public/assets/plugins/notifications/js/notification-custom-script.js"></script>


    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>