<?php
ob_start();
session_start();

if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {
    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
?>


        <form action="" name="formulario" id="formulario" method="POST">
            <div class="modal fade" id="modalSeguimiento" role="dialog"
                aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Cliente</h5>

                        </div>


                        <div class="modal-body">
                            <div class="row invoice-info">

                                <div class="col-sm-4 invoice-col">
                                    De
                                    <address>
                                        <strong id="cli_nombre"></strong><br>
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
                            <div class="form-row">
                            </div>
                            
                            <input type="hidden" class="form-control"
                                name="cli_id" id="cli_id">

                            <div class="form-row">
                            </div>

                            <div class="form-row">
                            </div>

                            <div class="form-row">


                                <div class="form-group col-md-6">
                                    <label for="cat_id_estado">Estado(*)</label>
                                    <select name="cat_id_estado" id="cat_id_estado" class="form-control selectpicker"
                                        data-live-search="true">
                                        <!-- Opciones aquí -->
                                    </select>
                                </div>


                                <div class="form-group col-md-6">

                                    <label for="">Novedaes</label>
                                    <input name="pedEstado_observaciones"
                                        id="pedEstado_observaciones" type="text" placeholder="Novedades" value="SIN NOVEDADES"
                                        class="form-control text-uppercase">
                                </div>


                            </div>

                            <div class="form-row">

                            </div>
                            <div style="width:900" id="listado">
                                <table id="tblSeguimiento" class="table table-bordered table-striped" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Estado</th>
                                            <th>Novedades</th>
                                            <th>Fecha de Registro</th>
                                            <th>Aprobado por:</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button id="btnGuardar" type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
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