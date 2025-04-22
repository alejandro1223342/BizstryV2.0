<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Pedidos
{

    //implementamos nuestro constructor
    public function __construct() {}

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
    public function listar_prod($cab_id)
    {
        $sql = "CALL sp_confirmarPedidos(5,$cab_id,0,0,0)";
        return ejecutarConsultaSP($sql);
    }

    public function usuario_Venta()
    {
        $sql = "call sp_usuarios(6,0,0,0,0,0,0,0,0)";
        return ejecutarConsultaSP($sql);
    }

    public function banco()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',12)";
        return ejecutarConsultaSP($sql);
    }

    public function tipoCuenta()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',12)";
        return ejecutarConsultaSP($sql);
    }

    public function formaPago()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',14)";
        return ejecutarConsultaSP($sql);
    }

    public function origenPago()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',12)";
        return ejecutarConsultaSP($sql);
    }

    public function canalVenta()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',47)";
        return ejecutarConsultaSP($sql);
    }

    public function paqueteria()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',17)";
        return ejecutarConsultaSP($sql);
    }

    public function prendas()
    {
        $sql = "CALL sp_prendas();";
        return ejecutarConsultaSP($sql);
    }

    public function disenio()
    {
        $sql = "CALL sp_disenio();";
        return ejecutarConsultaSP($sql);
    }

    public function promocion()
    {
        $sql = "CALL sp_catalgo('spa2','0','', '',33)";
        return ejecutarConsultaSP($sql);
    }

    public function mostrar_cliente($cli_codigo)
    {
        $sql = "CALL sp_clientes(2,'$cli_codigo', 0, 0, 0, 0, 
        0, 0, 0, 0, 0,0)";
        $result = ejecutarConsultaSP($sql);
        return $result->fetch_assoc();
    }

    public function insertar(
        $usu_id,
        $cli_id,
        $cat_id_banco,
        $cat_id_formaPago,
        $cat_id_origenPagoBanco,
        $ped_numComprobante,
        $cat_id_paqueteria,
        $ped_envio,
        $cab_descuento,
        $usu_id_vendedor,
        $prendas
    ) {
        $cat_id_estadoActual = 32; // Estado fijo para nuevo pedido

        $jsonPrendas = json_encode(array_map(function ($p) {
            return [
                'pre_id' => (int)$p['prendaId'],
                'dis_id' => (int)$p['disenioId'],
                'cantidad' => (int)$p['cantidad'],
                'precioUnitario' => (float)$p['total'],
                'descuento' => isset($p['descuento']) ? (float)$p['descuento'] : 0,
                'cat_id_promocion' => isset($p['promoId']) ? (int)$p['promoId'] : 0
            ];
        }, $prendas));
        $jsonPrendasSql = "'" . addslashes($jsonPrendas) . "'";
        // Preparar el llamado al SP
        $sql = "CALL insertar_pedido(
            $usu_id,
            $cli_id,
            $cat_id_banco,
            $cat_id_formaPago,
            $cat_id_origenPagoBanco,
            '$ped_numComprobante',
            $cat_id_paqueteria,
            $cat_id_estadoActual,
            $ped_envio,
            $cab_descuento,
            $usu_id_vendedor,
            $jsonPrendasSql
        )";

        echo $sql;

        // Ejecutar procedimiento
        $result = ejecutarConsultaSP($sql);

        return $result ? true : false;
    }


    public function editar(
        $usu_id,
        $cli_id,
        $cat_id_banco,
        $cat_id_tipoPago,
        $cat_id_origenPago,
        $cab_numComprobante,
        $cab_paqueteria,
        $cat_id_canalVenta,
        $cab_totalSinEnvio,
        $cab_costoEnvio,
        $cab_descuento,
        $totalValor,
        $cab_abono,
        $cab_usuVenta,
        $prendas,
        $cab_id
    ) {

        // Convertir a JSON las prendas
        $jsonPrendas = json_encode(array_map(function ($p) {
            return [
                'pre_id' => $p['prendaId'],
                'dis_id' => $p['disenioId'],
                'cantidad' => $p['cantidad'],
                'precioUnitario' => $p['total'],
                'cat_id_promocion' => isset($p['promoId']) ? $p['promoId'] : 0,
                'descuento' => isset($p['descuento']) ? $p['descuento'] : 0,
                'subtotal' => isset($p['descuentoSubtotal']) ? $p['descuentoSubtotal'] : $p['total']
            ];
        }, $prendas));

        $jsonPrendasSql = "'" . addslashes($jsonPrendas) . "'";

        // Consulta al SP  de edición
        $sql = "CALL editar_pedido(
            $usu_id, $cli_id, $cat_id_banco, $cat_id_tipoPago, $cat_id_origenPago, '$cab_numComprobante', $cab_paqueteria, $cat_id_canalVenta,
            $cab_totalSinEnvio, $cab_costoEnvio, $cab_descuento, $totalValor, $cab_abono, $cab_usuVenta, $cab_id, $jsonPrendasSql)";

        $result = ejecutarConsultaSP($sql);

        return $result ? true : false;
    }
}
