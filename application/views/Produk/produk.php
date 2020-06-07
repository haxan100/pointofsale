<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Produk</h1>
			</div>
			<?php
			// $ci = ;
			$bu = base_url();





			?>

			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Produk</li>
				</ol>
			</div>
			<div class="row">
				<div class="info-box mb-3">
					<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

					<div class="info-box-content">
						<span class="info-box-text">Produk</span>
						<span class="info-box-number"><?= $countKategori ?></span>
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
						<h1>Tambah Produk</h1>
						<form role="form" method="POST" action="">
							<input type="hidden" name="kode_produk" id="kode_produk" value="">
							<div class="form-group">
								<label class="control-label">Nama Produk</label>
								<div>
									<input type="text" class="form-control input-lg" name="nama_produk" id="nama_produk" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Harga Produk </label>
								<div>
									<input type="number" class="form-control input-lg" name="harga_produk" id="harga_produk" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Kategori</label>
								<select class="form-control" name="kategori" id="kategori" required>
									<option value="">No Selected</option>
									<?php foreach ($kategori as $row) : ?>
										<option value="<?php echo $row->id_kategori; ?>"><?php echo $row->nama_kategori; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Suplier</label>
								<select class="form-control" name="suplier" id="suplier" required>
									<option value="">No Selected</option>
									<?php foreach ($suplier as $row) : ?>
										<option value="<?php echo $row->suplier_id; ?>"><?php echo $row->nama_suplier; ?></option>
									<?php endforeach; ?>
									<option value="0">Tidak Ada Suplier</option>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Stok</label>
								<div>
									<input type="number" class="form-control input-lg" name="stok" id="stok" value="">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label">Status</label>
								<div>
									<div class="form-group">
										<div>
											<select class="form-control" name="status" id="status" required>
												<option value="">No Selected</option>
												<option value="1">Dijual</option>
												<option value="0">Ditahan</option>
											</select>
										</div>
									</div>
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
								<th>Kode Produk</th>
								<th>Nama Produk</th>
								<th>Harga</th>
								<th>Kategori</th>
								<th>Status</th>
								<th>Stok</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No.</th>
								<th>Kode Produk</th>
								<th>Nama Produk</th>
								<th>Harga</th>
								<th>Kategori</th>
								<th>Status</th>
								<th>Stok</th>
								<th>Aksi</th>
							</tr>
						</tfoot>
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

		$('#tambahUser').on('click', function() {
			var nama_produk = $('#nama_produk').val();
			var harga_produk = $('#harga_produk').val();
			var kategori = $('#kategori').val();

			var suplier = $('#suplier').val();
			var stok = $('#stok').val();
			var status = $('#status').val();
			// console.log(kategori);
			// return false;
			$('#btnEdit').hide();


			if (nama_produk == '') {
				$('*[for="slug"] > small').html('Harap diisi!');
				alert('harap isi Nama Produk!');
			} else if (harga_produk == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama Harga Produk!');
			} else if (kategori == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama Kategori!');
			} else if (stok == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama Stok!');
			} else if (status == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama Stok!');
			} else {

				$.ajax({
					url: '<?= $bu ?>produk/tambah_produk ',
					dataType: 'json',
					method: 'POST',
					data: {
						nama_produk: nama_produk,
						harga_produk: harga_produk,

						kategori: kategori,
						suplier: suplier,
						stok: stok,
						status: status,
					}
				}).done(function(e) {
					console.log('berhasil');
					// console.log(e);
					$('#nama_produk').val();
					$('#kategori').val('');
					$('#harga_produk').val('');

					$('#suplier').val();
					$('#stok').val('');
					$('#status').val('');
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
					"className": "dt-body-center dt-head-center"
				},
				{
					"targets": 5,
					"className": "dt-body-center dt-head-center"
				},
				{
					"targets": 6,
					"className": "dt-body-center dt-head-center"
				},
				{
					"targets": 7,
					"className": "dt-body-center dt-head-center"
				},
			],
			"order": [
				[2, "asc"]
			],
			'ajax': {
				url: '<?= base_url('produk/getAllProduk'); ?>',
				type: 'POST',
			},
		});

		$('body').on('click', '.btnHapus', function() {
			var id_kategori = $(this).data('id_kategori');
			var nama_kategori = $(this).data('nama_kategori');
			var c = confirm('Apakah anda yakin akan menghapus kategori: "' + nama_kategori + '" ?');
			if (c == true) {
				$.ajax({
					url: '<?= base_url('Produk/hapusKategori'); ?>',
					// url: bu + 'user/hapusUser',
					dataType: 'json',
					method: 'POST',
					data: {
						id_kategori: id_kategori
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
			var id_kategori = $(this).data('id_kategori');
			var nama_kategori = $(this).data('nama_kategori');
			var slug_kategori = $(this).data('slug_kategori');

			$('#btnEdit').show();
			$('#tambahUser').hide();
			$('.modalProdukTitleTambah').hide();
			$('#modalProdukTitleUbah').show();
			$('#tambahUser').hide();
			$('#modalEditUserTitle').hide();
			$('#editUser').show();
			$('#exampleModal').modal('show');

			// $('.btnEditAdmin').on('click', function() {
			// console.log(bu)

			$('#id_kategori').val(id_kategori);
			$('#nama_kategori').val(nama_kategori);
			$('#slug').val(slug_kategori);


			$("#form").submit();
			url_form = url_form_ubah;


			// return false;
		});

		function cekSlug() {
			var slug = $('#slug').val();
			if (slug == '') {
				validasi('#slug', false, 'Silahkan Isi Slug');
				return false;
			} else {
				validasi('#slug', true);
				return true;
			}
		}


		$('#btnEdit').on('click', function() {

			var slug = $('#slug').val();
			var id_kategori = $('#id_kategori').val();
			var nama_kategori = $('#nama_kategori').val();
			url_form = url_form_ubah;
			if (slug == '') {
				$('*[for="slug"] > small').html('Harap diisi!');
				alert('harap isi slug!');
			} else if (nama_kategori == '') {
				$('*[for="nama_kategori"] > small').html('Harap diisi!');
				alert('harap isi nama kategori!');
			} else {



				$.ajax({
					url: '<?= $bu ?>produk/edit_kategori ',
					dataType: 'json',
					method: 'POST',
					data: {
						slug: slug,
						nama_kategori: nama_kategori,
						id_kategori: id_kategori,
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
