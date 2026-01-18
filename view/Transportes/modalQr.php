<div id="qr_modal" class="modal fade">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
           
            <div class="modal-body">
                    <div class="col-12 col-lg-12 m-2" id="qr1">
                        <div class="card rounded">
                            <div class="card-body d-flex justify-content-center row">
                                <div class="row d-flex justify-content-center justify-content-lg-end">
                                    <button type="button" class="btn-close mg-lg-r-20 mg-b-20 mg-lg-b-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar"></button>

                                </div>
                                <div class="col-12">
                                    <p class="tx-bold mg-b-20 tx-center">Qr de la Orden de Transporte</p>
                                </div>
                                <div id="qrcode" style="display: flex; justify-content: center; align-items: center; "></div>


                                <div class="row col-12  d-flex justify-content-center mg-t-10">
                                    <p class="tx-center"><span class="bold-567" id="codigoVisible"><?php echo $jsonDatos['OA_PCS_LOCATOR'];?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
        </div>
    </div>
</div>