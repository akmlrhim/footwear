<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<div class="text-danger">
			<?= session()->getFlashdata('errors'); ?>
		</div>

		<div class="card card-primary">
			<div class="card-body">
				<form action="<?= base_url('user/update/' . $usr['id_user']); ?>" method="post">
					<?= csrf_field(); ?>
					<div class="form-row mb-2	">
						<div class="col">
							<label class="col-form-label ">Nama Lengkap </label>
							<input type="text" name="nama_lengkap" class="form-control" autocomplete="off" value="<?= $usr['nama_lengkap']; ?>">
						</div>
					</div>
					<div class="form-group ">
						<label for="Nama">Username : </label>
						<input type="text" name="username" class="form-control" autocomplete="off" value="<?= $usr['username']; ?>">
					</div>

					<div class="form-group ">
						<label for="Nama">Email : </label>
						<input type="email" name="email" class="form-control" autocomplete="off" value="<?= $usr['email']; ?>">
					</div>

					<div class="form-group ">
						<label for="select-roles">Roles : </label>
						<select name="role" class="form-control">
							<option value="">-- Pilih Role --</option>
							<option value="<?= $usr['role']; ?>" <?= ($usr['role'] == $usr['role']) ? 'selected' : ''; ?>><i>Role Sebelumnya</i>
								(<?= $usr['role']; ?>)</option>
							<option value="Owner">Owner</option>
							<option value="Karyawan">Karyawan</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary">Simpan Data</button>
					<a href="<?= base_url('/user'); ?>" class="btn btn-secondary"> Kembali </a>
				</form>
			</div>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>