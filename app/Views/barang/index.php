<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">

		<?php if (session()->get('role') == "Owner") : ?>
			<a href="<?= base_url('barang/tambah'); ?>" class="btn btn-primary btn-sm mb-3">
				<i class="fas fa-plus-circle mr-2"></i> Tambah Data
			</a>
			<a href="<?= base_url('barang/cetak-barang-habis'); ?>" class="btn btn-danger btn-sm mb-3"><i class="fas fa-print mr-2"></i>Cetak Data Barang Habis</a>
		<?php endif; ?>


		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif ?>
		<div class="card">
			<div class="card-body">

				<div class="table-responsive-sm">
					<table id="example1" class="table table-bordered text-center table-sm" style="width:100%">
						<thead>
							<tr>
								<th>Nama Barang</th>
								<th>Kategori</th>
								<th>Jumlah</th>
								<th>Ukuran</th>
								<th>Warna</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($barang as $brg) : ?>
								<tr>
									<td><?= esc($brg['nama_barang']); ?></td>
									<td><?= esc($brg['nama_kategori']); ?></td>
									<td><?= esc($brg['jumlah']); ?></td>
									<td><?= esc($brg['ukuran']); ?></td>
									<td><?= esc($brg['warna']); ?></td>
									<td>
										<?php if ($brg['jumlah'] == 0) : ?>
											<small class="badge badge-danger"> Habis</small>
										<?php elseif ($brg['jumlah'] >= 0) : ?>
											<small class="badge badge-success"> Masih Ada</small>
										<?php endif; ?>
									</td>
									<td>
										<a href="<?= base_url('barang/detail/' . $brg['id_barang']) ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
										<?php if (session()->get('role') == "Owner") : ?>
											<a href="<?= base_url('barang/edit/' . $brg['id_barang']); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

											<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal<?= $brg['id_barang'] ?>">
												<i class="fas fa-trash"></i>
											</button>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- modal hapus -->
<?php foreach ($barang as $brg) : ?>
	<div class="modal fade" id="modal<?= $brg['id_barang']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header justify-content-center">
					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<i class="fas fa-info-circle text-danger mb-4" style="font-size: 70px;"></i>
					<p>Apakah Anda Yakin untuk Menghapus <strong><?= $brg['nama_barang']; ?></strong> ?</p>
					<form action="<?= base_url('barang/' . $brg['id_barang']); ?>" method="POST">
						<?= csrf_field(); ?>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger">Yakin</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
	$(function() {
		$("#example1").DataTable({
			responsive: true,
			lengthChange: true,
			autoWidth: false,
		});
	});
</script>
<?= $this->endSection(); ?>