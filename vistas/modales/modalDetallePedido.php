<?php
ob_start();
session_start();

if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {
    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
        ?>


<form action="" name="formulario" id="formulario" method="POST">
            <div class="modal fade" id="modalDetallePedido" role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <!-- Main content -->
                    <section class="invoice">
                        <input  name="cabecera_id" id="cabecera_id" type="hidden"
                               class="form-control">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <i class="fa fa-globe"></i> Bizstry, Inc.
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">

                            <div class="col-sm-4 invoice-col">
                                De
                                <address>
                                    <strong id="nombre" ></strong><br>
                                    <span id="direccion"></span><br>
                                    <span id="ciudad"></span><br>
                                    Tlfn: <span id="telefono"></span><br>
                                    Correo: <span id="correo"></span>

                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <br>
                                <b>Fecha Pedido:</b> <span id="fecha_pedido"></span><br>
                                <br>
                                <b>Orden ID:</b> <span id="id"></span><br>
                                <b>Tipo de Pago:</b> <span id="tipoPago"></span><br>
                                <b>Paqueteria:</b> <span id="paqueteria"></span><br>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <br>
                                <b>Fecha Revisado:</b> <span id="fecha_revisado"></span><br>
                                <br>
                                <b>Nro de Comprobante:</b> <span id="numComprobante"></span><br>
                                <b>Banco:</b> <span id="cat_id_Banco"></span><br>
                                <b>Origen de Pago:</b> <span id="id_origen"></span><br>

                            </div>
                            <!-- /.col -->


                        </div>
                        <!-- /.row -->

                        <!-- Table row -->

                        <div style="width:900" id="listadoregistros">
                            <table id="tblDetalle" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Ctd</th>
                                    <th>Produto</th>
                                    <th>Promoción</th>
                                    <th>Precio Unitario</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                            </table>
                        </div>


                        <!-- /.row -->

                        <div class="row">
                            <!-- Columna para la tabla -->
                            <div class="col-sm-8">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Costo Envio:</th>
                                            <td id="cab_envio"></td>
                                        </tr>
                                        <tr>
                                            <th>Total sin Envio:</th>
                                            <td id="totalSinEnvio"></td>
                                        </tr>
                                        <tr>
                                            <th>Total con Envio:</th>
                                            <td id="cab_total"></td>
                                        </tr>
                                        <tr>
                                            <th id="descuento_titulo">Descuento:</th>
                                            <td id="cab_desc"></td>
                                        </tr>
                                        <tr>
                                            <th id="total_titulo">Total con Descuento:</th>
                                            <td id="cab_totalDescuento"></td>
                                        </tr>
                                        <tr>
                                            <th id="abono_titulo">Abono:</th>
                                            <td id="id_abono"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- Columna para el estado y motivo -->
                            <div class="col-sm-4">
                                <b>Estado:</b> <span id="estado"></span><br>
                                <b id="hiddenMotivo">Motivo:</b> <span id="motivo"></span><br>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal"> Salir </button>
                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->

                </div>

            </div>
        </form>



        <?php
    } else {
        require '../footer.php';

    }
    ?>
    <!--   <script src="../public/js/select2.full.min.js"></script>
     -->
    <?php
}
ob_end_flush();
?>