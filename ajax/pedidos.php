<?php
require_once "../modelos/Pedidos.php";
session_start();

$pedidos = new Pedidos();

$ped_id = isset($_POST["ped_id"]) ? limpiarCadena($_POST["ped_id"]) : "";
$ped_id_GET = isset($_GET["ped_id_GET"]) ? limpiarCadena($_GET["ped_id_GET"]) : "";


switch ($_GET["op"]) {

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
                        <button class="btn btn-cyan btn-xs" title="Agregar Abono" onclick="agregarAbono(' . $reg->ped_id . ')">
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
}
