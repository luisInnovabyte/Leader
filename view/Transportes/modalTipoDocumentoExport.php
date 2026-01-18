<div id="tipoDocumentoModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tipo de Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                    <div id="botonesDocumentos" class="row d-flex justify-content-center">
                        
                        <button data-tipodocumento='E' class="printDocumento btn btn-danger btn-icon-text col-auto">
                            <i class="fas fa-file-excel tx-25"></i>
                            <span>CLIENTE</span>
                        </button>
                        <button data-tipodocumento='O' id="" class="printDocumento btn btn-primary btn-icon-text col-auto">
                            <i class="fas fa-file-alt tx-25"></i>
                            <span>OFICINA</span>
                        </button>
                        <button data-tipodocumento='X' class="printDocumento btn btn-success btn-icon-text col-auto">
                            <i class="fas fa-file-contract tx-25"></i>
                            <span>RECEPTOR</span>
                        </button>
                       
                       
                    </div>
                    <div id="seleccionarViaje" class="d-none row d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <h2>Seleccione un viaje</h2>
                            <small>Para exportar la orden para el cliente, se debe especificar el viaje a mostrar.</small>
                            <select class="form-control w-90 mt-10" id="viajeSeleccionado">
                                <option value="">Selecciona un viaje</option>
                                <?php
                                // Recorremos los datos de los viajes y creamos las opciones
                                foreach ($datosViajes as $viaje) {
                                    // Aquí supongo que $viaje tiene una propiedad 'nombre', ajusta según tus datos
                                    echo "<option value='{$viaje['idViaje']}'>{$viaje['LUGAR_NOMBRE']} - {$viaje['LUGAR_DIRECCION']}</option>";
                                }
                                ?>
                            </select>
                        <div class="mt-4">
                            <button type="button" class="btn btn-secondary mr-2" onclick="cancelarDocumentoCliente()" >Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="generarDocumentoCliente()" id="generateDocumentButton">Generar Documento</button>
                        </div>
                        </div>

                        
                    </div>

                
                
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>