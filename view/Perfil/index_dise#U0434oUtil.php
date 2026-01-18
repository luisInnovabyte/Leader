<!doctype html>
<html lang="es" data-bs-theme="light">

<head>
  <?php include("../../config/templates/mainHead.php") ?>


  <?php checkAccess(['0','1']);

    require_once("../../config/conexion.php");
    require_once("../../config/funciones.php");
    require_once("../../models/Usuario.php");

    $usuObjeto = new Usuario();

    $tokenIdUrl = $_GET['tokenUsuario'];

    $datosUsuario = $usuObjeto->getUsuarioConductor_x_token($tokenIdUrl);
    // Verificar si los datos están vacíos
    if (empty($datosUsuario)) {
      // Redirección a ../Home/
      header("Location: ../Home/");
      exit(); // Asegurarse de que el script se detenga después de la redirección
    }
   
?>

</head>

<body>
  <link href="../Transportes/firma/assets/jquery.signaturepad.css" rel="stylesheet">
  <!--start header-->
  <?php include("../../config/templates/mainHeader.php"); ?>

  <!--end header-->


  <!--start sidebar-->
  <?php include("../../config/templates/mainSidebar.php"); ?>
  <!--end sidebar-->


  <!--start main content-->
  <main class="page-content">
    <!--breadcrumb-->
    
    <input type="hidden" id="idUsu" value="<?php echo $_GET['idUsuario']; ?>">
    <input type="hidden" id="idUsuSession" value="<?php echo $_SESSION['usu_id']; ?>">
    <input type="hidden" id="idUsuToken" value="<?php echo $tokenIdUrl; ?>">


    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Perfil</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Perfil de Usuario</li>
          </ol>
        </nav>
      </div>
      <div class="ms-auto">
        <div class="btn-group">
          <button type="button" class="btn btn-primary">Ajustes</button>
          <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
            <a class="dropdown-item" href="javascript:;">Another action</a>
            <a class="dropdown-item" href="javascript:;">Something else here</a>
            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
          </div>
        </div>
      </div>
    </div>
    <!--end breadcrumb-->


    <hr>
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs nav-success" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#perfil" role="tab" aria-selected="true">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bi bi-home font-18 me-1'></i>
                </div>
                <div class="tab-title">Perfil</div>
              </div>
            </a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#editarPerfil" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                </div>
                <div class="tab-title">Editar perfil</div>
              </div>
            </a>
          </li>
          <!-- <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#successcontact" role="tab" aria-selected="false">
              <div class="d-flex align-items-center">
                <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                </div>
                <div class="tab-title">Añadir informacion</div>
              </div>
            </a>
          </li> -->
        </ul>
        <div class="tab-content py-3">
          <div class="tab-pane fade show active" id="perfil" role="tabpanel">
            <div class="row">
              <div class="col-12 col-lg-8 col-xl-9">
                <div class="card overflow-hidden">
                  <div class="profile-cover bg-dark position-relative mb-4">
                    <div class="user-profile-avatar shadow position-absolute top-50 start-0 translate-middle-x">
                      <img src="../../public/assets/images/users/<?php echo $datosUsuario[0]['avatarUsu'] ; ?>" alt="...">
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="mt-5 d-flex align-items-start justify-content-between">
                      <div class="">
                        <h3 class="mb-2"><?php echo $datosUsuario[0]['nombreUsu'] . ' ' . $datosUsuario[0]['apellidosUsu'] ;?></h3>
                        <p class="mb-1">Usuario</p>
                        <p class="mb-1">Desarrollador de EfeunoDev</p>
                        <p>Valencia, España</p>
                        <div class="">
                          <span class="badge rounded-pill bg-primary">Junion</span>
                          <span class="badge rounded-pill bg-primary">Cualidades</span>
                          <span class="badge rounded-pill bg-primary">Otras cualidades</span>
                        </div>
                      </div>
                      <div class="">
                        <a href="javascript:;" class="btn btn-primary"><i class="bi bi-chat me-2"></i>Enviar mensaje</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="card">
                  <div class="card-body">
                    <h4 class="mb-2">Drescripcion</h4>
                    <p class="">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.</p>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.</p>
                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                  </div>
                </div> -->
              </div>
              <div class="col-12 col-lg-4 col-xl-3">

                <?php if($transporte_m == 1){ ?>
                <div class="card">
                  <div class="card-body">
                    <h5 class="mb-3">Firma General <i class="bi signature me-2"></i></h5>
                    
                    <div class="row">
                      <?php if($datosUsuario[0]['firmaTransportista_transportistasTransporte'] != ''){ ?>
                        <small>Esta es la firma que se mostrará automáticamente en todas las ordenes. </small>
                        <img id="imgFirmaGeneral" src="<?php echo $datosUsuario[0]['firmaTransportista_transportistasTransporte']; ?>" style="max-height: 125px" alt="">
                      <?php }else{ ?> 
                        
                        <small class="tx-danger">Sin firma general. Por favor, firme en el apartado 'Editar Perfil' > 'Firma Digital'.</small>

                      <?php } ?>
                    </div>

                  </div>
                </div>
                <?php } ?>

               <!--  <div class="card">
                  <div class="card-body">
                    <h5 class="mb-3">Connect</h5>
                    <p class=""><i class="bi bi-browser-edge me-2"></i>www.example.com</p>
                    <p class=""><i class="bi bi-facebook me-2"></i>Facebook</p>
                    <p class=""><i class="bi bi-twitter me-2"></i>Twitter</p>
                    <p class="mb-0"><i class="bi bi-linkedin me-2"></i>LinkedIn</p>
                  </div>
                </div> -->
