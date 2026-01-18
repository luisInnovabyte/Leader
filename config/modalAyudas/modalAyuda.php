<!-- ============================================================== -->
<!-- MODAL AYUDA DEL DATATABLES  -->
<!-- ============================================================== -->

<div class="modal fade" id="modalAyuda">
<div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">AYUDA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        
                               <div class="row">
                                 <div class="col-12">
                                 <h4 class="card-title">BOTONES DE ACCIÓN</h4>
                                     <!-- BOTONES DE ACCION -->
                                     <!-- editar -->
                                    <div class="row">
                                         <div class="col-4">
                                            <?php include_once '../../config/modalAyudas/ayuda/editar.php' ?>
                                         </div>
                                        
                                         <!-- activar -->
                                         <div class="col-4">
                                         <?php include_once '../../config/modalAyudas/ayuda/activar.php' ?>
                                         </div>
                                        
                                         <!-- desactivar -->
                                         <div class="col-4">
                                         <?php include_once '../../config/modalAyudas/ayuda/desactivar.php' ?>
                                         </div>
                                    </div>
                                
                                     <!-- BOTONES DE LA TABLA -->
                                     
                                
                                 </div>
                                 <div class="col-12">
                                 <h4 class="card-title">BOTONES DE LA TABLA</h4>

                                   <div class="row">
                                     <!-- quitarFiltros -->
                                         <div class="col-6">
                                     <?php include_once '../../config/modalAyudas/ayuda/quitarFiltros.php' ?>
                                         </div>
                                    
                                     <!-- ocultar-mostrar -->
                                         <div class="col-6">
                                     <?php include_once '../../config/modalAyudas/ayuda/ocultar.php' ?>
                                         </div>
                                    
                                     <!-- colvis -->
                                         <div class="col-6">
                                     <?php include_once '../../config/modalAyudas/ayuda/colVis.php' ?>
                                         </div>
                                    
                                     <!-- Exportacion de datos -->
                                         <div class="col-6">
                                     <?php include_once '../../config/modalAyudas/ayuda/exportacion.php' ?>
                                         </div>
                                    
                                     <!-- Busqueda completa -->
                                         <div class="col-12">
                                     <?php include_once '../../config/modalAyudas/ayuda/completa.php' ?>
                                         </div>
                                   </div>
                                     
                                
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