<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessageModel extends Model
{
    protected $table         = 'contact_messages';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'email', 'phone', 'subject', 'message', 'is_read'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules = [
        'name'    => 'required|min_length[3]',
        'email'   => 'required|valid_email',
        'message' => 'required|min_length[10]',
    ];
}
