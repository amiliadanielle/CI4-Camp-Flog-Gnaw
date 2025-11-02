<?php namespace App\Models;

use CodeIgniter\Model;

class SingerModel extends Model
{
    protected $table = 'singers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'genre', 'performance_date', 'bio', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
