<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;
    protected $table="containers";
    public $timestamps = false;
    
    public function tasks(){
        return $this->hasMany(Task::class,'containerid');
    }
    
}

