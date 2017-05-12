<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boundaries extends Model
# Model class to store uploaded boundary details
{
    //
    protected $table = 'boundaries';
    protected $fillable = ['boundary_type','boundary_name'];
}
