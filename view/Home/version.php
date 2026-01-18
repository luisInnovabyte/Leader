<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->
<?php 
session_start();

?>
<head>
    <?php include("../../config/templates/mainHead.php"); ?>
    
    <?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
    checkAccess(['0','1']);

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
    
        <link href="../../public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
 
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
                        <li class="breadcrumb-item" aria-current="page">Versiones</li>
                        <li class="breadcrumb-item active" aria-current="page">Control de Versiones</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">

                    <div class="row">
          

						<div class="">
						<div class="">
    <div class="container py-2">
        <h2 class="font-weight-light text-center text-muted py-3">
            Control de Versiones <i class="fa-solid fa-code-merge"></i>
        </h2>

        <?php
        // Definimos un array de meses en español
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        // Invertimos el array para mostrar las versiones de forma inversa
        $versiones_invertidas = array_reverse($versiones);

        // Iteramos sobre el array invertido
        foreach ($versiones_invertidas as $index => $version): 
            // Alternamos el color del punto y la tarjeta si es el primer ítem o los demás
            $is_first_item = ($index === 0);
            $badge_class = $is_first_item ? "bg-primary" : "bg-light border";
            $card_class = $is_first_item ? "border-primary shadow" : "";
            $text_class = $is_first_item ? "text-primary" : "text-muted";

            // Convertimos la fecha al formato deseado: "01 de Marzo de 2024"
            $timestamp = strtotime($version['fecha']);
            $dia = date('d', $timestamp);
            $mes = $meses[(int)date('m', $timestamp)];
            $anio = date('Y', $timestamp);
            $fecha_formateada = "$dia de $mes de $anio";
        ?>
        <!-- timeline item -->
        <div class="row">
            <!-- timeline item left dot -->
            <div class="col-auto text-center flex-column d-sm-flex">
                <div class="row h-50">
                    <div class="col <?= $index === 0 ? '' : 'border-end'; ?>">&nbsp;</div>
                    <div class="col">&nbsp;</div>
                </div>
                <h5 class="m-2">
                    <span class="badge rounded-pill <?= $badge_class; ?>">&nbsp;</span>
                </h5>
                <div class="row h-50">
                    <div class="col <?= $index === count($versiones_invertidas) - 1 ? '' : 'border-end'; ?>">&nbsp;</div>
                    <div class="col">&nbsp;</div>
                </div>
            </div>

            <!-- timeline item event content -->
            <div class="col py-2">
                <div class="card radius-15 <?= $card_class; ?>">
                    <div class="card-body">
                        <div class="float-end <?= $text_class; ?>">
                            <?= ucfirst($fecha_formateada); ?>
                        </div>
                        <h4 class="card-title <?= $text_class; ?>">
                            <?= $version['version']; ?> <?= $version['titulo']; ?>
                        </h4>
                        <p class="card-text"><?= $version['descripcion']; ?></p>

                        <!-- Mostrar detalles solo si hay eventos -->
                        <?php if (!empty($version['detalles'])): ?>
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-target="#details_<?= $index; ?>" data-bs-toggle="collapse">
                                Mostrar Detalles ▼
                            </button>
                            <div class="collapse border" id="details_<?= $index; ?>">
                                <div class="p-2 text-monospace">
                                    <?php foreach ($version['detalles'] as $detalle): ?>
                                        <div><?= $detalle['hora']; ?> - <?= $detalle['evento']; ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!--/row-->

        <?php endforeach; ?>
    </div>
    <!--container-->
</div>

						</div>
            	</div>
			</div>

    </main>
     <?php include("../../config/templates/mainFooter.php"); ?>    

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


    <script src="../../public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
   <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
   <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <!--BS Scripts-->
    <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



    <!--start plugins extra-->
    <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <!--end plugins extra-->



</body>

</html>