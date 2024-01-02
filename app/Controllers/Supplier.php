<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;
use Hermawan\DataTables\DataTable;

class Supplier extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Footwear | Supplier',
            'judul' => 'Data Supplier',
            'supplier' => $this->supplierModel->findAll()
        ];

        return view('supplier/index', $data);
    }

    public function dataSupplier()
    {
        $db = db_connect();
        $builder = $db->table('supplier')->select('id_supplier, nama, kontak');

        return DataTable::of($builder)
            ->add('action', function ($row) {
                return '
                <a class="btn btn-warning btn-sm" href="' . base_url('supplier/edit/' . $row->id_supplier) . '"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_supplier . '">
                    <i class="fas fa-trash"></i>
                </button>';
            })
            ->addNumbering('no')
            ->toJson(true);
    }

    public function tambahSupplier()
    {
        $data = [
            'title' => 'Supplier',
            'judul' => 'Form Tambah Supplier'
        ];

        return view('supplier/tambah_supplier', $data);
    }

    public function simpanSupplier()
    {
        $validate = $this->validate([
            'nama' => [
                'label' => 'Nama Supplier',
                'rules' => 'required|is_unique[supplier.nama]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'is_unique' => 'Nama Supplier sudah Ada !!'
                ]
            ],
            'kontak' => [
                'label' => 'Kontak',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $this->supplierModel->insert([
                'nama' => $this->request->getVar('nama'),
                'kontak' => $this->request->getVar('kontak'),
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('supplier'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function editSupplier($id_supplier)
    {
        $data = [
            'title' => 'Footwears | Supplier',
            'judul' => 'Form Ubah Supplier',
            'supplier' => $this->supplierModel->getSupplier($id_supplier),
        ];

        return view('supplier/edit_supplier', $data);
    }

    public function updateSupplier($id_supplier)
    {
        $validate = $this->validate([
            'nama' => [
                'label' => 'Nama Supplier',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'kontak' => [
                'label' => 'Kontak',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $this->supplierModel->save([
                'id_supplier' => $id_supplier,
                'nama' => $this->request->getVar('nama'),
                'kontak' => $this->request->getVar('kontak'),
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('supplier'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function hapusSupplier($id_supplier)
    {
        $this->supplierModel->delete($id_supplier);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('supplier'));
    }
}
