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

    public function getSupplier($id_supplier = false)
    {
        if ($id_supplier == false) {
            $query = $this->findAll();
        }
        $query = $this->where(['id_supplier' => $id_supplier])->first();
        return $query;
    }
}
