document.addEventListener("DOMContentLoaded", function () {
    const registroForm = document.getElementById('registro');
    registroForm.addEventListener("submit", validaForm);
});

function validaForm(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    const form = e.target;
    var data = new FormData(e.target);
    data.append("petvalida", true);
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.responseType = 'json';
    objXMLHttpRequest.onreadystatechange = function () {
        if (objXMLHttpRequest.readyState === 4) {
            if (objXMLHttpRequest.status === 200) {
                form.usuario.setCustomValidity("");
                form.password1.setCustomValidity("");
                form.password2.setCustomValidity("");
                form.email.setCustomValidity("");
                const response = objXMLHttpRequest.response;
                if (!(response.errorUsuario || response.errorPassword || response.errorEmail)) {
                    e.target.submit();
                } else {
                    if (response.errorUsuario) {
                        form.usuario.setCustomValidity("error");
                    }
                    if (response.errorPassword1) {
                        form.password1.setCustomValidity("error");
                    }
                    if (response.errorPasswords) {
                        form.password2.setCustomValidity("error");
                    }
                    if (response.errorEmail) {
                        form.email.setCustomValidity("error");
                    }
                }
                form.classList.add('was-validated');
            } else {
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    };
    objXMLHttpRequest.open('POST', 'index.php');
    objXMLHttpRequest.send(data);
}