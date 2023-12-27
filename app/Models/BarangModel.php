<?php

namespace App\Models;

use CodeIgniter\Model;
use PDO;

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

    public function getBarang($id = false)
    {
        if ($id == false) {
            return $this->join('kategori', 'kategori.id_kategori = barang.id_kategori')
                ->findAll();
        }

        return $this->where(['id_barang' => $id])
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->first();
    }

    public function getBarangAda()
    {
        return $this->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->where(['jumlah >' => 0])
            ->findAll();
    }

    public function getBarangHabis()
    {
        return $this->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->where(['jumlah =' => 0])
            ->findAll();
    }
    public function cekDuplikat($nama_barang, $id_kategori, $id_barang = null)
    {
        $this->where('nama_barang', $nama_barang)
            ->where('id_kategori', $id_kategori);

        if ($id_barang !== NULL) {
            $this->where('id_barang !=', $id_barang);
        }

        $result = $this->get()->getRow();
        return ($result !== null) ? true : false;
    }
}
