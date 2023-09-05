document.addEventListener("DOMContentLoaded", function () {
    const botonesVoto = document.querySelectorAll(".boton-votar");
    botonesVoto.forEach((boton) => boton.addEventListener("click", envVoto));
});

function envVoto(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    puntos = document.querySelector(`#puntos_${e.target.dataset.producto}`).value;
    var data = `producto=${e.target.dataset.producto}&puntos=${puntos}`;
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.responseType = 'json';
    objXMLHttpRequest.onreadystatechange = function () {
        if (objXMLHttpRequest.readyState === 4) {
            if (objXMLHttpRequest.status === 200) {
                const response = objXMLHttpRequest.response;
                //  var jsonData = JSON.parse(response);
                if (response.error) {
                    alert("Ya has votado por este producto");
                } else {
                    var estrellas = response.puntos / response.votos;
                    var innerHtml = response.votos + ((response.votos == 1) ? " Valoración " : " Valoraciones ");
                    for (i = 1; i <= estrellas; i++) {
                        innerHtml = innerHtml + "<i class='bi bi-star-fill'></i>"
                    }
                    if ((i - estrellas) <= 0.5) {
                        innerHtml = innerHtml + "<i class='bi bi-star-half'></i>"
                    }
                    $(`#votos_${e.target.dataset.producto}`).html(innerHtml);
                }
            } else {
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    };
    objXMLHttpRequest.open('POST', 'productos.php');
    objXMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    objXMLHttpRequest.send(data);
}