function validateForm() {
    var checkboxes = document.getElementsByName('seleccionar[]');
    var atLeastOneChecked = false;

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            atLeastOneChecked = true;
            break;
        }
    }

    if (!atLeastOneChecked) {
        alert('Selecciona almenos un empleado');
        return false;
    }

    return true;
}