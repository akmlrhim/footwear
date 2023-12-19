<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">
		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif ?>
		<div class="card">
			<div class="card-body">

				<div class="text-danger">
					<?= session()->getFlashdata('error'); ?>
				</div>

				<form action="<?= base_url('account/ubah-password'); ?>" method="POST">
					<?= csrf_field(); ?>
					<div class="form-group">
						<label for="current_password">Password Lama</label>
						<input type="password" class="form-control" name="password_lama" autocomplete="off" value="<?= old('password_lama'); ?>">
						<small class="text-danger"><?= session()->getFlashdata('passlama'); ?></small>
					</div>
					<div class="form-group">
						<label for="new_password">Password Baru</label>
						<input type="password" class="form-control" name="password_baru" autocomplete="off" value="<?= old('password_baru'); ?>">
					</div>
					<div class="form-group">
						<label for="re_password">Konfirmasi Password</label>
						<input type="password" class="form-control" name="re_password" autocomplete="off" value="<?= old('re_password'); ?>">
					</div>

					<button type="submit" class="btn btn-primary ">Simpan</button>
					<a href="<?= base_url('user'); ?>" class="btn  btn-secondary">Kembali</a>
				</form>
			</div>
		</div>

	</div>
</section>



<?= $this->endSection(); ?>