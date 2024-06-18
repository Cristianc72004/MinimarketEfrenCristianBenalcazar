document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const nombreInput = document.getElementById('nombre');
    const precioInput = document.getElementById('precio');
    const cantidadInput = document.getElementById('cantidad');
    const errorNombre = document.getElementById('errorNombre');
    const errorPrecio = document.getElementById('errorPrecio');
    const errorCantidad = document.getElementById('errorCantidad');

    form.addEventListener('submit', function(event) {
        let isValid = true;
        errorNombre.textContent = '';
        errorPrecio.textContent = '';
        errorCantidad.textContent = '';

        if (nombreInput.value.trim() === '') {
            errorNombre.textContent = 'El nombre del producto es requerido.';
            isValid = false;
        }

        if (precioInput.value.trim() === '' || isNaN(precioInput.value) || parseFloat(precioInput.value) <= 0) {
            errorPrecio.textContent = 'Ingrese un precio válido mayor a 0.';
            isValid = false;
        }

        if (cantidadInput.value.trim() === '' || isNaN(cantidadInput.value) || parseInt(cantidadInput.value) < 0) {
            errorCantidad.textContent = 'Ingrese una cantidad válida.';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
