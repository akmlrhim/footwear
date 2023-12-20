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

            $nama_lengkap = esc($this->request->getPost('nama_lengkap'));
            $username = esc($this->request->getPost('username'));
            $password = esc($this->request->getPost('password'));
            $role = esc($this->request->getPost('role'));

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
            'usr' => $this->userModel->getUser($id_user)
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
            $role = esc($this->request->getPost('role'));

            $data = [
                'id_user' => $id_user,
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
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

    public function ubahPassword()
    {
        $data = [
            'title' => 'Footwears',
            'judul' => 'Ubah Password'
        ];

        return view('user/ubah_password', $data);
    }

    public function updatePassword()
    {
        $loggedInUserId = session()->get('id_user');

        $validate = $this->validate([
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                ]
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[\w\d\W]{8,}$/]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'min_length' => '{field} minimal 8 karakter.',
                ]
            ],
            're_password' => [
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'required|matches[password_baru]',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                    'matches' => 'Konfirmasi password tidak sesuai dengan password baru.',
                ]
            ]
        ]);

        if ($validate) {
            $currentPassword = esc($this->request->getPost('password_lama'));
            $newPassword = esc($this->request->getPost('password_baru'));

            $user = $this->userModel->getUserByid($loggedInUserId);

            if ($user && password_verify("$currentPassword", $user['password'])) {
                $hashedPassword = password_hash("$newPassword", PASSWORD_DEFAULT);

                // Update password dalam database
                $this->userModel->updatePassword($loggedInUserId, $hashedPassword);

                return redirect()->back()->with('pesan', 'Password berhasil diperbarui.');
            } else {
                return redirect()->back()->with('passlama', 'Password lama salah.')->withInput();
            }
        } else {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }
    }
}
