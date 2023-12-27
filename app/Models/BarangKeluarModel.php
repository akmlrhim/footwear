<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang_keluar';
    protected $primaryKey       = 'id_brg_keluar';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_barang',
        'jumlah_keluar',
        'harga_satuan',
        'total_harga',
        'tgl_keluar',
        'disimpan_oleh'
    ];

    public function getBrgKeluar()
    {
        return $this
            ->join('barang', 'barang.id_barang = barang_keluar.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->findAll();
    }

    public function filter($tglawal, $tglakhir)
    {
        return $this->where('tgl_keluar >=', $tglawal)
            ->where('tgl_keluar <=', $tglakhir)
            ->join('barang', 'barang.id_barang = barang_keluar.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->findAll();
    }
}
