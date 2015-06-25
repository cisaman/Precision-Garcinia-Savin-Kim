<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Precision Vitality - Admin Dashboard</title>
        <link rel="icon" type="image/png" href="<?php echo base_url("assets/images") ?>/favicon.ico">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo base_url('assets/admin/css') ?>/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo base_url('assets/admin/css') ?>/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/admin/css') ?>/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/admin/css') ?>/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-black">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Precision Vitality
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Welcome <?php echo $this->admin_model->getAdminName(); ?></span>
                            </a>
                        </li>
                        <li class="user-menu">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" id="logout">
                                <i class="fa fa-sign-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">                        
                        <li>
                            <a href="<?php echo base_url('admin/index'); ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="javascript:void(0);">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Pages</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="<?php echo base_url('admin/pages') ?>"><i class="fa fa-angle-double-right"></i> Manage Pages</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin/addpage') ?>"><i class="fa fa-angle-double-right"></i> Add Page</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo base_url('admin/users'); ?>">
                                <i class="fa fa-users"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>   
                          <li>
                            <a href="<?php echo base_url('admin/profile'); ?>">
                                <i class="fa fa-user"></i>
                                <span>Manage Profile</span>
                            </a>
                        </li>   
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">