<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;
    protected $table="containers";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'projectid'
    ];
    
    public function tasks(){
        return $this->hasMany(Task::class,'containerid');
    }
    
    // protected static function booted () {
    //     static::deleting(function(Container $column) { 
    //         foreach($column->tasks() as $task){
    //             $task->members()->delete();
    //         }
    //         $column->tasks()->delete();
    //     });
    // }
  
    
}

