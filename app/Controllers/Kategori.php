<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use org\bovigo\vfs\Issue104TestCase;

class Kategori extends BaseController
{

    protected $kategoriModel;
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data  = [
            'title' => 'Footwears | Kategori',
            'judul' => 'Data Kategori',
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('kategori/index', $data);
    }

    public function tambahKategori()
    {
        $data  = [
            'title' => 'Kategori',
            'judul' => 'Form Tambah Kategori',
        ];

        return view('kategori/tambah_kategori', $data);
    }

    public function simpanKategori()
    {
        $validate = $this->validate([
            'nama_kategori' => [
                'label' => 'Nama Kategori',
                'rules' => 'required|is_unique[kategori.nama_kategori]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'is_unique' => 'Data sudah ada !!!'
                ]
            ]
        ]);

        if ($validate) {
            $this->kategoriModel->insert([
                'nama_kategori' => esc($this->request->getVar('nama_kategori'))
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('kategori'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function editKategori($id_kategori)
    {
        $data  = [
            'title' => 'Kategori',
            'judul' => 'Form Ubah Kategori',
            'kategori' => $this->kategoriModel->getKategori($id_kategori),
        ];

        return view('kategori/edit_kategori', $data);
    }

    public function updateKategori($id_kategori)
    {
        $validate = $this->validate([
            'nama_kategori' => [
                'label' => 'Nama Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ]
        ]);

        if ($validate) {
            $this->kategoriModel->save([
                'id_kategori' => $id_kategori,
                'nama_kategori' => esc($this->request->getVar('nama_kategori'))
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('kategori'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function hapusKategori($id_kategori)
    {
        $this->kategoriModel->delete($id_kategori);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('kategori');
    }
}
