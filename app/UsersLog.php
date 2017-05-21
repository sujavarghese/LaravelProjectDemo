<?php

/**
 * Created by PhpStorm.
 * User: Suja.Varghese
 * Date: 21/05/2017
 * Time: 10:29 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UsersLog extends Model
{
    use Notifiable;
    protected $table = 'users_log';
    public $timestamps = false;
}
