<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>

    <?php checkAccess(['0','1']);

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/Transportes.php");

    $transporte = new Transporte();
    $idTokenCifrada = $_GET['orden'];
 
    $datosTransporte = $transporte->recogerOrdenToken($idTokenCifrada);

    $datosViajes = $transporte->recogerViajesxOrden($datosTransporte['idOrden']); 

    ?>
      <style>
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


        /* BOTTON NUEVO TICKET  */

        .buttonNewTicket {
            --color: #01C0C8;
            padding: 0.8em 1.7em;
            background-color: transparent;
            border-radius: .3em;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: .5s;
            font-weight: 400;
            font-size: 17px;
            border: 1px solid;
            font-family: inherit;
            text-transform: uppercase;
            color: var(--color);
            z-index: 1;

        }

        /** BUTTON **/
        .buttonNewTicket::before,
        .buttonNewTicket::after {
            content: '';
            display: block;
            width: 50px;
            height: 50px;
            transform: translate(-50%, -50%);
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            background-color: var(--color);
            transition: 1s ease;
        }
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
        .img-bordered {
            box-shadow: 0 0 0 1px #ccc; /* Sombra que simula un borde */
            padding: 5px; /* Espacio entre la imagen y la sombra */
            border-radius: 5px; /* Bordes redondeados */
        }
        .buttonNewTicket::before {
            top: -1em;
            left: -1em;
        }

        .buttonNewTicket::after {
            left: calc(100% + 1em);
            top: calc(100% + 1em);
        }

        .buttonNewTicket:hover::before,
        .buttonNewTicket:hover::after {
            height: 410px;
            width: 410px;
        }

        .buttonNewTicket:hover {
            color: rgb(10, 25, 30);
            color: white;
        }

        .buttonNewTicket:active {
            filter: brightness(.8);
        }
    </style>
    <?php
    date_default_timezone_set('Europe/Madrid');
    $fecha_europa = date('H:i d-m-Y');
    ?>
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

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Transportes</li>
                        <li class="breadcrumb-item active" aria-current="page">Incidencias</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
          

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                <input type="hidden" id="idOrdenToken" value="<?php echo $_GET['orden']; ?>">
                <input type="hidden" id="idOrden" value="<?php echo $datosTransporte['num_transporte'] ?>">
                    <h2 class="card-title"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffec00" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 9v4" />
                                        <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                                        <path d="M12 16h.01" />
                                    </svg> Incidencia de la orden <?php echo $datosTransporte['num_transporte'] ?></h2>
                    <div class="my-3 border-top"></div>
                    <div>
                        <h6 class="card-subtitle">En esta sección, podrás consultar las incidencias reportadas y también informar sobre nuevas incidencias.</h6>
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card radius-10">
                                <div class="card-body p-0">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Mostrar Leyenda
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-primary waves-effect tx-12-force col-12 col-lg-1">Agregar</button>
                                                    <label class="mg-l-10 col-12 col-lg-10 mg-t-10-force mg-lg-t-0-force"> Al presionar este botón se empezará el proceso para <label class="fw-bold">agregar</label> una nueva opción a la aplicación, esto permitirá tener diferentes opciones.</label>
                                                </div>

                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-info waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-edit"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force"> Con este botón podrás <label class="fw-bold">editar</label> la información de la opción seleccionada.</label>
                                                </div>

                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-success waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-check"></i></button> 
                                                    <button class="btn btn-danger waves-effect tx-12-force col-12 col-lg-1 mg-lg-l-10 mg-lg-t-0-force mg-l-0 mg-t-10-force"><i class="fa-solid fa-xmark"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-8  mg-t-10-force mg-lg-t-0-force"> Con estos botones podrás <label class="fw-bold tx-success">activar</label> / <label class="fw-bold tx-danger">desactivar</label> las opciones, <label class="fw-bold tx-success">permitiendo</label> / <label class="fw-bold tx-danger">denegando</label> su <label class="fw-bold">uso en apartados de la aplicación</label>.</label>
                                                </div>
                                                <div class="accordion-body row d-flex align-items-center">
                                                    <button class="btn btn-primary btn-icon waves-effect tx-12-force col-12 col-lg-1"><i class="fa-solid fa-eye"></i></button>
                                                    <label class="mg-l-10 col-12 col-lg-10  mg-t-10-force mg-lg-t-0-force"> Te mostrara una ventana con <label class="fw-bold">información adicional</label> de la opción seleccionada.</label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row  d-flex justify-content-center mg-b-20">
                            <div class="col-sm-2 col-md-2 col-lg-2 align-items-center ">
                                <div class="text-center">
                                    <button id="btnNewTicket" data-bs-toggle="modal" data-bs-target="#modalAgregarIncidencia" class="buttonNewTicket"> Nueva Incidencia</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <?php include_once '../../config/modalAyudas/filtroActivo.php' ?>

                            <div class="row">

                                <div class="table-responsive">
                                <?php

                                    $nombreTabla = "incidencia_table";
                                    $nombreCampos = ["SITUACIÓN", "REPORTANTE", "FECHA", "CONSULTAR"];
                                    $nombreCamposFooter = ["SITUACIÓN", "REPORTANTE", "FECHA", "CONSULTAR"];
                                    $cantidadGrupos = 0; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                                    $columGrupos = [5]; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                                    $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                                    $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                                    $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                                    $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                                    $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                                    echo $tablaHTML;
                                ?>
                                    
                                    
                                </div>
                            </div>
                            <a href="ordenTransporte?orden=<?php echo $idTokenCifrada; ?>"><button type='button' class='btn btn-secondary'>Volver a la orden</button></a>

                        </div>
                    </div>

                   
                </div>
                
            </div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    <!--end main content-->


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

    <!-- Search Modal -->
    <?php include_once 'modalAgregarIncidencia.php' ?>
    <?php include_once 'modalIncidencia.php' ?>

    <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->



    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="index.js"></script>
    <!--end plugins extra-->



</body>

</html>
