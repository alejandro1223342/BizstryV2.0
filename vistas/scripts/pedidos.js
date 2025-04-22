// Declaración de variable global para la tabla principal
var tabla;

// === FUNCIONES PRINCIPALES ===

// Función de inicialización
function init() {
    listar();              // Carga la tabla principal con pedidos
    mostrarform(false);    // Oculta el formulario al inicio
    reajustar_tablas();    // Configura ajustes responsivos
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

// === FUNCIONES DE VALIDACIÓN Y EVENTOS ===

// Limpiar
//funcion limpiar
function limpiar() {
    $("#cab_numComprobante").val("");
    $("#cab_costoEnvio").val("0.00");
    $("#detven_descuento").text("0.00");
    $("#costoEnvio").text("0.00");  // Aquí cambiamos .val() por .text()
}

function limpiarTabla() {
    if ($.fn.DataTable.isDataTable('#tbllistado')) {
        let table = $('#tbllistado').DataTable();
        table.clear().draw(); // Limpia la tabla y la redibuja

        // Asegurar que las columnas 6, 7 y 8 sigan ocultas y no sean buscables
        table.columns([8, 9, 10]).visible(false, false);
    } else {
        $('#tbllistado').DataTable({
            searching: false,
            info: false,
            lengthChange: false,
            paging: false,
            columnDefs: [
                { targets: [8, 9, 10], visible: false, searchable: false } // Oculta y desactiva búsqueda en estas columnas
            ]
        });
    }

    const tbody = document.querySelector('#tbllistado tbody');
    tbody.innerHTML = ''; // Elimina todas las filas del cuerpo de la tabla
    recalcularTotal(); // Recalcula el total, que debería ser 0 ahora
}

function inicializarTablaPrendas() {
    const isSmallScreen = window.innerWidth <= 768;

    // Si la tabla ya está inicializada, destrúyela antes de reinicializarla
    if ($.fn.dataTable.isDataTable('#tbllistadoPrendas')) {
        $('#tbllistadoPrendas').DataTable().clear().destroy();
    }

    // Inicializa la tabla de nuevo
    $('#tbllistadoPrendas').DataTable({
        searching: false,
        info: false,
        lengthChange: false,
        paging: false,
        responsive: false,
        scrollX: isSmallScreen, // solo activa scroll en móviles
        autoWidth: false,
        columnDefs: [
            {
                targets: [7, 8, 9], // columnas de ID ocultas
                visible: false,
                searchable: false
            },
            // Ajustar anchos de columnas visibles
            { targets: 0, width: '25%' }, // Prenda
            { targets: 1, width: '20%' }, // Diseño
            { targets: 2, width: '5%' }, // Cantidad
            { targets: 3, width: '5%' }, // Subtotal
            { targets: 4, width: '5%' }, // Descuento
            { targets: 5, width: '15%' }, // Promoción
            { targets: 6, width: '5%' }  // Acciones
        ],
        language: {
            emptyTable: "Sin datos"
        }
    });
}



function cancelarform() {
    limpiar();
    limpiarTabla();
    mostrarform(false);
}

//funcion para guardaryeditar
function guardaryeditar(e) {
    e.preventDefault(); // Detiene la acción por defecto del formulario

    // Verificar si el costo de envío es válido
    // if (!validarCostoEnvio()) {
    //     return; // Si la validación falla, no continúa con el guardado o edición
    // }
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    const table = $("#tbllistadoPrendas").DataTable();
    const prendas = [];

    // Verificar si hay filas en el DataTable
    if (table.rows().count() === 0) {
        bootbox.alert("Debes agregar al menos una prenda antes de guardar.");
        $("#btnGuardar").prop("disabled", false);
        return; // Detener la ejecución si no hay filas
    }

    // Recorrer todas las filas, incluyendo las no visibles (paginadas o filtradas)
    table.rows({ search: 'applied', page: 'all' }).every(function () {
        const row = this.node(); // Obtener el nodo de la fila actual
        const data = this.data(); // Obtener los datos de la fila actual

        // Obtener los valores de las columnas (tanto visibles como ocultas)
        const prendaId = data[7] || row.cells[0]?.getAttribute('data-id'); // Columna oculta 8
        const disenioId = data[8] || row.cells[1]?.getAttribute('data-id'); // Columna oculta 9
        const promoId = data[9] || row.cells[6]?.getAttribute('data-id'); // Columna oculta 10

        const cantidad = data[2]; // Columna visible 2
        const subtotal = data[3]; // Columna visible 3 (suponiendo que el subtotal se encuentra aquí)
        const descuento = data[4];
        // Validación de que el subtotal existe y es un número
        if (!prendaId || !disenioId || !cantidad || !subtotal) {
            console.error("Faltan valores en la fila:", data);
            return; // Si falta algún dato, no agregamos esta fila
        }

        // Agregar los datos al array de prendas
        prendas.push({
            prendaId: prendaId,
            disenioId: disenioId,
            cantidad: cantidad,
            total: subtotal,
            descuento: descuento,
            promoId: promoId
        });
    });

    console.log(prendas);


    // Agregar los datos de la tabla al formData
    formData.append('prendas', JSON.stringify(prendas));
    // Enviar los datos a través de AJAX
    $.ajax({
        url: "../ajax/pedidos.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            try {
                const respuesta = JSON.parse(datos);
                const mensaje = respuesta.mensaje || "Operación realizada.";
                bootbox.alert(mensaje);
                mostrarform(false);
                tabla.ajax.reload();
                limpiarTabla();
                limpiar();
            } catch (e) {
                console.error("Error al parsear la respuesta del servidor:", e);
                bootbox.alert("Error inesperado. No se pudo guardar el pedido.");
            }
        },
    });

    limpiar();  // Limpia los campos del formulario al final
}

