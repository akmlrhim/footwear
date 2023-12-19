<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">
		<div class="card card-primary">
			<div class="card-body">

				<div class="text-danger">
					<?= session()->getFlashdata('errors'); ?>
				</div>

				<form method="POST" action="<?= base_url('barang/simpan'); ?>" enctype="multipart/form-data" class="no-style">
					<?= csrf_field(); ?>
					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Nama Barang </label>
							<input type="text" name="nama_barang" class="form-control" autocomplete="off" value="<?= old('nama_barang'); ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Kategori </label>
							<select name="id_kategori" class="form-control">
								<option value="">-- Pilih Kategori --</option>
								<?php foreach ($kategori as $ktg) : ?>
									<option value="<?= $ktg['id_kategori']; ?>"><?= $ktg['nama_kategori']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group mt-3">
						<label class="col-form-label">Gambar </label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="gambar" id="gambarInput" onchange="updateFileName()">
							<label class="custom-file-label" for="gambarInput">Pilih Gambar...</label>
						</div>
					</div>

					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Ukuran </label>
							<input type="number" name="ukuran" class="form-control" min=0 autocomplete="off" value="<?= old('ukuran'); ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Warna </label>
							<input type="text" name="warna" class="form-control" autocomplete="off" value="<?= old('warna'); ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Jumlah </label>
							<input type="number" name="jumlah" class="form-control" min=0 autocomplete="off" value="<?= old('jumlah'); ?>">
						</div>
					</div>

					<div class="form-row mt-3 mb-3">
						<label class="col-form-label">Deskripsi </label>
						<div class="col-sm-12">
							<textarea class="form-control" rows="3" name="deskripsi"></textarea>
						</div>
					</div>


					<button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
					<a href="/barang" class="btn btn-secondary btn-sm">Kembali</a>

				</form>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
	function updateFileName() {
		var input = document.getElementById('gambarInput');

		var fileName = input.files[0].name;

		var label = document.querySelector('.custom-file-label');
		label.innerHTML = fileName;
	}
</script>
<?= $this->endSection(); ?>