function validateForm() {
    var checkboxes = document.getElementsByName("seleccionar[]");
    var checked = false;

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked = true;
            break;
        }
    }

    if (!checked) {
        alert("Debes seleccionar almenos un integrante para tu equipo.");
        return false; 
    }

    return true; 
}

