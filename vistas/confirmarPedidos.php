<?php
ob_start();
session_start();
if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {

    if ($_SESSION['permisos']['Contador']['ver'] == 1) {
        require 'header.php';
?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <!-- COLOR PALETTE -->
                <div class="box box-default color-palette-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-dropbox"></i> Confirmar Pedidos</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="box-body">
                                <table id="tbllistado" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Pedido N°</th>
                                            <th>Cliente</th>
                                            <th>Paquetería</th>
                                            <th>Forma de Pago</th>
                                            <th>Estado del Pedido</th>
                                            <th>Acciones</th>

                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <?php
                require 'modales/modalConfirmarPedido.php';
                ?>
            </section>
            <!-- /.content -->
        </div>
    <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/confirmarPedidos.js"></script>
    <!--   <script src="../public/js/select2.full.min.js"></script>
     -->
<?php
}
ob_end_flush();
?>