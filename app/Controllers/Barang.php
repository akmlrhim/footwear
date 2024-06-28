<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Controllers\BaseController;
use App\Models\KategoriModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Hermawan\DataTables\DataTable;

class Barang extends BaseController
{
    protected $barangModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Footwears | Barang',
            'judul' => 'Data Barang',
            'barang' => $this->barangModel->getBarang(),
        ];
        return view('barang/index', $data);
    }

    public function dataBarang()
    {
        $db = db_connect();
        $builder = $db->table('barang')
            ->select('id_barang, nama_barang, nama_kategori, ukuran, warna, jumlah')
            ->join('kategori', 'kategori.id_kategori = barang.id_kategori');

        return DataTable::of($builder)
            ->add('status', function ($row) {
                if ($row->jumlah == 0) {
                    return '<small class="badge badge-danger"> Habis</small>';
                } else {
                    return '<small class="badge badge-success"> Masih Ada</small>';
                }
            })
            ->add('action', function ($row) {
                return '
                <a class="btn btn-success btn-sm" href="' . base_url('barang/detail/' . $row->id_barang) . '"><i class="fas fa-eye"></i></a>
                <a class="btn btn-warning btn-sm" href="' . base_url('barang/edit/' . $row->id_barang) . '"><i class="fas fa-edit"></i></a>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal' . $row->id_barang . '">
                    <i class="fas fa-trash"></i> 
                </button>';
            })
            ->toJson(true);
    }

    public function detailBarang($id)
    {
        $data = [
            'title' => 'Barang',
            'judul' => 'Detail Barang',
            'barang' => $this->barangModel->getBarang($id)
        ];

        if (empty($data['barang'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan id : ' . $id .  ' Tidak Ditemukan');
        }

        return view('barang/detail_barang', $data);
    }

    public function tambahBarang()
    {
        $data  = [
            'title' => 'Barang',
            'judul' => 'Form Tambah Barang',
            'kategori' => $this->kategoriModel->findAll(),
        ];

        return view('barang/tambah_barang', $data);
    }
    public function simpanBarang()
    {

        $nama_barang = esc($this->request->getVar('nama_barang'));
        $id_kategori = $this->request->getVar('id_kategori');

        if ($this->barangModel->cekDuplikat($nama_barang, $id_kategori)) {
            return redirect()->back()->with('dupl', 'Sepatu dengan kategori yang sama sudah terdaftar.');
        }
        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);

        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');
            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                if ($file_gambar->isValid()) {
                    $nama_gambar = $file_gambar->getRandomName();
                    $file_gambar->move('img_data', $nama_gambar);
                } else {
                    return redirect()->back()->with('errors', $this->validator->listErrors());
                }
            }
            $this->barangModel->insert([
                'nama_barang' => esc($this->request->getVar('nama_barang')),
                'id_kategori' => $this->request->getVar('id_kategori'),
                'gambar' => $nama_gambar,
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);

            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('barang'));
        } else {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusBarang($id)
    {
        $barang = $this->barangModel->find($id);

        if ($barang['gambar'] != 'default_image.jpg') {
            unlink('img_data/' . $barang['gambar']);
        }

        $this->barangModel->delete($id);
        return redirect()->to(base_url('barang'))->with('pesan', 'Data Berhasil Dihapus');
    }

    public function editBarang($id)
    {
        $data = [
            'title' => 'Barang',
            'judul' => 'Form Ubah Barang',
            'barang' => $this->barangModel->getBarang($id),
            'kategori' => $this->kategoriModel->findAll(),
        ];
        return view('barang/edit_barang', $data);
    }

    public function updateBarang($id)
    {
        $validate = $this->validate([
            'nama_barang' => [
                'label' => 'Nama Barang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                ]
            ],
            'id_kategori' => [
                'label' => 'Kategori',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'gambar' => [
                'label' => 'Gambar',
                'rules' => 'is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar !!!',
                    'is_image' => 'File yang diupload bukan gambar !!!',
                    'mime_in' => 'File yang diupload harus berformat (JPG/JPEG/PNG)'
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'ukuran' => [
                'label' => 'Ukuran',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'jumlah' => [
                'label' => 'Jumlah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
        ]);
        if ($validate) {
            $file_gambar = $this->request->getFile('gambar');
            if ($file_gambar->getError() == 4) {
                $nama_gambar = 'default_image.jpg';
            } else {
                $nama_gambar = $file_gambar->getRandomName();
                $file_gambar->move('img_data', $nama_gambar);
            }
            $this->barangModel->save([
                'id_barang' => $id,
                'nama_barang' => esc($this->request->getVar('nama_barang')),
                'id_kategori' => $this->request->getVar('id_kategori'),
                'gambar' => $nama_gambar,
                'ukuran' => esc($this->request->getVar('ukuran')),
                'warna' => esc($this->request->getVar('warna')),
                'jumlah' => esc($this->request->getVar('jumlah')),
                'deskripsi' => esc($this->request->getVar('deskripsi')),
            ]);
            session()->setFlashdata('pesan', 'Data Berhasil Diubah');
            return redirect()->to(base_url('barang'));
        } else {
            session()->setFlashdata('errors', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function cetakBarangHabis()
    {
        $options = new Options();
        $options->set('enabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $data['habis'] =  $this->barangModel->getBarangHabis();
        if (!empty($data['habis'])) {
            $html = view('barang/rep-barang-habis', $data);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'potrait');
            $dompdf->render();
            $filename = 'barang-habis_' . date('YmdHis') . '.pdf';
            $dompdf->stream($filename);
        } else {
            return redirect()->back()->with('empty', 'Tidak ada barang habis');
        }
    }
}
