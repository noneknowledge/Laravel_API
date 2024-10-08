<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table="tasks";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'tag',
        'priority',
        'containerid',
        'arrange'
    ];

    public function members(){
        return $this->hasMany(TaskMember::class,'taskid');
    }
   
}
