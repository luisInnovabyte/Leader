<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->
<?php 
session_start();

?>
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    
    <?php
    // Verifica si la variable de sesión 'superadmin' no está creada
    session_start();
    if (!isset($_SESSION['superadmin'])) {
        // Redirige a la página que desees cuando la variable de sesión no está creada
        // El usuario no tiene ninguno de los roles requeridos, se redirige a la página de login
        header('Location: ../../view/Login/index.php');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['usuario'])) {
            $_SESSION['usu_rol'] = '0';
        } elseif (isset($_POST['administrador'])) {
            $_SESSION['usu_rol'] = '1';
        }
    }

    ?>
    
    <!--end head-->
    <style>
        #accordionButton1.accordion-button:not(.collapsed) {
            background-color: var(--bs-cyan);
            color: var(--bs-black);
        }

        #accordionButton2.accordion-button:not(.collapsed) {
            background-color: var(--bs-orange);
            color: var(--bs-black);
        }
    </style>
</head>



<body>
    <input type="hidden" id="usuRol" value="<?php echo $_SESSION['usu_rol']; ?>">
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
                        <li class="breadcrumb-item active" aria-current="page">Ordenes de Transporte</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">SUPER ADMIN 🎭</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                       
                      
                        <div class="col-12">
                            
                            
                            <div class="card-body">
                                <div class="row">
                                    <div>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <h3>Cambiar Roles</h3>
                                            <button type="submit" class="btn btn-info waves-effect" name="usuario">USUARIO</button>
                                            <button type="submit"  class="btn btn-warning waves-effect" name="administrador">ADMIN</button>
                                        </form>
                                    </div>
                                </div><br>
                                <h3>Módulos</h3>
                                <div class="d-flex align-items-center gap-3 flex-wrap row">
                                    <div class="col-3">
                                        <div class="form-check form-switch ">
                                            <input class="form-check-input" type="checkbox" role="switch" id="gesdocModuloActivar" 
                                                <?php if ($gesdoc_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="gesdocModuloActivar">Gesdoc 🗂️</label>
                                        </div>
                                        <div class="form-check form-switch form-check-success">
                                            <input class="form-check-input" type="checkbox" role="switch" id="cmsModuloActivar" <?php if ($cms_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="cmsModuloActivar">CMS 💻</label>
                                        </div>
                                        <div class="form-check form-switch form-check-danger">
                                            <input class="form-check-input" type="checkbox" role="switch" id="inscripcionModuloActivar"  <?php if ($inscripciones_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="inscripcionModuloActivar">Inscripción 📋</label>
                                        </div>
                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check form-switch form-check-warning">
                                            <input class="form-check-input" type="checkbox" role="switch" id="facturacionModuloActivar"  <?php if ($facturacion_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="facturacionModuloActivar">Facturación 💰</label>
                                        </div>
                                        <div class="form-check form-switch form-check-dark">
                                            <input class="form-check-input" type="checkbox" role="switch" id="helpDeskModuloActivar"  <?php if ($helpdesk_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="helpDeskModuloActivar">HelpDesk 📬</label>
                                        </div>
                                        <div class="form-check form-switch form-check-secondary">
                                            <input class="form-check-input" type="checkbox" role="switch" id="transportesModuloActivar" <?php if ($transporte_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="transportesModuloActivar">Transportes 🚚</label>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check form-switch form-check-info">
                                            <input class="form-check-input" type="checkbox" role="switch" id="avisosModuloActivar" <?php if ($avisos_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="avisosModuloActivar">Avisos Laboral ⚠️</label>
                                        </div>
                                        <div class="form-check form-switch form-check-secondary">
                                            <input class="form-check-input" type="checkbox" role="switch" id="educacionModuloActivar" <?php if ($educacion_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="educacionModuloActivar">Educación 📚</label>
                                        </div>
                                        <div class="form-check form-switch form-check-info">
                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckInfo" <?php if ($avisos_m == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="flexSwitchCheckInfo"></label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
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
    <?php include_once 'modalAgregar.php' ?>
    <?php include_once 'modalEditar.php' ?>
    <?php include_once 'modalInformacion.php' ?>

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
    <script src="super.js"></script>
    <!--end plugins extra-->



</body>

</html>