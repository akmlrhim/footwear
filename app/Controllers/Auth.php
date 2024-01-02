<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use ReCaptcha\ReCaptcha;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index() //untuk halaman login
    {
        return view('auth/form_login');
    }

    public function login() //untuk proses login
    {
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');

        $recaptcha = new Recaptcha('6LespSApAAAAAM2OPYhvVgy_yszkXbrFEa-4Oi--');
        $result = $recaptcha->verify($recaptchaResponse);

        if (!$result->isSuccess()) {
            session()->setFlashdata('pesan', 'Validasi reCAPTCHA gagal. Harap coba lagi.');
            return redirect()->to(base_url('/'))->withInput();
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        $validate = $this->validate([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong.'
                ]
            ]
        ]);
        if ($validate) {
            if ($user && password_verify("$password", $user['password'])) {
                session()->set('isLogin', true);
                session()->set('id_user', $user['id_user']);
                session()->set('nama_lengkap', $user['nama_lengkap']);
                session()->set('username', $user['username']);
                session()->set('password', $user['password']);
                session()->set('role', $user['role']);
                return redirect()->to(base_url('dashboard'));
            } else {
                session()->setFlashdata('pesan', 'Username atau password salah.');
                return redirect()->to(base_url('/'))->withInput();
            }
        } else {
            return redirect()->back()->withInput()->with('pesan', 'Username dan Password Tidak Boleh Kosong');
        }
    }

    public function logout() //untuk proses logout
    {
        session()->remove('isLogin');
        session()->remove('id_user');
        session()->remove('nama_lengkap');
        session()->remove('username');
        session()->remove('password');
        session()->remove('role');

        return redirect()->to(base_url('/'))->with('pesan', 'Anda Telah Logout');
    }
}
