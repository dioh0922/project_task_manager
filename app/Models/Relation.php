<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;
    
    // 別々のIDでリレーションする
    public function parent()
    {
        return $this->belongsTo(Task::class, 'base_task_id');
    }

    public function child()
    {
        return $this->belongsTo(Task::class, 'child_task_id');
    }
}
