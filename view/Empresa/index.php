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
                        <li class="breadcrumb-item" aria-current="page">Clientes</li>
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
                    <h2 class="card-title">Empresa</h2>
                    <div class="my-3 border-top"></div>


                    <!-- ############################################################### -->
                    <!-- ###################### DETALLES EMPRESA ####################### -->
                    <!-- ############################################################### -->

                    <div class="container-fluid">
                        <!-- ============================================================== -->
                        <!-- Start Page Content -->
                        <!-- ============================================================== -->
                        <!-- Row -->
                        <div class="row d-none" id="divMostrarEmpresa">
                            <div class="col-12">

                                <div class="card border-0">
                                    <div class="card-body">
                                        <h4 class="card-title">Configurar Empresa</h4>
                                        <h6 class="card-subtitle"><code>*</code> Para poder generar facturas, es imprescindible que completes la configuración de los datos de facturación. </h6><br>


                                        <!-- Card -->
                                        <div class="card text-center w-100">
                                            <div class="card-header">
                                                BOTONES DE ACCION
                                            </div>
                                            <div class="card-body text-left">
                                                <!-- <h4 class="card-title">Special title treatment</h4>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="javascript:void(0)" class="btn btn-info">Go somewhere</a> -->
                                                <span class="tx-danger tx-bold">Botón de editar:(<i class="fa fa-edit"></i>)</span>
                                                Nos habilita el formulario para modificar los datos de la empresa. Es de acceso exclusivo de los administradores del sistema.
                                                <br>
                                                <span>Al presionar el botón anterior aparecerán en la misma posición los botones de <span class="tx-info tx-bold">Guardar</span> y <span class="tx-bold tx-dark"> Cancelar </span></span>


                                            </div>
                                            <!-- <div class="card-footer text-muted">
                                        2 days ago
                                    </div> -->
                                        </div>
                                        <!-- Card -->


                                    </div>
                                    <hr class="m-t-0">

                                    <div class="form-body">

                                        <div class="card-body">
                                            <h4 class="card-title mg-b-30-force">Datos de Facturación</h4>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nombre de Empresa:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textNombreEmpresa"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Teléfono:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textTelefono"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Email:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textEmail"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">CIF-NIF:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textNif"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Web:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textWeb"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Reg Empresa:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextRegEmpresa"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Proforma:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textPrePro">2023PRO</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Factura:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textPreFact">2023</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <hr><br>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura proforma:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textfactpro"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textfac"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <!-- <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Nº Factura Abono:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static" id="textfacneg"></p>
                                                </div>
                                            </div>
                                        </div> -->
                                                <!--/span-->
                                            </div>

                                            <hr>
                                            <!--/row-->
                                        </div>
                                        <div class="card-body bg-light">
                                            <h4 class="card-title mg-b-30-force">Dirección de Facturación</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Dirección:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextDireccion"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Población:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextPoblacion"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Provincia:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextProvincia"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Código Postal:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextCP"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">País:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextPais"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-actions">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button class="btn btn-danger" onclick="cargarDatosEmpresa()"> <i class="fa fa-pencil"></i> Editar</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ############################################################### -->
                        <!-- ############################################################### -->
                        <!-- ############################################################### -->

                        <!-- Row INSERTAR EMPRESA -->

                        <div class="row d-none" id="divInsertarEmpresa">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Configurar Empresa</h4>
                                        <h6 class="card-subtitle"><code>*</code> Para poder generar facturas, es imprescindible que completes la configuración de los datos de facturación. </h6><br>
                                    </div>
                                    <hr class="m-t-0">
                                    <form class="form-horizontal r-separator" id="formEmpresa">
                                        <div class="card-body">
                                            <input type="hidden" class="form-control" name="inputIdEmpresa" id="inputIdEmpresa" placeholder="">

                                            <h4 class="card-title m-t-10 p-b-20 mg-b-30-force">Datos de Facturación</h4>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Nombre de Empresa</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputNombreEmpresa" minlength="1" maxlength="40" autofocus id="inputNombreEmpresa" placeholder="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Teléfono</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputTelf" minlength="1" maxlength="15" id="inputTelf" placeholder="">
                                                            <small class="text-muted">Escriba el teléfono de empresa. Solo números.</small>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <input type="email" autocomplete="off" class="form-control" minlength="1" maxlength="35" name="inputEmail" id="inputEmail" placeholder="">
                                                            <small class="text-muted">Escriba el correo de empresa. ejemplo@ejemplo.xx</small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">NIF</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="inputNif" minlength="1" maxlength="10" name="inputNif" placeholder="">
                                                            <small class="text-muted">Escriba el nif de empresa. Comience por letra y 8 números.</small>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Web</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputWeb" id="inputWeb" minlength="1" maxlength="70" placeholder="http://">
                                                            <small class="text-muted">La web debe empezar por https:// o http://</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Reg Empresa</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" name="inputRegEmpresa" id="inputRegEmpresa" minlength="1" maxlength="255" rows="3" placeholder=""></textarea>
                                                            <small class="text-muted">Escriba el registro de empresa.</small>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Proforma:</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="prefijoPro" id="prefijoPro" minlength="1" maxlength="15" rows="3" placeholder="">
                                                            <small class="text-muted">Escriba el prefijo de empresa. Solo números y letras</small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Factura:</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="prefijoFact" id="prefijoFact" minlength="1" maxlength="15" rows="3" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <hr><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura proforma:</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="inputfactPro" id="inputfactPro" minlength="1" maxlength="15" rows="3" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura:</label>
                                                        <div class="col-md-9">
                                                            <input class="form-control" name="inputfact" id="inputfact" minlength="1" maxlength="16" rows="3" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <!-- <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Nº Factura Abono:</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" name="inputfactNeg" id="inputfactNeg"  minlength="1" maxlength="15" rows="3" placeholder="">
                                                </div>
                                            </div>
                                        </div> -->
                                                <!--/span-->
                                            </div>

                                            <!--/row-->
                                            <hr>
                                        </div>
                                        <div class="card-body bg-light">
                                            <h4 class="card-title m-t-10 p-b-20 mg-b-30-force">Dirección de Facturación</h4>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Dirección</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputDireccion" minlength="1" maxlength="60" id="inputDireccion" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Población</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputPoblacion" minlength="1" maxlength="20" id="inputPoblacion" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Provincia</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputProvincia" minlength="1" maxlength="20" id="inputProvincia" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Código Postal</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputCP" id="inputCP" minlength="1" maxlength="7" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6">
                                                    <div class="form-group row p-t-15">
                                                        <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">País</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="inputPais" id="inputPais" minlength="1" maxlength="10" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="card-body">
                                            <div class="form-group m-b-0 text-left">
                                                <button type="submit" id="guardarEmpresaButtom" class="btn btn-success waves-effect waves-light insertando d-none">Guardar Empresa</button>
                                                <button type="button" id="editarEmpresaButtom" onclick="editarEmpresa()" class="btn btn-info waves-effect waves-light editando d-none">Guardar</button>
                                                <button class="btn btn-dark waves-effect waves-light editando d-none" type="button" onclick="cancelarEditar()">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->

                    </div>

                    <!-- ##############################################################-->
                    <!-- ################ PERSONALIZACIÓN #############################-->
                    <!-- ##############################################################-->

                    <div class="container-fluid">
                        <!-- ============================================================== -->
                        <!-- Start Page Content -->
                        <!-- ============================================================== -->
                        <!-- Row -->
                        <div class="row d-none" id="divMostrarEmpresa">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Configurar Empresa</h4>
                                        <h6 class="card-subtitle"><code>*</code> Para poder generar facturas, es imprescindible que completes la configuración de los datos de facturación. </h6><br>
                                        <!-- Card -->
                                        <div class="card text-center w-75">
                                            <div class="card-header">
                                                BOTONES DE ACCION
                                            </div>
                                            <div class="card-body text-left">
                                                <!-- <h4 class="card-title">Special title treatment</h4>
                                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                        <a href="javascript:void(0)" class="btn btn-info">Go somewhere</a> -->
                                                <span class="tx-danger tx-bold">Botón de editar:(<i class="fa fa-edit"></i>)</span>
                                                Nos habilita el formulario para modificar los datos de la empresa. Es de acceso exclusivo de los administradores del sistema.
                                                <br>
                                                <span>Al presionar el botón anterior aparecerán en la misma posición los botones de <span class="tx-info tx-bold">Guardar</span> y <span class="tx-bold tx-dark"> Cancelar </span></span>
                                            </div>
                                            <!-- <div class="card-footer text-muted">
                                        2 days ago
                                    </div> -->
                                        </div>
                                        <!-- Card -->
                                    </div>
                                    <hr class="m-t-0">

                                    <div class="form-body">

                                        <div class="card-body">
                                            <h4 class="card-title mg-b-30-force">Datos de Facturación</h4>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nombre de Empresa:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textNombreEmpresa"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Teléfono:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textTelefono"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Email:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textEmail"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">CIF-NIF:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textNif"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Web:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textWeb"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Reg Empresa:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextRegEmpresa"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Proforma:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textPrePro">2023PRO</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Prefijo Factura:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textPreFact">2023</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <hr><br>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura proforma:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textfactpro"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Nº Factura:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="textfac"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <!-- <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Nº Factura Abono:</label>
                                                <div class="col-md-9">
                                                    <p class="form-control-static" id="textfacneg"></p>
                                                </div>
                                            </div>
                                        </div> -->
                                                <!--/span-->
                                            </div>

                                            <hr>
                                            <!--/row-->
                                        </div>
                                        <div class="card-body bg-light">
                                            <h4 class="card-title mg-b-30-force">Dirección de Facturación</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Dirección:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextDireccion"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Población:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextPoblacion"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Provincia:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextProvincia"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">Código Postal:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextCP"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="control-label text-right col-md-3">País:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static" id="TextPais"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-actions">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button class="btn btn-danger" onclick="cargarDatosEmpresa()"> <i class="fa fa-pencil"></i> Editar</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ############################################################### -->
                        <!-- ############################################################### -->
                        <!-- ############################################################### -->

                        <!-- Row INSERTAR EMPRESA -->

                        <div class="row" id="">
                            <div class="col-12">
                                <div class="card border-0">

                                    <div class="card-body">
                                        <h4 class="card-title">Personalización de Empresa</h4>
                                        <h6 class="card-subtitle mb-3">En esta sección, te brindamos la capacidad de personalizar la aplicación de acuerdo a tus necesidades y preferencias.<br><br><i>Las opciones habilitadas apareceran con el texto </i>: No habilitado: <code class="">Ejemplo</code> | Habilitado: <code class="tx-18 tx-bold">Ejemplo</code></h6><br>

                                        <div class="row">
                                            
                                        <div class="col-12 col-lg-4">
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="conteprecintoSwitch" value="<?php echo $mostrarContPrecinto ?>">
                                                    <label class="form-check-label" for="conteprecintoSwitch">
                                                        <h6 class="card-subtitle">Mostrar el <code class="conteprecinto">contenedor y precinto editable</code> en las ordenes.</h6>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <!-- Facturas modo Proforma o Presupuesto -->
                                            <div class="col-12 col-lg-4">
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="mostrarFacturasSwitch" value="<?php echo $factProPresupuesto ?>">

                                                    <label class="form-check-label" for="mostrarFacturasSwitch">
                                                        <h6 class="card-subtitle">Mostrar facturas modo <code class="proforma">Proforma</code> o <code class="presupuesto">Presupuesto</code></h6>
                                                    </label>
                                                </div>

                                            </div>

                                            <!-- Periodo Trimestral -->
                                            <div class="col-12 col-lg-4">
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="trimestralSwitch" value="<?php echo $mostrarTrimestral ?>">
                                                    <label class="form-check-label" for="trimestralSwitch">
                                                        <h6 class="card-subtitle">Periodo <code class="trimestral">Trimestral</code>: Habilitará / deshabilitará las tarifas trimestrales.</h6>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Periodo Trimestral -->
                                            <div class="col-12 col-lg-4">
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="quincenasSwitch" value="<?php echo $mostrarQuincenas ?>">
                                                    <label class="form-check-label" for="quincenasSwitch">
                                                        <h6 class="card-subtitle">Periodo <code class="quincenal">Quincenal</code>: Habilitará / deshabilitará las tarifas quincenales.</h6>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row mt-4">
                                            <!-- Mostrar motivo de sanción -->
                                            <div class="col-12 col-lg-4">
                                                <div class="form-check form-switch form-check-inline">
                                                    <input class="form-check-input" type="checkbox" id="sancionSwitch" value="<?php echo $mostrarSancion ?>">
                                                    <label class="form-check-label" for="sancionSwitch">
                                                        <h6 class="card-subtitle">Mostrar motivo de <code class="sancion">sanción</code>: Mostrar / Ocultar el mensaje informativo para el usuario.</h6>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Seleccionar color principal -->
                                            <div class="col-12 col-lg-4" style=" z-index: 0">
                                                <h6 class="card-subtitle">Seleccione <code>color</code> principal de la aplicación.</h6>
                                                <div class="input-group">
                                                    <input type="text" id="wheel-demo" class="form-control demo" data-control="wheel" value="<?php echo $colorDefault; ?>">
                                                    <button class="btn btn-success" onclick="actualizarColor()" type="button">Guardar</button>
                                                </div>
                                            </div>

                                            <!-- Cambiar nombre de empresa -->
                                            <div class="col-12 col-lg-4" style=" z-index: 0">
                                                <h6 class="card-subtitle">Cambiar nombre de <code>Empresa</code>.</h6>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="nombreConfigEmpresa" value="<?php echo $nombreEmpresa; ?>" placeholder="Nombre de Empresa">
                                                    <button class="btn btn-success" onclick="actualizarNombre()" type="button">Guardar</button>
                                                </div>
                                                <small class="form-text text-muted">Solo letras *</small>
                                            </div>
                                        </div>
                                    </div>



                                    <form class="form-horizontal r-separator" id="cambiarImagenForm">

                                        <div class="card-body bg-light-info mg-t-10">

                                            <!-- PERSONALIZAR IMAGEN -->
                                            <h4 class="card-title m-t-20 p-b-20 mg-b-30-force"> Logotipos - Modo Claro <i class=" far fa-sun"></i></h4>
                                            <small><b class="tx-danger">*</b> Asegúrate de que los logotipos contengan colores oscuros.</small>

                                            <div class="rowContenedor mg-t-20">
                                                <!-- Recoger Datos BD -->
                                                <?php

                                                $resultadoParseado2 = $resultado[0]["empresa"];
                                                $resultadoParseado2 = json_decode($resultadoParseado2, true);

                                                ?>
                                                <div class='row d-flex justify-content-center'>

                                                    <div class='col-3 bold tx-center headPersonalizacion'>
                                                        Logo Principal
                                                    </div>
                                                    <div class='col-3 bold tx-center headPersonalizacion d-none'>
                                                        Logo Footer
                                                    </div>
                                                    <div class='col-3 bold tx-center headPersonalizacion'>
                                                        Logo Favicon
                                                    </div>
                                                </div>
                                                <div class='row infoEmpresa d-flex justify-content-center'>

                                                    <div class='col-3 pd-t-20 tx-center bodyPersonalizacion'>
                                                        <input type='hidden'  value='../../public/assets/images/<?= $datosEmpresa[0]['logotipoWhite'] ?>'>
                                                        <div class='dropzone  bg-light-info 'data-info="logoWhite"></div>
                                                    </div>
                                                    <div class='col-3 pd-t-20 tx-center bodyPersonalizacion d-none'>

                                                        <input type='hidden' value='../../public/assets/images/<?= $resultadoParseado2["Empresa"]["LogoFooter"] ?>'>
                                                        <div class='dropzone  bg-light-info '></div>
                                                    </div>
                                                    <div class='col-3 pd-t-20  tx-center bodyPersonalizacion'>

                                                        <input type='hidden'  value='../../public/assets/images/<?= $datosEmpresa[0]['faviconWhite'] ?>'>
                                                        <div class='dropzone tx-white bg-light-info 'data-info="favWhite"></div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                <div class="card-body bg-light-info-dark mg-t-10">

                                    <!-- PERSONALIZAR IMAGEN -->
                                    <h4 class="card-title m-t-20 p-b-20 mg-b-30-force">Logotipos - Modo Oscuro <i class="far fa-moon"></i> </h4>
                                    <small class=""><b class="tx-danger">*</b> Asegúrate de que los logotipos contengan colores claros.</small>
                                    <div class="rowContenedor mg-t-20">
                                        <!-- Recoger Datos BD -->
                                        <?php

                                        $resultadoParseado2 = $resultado[0]["empresa"];
                                        $resultadoParseado2 = json_decode($resultadoParseado2, true);

                                        ?>
                                        <div class='row d-flex justify-content-center'>

                                            <div class='col-3 bold tx-center headPersonalizacion'>
                                                Logo Principal
                                            </div>
                                            <div class='col-3 bold tx-center headPersonalizacion d-none'>
                                                Logo Footer
                                            </div>
                                            <div class='col-3 bold tx-center headPersonalizacion'>
                                                Logo Favicon
                                            </div>
                                        </div>
                                        <div class='row infoEmpresa bg-light-info-dark d-flex justify-content-center'>
                                            <div class='col-3 pd-t-20 tx-center bodyPersonalizacion'>
                                                <input type='hidden'  value='../../public/assets/images/<?= $datosEmpresa[0]['logotipoDark'] ?>'>
                                                <div class='dropzone  bg-light-info-dark'data-info="logoDark"></div>
                                            </div>
                                            <div class='col-3 pd-t-20 tx-center bodyPersonalizacion d-none'>

                                                <input type='hidden' value='../../public/assets/images/<?= $resultadoParseado2["Empresa"]["LogoFooter"] ?>'>
                                                <div class='dropzone  bg-light-info-dark'></div>
                                            </div>
                                            <div class='col-3 pd-t-20 tx-center bodyPersonalizacion'>

                                                <input type='hidden'  value='../../public/assets/images/<?= $datosEmpresa[0]['faviconDark'] ?>'>
                                                <div class='dropzone  bg-light-info-dark'data-info="favDark"></div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="col-12 btn btn-primary waves-effect" id="cambiarImagenForm">Guardar Imagenes</button>



                            </div>
                            </form>

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

    <script>
        $('.demo').each(function() {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                format: $(this).attr('data-format') || 'hex',
                keywords: $(this).attr('data-keywords') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                    }
                },
                theme: 'bootstrap'
            });

        });
    </script>
    <script>
        $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
        var radioswitch = function() {
            var bt = function() {
                $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioState")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
                }), $(".radio-switch").on("switch-change", function() {
                    $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
                })
            };
            return {
                init: function() {
                    bt()
                }
            }
        }();
        $(document).ready(function() {
            radioswitch.init()
        });
    </script>

    <script src="empresaIndex.js"></script>


</body>

</html>