<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {

    require 'header.php';
    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
?>
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <!-- Encabezado de la sección -->
                <div class="row" style="height: 45px;" id="headerPedido">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title" style="margin-right: 10px;">Pedidos
                                    <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar">
                                        <i class="fa fa-plus-circle" style="margin-right: 6px;"></i> Agregar
                                    </button>
                                </h1>
                            </div>

                            <!-- Tabla de pedidos -->
                            <div class="table-responsive-sm">
                                <table id="tbllistado" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Cliente</th>
                                            <th>Paquetería</th>
                                            <th>Forma de Pago</th>
                                            <th>Estado del Pedido</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> <!-- .box -->
                    </div>
                </div>

                <!-- Formulario de Pedido -->
                <div class="container-fluid">
                    <div class="form-container" id="formularioPedido">
                        <div class="header">PEDIDO</div>
                        <br />
                        <form name="formulario" id="formulario" method="POST">
                            <!-- Buscador y datos del cliente -->
                            <div class="form-group">
                                <div class="client-search-container">
                                    <div class="search-box">
                                        <input type="text" class="form-control" placeholder="Buscar Cliente" id="cli_codigo">
                                        <button class="btn btn-primary" type="button" id="btnCliente">Buscar</button>
                                    </div>

                                    <div class="client-info">
                                        <input name="cli" id="cli" type="hidden" class="form-control">
                                        <div><b>Código:</b> <span id="cli_cod">N/A</span></div>
                                        <div><b>Nombre:</b> <span id="cli_nombre">N/A</span></div>
                                        <div><b>Dirección:</b> <span id="cli_direccion">N/A</span></div>
                                        <div><b>Teléfono:</b> <span id="cli_telefono">N/A</span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalles del pedido -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cat_id_banco">Banco(*)</label>
                                        <select name="cat_id_banco" id="cat_id_banco" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cat_id_formaPago">Forma de Pago</label>
                                        <select name="cat_id_formaPago" id="cat_id_formaPago" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cat_id_origenPago">Origen de Pago(*)</label>
                                        <select name="cat_id_origenPago" id="cat_id_origenPago" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cab_numComprobante">Num° Comprobante de Pago(*)</label>
                                        <input name="cab_numComprobante" id="cab_numComprobante" type="text" placeholder="Número de Identificación" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cab_costoEnvio">$Costo de Envio(*)</label>
                                        <input name="cab_costoEnvio" id="cab_costoEnvio" type="text" placeholder="$Costo de Envio" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cab_descuento">$Descuento</label>
                                        <input name="cab_descuento" id="cab_descuento"
                                            type="text" placeholder="$Descuento"
                                            class="form-control" value="0.00">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cab_paqueteria">Paquetería</label>
                                        <select name="cab_paqueteria" id="cab_paqueteria" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cat_id_canalVenta">Canal de Venta(*)</label>
                                        <select name="cat_id_canalVenta" id="cat_id_canalVenta" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="usu_venta">Vendedor</label>
                                        <select name="usu_venta" id="usu_venta" class="form-control selectpicker" data-live-search="true" required></select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección para agregar prenda -->
                            <div class="section-title">Agregar Prenda</div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Prenda(*)</label>
                                        <select name="pre_id" id="pre_id" class="form-control selectpicker" data-live-search="true"></select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cat_id_disenio">Diseño(*)</label>
                                        <select name="cat_id_disenio" id="cat_id_disenio" class="form-control selectpicker" data-live-search="true"></select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad(*)</label>
                                        <input type="number" name="cantidad" id="cantidad" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cat_id_promo">Promoción</label>
                                        <select name="cat_id_promo" id="cat_id_promo" class="form-control selectpicker" data-live-search="true"></select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad">Descuento(*)</label>
                                        <input type="number" name="detven_descuento" id="detven_descuento" class="form-control" value="0.00" step="0.1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top: 25px;">
                                        <button class="btn btn-primary" id="btnGuardarPrenda" onclick="saveForm()">✔</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla -->

                            <table class="table table-bordered table-striped" id="tbllistadoPrendas" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Prenda</th>
                                        <th>Diseño</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                        <th>Descuento</th>
                                        <th>Promoción</th>
                                        <th>Acciones</th>
                                        <th>ID</th>
                                        <th>ID</th>
                                        <th>ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se agregarán las filas dinámicamente -->
                                </tbody>
                            </table>
                            <br />

                            <!-- Botones -->
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnGuardar">
                                    <i class="fa fa-save" style="margin-right: 6px;"></i> Guardar
                                </button>
                                <button class="btn btn-danger" onclick="mostrarform(false)" type="button">
                                    <i class="fa fa-arrow-circle-left" style="margin-right: 6px;"></i> Cancelar
                                </button>
                            </div>
                    </div> <!-- .form-container -->
                </div> <!-- .container-fluid -->

                <?php require 'modales/modalDetallePedido.php'; ?>

            </section>
            </form>
        </div>

    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/pedidos.js"></script>
<?php
}

ob_end_flush();
?>