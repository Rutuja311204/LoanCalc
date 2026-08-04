<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table         = 'notifications';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'title', 'message', 'type', 'is_read'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    public function forUser(int $userId, int $limit = 10): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    public function unreadCount(int $userId): int
    {
        return $this->where('user_id', $userId)->where('is_read', 0)->countAllResults();
    }
}
