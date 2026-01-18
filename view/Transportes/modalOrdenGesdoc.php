<!-- ============================================================== -->
<!-- MODAL INCIDENCIA  -->
<!-- ============================================================== -->
<div id="modalOrdenGesdoc" class="modal fade">
    <div class="modal-dialog modal-xl" id="inModalSubirImagen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir documentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="centrar_contenido row ">
                    <div class="row col-12 col-lg-12 m-2" >
                        <div class="card col-12 rounded">

                            <div class="card-body d-flex justify-content-between  row">
                                <div class="col-12 col-lg-4">
                                    <div class="row d-flex justify-content-end d-lg-none">
                                        <button class="btn btn-warning waves-effect irGaleria">Ir a la galeria >></button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 row mg-0 mg-t-10">
                                    <div class="col-12 row d-flex justify-content-center">
                                        <div class="fa-solid fa-camera tx-50 tx-primary tx-center col-12 mg-b-10">
                                        </div>
                                        <form id="img_aviso" class="tx-center col-12 mg-b-20" enctype="multipart/form-data">
                                            <!-- <input type="file" accept="image/*" capture="camera"> En caso de obligar camara en el momento,  -->


                                            <input type="file" name="files[]" id="file" class="galeria_inputfile" accept=".png, .jpg, .jpeg, .webp, .pdf" data-multiple-caption="{count} fotos seleccionadas." multiple="">
                                            <label for="file" class="galeria_label if-outline if-outline-info">
                                                <i class="fa-regular fa-image tx-18"></i>
                                                <span id="textoSubirFotos">Subir documentos...</span>
                                            </label>

                                            <div id="listadoSubida" class="mg-t-20">
                                                
                                            </div>
                                            
                                            <div>
                                                <label><small class="tx-danger bold">Solo png, jpg, jpeg, webp y pdf, Máximo 10 Archivos</small></label><br>
                                                
                                                <label><small class="tx-danger bold">Peso máximo por archivo 8MB y en total 16MB</small></label><br>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="row d-flex justify-content-end galery_d-none">
                                        <button class="btn btn-warning waves-effect irGaleria">Ir a la galeria >></button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type='button' id="addImg" class='btn btn-success'>Subir Archivos</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
    <div class="modal-dialog modal-xl d-none" id="inModalGaleria">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Galería del orden</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="centrar_contenido row ">
                    <div class="row col-12 col-lg-12 m-2">
                        <div class="card col-12 rounded">

                            <div class="card-body d-flex justify-content-between  row">
                                <div class="col-lg-4 col-12">
                                    <div class="row d-flex justify-content-end">
                                        <button class="btn btn-warning waves-effect irImagen">
                                            << Ir a subir archivo</button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row d-flex justify-content-end galery_d-none">

                                    </div>
                                </div>
                                <div class="col-12 row mg-t-20">
                                    <div class="image-container">
                                        <div class="image-container">
                                            <div class="image-grid">

                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
            </div>
        </div>
    </div>
</div>