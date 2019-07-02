<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = [
        "username", "password", "admin"
    ];

    public $incrementing = false;
    public $timestamps = false;
}