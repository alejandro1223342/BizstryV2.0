<?php
require_once "../modelos/Pedidos.php";
session_start();

$pedidos = new Pedidos();
$cli_codigo = isset($_POST["cli_codigo"]) ? limpiarCadena($_POST["cli_codigo"]) : "";
$cab_id = isset($_POST["cab_id"]) ? limpiarCadena($_POST["cab_id"]) : "";
$usu_id = isset($_SESSION['usu_id']) ? $_SESSION['usu_id'] : "";
$cli = isset($_POST["cli"]) ? limpiarCadena($_POST["cli"]) : "";
$cat_id_banco = isset($_POST["cat_id_banco"]) ? limpiarCadena($_POST["cat_id_banco"]) : "";
$cat_id_tipoPago = isset($_POST["cat_id_formaPago"]) ? limpiarCadena($_POST["cat_id_formaPago"]) : "";
$cat_id_canalVenta = isset($_POST["cat_id_canalVenta"]) ? limpiarCadena($_POST["cat_id_canalVenta"]) : "";
$cab_numComprobante = isset($_POST["cab_numComprobante"]) ? limpiarCadena($_POST["cab_numComprobante"]) : "";
$cab_paqueteria = isset($_POST["cab_paqueteria"]) ? limpiarCadena($_POST["cab_paqueteria"]) : "";
$cab_costoEnvio = isset($_POST["cab_costoEnvio"]) ? limpiarCadena($_POST["cab_costoEnvio"]) : "";
$hiddenTotalValor = isset($_POST["hiddenTotalValor"]) ? floatval(limpiarCadena($_POST["hiddenTotalValor"])) : 0;
$hiddenTotalconEnvio = isset($_POST["hiddenTotalconEnvio"]) ? floatval(limpiarCadena($_POST["hiddenTotalconEnvio"])) : 0;
$prendas = isset($_POST['prendas']) ? json_decode($_POST['prendas'], true) : [];
$cat_id_origenPago = isset($_POST["cat_id_origenPago"]) ? limpiarCadena($_POST["cat_id_origenPago"]) : "";
$cab_abono = isset($_POST["cab_abono"]) ? limpiarCadena($_POST["cab_abono"]) : "";
$cab_descuento = isset($_POST["cab_descuento"]) ? limpiarCadena($_POST["cab_descuento"]) : "";
$usu_venta = isset($_POST["usu_venta"]) ? limpiarCadena($_POST["usu_venta"]) : "";
$detven_id = isset($_POST["detven_id"]) ? limpiarCadena($_POST["detven_id"]) : "";

$ped_id = isset($_POST["ped_id"]) ? limpiarCadena($_POST["ped_id"]) : "";
$ped_id_GET = isset($_GET["ped_id_GET"]) ? limpiarCadena($_GET["ped_id_GET"]) : "";

switch ($_GET["op"]) {

    case 'usuario_Venta':
        $rspta = $pedidos->usuario_Venta();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->usu_id . '>' . $reg->usu_nombre . '</option>';
        }
        break;

    case 'banco':
        $rspta = $pedidos->banco();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value="' . $reg->cat_id . '">' . $reg->cat_nombre . ' - ' . $reg->cat_descripcion . '</option>';
        }
        break;

    case 'tipoCuenta':
        $rspta = $pedidos->tipoCuenta();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'formaPago':
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        $rspta = $pedidos->formaPago();
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'origenPago':
        $rspta = $pedidos->origenPago();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;
    case 'canalVenta':
        $rspta = $pedidos->canalVenta();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;
    case 'paqueteria':
        $rspta = $pedidos->paqueteria();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'prendas':
        $rspta = $pedidos->prendas();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value="' . $reg->pre_id . '" data-id="' . $reg->pre_id . '" data-precio="' . $reg->pre_venta . '">'
                . $reg->prenda . ' COLOR ' . $reg->color . ' TALLA ' . $reg->medida . ': STOCK DISPONIBLE ' . $reg->pre_stock . '</option>';
        }
        break;

    case 'disenio':
        $rspta = $pedidos->disenio();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value="' . $reg->dis_id . '" data-id="' . $reg->dis_id . '">' . $reg->cat_nombre . ': STOCK DISPONIBLE ' . $reg->cat_stock . '</option>';
        }
        break;

    case 'promocion':
        $rspta = $pedidos->promocion();
        echo '<option value="">SELECCIONE</option>'; // Agrega esta línea para incluir la opción inicial
        while ($reg = $rspta->fetch_object()) {
            echo '<option value="' . $reg->cat_id . '" data-id="' . $reg->cat_id . '">' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'listar_pedidos':
        $rspta = $pedidos->listar_pedidos();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $botones = '<center>
                        <button class="btn btn-primary btn-xs" title="Ver Detalle" onclick="detallePedido(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-eye"></i>
                        </button>
                        <button class="btn btn-warning btn-xs" title="Editar Pedido" onclick="editarPedido(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-edit"></i>
                        </button>
                        <button class="btn btn-info btn-xs" title="Registrar Seguimiento" onclick="registrarSeguimiento(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-map-marker"></i>
                        </button>
                        <button class="btn btn-darkgray btn-xs" title="Agregar Abono" onclick="agregarAbono(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-dollar"></i>
                        </button>
                        <button class="btn btn-danger btn-xs" title="Cancelar Pedido" onclick="cancelarPedido(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </center>';

            $data[] = array(
                "0" => $reg->ped_id,
                "1" => $reg->cliente,
                "2" => $reg->paqueteria,
                "3" => $reg->formaPago,
                "4" => $reg->estadoActual,
                "5" => $botones,
            );
        }
        $results = array(
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'guardaryeditar':
        if (empty($cab_id)) {
            // Depuración del contenido de $prendas
            var_dump($prendas);  // Esto te mostrará cómo llega el array de prendas
            $rspta = $pedidos->insertar(
                $usu_id,
                $cli,
                $cat_id_banco,
                $cat_id_tipoPago,
                $cat_id_origenPago,
                $cab_numComprobante,
                $cab_paqueteria,
                $cab_costoEnvio,
                $cab_descuento,
                $usu_venta,
                $prendas
            );
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        } else {
            // Código de actualización
            $rspta = $pedidos->editar(
                $usu_id,
                $cli,
                $cat_id_banco,
                $cat_id_tipoPago,
                $cat_id_origenPago,
                $cab_numComprobante,
                $cab_paqueteria,
                $cat_id_canalVenta,
                $hiddenTotalValor,
                $cab_costoEnvio,
                $cab_descuento,
                $hiddenTotalconEnvio,
                $cab_abono,
                $usu_venta,
                $prendas,
                $cab_id
            );
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;

    case 'mostrar_pedido':
        $rspta = $pedidos->mostrar_pedido($ped_id);

        echo json_encode($rspta);
        break;

    case 'mostrar_cliente':
        $rspta = $pedidos->mostrar_cliente($cli_codigo);

        echo json_encode($rspta);
        break;

    case 'listar_detallePedido':
        $rspta = $pedidos->listar_detallePedido($ped_id_GET);
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->det_cantidad,
                "1" => $reg->producto,
                "2" => $reg->promocion,
                "3" => $reg->det_precioUnitario,
                "4" => $reg->det_descuento,
                "5" => $reg->det_subtotal,
            );
        }

        $results = array(
            "sEcho" => 1, // Información para DataTables
            "iTotalRecords" => count($data), // Total de registros
            "iTotalDisplayRecords" => count($data), // Total de registros visibles
            "aaData" => $data // Datos para el DataTable
        );

        echo json_encode($results);
        break;
}
