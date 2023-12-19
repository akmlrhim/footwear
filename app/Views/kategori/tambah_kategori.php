<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">
		<div class="card card-primary">
			<form action="<?= base_url('kategori/simpan'); ?>" method="POST" id="tambah-kategori">
				<div class="card-body">

					<div class="text-danger">
						<?= session()->getFlashdata('errors'); ?>
					</div>

					<div class="form-group">
						<label>Nama Kategori</label>
						<input type="text" class="form-control" autocomplete="off" name="nama_kategori">
						<span class="text-danger error-text nama_kategori_error text-small"></span>
					</div>
					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<a href="<?= base_url('kategori'); ?>" class="btn btn-secondary">Kembali</a>
				</div>
			</form>
		</div>
		<!-- /.card -->

	</div>
</section>

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<?= $this->endSection(); ?>