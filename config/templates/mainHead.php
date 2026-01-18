

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="efeuno.es">
<?php require_once('../../config/config.php'); ?> 

<title><?php echo  $configJsonSetting['General']['tituloSitio']; ?></title>
<link rel="icon" type="image/x-icon" href="../../public/assets/images/<?php echo $favicon ?>">
<?php require_once('sesion.php'); ?>

<!-- Required meta tags -->
<meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">

<!-- Cambiar de ../assets/images/ a ../public/img -->

<!-- FICHERO CONFIG -->


<?php include_once '../../config/funciones.php'; ?>
<?php include_once '../../config/templates/mainVersiones.php'; ?>



<!-- Summernote CSS -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />

<!--plugins-->
<link href="../../public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
<link href="../../public/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
<link href="../../public/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
<!-- loader-->
<link href="../../public/assets/css/pace.min.css" rel="stylesheet">
<script src="../../public/assets/js/pace.min.js"></script>
<!--Styles-->
<link href="../../public/assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="../../public/assets/css/icons.css">
<link href="../../public/assets/css/jquery.switch.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="../../public/assets/css/main.css" rel="stylesheet">
<link href="../../public/assets/css/dark-theme.css" rel="stylesheet">
<link href="../../public/assets/css/semi-dark-theme.css" rel="stylesheet">
<link href="../../public/assets/css/minimal-theme.css" rel="stylesheet">
<link href="../../public/assets/css/shadow-theme.css" rel="stylesheet">
<!-- TOASTR Encargado de las alertas -->
<link href="../../public/assets/js/toastr/build/toastr.css" rel="stylesheet">
<!-- Efeuno CSS 
<link href="https://efeuno.es/efeuno.css" rel="stylesheet">-->
<link href="../../public/publicSing/css/singular.css" rel="stylesheet">

<link href="../../public/assets/css/datatable-btns.css" rel="stylesheet">


<!-- DROPZONE CSS -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" type="text/css" />

<!-- **************** ACTUALES DATATABLES ************************************************-->
<!-- <link href="https://cdn.datatables.net/1.13.4/css/dataTables.jqueryui.min.css" rel="stylesheet" /> -->
<link href="../../public/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet">


<!-- <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.jqueryui.min.css" /> -->
<link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/keytable/2.9.0/css/keyTable.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/scroller/2.1.1/css/scroller.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/searchbuilder/1.4.2/css/searchBuilder.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/searchpanes/2.1.2/css/searchPanes.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/select/1.6.2/css/select.jqueryui.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/staterestore/1.2.2/css/stateRestore.jqueryui.min.css" rel="stylesheet" />


<link href="../../public/assets/css/extra-icons.css" rel="stylesheet">

<link href="../../public/assets/css/icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-minicolors/2.3.6/jquery.minicolors.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link href="../../public/assets/css/lobibox.min.css" rel="stylesheet">


<link href="../../public/assets/css/style.css" rel="stylesheet">


<link href="../../public/assets/css/efeuno.css" rel="stylesheet">
<style>
    .msg-info {
  white-space: normal; /* Permite el salto de línea */
  word-wrap: break-word; /* Fuerza el salto de línea si una palabra es demasiado larga */
  overflow-wrap: break-word; /* Soporte adicional para algunos navegadores */
}

</style>

<?php include_once '../../config/funciones.php'; ?>