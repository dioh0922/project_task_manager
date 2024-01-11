<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Reference;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function references(){
        return $this->hasMany(Reference::class);
    }
}
