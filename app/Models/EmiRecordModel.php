<?php

namespace App\Models;

use CodeIgniter\Model;

class EmiRecordModel extends Model
{
    protected $table         = 'emi_records';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'user_id', 'loan_application_id', 'principal', 'interest_rate',
        'tenure_months', 'emi_amount', 'total_interest', 'total_payment',
        'schedule_json',
    ];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}
