<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Satuan Produk</h1>
			</div>
			<?php
			// $ci = ;
			$bu = base_url();


			?>

			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Satuan</li>
				</ol>
			</div>
			<div class="row">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Satuan</span>
						<span class="info-box-number"><?= $countSatuan ?></span>
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
						<h1>Tambah Satuan</h1>
						<form role="form" method="POST" action="">
							<input type="hidden" name="id_satuan" id="id_satuan" value="">
							<div class="form-group">
								<label class="control-label">Nama Satuan</label>
								<div>
									<input type="text" class="form-control input-lg" name="nama_satuan" id="nama_satuan" value="">
								</div>
							</div>

							<div class="form-group">
								<div>
									<button type="button" id="tambahSatuan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
			<!-- /.card-header -->
			<div class="card-body">
				<a data-toggle="modal" data-target="#exampleModal" class="btn btn-primary tambahKategori">
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
								<th>Nama Satuan</th>
								<th>Aksi</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<!-- /.card-body -->
		</div>

	</div>
	</div><!-- /.container-fluid -->
</section>
<script src="<?= $bu; ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- <script src="<?= $bu; ?>assets/plugins/datatables/jquery.dataTables.js"></script> -->
<script src="<?= $bu; ?>assets/plugins/datatables/datatables.min.js" defer></script>


<script>
	$(document).ready(function() {

		var bu = '<?= base_url(); ?>';

		var url_form_ubah = bu + 'produk/ubah_produk_proses';
		$('.tambahKategori').on('click', function() {
			console.log("semangat");


			$('#btnEdit').hide();
		});

		$('#tambahSatuan').on('click', function() {
			var nama_satuan = $('#nama_satuan').val();
			// console.log(username, nama_lengkap, password, email, alamat, level);
			// return false;
			$('#btnEdit').hide();


			if (nama_satuan == '') {
				$('*[for="nama_satuan"] > small').html('Harap diisi!');
				alert('harap isi nama satuan!');
			} else {

				$.ajax({
					url: '<?= $bu ?>produk/tambah_satuan ',
					dataType: 'json',
					method: 'POST',
					data: {
						
						nama_satuan: nama_satuan,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					
					$('#nama_satuan').val('');
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
			],
			"order": [
				[2, "asc"]
			],
			'ajax': {
				url: '<?= base_url('produk/getAllSatuan'); ?>',
				type: 'POST',
			},
		});

		$('body').on('click', '.btnHapus', function() {
			var id_satuan = $(this).data('id_satuan');
			var nama_satuan = $(this).data('nama_satuan');
			var c = confirm('Apakah anda yakin akan menghapus Satuan: "' + nama_satuan + '" ?');
			if (c == true) {
				$.ajax({
					url: '<?= base_url('Produk/hapusSatuan'); ?>',
					// url: bu + 'user/hapusUser',
					dataType: 'json',
					method: 'POST',
					data: {
						id_satuan: id_satuan
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

			console.log("kkk");
			// return(false);
			var id_satuan = $(this).data('id_satuan');
			var nama_satuan = $(this).data('nama_satuan');

			$('#btnEdit').show();
			$('#tambahSatuan').hide();
			$('.modalProdukTitleTambah').hide();
			$('#modalProdukTitleUbah').show();
			$('#tambahSatuan').hide();
			$('#modalEditUserTitle').hide();
			$('#editUser').show();
			$('#exampleModal').modal('show');

			// $('.btnEditAdmin').on('click', function() {
			// console.log(bu)

			$('#id_satuan').val(id_satuan);
			$('#nama_satuan').val(nama_satuan);

			$("#form").submit();
			url_form = url_form_ubah;


			// return false;
		});




		$('#btnEdit').on('click', function() {
			
			var id_satuan = $('#id_satuan').val();
			var nama_satuan = $('#nama_satuan').val();
			url_form = url_form_ubah;
			if (nama_satuan == '') {
				$('*[for="nama_satuan"] > small').html('Harap diisi!');
				alert('harap isi nama satuan!');
			} else {



				$.ajax({
					url: '<?= $bu ?>produk/edit_satuan ',
					dataType: 'json',
					method: 'POST',
					data: {
						
						nama_satuan: nama_satuan,
						id_satuan: id_satuan,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					
					$('#nama_satuan').val('');
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