<!-- 
                <div class="card">
                  <div class="card-body">
                    <h5 class="mb-3">Skills</h5>
                    <div class="mb-3">
                      <p class="mb-1">Web Design</p>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 45%"></div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <p class="mb-1">HTML5</p>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 55%"></div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <p class="mb-1">PHP7</p>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <p class="mb-1">CSS3</p>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 75%"></div>
                      </div>
                    </div>
                    <div class="mb-0">
                      <p class="mb-1">Photoshop</p>
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar" role="progressbar" style="width: 85%"></div>
                      </div>
                    </div>

                  </div>
                </div> -->

              </div>
            </div><!--end row-->
          </div>
          <div class="tab-pane fade" id="editarPerfil" role="tabpanel">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body p-4">
                    <h5 class="mb-4">Editar perfil</h5>

                    <!-- Foto de perfil -->
                    <div class="row mb-3">
                      <label for="profilePicture" class="col-sm-3 col-form-label">Foto de perfil</label>
                      <div class="col-sm-9">
                        <div class="d-flex align-items-center">
                          <img id="profilePreview" src="../../public/assets/images/users/<?php echo $datosUsuario[0]['avatarUsu'] ; ?>" alt="Foto de perfil" class="img-thumbnail me-3" style="width: 100px; height: 100px;">
                          <input type="file" class="form-control" id="profilePicture" accept="image/*" onchange="previewProfilePicture(event)">
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input42" class="col-sm-3 col-form-label">Nombre</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <input type="text" class="form-control" id="nombreUsu"  placeholder="Nombre">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input42" class="col-sm-3 col-form-label">Apellidos</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <input type="text" class="form-control" id="apellidosUsu" placeholder="Apellidos">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person-circle"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input43" class="col-sm-3 col-form-label">Teléfono</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <input type="text" class="form-control" id="movilUsu" placeholder="Número de Teléfono">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone-fill"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input44" class="col-sm-3 col-form-label">Correo eléctronico</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <input type="text" class="form-control" id="correoUsu" placeholder="Correo eléctronico">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-envelope-fill"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input45" class="col-sm-3 col-form-label">Modificar contraseña</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <button type="button" id="changePassword" class="btn btn btn-outline-primary px-4">Pulsa aqui para cambiar la contraseña <i class="bi bi-lock-fill"></i></button>
                          <span class="position-absolute top-50 translate-middle-y"></span>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="input46" class="col-sm-3 col-form-label">Ciudad</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">

                          <input type="text" class="form-control" id="ciudadPuebloUsu" placeholder="Ciudad">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                        </div>
                      </div>

                    </div>
                    <div class="row mb-3">
                      <label for="input44" class="col-sm-3 col-form-label">Codigo Postal</label>
                      <div class="col-sm-9">
                        <div class="position-relative input-icon">
                          <input type="text" class="form-control" id="codigoPostalUsu" placeholder="Codigo Postal">
                          <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="input47" class="col-sm-3 col-form-label">Fecha de nacimiento</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" id="fechaNacimientoUsu" placeholder="DOB">
                      </div>
                    </div>
                    <?php if($transporte_m == 1){ ?>

                        <!-- FIRMA -->
                        <div class="card-body d-flex justify-content-center row">
                            <div class="col-12">
                                <p class="tx-bold mg-b-20 tx-center">Firma Digital</p>
                            </div>
                            <div id="fsignatureContainerUsuario" class="col-12 d-flex justify-content-center">
                                <form id="formSignatureUsuario" class="formSignature" method="POST">
                                    <canvas id="signaturePadUsuario" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
                                    <div class="d-flex justify-content-center mt-3">
                                        <input class="btn mt-2 text-center tx-center mr-2" id="borrarFirmaReceptor" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FIN FIRMA -->
                     <?php } ?>
                    <div class="row mb-3">
                      <label class="col-sm-3 col-form-label"></label>

                    </div>
                    <div class="row">
                      <label class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                          <button type="button" id="editardatosPerfil" class="btn btn-primary px-4">Editar datos</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div><!--end row-->

          </div>
          <div class="tab-pane fade" id="successcontact" role="tabpanel">
            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
          </div>
        </div>
      </div>
    </div>







  </main>
  <!--end main content-->


  <!--start overlay-->
  <div class="overlay btn-toggle-menu"></div>
  <!--end overlay-->

  <!-- Search Modal -->
  <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>


  <!--start theme customization-->
  <?php include("../../config/templates/mainThemeCustomization.php"); ?>
  <!--end theme customization-->

  <!--BS Scripts-->
  <?php include("../../config/templates/mainJs.php"); ?>

  

  <script src="../Transportes/firma/jquery.signaturepad.js"></script>
  <script src="../Transportes/firma/assets/numeric-1.2.6.min.js"></script>
  <script src="../Transportes/firma/assets/bezier.js"></script>


  <script src="index.js"></script>
  <!-- end BS Scripts-->


  <!--start plugins extra-->
  <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <!--end plugins extra-->



</body>

</html>