<?php
require_once "../modelos/Abonos.php";
session_start();

$abonos = new Abonos();

$ped_id = isset($_POST["ped_id"]) ? limpiarCadena($_POST["ped_id"]) : "";
$ped_id_GET = isset($_GET["ped_id_GET"]) ? limpiarCadena($_GET["ped_id_GET"]) : "";


switch ($_GET["op"]) {

    
   
    case 'listar_abonos':
        $rspta = $abonos->listar_abonos($ped_id_GET);
        $data = array();

        while ($reg = $rspta->fetch_object()) {

            $data[] = array(
                "0" => $reg->banco,
                "1" => $reg->formaPago,
                "2" => $reg->origenPago,
                "3" => $reg->abo_monto,
                "4" => $reg->abo_observaciones,
                "5" => $reg->estado,
                "6" => $reg->abo_fecha,
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