function saveForm() {
    event.preventDefault(); // Prevenir el envío del formulario

    // Obtener valores de los campos
    const prendaId = $('#pre_id').val();
    const disenioId = $('#cat_id_disenio').val();
    const cantidad = parseInt($('#cantidad').val(), 10);
    const descuento = parseFloat($('#detven_descuento').val()) || 0.00;
    const promoId = $('#cat_id_promo').val();

    const precio = parseFloat($('#pre_id option:selected').data('precio'));
    const prendaText = $('#pre_id option:selected').text();
    const disenioText = $('#cat_id_disenio option:selected').text();
    const promoText = $('#cat_id_promo option:selected').text() || 'Sin promoción';

    // Validación
    if (!prendaId || !disenioId || isNaN(cantidad) || isNaN(precio) || cantidad <= 0) {
        alert('Todos los campos obligatorios deben estar llenos y cantidad debe ser mayor a 0.');
        return;
    }

    const total = precio * cantidad;
    const totalDescuento = total - descuento;

    // Verificar si DataTable ya está inicializado
    let table = $.fn.dataTable.isDataTable('#tbllistadoPrendas')
        ? $('#tbllistadoPrendas').DataTable()
        : $('#tbllistadoPrendas').DataTable({
            searching: false,
            info: false,
            lengthChange: false,
            paging: false,
            columnDefs: [
                {
                    targets: [7, 8, 9], // Índices de las columnas a ocultar
                    visible: false, // Oculta las columnas
                    searchable: false // Evita que se usen en la búsqueda
                },
                // Ajustar anchos de columnas visibles
                { targets: 0, width: '25%' }, // Prenda
                { targets: 1, width: '20%' }, // Diseño
                { targets: 2, width: '5%' }, // Cantidad
                { targets: 3, width: '5%' }, // Subtotal
                { targets: 4, width: '5%' }, // Descuento
                { targets: 5, width: '15%' }, // Promoción
                { targets: 6, width: '5%' }  // Acciones
            ]
        });

    // Eliminar la fila con el mensaje "No se encontraron registros" si existe
    const tbody = document.querySelector('#tbllistadoPrendas tbody');
    if (tbody) {
        const noDataRow = tbody.querySelector('td.dataTables_empty');
        if (noDataRow) {
            noDataRow.closest('tr').remove();
        }
    }

    // Crear los datos para la nueva fila
    const newRowData = [
        prendaText,  // Columna 1: Nombre de la prenda
        disenioText, // Columna 2: Nombre del diseño
        cantidad,    // Columna 3: Cantidad
        total.toFixed(2), // Columna 4: Total con 2 decimales
        descuento != null ? descuento.toFixed(2) : null,
        promoText,   // Columna 5: Promoción aplicada
        `<center><button type="button" class="btn btn-danger btn-xs" onclick="eliminarFila(this)">
        <i class="fa fa-trash"></i></button></center>`, // Columna 6: Botón eliminar
        prendaId,
        disenioId,
        promoId
    ];

    // Agregar la nueva fila a la tabla
    table.row.add(newRowData).draw();

    // Recalcular total de la tabla
    // recalcularTotal();

    // Resetear los campos del formulario
    $('#pre_id, #cat_id_disenio, #cat_id_promo').val('').trigger('change'); // Reset Select2
    $('#cantidad').val('');
    $('#detven_descuento').val('0.00');
}

