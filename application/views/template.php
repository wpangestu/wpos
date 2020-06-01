<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= isset($sub_title)?$sub_title:$main_title ?> - WPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Jquery-ui -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/dropify/css/dropify.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/toast/jquery.toast.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/sweetalert/sweetalert2.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/datatables/Buttons-1.5.1/css/buttons.dataTables.min.css') ?>" />

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/chartjs/dist/chart.css"> -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/pace/pace.min.css">

  <style>
    .swal2-popup {
      font-size: 1.6rem !important;
    }

    tr.selected {
      background-color: #FFCF8B;
    }

    tr.rowtable:hover {
      cursor: pointer;
      background-color: #FFCF8B;
    }

    table.dataTable tr.focus {
      outline: 2px solid #1ABB9C !important;
      outline-offset: -1px
    }

    .fixed_header tbody {
      display: block;
      overflow: auto;
      height: 300px;
      width: 100%;
    }

    .fixed_header thead tr {
      display: block;
      width: 100%;
    }


  </style>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition <?= getsetting()->theme ?> sidebar-mini <?= isset($lebar) ? 'sidebar-collapse' : 'sidebar-collapse' ?>">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?= base_url() ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><i class="fa fa-desktop"></i></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><i class="fa fa-desktop"></i> WPOS</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        
        <span style="margin-left:5px; font-size: 20px; font-weight: bold; color: <?= getsetting()->theme=='skin-black'|| getsetting()->theme=='skin-black-light' ? 'black':'white'?>; line-height: 50px"><?= getsetting()->nm_toko ?></span>
        
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php $queri = $this->db->get_where('users', array('id' => $this->session->userdata('iduser')))->row() ?>
                <img src="<?= base_url() ?>assets/img/<?= ($queri->image == null) ? 'default.jpg' : $queri->image ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?= getuser()->name ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="<?= base_url() ?>assets/img/<?= ($queri->image == null) ? 'default.jpg' : $queri->image ?>" class="img-circle" alt="User Image">
                  <p>
                    <?= getuser()->name ?>
                    <small><?= getuser()->username ?> as <?= getuser()->level ?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?= base_url('profile') ?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-default btn-flat">Sign out</a>
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

        <!-- SIDEBAR PROFILE -->
        <!-- <div class="user-panel">
          <div class="pull-left image">
            <img src="<?= base_url() ?>assets/img/<?= ($queri->image == null) ? 'default.jpg' : $queri->image ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?= getuser()->name ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div> -->
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-cubes"></i>
              <span>Master Data</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('supplier') ?>"><i class="fa fa-circle-o"></i> Supplier</a></li>
              <li><a href="<?= base_url('category') ?>"><i class="fa fa-circle-o"></i> Kategori</a></li>
              <li><a href="<?= base_url('customer') ?>"><i class="fa fa-circle-o"></i> Pelanggan</a></li>
              <li><a href="<?= base_url('product') ?>"><i class="fa fa-circle-o"></i> Barang</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>Transaksi</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('penjualan') ?>"><i class="fa fa-circle-o"></i> Penjualan</a></li>
              <li><a href="<?= base_url('transaksi/pembelian') ?>"><i class="fa fa-circle-o"></i> Pembelian</a></li>
              <li><a href="<?= base_url('transaksi/stokin') ?>"><i class="fa fa-circle-o"></i> Stok In</a></li>
              <li><a href="<?= base_url('transaksi/stokout') ?>"><i class="fa fa-circle-o"></i> Stok Out</a></li>
            </ul>
          </li>
          <li><a href="<?= base_url('tampil_penjualan') ?>"><i class="fa fa-book"></i> <span>Tampil Penjualan</span></a></li>
        <?php if(getuser()->level=='admin') : ?>
          <li><a href="<?= base_url('grafik') ?>"><i class="fa fa-bar-chart"></i> <span>Grafik Penjualan</span></a></li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?= base_url('report/choose') ?>"><i class="fa fa-circle-o"></i> Penjualan</a></li>
              <li><a href="<?= base_url('report/purchase') ?>"><i class="fa fa-circle-o"></i> Pembelian</a></li>
              <li><a href="<?= base_url('report/stock_in_out') ?>"><i class="fa fa-circle-o"></i> Stok Masuk/Keluar</a></li>
            </ul>
          </li>
        <?php endif ?>
          <li class="header">SETTING</li>
          <li><a href="<?= base_url('profile') ?>"><i class="fa fa-user-circle"></i> <span>Profile Saya</span></a></li>
          <?php if (getuser()->level == 'admin') : ?>
            <li><a href="<?= base_url('users') ?>"><i class="fa fa-users"></i> <span>Pengguna</span></a></li>
            <li><a href="<?= base_url('setting') ?>"><i class="fa fa-gears"></i> <span>Pengaturan</span></a></li>
          <?php endif ?>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= $main_title ?>
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#"><?= $main_title ?></a></li>
          <?php if(isset($sub_title)) : ?>
            <li><?= isset($sub_title) ? $sub_title : '' ?></li>
          <?php endif ?>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- START ALERTS AND CALLOUTS -->
        <?php $this->load->view($content) ?>
      </section>
    </div>
    <!-- ./wrapper -->

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Template by</b> AdminLTE
      </div>
      <strong>Copyright &copy; <a href="#">wpangestu</a> 2020</strong>
    </footer>

    <!-- jQuery 3 -->
    <script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Jquery UI -->
    <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- DataTables -->
    <script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/select2/dist/js/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/toast/jquery.toast.js"></script>
    <script src="<?= base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>

    <script src="<?= base_url('assets/datatables/Buttons-1.5.1/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/Buttons-1.5.1/js/buttons.flash.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/Buttons-1.5.1/js/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/Buttons-1.5.1/js/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/JSZip-2.5.0/jszip.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/pdfmake-0.1.32/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/pdfmake-0.1.32/vfs_fonts.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/price_format/jquery.priceformat.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url() ?>assets/bower_components/moment/min/moment.min.js"></script>
    <script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
    <!-- ChartJS -->
    <!-- <script src="<?= base_url('assets/plugins/chartjs/dist/chart.js') ?>"></script> -->
    <!-- CanvasJs -->
    <script src="<?= base_url('assets/plugins/canvasjs/canvasjs.min.js') ?>"></script>

    <!-- bootstrap datepicker -->
    <script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.id.min.js"></script>
    <script src="<?= base_url() ?>assets/bower_components/PACE/pace.min.js"></script>
    <!-- AdminLTE for demo purposes -->

    <script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
    <script>
      $(document).ajaxStart(function () {
        Pace.restart()
      })    
    </script>
    <?php if (isset($codejs)) {
      $this->load->view($codejs);
    } ?>
    <script>
      $(function() {
        $('#example1').DataTable()
        {

        }
      });

      $('.datatables').DataTable();

      $('.mydaterangepicker').daterangepicker({
        ranges: {
          'Hari ini': [moment(), moment()],
          'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
          '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
          'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
          'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        // autoApply: true,
        locale: {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "applyLabel": "Apply",
          "cancelLabel": "Cancel",
          "fromLabel": "From",
          "toLabel": "To",
          "customRangeLabel": "Custom",
          "weekLabel": "W",
          "daysOfWeek": [
            "Mg",
            "Sn",
            "Sl",
            "Rb",
            "Ka",
            "Ju",
            "Sa"
          ],
          "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
          ],
          "firstDay": 1
        }
      })
    </script>
    <script>
      $(document).ready(function() {

        const type = $('#flashdata').data('type');
        const message = $('#flashdata').data('message');
        if (type == 'success') {
          $.toast({
            text: message, // Text that is to be shown in the toast
            heading: 'Sukses', // Optional heading to be shown on the toast
            icon: 'success', // Type of toast icon
            showHideTransition: 'fade', // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

            loader: false,
            textAlign: 'left', // Text alignment i.e. left, right or center
            beforeShow: function() {}, // will be triggered before the toast is shown
            afterShown: function() {}, // will be triggered after the toat has been shown
            beforeHide: function() {}, // will be triggered before the toast gets hidden
            afterHidden: function() {} // will be triggered after the toast has been hidden
          });
        } else if (type == 'failed') {
          $.toast({
            text: message, // Text that is to be shown in the toast
            heading: 'Gagal', // Optional heading to be shown on the toast
            icon: 'error', // Type of toast icon
            showHideTransition: 'fade', // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

            loader: false,
            textAlign: 'left', // Text alignment i.e. left, right or center
            loaderBg: '#9ec600', // Background color of the toast loader
            beforeShow: function() {}, // will be triggered before the toast is shown
            afterShown: function() {}, // will be triggered after the toat has been shown
            beforeHide: function() {}, // will be triggered before the toast gets hidden
            afterHidden: function() {} // will be triggered after the toast has been hidden
          });
        } else if (type == 'failed_sw') {
          Swal.fire({
            type: 'error',
            title: 'Gagal',
            text: message,
          })
        } else if (type == 'success_sw') {
          Swal.fire({
            type: 'success',
            title: 'Sukses',
            text: message,
          })
        }
      })
    </script>
</body>

</html>