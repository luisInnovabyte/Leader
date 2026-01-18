<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->

<head>
  <?php include("../../config/templates/mainHead.php"); ?>
  <!--end head-->

  <style>
    .pace {
      display: none !important;
    }

    .tm_invoice_info {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
    }

    .tm_invoice_seperator {
      min-height: 18px;
      border-radius: 1.6em;
      -webkit-box-flex: 1;
      -ms-flex: 1;
      flex: 1;
      margin-right: 20px;
    }

    .tm_invoice_info_list {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    .tm_invoice_info_list>*:not(:last-child) {
      margin-right: 20px;
    }

    .tm_invoice_info_list {
      position: relative;
      z-index: 1;
    }

    .tm_gray_bg {
      background: #f5f6fa;
    }
  </style>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Revisar si se está recibiendo algo en $_POST
    if (isset($_POST['factura'])) {
      // Decodificamos el JSON recibido
      $factura = json_decode($_POST['factura'], true);

      if ($factura) {
        
        /*JSON - TODO:BORRAR*/
        $json_string = json_encode($factura);
        $file = 'factura.json';
        file_put_contents($file, $json_string);
        //***FIN JSON***
        // Ahora tienes acceso a los valores de 'cliente' y 'docencia'
        $cliente = $factura['cliente']; // Nombre del cliente
        $docencia = $factura['docencia']; // Array con los detalles de docencia
        $alojamiento = $factura['alojamiento']; // Array con los detalles de docencia
        $otros = $factura['otros']; // Array con los detalles de docencia
        $ivaFact = $factura['iva']; // Array con los detalles de docencia
        $totalSinIva = $factura['totalSinIva']; // Array con los detalles de docencia
        $totalDescuento = $factura['totalDescuento']; // Array con los detalles de docencia
        $totalConDescuento = $factura['totalConDescuento']; // Array con los detalles de docencia
        $totalFactura = $factura['totalFactura']; // Array con los detalles de docencia
        $yaPagado = $factura['yaPagado']; // Array con los detalles de docencia
        $paisFact = $factura["paisFact"];
        $ciudadFact = $factura["ciudadFact"];
        $cpFact = $factura["cpFact"];
        $direcFact = $factura["direcFact"];
        $tefFact = $factura["tefFact"];
        $movilFact = $factura["movilFact"];
        $correoFact = $factura["correoFact"];
        $descrEmpresa = $factura["descrEmpresa"];
        $dirEmpresa = $factura["dirEmpresa"];
        $cpEmpresa = $factura["cpEmpresa"];
        $emailEmpresa = $factura["emailEmpresa"];
        $nifEmpresa = $factura["nifEmpresa"];
        $paisEmpresa = $factura["paisEmpresa"];
        $poblaEmpresa = $factura["poblaEmpresa"];
        $provEmpresa = $factura["provEmpresa"];
        $regEmpresa = $factura["regEmpresa"];
        $tlfEmpresa = $factura["tlfEmpresa"];
        $numProforma = $factura["numProforma"];
        $departamento = $factura["departamento"];


      } else {
        echo "No se pudo decodificar el JSON.";
      }
    } else {
      echo "No se recibieron los datos de 'factura'.";
    }
  } else {
    echo "No se recibieron datos POST.";
  }

  ?>

</head>



