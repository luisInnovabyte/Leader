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
                        <li class="breadcrumb-item active" aria-current="page">Control de Archivos Procesados</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                <h4 class="card-title">Control de Archivos Procesados - Sistema ERP de Leader Transport</h4>
                    <h6 class="card-subtitle">Esta sección está dedicada para consultar los archivos procesados por el sistema de ORDENES. 
                        Seleccione una carpeta de proceso para visualizar sus archivos JSON.</h6> <br><br>

                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <div class="col-12 ">
                           
                            <div class="card text-center">
                                <div class="card-header">
                                    
                                </div>
                                        <div class="card-body ">
                                            <h4 class="card-title">Carpetas de Archivos Procesados</h4>
                                            <p class="card-text">Seleccione una carpeta de proceso para visualizar los archivos JSON que contiene</p>
                                    
                                    

                                            <div class="d-flex justify-content-center mb-3">
                                                <select class="form-control" id="select2-carpeta-procesados" style="width: 550px;height: 36px;">
                                                    <option value="" selected="selected">Seleccione una carpeta...</option>
                                                    <?php
                                                    $directorioProcesados = '../Ordenes/descargas_procesados/';
                                                    if (is_dir($directorioProcesados)) {
                                                        $carpetas = glob($directorioProcesados . '*', GLOB_ONLYDIR);
                                                        // Ordenar carpetas por fecha de modificación descendente (más reciente primero)
                                                        usort($carpetas, function($a, $b) {
                                                            return filemtime($b) - filemtime($a);
                                                        });
                                                        
                                                        foreach ($carpetas as $carpeta) {
                                                            $basename = basename($carpeta);
                                                            // Excluir la carpeta control_procesados
                                                            if ($basename !== 'control_procesados') {
                                                                $fechaCarpeta = filemtime($carpeta);
                                                                $fechaFormateada = date('d/m/Y H:i:s', $fechaCarpeta);
                                                                echo "<option value='" . $basename . "'>" . $basename . " - " . $fechaFormateada . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>     
                                            </div>

                                            <!-- Select para archivos JSON dentro de la carpeta seleccionada -->
                                            <div id="contenedor-archivos" class="d-flex justify-content-center" style="display: none;">
                                                <select class="form-control" id="select2-archivo-procesado" style="width: 550px;height: 36px;">
                                                    <option value="" selected="selected">Seleccione un archivo JSON...</option>
                                                </select>     
                                            </div>

                                    </div>
                            <div class="card-footer text-muted">
                               
                            </div>
                        </div>
                        <!-- Card -->
                    </div>
                                                         
                    <div id="contenidoJSON" class="mt-4" style="display: none;">
                        <!-- DataTable para mostrar el contenido del archivo -->
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">📋 Detalle del Archivo Procesado</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla-control-procesado" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>📄 Nombre Archivo</th>
                                                <th>✅ Procesado</th>
                                                <th>⚠️ Errores</th>
                                                <th>📋 Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-control-procesado">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>📄 Nombre Archivo</th>
                                                <th>✅ Procesado</th>
                                                <th>⚠️ Errores</th>
                                                <th>📋 Detalles</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
    
    <script src="controlProcesados.js"></script>
    <!--end plugins extra-->



</body>

</html>
