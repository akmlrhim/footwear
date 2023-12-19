<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {

        $user = $this->userModel->findAll();

        $data = [
            'title' => 'Footwears | User',
            'judul' => 'Data User',
            'user' => $user
        ];

        return view('user/index', $data);
    }

    public function tambahUser()
    {
        $data = [
            'title' => 'Footwears | User',
            'judul' => 'Form Tambah User'
        ];

        return view('user/tambah_user', $data);
    }

    public function simpanUser()
    {

        if ($this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'is_unique' => '{field} Sudah Terdaftar.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[\w\d\W]{8,}$/]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'min_length' => 'Password harus memuat minimal 8 karakter.',
                    'regex_match' => 'Password harus berisi minimal satu angka, satu huruf besar, satu huruf kecil, dan satu karakter khusus'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ])) {

            $nama_lengkap = $this->request->getPost('nama_lengkap');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');

            $password = password_hash("$password", PASSWORD_BCRYPT);

            $data = [
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'password' => $password,
                'role' => $role
            ];

            $this->userModel->insert($data);
            session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
            return redirect()->to(base_url('/user'));
        } else {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
    }

    public function editUser($id_user)
    {
        $data = [
            'title' => 'Footwears | User',
            'judul' => 'Form Ubah User',
            'usr' => $this->userModel->findUser($id_user)
        ];

        return view('user/edit_user', $data);
    }

    public function updateUser($id_user)
    {
        $validate = $this->validate([
            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'is_unique' => '{field} Sudah Terdaftar.'
                ]
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'is_unique' => '{field} Sudah Terdaftar.'
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ]);

        if ($validate) {
            $nama_lengkap = esc($this->request->getPost('nama_lengkap'));
            $username = esc($this->request->getPost('username'));
            $email = esc($this->request->getPost('email'));
            $role = esc($this->request->getPost('role'));

            $data = [
                'id_user' => $id_user,
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'email' => $email,
                'role' => $role
            ];
            $this->userModel->save($data);
            return redirect()->to(base_url('user'))->with('pesan', 'Data Berhasil Diubah');
        } else {
            return redirect()->back()->with('errors', $this->validator->listErrors());
        }
    }

    public function hapusUser($id_user)
    {
        $this->userModel->delete($id_user);
        return redirect()->back()->with('pesan', 'Data Berhasil Dihapus');
    }
}
