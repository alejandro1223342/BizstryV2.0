<?php
ob_start();
session_start();

if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {
    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
?>


        <form action="" name="formulario" id="formulario" method="POST">
            <div class="modal fade" id="modalAbonos" role="dialog"
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
                                    <strong id="cliente_nombre"></strong><br>
                                    <span id="cliente_direccion"></span><br>
                                    <span id="cliente_ciudad"></span><br>
                                    Tlfn: <span id="cliente_telefono"></span><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <br>
                                <b>Orden ID:</b> <span id="pedido_id"></span><br>
                                <b>Total:</b> <span id="total_pedido"></span><br>
                                <b>Saldo Pendiente:</b> <span id="total_saldo"></span><br>
                            </div>
                            <div class="col-sm-4 invoice-col">


                            </div>
                            <!-- /.col -->


                        </div>
                        <!-- /.row -->
                        <div class="row">


                        </div>

                        <div class="row">

                            <div class="col-xs-4">
                                <label for="cat_id_estado">Banco(*)</label>
                                <select name="cat_id_estado" id="cat_id_estado" class="form-control">
                                    <!-- Opciones aquí -->
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="cat_id_estado">Forma de Pago(*)</label>
                                <select name="cat_id_estado" id="cat_id_estado" class="form-control">
                                    <!-- Opciones aquí -->
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <label for="cat_id_estado">Origen de Pago(*)</label>
                                <select name="cat_id_estado" id="cat_id_estado" class="form-control">
                                    <!-- Opciones aquí -->
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xs-4" id="observaciones">
                                <label for="abo_monto">Monto(*)</label>
                                <input name="abo_monto" id="abo_monto" type="text" placeholder="Observaciones"
                                    class="form-control text-uppercase">
                            </div>
                            <div class="col-xs-4" id="observaciones">
                                <label for="abo_observaciones">Observaciones</label>
                                <input name="abo_observaciones" id="abo_observaciones" type="text" placeholder="Observaciones"
                                    class="form-control text-uppercase">
                            </div>
                        </div>

                        <div style="width:900" id="listado">
                            <table id="tblAbonos" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Banco:</th>
                                        <th>Forma de Pago:</th>
                                        <th>Origen de Pago:</th>
                                        <th>Monto:</th>
                                        <th>Observaciones:</th>
                                        <th>Estado:</th>
                                        <th>Fecha de Abono:</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button id="btnFinalizarAbonos" type="button" class="btn btn-warning">Finalizar Abonos</button>

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