	<?php
	$bu = base_url();


	?>


	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Blank Page</h1>
				</div>

				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Rekap Menu</li>
					</ol>
				</div>
				<div class="row">
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box">
							<span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">CPU Traffic</span>
								<span class="info-box-number">
									10
									<small>%</small>
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->
					<div class="col-12 col-sm-6 col-md-3">
						<div class="info-box mb-3">
							<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Likes</span>
								<span class="info-box-number">41,410</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</div>
					<!-- /.col -->

					<!-- fix for small devices only -->
					<div class="clearfix hidden-md-up"></div>

					<a href="<?= $bu ?>produk"  class="col-12 col-sm-6 col-md-3">
						<div class="info-box mb-3">
							<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">Produk</span>
								<span class="info-box-number"><?= $produk ?></span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</a>
					<!-- /.col -->
					<a href="<?= $bu ?>user " class="col-12 col-sm-6 col-md-3">
						<div class="info-box mb-3">
							<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

							<div class="info-box-content">
								<span class="info-box-text">User</span>
								<span class="info-box-number"><?= count($user) ?>
								</span>
							</div>
							<!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					</a>
					<!-- /.col -->
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<a href=""></a>
