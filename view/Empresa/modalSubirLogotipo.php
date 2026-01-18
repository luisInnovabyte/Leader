<div id="modal_logotipo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambiar imagen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>   
            </div>

            <form id="cambiarImagenForm" enctype="multipart/form-data">
                <div class="modal-body">
                      
                    <input type="hidden" id="nombreArchivo" name="nombreArchivo" />

                    <div action="#" class="dropzone" id="dropzoneContainer">
                        <div class="fallback">
                            <input id="file" name="files" type="file" />
                        </div>
                    </div>
                   
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning waves-effect waves-light" data-dismiss="modal" data-target="#modal_galeria">Cerrar</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"  data-target="#modal_galeria">Enviar</button>

<!--               <button type="submit" class="btn btn-success waves-effect waves-light" data-dismiss="modal" data-target="#modal_galeria">Aceptar</button>
 -->              </div>
            </form>


        </div>
    </div>
</div>

