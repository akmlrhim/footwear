<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use CodeIgniter\API\ResponseTrait;

class Pegawai extends BaseController
{
    use ResponseTrait;
    protected $pegawai;

    public function __construct()
    {
        $this->pegawai = new PegawaiModel();
    }

    public function index()
    {
        $data = $this->pegawai->orderBy('nama_lengkap', 'asc')->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8100');
        $data = $this->pegawai->where('id_pegawai', $id)->findAll();

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function create()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8100');

        $data = esc($this->request->getPost());

        $this->pegawai->insert($data);

        $response = [
            'status' => 201,
            'error' => NULL,
            'messages' => 'sukses'
        ];

        return $this->respond($response);
    }

    public function update($id = null)
    {

        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8100');

        $data = $this->request->getRawInput();
        $data['id_pegawai'] = $id;

        $isTrue = $this->pegawai->where('id_pegawai', $id)->findAll();

        if (!$isTrue) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        if (!$this->pegawai->save($data)) {
            return $this->respond($data);
        }

        $response = [
            'status' => 200,
            'error' => null,
            'messages' => "sukses diupdate"
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $this->response->setHeader('Access-Control-Allow-Origin', 'http://localhost:8100/$id');

        $data = $this->pegawai->where('id_pegawai', $id);

        if ($data) {
            $this->pegawai->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => 'Data berhasil dihapus',
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
