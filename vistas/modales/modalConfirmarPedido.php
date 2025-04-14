<?php
ob_start();
session_start();

if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {
    if ($_SESSION['permisos']['Contador']['ver'] == 1) {
        ?>


        <form action="" name="formulario" id="formulario" method="POST">
            <div class="modal fade" id="modalConfirmarPedido" role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <!-- Main content -->
                    <section class="invoice">
                        <input name="ped_id" id="ped_id" type=""
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
                                    <strong id="cli_nombre" ></strong><br>
                                    <span id="cli_direccion"></span><br>
                                    <span id="cli_ciudad"></span><br>
                                    Tlfn: <span id="cli_telefono"></span><br>
                                    Correo: <span id="cli_correo"></span>

                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <br>
                                <b>Orden ID:</b> <span id="cab_id"></span><br>
                                <b>Tipo de Pago:</b> <span id="cat_id_tipoPago"></span><br>
                                <b>Paqueteria:</b> <span id="paque"></span><br>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <br>
                                <b>Nro de Comprobante:</b> <span id="cab_numComprobante"></span><br>
                                <b>Banco:</b> <span id="cat_id_Banco"></span><br>
                                <b>Origen de Pago:</b> <span id="cat_id_origen"></span><br>

                            </div>
                            <!-- /.col -->


                        </div>
                        <!-- /.row -->
                        <div class="row">


                        </div>
                        <!-- Table row -->
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped" id="tblDetalle" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Ctd</th>
                                        <th>Prenda</th>
                                        <th>Subtotal</th>

                                    </tr>
                                    </thead>

                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->

                            <!-- /.col -->
                            <div class="col-xs-6">

                                <div class="table-responsive">
                                    <table class="table">

                                        <tr>
                                            <th>Costo Envio:</th>
                                            <td id="envio"></td>
                                        </tr>
                                        <tr>
                                            <th>Total sin Envio:</th>
                                            <td id="cab_totalSinEnvio"></td>
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
                                        <tr >
                                            <th id="abono">Abono:</th>
                                            <td id="cab_abono"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-6">
                                <label for="cat_id_estado">Estado(*)</label>
                                <select name="cat_id_estado" id="cat_id_estado" class="form-control">
                                    <!-- Opciones aquí -->
                                </select>
                            </div>
                            <div class="col-xs-6" id="observaciones">
                                <label for="ped_observaciones">OBSERVACIONES</label>
                                <input  name="ped_observaciones" id="ped_observaciones" type="text" placeholder="Observaciones"
                                        class="form-control text-uppercase">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <?php
                            // Verificar si el usuario tiene permiso de 'escribir' (o de 'agregar')
                            if ($_SESSION['permisos']['Contador']['agregar'] == 1) {
                                ?>
                                <button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
                                <?php
                            }
                            ?>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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