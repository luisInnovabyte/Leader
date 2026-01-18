<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->
<head>
<?php include("../../config/templates/mainHead.php"); ?>
<?php
    // 3 es USER y 1 es ADMIN. 2 JEFE DE ESTUDIOS 0 PROFESOR
    //checkAccess(['0', '1', '2', '3']);
     checkAccess(['1','0','3']);

    ?>
<!--end head-->
</head>



<body>

  <!--start mainHeader-->
  <?php include("../../config/templates/mainHeader.php"); ?>
  <!--end mainHeader-->


  <!--start sidebar-->
  <?php include("../../config/templates/mainSidebar.php"); ?>
  <!--end sidebar-->


  <!--start main content-->
  <main class="page-content">
    <style>
      .home-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 70vh;
        position: relative;
      }
      
      .logo-circle {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #159315ff 0%, #0d6b0dff 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(21, 147, 21, 0.3);
        animation: pulse 2s ease-in-out infinite;
      }
      
      .logo-circle i {
        font-size: 3.5rem;
        color: white;
      }
      
      @keyframes pulse {
        0%, 100% {
          transform: scale(1);
          box-shadow: 0 10px 40px rgba(21, 147, 21, 0.3);
        }
        50% {
          transform: scale(1.05);
          box-shadow: 0 15px 50px rgba(21, 147, 21, 0.4);
        }
      }
      
      .main-title {
        font-size: 4rem;
        font-weight: bold;
        background: linear-gradient(135deg, #159315ff 0%, #0d6b0dff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
        letter-spacing: 3px;
        margin-bottom: 15px;
        animation: fadeInDown 1s ease-out;
      }
      
      .subtitle {
        font-size: 1.5rem;
        color: #666;
        text-align: center;
        font-weight: 300;
        margin-bottom: 40px;
        animation: fadeInUp 1s ease-out;
      }
      
      .feature-cards {
        display: flex;
        gap: 30px;
        margin-top: 40px;
        animation: fadeInUp 1.2s ease-out;
      }
      
      .feature-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        width: 180px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      
      .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(21, 147, 21, 0.2);
      }
      
      .feature-card i {
        font-size: 2.5rem;
        color: #159315ff;
        margin-bottom: 15px;
      }
      
      .feature-card h4 {
        font-size: 1rem;
        color: #333;
        font-weight: 600;
        margin: 0;
      }
      
      @keyframes fadeInDown {
        from {
          opacity: 0;
          transform: translateY(-30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      
      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
    
    <div class="home-container">
      <div class="logo-circle">
        <i class="bi bi-truck"></i>
      </div>
      
      <h1 class="main-title">
        LEADER TRANSPORT
      </h1>
      
      <h3 class="subtitle">
        Sistema de gestión de órdenes de transporte
      </h3>
      
     
    </div>
  </main>
  <!--end main content-->


  <!--start overlay-->
  <div class="overlay btn-toggle-menu"></div>
  <!--end overlay-->

  <!-- Search Modal -->
  <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>



  <!--start theme customization-->
  <?php include("../../config/templates/mainThemeCustomization.php"); ?>

  <!--end theme customization-->



  <!--BS Scripts-->
  <?php include("../../config/templates/mainJs.php"); ?>

    <!-- end BS Scripts-->



  <!--start plugins extra-->
   <script src="../../public/assets/plugins/metismenu/js/metisMenu.min.js"></script>
   <script src="../../public/assets/plugins/simplebar/js/simplebar.min.js"></script>
  <!--end plugins extra-->



</body>

</html>