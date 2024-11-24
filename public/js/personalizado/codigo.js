document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('createModal-{{ $libro->id }}');
    const codigoInput = document.getElementById('codigo');
    const customCodeCheckbox = document.getElementById('customCode');

    // Generar un código único automáticamente
    function generateUniqueCode() {
        return 'LIB-' + Math.random().toString(36).substring(2, 10).toUpperCase();
    }

    // Asignar código automáticamente al abrir el modal
    modal.addEventListener('show.bs.modal', function () {
        if (!customCodeCheckbox.checked) {
            codigoInput.value = generateUniqueCode();
        }
    });

    // Escuchar cambios en el checkbox para habilitar/deshabilitar el input
    customCodeCheckbox.addEventListener('change', function () {
        if (this.checked) {
            codigoInput.readOnly = false;
            codigoInput.value = ''; // Limpiar el valor cuando es personalizado
        } else {
            codigoInput.readOnly = true;
            codigoInput.value = generateUniqueCode(); // Generar uno nuevo
        }
    });
});