<!-- ============================================================== -->
<!-- MODAL FIRMA  -->
<!-- ============================================================== -->

<div id="modalSubidaManual" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="tituloModal" class="modal-title">Nueva Incidencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            
            <div class="modal-body">
                <div id="" class="centrar_contenido row ">
                    <div class="row col-12 col-lg-12 m-2" id="qr1">
                        <div class="card col-12 rounded">
                            <div class="card-body d-flex justify-content-center row">
                                <div class="col-12">
                                    <p class="tx-bold mg-b-20 tx-center">Documentos Aportados</p>
                                </div>
                                
                                <div class="col-12 tx-center" id="divDocumentos">
                                </div>
                            </div>
                        </div>
                        <div class="card col-12 rounded">
                            <div class="card-body d-flex justify-content-center row">
                                <div class="col-12">
                                    <p class="tx-bold mg-b-20 tx-center">Subir Imágenes</p>
                                </div>
                                
                                <div class="col-12 tx-center" id="">
                                    <div class="row mg-b-20">
                                        <div class="col-12 dropzone" id="dropzoneGesdoc"></div>
                                        <button class="col-12 btn btn-info waves-effect d-none" id="botonSubirDocumento" onClick="subirDocumentos()">SUBIR DOCUMENTOS</button>
                                    </div>
                                    <label for=""><b class="tx-danger">*</b> Suba las imágenes si fuesen necesario. Las extensiones de archivo permitidas son .png, .jpg, .jpeg y .pdf, máximo 5 archivos.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
