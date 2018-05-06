<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BI TMS - <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/css/pqselect.dev.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo base_url(); ?>assets_theme/dist/css/defaultTheme.css" rel="stylesheet" media="screen" />
    <link href="<?php echo base_url(); ?>assets_theme/dist/css/myTheme.css" rel="stylesheet" media="screen" />   
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/css/jquery-ui.css" />  
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/css/modules.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/remodal/remodal.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets_theme/dist/remodal/remodal-default-theme.css">
  
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
       <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="<?php echo base_url(); ?>assets_theme/dist/remodal/remodal.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
	  
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets_theme/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>assets_theme/dist/js/jquery.inputmask.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/jquery.fixedheadertable.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/demo-fixed-table.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets_theme/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets_theme/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets_theme/dist/js/jquery.validate.js"></script>
	
<script src="<?php echo base_url(); ?>assets_theme/dist/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets_theme/dist/js/highcharts.src.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets_theme/dist/js/highcharts-3d.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<script src="<?php echo base_url(); ?>assets_theme/dist/js/adminlte.min.js"></script>
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/pqselect.dev.js"></script>
	<script src="<?php echo base_url(); ?>assets_theme/dist/js/pages/dashboard.js"></script>
	<script src="<?php echo base_url(); ?>assets_theme/dist/js/date.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets_theme/dist/js/demo.js"></script>
    


  </head>
  <body class="hold-transition skin-blue-light">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-lg"><b>TMS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-mini"><b>Goodeva</b> TMS</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
		</a>
        <div id="right-welcome">
       Welcome <?php echo $data_account[0]['name']; ?>
        </div>
        
          <!-- Sidebar toggle button-->
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              
            
              <!-- User Account: style can be found in dropdown.less -->
              
              <!-- Control Sidebar Toggle Button -->
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
         <?php echo $sidebar; ?>
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
       <!--- Print Body -->
                      <?php echo $content; ?>
                     <!-- Print Body End -->
       
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
        </div>
        <strong>Copyright &copy; 2018 <a href="http://suksemasolution.co.id/" target="_blank">Goodeva Media</a>.</strong> All rights reserved.
      </footer>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

 
  </body>
  
  <script>
  $(".sidebar-toggle").click(function(){
	  
	 
	 if ($(".sidebar-collapse").length > 0) {
        $('body').removeClass('sidebar-collapse');
	 }
	 else
	 {
		$('body').addClass('sidebar-collapse'); 
	 }
	
  });
  
  
  </script>
  
  
  
</html>