// Función para recalcular el total general
function recalcularTotal() {
    let total = 0;
    document.querySelectorAll('#tbllistadoPrendas tbody tr').forEach(row => {
        const subtotal = parseFloat(row.children[3].textContent);
        total += subtotal;
    });
    document.getElementById('totalGeneral').textContent = total.toFixed(2);
}

function eliminarFila(btn) {
    // Obtener la fila que contiene el botón
    const row = btn.closest('tr');
    // Eliminar la fila de la tabla
    row.remove();
    // Recalcular el total después de eliminar la fila
    recalcularTotal();
}

function cargarSelectsConDatos(data) {
    // Objeto con la relación de selectores y los endpoints de donde obtener los datos
    const selects = {
        "#usu_venta": "usuario_venta",
        "#cat_id_banco": "banco",
        "#cat_id_formaPago": "tipoPago",
        "#cat_id_origenPago": "origenPago",
        "#cat_id_canalVenta": "canalVenta",
        "#cab_paqueteria": "paqueteria"
    };

    // Promesas para esperar que todos los selects se carguen antes de asignar valores
    let promises = [];

    Object.entries(selects).forEach(([selector, endpoint]) => {
        let promise = $.post(`../ajax/pedidos.php?op=${endpoint}`, function (r) {
            $(selector).html(r).selectpicker("refresh");
        });
        promises.push(promise);
    });

    // Cuando todos los selects han terminado de cargar, asignamos los valores de data
    $.when(...promises).done(() => {
        $("#usu_venta").val(data.cab_usuVenta).trigger("change");
        $("#cat_id_banco").val(data.cat_id_banco).trigger("change");
        $("#cat_id_formaPago").val(data.cat_id_formaPago).trigger("change");
        $("#cat_id_origenPago").val(data.cat_id_origenPago).trigger("change");
        $("#cat_id_canalVenta").val(data.cat_id_canalVenta).trigger("change");
        $("#cab_paqueteria").val(data.cab_paqueteria).trigger("change");
    });
}

