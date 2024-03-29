<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    //既存のログインテーブルを使う
    protected $table = 'login';
    protected $primaryKey = 'userID';
    //remember_tokenはないためfalse
    protected $rememberTokenName = false;
    //主キーは文字列のためauto_incはfalse
    public $incrementing = false;

    public $timestamps = false;

    public function getAuthPassword(){
        return $this->pass;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userID',
        'pass'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pass',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pass' => 'hashed',
    ];
}
