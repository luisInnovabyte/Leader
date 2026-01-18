
<!-- ============================================================== -->
<!-- MODAL INCIDENCIA  -->
<!-- ============================================================== -->
<div id="modalAgregarIncidencia" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">
                    <div id="" class="centrar_contenido row ">
                                <div class="row col-12 col-lg-12 m-2" id="qr1">
                                        <div class="card col-12 rounded">
                                           
                                            <div class="card-body d-flex justify-content-center  row">
                                                <div class="col-12">
                                                    <p class="tx-bold mg-b-20 tx-center">Subir Imagenes</p>
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

                                        <div class="card col-12 rounded">
                                           
                                           <div class="card-body d-flex justify-content-center  row">
                                                <div class="col-12 row">
                                                    <div class="col-12 col-md-6  mt-3 row  d-flex justify-content-center">
                                                        <div class="form-group col-12">
                                                            <p class="form-control-label tx-bold mr-2 mg-l-10">Situación: </p>
                                                            <select id="selectSituacion" class="form-control "></select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6  mt-3 row  d-flex justify-content-center">
                                                        <div class="form-group col-12">
                                                            <p class="form-control-label tx-bold mr-2 mg-l-10">Viaje: </p>
                                                            <select id="selectViaje" class="form-control ">
                                                                <option value="INCIDENCIA GENERAL">INCIDENCIA GENERAL</option>
                                                                <?php
                                                                // Recorremos los datos de los viajes y creamos las opciones
                                                                foreach ($datosViajes as $viaje) {
                                                                    // Aquí supongo que $viaje tiene una propiedad 'nombre', ajusta según tus datos
                                                                    echo "<option value='{$viaje['LUGAR_NOMBRE']} - {$viaje['LUGAR_DIRECCION']}'>{$viaje['LUGAR_NOMBRE']} - {$viaje['LUGAR_DIRECCION']} - {$viaje['tipoViaje']}</option>";
                                  

                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-12 col-md-6 row  mt-3">
                                                        <div class="form-group col-12">
                                                            <p class="form-control-label tx-bold mr-2">Reportante: </p>
                                                            <p class="" id="reportante"><?php  session_start(); echo $_SESSION['usu_nom'].' '.$_SESSION['usu_ape'];  ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 row  mt-3">
                                                        <div class="form-group col-12">
                                                            <p class="form-control-label tx-bold mr-2">Fecha: </p>
                                                            <input type="datetime" readonly value="<?php echo $fecha_europa; ?>" class="form-control" id="fechaIncidencia"></input>
                                                        </div>
                                                    </div>
                                               </div>
                                               <div class="col-12 mg-t-30  mt-3">
                                                   <p class="tx-bold mg-b-20 tx-center">Descripción del la incidencia</p>
                                                   <textarea class="form-control" name="" id="descripcionIncidencia" cols="30" maxlength="500" rows="5"></textarea>
                                               </div>
                                               
                                            
                                               <div class="col-12 d-flex justify-content-center  mt-3">
                                                    <a onclick=''><button type='button' id="guardarIncidencia" class='btn btn-success'>Guardar Incidencia</button></a>
                                               </div>
                                               <div class="col-12 d-flex justify-content-center  mt-3">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cerrar">Cerrar</button>
                                               </div>
                                           </div>
                                           
                                       </div>
                                        
                                </div>
                            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" title="Cerrar">Eliminar Incidencia</button>
            </div>
        </div>
    </div>
</div>
