function init() {
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

}


function listar() {
    tabla = $("#tbllistado").DataTable({
        ajax: {
            url: "../ajax/confirmarPedidos.php?op=listar",
            type: "GET",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            },
        },
        initComplete: function () {
            $("#tbllistado_wrapper").css("min-height", "300px"); // Mantiene la altura fija
        },
        columnDefs: [
            { className: 'text-center', targets: [0, 1, 2, 3, 4, 5] }
        ],
    });
}

function confirmarPedido(ped_id) {
    openModal();
    mostrar_pedido(ped_id);
    mostrar_detalle(ped_id);
}

function openModal() {
    $('#modalConfirmarPedido').modal('show');
    $.post("../ajax/confirmarPedidos.php?op=cofirmar", function (r) {
        $("#cat_id_estado").html(r); // Actualiza el contenido del select con la respuesta del servidor
        $("#cat_id_estado").selectpicker('refresh')(); // Inicializa select2 después de actualizar

    });
}


function mostrar_pedido(ped_id){
    $.ajax({
        url: "../ajax/confirmarPedidos.php?op=mostrar_pedido",
        type: "POST",
        data: { ped_id: ped_id }, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON
            // Asignar valores a los campos del formulario
            $("#ped_id").val(data.ped_id);
            $("#cli_nombre").text(data.cli_nombre);
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });

}

function mostrar_detalle(ped_id_GET){
    if ($.fn.DataTable.isDataTable("#tblDetalle")) {
        $("#tblDetalle").DataTable().destroy();
    }

    tablaDet = $("#tblDetalle").DataTable({
        ajax: {
            url: "../ajax/confirmarPedidos.php?op=listar_detallePedido",
            type: "GET",
            dataType: "json",
            data: { ped_id_GET : ped_id_GET }, // Enviar el parámetro cab_id
            error: function (e) {
                console.log(e.responseText);
            },
        }, columnDefs: [
            {
                targets: 0, // Índice de la columna 1 (es 0 porque el índice es 0 basado)
                width: '200px', // Establecer el ancho de la columna
                className: 'dt-center' // Centrar el contenido de la columna
            }
        ],
        dom: 't', // Solo muestra la tabla, sin los elementos de búsqueda y botones
        searching: false, // Desactiva la búsqueda
        paging: true, // Si necesitas paginación, mantén esto activado
        info: false, // Desactiva la información de filas mostradas
        ordering: false, // Desactiva la ordenación de las columnas
        initComplete: function () {
            $("#tbllistado_wrapper").css("min-height", "300px"); // Mantiene la altura fija
        },
    });

} 



function guardaryeditar(e) {
    e.preventDefault(); // Detiene la acción por defecto del formulario

    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/confirmarPedidos.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            bootbox.alert(datos);
            $('#modalConfirmarPedido').modal('hide');
            $("#btnGuardar").prop("disabled", false);

            tabla.ajax.reload();
        },


    });

    //limpiar();
}
init();