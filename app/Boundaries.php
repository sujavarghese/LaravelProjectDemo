<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boundaries extends Model
{
    //
    protected $table = 'boundaries';
    protected $fillable = ['boundary_type','boundary_name'];
}
