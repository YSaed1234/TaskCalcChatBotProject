<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserLog extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'user_log';
    protected $guarded = ['id'];

    const Log_User_Id = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class, self::Log_User_Id);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'tag',
        'action',
        'message',
        'user_id',
    ];

}
