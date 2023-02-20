<style>
.panel-margin{
	margin: 13% 0!important;}
</style>
<?php
	$sessionData = $this->session->all_userdata();
	//print_r($sessionData['admintype']);die;
	//$email = $sessionData['email'];		
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SNRAKSHK Web Panel</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.5 -->
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/style.css">
<script src="<?php echo base_url(); ?>temp/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body class="hold-transition skin-blue">
<div class="wrapper">
	<header class="main-header">
	<!-- Logo -->
	<?php if ($sessionData['admintype'] == 'superadmin') {?>
	<a href="<?php echo base_url(); ?>web/Superadmin/companyheadlist" class="logo">
	<?php }elseif ($sessionData['admintype'] == 'supervisor') {?>
		<a href="<?php echo base_url(); ?>web/Supervisor/fieldinspectorlist" class="logo">
	<?php }elseif ($sessionData['admintype'] == 'reasonalhead') { ?>
		<a href="<?php echo base_url(); ?>web/Reasonalhead/supervisorlist" class="logo">
	<?php }elseif ($sessionData['admintype'] == 'companyhead') { ?>
		<a href="<?php echo base_url(); ?>web/Companyhead/reasonalheadlist" class="logo">
	<?php }?>
	  <!-- mini logo for sidebar mini 50x50 pixels -->
	  	<span class="logo-mini"><b>SNRAKSHK</b></span>
	  	<div class="headerlogo">
           <img src="<?php echo base_url();?>/temp/images/ican/IOCL.png" alt="" style="width:42px;"/>
      	</div>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
	  <!-- Sidebar toggle button-->
	  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	  </a>
	  <!-- Navbar Right Menu -->
	  <div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
		 
		  <li>
			<a href="<?php echo base_url();?>web/Snrakshklog/logout"><i class="fa fa-sign-out"></i></a>
		  </li>
		</ul>
	  </div>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	</nav>
  </header>
  <?php if ($sessionData['admintype'] == 'superadmin') {?>
  	<!-- Left side column. contains the logo and sidebar -->
	  <aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="<?php echo base_url(); ?>temp/dist/img/user2-160x160.jpg" 	class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			  <p><?php echo "Super admin"; ?></p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		  </div>
		  <ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="active treeview">
			 
			 <li <?php if($this->uri->segment(3)=="companyheadlist"){echo 'class="active"';}?>>
			 <a href="<?php echo base_url();?>web/Superadmin/companyheadlist">
			 <i class="fa fa-users"></i>Company Head List</a></li>
			 </li>
			 <li class="active treeview">
			 
			 <li <?php if($this->uri->segment(3)=="reasonalheadlist"){echo 'class="active"';}?>>
			 <a href="<?php echo base_url();?>web/Superadmin/reasonalheadlist">
			 <i class="fa fa-users"></i>Reasonal Head List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="supervisorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Superadmin/supervisorlist"><i class="fa fa-users"></i>Supervisor List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="fieldinspectorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Superadmin/fieldinspectorlist"><i class="fa fa-users"></i>Field Inspector List</a></li>
			 </li>

	           <li <?php if($this->uri->segment(3)=="consumerlist")
                 {echo 'class="active"';}?>>
				 <a href="<?php echo base_url();?>web/Superadmin/consumerlist">
			   <i class="fa fa-users"></i>Consumer List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="Importedconsumerlist")
                 {echo 'class="active"';}?>>
				 <a href="<?php echo base_url();?>web/Superadmin/Importedconsumerlist">
			   <i class="fa fa-users"></i>Imported Consumer List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="changepassword"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Superadmin/changepassword"><i class="fa fa-key"></i>Change Password</a></li>
			 </li>

			<li class="treeview">
			  	<li><a href="<?php echo base_url();?>web/Snrakshklog/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</li>
		  </ul>
		</section>
		<!-- /.sidebar -->
	  </aside>
  <?php }elseif ($sessionData['admintype'] == 'supervisor') {?>
  	<!-- Left side column. contains the logo and sidebar -->
	  <aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="<?php echo base_url(); ?>temp/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			  <p><?php echo "Supervisor"; ?></p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		  </div>
		  <ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			 <li <?php if($this->uri->segment(3)=="fieldinspectorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Supervisor/fieldinspectorlist"><i class="fa fa-users"></i>Field Inspector List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="changepassword"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Supervisor/changepassword"><i class="fa fa-key"></i>Change Password</a></li>

			<li class="treeview">
			  	<li><a href="<?php echo base_url();?>web/Snrakshklog/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</li>
		  </ul>
		</section>
		<!-- /.sidebar -->
	  </aside>
  <?php } elseif ($sessionData['admintype'] == 'reasonalhead') {?>
  	<!-- Left side column. contains the logo and sidebar -->
	  <aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="<?php echo base_url(); ?>temp/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			  <p><?php echo "Reasonal Head"; ?></p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		  </div>
		  <ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="active treeview">
			 
			 <li <?php if($this->uri->segment(3)=="supervisorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Reasonalhead/supervisorlist"><i class="fa fa-users"></i>Supervisor List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="fieldinspectorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Reasonalhead/fieldinspectorlist"><i class="fa fa-users"></i>Field Inspector List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="changepassword"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Reasonalhead/changepassword"><i class="fa fa-key"></i>Change Password</a></li>

			<li class="treeview">
			  	<li><a href="<?php echo base_url();?>web/Snrakshklog/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</li>
		  </ul>
		</section>
		<!-- /.sidebar -->
	  </aside>
  <?php } elseif ($sessionData['admintype'] == 'companyhead') {?>
  	<!-- Left side column. contains the logo and sidebar -->
	  <aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
		  <!-- Sidebar user panel -->
		  <div class="user-panel">
			<div class="pull-left image">
			  <img src="<?php echo base_url(); ?>temp/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
			  <p><?php echo "Company Head"; ?></p>
			  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		  </div>
		  <ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="active treeview">
			 
			<li <?php if($this->uri->segment(3)=="reasonalheadlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Companyhead/reasonalheadlist"><i class="fa fa-users"></i>Reasonal Head List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="supervisorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Companyhead/supervisorlist"><i class="fa fa-users"></i>Supervisor List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="fieldinspectorlist"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Companyhead/fieldinspectorlist"><i class="fa fa-users"></i>Field Inspector List</a></li>
			 </li>

			 <li <?php if($this->uri->segment(3)=="changepassword"){echo 'class="active"';}?>><a href="<?php echo base_url();?>web/Companyhead/changepassword"><i class="fa fa-key"></i>Change Password</a></li>

			<li class="treeview">
			  	<li><a href="<?php echo base_url();?>web/Snrakshklog/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</li>
		  </ul>
		</section>
		<!-- /.sidebar -->
	  </aside>
  <?php } ?>
  