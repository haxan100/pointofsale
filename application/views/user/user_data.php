<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>User</h1>
			</div>
			<?php
			// $ci = ;
			$bu = base_url();


			?>

			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">User</li>
				</ol>
			</div>
			<div class="row">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">New Members</span>
						<span class="info-box-number"><?= $count ?></span>
					</div>
					<!-- /.info-box-content -->
				</div>
			</div>
		</div>
		<!-- modal tambah -->


		<!-- Modal HTML Markup -->
		<div id="exampleModal" class="modal fade">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<h1>Tambah User</h1>
						<form role="form" method="POST" action="">
							<input type="hidden" name="user_id" id="user_id" value="">
							<div class="form-group">
								<label class="control-label">Username</label>
								<div>
									<input type="text" class="form-control input-lg" name="name" id="username" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Nama Lengkap</label>
								<div>
									<input type="text" class="form-control input-lg" name="nama_tengkap" id="nama_lengkap" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Password</label>
								<div>
									<input type="text" class="form-control input-lg" id="password" name="password">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Level</label>
								<div>
									<select name="level" id="level" class="btn btn-primary m-t-20 btn-info waves-effect waves-light ">
										<option value="default" desable>Pilih Level</option>
										<option value="1">Admin</option>
										<option value="2">Kasir</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Email</label>
								<div>
									<input type="email" class="form-control input-lg" id="email" name="email">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Alamat</label>
								<div>
									<textarea type="text" class="form-control input-lg" id="alamat" name="alamat"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div>
									<button type="button" id="tambahUser" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
									<button type="button" id="btnEdit" class="btn btn-primary"><i class="fas fa-save"></i> Edit</button>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- modal tambah -->



		<div class="card">
			<div class="card-header">
				<h3 class="card-title">User List</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<a data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">
					<i class="fas fa-user-plus">
					</i> Tambah
				</a>
				<hr>

				<p id="alertNotif" class="mt-2"></p>
				<div class="table-responsive">
					<table id="adminList" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Username</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Alamat</th>
								<th>Level</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No.</th>
								<th>Username</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Alamat</th>
								<th>Level</th>
								<th>Aksi</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<!-- /.card-body -->
		</div>




		<!-- /.info-box -->
		<!-- /.col -->

	</div>
	</div><!-- /.container-fluid -->
</section>
<script src="<?= $bu; ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- <script src="<?= $bu; ?>assets/plugins/datatables/jquery.dataTables.js"></script> -->
<script src="<?= $bu; ?>assets/plugins/datatables/datatables.min.js" defer></script>


