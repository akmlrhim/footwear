<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<div class="text-danger">
			<?= session()->getFlashdata('errors'); ?>
		</div>

		<div class="card card-primary">
			<div class="card-body">
				<form method="POST" action="<?= base_url('supplier/update' . '/' . $supplier['id_supplier']); ?>">
					<?= csrf_field(); ?>

					<div class="form-row mb-3">
						<div class="col">
							<label class="col-form-label">Nama Supplier </label>
							<input type="text" name="nama" class="form-control" autocomplete="off" value="<?= $supplier['nama']; ?>">
						</div>

						<div class="col">
							<label class="col-form-label">Kontak Supplier </label>
							<input type="number" name="kontak" class="form-control" autocomplete="off" value="<?= $supplier['kontak']; ?>">
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<a href="/supplier" class="btn btn-secondary">Kembali</a>

				</form>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>