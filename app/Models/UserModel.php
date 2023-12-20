<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role'
    ];

    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id_user' => $id])->first();
    }

    public function getUserByUsername($username)
    {
        $query =  $this->where(['username' => $username])->first();
        return $query;
    }

    public function getUserByid($id)
    {
        return $this->where('id_user', $id)
            ->get()
            ->getRowArray();
    }

    public function updatePassword($id, $npass)
    {
        return $this->where('id_user', $id)
            ->set('password', $npass)
            ->update();
    }
}
