<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $table            = 'barang_masuk';
    protected $primaryKey       = 'id_brg_masuk';
    protected $allowedFields    = [
        'id_barang',
        'jumlah_masuk',
        'id_supplier',
        'harga_satuan',
        'total_harga',
        'tgl_masuk',
        'disimpan_oleh'
    ];

    public function getBarangMasuk()
    {
        $query = $this
            ->join('barang', 'barang.id_barang = barang_masuk.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier')
            ->findAll();

        return $query;
    }

    public function filter($tglawal, $tglakhir)
    {
        return $this->where('tgl_masuk >=', $tglawal)
            ->where('tgl_masuk <=', $tglakhir)
            ->join('barang', 'barang.id_barang = barang_masuk.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier')
            ->findAll();
    }
}
