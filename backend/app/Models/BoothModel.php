<?php namespace App\Models;

use CodeIgniter\Model;

class BoothModel extends Model
{
    protected $table = 'booths';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'location', 'description', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
