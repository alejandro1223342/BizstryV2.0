<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Pedidos{


    //implementamos nuestro constructor
    public function __construct(){

    }

    public function listar_pedidos()
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

    public function cancelarPedido($ped_id,$usu_id){
        $sql="CALL sp_pedidos_estado(3, $ped_id, 46, 'PEDIDO CANCELADO', $usu_id)";
        return ejecutarConsulta($sql);
    }
}