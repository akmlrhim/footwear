<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Account extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Footwears',
            'judul' => 'Ubah Password'
        ];

        return view('account/ubah_password', $data);
    }

    public function ubahPassword()
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
                'rules' => 'required|min_length[8]',
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

    public function forgotPassword()
    {
        $data = [
            'title' => 'Footwears',
            'judul' => 'Reset Password'
        ];

        return view('account/forgot-password', $data);
    }

    public function resetPassword()
    {
        $email = \Config\Services::email();

        $validate = $this->validate([]);;
    }
}
