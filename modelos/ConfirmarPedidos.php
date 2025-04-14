<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class ConfirmarPedidos{


    //implementamos nuestro constructor
    public function __construct(){

    }

    public function listar()
    {
        $sql = "CALL sp_pedidos(1, 0)";
        return ejecutarConsultaSP($sql);
    }

    public function mostrar_pedido($ped_id)
    {
        $sql = "CALL sp_pedidos(2,$ped_id)";
        $result = ejecutarConsultaSP($sql);
        return $result->fetch_assoc();
    }

    public function listar_detallePedido($ped_id)
    {
        $sql = "CALL sp_pedidos(3, $ped_id)";
        return ejecutarConsultaSP($sql);
    }

    public function cofirmar(){
        $sql="CALL sp_catalgo('spa2','0','', '',21)";
        return ejecutarConsultaSP($sql);
    }

    public function guardaryeditar($ped_id,$cat_id_estado, $ped_observaciones,$usu_id)
    {
        $sql = "CALL sp_pedidos_estado(1, $ped_id, $cat_id_estado, '$ped_observaciones', $usu_id);";
        echo $sql;
        return ejecutarConsulta($sql);
    }

}