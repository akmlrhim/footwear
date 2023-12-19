<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id_barang';
    protected $allowedFields    = [
        'nama_barang',
        'id_kategori',
        'gambar',
        'ukuran',
        'warna',
        'jumlah',
        'deskripsi'
    ];

    public function getBarang($id_barang = false)
    {
        if ($id_barang == false) {
            return $this->join('kategori', 'kategori.id_kategori = barang.id_kategori')
                ->where(['jumlah >' => 0])
                ->findAll();
        }

        return $this->where(['id_barang' => $id_barang])
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->first();
    }

    public function getAllBarang()
    {
        return $this->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->findAll();
    }

    public function getBarangHabis()
    {
        $query = $this->where(['jumlah =' =>  0])
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->findAll();
        return $query;
    }
}
