<div id="editar-usuario-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <form id="edit-grupos-form">


                    <input type="hidden" id="idUsuarioHidden">
                        <div class="modal-body">

                            <div class="row mg-t-20 centrar_contenido">
                                
                                <div class="form-group col-6">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombreUsuarioE" placeholder="" autocomplete="off">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                                <div class="form-group col-6">
                                    <label class="control-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidoUsuarioE" placeholder="" autocomplete="off">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                               
                            </div>     
                            <div class="row mg-t-20 centrar_contenido">
                                 
                                <div class="form-group col-6">
                                    <label class="control-label">Correo</label>
                                    <input type="text" class="form-control" autocomplete="off" id="correoUsuarioE"  placeholder="">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>
                                <div class="form-group col-6">
                                    <label class="control-label">Móvil</label>
                                    <input type="text" class="form-control" autocomplete="off" id="movilUsuarioE"  placeholder="">
                                    <!-- Resto de los campos y mensajes de validación aquí -->
                                </div>

                            </div>   

                            <div class="row mg-t-20 centrar_contenido">
                                
                                <label class="ckbox">
                                    <div class="custom-radio">
                                        <input type="radio" class="rol-usuario mb-3" id="rol-trabajadorE" value="3" name="rolRadioE" required checked>
                                        <label class="rol-trabajador" for="rol-trabajadorE">Franquiciado</label>
                                    </div>
                                    <div class="custom-radio">
                                        <input type="radio" class="rol-administrador" value="1" id="rol-administradorE" name="rolRadioE" required>
                                        <label class="rol-administrador" for="rol-administradorE">Administrador</label>
                                    </div>
                                </label>

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
                            <button type="button" class="btn btn-dark waves-effect" id="cancelar-update"  data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success waves-effect waves-light" onClick="editarUsuario()">Editar Usuario</button>
                        </div>

                    </form>
                     
                </div>
            </div>
        </div>

 