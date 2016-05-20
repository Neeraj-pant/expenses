<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReference extends Model
{
    protected $fillable = [ 'user_id' ];

    protected $table = 'user_references';
}
