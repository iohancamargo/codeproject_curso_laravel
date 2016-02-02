<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use CodeProject\Entities\User;

class ProjectFile extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [ 
    	'name',
        'description',
        'extension',
    ];

    public function members()
    {
        return $this->belongsToMany(Project::class);
    }

}
