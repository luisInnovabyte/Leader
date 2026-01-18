<div id="agregar-usuarios-modal" class="modal fade">
<div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Nuevo Usuario</h5>
                        <div class="row g-3">
                            <div class="col-12 col-lg-3">
                                <label for="nickUsuario" class="form-label">Apodo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="nickUsuario" placeholder="Efeuno12" data-type="3" data-min="1" data-max="40" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="nombreUsuario" class="form-label">Nombre</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="nombreUsuario" placeholder="Nombre" data-type="0" data-min="1" data-max="40" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="apeUsuario" class="form-label">Apellidos</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="apeUsuario" placeholder="Apellido1 Apellido2" data-type="0" data-min="1" data-max="80" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="fechUsuario" class="form-label">Fecha de nacimiento</label>
                                <div class="position-relative input-icon">
                                    <input type="text" id="fechUsuario" class="form-control date-format" placeholder="17 Marzo, 1993" />
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="dniUsuario" class="form-label">DNI</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="dniUsuario" placeholder="12345678X" data-type="7" data-min="9" data-max="9" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="fijoUsuario" class="form-label">Teléfono Fijo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="fijoUsuario" placeholder="962 56 48 23" data-type="4" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required = "0">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="movilUsuario" class="form-label">Teléfono Movil</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="movilUsuario" placeholder="662 23 49 54" data-type="2" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="correoUsuario" class="form-label">Correo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="correoUsuario" placeholder="ejemplo@ejemplo.es" data-type="1" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-chat-left-text"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="passUsuario" class="form-label">Contraseña</label>
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="passUsuario" placeholder="*********" data-type="6" data-min="8" data-max="100" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-key"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="paisUsuario" class="form-label">País</label>
                                <div class="position-relative input-icon">
                                <input type="text" class="form-control" id="paisUsuario" placeholder="España" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="provUsuario" class="form-label">Provincia</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="provUsuario" placeholder="Valencia" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="cityUsuario" class="form-label">Ciudad / Pueblo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="cityUsuario" placeholder="Quart de Poblet" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="cpUsuario" class="form-label">Codigo Postal</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="cpUsuario" placeholder="46930" data-type="5" data-min="5" data-max="10" data-new-input="1" data-descripcion="1" data-required = "1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt"></i></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="dirUsuario" class="form-label">Dirección</label>
                                <div class="position-relative input-icon">
                                    <textarea class="form-control" id="dirUsuario" placeholder="C/ Vinatea 1, Bajo" rows="1" data-type="3" data-min="3" data-max="150" data-new-input="1" data-descripcion="1" data-required = "1"></textarea>
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt"></i></span>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <label class="tx-force-14 fw-bold">Rol seleccionado: <label id="rolSeleccionado" class="badge bg-primary tx-14-force">Usuario</label></label>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <? if ( $_SESSION['usu_rol'] ) { ?>

                                            <label class="badge bg-primary tx-14-force" id="usuarioBtn">Usuario</label>
                                            <label class="badge bg-cyan tx-14-force mg-l-10" id="adminBtn">Administrador</label>
                                    
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="agregarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>