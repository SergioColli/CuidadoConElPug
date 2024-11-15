function validateForm() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return false; // Evita el envío del formulario
    }
    return true; // Permite el envío del formulario
}


function validateForm() {
    var termsAccepted = document.getElementById('terms').checked;
    if (!termsAccepted) {
        alert("Debes aceptar los Términos y Condiciones.");
        return false;
    }
    return true;
}
