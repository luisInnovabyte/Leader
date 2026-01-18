  /* *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** ***
  /////////////////   Down Load Button Function   /////////////////
  *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** *** */
 /* 
  (function ($) {
    'use strict';
  
    $('#tm_download_btn').on('click', function () {


        var downloadSection = $('#html-template');
        
        var cWidth, cHeight;


        // Verificar si estamos en una pantalla pequeña (menor a 750px)
        if ($(window).width() < 750) {
          cWidth = $(window).width();
          cHeight = $(window).height();
        } else {
          cWidth = 850;
          cHeight = 1089.09;
        }

        var topLeftMargin = 50;
        var pdfWidth = cWidth + topLeftMargin * 2;
        var pdfHeight = pdfWidth * 1.5 + topLeftMargin * 2;
        var canvasImageWidth = cWidth;
        var canvasImageHeight = cHeight;
        var totalPDFPages = Math.ceil(cHeight / pdfHeight) - 1;
  
        html2canvas(downloadSection[0], { allowTaint: true }).then(function (
          canvas
        ) {
          canvas.getContext('2d');
          var imgData = canvas.toDataURL('image/png', 1.0);
          var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
  
          pdf.addImage(
            imgData,
            'PNG',
            topLeftMargin,
            topLeftMargin,
            canvasImageWidth,
            canvasImageHeight
          );
          for (var i = 1; i <= totalPDFPages; i++) {
            pdf.addPage(pdfWidth, pdfHeight);
            pdf.addImage(
              imgData,
              'PNG',
              topLeftMargin,
              -(pdfHeight * i) + topLeftMargin * 0,
              canvasImageWidth,
              canvasImageHeight
            );
          }
          var blob = pdf.output('blob');
  
          var formData = new FormData();
          formData.append('pdf', blob);
  
          idAviso = $('#idAviso').val();
          formData.append('idAviso', idAviso);

          $.ajax({
              url: 'guardar_pdf.php',
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(data) {
                  console.log(data);
              },
              error: function(data) {
                  console.log(data);
              }
          });
        });
    });
  })(jQuery);
   */