<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFriend extends Model
{
    use HasFactory;
    protected $table = 'user_friend';

    protected $fillable = [
        'user1id',
        'user2id',
        'status1',
        'status2',
    ];
    public $timestamps = false;
}
