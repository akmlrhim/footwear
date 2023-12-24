<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\BarangModel;
use Dompdf\Dompdf;

class BarangKeluar extends BaseController
{
    protected $keluar;
    protected $barangModel;

    public function __construct()
    {
        $this->keluar = new BarangKeluarModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Footwear | Barang Keluar',
            'judul' => 'Data Barang Keluar',
            'keluar' => $this->keluar->getBrgKeluar()
        ];

        return view('barang_keluar/index', $data);
    }

    public function tambahBrgKeluar()
    {
        $data = [
            'title' => 'Footwear | Barang Keluar',
            'judul' => 'Data Barang Keluar',
            'barang' => $this->barangModel->getBarang()
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
                    'id_barang' => esc($this->request->getVar('id_barang')),
                    'jumlah_keluar' => esc($jumlahKeluar),
                    'harga_satuan' => esc($this->request->getVar('harga_satuan')),
                    'total_harga' => esc($this->request->getVar('total_harga')),
                    'tgl_keluar' => esc($this->request->getVar('tgl_keluar')),
                    'disimpan_oleh' => esc($this->request->getVar('disimpan_oleh'))
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

        $html = view('barang_keluar/filtered-data', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $filename = 'barang-keluar' . date('YmdHis') . '.pdf';
        $dompdf->stream($filename);
    }
}
