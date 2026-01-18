<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once '../../config/templates/mainHead.php' ?>
    <?php
    // Escribe 1 = Admin o 0 = User
    ?>

</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php include_once '../../config/templates/mainPreloader.php' ?>
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


        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- CABECERA-->
                    <!-- ============================================================== -->
                    <div class="col-5 align-self-center">
                        <div class="d-flex align-items-center">

                        </div>
                    </div>


                    <div class="col-7 align-self-center">
                        <div class="d-flex no-block justify-content-end align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="index.php">Usuarios</a>
                                    </li>
                                    <li id="current-page" class="breadcrumb-item active" aria-current="page">Gestión Usuario</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- FIN DE CABECERA DE LA PAGINA Y TITULO  -->
            <!-- ============================================================== -->
            <!-- RECOGEMOS LA VARIABLE IDCLIENTE -->
            <input type="hidden" id="editIdUsuario" value="<?php echo $_GET['idUsuario']; ?>">

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ***************************************************** -->
                <!--            END CABECERA DE LA PAGINA                  -->
                <!-- ***************************************************** -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- **************************************** -->
                            <!--             CONTENIDO PRINCIPAL          -->
                            <!-- **************************************** -->



                            <div class="col-lg-12 ">
                                <div class="form-layout form-layout-4 ">
                                    <!-- <p class="br-section-text">Introduza la descripción del producto a añadir</p> -->


                                    <!-- ********************************** -->
                                    <!-- ********************************** -->
                                    <!-- ** MENSAJES DE LAS VALIDACIONES ** -->
                                    <!-- ********************************** -->
                                    <!-- ********************************** -->
                                    <!-- alerta de exito -->

                                    <!-- ********************************** -->
                                    <!-- ********************************** -->
                                    <!-- ** FIN DEL MENSAJES DE LAS VALIDACIONES ** -->
                                    <!-- ********************************** -->
                                    <!-- ********************************** -->

                                    <!-- https://content.breatheco.de/es/lesson/regex-tutorial-regular-expression-examples -->
                                    <!-- https://www.regexpal.com -->
                                    <h4 id="page-title" class="page-title"></h4>

                                    <form method="POST" id="usuario_form">
                                        <input type="hidden" name="idUsuario" value="<?php echo $_GET['idUsuario']; ?>">

                                        <div class="row">
                                            <div class="form-group col-2">
                                                <label class="control-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" placeholder="" autocomplete="off">
                                                <!-- Resto de los campos y mensajes de validación aquí -->
                                            </div>
                                            <div class="form-group col-2">
                                                <label class="control-label">Apellido</label>
                                                <input type="text" class="form-control" id="apellido" placeholder="" autocomplete="off">
                                                <!-- Resto de los campos y mensajes de validación aquí -->
                                            </div>
                                            <div class="form-group col-2">
                                                <label class="control-label">Correo</label>
                                                <input type="email" class="form-control" autocomplete="off" id="correo" name="correo" placeholder="">
                                                <!-- Resto de los campos y mensajes de validación aquí -->
                                            </div>
                                            <div class="form-group col-2">
                                                <label class="control-label">Móvil</label>
                                                <input type="text" class="form-control" autocomplete="off" id="movil" name="movil" placeholder="">
                                                <!-- Resto de los campos y mensajes de validación aquí -->
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                            <label class="tx-bold">Fecha de Nacimiento</label>
                                            <div class="form-group col-3">
                                                <select class="form-control" id="diaNacimiento" name="diaNacimiento" required>
                                                    <option value="" disabled selected>Día</option>
                                                    <!-- Aquí puedes generar los options del 1 al 31 -->
                                                    <!-- Generar los options para los días -->
                                                    <?php
                                                    for ($i = 1; $i <= 31; $i++) {
                                                        echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-3">
                                                <select class="form-control" id="mesNacimiento" name="mesNacimiento" required>
                                                    <option value="" disabled selected>Mes</option>
                                                    <!-- Aquí puedes generar los options de los meses -->
                                                    <?php
                                                    $meses = array(
                                                        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                                        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                                                    );
                                                    foreach ($meses as $index => $mes) {
                                                        echo "<option value='" . ($index + 1) . "'>$mes</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-3">
                                                <select class="form-control" id="anioNacimiento" name="anioNacimiento" required>
                                                    <option value="" disabled selected>Año</option>
                                                    <!-- Generar los options para los años -->
                                                    <?php
                                                    $anioActual = date("Y");
                                                    for ($i = $anioActual; $i >= 1903; $i--) {
                                                    echo "<option value='$i'>$i</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    
                                        <!-- row -->
                                        <!-- row -->
                                        <div class="row mg-b-10 passDiv d-none">
                                            <label class="col-sm-12 col-md-12 col-lg-2 form-control-label">Contraseña: <span class="tx-danger">*</span></label>
                                            <div class="col-sm-12 col-md-12 col-lg-10 mg-t-10 mg-sm-t-0">
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="senaUsuario" name="senaUsuario" maxlength="45" minlength="2" placeholder="Introduzca la contraseña" onClick="this.select()" />

                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" id="ver" type="button"><i id="icono" class="fa fa-eye"></i></button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <span id="infosenaUsu" class="col-sm-10 mg-b-2 mg-t-5 tx-10 tx-gray-500">Al menos 8 posiciones 1 dígito, una minúscula y una Mayúscula</span>
                                                    <span id="lonsenaUsu" class="col-sm-2 mg-b-2 mg-t-5 tx-10 tx-gray-500 text-center"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row mg-t-15">
                                            <!-- <label class="col-sm-2 form-control-label">Admnistrador:</label> -->
                                            <label class="col-sm-12 col-md-12 col-lg-2 form-control-label">Rol:</label>
                                            <!-- <div class="col-sm-10 mg-t-10 mg-sm-t-0"> -->
                                            <div class="col-sm-12 col-md-12 col-lg-10 mg-t-10 mg-sm-t-0">
                                                <label class="ckbox">
                                                    <div class="custom-radio">
                                                        <input type="radio" class="rol-usuario mb-3" id="rol-trabajador" value="3" name="rolRadio" required checked>
                                                        <label class="rol-trabajador" for="rol-trabajador">Franquiciado</label>
                                                    </div>
                                                    <div class="custom-radio">
                                                        <input type="radio" class="rol-administrador" value="1" id="rol-administrador" name="rolRadio" required>
                                                        <label class="rol-administrador" for="rol-administrador">Administrador</label>
                                                    </div>
                                                </label>
                                            </div><!-- col-3 -->
                                        </div><!-- row -->


                                        <br>
                                        <!-- <div class="sig sigWrapper"> -->
                                        <div class=" form-layout-footer mg-t-30 pd-t-20 ">
                                            <button id="cancelar" class="btn btn-dark mg-sm-t-10">Volver</button>
                                            <button type="submit" name="action" id="botonGuardar" value="add" class="btn btn-success d-none mg-sm-t-10">Guardar</button>
                                            <button type="submit" name="action2" id="botonEditar" value="add2" class="btn btn-info d-none mg-sm-t-10">Guardar</button>
                                        </div><!-- form-layout-footer -->
                                        <!-- form-layout-footer -->
                                    </form>
                                </div><!-- form-layout -->
                            </div>
                        </div>
                    </div><!-- br-section-wrapper -->
                    <!-- **************************************** -->
                    <!--         END CONTENIDO PRINCIPAL          -->
                    <!-- **************************************** -->



                    <!------------------------>
                    <!--- MODAL CONTRASEÑA  // Se añade para no recibir problemas con la validación pass al compartir JS--->
                    <!------------------------>

                    <div class="modal fade effect-rotate-bottom" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="modalPass" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bd-0 tx-14">
                                <div class="modal-header pd-y-20 pd-x-25">
                                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">CAMBIAR CONTRASEÑA</h6>
                                    <button type="button" id="cerrarModalPass" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body pd-25">

                                    <!-- Interior Modal -->
                                    <div class="row">
                                        <div class="col-lg-12 bg-white">
                                            <div class="pd-y-30 pd-xl-x-30">
                                                <div class="pd-x-30 pd-y-10">
                                                    <strong class="tx-success tx-center d-none" id="textSuccess">¡Contraseña cambiada con exito!&nbsp; </strong>

                                                    <p class="tx-bold">Vas a cambiar la contraseña de: <?php echo $datos[0]['nomUsu'] ?> </p>

                                                    <div class="input-group ">
                                                        <input type="password" class="form-control  form-control pd-y-12 verPass" id="senaUsu" name="senaUsu" maxlength=15 minlength=8 placeholder="Introduzca la contraseña" />

                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary verPassButton" id="" type="button"><i id="icono" class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="row mg-b-10">
                                                        <span id="infosenaUsu" class="col-sm-10 mg-b-2 mg-t-5 tx-8 tx-gray-500">Al menos 8 posiciones 1 dígito, una minúscula y una Mayúscula</span>

                                                        <span id="lonsenaUsu" class="col-sm-2 mg-b-2 mg-t-5 tx-8 tx-gray-500 text-center"></span>
                                                    </div>

                                                    <div class="input-group ">
                                                        <input type="password" class="form-control  form-control pd-y-12 verPass" id="reSenaUsu" name="reSenaUsu" maxlength=15 minlength=8 placeholder="Repita la contraseña" />
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary verPassButton" type="button"><i id="icono" class="fa fa-eye"></i></button>
                                                        </div>
                                                    </div>


                                                    <button id="cambiarPassword" class="btn  disabled pd-y-12 btn-block">Guardar</button>

                                                </div>
                                            </div><!-- pd-20 -->
                                        </div><!-- col-6 -->
                                    </div>
                                </div><!-- modal-dialog -->
                            </div>
                        </div>
                    </div>
                    <!---------------------------->
                    <!--- FIN MODAL CONTRASEÑA --->
                    <!---------------------------->
                </div><!-- br-pagebody -->
            </div>
        </div>
    </div><!-- br-mainpanel -->
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


    <?php include_once '../../config/templates/mainJs.php' ?>

    <!-- SCRIPTS PERSONALIZADOS -->

    <!-- ALERTAS  -->
 <script src="../../public/js/dist/custom.min.js"></script>
 
    <script src="usuariosIndex.js"></script>

</body>

</html>