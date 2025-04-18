<?php
require_once "../modelos/Seguimiento.php";
session_start();

$seguimiento = new Seguimiento();

$ped_id = isset($_POST["ped_id"]) ? limpiarCadena($_POST["ped_id"]) : "";
$ped_id_GET = isset($_GET["ped_id_GET"]) ? limpiarCadena($_GET["ped_id_GET"]) : "";


switch ($_GET["op"]) {

    
    case 'mostrar_pedido':
        $rspta = $pedidos->mostrar_pedido($ped_id);

        echo json_encode($rspta);
        break;

    case 'listar_estado':
        $rspta = $seguimiento->listar_estado($ped_id_GET);
        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $btnEditar = '';
            $btnVer = '';
            $btnDesactivar = '';
            $btnActivar = '';


            if($_SESSION['permisos']['Atención al Cliente']['eliminar'] == 1){
                $btnDesactivar = '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->pedEstado_id . ')"><i class="fa fa-times"></i></button>';
            }

            if($_SESSION['permisos']['Atención al Cliente']['editar'] == 1){
                $btnEditar = '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->pedEstado_id . ')"><i class="fa fa-pencil"></i></button>';
            }
            $data[] = array(
                "0" => $reg->estado,
                "1" => $reg->observaciones,
                "2" => $reg->fecha,
                "3" => $reg->usuario,
                "4" => '<center>' . $btnDesactivar .' '.$btnEditar .'</center>',
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
