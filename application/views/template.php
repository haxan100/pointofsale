<!DOCTYPE html>
<html>
<?php
// $ci = ;
$bu = base_url();


?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>AdminLTE 3 | Blank Page</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url()  ?>assets/plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url()  ?>assets/dist/css/adminlte.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="<?= base_url()  ?>assets/index3.html" class="nav-link">Home</a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="#" class="nav-link">Contact</a>
				</li>
			</ul>

			<!-- SEARCH FORM -->
			<form class="form-inline ml-3">
				<div class="input-group input-group-sm">
					<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
						<button class="btn btn-navbar" type="submit">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</div>
			</form>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Messages Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-comments"></i>
						<span class="badge badge-danger navbar-badge">3</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<a href="#" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<img src="<?= base_url()  ?>assets/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										Brad Diesel
										<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">Call me whenever you can...</p>
									<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
								</div>
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<img src="<?= base_url()  ?>assets/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										John Pierce
										<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">I got your message bro</p>
									<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
								</div>
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<!-- Message Start -->
							<div class="media">
								<img src="<?= base_url()  ?>assets/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
								<div class="media-body">
									<h3 class="dropdown-item-title">
										Nora Silvester
										<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
									</h3>
									<p class="text-sm">The subject goes here</p>
									<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
								</div>
							</div>
							<!-- Message End -->
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
					</div>
				</li>
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge">15</span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
							<span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
							<span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
							<span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
						<i class="fas fa-th-large"></i>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="<?= base_url()  ?>assets/index3.html" class="brand-link">
				<img src="<?= base_url()  ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light">AdminLTE 3</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">

					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item has-treeview">
							<a href="#" class="nav-link">
								<div class="image">
									<img src="<?= base_url()  ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
								</div>
								<p>
									<?= $this->fungsi->user_login()->nama_lengkap; ?>
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?php echo site_url('auth/logout') ?>" class="nav-link">
										<i class="fas fa-power-off"></i>
										<p>Log Out</p>
									</a>
								</li>
								<!-- <li class="nav-item">
									<a href="../../index2.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v2</p>
									</a>
								</li> -->
								<!-- <li class="nav-item">
									<a href="../../index3.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v3</p>
									</a>
								</li> -->
							</ul>
						</li>
					</ul>
				</div>



				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<?php if ($this->session->userdata('level') == 1) { ?>

							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-copy"></i>
									<p>
										Layout Options
										<i class="fas fa-angle-left right"></i>
										<span class="badge badge-info right">6</span>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="../layout/top-nav.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Top Navigation</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../layout/boxed.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Boxed</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../layout/fixed-sidebar.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Fixed Sidebar</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../layout/fixed-topnav.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Fixed Navbar</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../layout/fixed-footer.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Fixed Footer</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../layout/collapsed-sidebar.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Collapsed Sidebar</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-chart-pie"></i>
									<p>
										Charts
										<i class="right fas fa-angle-left"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="../charts/chartjs.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>ChartJS</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../charts/flot.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Flot</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../charts/inline.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Inline</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-tree"></i>
									<p>
										UI Elements
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="../UI/general.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>General</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/icons.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Icons</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/buttons.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Buttons</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/sliders.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Sliders</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/modals.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Modals & Alerts</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/navbar.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Navbar & Tabs</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/timeline.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Timeline</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../UI/ribbons.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Ribbons</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-edit"></i>
									<p>
										Forms
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="../forms/general.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>General Elements</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= $bu ?>produk/kategori" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Kategori</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="<?= $bu ?>produk/satuan" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Satuan</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../forms/editors.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>Editors</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-table"></i>
									<p>
										Tables
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="<?= $bu ?>user" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>User</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../tables/data.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>DataTables</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="../tables/jsgrid.html" class="nav-link">
											<i class="far fa-circle nav-icon"></i>
											<p>jsGrid</p>
										</a>
									</li>
								</ul>
							</li>

						<?php } ?>

						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-circle text-info"></i>
								<p>Informational</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<?php echo $contents ?>

			<!-- Main content -->

			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Version</b> 3.0.1
			</div>
			<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
			reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="<?= base_url()  ?>assets/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url()  ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url()  ?>assets/dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?= base_url()  ?>assets/dist/js/demo.js"></script>
</body>

</html>
