<?php

namespace App\Models;

use CodeIgniter\Model;

class CountModel extends Model
{
    public function countBarang()
    {
        return $this->db->table('barang')->countAll();
    }

    public function countBarangAda()
    {
        return $this->db->table('barang')
            ->where(['jumlah >' => 0])
            ->countAllResults();
    }

    public function countBarangHabis()
    {
        return $this->db->table('barang')
            ->where(['jumlah =' => 0])
            ->countAllResults();
    }

    public function countKategori()
    {
        return $this->db->table('kategori')->countAll();
    }

    public function countSupplier()
    {
        return $this->db->table('supplier')->countAll();
    }

    public  function countUser()
    {
        return $this->db->table('users')->countAll();
    }

    public function countBarangMasuk()
    {
        return $this->db->table('barang_masuk')->countAll();
    }

    public function countBarangKeluar()
    {
        return $this->db->table('barang_keluar')->countAll();
    }
}
