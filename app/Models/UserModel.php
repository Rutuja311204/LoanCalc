<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'full_name', 'email', 'phone', 'password', 'role', 'address',
        'dob', 'profile_image', 'reset_token', 'reset_expires', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'full_name' => 'required|min_length[3]|max_length[150]',
        'email'     => 'required|valid_email',
        'phone'     => 'permit_empty|min_length[10]|max_length[15]',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required' => 'Please enter your full name.',
        ],
        'email' => [
            'required'    => 'Please enter your email address.',
            'valid_email' => 'Please enter a valid email address.',
        ],
    ];

    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
