<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['1']);

    ?>
    <!--end head-->
   
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
                        <li class="breadcrumb-item" aria-current="page">Logs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-12 pageTitle mt-3">
                <div class="row">
                    <div class="col-1 wd-auto-force">
                        <i class="fa-solid fa-triangle-exclamation tx-50-force"></i>
                    </div>
                    <div class="col-10 d-flex align-items-center">
                        <div class="row">
                            <h4 class="col-12 tx-18">AVISOS GERENCIA</h4>
                            <p class="mb-0 col-12 tx-16"></p>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                <h4 class="card-title">Registro log's - Sistema ERP de Leader Transport</h4>
                    <h6 class="card-subtitle">Esta sección está dedicada para consultar los logs. Archivos que registran eventos y acciones en un sistema, proporcionando información para el análisis, diagnóstico y seguridad del mismo.</h6> <br><br>

                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <div class="col-12 ">
                           
                            <div class="card text-center">
                                <div class="card-header">
                                    
                                </div>
                                        <div class="card-body ">
                                            <h4 class="card-title">Gestión de Registros</h4>
                                            <p class="card-text">Seleccione un archivo de registro (log) para cargar la tabla</p>
                                    
                                    

                                            <div class="d-flex justify-content-center">
                                                <select class="form-control" id="select2-log" style="width: 20%;height: 36px;">
                                                    <option value="" selected="selected"></option>
                                                    <?php
                                                    foreach (glob('../../public/log/*.log') as $filename) {
                                                        $filename = basename($filename);
                                                        echo "<option value='" . $filename . "'>" . $filename . "</option>";
                                                    }
                                                    ?>
                                                </select>     
                                            </div>

                                    </div>
                            <div class="card-footer text-muted">
                               
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                                                         
                    <div>
                        
                   
                        <div  class="table-responsive d-none">
                            <?php
                          

                         

                            $nombreTabla = "log_table";
                            $nombreCampos = ["Nombre", "Pantalla", "Acción Realizada", "Fecha", "Hora"];
                            $nombreCamposFooter = ["Nombre", "Pantalla", "Acción Realizada", "Fecha", "Hora"];

                            $cantidadGrupos = 1; //* CANTIDAD DE AGRUPACIONES *// //=Valores 0 ~ 3==//
                            $columGrupos = []; //* COLUMNAS A AGRUPAR *// //=Poner el numero de la columna empezando a contar desde 0==//
                            $agrupacionesPersonalizadas = 0; //* MARCAR SI QUIERES REALIZAR EL DISEÑO DE LA AGRUPACION MANUAL O AUTOMATICA *// //= 0->Auto 1->Manual ==//
                            $colorHEX = "#3AB54A"; //* COLOR POR DEFECTO DE LAS AGRUPACIONES *// //= Color Hexadecimal #000000 ~ #FFFFFF ==//
                            $desplegado = 0; //* SI QUIERES QUE POR DEFECTO LAS AGRUPACIONES ESTEN PLEGADAS *// //= 0->DESPLEGADO 1->PLEGADO ==//
                            $colorPicker = 0; //* SI QUIERES MOSTRAR EL COLOR PICKER O NO *// //= 0->No 1->Si  ==//

                            $tablaHTML = generarTabla($nombreTabla, $nombreCampos, $nombreCamposFooter, $cantidadGrupos, $columGrupos, $agrupacionesPersonalizadas, $colorHEX, $desplegado, $colorPicker);
                            echo $tablaHTML;
                            
                            ?>
                    

                        </div>
                    </div>
                </div>
            </div>

    </main>


    <!--start overlay-->
    <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

   

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
    <!-- Propio de logs -->
 

    <script src="logIndex.js"></script>
    <!--end plugins extra-->



</body>

</html>