function mostrar_cabecera(cab_id_post) {
    $.ajax({
        url: "../ajax/confirmarPedidos.php?op=mostrar",
        type: "POST",
        data: { cab_id_post: cab_id_post }, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON
            // Asignar valores a los campos del formulario
            $("#nombre").text(data.cli_nombre);
            $("#direccion").text(data.cli_direccion);
            $("#ciudad").text(data.direccion);
            $("#telefono").text(data.cli_telefono);
            $("#correo").text(data.cli_correo);
            $("#numComprobante").text(data.cab_numComprobante);
            $("#tipoPago").text(data.tipoPago);
            $("#cab_envio").text("$" + data.cab_costoEnvio);
            $("#cab_total").text("$" + data.cab_sinDesc); // Agregar el símbolo del dólar al valor
            $("#id").text(data.cab_id);
            $("#cab_id").val(data.cab_id);
            $("#totalSinEnvio").text("$" + data.cab_totalSinEnvio);
            $("#estado").text(data.estado);
            $("#motivo").text(data.cab_observacion);
            $("#cat_id_Banco").text(data.banco);
            $("#cat_id_origen").text(data.origenPago);
            $("#cab_abono").text(data.cab_abono);
            $("#cat_id_Banco").text(data.banco);
            $("#id_origen").text(data.origenPago);
            $("#id_abono").text("$" + data.cab_abono);
            $("#cab_desc").text("$" + data.cab_descuento);
            $("#cab_totalDescuento").text("$" + data.cab_total);
            $("#paqueteria").text(data.paqueteria);
            $("#fecha_pedido").text(data.cab_fecha);
            $("#fecha_revisado").text(data.cab_fechaRev);

            const descuento = data.cab_descuento || "";
            const abono = data.cab_abono || "";
            const observacion = data.cab_observacion || "";

            if (descuento.trim() === "0.00") {
                // Ocultar los campos si cab_descuento es "0.00"
                $("#cab_desc").hide();
                $("#descuento_titulo").hide();
                $("#cab_totalDescuento").hide();
                $("#total_titulo").hide();
            } else {
                // Mostrar los campos si cab_descuento no es "0.00"
                $("#cab_desc").show();
                $("#descuento_titulo").show();
                $("#cab_totalDescuento").show().text(data.cab_total);
                $("#total_titulo").show();
            }

            if (abono.trim() === "0.00") {
                // Ocultar la etiqueta y el campo de motivo si está vacío
                $("#id_abono").hide();
                $("#abono_titulo").hide();
            } else {
                // Mostrar el motivo si no está vacío
                $("#abono_titulo").show();
                $("#id_abono").show().text(data.cab_abono);
            }

            if (!observacion.trim()) {
                // Ocultar la etiqueta y el campo de motivo si está vacío
                $("#hiddenMotivo").hide();
                $("#motivo").hide();
            } else {
                // Mostrar el motivo si no está vacío
                $("#hiddenMotivo").show();
                $("#motivo").show().text(data.cab_observacion);
            }

        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });
}

$("#btnCliente").on("click", function () {
    const cli_codigo = $("#cli_codigo").val(); // Obtener valor del input
    if (cli_codigo) {
        mostrar_Cliente(cli_codigo); // Llamar función si hay código
    } else {
        alert("Por favor, ingresa un código de cliente.");
    }
});

// Función para mostrar cliente
function mostrar_Cliente(cli_codigo) {
    $.ajax({
        url: "../ajax/pedidos.php?op=mostrar_cliente",
        type: "POST",
        data: { cli_codigo: cli_codigo }, // Enviar cli_codigo como dato
        success: function (datos) {
            try {
                const data = JSON.parse(datos); // Parsear la respuesta a JSON
                // Asignar valores a los campos del formulario
                $("#cli_cod").text(data.codigo || "N/A");
                $("#cli_nombre").text(data.cli_nombre || "N/A");
                $("#cli_direccion").text(data.cli_direccion || "N/A");
                $("#cli_telefono").text(data.cli_telefono || "N/A");
                $("#cli_correo").text(data.cli_correo || "N/A");
                $("#cli").val(data.cli_id || ""); // Input oculto con el ID
            } catch (e) {
                console.error("Error al procesar los datos:", e);
                Swal.fire({
                    icon: 'warning',
                    title: 'Cliente no encontrado',
                    text: 'El código ingresado no corresponde a ningún cliente.',
                }); $("#cli_cod").text("N/A");
                $("#cli_nombre").text("N/A");
                $("#cli_direccion").text("N/A");
                $("#cli_telefono").text("N/A");
                $("#cli_correo").text("N/A");
                $("#cli").val(""); // Input oculto con el ID
            }
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
            alert("Error al buscar el cliente. Por favor, intenta nuevamente.");
        },
    });
}

// === AJUSTE DE TABLAS CON RESPONSIVE ===
// Ajusta DataTable cuando se redimensiona la ventana o colapsa menú lateral
function reajustar_tablas() {
    let resizeTimeout;

    // Reajuste al cambiar tamaño de ventana
    $(window).on('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function () {
            if ($.fn.DataTable.isDataTable('#tbllistado')) {
                $('#tbllistado').DataTable().columns.adjust().responsive.recalc();
            }
        }, 200);
    });

    // Reajuste al colapsar o expandir el menú lateral
    $(document).on('click', '[data-widget="pushmenu"]', function () {
        setTimeout(function () {
            if ($.fn.DataTable.isDataTable('#tbllistado')) {
                $('#tbllistado').DataTable().columns.adjust().responsive.recalc();
            }
        }, 500); // Tiempo acorde a animación de AdminLTE
    });
}

