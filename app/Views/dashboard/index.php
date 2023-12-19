<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<!-- owner saja -->
		<div class="row">
			<?php if (session()->get('role') == 'Owner') : ?>
				<div class="col-lg-3 col-6">
					<div class="small-box bg-warning">
						<div class="inner">
							<h3><?= $countBarang; ?></h3>
							<p>Total Semua Barang</p>
						</div>
						<div class="icon">
							<i class="fas fa-box"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-success">
						<div class="inner">
							<h3><?= $countBarangAda; ?></h3>
							<p>Barang Tersedia</p>
						</div>
						<div class="icon">
							<i class="fas fa-check"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-danger">
						<div class="inner">
							<h3><?= $countBarangHabis; ?></h3>
							<p>Barang Habis</p>
						</div>
						<div class="icon">
							<i class="fas fa-times-circle"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-dark">
						<div class="inner">
							<h3><?= $countKategori; ?></h3>
							<p>Kategori</p>
						</div>
						<div class="icon">
							<i class="fas fa-tags"></i>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-6">
					<div class="small-box bg-primary">
						<div class="inner">
							<h3><?= $countSupplier; ?></h3>
							<p>Supplier</p>
						</div>
						<div class="icon">
							<i class="fas fa-truck"></i>
						</div>
					</div>
				</div>


				<div class="col-lg-3 col-6">
					<div class="small-box bg-info">
						<div class="inner">
							<h3><?= $countUser; ?></h3>
							<p>User</p>
						</div>
						<div class="icon">
							<i class="fas fa-user"></i>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- owner dan karyawan -->
			<div class="col-lg-3 col-6">
				<div class="small-box bg-secondary">
					<div class="inner">
						<h3><?= $countBarangMasuk; ?></h3>
						<p>Barang Masuk</p>
					</div>
					<div class="icon">
						<i class="fas fa-inbox"></i>
					</div>
				</div>
			</div>

			<div class="col-lg-3 col-6">
				<div class="small-box bg-dark">
					<div class="inner">
						<h3><?= $countBarangKeluar; ?></h3>
						<p>Barang Keluar</p>
					</div>
					<div class="icon">
						<i class="fas fa-external-link-square-alt"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>