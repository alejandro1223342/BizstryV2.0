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

                <!-- Default box -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Pedidos
                                    <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
                                            class="fa fa-plus-circle"></i>Agregar
                                    </button>
                                </h1>
                                <div class="box-tools pull-right">

                                </div>
                            </div>
                            <!--box-header-->
                            <!--centro-->
                            <div style="width:900" id="listadoregistros">
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


                            <!--fin centro-->
                        </div>
                    </div>
                </div>
                <!-- /.box -->
                <?php
                require 'modales/modalDetallePedido.php';
                ?>
                <?php
                require 'modales/modalSeguimiento.php';
                ?>
                <?php
                require 'modales/modalAbonos.php';
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
    <script src="scripts/pedidos.js"></script>
    <script src="scripts/seguimiento.js"></script>
    <script src="scripts/abonos.js"></script>

<?php
}

ob_end_flush();
?>