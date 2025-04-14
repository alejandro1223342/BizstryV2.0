var tabla;

//funcion que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

}


//funcion limpiar
function limpiar() {
    $("#cat_id").val("");
    $("#cat_nombre").val("");
    $("#cat_descripcion").val("");
    $("#cat_padre").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#tbllistado").hide();
        $("#tbllistado_wrapper").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#tbllistado").show();
        $("#tbllistado_wrapper").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

function listar() {
    tabla = $("#tbllistado").DataTable({
        ajax: {
            url: "../ajax/cliente.php?op=listar",
            type: "GET",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            },
        },
        initComplete: function () {
            $("#tbllistado_wrapper").css("min-height", "300px"); // Mantiene la altura fija
        },
    });
}

function cancelarform() {
    limpiar();
    mostrarform(false);
}

//funcion para desactivar
function desactivar(cli_id) {

    $.post(
        "../ajax/cliente.php?op=desactivar",
        {cli_id: cli_id},
        function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
        }
    );

}

function activar(cli_id) {

    $.post(
        "../ajax/cliente.php?op=activar",
        {cli_id: cli_id},
        function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
        }
    );

}

//funcion para guardaryeditar
function guardaryeditar(e) {
    e.preventDefault(); // Detiene la acción por defecto del formulario

    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/cliente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            Swal.fire({
                title: "Operación exitosa",
                text: datos,
                icon: "success",
                confirmButtonColor: "#3085d6",
            }).then(() => {
                // Cerrar el modal y recargar la tabla
                $('#modalClientes').modal('hide');
                // Reactivar el botón "Guardar"
                $("#btnGuardar").prop("disabled", false);
                tabla.ajax.reload();
            });

        },

    });

    limpiar();
}

function open_Modal() {
    $('#modalClientes').modal('show');

    $.post("../ajax/cliente.php?op=provincia", function (r) {
        $("#cat_id_provincia").html(r); // Actualiza el contenido del select con la respuesta del servidor
        $("#cat_id_provincia").selectpicker('refresh'); // Vuelve a inicializar select2 después de cambiar su contenido

        // Seleccionar el primer valor por defecto
        let primerValor = $("#cat_id_provincia option:first").val();
        $("#cat_id_provincia").val(primerValor).change();
    });

    $("#cat_id_provincia").change(function () {
        let selectedValue = $(this).val();

        $.post("../ajax/cliente.php?op=parroquia", {cat_id_provincia: selectedValue}, function (r) {
            $("#cat_id_parroquia").html(r); // Actualiza el contenido del select con la respuesta del servidor
            $("#cat_id_parroquia").selectpicker('refresh'); // Vuelve a inicializar select2 después de cambiar su contenido
        });
    });

    $.post("../ajax/cliente.php?op=genero", function (r) {
        $("#cat_id_tipo_genero").html(r); // Actualiza el contenido del select con la respuesta del servidor
        $("#cat_id_tipo_genero").selectpicker('refresh'); // Vuelve a inicializar select2 después de cambiar su contenido
    });


}

function mostrar(cli_id) {
    $.ajax({
        url: "../ajax/cliente.php?op=mostrar",
        type: "POST",
        data: {cli_id: cli_id}, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON

            // Asignar valores a los campos del formulari
            $("#cli_id").val(data.cli_id);
            $("#cli_nombre").val(data.cli_nombre);
            $("#cli_identificacion").val(data.cli_cedula);
            setTimeout(function () {
                $("#cat_id_provincia").val(datos.cat_id_provincia);
            }, 500);
            $("#cat_id_parroquia").val(data.cat_id_ciudad);
            $("#cli_telefono").val(data.cli_telefono);
            $("#cli_telefono2").val(data.cli_telefonoDos);
            $("#cli_direccion").val(data.cli_direccion);
            $("#cli_correo").val(data.cli_correo);
            $("#cat_id_tipo_genero").val(data.cat_id_genero);
            open_Modal();

            //console.log(datos)
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });

}


init();
