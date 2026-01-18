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
    <style>
        /* From Uiverse.io by PriyanshuGupta28 */
        .checkbox-wrapper:hover .check {
            stroke-dashoffset: 0;
        }

        .checkbox-wrapper {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 30px;
        }

        .checkbox-wrapper .background {
            fill: #0D6EFD;
            transition: ease all 0.6s;
            -webkit-transition: ease all 0.6s;
        }

        .checkbox-wrapper .stroke {
            fill: none;
            stroke: #fff;
            stroke-miterlimit: 10;
            stroke-width: 2px;
            stroke-dashoffset: 100;
            stroke-dasharray: 100;
            transition: ease all 0.6s;
            -webkit-transition: ease all 0.6s;
        }

        .checkbox-wrapper .check {
            fill: none;
            stroke: #fff;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-width: 2px;
            stroke-dashoffset: 22;
            stroke-dasharray: 22;
            transition: ease all 0.6s;
            -webkit-transition: ease all 0.6s;
        }

        .checkbox-wrapper input[type=checkbox] {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            margin: 0;
            opacity: 0;
            -appearance: none;
            -webkit-appearance: none;
        }

        .checkbox-wrapper input[type=checkbox]:hover {
            cursor: pointer;
        }

        .checkbox-wrapper input[type=checkbox]:checked+svg .background {
            fill: #0D6EFD;
        }

        .checkbox-wrapper input[type=checkbox]:checked+svg .stroke {
            stroke-dashoffset: 0;
        }

        .checkbox-wrapper input[type=checkbox]:checked+svg .check {
            stroke-dashoffset: 0;
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

    <!--start main content-->
    <main class="page-content">
        <div class="page-breadcrumb d-sm-flex align-items-center">
            <div class="breadcrumb-title pe-3"><a href="../../view/Home/index.php" class="text-reset">Inicio</a></div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item" aria-current="page">Configuración Correo</li>
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
                    <h2 class="card-title">Configurar Correos</h2>
                    <div class="my-3 border-top"></div>
                    <div class="row">

                        <div class="col-12 col-lg-12">
                            <label for="nombreTipo" class="form-label">Servidor de Hosting</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                <input type="text" value="<?php echo $smtp_host ?>" class="form-control" id="servHosting" name="servHosting" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mg-t-20">
                            <label for="nombreTipo" class="form-label">Usar SMTP</label>
                            <div class="checkbox-wrapper">
                                <input checked="<?php echo $smtp_auth ?>" value="<?php echo $smtp_auth ?>" type="checkbox" id="usarSMTP">
                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
                                </svg>
                            </div>




                        </div>
                        
                        <div class="col-12 col-lg-12 mg-t-20">
                            <label for="nombreTipo" class="form-label">Usuario</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                <input type="text" value="<?php echo $smtp_username ?>" class="form-control" id="userHosting" name="userHosting" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mg-t-20">
                            <label for="nombreTipo" class="form-label">Contraseña</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                <input type="password" value="<?php echo $smtp_pass ?>" class="form-control" id="passHosting" name="passHosting" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mg-t-20">
                            <label for="nombreTipo" class="form-label">Puerto</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                <input type="text" value="<?php echo $smtp_port ?>" class="form-control" id="puertoSMTP" name="puertoSMTP" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 mg-t-20">
                            <label for="nombreTipo" class="form-label">Receptor</label>
                            <div class="position-relative input-icon">
                                <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-caret-right"></i></span>
                                <input type="text" value="<?php echo $smtp_receptor ?>" class="form-control" id="emailReceptor" name="emailReceptor" placeholder="Nombre" data-type="3" data-min="3" data-max="100" data-new-input="1" data-descripcion="0" data-required="1">
                            </div>
                        </div>
                    </div>


                    <!-- End Row -->

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



    <script src="index.js"></script>


</body>

</html>