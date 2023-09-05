const formRegistro = document.getElementById('registro');
formRegistro.addEventListener('submit', validaForm);

function validaForm(e) {
    const form = e.target;
    form.password2.setCustomValidity("");
    const errPasswords = form.password1.value !== form.password2.value;
    if (errPasswords) {
        form.password2.setCustomValidity("error");
    }
    if (!form.checkValidity() || errPasswords) {
        // form es invalido - cancela submit
        e.preventDefault();
        e.stopImmediatePropagation();
    }
    form.classList.add('was-validated');
}