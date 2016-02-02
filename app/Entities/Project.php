<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use CodeProject\Entities\User;

class Project extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'project';
    protected $fillable = [ 
    	'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date'];

    public function notes()
    {
        return $this->hasMany(ProjectNote::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'project_members','project_id','member_id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

}
