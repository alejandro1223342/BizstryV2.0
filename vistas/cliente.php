<?php
ob_start();
session_start();
if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {

    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
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
                        <h3 class="box-title"><i class="fa fa-fw fa-users"></i> Clientes</h3>
                        <?php
                        // Verificar si el usuario tiene permiso de 'escribir' (o de 'agregar')
                        if ($_SESSION['permisos']['Atención al Cliente']['agregar'] == 1) {
                            ?>
                            <button onclick="open_Modal();" type="button" class="btn btn-success"
                                    style="margin-left: 10px;">Agregar <i class="fa fa-fw fa-plus-circle"></i></button>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="box-body">
                                <div class="table-responsive">

                                    <table id="tbllistado" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Telefono</th>
                                            <th>Correo</th>
                                            <th>Provincia</th>
                                            <th>Ciudad</th>
                                            <th>Dirección</th>
                                            <th>Estado</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>

            </section>
            <!-- /.content -->
        </div>
        <?php
        require 'modales/modalClientes.php';
        ?>

        <?php
    } else {
        require 'noacceso.php';
    }
    require 'footer.php';
    ?>
    <script src="scripts/cliente.js"></script>
    <!--   <script src="../public/js/select2.full.min.js"></script>
     -->
    <?php
}
ob_end_flush();
?>