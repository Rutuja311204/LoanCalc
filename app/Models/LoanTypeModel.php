<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanTypeModel extends Model
{
    protected $table         = 'loan_types';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'name', 'slug', 'description', 'min_amount', 'max_amount',
        'min_tenure_months', 'max_tenure_months', 'base_interest_rate',
        'icon', 'status',
    ];
    protected $useTimestamps = false;

    public function getActive(): array
    {
        return $this->where('status', 'active')->findAll();
    }
}
