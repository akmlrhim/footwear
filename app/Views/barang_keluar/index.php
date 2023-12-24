<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<a href="<?= base_url('barang_keluar/tambah'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus-circle mr-2"></i>Tambah Data</a>

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif; ?>

		<div class="card">
			<div class="card-body">

				<div class="table-responsive-sm">
					<table class="table table-bordered text-center table-sm " id="example1">
						<thead>
							<tr>
								<th scope="col">Tanggal</th>
								<th scope="col">Nama Barang / Kategori</th>
								<th scope="col">Jumlah Keluar</th>
								<th scope="col">Harga Satuan</th>
								<th scope="col">Total Harga</th>
								<?php if (session()->get('role') == 'Owner') : ?>
									<th scope="col">Disimpan Oleh</th>
								<?php endif; ?>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<?php foreach ($keluar as $klr) : ?>
							<tr>
								<td><?= date('d/m/Y ', strtotime($klr['tgl_keluar'])) ?></td>
								<td><?= esc($klr['nama_barang']) . ' / ' . esc($klr['nama_kategori']); ?></td>
								<td><?= esc($klr['jumlah_keluar']); ?></td>
								<td>Rp. <?= number_format($klr['harga_satuan'], 0, ',', '.'); ?></td>
								<td>Rp. <?= number_format($klr['total_harga'], 0, ',', '.'); ?></td>
								<?php if (session()->get('role') == 'Owner') : ?>
									<td><small class="badge badge-danger"> <?= esc($klr['disimpan_oleh']); ?></small></td>
								<?php endif; ?>
								<td>
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal<?= $klr['id_brg_keluar']; ?>">
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- mmodal hapus  -->

<?php foreach ($keluar as $klr) : ?>
	<div class="modal fade" id="modal<?= $klr['id_brg_keluar']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<i class="fas fa-info-circle text-danger mb-4" style="font-size: 70px;"></i>
					<p>Apakah Anda Yakin untuk Menghapus Data Ini ?</p>
					<form action="<?= base_url('barang_keluar/' . $klr['id_brg_keluar']); ?>" method="POST">
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