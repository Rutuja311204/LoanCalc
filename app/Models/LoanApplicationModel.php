<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanApplicationModel extends Model
{
    protected $table         = 'loan_applications';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'application_no', 'user_id', 'loan_type_id', 'bank_id', 'loan_amount',
        'tenure_months', 'interest_rate', 'monthly_income', 'employment_type',
        'purpose', 'emi_amount', 'total_payable', 'total_interest',
        'documents', 'current_status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'loan_type_id' => 'required|integer',
        'bank_id'      => 'required|integer',
        'loan_amount'  => 'required|numeric|greater_than[0]',
        'tenure_months'=> 'required|integer|greater_than[0]',
    ];

    public function forUser(int $userId): array
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    public function withRelations(int $id): ?array
    {
        return $this->select('loan_applications.*, loan_types.name as loan_type_name, banks.bank_name, users.full_name, users.email')
            ->join('loan_types', 'loan_types.id = loan_applications.loan_type_id')
            ->join('banks', 'banks.id = loan_applications.bank_id')
            ->join('users', 'users.id = loan_applications.user_id')
            ->where('loan_applications.id', $id)
            ->first();
    }

    public function allWithRelations(): array
    {
        return $this->select('loan_applications.*, loan_types.name as loan_type_name, banks.bank_name, users.full_name, users.email')
            ->join('loan_types', 'loan_types.id = loan_applications.loan_type_id')
            ->join('banks', 'banks.id = loan_applications.bank_id')
            ->join('users', 'users.id = loan_applications.user_id')
            ->orderBy('loan_applications.created_at', 'DESC')
            ->findAll();
    }
}
