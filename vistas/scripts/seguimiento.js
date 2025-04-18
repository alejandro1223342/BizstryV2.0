function init() {

}

function registrarSeguimiento(ped_id) {
    $('#modalSeguimiento').modal('show');
    listar_estado(ped_id);
    mostrar_pedido_seguimiento(ped_id);
}

function mostrar_pedido_seguimiento(ped_id){
    $.ajax({
        url: "../ajax/pedidos.php?op=mostrar_pedido",
        type: "POST",
        data: { ped_id: ped_id }, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON
            // Asignar valores a los campos del formulario
            $("#cli_nombre").text(data.cli_nombre);
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });

}


function listar_estado(ped_id_GET) {
    if ($.fn.DataTable.isDataTable("#tblSeguimiento")) {
        $('#tblSeguimiento').DataTable().clear().destroy();
    }    

    tablaDet = $("#tblSeguimiento").DataTable({
        ajax: {
            url: "../ajax/seguimiento.php?op=listar_estado",
            type: "GET",
            dataType: "json",
            data: { ped_id_GET: ped_id_GET }, // Enviar el parámetro cab_id
            error: function (e) {
                console.log(e.responseText);
            },
        }
    });

}



init()