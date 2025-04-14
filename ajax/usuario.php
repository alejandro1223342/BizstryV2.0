<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();
$claveu = isset($_POST["claveu"]) ? limpiarCadena($_POST["claveu"]) : "";
$usu_id = isset($_POST["usu_id"]) ? limpiarCadena($_POST["usu_id"]) : "";
$usu_nombre = isset($_POST["usu_nombre"]) ? limpiarCadena($_POST["usu_nombre"]) : "";
$usu_identificacion = isset($_POST["usu_identificacion"]) ? limpiarCadena($_POST["usu_identificacion"]) : "";
$usu_telefono = isset($_POST["usu_telefono"]) ? limpiarCadena($_POST["usu_telefono"]) : "";
$usu_correo = isset($_POST["usu_correo"]) ? limpiarCadena($_POST["usu_correo"]) : "";
$cat_id_tipo_Cargo = isset($_POST["cat_id_tipo_Cargo"]) ? limpiarCadena($_POST["cat_id_tipo_Cargo"]) : "";
$usu_login = isset($_POST["usu_login"]) ? limpiarCadena($_POST["usu_login"]) : "";
$usu_clave = isset($_POST["usu_clave"]) ? limpiarCadena($_POST["usu_clave"]) : "";

switch ($_GET["op"]) {

    case 'verificar':
        //validar si el usuario tiene acceso al sistema
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        //Hash SHA256 en la contraseña
        $clavehash = hash("SHA256", $clavea);
        $rspta = $usuario->verificar($logina, $clavehash);
        $fetch = $rspta->fetch_object();

        if (isset($fetch)) {
            // Declaramos las variables de sesión
            $_SESSION['usu_id'] = $fetch->usu_id;
            $_SESSION['usu_nombre'] = $fetch->usu_nombre;
            $_SESSION['usu_login'] = $fetch->usu_login;
            $_SESSION['usu_correo'] = $fetch->usu_correo;
            $_SESSION['usu_cedula'] = $fetch->usu_cedula;
            $_SESSION['cat_id_rol'] = $fetch->cat_id_rol;

            // Obtener los permisos del usuario
            // Recargar permisos al iniciar sesión
            $marcados = $usuario->listarmarcados($fetch->cat_id_rol);
            $permisos = [];

            while ($per = $marcados->fetch_object()) {
                $permisos[$per->mod_nombre] = [
                    'ver' => (int) $per->per_ver === 1 ? 1 : 0,
                    'agregar' => (int) $per->per_agregar === 1 ? 1 : 0,
                    'editar' => (int) $per->per_editar === 1 ? 1 : 0,
                    'eliminar' => (int) $per->per_eliminar === 1 ? 1 : 0
                ];
            }

            // Actualizamos los permisos en la sesión inmediatamente
            $_SESSION['permisos'] = $permisos;
        }

        // Retornamos el objeto con los datos del usuario para hacer un login exitoso
        echo json_encode($fetch);
        break;



    case 'salir':
        //limpiamos la variables de la secion
        session_unset();

        //destruimos la sesion
        session_destroy();
        //redireccionamos al usu_login
        header("Location: ../index.php");
        break;

    case 'listar':
        $rspta = $usuario->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {

            $btnEditar = '';
            $btnDesactivar = '';
            $btnActivar = '';

            if($_SESSION['permisos']['Acceso']['editar'] == 1){
                $btnEditar = '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->usu_id . ')"><i class="fa fa-pencil"></i></i></button> ';
            }


            if($_SESSION['permisos']['Acceso']['eliminar'] == 1){
                $btnDesactivar = '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->usu_id . ')"><i class="fa fa-times"></i></button>';
            }

            if($_SESSION['permisos']['Acceso']['eliminar'] == 1){
                $btnActivar = '<button class="btn btn-danger btn-xs" onclick="activar(' . $reg->usu_id . ')"><i class="fa fa-times"></i></button>';
            }

            $data[] = array(
                "0" => ($reg->usu_estado) ?
                    '<center>' . $btnEditar . $btnDesactivar . '</center>' :
                    '<center>' . $btnEditar . $btnActivar .'</center>',

                "1" => $reg->usu_nombre,
                "2" => $reg->usu_login,
                "3" => $reg->cargo,
                "4" => ($reg->usu_estado) ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>'
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
        $rspta = $usuario->desactivar($usu_id);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $usuario->activar($usu_id);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        //echo $_POST["usu_id"];
        $rspta = $usuario->mostrar($usu_id);
        echo json_encode($rspta);
        break;


    case 'permisos':
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar(); // Aquí listamos todos los permisos sin depender del 'id'

        // Verificamos si 'id' está presente en la URL
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            // Obtener permisos asignados solo si 'id' no está vacío
            $marcados = $usuario->listarmarcados($id);
            $valores = array();

            // Almacenar los permisos asignados
            while ($per = $marcados->fetch_object()) {
                array_push($valores, $per->per_id);
            }
        } else {
            // Si no hay 'id', asignamos un array vacío
            $valores = array();
        }

        // Mostrar la lista de permisos
        while ($reg = $rspta->fetch_object()) {
            $sw = in_array($reg->per_id, $valores) ? 'checked' : '';
            echo '<li><label><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $reg->per_id . '"> ' . $reg->per_nombre . '</label></li>';
        }
        break;


    case 'cargos':
        $rspta = $usuario->cargos();
        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->cat_id . '>' . $reg->cat_nombre . '</option>';
        }
        break;

    case 'guardaryeditar':
        //Hash SHA256 para la contraseña
        if ($claveu == $usu_clave) {
            $usu_clavehash = $usu_clave;
        } else {
            $usu_clavehash = hash("SHA256", $usu_clave);
        }

        if (empty($usu_id)) {
            $rspta = $usuario->insertar($usu_nombre, $usu_identificacion, $usu_telefono, $usu_correo, $cat_id_tipo_Cargo, $usu_login, $usu_clavehash);
            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar";
        } else {
            $rspta = $usuario->editar($usu_id, $usu_nombre, $usu_identificacion, $usu_telefono, $usu_correo, $cat_id_tipo_Cargo, $usu_login, $usu_clavehash);
            //echo $usu_clave;
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar Login existente";
        }
        break;


}