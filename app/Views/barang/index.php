<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">

		<?php if (session()->get('role') == "Owner") : ?>
			<a href="<?= base_url('barang/tambah'); ?>" class="btn btn-primary mb-3">
				<i class="fas fa-plus-circle mr-2"></i> Tambah Data
			</a>
			<a href="<?= base_url('barang/cetak-barang-habis'); ?>" class="btn btn-danger mb-3"><i class="fas fa-print mr-2"></i>Cetak Barang Habis</a>
		<?php endif; ?>

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif ?>

		<?php if (session()->getFlashdata('empty')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?= session()->getFlashdata('empty'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="card">
			<div class="card-body">

				<div class="table-responsive-sm">
					<table id="tables" class="table table-bordered text-center table-sm" style="width:100%">
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
							<!-- data ditampilkan dengan sideserver -->
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
		$("#tables").DataTable({
			responsive: true,
			lengthChange: true,
			processing: true,
			serverSide: true,
			ajax: '<?= base_url('barang/data-barang'); ?>',
			columns: [{
					data: 'nama_barang',
					name: 'barang.nama_barang'
				},
				{
					data: 'nama_kategori',
					name: 'kategori.nama_kategori'
				},
				{
					data: 'jumlah',
					name: 'barang.jumlah'
				},
				{
					data: 'ukuran',
					name: 'barang.ukuran'
				},
				{
					data: 'warna',
					name: 'barang.warna'
				},
				{
					data: 'status',
					orderable: false
				},
				{
					data: 'action',
					orderable: false
				}
			]
		});
	});
</script>
<?= $this->endSection(); ?>