<body>
  <div class="col-12 card mg-t-20-force">
    <div class="card-body ">
      <div class="row">
        <div class="col-6"><img class="mg-20" src="../../public/assets/images/efeuno/logotipoDark.png" width="200px"></div>
        <div class="col-6 d-flex justify-content-end align-items-end">
          <h1 class="tx-60-force">PROFORMA</h1>
        </div>
      </div>
      <div class="row">

        <div class="tm_invoice_info tm_mb20">
          <div class="tm_invoice_seperator bg-info"></div>
          <div class="tm_invoice_info_list">
            <p class="tm_invoice_number mg-0 tx-20">PROFORMA Nº<b class="tx-danger fw-bolder" id="numeroAlbaran"><?php echo $departamento.$numProforma ?></b></p>
            <p class="tm_invoice_date mg-0 tx-20">Fecha: <b class="tx-primary fw-bolder" id="fechaPDF"><?php echo date("d/m/Y"); ?></b></p>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6">
          <h5>Empresa: <?php echo $descrEmpresa ?></h5>
          <p><?php echo $dirEmpresa.",".$poblaEmpresa.",".$cpEmpresa.",".$paisEmpresa ?><br>NIF: <?php echo $nifEmpresa ?><br>Móvil: <?php echo $tlfEmpresa ?><br>Email: <?php echo $emailEmpresa ?></p>
        </div>
        <div class="col-md-6 text-end">
          <h5>Cliente:</h5>
          <p><?php 
        // Comprobamos cada variable y la concatenamos si no está vacía
        $direccion = "";
        
        if (!empty($direcFact)) {
            $direccion .= $direcFact;
        }
        
        if (!empty($ciudadFact)) {
            $direccion .= (empty($direccion) ? "" : ", ") . $ciudadFact;
        }
        
        if (!empty($cpFact)) {
            $direccion .= (empty($direccion) ? "" : ", ") . $cpFact;
        }
        
        if (!empty($paisFact)) {
            $direccion .= (empty($direccion) ? "" : ", ") . $paisFact;
        }
        
        echo $direccion . "<br>";
        
        // Solo mostramos el prefijo y el valor si existen las variables de contacto
        if (!empty($tefFact)) {
            echo "Tlf: " . $tefFact . "<br>";
        }
        
        if (!empty($movilFact)) {
            echo "Móvil: " . $movilFact . "<br>";
        }
        
        if (!empty($correoFact)) {
            echo "Email: " . $correoFact;
        }
    ?></p>
        </div>
        






      </div>

      <!-- Tabla de items -->
      <div class="row">
        <div class="col-md-12">
          <table class="table table-bordered table-striped invoice-table">
            <thead>
              <tr>
                <th class="bg-warning">Código</th>
                <th class="bg-warning">Nombre</th>
                <th class="bg-warning">Iva</th>
                <th class="bg-warning">Precio</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Recorrer el array de docencia si existen elementos
              foreach ($docencia as $item) {
                $codigo = $item['codigo'];
                $descripcion = $item['descripcion'];
                $iva = $item['iva'];
                $importe = $item['importe'];
              ?>

                <tr>
                  <td><?php echo $codigo ?></td>
                  <td>(Docencia) <?php echo $descripcion ?></td>
                  <td><?php echo $iva ?></td>
                  <td><?php echo $importe ?></td>
                </tr>
              <?php

                // Aquí podrías realizar operaciones como almacenar estos datos en la base de datos
                //echo "Código: $codigo, Descripción: $descripcion, IVA: $iva, Importe: $importe<br>";
              }

              ?>
               <?php
              // Recorrer el array de docencia si existen elementos
              foreach ($alojamiento as $item) {
                $codigo = $item['codigo'];
                $descripcion = $item['descripcion'];
                $iva = $item['iva'];
                $importe = $item['importe'];
              ?>

                <tr>
                  <td><?php echo $codigo ?></td>
                  <td>(Alojamiento) <?php echo $descripcion ?></td>
                  <td><?php echo $iva ?></td>
                  <td><?php echo $importe ?></td>
                </tr>
              <?php

                // Aquí podrías realizar operaciones como almacenar estos datos en la base de datos
                //echo "Código: $codigo, Descripción: $descripcion, IVA: $iva, Importe: $importe<br>";
              }

              ?> <?php
              // Recorrer el array de docencia si existen elementos
              foreach ($otros as $item) {
                $codigo = $item['codigo'];
                $descripcion = $item['descripcion'];
                $iva = $item['iva'];
                $importe = $item['importe'];
              ?>

                <tr>
                  <td><?php echo $codigo ?></td>
                  <td>(Otros) <?php echo $descripcion ?></td>
                  <td><?php echo $iva ?></td>
                  <td><?php echo $importe ?></td>
                </tr>
              <?php

                // Aquí podrías realizar operaciones como almacenar estos datos en la base de datos
                //echo "Código: $codigo, Descripción: $descripcion, IVA: $iva, Importe: $importe<br>";
              }

              ?>
              <!-- <tr>
                <td>CA2</td>
                <td>(Alojamiento) Habitacion Individiual - 4 semanas</td>
                <td>24.2€</td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Subtotal e IVA -->
      <div class="row">
        <!-- <div class="col-md-10">
          <h5>Descripción o información adicional del alumno:  (RECOGER INFORMACIÓN DESDE LLEGADA O PRESCRIPCIÓN)</h5>
          <p>Tiene un alojamiento que empieza el dia x...</p>
        </div> -->
        <div class="col-md-2 text-end">
          <div class="row">
            <div class="col-9">
            





              <p class="total-section fw-bolder tx-16">Total sin IVA:</p>
              <p class="total-section fw-bolder tx-16">Total con Descuento:</p>
              <p class="total-section fw-bolder tx-16">Total IVA:</p>
              <p class="total-section fw-bolder tx-16">Total Factura:</p>
              <p class="payment-status fw-bolder tx-16">Ya pagado:</p>
            </div>
            <div class="col-3">

              <p class="total-section tx-16"><?php echo $totalSinIva ?></p>
              <p class="total-section tx-16"><?php echo $totalConDescuento ?></p>
              <p class="total-section tx-16"><?php
              // Recorrer el array de docencia si existen elementos
              $totalIva = 0;
              foreach ($ivaFact as $item) {
                $importe = $item['importe'];
                $totalIva+=$importe;

                // Aquí podrías realizar operaciones como almacenar estos datos en la base de datos
                //echo "Código: $codigo, Descripción: $descripcion, IVA: $iva, Importe: $importe<br>";
              }
              echo number_format($totalIva, 2, ',', '.');
              ?>€</p>
              <p class="total-section tx-16"><?php echo $totalFactura ?></p>

              


              <p class="payment-status tx-16"><?php echo $yaPagado ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <small class="tx-center">
          <?php echo $regEmpresa ?>
        </small>
      </div>
    </div>
  </div>



  <!--end theme customization-->



  <!--BS Scripts-->
  <?php include("../../config/templates/mainJs.php"); ?>

  <!-- end BS Scripts-->



  <!--start plugins extra-->
  <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="index.js"></script>
  <!--end plugins extra-->



</body>

</html>