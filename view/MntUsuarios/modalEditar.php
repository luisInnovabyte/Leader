<div id="editar-usuarios-modal" class="modal fade">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hiddenid">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 ">Editando <label id="editando"></label></h5>
                        <div class="row g-3">
                            <div class="col-12 col-lg-3">
                                <label for="nickUsuarioE" class="form-label">Apodo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="nickUsuarioE" placeholder="Efeuno12" data-type="3" data-min="1" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="nombreUsuarioE" class="form-label">Nombre</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="nombreUsuarioE" placeholder="Nombre" data-type="0" data-min="1" data-max="40" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="apeUsuarioE" class="form-label">Apellidos</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="apeUsuarioE" placeholder="Apellido1 Apellido2" data-type="0" data-min="1" data-max="80" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-person"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <label for="fechUsuarioE" class="form-label">Fecha de nacimiento</label>
                                <div class="position-relative input-icon">
                                    <input type="text" id="fechUsuarioE" class="form-control date-format" placeholder="17 Marzo, 1993" />
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-calendar-check"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="dniUsuarioE" class="form-label">DNI</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="dniUsuarioE" placeholder="12345678X" data-type="7" data-min="9" data-max="9" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="fijoUsuarioE" class="form-label">Teléfono Fijo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="fijoUsuarioE" placeholder="962 56 48 23" data-type="4" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="0">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="movilUsuarioE" class="form-label">Teléfono Movil</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="movilUsuarioE" placeholder="662 23 49 54" data-type="2" data-min="3" data-max="20" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-telephone"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="correoUsuarioE" class="form-label">Correo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="correoUsuarioE" placeholder="ejemplo@ejemplo.es" data-type="1" data-min="3" data-max="100" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-chat-left-text"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="passUsuarioE" class="form-label"><label class="badge bg-warning tx-14-force">Opcional</label> - Cambiar Contraseña</label>
                                <div class="position-relative input-icon">
                                    <input type="password" class="form-control" id="passUsuarioE" placeholder="*********" data-type="6" data-min="8" data-max="100" data-new-input="1" data-descripcion="1" data-required="0">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-key"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="paisUsuarioE" class="form-label">País</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="paisUsuarioE" placeholder="España" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="provUsuarioE" class="form-label">Provincia</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="provUsuarioE" placeholder="Valencia" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="cityUsuarioE" class="form-label">Ciudad / Pueblo</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="cityUsuarioE" placeholder="Quart de Poblet" data-type="0" data-min="3" data-max="50" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-building"></i></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="cpUsuarioE" class="form-label">Codigo Postal</label>
                                <div class="position-relative input-icon">
                                    <input type="text" class="form-control" id="cpUsuarioE" placeholder="46930" data-type="5" data-min="5" data-max="10" data-new-input="1" data-descripcion="1" data-required="1">
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt"></i></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="dirUsuarioE" class="form-label">Dirección</label>
                                <div class="position-relative input-icon">
                                    <textarea class="form-control" id="dirUsuarioE" placeholder="C/ Vinatea 1, Bajo" rows="1" data-type="3" data-min="3" data-max="150" data-new-input="1" data-descripcion="1" data-required="1"></textarea>
                                    <span class="position-absolute top-50 translate-middle-y"><i class="bi bi-geo-alt"></i></span>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <label class="tx-force-14 fw-bold">Rol seleccionado: <label id="rolSeleccionadoE" class="badge bg-primary tx-14-force">Usuario</label></label>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <? if ($_SESSION['usu_rol']) { ?>

                                    <label class="badge bg-primary tx-14-force" id="usuarioBtnE">Usuario</label>
                                    <label class="badge bg-cyan tx-14-force mg-l-10" id="adminBtnE">Administrador</label>

                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary" title="Guardar Cambios" onClick="editarElemento()">Aceptar</button>
            </div>
        </div>
    </div>
</div>