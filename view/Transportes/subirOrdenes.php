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
    checkAccess(['0', '1']);

    ?>
    <!--end head-->
    <style>
        :root {
            --primary-green: #159315ff;
            --dark-green: #0d6b0dff;
            --light-green: #e8f5e9;
            --border-green: #c8e6c9;
        }

        .page-content {
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .card {
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-title {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-title::before {
            content: "🚚";
            font-size: 2rem;
        }

        .my-3.border-top {
            border-color: var(--border-green) !important;
            border-width: 2px !important;
        }

        .tx-bold {
            color: #333;
            font-size: 1.1rem;
            background: var(--light-green);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-green);
        }

        /* Botones estilizados */
        .btn {
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, var(--dark-green) 0%, #0a5a0aff 100%);
        }

        /* Sección de información */
        .info-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid var(--primary-green);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .info-section p {
            margin: 0;
            color: #555;
            line-height: 1.6;
        }

        .info-section strong {
            color: var(--primary-green);
            font-weight: 600;
        }

        #zonaMensajes {
            background: var(--light-green);
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed var(--border-green);
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #zonaMensajes p {
            color: var(--dark-green);
            font-weight: 500;
            margin: 0;
        }

        /* Breadcrumb personalizado */
        .breadcrumb-title a {
            color: var(--primary-green) !important;
            font-weight: 600;
        }

        .breadcrumb-item.active {
            color: var(--dark-green);
            font-weight: 500;
        }

        /* Iconos para botones */
        .btn i {
            margin-right: 8px;
        }

        /* Animación de carga */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .dropzone .dz-progress .dz-upload {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%) !important;
            height: 5px;
            border-radius: 3px;
        }

        /* Contenedor de botones */
        .button-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px 20px;
        }

        /* Esquema de flujo */
        .flow-diagram {
            background: white;
            padding: 30px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .flow-diagram h4 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.3rem;
        }

        .flow-step {
            display: flex;
            align-items: center;
            margin: 15px 0;
            padding: 15px;
            background: var(--light-green);
            border-radius: 8px;
            border-left: 4px solid var(--primary-green);
            transition: all 0.3s ease;
        }

        .flow-step:hover {
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(21, 147, 21, 0.15);
        }

        .flow-step-number {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .flow-step-content {
            flex: 1;
        }

        .flow-step-title {
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 5px;
        }

        .flow-step-desc {
            color: #666;
            font-size: 0.9rem;
            margin: 0;
        }

        .flow-step-code {
            background: #f8f9fa;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #e83e8c;
        }

        .flow-arrow {
            text-align: center;
            color: var(--primary-green);
            font-size: 1.5rem;
            margin: 5px 0;
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
                        <li class="breadcrumb-item active" aria-current="page">Subir-Descargar Ordenes</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">

            <div class="col-12 card mg-t-20-force">
                <div class="card-body">
                    <h2 class="card-title">Subida-Descarga de Ordenes</h2>
                    <div class="my-3 border-top"></div>

                    <div class="row">
                        <!-- Form Validation Form -->
                        <div id="form-SubirImg" class="card-body row">
                            <div class="col-12">
                                <p class="tx-bold mg-b-20 text-center">📦 Gestión masiva de órdenes mediante archivos JSON</p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="col-12 button-container">
                                <button type='button' class='btn btn-warning' id="descargar">
                                    <i class="bi bi-cloud-download"></i>
                                    Descargar del FTP
                                </button>

                                <button type='button' class='btn btn-danger' id="cargar">
                                    <i class="bi bi-cloud-upload"></i>
                                    Subir al FTP
                                </button>
                            </div>

                            <!-- Esquema de flujo de descarga -->
                            <div class="col-12 flow-diagram">
                                <h4>📥 Flujo de Descarga de Órdenes</h4>
                                
                                <div class="flow-step">
                                    <div class="flow-step-number">1</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">🌐 Conexión al FTP Remoto</div>
                                        <p class="flow-step-desc">
                                            Se establece conexión con el servidor FTP del cliente 
                                            <span class="flow-step-code">84.127.234.85:21</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flow-arrow">⬇️</div>

                                <div class="flow-step">
                                    <div class="flow-step-number">2</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">📦 Descarga de Archivos JSON</div>
                                        <p class="flow-step-desc">
                                            Los archivos JSON se descargan a la carpeta local 
                                            <span class="flow-step-code">/view/Ordenes/descargas/</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flow-arrow">⬇️</div>

                                <div class="flow-step">
                                    <div class="flow-step-number">3</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">🔍 Validación y Procesamiento</div>
                                        <p class="flow-step-desc">
                                            Se validan los datos (DNI, email, CP) y se procesan las órdenes
                                        </p>
                                    </div>
                                </div>

                                <div class="flow-arrow">⬇️</div>

                                <div class="flow-step">
                                    <div class="flow-step-number">4</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">💾 Inserción en Base de Datos</div>
                                        <p class="flow-step-desc">
                                            Se crean/actualizan registros en tablas 
                                            <span class="flow-step-code">tm_usuario</span> y 
                                            <span class="flow-step-code">transportistas-Transporte</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flow-arrow">⬇️</div>

                                <div class="flow-step">
                                    <div class="flow-step-number">5</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">📊 Archivo Procesado</div>
                                        <p class="flow-step-desc">
                                            Archivo exitoso → Se mueve a 
                                            <span class="flow-step-code">/descargas_procesados/</span>
                                            <br>
                                            Archivo con error → Se mueve a 
                                            <span class="flow-step-code">/errores_procesados/YYYYMMDD/</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flow-arrow">⬇️</div>

                                <div class="flow-step">
                                    <div class="flow-step-number">6</div>
                                    <div class="flow-step-content">
                                        <div class="flow-step-title">📋 Registro de Control</div>
                                        <p class="flow-step-desc">
                                            Se genera JSON de control en 
                                            <span class="flow-step-code">/descargasProcesados/control_procesados/YYYYMMDD_HHMMSS.json</span>
                                            con estadísticas del proceso
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de carga -->
                            <div class="col-12 info-section">
                                <p>
                                    <strong>📤 Carga de ficheros al FTP:</strong> El sistema se conecta al FTP del cliente  y sube los ficheros de la carpeta local 
                                    <code>Ordenes/envios</code> a la carpeta remota <code>/responsesEfeuno</code>.
                                </p>
                            </div>

                            <!-- Zona de mensajes -->
                            <!-- <div class="col-12">
                                <div id="zonaMensajes">
                                    <p>💬 Zona de mensajes del sistema</p>
                                </div>
                            </div> -->

                        </div>
                    </div>

    </main>
    <?php include("../../config/templates/mainFooter.php"); ?> <!--end main content-->



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
    <script src="subirArchivoOrdenes.js"></script>
    <!--end plugins extra-->



</body>

</html>