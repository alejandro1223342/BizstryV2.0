<?php
ob_start();
session_start();

if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {
    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
        ?>


        <form action="" name="formulario" id="formulario" method="POST">
            <div class="modal fade" id="modalClientes" role="dialog"
                 aria-labelledby="exampleModalCenterTitle"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Cliente</h5>

                        </div>


                        <div class="modal-body">
                            <input type="hidden" class="form-control"
                                   name="cli_id" id="cli_id">

                            <div class="form-row">
                            </div>

                            <div class="form-row">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label for="">Nombres y Apellidos(*)</label>
                                    <input name="cli_nombre"
                                           id="cli_nombre" type="text" placeholder="Nombres y Apellidos"
                                           class="form-control text-uppercase">
                                </div>
                                <div class="form-group col-md-6">

                                    <label for="">Cédula</label>
                                    <input name="cli_identificacion"
                                           id="cli_identificacion" type="text" placeholder="Número de Identificación"
                                           class="form-control text-uppercase">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cat_id_provincia">Provincia(*)</label>
                                    <select name="cat_id_provincia" id="cat_id_provincia"  class="form-control selectpicker"
                                            data-live-search="true" >
                                        <!-- Opciones aquí -->
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cat_id_parroquia">Ciudad(*)</label>
                                    <select name="cat_id_parroquia" id="cat_id_parroquia"  class="form-control selectpicker"
                                            data-live-search="true" >
                                        <!-- Opciones aquí -->
                                    </select>
                                </div>

                                <div class="form-group col-md-3">

                                    <label for="">Teléfono(*)</label>
                                    <input name="cli_telefono"
                                           id="cli_telefono" type="text" placeholder="Teléfono"
                                           class="form-control text-uppercase">
                                </div>
                                <div class="form-group col-md-3">

                                    <label for="">Teléfono 2</label>
                                    <input name="cli_telefono2"
                                           id="cli_telefono2" type="text" placeholder="Teléfono"
                                           class="form-control text-uppercase">
                                </div>



                            </div>

                            <div class="form-row">

                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">

                                    <label for="">Dirección(*)</label>
                                    <input name="cli_direccion"
                                           id="cli_direccion" type="text" placeholder="Dirección"
                                           class="form-control text-uppercase">
                                </div>

                                <div class="form-group col-md-6">

                                    <label for="">Correo</label>
                                    <input name="cli_correo"
                                           id="cli_correo" type="email" placeholder="Correo"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cat_id_tipo_genero">Género(*)</label>
                                    <select name="cat_id_tipo_genero" id="cat_id_tipo_genero"
                                            class="form-control selectpicker"
                                            data-live-search="true">
                                        <!-- Opciones aquí -->
                                    </select>
                                </div>

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