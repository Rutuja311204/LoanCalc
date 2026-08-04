<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailLogModel extends Model
{
    protected $table         = 'email_logs';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['to_email', 'subject', 'body', 'status', 'related_type', 'related_id'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}
