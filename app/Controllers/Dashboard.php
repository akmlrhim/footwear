<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CountModel;

class Dashboard extends BaseController
{
    protected $countModel;

    public function __construct()
    {
        $this->countModel = new CountModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard | Footwears',
            'judul' => 'Dashboard',
            'countBarang' => $this->countModel->countBarang(),
            'countBarangAda' => $this->countModel->countBarangAda(),
            'countBarangHabis' => $this->countModel->countBarangHabis(),
            'countKategori' => $this->countModel->countKategori(),
            'countSupplier' => $this->countModel->countSupplier(),
            'countUser' => $this->countModel->countUser(),
            'countBarangMasuk' => $this->countModel->countBarangMasuk(),
            'countBarangKeluar' => $this->countModel->countBarangKeluar()
        ];

        return view('dashboard/index', $data);
    }
}
