<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangMasukModel;
use App\Models\BarangModel;
use App\Models\SupplierModel;
use Dompdf\Dompdf;
use Hermawan\DataTables\DataTable;

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

    //owner index
    public function index()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Data Barang Masuk',
            'masuk' => $this->barangMasukModel->getBarangMasuk()
        ];

        return view('barang_masuk/owner_index', $data);
    }

    //karyawan index
    public function indexs()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Data Barang Masuk',
            'masuk' => $this->barangMasukModel->getBarangMasuk()
        ];

        return view('barang_masuk/karyawan_index', $data);
    }

    //server side untuk tampil data role owner
    public function dataBrgMasuk_own()
    {
        $db = db_connect();
        $builder = $db->table('barang_masuk')
            ->select('id_brg_masuk, tgl_masuk, nama_barang, nama_kategori, jumlah_masuk, harga_satuan, total_harga, nama, disimpan_oleh')
            ->join('barang', 'barang.id_barang = barang_masuk.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier');

        return DataTable::of($builder)
            ->add('tgl_masuk', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_masuk));
            })

            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })

            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })

            ->add('disimpan_oleh', function ($row) {
                return '<small class="badge badge-danger">' . esc($row->disimpan_oleh) . '</small>';
            })

            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_brg_masuk . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    //server side untuk tampil data role karyawan
    public function dataBrgMasuk_krw()
    {
        $db = db_connect();
        $builder = $db->table('barang_masuk')
            ->select('id_brg_masuk, tgl_masuk, nama_barang, nama_kategori, jumlah_masuk, harga_satuan, total_harga, nama')
            ->join('barang', 'barang.id_barang = barang_masuk.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori')
            ->join('supplier', 'supplier.id_supplier = barang_masuk.id_supplier');

        return DataTable::of($builder)
            ->add('tgl_masuk', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_masuk));
            })

            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })

            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })

            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_brg_masuk . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    public function tambahBrgMasuk()
    {
        $data = [
            'title' => 'Footwears | Barang Masuk',
            'judul' => 'Form Tambah Barang Masuk',
            'barang' => $this->barangModel->getBarang(),
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
                    'id_barang' => $this->request->getVar('id_barang'),
                    'id_supplier' => $this->request->getVar('id_supplier'),
                    'jumlah_masuk' => $jumlahMasuk,
                    'harga_satuan' => $this->request->getVar('harga_satuan'),
                    'total_harga' => $this->request->getVar('total_harga'),
                    'tgl_masuk' => $this->request->getVar('tgl_masuk'),
                    'disimpan_oleh' => $this->request->getVar('disimpan_oleh')
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

        if (!empty($data['result'])) {
            $html = view('barang_masuk/filtered-data', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->render();
            $filename = 'barang-masuk_' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => 0]); //eksekusi 
        } else {
            return redirect()->to(base_url('barang_masuk/rep-barang-masuk'))
                ->with('error', 'Tidak ada data yang terfilter');
        }
    }
}