// === CARGA DINÁMICA DE SELECTS DESDE EL SERVIDOR ===

function selects() {
    // Utiliza el mismo patrón para evitar código duplicado
    const combos = [
        { id: "#pre_id", op: "prendas" },
        { id: "#cat_id_disenio", op: "disenio" },
        { id: "#cat_id_promo", op: "promocion" },
        { id: "#usu_venta", op: "usuario_Venta" },
        { id: "#cat_id_banco", op: "banco" },
        { id: "#cat_id_formaPago", op: "formaPago" },
        { id: "#cat_id_origenPago", op: "origenPago" },
        { id: "#cab_paqueteria", op: "paqueteria" },
        { id: "#cat_id_canalVenta", op: "canalVenta" }
    ];

    combos.forEach(combo => {
        $.post(`../ajax/pedidos.php?op=${combo.op}`, function (r) {
            $(combo.id).html(r);
            $(combo.id).selectpicker('refresh');
        });
    });

    $('#pre_id').selectpicker({ dropupAuto: false }); // Config opcional
}

// === MOSTRAR U OCULTAR FORMULARIO ===
function mostrarform(flag) {
    if (flag) {
        // Mostrar formulario
        $('#listadoregistros').fadeOut(300, function () {
            $('#formularioPedido').addClass('active');
        });
        $("#btnagregar").fadeOut(300);
        $('#headerPedido').fadeOut(300);
        selects(); // Cargar selects al abrir formulario
        inicializarTablaPrendas()

    } else {
        // Ocultar formulario
        $('#formularioPedido').removeClass('active');
        setTimeout(function () {
            $('#listadoregistros').fadeIn(300);
        }, 300);
        $("#btnagregar").fadeIn(300);
        $('#headerPedido').fadeIn(300);
    }
}

