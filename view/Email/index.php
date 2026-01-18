<!doctype html>
<html lang="es" data-bs-theme="light">
<!--start head-->
<?php include("../../config/templates/mainHead.php"); ?>
<!--end head-->

  <body>

  <!--start mainHeader-->
  <?php include("../../config/templates/mainHeader.php"); ?>
  <!--end mainHeader-->


  <!--start sidebar-->
  <?php include("../../config/templates/mainSidebar.php"); ?>
  <!--end sidebar-->


    <!--start main content-->
     <main class="page-content">

     </main>
     <?php include("../../config/templates/mainFooter.php"); ?>     <!--end main content-->
 

    <!--start overlay-->
      <div class="overlay btn-toggle-menu"></div>
    <!--end overlay-->

   <!-- Search Modal -->
   <?php include("../../config/templates/searchModal.php"); ?>
<?php include("../../config/templates/mainFooter.php"); ?>


    <!--start theme customization-->
    <?php include("../../config/templates/mainThemeCustomization.php"); ?>

    <!--end theme customization-->

  

   <script>
		 new PerfectScrollbar('.email-navigation');
		 new PerfectScrollbar('.email-list');
	</script>

   <!--BS Scripts-->
   <?php include("../../config/templates/mainJs.php"); ?>

<!-- end BS Scripts-->


  <!--start plugins extra-->

  <!--end plugins extra-->
  </body>
</html>