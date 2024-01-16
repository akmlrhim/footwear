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
    }

    public function create()
    {
        // $data = [
        //     'nama_lengkap' => $this->request->getVar('nama_lengkap'),
        //     'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
        //     'alamat'       => $this->request->getVar('alamat')
        // ];

        $data = esc($this->request->getPost());

        // $this->pegawai->save($data);

        if (!$this->pegawai->save($data)) {
            return $this->fail($this->pegawai->errors());
        }
        $response = [
            'status' => 201,
            'error' => NULL,
            'messages' => 'sukses'
        ];

        return $this->respond($response);
    }
}