// === LISTADO PRINCIPAL DE PEDIDOS ===
function listar() {
    tabla = $("#tbllistado").DataTable({
        responsive: {
            details: {
                type: 'inline',
                target: 'tr'
            }
        },
        autoWidth: false,
        ajax: {
            url: "../ajax/pedidos.php?op=listar_pedidos",
            type: "GET",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        initComplete: function () {
            $("#tbllistado_wrapper").css("min-height", "300px");
        },
        columnDefs: [
            { className: 'text-center', targets: "_all" },
            { width: "15px", targets: 0 },
            { width: "250px", targets: 1 },
            { width: "150px", targets: 2 },
            { width: "110px", targets: 3 },
            { width: "130px", targets: 4 },
            { width: "217px", targets: 5 },
            { responsivePriority: 1, targets: 1 },
            { responsivePriority: 2, targets: 5 },
            { responsivePriority: 10001, targets: 2 },
            { responsivePriority: 10002, targets: 3 }
        ],
        dom: 'frtip'
    });
}

// === MOSTRAR DETALLE DE UN PEDIDO ===

function detallePedido(ped_id) {
    $('#modalDetallePedido').modal('show');
    mostrar_pedido(ped_id);       // Mostrar datos principales
    mostrar_detalle(ped_id);      // Mostrar detalle del pedido
}

// Muestra datos generales del pedido
function mostrar_pedido(ped_id) {
    $.ajax({
        url: "../ajax/pedidos.php?op=mostrar_pedido",
        type: "POST",
        data: { ped_id: ped_id },
        success: function (datos) {
            const data = JSON.parse(datos);
            $("#nombre").text(data.cli_nombre);
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        }
    });
}

// Muestra tabla de detalles del pedido
function mostrar_detalle(ped_id_GET) {
    if ($.fn.DataTable.isDataTable("#tblDetalle")) {
        $("#tblDetalle").DataTable().destroy();
    }

    $("#tblDetalle").DataTable({
        ajax: {
            url: "../ajax/pedidos.php?op=listar_detallePedido",
            type: "GET",
            dataType: "json",
            data: { ped_id_GET: ped_id_GET },
            error: function (e) {
                console.log(e.responseText);
            }
        },
        columnDefs: [
            {
                targets: 0,
                width: '300px',
                className: 'dt-center'
            }
        ],
        dom: 't',
        searching: false,
        paging: true,
        info: false,
        ordering: false,
        initComplete: function () {
            $("#tbllistado_wrapper").css("min-height", "300px");
        }
    });
}

function cabecera(cab_id) {
    $.ajax({
        url: "../ajax/pedidos.php?op=cabecera",
        type: "POST",
        data: { cab_id: cab_id }, // Enviar cab_id como datos
        success: function (datos) {
            const data = JSON.parse(datos); // Parsear la respuesta a JSON

            // Cargar los selects con los datos recibidos
            cargarSelectsConDatos(data);
            $("#cli_codigo").val(data.codigo);
            $("#cli_cod").text(data.codigo);
            $("#cli_nombre").text(data.cli_nombre);
            $("#cli_direccion").text(data.cli_direccion);
            $("#cli_ciudad").text(data.direccion);
            $("#cli_telefono").text(data.telefono);
            $("#cli_correo").text(data.cli_correo);
            $("#cab_numComprobante").val(data.cab_numComprobante);
            $("#cab_costoEnvio").val(data.cab_costoEnvio);
            $("#cab_abono").val(data.cab_abono);

            $('#cab_id').val(data.cab_id);
            $('#cli').val(data.cli_id);
            $("#cab_descuento").val(data.cab_descuento);
            $("#costoEnvio").text(data.cab_costoEnvio);
            $("#totalValor").text(data.cab_totalSinEnvio);

            $("#totalConEnvio").text(data.cab_total);
            $("#descuento").text(data.cab_descuento);
            $("#totalConDescuento").text(data.cab_descuento);
        },
        error: function (e) {
            console.error("Error en la solicitud:", e.responseText);
        },
    });
}

function detalle(cab_id) {
    if ($.fn.DataTable.isDataTable("#tbllistadoPrendas")) {
        $("#tbllistadoPrendas").DataTable().destroy();
    }
    $("#tbllistadoPrendas").DataTable({
        ajax: {
            url: "../ajax/pedidos.php?op=listar_prod",
            type: "GET",
            dataType: "json",
            data: { cab_id: cab_id },
            error: function (e) {
                console.log(e.responseText);
            },
        },
        dom: 'tp', // 🔹 Agrega paginación
        searching: false,
        paging: true, // 🔹 Asegura que la paginación esté activada
        info: false,
        ordering: false,
        autoWidth: false,
        scrollX: true,
        pageLength: 10, // 🔹 Número de filas por página (ajústalo según necesidad)
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]], // 🔹 Opciones de paginación
        columnDefs: [
            { targets: 0, width: '25%', className: 'dt-left' },  // Prenda (Más ancho)
            { targets: 1, width: '25%', className: 'dt-center' },// Diseño (Más ancho)
            { targets: 2, width: '5%', className: 'dt-center' }, // Cantidad (Número pequeño)
            { targets: 3, width: '5%', className: 'dt-right' },  // Subtotal (Número pequeño)
            { targets: 4, width: '5%', className: 'dt-right' },  // Descuento (Número pequeño)
            { targets: 5, width: '5%', className: 'dt-right' },  // Total (Número pequeño)
            { targets: 6, width: '25%', className: 'dt-center' },// Promoción (Más ancho)
            { targets: 7, width: '5%', className: 'dt-center' }, // Acciones (Botón pequeño)
            { targets: [8, 9, 10], visible: false, searchable: false } // Ocultar IDs
        ]
    });
}

function editar(cab_id) {
    cabecera(cab_id);
    detalle(cab_id);
    mostrarform(true);
}


function eliminar(detven_id) {
    $.post(
        "../ajax/pedidos.php?op=eliminar",
        { detven_id: detven_id },
        function (e) {
            bootbox.alert(e);
            tablaprod.ajax.reload();
        }
    );
}

// === INICIALIZACIÓN AUTOMÁTICA AL CARGAR ===
init();
