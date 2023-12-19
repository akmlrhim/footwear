<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Dompdf\Dompdf;

class BarangMasuk extends BaseController
{

    protected $barangMasukModel;
    protected $barangModel;
    protected $supplierModel;

    public function __construct()
    {
        $this->barangMasukModel = new BarangMasukModel();
        $this->barangModel = new BarangModel();
        $this->supplierModel = new SupplierModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Data Barang Masuk',
            'masuk' => $this->barangMasukModel->getBarangMasuk()
        ];

        return view('barang_masuk/index', $data);
    }

    public function tambahBrgMasuk()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Form Tambah Barang Masuk',
            'barang' => $this->barangModel->getAllBarang(),
            'supplier' => $this->supplierModel->findAll(),
        ];

        return view('barang_masuk/tambah_brg_masuk', $data);
    }

    public function simpanBrgMasuk()
    {
        $validate = $this->validate([
            'id_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_supplier' => [
                'label' => 'Nama Supplier',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'jumlah_masuk' => [
                'label' => 'Jumlah Masuk',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'harga_satuan' => [
                'label' => 'Harga Satuan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],

            'tgl_masuk' => [
                'label' => 'Tanggal Masuk',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $barang = $this->barangModel->find($this->request->getVar('id_barang'));

            if ($barang) {
                $jumlahMasuk = $this->request->getVar('jumlah_masuk');
                $stokBaru = $barang['jumlah'] + $jumlahMasuk;

                $this->barangModel->update($this->request->getVar('id_barang'), ['jumlah' => $stokBaru]);

                $this->barangMasukModel->insert([
                    'id_barang' => esc($this->request->getVar('id_barang')),
                    'id_supplier' => esc($this->request->getVar('id_supplier')),
                    'jumlah_masuk' => esc($jumlahMasuk),
                    'harga_satuan' => esc($this->request->getVar('harga_satuan')),
                    'total_harga' => esc($this->request->getVar('total_harga')),
                    'tgl_masuk' => esc($this->request->getVar('tgl_masuk')),
                    'disimpan_oleh' => esc($this->request->getVar('disimpan_oleh'))
                ]);
                session()->setFlashdata('pesan', 'Data Berhasil Ditambah');
                return redirect()->to(base_url('barang_masuk'));
            }
        } else {
            return redirect()->back()
                ->with('errors', $this->validator->listErrors())
                ->withInput();
        }
    }

    public function hapusBrgMasuk($id)
    {
        $this->barangMasukModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to(base_url('barang_masuk'));
    }

    public function repMasuk()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Laporan Barang Masuk'
        ];

        return view('barang_masuk/rep-masuk', $data);
    }

    public function filterData()
    {
        $dompdf = new Dompdf();

        $tglawal = $this->request->getVar('tgl_awal');
        $tglakhir = $this->request->getVar('tgl_akhir');

        $data =  [
            'tgl_awal' => $tglawal,
            'tgl_akhir' => $tglakhir,
            'result' => $this->barangMasukModel->filter($tglawal, $tglakhir)
        ];

        $html = view('barang_masuk/filtered-data', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $filename = 'barang-masuk_' . date('YmdHis') . '.pdf';
        $dompdf->stream($filename);
    }
}
