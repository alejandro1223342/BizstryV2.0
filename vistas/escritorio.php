<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['usu_nombre'])) {
    header("Location: login.html");
} else {


    require 'header.php';

    if ($_SESSION['permisos']['Dashboard']['ver'] == 1) {


        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3 id="ventas_diarias">0</h3>

                                <p>Pedidos Diarios Aprobados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3 id="pedidos_Pendientes">0</h3>

                                <p>Pedidos Diarios Pendientes</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3 id="totalUsuarios">0</h3> <!-- Aquí se actualizará el número -->

                                <p>Usuarios Registrados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3 id="totalClientes">0</h3>

                                <p>Clientes Registrados</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>
                    </section>
                    <section class="col-lg-6 connectedSortable">
                        <div>
                            <canvas id="myChart2"></canvas>
                        </div>
                    </section>

                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="box-body">
                            <table id="tbllistado" class="table table-bordered table-striped" >
                                <thead>
                                <tr>
                                    <th>VENDEDOR</th>
                                    <th>CONTRAENTREGA</th>
                                    <th>DEPOSITO</th>
                                    <th>EFECTIVO</th>
                                    <th>PAYPAL</th>
                                    <th>TC. PAYPHONE</th>
                                    <th>TD. PAYPHONE</th>
                                    <th>TRANSFERENCIA</th>
                                    <th>SUMA TOTAL</th>
                                </tr>
                                </thead>

                            </table>
                        </div>


                    </div>

                </div>
                <!-- /.row (main row) -->
            </section>


            <!-- /.content -->
        </div>
        <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>
    <script src="scripts/escritorio.js"></script>


    <?php
}

ob_end_flush();
?>

