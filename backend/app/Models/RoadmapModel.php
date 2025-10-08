<?php

namespace App\Models;

use CodeIgniter\Model;

class RoadmapModel extends Model
{
    protected $table = 'roadmap_tasks';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'description',
        'priority',
        'status'
    ];
}