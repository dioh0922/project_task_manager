<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'source'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
