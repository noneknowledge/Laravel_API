<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMember extends Model
{
    use HasFactory;
    protected $table="task_member";
    public $timestamps = false;

    public function member(){
        return $this->belongsTo(User::class,'leaderid','id');
    }

    public function task(){
        return $this->belongsTo(Task::class,'taskid','id');
    }

}
