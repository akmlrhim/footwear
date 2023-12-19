<style>
	table,
	td,
	th {
		border: 1px solid black;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	th,
	td {
		padding: 2px;
	}

	th {
		background-color: #CCC;
	}
</style>

<h1>Data Barang Masuk | Footwears</h1>
<h3>Periode : <?= date('d/m/Y ', strtotime($tgl_awal)) . " s/d " . date('d/m/Y ', strtotime($tgl_akhir)) ?></h3>
<table>
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Barang</th>
			<th>Kategori</th>
			<th>Jumlah Masuk</th>
			<th>Supplier</th>
			<th>Harga Satuan</th>
			<th>Total Harga</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1 ?>
		<?php $totalSeluruhHarga =  0 ?>
		<?php foreach ($result as $res) : ?>
			<?php $totalSeluruhHarga += $res['total_harga'] ?>
			<tr>
				<td><?= $no++; ?></td>
				<td><?= esc($res['nama_barang']) ?></td>
				<td><?= esc($res['nama_kategori']) ?></td>
				<td><?= esc($res['jumlah_masuk']); ?></td>
				<td><?= esc($res['nama']); ?></td>
				<td>Rp. <?= number_format($res['harga_satuan'], 0, ',', '.'); ?></td>
				<td>Rp. <?= number_format($res['total_harga'], 0, ',', '.'); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6">Total Seluruh Harga :</th>
			<td><b>Rp. <?= number_format($totalSeluruhHarga, 0, ',', '.'); ?></b></td>
		</tr>
	</tfoot>
</table>