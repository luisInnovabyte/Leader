<?php
/**
 * PÁGINA DE PRUEBA - Monitor de Sesión
 * 
 * Esta página sirve para probar el monitor de sesión antes de activarlo globalmente.
 * 
 * INSTRUCCIONES:
 * 1. Subir este archivo al servidor
 * 2. Acceder a: https://tudominio.com/logistica/test_monitor_sesion.php
 * 3. Abrir la consola del navegador (F12)
 * 4. Esperar 2 segundos - debe aparecer: "Monitor: Verificando sesión"
 * 5. Debe aparecer: "Monitor: Sesión activa ✓"
 * 6. En otra pestaña, ir a controller/logout.php
 * 7. Volver a esta pestaña y esperar máximo 60 segundos
 * 8. Debe aparecer el modal de sesión expirada
 * 9. ELIMINAR este archivo después de probar
 * 
 * @date 28/01/2026
 */

session_start();

// Verificar si hay sesión
$haySession = isset($_SESSION['usu_id']) && !empty($_SESSION['usu_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba - Monitor de Sesión</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .test-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 800px;
            margin: 0 auto;
        }
        .status-box {
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .status-active {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .status-inactive {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .log-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            max-height: 300px;
            overflow-y: auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }
        .log-entry {
            margin: 5px 0;
            padding: 5px;
        }
        .log-info { color: #0066cc; }
        .log-success { color: #28a745; }
        .log-warning { color: #ffc107; }
        .log-error { color: #dc3545; }
    </style>
</head>
<body>
    <div class="test-card">
        <h1 class="mb-4">
            <i class="bx bx-test-tube"></i> Prueba del Monitor de Sesión
        </h1>
        
        <!-- Estado de la Sesión -->
        <div class="status-box <?php echo $haySession ? 'status-active' : 'status-inactive'; ?>">
            <h4>
                <i class="bx <?php echo $haySession ? 'bx-check-circle' : 'bx-x-circle'; ?>"></i>
                Estado de Sesión: <?php echo $haySession ? 'ACTIVA' : 'INACTIVA'; ?>
            </h4>
            <?php if ($haySession): ?>
                <p class="mb-0">Usuario ID: <?php echo $_SESSION['usu_id']; ?></p>
            <?php else: ?>
                <p class="mb-0">No hay sesión activa. Por favor, inicia sesión primero.</p>
            <?php endif; ?>
        </div>
        
        <!-- Instrucciones -->
        <div class="alert alert-info mt-3">
            <h5><i class="bx bx-info-circle"></i> Instrucciones de Prueba:</h5>
            <ol class="mb-0">
                <li>Abre la consola del navegador (F12)</li>
                <li>Espera 2 segundos - verás "Monitor: Verificando sesión"</li>
                <li>Debe aparecer "Monitor: Sesión activa ✓" cada 60 segundos</li>
                <li>Para probar la expiración:
                    <ul>
                        <li>Opción A: Abre <code>controller/logout.php</code> en otra pestaña</li>
                        <li>Opción B: Espera el timeout natural de PHP</li>
                    </ul>
                </li>
                <li>Vuelve a esta pestaña y espera máximo 60 segundos</li>
                <li>Debe aparecer el modal de "Sesión Expirada"</li>
                <li>El modal debe redirigir al login automáticamente</li>
            </ol>
        </div>
        
        <!-- Botones de Acción -->
        <div class="mt-3">
            <a href="controller/logout.php" class="btn btn-danger" target="_blank">
                <i class="bx bx-log-out"></i> Cerrar Sesión (nueva pestaña)
            </a>
            <button class="btn btn-primary" onclick="SessionMonitor.verificarAhora()">
                <i class="bx bx-refresh"></i> Verificar Sesión Ahora
            </button>
            <button class="btn btn-secondary" onclick="toggleLogs()">
                <i class="bx bx-list-ul"></i> Mostrar/Ocultar Logs
            </button>
        </div>
        
        <!-- Logs en Tiempo Real -->
        <div id="logsContainer" class="mt-3" style="display: none;">
            <h5>Logs del Monitor:</h5>
            <div id="logsBox" class="log-box"></div>
        </div>
        
        <!-- Información Técnica -->
        <div class="alert alert-secondary mt-3">
            <h6><i class="bx bx-code-alt"></i> Información Técnica:</h6>
            <small>
                <strong>Script:</strong> public/js/session_monitor.js v2.0.0<br>
                <strong>Intervalo:</strong> 60 segundos<br>
                <strong>Endpoint:</strong> config/check_session.php<br>
                <strong>Tiempo de espera:</strong> 2 segundos inicial + 60 seg entre verificaciones<br>
                <strong>Protecciones:</strong> Bandera de procesado, contador de errores, detención automática<br>
            </small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Monitor de Sesión -->
    <script src="public/js/session_monitor.js"></script>
    
    <!-- Script para capturar logs -->
    <script>
        // Capturar logs de consola
        const originalLog = console.log;
        const originalWarn = console.warn;
        const originalError = console.error;
        
        function addLogEntry(message, type) {
            const logsBox = document.getElementById('logsBox');
            if (logsBox) {
                const entry = document.createElement('div');
                entry.className = 'log-entry log-' + type;
                const timestamp = new Date().toLocaleTimeString();
                entry.textContent = '[' + timestamp + '] ' + message;
                logsBox.appendChild(entry);
                logsBox.scrollTop = logsBox.scrollHeight;
            }
        }
        
        console.log = function(...args) {
            originalLog.apply(console, args);
            const message = args.join(' ');
            if (message.includes('Monitor')) {
                addLogEntry(message, message.includes('✓') ? 'success' : 'info');
            }
        };
        
        console.warn = function(...args) {
            originalWarn.apply(console, args);
            const message = args.join(' ');
            if (message.includes('Monitor') || message.includes('Sesión')) {
                addLogEntry(message, 'warning');
            }
        };
        
        console.error = function(...args) {
            originalError.apply(console, args);
            const message = args.join(' ');
            if (message.includes('Monitor')) {
                addLogEntry(message, 'error');
            }
        };
        
        function toggleLogs() {
            const logsContainer = document.getElementById('logsContainer');
            if (logsContainer.style.display === 'none') {
                logsContainer.style.display = 'block';
            } else {
                logsContainer.style.display = 'none';
            }
        }
        
        // Mostrar información inicial
        addLogEntry('Página de prueba cargada', 'info');
        addLogEntry('Monitor debería iniciar en 2 segundos...', 'info');
    </script>
</body>
</html>
