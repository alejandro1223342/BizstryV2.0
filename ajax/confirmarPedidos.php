<?php
require_once "../modelos/ConfirmarPedidos.php";
session_start();

$pedidos = new ConfirmarPedidos();

$ped_id = isset($_POST["ped_id"]) ? limpiarCadena($_POST["ped_id"]) : "";
$ped_id_GET = isset($_GET["ped_id_GET"]) ? limpiarCadena($_GET["ped_id_GET"]) : "";
$cat_id_estado = isset($_POST["cat_id_estado"]) ? limpiarCadena($_POST["cat_id_estado"]) : "";
$ped_observaciones = isset($_POST["ped_observaciones"]) ? limpiarCadena($_POST["ped_observaciones"]) : "";
$usu_id = isset($_SESSION['usu_id']) ? $_SESSION['usu_id'] : "";  // Recupera el ID del usuario desde la sesión



switch ($_GET["op"]) {

    case 'listar':
        $rspta = $pedidos->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $botones = '<center>
                        <button class="btn btn-primary btn-xs" title="Ver Detalle" onclick="confirmarPedido(' . $reg->ped_id . ')">
                            <i class="fa fa-fw fa-eye"></i>
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

    case 'mostrar_pedido':
        $rspta = $pedidos->mostrar_pedido($ped_id);

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

    case 'cofirmar':
        $rspta = $pedidos->cofirmar();
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'guardaryeditar':
        if ($ped_id) {
            $rspta = $pedidos->guardaryeditar($ped_id,$cat_id_estado, $ped_observaciones,$usu_id);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        }
        break;
}
