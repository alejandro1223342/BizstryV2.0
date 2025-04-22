<?php
if (strlen(session_id()) < 1)
    session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BIZSTRY</title>
    <link rel="icon" type="image/x-icon" href="../files/img/isoblanco.ico">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/x-icon" href="../files/img/isoblanco.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <!-- DATATABLES CSS -->
    <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">

    <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="../public/css/datepicker3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="../public//css//styles.css">
    <style>
        .main-sidebar {
            background-color: #2c3b41 !important;
            /* Gris */
        }

        .sidebar-menu>li>a {
            color: white !important;
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini ">

    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="escritorio.php" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <font size="4">=></font>
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <font size="4">MENU</font>
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span>
                        <font size="4" style="color:#FFF">BIZSTRY - ECOMMERCE </font>
                    </span>

                </a>

                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="hidden-xs"><?php echo $_SESSION['usu_nombre']; ?><?php echo $_SESSION['cat_id_rol']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">

                                    <p>
                                        BIZSTRY
                                        <small>2024-2025</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">

                                    </div>
                                    <div class="pull-right">
                                        <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Salir</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->

                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->

                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->

                <ul class="sidebar-menu" data-widget="tree">

                    <br>
                    <?php
                    if ($_SESSION['permisos']['Dashboard']['ver'] == 1) {
                        echo '  
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-fw fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-down pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li><a href="escritorio.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a></li>
                            
                        </ul>
                        
                    </li>';
                    }
                    ?>


                    <?php
                    if ($_SESSION['permisos']['Acceso']['ver'] == 1) {
                        echo '  
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-laptop"></i> <span>Acceso</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-down pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li><a href="roles.php"><i class="fa fa-circle-o"></i> Roles</a></li>
                            <li><a href="usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                            <li><a href="catalogo.php"><i class="fa fa-circle-o"></i> Catálogos</a></li>
                            <li><a href="ciudades.php"><i class="fa fa-circle-o"></i> Ciudades</a></li>
                            <li><a href="prendas_disenio.php"><i class="fa fa-circle-o"></i> Prendas-Diseños</a></li>
                        </ul>
                    </li>';
                    }
                    ?>




                    <?php
                    if ($_SESSION['permisos']['Atención al Cliente']['ver'] == 1) {
                        echo '  
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-fw fa-cart-plus"></i> <span>Atención al Cliente</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-down pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li><a href="cliente.php"><i class="fa fa-fw fa-users"></i> Crear Clientes</a></li>
                            <li><a href="pedidos.php"><i class="fa fa-fw fa-inbox"></i> Crear Pedido</a></li>
                            <li><a href="chats.php"><i class="fa fa-fw fa-wechat"></i> Registrar Chats</a></li>
                        </ul>
                    </li>';
                    }
                    ?>

                    <?php
                    if ($_SESSION['permisos']['Contador']['ver'] == 1) {
                        echo '  
                    <li class="treeview menu-open">
                        <a href="#">
                            <i class="fa fa-fw fa-cart-plus"></i> <span>Contador</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-down pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: block;">
                            <li><a href="confirmarPedidos.php"><i class="fa fa-circle-o"></i> Confirmar Pedidos</a></li>
                        </ul>
                    </li>';
                    }
                    ?>


                </ul>
            </section>
            <!-- /.sidebar -->

        </aside>