<script>
	$(document).ready(function() {

		$('#tambahUser').on('click', function() {
			var username = $('#username').val();
			var nama_lengkap = $('#nama_lengkap').val();
			var password = $('#password').val();
			var email = $('#email').val();
			var alamat = $('#alamat').val();
			var level = $('#level option:selected').val();
			// console.log(username, nama_lengkap, password, email, alamat, level);
			// return false;
			$('#btnEdit').hide();


			if (username == '') {
				$('*[for="username"] > small').html('Harap diisi!');
				alert('harap isi username!');
			} else if (password == '') {
				$('*[for="password"] > small').html('Harap diisi!');
				alert('harap isi password!');
			} else if (nama_lengkap == '') {
				alert('harap isi nama lengkap!');

				$('*[for="nama_lengkap"] > small').html('Harap Isikan Nama!');
			} else if (level == 'default') {
				$('*[for="level"] > small').html('Harap Pilih Level!');
			} else {

				$.ajax({
					url: '<?= $bu ?>user/tambah_user ',
					dataType: 'json',
					method: 'POST',
					data: {
						nama_lengkap: nama_lengkap,
						username: username,
						password: password,
						email: email,
						level: level,
						alamat: alamat,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					$('#nama').val('');
					$('#username').val('');
					$('#password').val('');
					$('#email').val('');
					datatable.ajax.reload();
					//$('body').removeClass('modal-open');$('.modal-backdrop').remove();
					var alert = '';
					if (e.status) {
						notifikasi('#alertNotif', e.message, false);
						$('#exampleModal').modal('hide');
						datatable.ajax.reload();
						// resetForm();
					} else {
						notifikasi('#alertNotif', e.message, true);
						$('#exampleModal').modal('hide');

						$.each(e.errorInputs, function(key, val) {
							console.log(val[0], val[1]);
							// validasi(val[0], false, val[1]);
							$(val[0])
								.parent()
								.find('.input-group-text')
								.addClass('form-control is-invalid');
						});

					}
				}).fail(function(e) {
					console.log(e);
					// resetForm($('#exampleModal'));
					$('#modalAdmin').modal('show');
					notifikasi('#alertNotif', 'Terjadi kesalahan!', true);

				});
			}
		});
		var datatable = $('#adminList').DataTable({
			'lengthMenu': [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, 'All']
			],
			'pageLength': 5,
			"processing": true,
			"serverSide": true,
			"columnDefs": [{
					"targets": 0,
					"className": "dt-body-center dt-head-center",
					"width": "20px"
				},
				{
					"targets": 1,
					"className": "dt-head-center"
				},
				{
					"targets": 2,
					"className": "dt-body-center dt-head-center"
				},
				{
					"targets": 3,
					"className": "dt-body-center dt-head-center"
				},
				{
					"targets": 4,
					"className": "dt-body-center dt-head-center",
					"orderable": false
				},
			],
			"order": [
				[2, "asc"]
			],
			'ajax': {
				url: '<?= base_url('user/getAllUser'); ?>',
				type: 'POST',
			},
		});

		$('body').on('click', '.btnHapus', function() {
			var user_id = $(this).data('user_id');
			var username = $(this).data('username');
			var c = confirm('Apakah anda yakin akan menghapus User: "' + username + '" ?');
			if (c == true) {
				$.ajax({
					url: '<?= base_url('user/hapusUser'); ?>',
					// url: bu + 'user/hapusUser',
					dataType: 'json',
					method: 'POST',
					data: {
						user_id: user_id
					}
				}).done(function(e) {
					console.log(e);
					notifikasi('#alertNotif', e.message, !e.status);
					datatable.ajax.reload();
				}).fail(function(e) {
					console.log('gagal');
					console.log(e);
					var message = 'Terjadi Kesalahan. #JSMP01';
					notifikasi('#alertNotif', message, true);
				});
			}
			return false;
		});



		function notifikasi(sel, msg, err) {
			var alert_type = 'alert-success ';
			if (err) alert_type = 'alert-danger ';
			var html = '<div class="alert ' + alert_type + ' alert-dismissible show p-4">' + msg + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
			$(sel).html(html);
			// $('html, body').animate({
			// 	scrollTop: $(sel).offset().top - 75
			// }, 500);
		}

		$('body').on('click', '.btnEditAdmin', function() {

			// console.log("kkk");return(false);
			var user_id = $(this).data('user_id');
			var nama_lengkap = $(this).data('nama_lengkap');
			var username = $(this).data('username');
			var password = $(this).data('password');
			var email = $(this).data('email');
			var alamat = $(this).data('alamat');
			var level = $(this).data('level');


			$('#btnEdit').show();
			$('#tambahUser').hide();
			$('.modalProdukTitleTambah').hide();
			$('#modalProdukTitleUbah').show();
			$('#tambahUser').hide();
			$('#modalEditUserTitle').hide();
			$('#editUser').show();
			$('#exampleModal').modal('show');

			// $('.btnEditAdmin').on('click', function() {

			$('#user_id').val(user_id);
			$('#username').val(username);
			$('#password').val(password);
			$('#email').val(email);
			$('#nama_lengkap').val(nama_lengkap);
			$('#alamat').val(alamat);



			// return false;
		});




	});
</script>
