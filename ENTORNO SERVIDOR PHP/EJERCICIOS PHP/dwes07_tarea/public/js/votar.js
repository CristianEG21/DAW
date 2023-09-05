$(document).ready(function () {
    $(".boton-votar").click(envVoto);
});

function envVoto(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
        type: "POST",
        url: 'productos.php',
        dataType: "json",
        data: {producto: e.target.dataset.producto, puntos: $(`#puntos_${e.target.dataset.producto}`).val()},
        success: function (response)
        {
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
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}