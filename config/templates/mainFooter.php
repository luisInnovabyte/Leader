
<footer class="footer">
    <div class="footer-content">
        <div class="footer-left"></div> <!-- Este div se mantiene vacío para equilibrar el espacio -->
        <div class="footer-center">
            <?php echo $ano_actual = date("Y");?> © Todos los derechos reservados. Diseñado y desarrollado por 
            <a href="https://innovabyte.es">Innovabyte</a>.
        </div>
        <div class="footer-right">
            v<?php echo 2.0; ?><b class="tx-danger">*</b> <!-- Aquí pones la versión del software -->
        </div>
    </div>
</footer>

<!-- Monitor de Sesión v2.0 - Detecta automáticamente sesiones expiradas -->
<script>
// Calcular ruta absoluta al script desde JavaScript
(function() {
    var path = window.location.pathname;
    var pathParts = path.split('/').filter(function(p) { return p; });
    var logisticaIndex = pathParts.indexOf('logistica');
    
    if (logisticaIndex !== -1) {
        var basePath = '/' + pathParts.slice(0, logisticaIndex + 1).join('/');
        var scriptPath = window.location.origin + basePath + '/public/js/session_monitor.js';
        
        var script = document.createElement('script');
        script.src = scriptPath;
        script.onerror = function() {
            console.error('Monitor de sesión: No se pudo cargar el script desde', scriptPath);
        };
        document.body.appendChild(script);
    } else {
        console.warn('Monitor de sesión: No se encontró "logistica" en la ruta');
    }
})();
</script>