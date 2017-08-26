<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    public $table = "users";

    public function group() {
        return $this->hasMany('App\Group');
    }
}
