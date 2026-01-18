<!-- ============================================================== -->
<!-- MODAL INCIDENCIA  -->
<!-- ============================================================== -->
<div id="consultarIncidencia" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="" class="centrar_contenido row ">
                    <div class="row col-12 col-lg-12 m-2" id="qr1">
                        <div class="card col-12 rounded">
                            <div class="card-body d-flex justify-content-center  row">
                                <div class="col-12">
                                    <p class="tx-bold mg-b-20 tx-center">Documentos Aportados</p>
                                </div>
                                
                                <div class="col-12 tx-center" id="divDocumentos">
                                </div>
                            </div>
                        </div>

                        <div class="card col-12 rounded">
                            <div class="card-body d-flex justify-content-center  row">
                                <div class="col-12 row">
                                    <div class="col-12 col-md-3">
                                        <label class="form-control-label tx-bold mr-2">Situación: </label>
                                        <span class="form-control" id="situacionModal"></span>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label class="form-control-label tx-bold mr-2">Reportante: </label>
                                        <span class="form-control" id="reportanteModal"></span>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-control-label tx-bold mr-2">Fecha: </label>
                                        <span class="form-control " id="fechaModal"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3 justify-content-center d-flex ">
                                    <div class="row justify-content-center d-flex ">
                                        <label class="form-control-label tx-bold tx-center mr-2 ">VIAJE 
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
                                        </svg></label>
                                        <span class="form-control" id="viajeModal"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <p class="tx-bold mg-b-20 tx-center">Descripción del la incidencia</p>
                                    <label id="descripcionModal" class=" mg-b-20 tx-center"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
           
                <button type="button" class="btn btn-danger" id="botonEliminarIncidencia" data-bs-dismiss="modal"  onClick='cambiarEstado("")' title="Cerrar"> Eliminar Incidencia</button>
            </div>
        </div>
    </div>
</div>

