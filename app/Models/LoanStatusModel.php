<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanStatusModel extends Model
{
    protected $table         = 'loan_status';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['loan_application_id', 'status', 'remarks', 'updated_by'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    public function historyFor(int $applicationId): array
    {
        return $this->where('loan_application_id', $applicationId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }
}
