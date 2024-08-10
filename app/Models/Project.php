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


}
