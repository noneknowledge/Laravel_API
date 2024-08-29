<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        
        'title',
        'thumbnail',
        'total',
        'leaderId',
    ];
    

    public $timestamps = false;

    public function members(){
        return $this->hasMany(UserProject::class,'projectid');
    }
    public function leader(){
        return $this->belongsTo(User::class,'leaderid','id');
    }
    public function columns(){
        return $this->hasMany(Container::class,'projectid');
    }

      // this is a recommended way to declare event handlers
      protected static function booted () {
        static::deleting(function(Project $project) { // before delete() method call this
            $project->columns()->delete();
            $project->members()->delete();
        });
    }


}
