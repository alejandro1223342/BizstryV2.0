
<?php
require_once "../modelos/Cliente.php";
session_start();
$cliente = new Cliente();
$usu_id = isset($_SESSION['usu_id']) ? $_SESSION['usu_id'] : "";  // Recupera el ID del usuario desde la sesión
$cli_id = isset($_POST["cli_id"]) ? limpiarCadena($_POST["cli_id"]) : "";
$cli_nombre = isset($_POST["cli_nombre"]) ? limpiarCadena($_POST["cli_nombre"]) : "";
$cat_id_tipo_identificacion = isset($_POST["cat_id_tipo_identificacion"]) ? limpiarCadena($_POST["cat_id_tipo_identificacion"]) : "";
$cli_identificacion = isset($_POST["cli_identificacion"]) ? limpiarCadena($_POST["cli_identificacion"]) : "";
$cli_telefono = isset($_POST["cli_telefono"]) ? limpiarCadena($_POST["cli_telefono"]) : "";
$cli_telefono2 = isset($_POST["cli_telefono2"]) ? limpiarCadena($_POST["cli_telefono2"]) : "";
$cli_correo = isset($_POST["cli_correo"]) ? limpiarCadena($_POST["cli_correo"]) : "";
$cat_id_provincia = isset($_POST["cat_id_provincia"]) ? limpiarCadena($_POST["cat_id_provincia"]) : "";
$cat_id_parroquia = isset($_POST["cat_id_parroquia"]) ? limpiarCadena($_POST["cat_id_parroquia"]) : "";
$cli_direccion = isset($_POST["cli_direccion"]) ? limpiarCadena($_POST["cli_direccion"]) : "";
$cat_id_tipo_genero = isset($_POST["cat_id_tipo_genero"]) ? limpiarCadena($_POST["cat_id_tipo_genero"]) : "";



switch ($_GET["op"]) {


    case 'genero':
        $rspta = $cliente->genero();
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'provincia':
    $rspta = $cliente->provincia();
    while ($reg = $rspta->fetch_object()) {
        echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
    }
    break;

    case 'parroquia':
        $rspta = $cliente->parroquia($cat_id_provincia);
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;
    case 'listar':
        $rspta = $cliente->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $btnEditar = '';
            $btnVer = '';
            $btnDesactivar = '';
            $btnActivar = '';


            if($_SESSION['permisos']['Atención al Cliente']['eliminar'] == 1){
                $btnDesactivar = '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->cli_id . ')"><i class="fa fa-times"></i></button>';
            }

            if($_SESSION['permisos']['Atención al Cliente']['eliminar'] == 1){
                $btnActivar = '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->cli_id . ')"><i class="fa fa-check"></i></button>';
            }

            if($_SESSION['permisos']['Atención al Cliente']['editar'] == 1){
                $btnEditar = '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->cli_id . ')"><i class="fa fa-pencil"></i></button>';
            }

            $data[] = array(
                "0" =>($reg->cli_estado) ?
                    '<center>' . $btnDesactivar .' '.$btnEditar .'</center>' :
                    '<center>' . $btnActivar .' '.$btnEditar .'</center>',
                "1" => $reg->codigo,
                "2" => $reg->cli_nombre,
                "3" => $reg->cli_telefono,
                "4" => $reg->cli_correo,
                "5" => $reg->provincia,
                "6" => $reg->parroquia,
                "7" => $reg->cli_direccion,
                "8" => ($reg->cli_estado) ? '<span class="label label-success">Activado</span>' : '<span class="label label-warning">Desactivado</span>'
            );
        }
        $results = array(
            "sEcho" => 1,//info para datatables
            "iTotalRecords" => count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data),//enviamos el total de registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
        break;


    case 'desactivar':
        $rspta = $cliente->desactivar($cli_id);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $cliente->activar($cli_id);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;


    case 'guardaryeditar':
        if (empty($cli_id)) {
            $rspta = $cliente->insertar($cli_nombre, $cli_identificacion,
                $cli_telefono,$cli_telefono2,$cli_correo, $cat_id_provincia,$cat_id_parroquia,$cli_direccion,$cat_id_tipo_genero,$usu_id);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        } else {
            //echo "Valor de cat_id: " . $cat_id; // Imprime el valor de cat_id

            $rspta = $cliente->editar($cli_nombre, $cli_identificacion,
                $cli_telefono,$cli_telefono2,$cli_correo, $cat_id_provincia,$cat_id_parroquia,$cli_direccion,$cat_id_tipo_genero,$cli_id);
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;

    case 'mostrar' :
        $rspta = $cliente->mostrar($cli_id);

        echo json_encode($rspta);
        break;


}
