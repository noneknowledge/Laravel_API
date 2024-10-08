<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    use HasFactory;
    protected $table="user_project";
    protected $fillable = ['userid', 'projectid','role'];
    public $timestamps = false;
    
    public function member(){
        return $this->belongsto(User::class,'userid');
    }
    
}
