<div id="contenedor_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contenedorModalTitle">Confirmación de contenedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="" class="centrar_contenido row">
                    <div class="row col-12 m-2" id="qr1">
                        <div class="card col-12 rounded">
                            <div class="card-body d-flex justify-content-center row">
                                <div class="col-12">
                                    <p id="tituloContenedor" class="tx-bold tx-18 mg-b-20 tx-center"></p>
                                </div>
                                <div class="col-12  d-flex justify-content-center ">
                                    <p id="contenedorAnterior" class="tx-bold tx-15 mg-b-20 tx-center"></p><br>
                                </div>
                                <div class="col-12  d-flex justify-content-center ">
                                    <p id="contenedorNuevo" class="tx-bold tx-15 mg-b-20 tx-center"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12  d-flex justify-content-center ">
                    <small class="tx-danger" id="txDangerModal">Al guardar el contenedor, no se podrá revertir al anterior.</small>

                    </div>
                    <div class="col-12  d-flex justify-content-center ">
                    <small id="alertInvalid"></small>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                <button type="button" class="btn btn-primary d-none" title="Guardar Cambios" onClick="guardarNuevoContenedor()" id="guardarContenedorModal">Guardar Contenedor</button>
                <button type="button" class="btn btn-primary d-none" title="Guardar Cambios" onClick="guardarNuevoPrecinto()" id="guardarPrecintoModal">Guardar Precinto</button>
            </div>
        </div>
    </div>
</div>
