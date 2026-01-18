<div id="agregar-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <form id="add-grupos-form">


                        <div class="modal-body">

                            <div class="row mg-t-20 centrar_contenido">
                                
                                <div class="form-group col-6">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombreUsuario" placeholder="" autocomplete="off">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                                <div class="form-group col-6">
                                    <label class="control-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidoUsuario" placeholder="" autocomplete="off">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                               

                            </div>     
                            <div class="row mg-t-20 centrar_contenido">
                                
                                
                                <div class="form-group col-6">
                                    <label class="control-label">Correo</label>
                                    <input type="text" class="form-control" autocomplete="off" id="correoUsuario" name="correo" placeholder="">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                                <div class="form-group col-6">
                                    <label class="control-label">Móvil</label>
                                    <input type="text" class="form-control" autocomplete="off" id="movilUsuario" name="movil" placeholder="">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>

                            </div>   

                            <div class="row mg-t-20 centrar_contenido">
                                
                                
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

                            </div>   
                           
                            <div class="row mg-t-20 centrar_contenido">

                                <div class="form-group col-12">
                                    <p id="textError" class="">Asegúrate de que tenga 8 caracteres o más.<br>
                                        Una mayúscula y un símbolo
                                    </p>
                                    <label class="control-label">Contraseña</label>

                                    <div class="row col-12 entrar_contenido">
                                        <input type="password" class="form-control col-9" autocomplete="off" id="passUsuario" name="movil" placeholder="Introduce una contraseña">

                                        <div class="input-group-append col-3">
                                            <button class="btn btn-success " id="ver" type="button" title="Mostrar contraseña">
                                                <i id="icono" class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div> 

                            
                            <div class="row mg-t-20 mg-20 centrar_contenido">

                               
                                <strong><b><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 9v4" />
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                                <path d="M12 16h.01" />
                                </svg>
                                 Los correos promocionales estarán desactivado.</strong></b>
                                <strong><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 9v4" />
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                                <path d="M12 16h.01" />
                                </svg><b> No recomendamos la creación de Franquiciados.</strong></b>

                                 <b><strong><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff2825" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 9v4" />
                                <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                                <path d="M12 16h.01" />
                                </svg> La fecha de nacimiento será asignada al día de hoy.</strong></b>



                            </div>   

                            
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark waves-effect" id="cancelar-insert" name="cancelar-insert" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success waves-effect waves-light" onClick="agregarUsuario()">Crear Usuario</button>
                        </div>

                    </form>
                     
                </div>
            </div>
        </div>

        
<script>
    const passwordInput = document.getElementById("passUsuario");
    const toggleButton = document.getElementById("ver");
    const eyeIcon = document.getElementById("icono");

    toggleButton.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    });
</script>