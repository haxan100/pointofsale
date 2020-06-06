<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Suplier</h1>
			</div>
			<?php
			// $ci = ;suplier_id
			$bu = base_url();


			?>

			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Suplier</li>
				</ol>
			</div>
			<div class="row">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">New Suplier</span>
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
						<h1>Tambah Suplier</h1>
						<form role="form" method="POST" action="">
							<input type="hidden" name="suplier_id" id="suplier_id" value="">
							<div class="form-group">
								<label class="control-label">Nama Suplier</label>
								<div>
									<input type="text" class="form-control input-lg" name="nama_suplier" id="nama_suplier" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Status</label>
								<div>
									<select name="status" id="status" class="btn btn-primary m-t-20 btn-info waves-effect waves-light ">
										<option value="default" desable>Pilih Status</option>
										<option value="0">Tidak Aktif</option>
										<option value="1">Aktif</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">No. Telp</label>
								<div>
									<input type="text" class="form-control input-lg" id="no_telp" name="no_telp">
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
				<a data-toggle="modal" data-target="#exampleModal" class=" tambahSuplier btn btn-primary">
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
								<th>Nama Suplier</th>
								<th>No Telp </th>
								<th>Alamat</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No.</th>
								<th>Nama Suplier</th>
								<th>No Telp </th>
								<th>Alamat</th>
								<th>Status</th>
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

		var bu = '<?= base_url(); ?>';

		$('.tambahSuplier').on('click', function() {
			console.log("semangat");


			$('#btnEdit').hide();
		});

		$('#tambahUser').on('click', function() {
			var nama_suplier = $('#nama_suplier').val();
			var no_telp = $('#no_telp').val();
			var alamat = $('#alamat').val();
			var status = $('#status option:selected').val();

			$('#btnEdit').hide();


			if (nama_suplier == '') {
				$('*[for="nama_suplier"] > small').html('Harap diisi!');
				alert('harap isi Nama Suplier!');
			} else if (no_telp == '') {
				$('*[for="no_telp"] > small').html('Harap diisi!');
				alert('harap isi no telpon!');
			} else if (alamat == '') {
				alert('harap isi Alamat lengkap!');

				$('*[for="alamat"] > small').html('Harap Isikan Nama!');
			} else if (status == 'default') {

				alert('harap isi Status!');
				$('*[for="status"] > small').html('Harap Pilih Level!');
			} else {

				$.ajax({
					url: '<?= $bu ?>user/tambah_suplier ',
					dataType: 'json',
					method: 'POST',
					data: {
						nama_suplier: nama_suplier,
						status: status,
						no_telp: no_telp,
						alamat: alamat,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					$('#nama_suplier').val('');
					$('#status option:selected').val('');
					$('#no_telp').val('');
					$('#alamat').val('');
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
			],
			"order": [
				[2, "asc"]
			],
			'ajax': {
				url: '<?= base_url('user/getAllSuplier'); ?>',
				type: 'POST',
			},
		});

		$('body').on('click', '.btnHapus', function() {
			var suplier_id = $(this).data('suplier_id');
			var nama_suplier = $(this).data('nama_suplier');
			var c = confirm('Apakah anda yakin akan menghapus User: "' + nama_suplier + '" ?');
			if (c == true) {
				$.ajax({
					url: '<?= base_url('user/hapusSuplier'); ?>',
					// url: bu + 'user/hapusUser',
					dataType: 'json',
					method: 'POST',
					data: {
						suplier_id: suplier_id
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
			var suplier_id = $(this).data('suplier_id');
			var nama_suplier = $(this).data('nama_suplier');
			var no_telp = $(this).data('no_telp_suplier');
			var alamat = $(this).data('alamat_suplier');
			var status = $(this).data('status_suplier');

			// console.log(no_telp);
			// return (false);

			$('#btnEdit').show();
			$('#tambahUser').hide();
			$('.modalProdukTitleTambah').hide();
			$('#modalProdukTitleUbah').show();
			$('#tambahUser').hide();
			$('#modalEditUserTitle').hide();
			$('#editUser').show();
			$('#exampleModal').modal('show');

			// $('.btnEditAdmin').on('click', function() {

			$('#suplier_id').val(suplier_id);
			$('#nama_suplier').val(nama_suplier);
			$('#status').val(status);
			$('#alamat').val(alamat);
			$('#no_telp').val(no_telp);



			// return false;
		});
		$('#btnEdit').on('click', function() {

			var suplier_id = $('#suplier_id').val();
			// console.log(suplier_id);return(false);

			var status = $('#status option:selected').val();
			var no_telpon = $('#no_telp').val();
			var alamat = $('#alamat').val();
			var nama_suplier = $('#nama_suplier').val();
			// console.log(status);
			// return (false);


			if (status == 'default') {
				$('*[for="status"] > small').html('Harap diisi!');
				alert('harap isi status!');
			} else if (nama_suplier == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama suplier!');
			} else if (no_telpon == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nomor telpon suplier!');
			} else {



				$.ajax({
					url: '<?= $bu ?>user/edit_Suplier ',
					dataType: 'json',
					method: 'POST',
					data: {

						suplier_id: suplier_id,
						status: status,
						no_telpon: no_telpon,
						alamat: alamat,
						nama_suplier: nama_suplier,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					$('#slug').val('');
					$('#nama_kategori').val('');
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


				return false;
			}
		});




	});

</script>
