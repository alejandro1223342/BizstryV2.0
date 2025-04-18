<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Seguimiento{


    //implementamos nuestro constructor
    public function __construct(){

    }

//metodo insertar registro
    public function insertar($cli_nombre, $cli_identificacion,
                             $cli_telefono,$cli_telefono2,$cli_correo, $cat_id_provincia,$cat_id_parroquia,$cli_direccion,$cat_id_tipo_genero,$usu_id){
        $sql="CALL sp_clientes(0, 0, '$cli_nombre', '$cli_identificacion', '$cli_telefono','$cli_telefono2' ,
        '$cli_correo', $cat_id_provincia, $cat_id_parroquia, '$cli_direccion', $cat_id_tipo_genero,$usu_id)";

        return ejecutarConsulta($sql);
    }
    public function editar($cli_nombre, $cli_identificacion,
                             $cli_telefono,$cli_telefono2,$cli_correo, $cat_id_provincia,$cat_id_parroquia,$cli_direccion,$cat_id_tipo_genero,$cli_id){
        $sql="CALL sp_clientes(6, 0, '$cli_nombre', '$cli_identificacion', '$cli_telefono','$cli_telefono2' ,
        '$cli_correo', $cat_id_provincia, $cat_id_parroquia, '$cli_direccion', $cat_id_tipo_genero,$cli_id)";

        return ejecutarConsulta($sql);
    }

   
    public function provincia(){
        $sql="CALL sp_catalgo('spa2','0','', '',9)";
        return ejecutarConsultaSP($sql);
    }
   

    public function listar_estado($ped_id){
        $sql="CALL sp_pedidos_estado(2, $ped_id, 0, 0, 0);";
        //echo $sql;
        return ejecutarConsultaSP($sql);
    }

    public function desactivar($cli_id){
        $sql="CALL sp_clientes(3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $cli_id)";
        return ejecutarConsulta($sql);
    }
    
    public function mostrar($cli_id)
    {
        $sql = "CALL sp_clientes(5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $cli_id)";
        $result = ejecutarConsultaSP($sql);
        return $result->fetch_assoc();
    }

}