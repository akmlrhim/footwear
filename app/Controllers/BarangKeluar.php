<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\BarangModel;
use Dompdf\Dompdf;
use Hermawan\DataTables\DataTable;

class BarangKeluar extends BaseController
{
    protected $keluar;
    protected $barangModel;

    public function __construct()
    {
        $this->keluar = new BarangKeluarModel();
        $this->barangModel = new BarangModel();
    }

    //index owner
    public function index()
    {
        $data = [
            'title' => 'Footwear | Barang Keluar',
            'judul' => 'Data Barang Keluar',
            'keluar' => $this->keluar->getBrgKeluar()
        ];

        return view('barang_keluar/owner_index', $data);
    }

    //index karyawan
    public function indexs()
    {
        $data = [
            'title' => 'Footwear | Barang Keluar',
            'judul' => 'Data Barang Keluar',
            'keluar' => $this->keluar->getBrgKeluar()
        ];

        return view('barang_keluar/karyawan_index', $data);
    }

    //server side untuk tampil data role owner
    public function dataBrgKeluar_own()
    {
        $db = db_connect();
        $builder = $db->table('barang_keluar')
            ->select('id_brg_keluar, tgl_keluar, nama_barang, nama_kategori, jumlah_keluar, harga_satuan, total_harga, disimpan_oleh')
            ->join('barang', 'barang.id_barang = barang_keluar.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori');
        return DataTable::of($builder)
            ->add('tgl_keluar', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_keluar));
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
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_brg_keluar . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    //server side untuk tampil data role karyawan
    public function dataBrgKeluar_krw()
    {
        $db = db_connect();
        $builder = $db->table('barang_keluar')
            ->select('id_brg_keluar, tgl_keluar, nama_barang, nama_kategori, jumlah_keluar, harga_satuan, total_harga')
            ->join('barang', 'barang.id_barang = barang_keluar.id_barang')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori');

        return DataTable::of($builder)
            ->add('tgl_keluar', function ($row) {
                return date('d/m/Y', strtotime($row->tgl_keluar));
            })

            ->add('harga_satuan', function ($row) {
                return 'Rp. ' . number_format($row->harga_satuan, 0, ',', '.');
            })

            ->add('total_harga', function ($row) {
                return 'Rp. ' . number_format($row->total_harga, 0, ',', '.');
            })

            ->add('action', function ($row) {
                return '
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_brg_keluar . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }


    public function tambahBrgKeluar()
    {
        $data = [
            'title' => 'Footwear | Barang Keluar',
            'judul' => 'Form Tambah Barang Keluar',
            'barang' => $this->barangModel->getBarangAda()
        ];

        return view('barang_keluar/tambah_brg_keluar', $data);
    }

    public function simpanBrgKeluar()
    {
        $validate = $this->validate([
            'id_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'jumlah_keluar' => [
                'label' => 'Jumlah Keluar',
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

            'tgl_keluar' => [
                'label' => 'Tanggal Keluar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $barang = $this->barangModel->find($this->request->getVar('id_barang'));
            if ($barang) {
                $jumlahKeluar = $this->request->getVar('jumlah_keluar');

                if ($jumlahKeluar > $barang['jumlah']) {
                    return redirect()->back()
                        ->with('errors', 'Jumlah keluar melebihi stok barang.')
                        ->withInput();
                }
                $stokBaru = $barang['jumlah'] - $jumlahKeluar;
                $this->barangModel->update($this->request->getVar('id_barang'), ['jumlah' => $stokBaru]);
                $this->keluar->insert([
                    'id_barang' => $this->request->getVar('id_barang'),
                    'jumlah_keluar' => $jumlahKeluar,
                    'harga_satuan' => $this->request->getVar('harga_satuan'),
                    'total_harga' => $this->request->getVar('total_harga'),
                    'tgl_keluar' => $this->request->getVar('tgl_keluar'),
                    'disimpan_oleh' => $this->request->getVar('disimpan_oleh')
                ]);

                session()->setFlashdata('pesan', 'Data Berhasil Ditambah');
                return redirect()->to(base_url('barang_keluar'));
            }
        } else {
            return redirect()->back()->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusBrgKeluar($id)
    {
        $this->keluar->delete($id);
        return redirect()->to(base_url('barang_keluar'))
            ->with('pesan', 'Data berhasil dihapus');
    }

    public function repKeluar()
    {
        $data = [
            'title' => 'Footwears | Barang Keluar',
            'judul' => 'Laporan Barang Keluar'
        ];

        return view('barang_keluar/rep-keluar', $data);
    }

    public function filterData()
    {
        $dompdf = new Dompdf();
        $tglawal = $this->request->getVar('tgl_awal');
        $tglakhir = $this->request->getVar('tgl_akhir');

        $data =  [
            'tgl_awal' => $tglawal,
            'tgl_akhir' => $tglakhir,
            'result' => $this->keluar->filter($tglawal, $tglakhir)
        ];

        if (!empty($data['result'])) {
            $html = view('barang_keluar/filtered-data', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            $filename = 'barang-keluar' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => 0]);
            exit();
        } else {
            return redirect()->to(base_url('barang_keluar/rep-barang-keluar'))
                ->with('error', 'Tidak ada data yang terfilter');
        }
    }
}
