<?php

namespace App\Models;

use CodeIgniter\Model;

class BankModel extends Model
{
    protected $table         = 'banks';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'bank_name', 'bank_code', 'logo', 'interest_rate_min',
        'interest_rate_max', 'processing_fee_percent', 'status',
    ];
    protected $useTimestamps = false;

    public function getActive(): array
    {
        return $this->where('status', 'active')->findAll();
    }
}
