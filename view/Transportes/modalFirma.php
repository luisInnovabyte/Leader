<!-- Modal Firma de Orden -->
<div id="firma_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Firma de Orden</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div id="contenido_firma" class="centrar_contenido row">
                    <div class="row col-12 m-2" id="qr1">
                        <div class="card col-12 rounded">
                            <div class="card-body">
                                <!-- Nav Tabs -->
                                <ul class="nav nav-tabs nav-success justify-content-center" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#firmaConductorTab" role="tab" aria-selected="false" tabindex="-1">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class="bx bxs-truck font-18 me-1"></i></div>
                                                <div class="tab-title">Firma Conductor</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#firmaReceptorTab" role="tab" aria-selected="true">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class="bx bxs-component font-18 me-1"></i></div>
                                                <div class="tab-title">Firma Receptor</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item tabCliente" role="presentation">
                                        <a class="nav-link " data-bs-toggle="tab" href="#firmaClienteTab" role="tab" aria-selected="false" tabindex="-1">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i></div>
                                                <div class="tab-title">Firma Cliente</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab Contents -->
                                <div class="tab-content py-3">
                                    <!-- Firma Conductor -->
                                    <div class="tab-pane fade" id="firmaConductorTab" role="tabpanel">
                                        <div class="card-body d-flex justify-content-center row">
                                            <div class="col-12">
                                                <p class="tx-bold mg-b-20 tx-center">Firma Digital Conductor</p>
                                            </div>
                                            <div id="fsignatureContainerConductor" class="col-12 d-none d-flex justify-content-center">
                                                <form id="formSignatureConductor" class="formSignatureConductor" method="POST">
                                                    <canvas id="signaturePadConductor" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
                                                    <div class="d-flex justify-content-center mt-3">
                                                        <input class="btn mt-2 text-center tx-center mr-2" id="borrarFirmaConductor" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <label for="nombreInputConductor" class="form-label">Nombre responsable de firma</label>
                                                <input type="text" class="form-control inputsfirma" id="nombreInputConductor" placeholder="Nombre" data-type="0" data-min="3" data-max="60" data-new-input="1" data-descripcion="1" data-required="1">
                                            </div>
                                            <div class="col-12 col-lg-12 mg-b-20 mg-t-20">
                                                <label for="DNIinputConductor" class="form-label">Documento identidad</label>
                                                <input type="text" class="form-control inputsfirma" id="DNIinputConductor" placeholder="12345678X" style="text-transform: uppercase;" data-min="6" data-max="25" data-new-input="1" data-descripcion="0" data-required="1">
                                            </div>
                                            
                                            <div class="col-12 mg-b-20 d-flex justify-content-center">
                                                <button id="saveSignatureConductor" type="button" class="btn mt-2 btn btn-success px-5 tx-center">Guardar Datos</button>
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <!-- Firma Receptor -->
                                    <div class="tab-pane fade  active show" id="firmaReceptorTab" role="tabpanel">
                                        <div class="card-body d-flex justify-content-center row">
                                            <div class="col-12">
                                                <p class="tx-bold mg-b-20 tx-center">Firma Digital Receptor</p>
                                            </div>
                                            <div id="fsignatureContainerReceptor" class="col-12 d-none d-flex justify-content-center">
                                                <form id="formSignatureReceptor" class="formSignature" method="POST">
                                                    <canvas id="signaturePadReceptor" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
                                                    <div class="d-flex justify-content-center mt-3">
                                                        <input class="btn mt-2 text-center tx-center mr-2" id="borrarFirmaReceptor" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <label for="nombreInputReceptor" class="form-label">Nombre responsable de firma</label>
                                                <input type="text" class="form-control inputsfirma" id="nombreInputReceptor" placeholder="Nombre" data-type="0" data-min="3" data-max="60" data-new-input="1" data-descripcion="1" data-required="1">
                                            </div>
                                            <div class="col-12 col-lg-12 mg-b-20 mg-t-20">
                                                <label for="DNIinputReceptor" class="form-label">Documento identidad</label>
                                                <input type="text" class="form-control inputsfirma" id="DNIinputReceptor" placeholder="12345678X" style="text-transform: uppercase;"  data-min="6" data-max="25" data-new-input="1" data-descripcion="0" data-required="1">
                                            </div>
                                            <div class="col-12 col-lg-12 mg-t-20 mg-b-10">
                                                <label for="correoInputReceptor" class="form-label">Correo</label>
                                                <div class="row d-flex justify-content-center">
                                                    <input type="text" class="form-control mg-r-10 col-9 inputsfirma" id="correoInputReceptor" placeholder="ejemplo@ejemplo.es" data-type="1" data-min="10" data-max="120" data-new-input="1" data-descripcion="0" data-required="0">
                                                    <button type="button" class="btn col-2 btn-outline-danger" onclick="enviarCorreoDatos('receptor')" id="botonEnviarOrdenReceptor" title="Enviar correo orden">
                                                        <svg class="svg-inline--fa fa-envelope" aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path fill="currentColor" d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mg-b-20 d-flex justify-content-center">
                                                <button id="saveSignatureReceptor" type="button" class="btn mt-2 btn btn-success px-5 tx-center">Guardar Datos</button>
                                            </div>
                                        </div>                                    
                                    </div>
                                    

                                    <!-- Firma Cliente -->
                                    <div class="tab-pane fade tabCliente" id="firmaClienteTab" role="tabpanel">
                                        <div class="card-body d-flex justify-content-center row">
                                            <div class="col-12">
                                                <p class="tx-bold mg-b-20 tx-center">Firma Digital Cliente</p>
                                            </div>
                                            <div id="fsignatureContainerCliente" class="d-none col-12 d-flex justify-content-center">
                                                <form id="formSignatureCliente" class="formSignature" method="POST">
                                                    <canvas id="signaturePadCliente" class="signaturePad" width="400" height="300" style="border: 1px solid #000;"></canvas>
                                                    <div class="d-flex justify-content-center mt-3">
                                                        <input class="btn mt-2 text-center tx-center mr-2" id="borrarFirmaCliente" style="background-color: #ff5353; color: white;" type="reset" value="Borrar Firma" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <label for="nombreInputCliente" class="form-label">Nombre responsable de firma</label>
                                                <input type="text" class="form-control inputsfirma" id="nombreInputCliente" placeholder="Nombre" data-type="0" data-min="3" data-max="60" data-new-input="1" data-descripcion="1" data-required="1">
                                            </div>
                                            <div class="col-12 col-lg-12 mg-b-20 mg-t-20">
                                                <label for="DNIinputCliente" class="form-label">Documento identidad</label>
                                                <input type="text" class="form-control inputsfirma" id="DNIinputCliente" placeholder="12345678X" style="text-transform: uppercase;"data-min="6" data-max="25" data-new-input="1" data-descripcion="0" data-required="1">
                                            </div>
                                            <div class="col-12 col-lg-12 mg-t-20 mg-b-10">
                                                <label for="correoInputCliente" class="form-label">Correo</label>
                                                <div class="row d-flex justify-content-center">
                                                    <input type="text" class="form-control mg-r-10 col-9 inputsfirma" id="correoInputCliente" placeholder="ejemplo@ejemplo.es" data-type="1" data-min="10" data-max="120" data-new-input="1" data-descripcion="0" data-required="0">
                                                    <button type="button" class="btn col-2 btn-outline-danger" onclick="enviarCorreoDatos('cliente')" id="botonEnviarOrdenCliente" title="Enviar correo orden">
                                                        <svg class="svg-inline--fa fa-envelope" aria-hidden="true" focusable="false" data-prefix="far" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path fill="currentColor" d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mg-b-20 d-flex justify-content-center">
                                                <button id="saveSignatureCliente" type="button" class="btn mt-2 btn btn-success px-5 tx-center">Guardar Datos</button>
                                            </div>
                                        </div>
                                    </div>
 
                                </div>
                            </div>
                        </div>
                    </div>
                    <small>Si la firma no se ha guardado, puedes cargar la firma guardada en caso de borrado.</small>
                    <small>Complete los campos Nombre Responsable y Documento identidad para habilitar la firma.</small>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" onclick="cargarViaje($('#selectViajes').val())" title="Cargar firma anterior">Cargar Datos</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>
