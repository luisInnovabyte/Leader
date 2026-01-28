/**
 * Monitor de Sesión - Sistema de detección automática de sesión expirada
 * Verifica cada 60 segundos si la sesión sigue activa
 * Si expira, muestra un modal y redirige al login
 * 
 * @file session_monitor.js
 * @version 1.0.0
 * @date 27/01/2026
 */

// PROTECCIÓN: Evitar múltiples cargas del script
if (window.SessionMonitorCargado) {
    console.warn('SessionMonitor ya está cargado - ignorando');
} else {
    window.SessionMonitorCargado = true;

(function() {
    'use strict';
    
    let intervaloVerificacionSesion = null;
    let modalSesionCreado = false;
    let sesionExpiradaProcesada = false; // Bandera para evitar múltiples llamadas
    
    /**
     * Crea el modal de sesión expirada (solo una vez)
     */
    function crearModalSesionExpirada() {
        if (modalSesionCreado) return;
        
        const modalHTML = `
            <div class="modal fade" id="modalSesionExpirada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalSesionExpiradaLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="modalSesionExpiradaLabel">
                                <i class="bx bx-time"></i> Sesión Expirada
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <div class="mb-3">
                                <i class="bx bx-error-circle tx-60 tx-warning"></i>
                            </div>
                            <h5>Su sesión ha finalizado</h5>
                            <p class="tx-gray-600">Por motivos de seguridad, su sesión ha expirado debido a inactividad.</p>
                            <p class="tx-gray-600">Será redirigido automáticamente al inicio de sesión en <strong><span id="contadorRedireccion">5</span></strong> segundos.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnIrLoginAhora">
                                <i class="bx bx-log-in"></i> Ir al Login Ahora
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Añadir modal al body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        modalSesionCreado = true;
    }
    
    /**
     * Muestra el modal y redirige al login después de 5 segundos
     */
    function mostrarModalYRedirigir() {
        // Evitar ejecuciones múltiples - CRÍTICO
        if (sesionExpiradaProcesada) {
            console.log('Ya procesado - ignorando');
            return;
        }
        sesionExpiradaProcesada = true;
        console.log('=== SESIÓN EXPIRADA - PROCESANDO ===');
        
        // DETENER INMEDIATAMENTE TODAS LAS VERIFICACIONES
        if (intervaloVerificacionSesion) {
            clearInterval(intervaloVerificacionSesion);
            intervaloVerificacionSesion = null;
            console.log('Intervalo detenido');
        }
        
        // Construir ruta absoluta al login
        const pathParts = window.location.pathname.split('/');
        const logisticaIndex = pathParts.indexOf('logistica');
        
        let rutaLogin;
        if (logisticaIndex !== -1) {
            // Ruta absoluta desde logistica/
            const baseUrl = window.location.origin + pathParts.slice(0, logisticaIndex + 1).join('/') + '/';
            rutaLogin = baseUrl + 'view/Login/';
        } else {
            // Fallback a ruta relativa
            rutaLogin = '../../view/Login/';
        }
        
        // Log para debug
        console.log('Ruta login calculada:', rutaLogin);
        
        // Crear modal si no existe
        if (!modalSesionCreado) {
            crearModalSesionExpirada();
        }
        
        // Mostrar modal
        const modalElement = document.getElementById('modalSesionExpirada');
        if (!modalElement) {
            console.error('Modal no encontrado - redirigiendo directamente');
            window.location.replace(rutaLogin);
            return;
        }
        
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
        console.log('Modal mostrado');
        
        // Contador de redirección
        let segundos = 5;
        const spanContador = document.getElementById('contadorRedireccion');
        
        const intervaloContador = setInterval(function() {
            segundos--;
            console.log('Contador:', segundos);
            
            if (spanContador) {
                spanContador.textContent = segundos;
            }
            
            if (segundos <= 0) {
                clearInterval(intervaloContador);
                console.log('=== REDIRIGIENDO AHORA ===');
                
                // NO intentar cerrar el modal - simplemente redirigir
                // La página se recargará y el modal desaparecerá automáticamente
                window.location.replace(rutaLogin);
            }
        }, 1000);
        
        // Botón para ir inmediatamente
        const btnIrLoginAhora = document.getElementById('btnIrLoginAhora');
        if (btnIrLoginAhora) {
            btnIrLoginAhora.onclick = function() {
                clearInterval(intervaloContador);
                console.log('=== BOTÓN CLICKEADO - REDIRIGIENDO ===');
                window.location.replace(rutaLogin);
                return false;
            };
        }
    }
    
    /**
     * Verifica si la sesión sigue activa
     */
    function verificarSesion() {
        // NO VERIFICAR SI YA SE PROCESÓ EXPIRACIÓN
        if (sesionExpiradaProcesada) {
            return;
        }
        
        // Determinar ruta al check_session.php
        const rutaActual = window.location.pathname;
        let rutaCheckSession = '../../config/check_session.php';
        
        // MODO PRUEBA: Descomentar esta línea para usar el script de prueba
        // rutaCheckSession = '../../test_session_expired.php';
        
        // Ajustar según la profundidad
        const niveles = (rutaActual.match(/\//g) || []).length;
        if (niveles > 3) {
            rutaCheckSession = '../../../config/check_session.php';
        } else if (niveles === 3) {
            rutaCheckSession = '../../config/check_session.php';
        }
        
        fetch(rutaCheckSession, {
            method: 'GET',
            cache: 'no-cache',
            credentials: 'same-origin'
        })
        .then(response => {
            // Si ya se procesó, no continuar
            if (sesionExpiradaProcesada) {
                return null;
            }
            
            if (response.status === 401 || !response.ok) {
                // Sesión expirada - mostrar modal
                console.warn('Sesión expirada detectada por status code');
                mostrarModalYRedirigir();
                return null;
            }
            return response.text();
        })
        .then(data => {
            // Si ya se procesó, no continuar
            if (sesionExpiradaProcesada) {
                return;
            }
            
            if (data && data.includes('session_expired')) {
                // Sesión expirada - mostrar modal
                console.warn('Sesión expirada detectada por respuesta');
                mostrarModalYRedirigir();
            }
        })
        .catch(error => {
            // Si ya se procesó, no mostrar errores
            if (!sesionExpiradaProcesada) {
                console.error('Error al verificar sesión:', error);
            }
            // No mostrar modal por error de red, solo registrar
        });
    }
    
    /**
     * Inicializa el monitor de sesión
     */
    function iniciarMonitorSesion() {
        // No iniciar si ya se procesó una sesión expirada
        if (sesionExpiradaProcesada) {
            console.log('Monitor de sesión: No iniciado (sesión ya expirada)');
            return;
        }
        
        // Solo iniciar si no estamos en la página de login
        const rutaActual = window.location.pathname;
        if (rutaActual.includes('/Login/') || rutaActual.includes('/login/')) {
            console.log('Monitor de sesión: No iniciado (página de login)');
            return;
        }
        
        console.log('Monitor de sesión: Iniciado - verificación cada 60 segundos');
        
        // Verificar inmediatamente al cargar
        verificarSesion();
        
        // Verificar cada 60 segundos (1 minuto)
        intervaloVerificacionSesion = setInterval(verificarSesion, 60000);
    }
    
    /**
     * Detiene el monitor (útil para páginas que no lo necesitan)
     */
    function detenerMonitorSesion() {
        if (intervaloVerificacionSesion) {
            clearInterval(intervaloVerificacionSesion);
            intervaloVerificacionSesion = null;
            console.log('Monitor de sesión: Detenido');
        }
    }
    
    // Exportar funciones al objeto global para uso externo si es necesario
    window.SessionMonitor = {
        iniciar: iniciarMonitorSesion,
        detener: detenerMonitorSesion,
        verificarAhora: verificarSesion
    };
    
    // Iniciar automáticamente cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', iniciarMonitorSesion);
    } else {
        // DOM ya está listo
        iniciarMonitorSesion();
    }
    
})();

} // Fin de la protección contra múltiples cargas
