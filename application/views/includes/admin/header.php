<!DOCTYPE html>
<html>
<?php 
  $pageUrl =$this->uri->segment(1);
  $access = $this->session->userdata('access');
  $jsonstringtoArray = json_decode($access, true);
  $isVendorloginIn = $this->session->userdata('loginvendorId');
  $user_flag = $this->session->userdata('user_flag');
  $userId = $this->session->userdata('userId');
?>
<head>
  <meta charset="UTF-8">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.4 -->
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- FontAwesome 4.3.0 -->
  <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Ionicons 2.0.0 -->
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
   <!-- Custom css style -->
  <link href="<?php echo base_url(); ?>assets/dist/css/Comman.css" rel="stylesheet" type="text/css" />
  <!-- Datatables style -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"
  />
  <link rel="icon" href="https://example.com/favicon.png">

  <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
  <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <style>
    .error {
      color: red;
      font-weight: normal;
    }
    thead{
      background: #3c8dbc;
      color: #fff;
    }
    table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
      opacity : 0.6;
    }
  </style>
  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
  </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?php echo base_url(); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
          <b>DGT</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <b>DGT</b> College</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        
      
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-history"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="header"> Last Entry :
                  <i class="fa fa-clock-o"></i>
                  <?= empty($last_login) ? "First Login" : $last_login; ?>
                </li>
              </ul>
            </li>
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image" />
                <span class="hidden-xs">
                  <?php echo $name; ?>
                </span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                  <p>
                    <?php echo $name; ?>
                    <small>
                      <?php echo $role_text; ?>
                    </small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo base_url(); ?>userEdit" class="btn btn-default btn-flat">
                      <i class="fa fa-key"></i> Account settings</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">
                      <i class="fa fa-sign-out"></i> Log out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <!-- <li class="header">
          </li> -->

                      <li class="treeview">
                        <a href="<?php echo base_url(); ?>dashboard">
                          <i class="fa fa-dashboard"></i>
                          <!-- <span>Home page</span> -->
                          <span>Dashboard</span>
                          </i>
                        </a>
                      </li>
             

              <?php if (in_array("usersmodule", $jsonstringtoArray)){?>
              <li class="treeview <?php if($pageUrl=="userListing" || $pageUrl=="roleListing" || $pageUrl=="addNew" || $pageUrl=="addRole" || $pageUrl=="editOld" || $pageUrl=="editRole"){echo 'active';}?>" style="height: auto;">
                <a href="#">
                  <i class="fa fa-users"></i> <span>User</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu" >
                <?php if (in_array("userpage", $jsonstringtoArray)){?>
                  <li class="<?php if($pageUrl=="userListing" || $pageUrl=="addNew" || $pageUrl=="editOld"){echo 'active';}?>"><a href="<?php echo base_url(); ?>userListing"><i class="fa fa-users"></i> Users</a></li>
                  <!-- <li><a href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus-circle"></i> Users</a></li> -->
                <?php }?> 
                <?php if (in_array("rolepage", $jsonstringtoArray)){?>
                  <li class="<?php if($pageUrl=="roleListing" || $pageUrl=="addRole" || $pageUrl=="editRole"){echo 'class="active"';}?>"><a href="<?php echo base_url(); ?>roleListing"><i class="fa fa-check-square-o"></i> Role</a></li>
                <?php }?> 
                </ul>
              </li>
              <?php }?>

                      <li class="treeview">
                        <a href="<?php echo base_url(); ?>banner">
                          <i class="fa fa-image"></i>
                          <!-- <span>Home page</span> -->
                          <span>Banner</span>
                          </i>
                        </a>
                      </li>

                      <li class="treeview">
                        <a href="<?php echo base_url(); ?>events">
                          <i class="fa fa-file"></i>
                          <!-- <span>Home page</span> -->
                          <span>News & Events</span>
                          </i>
                        </a>
                      </li>
              
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <div class="loader_ajax" style="display:none;">
	    <div class="loader_ajax_inner"><img src="<?php echo base_url(); ?>assets/images/preloader_ajax.gif"></div>
	  </div>
    <style>
    .loader_ajax {background-color: #242424;bottom: 0;height: 100%;left: 0;opacity: 0.9;position: fixed;top: 0;width: 100%;z-index: 999;}
    .loader_ajax_inner {background: transparent url("<?php echo base_url(); ?>assets/images/bg.png") no-repeat scroll center center;height: 44px;left: 50%;margin: -22px 0 0 -22px;position: absolute;top: 50%;width: 44px;}
    .loader_ajax img {margin: 9px 0 0 8px;width: 28px;}
    </style>