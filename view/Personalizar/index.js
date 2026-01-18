/* 
function limitarFilas(elemento,num) {
    // Dividir el contenido del textarea por saltos de línea y contar las filas
    var lineas = elemento.value.split('\n').length;

    // Si el número de filas es mayor que 3, restringir la entrada
    if (lineas > num) {
      // Dividir el contenido del textarea por saltos de línea y tomar solo las primeras 3 líneas
      var texto = elemento.value.split('\n').slice(0, 3).join('\n');
      elemento.value = texto; // Establecer el nuevo valor del textarea
    }
  } */
  window.addEventListener('message', function(event) {
    console.log(event.data);
    if (event.data === 'ping') {
        toastr.success('¡Página actualizada!');
    }
});