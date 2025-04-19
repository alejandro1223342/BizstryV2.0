
function agregarAbono(ped_id) {
    console.log("Ejecutando agregarAbono con ped_id:", ped_id);
    $('#modalAbonos').modal('show');
    listar_abonos(ped_id);
    mostrar_pedido_abonos(ped_id);
}

function mostrar_pedido_abonos(ped_id){
    $.ajax({
        url: "../ajax/pedidos.php?op=mostrar_pedido",
        type: "POST",
        data: { ped_id: ped_id }, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON
            // Asignar valores a los campos del formulario
            $("#cliente_nombre").text(data.cli_nombre);
            $("#cliente_direccion").text(data.cli_direccion);
            $("#cliente_ciudad").text(data.ciudad);

            $("#pedido_id").text(data.ped_id);
            $("#total_pedido").text(data.ped_total);
            $("#total_saldo").text(data.saldoPendiente);
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });

}

function listar_abonos(ped_id_GET) {
    if ($.fn.DataTable.isDataTable("#tblAbonos")) {
        $('#tblAbonos').DataTable().clear().destroy();
    }    

    tablaDet = $("#tblAbonos").DataTable({
        ajax: {
            url: "../ajax/abonos.php?op=listar_abonos",
            type: "GET",
            dataType: "json",
            data: { ped_id_GET: ped_id_GET }, // Enviar el parámetro cab_id
            error: function (e) {
                console.log(e.responseText);
            },
        }
    });

}
