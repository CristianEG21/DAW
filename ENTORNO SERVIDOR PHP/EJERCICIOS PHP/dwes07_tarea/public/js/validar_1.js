document.addEventListener("DOMContentLoaded", function () {
    const registroForm = document.getElementById('login');
    registroForm.addEventListener("submit", validaForm);
});

function validaForm(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    const form = e.target;
    var data = new FormData(e.target);
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.responseType = 'json';
    objXMLHttpRequest.onreadystatechange = function () {
        if (objXMLHttpRequest.readyState === 4) {
            if (objXMLHttpRequest.status === 200) {
                const response = objXMLHttpRequest.response;
                if (response.login) {
                    e.target.submit();
                } else {
                    $("#mensaje").removeClass("d-none");
                }
            } else {
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    };
    objXMLHttpRequest.open('POST', 'index.php');
    objXMLHttpRequest.send(data);
}