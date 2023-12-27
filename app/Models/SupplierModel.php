<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'supplier';
    protected $primaryKey       = 'id_supplier';
    protected $allowedFields    = [
        'nama',
        'kontak'
    ];

    public function getSupplier($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id_supplier' => $id])->first();
    }
}
