<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../../config/templates/mainHead.php'; ?>

    <?php checkAccess(['1']); ?>

</head>

<body style="height:80vh">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php include_once '../../config/templates/mainPreloader.php'; ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->



    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <?php include_once '../../config/templates/mainLogo.php' ?>
                    <!-- ============================================================== -->
                    <!-- FIN Logo -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti-more"></i>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->

                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ================================================================================ -->
                    <!--PARTE SUPERIOR DESPUES DEL SIDEBAR (TRES LINEAS, CAJA DE REGALO, CAMPANA y SOBRE) -->
                    <!-- ================================================================================ -->
                    <?php include_once '../../config/templates/mainNavbar.php' ?>

                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once '../../config/templates/mainSidebar.php' ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- CABECERA DE LA PAGINA Y TITULO  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <!-- <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Gesdoc</h4>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="..\Home">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Gesdoc</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- ============================================================== -->
            <!-- FIN DE CABECERA DE LA PAGINA Y TITULO  -->
            <!-- ============================================================== -->


            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <!-- ============================================================== -->
                <!-- CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

                <div class="card-body">
                    <?php
                    $mostrarIframe = $_GET["personalizar"];

                    switch ($mostrarIframe) {
                        case "1":
                    ?>
                            <iframe src="../IframesPersonalizar/deliveredGoods.php" frameborder="0" style="width:100%;height:75vh"></iframe>
                        <?php

                        break;
                        case "2":
                        ?>
                            <iframe src="../IframesPersonalizar/digitalFreight.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "3":
                        ?>
                            <iframe src="../IframesPersonalizar/sliderHome.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "4":
                        ?>
                            <iframe src="../IframesPersonalizar/cases&Clients.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "5":
                        ?>
                            <iframe src="../IframesPersonalizar/globalLogistics.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "6":
                        ?>
                            <iframe src="../IframesPersonalizar/opinions.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "7":
                        ?>
                            <iframe src="../IframesPersonalizar/ubicacion.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "8":
                        ?>
                            <iframe src="../IframesPersonalizar/personalizarMenu.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "9":
                        ?>
                            <iframe src="../IframesPersonalizar/envio-por-carretera.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                        case "10":
                        ?>
                            <iframe src="../IframesPersonalizar/footer.php" frameborder="0" style="width:100%;height:125vh"></iframe>
                        <?php

                        break;
                    }

                    ?>





                </div>




                <!-- ============================================================== -->
                <!-- FIN DEL CONTENIDO DE LA PÁGINA  -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->


            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <?php include_once '../../config/templates/mainFooter.php' ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
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

    <div class="chat-windows"></div>


    <!-- SCRIPTS PERSONALIZADOS -->

    <?php include_once 'modalSubirDoc.php' ?>
    <?php include_once 'modalComentarios.php' ?>
    <!-- MODALS -->
    <?php //include_once 'modalAgregar.php' 
    ?>


    <?php include_once '../../config/templates/mainJs.php' ?>


    <script src="index.js"></script>

</body>

</html>