const formRegistro = document.getElementById('registro');
formRegistro.addEventListener('submit', validaForm);

function validaForm(e) {
    const form = e.target;
    form.email.setCustomValidity("");
    form.usuario.setCustomValidity("");
    form.password1.setCustomValidity("");
    form.password2.setCustomValidity("");

    const errPassword = form.password1.value !== form.password2.value;
    if (!form.email.validity.valid) {
        form.email.setCustomValidity("La dirección de email NO es válida.");
        form.email.reportValidity();
    }
    if (!form.password2.validity.valid) {
        form.password2.setCustomValidity("Debe tener más de cinco caracteres.");
        form.password2.reportValidity();
    }
    if (!form.password1.validity.valid) {
        form.password1.setCustomValidity("Debe tener más de cinco caracteres.");
        form.password1.reportValidity();
    }
    if (errPassword) {
        form.password2.setCustomValidity("Deben de ser iguales.");
        form.password2.reportValidity();
    }
    if (!form.usuario.validity.valid) {
        form.usuario.setCustomValidity("Debe tener más de tres caracteres.");
        form.usuario.reportValidity();
    }
    if (!form.checkValidity() || errPassword) {
        // form es invalido - cancela submit
        e.preventDefault();
        e.stopImmediatePropagation();
    }
}