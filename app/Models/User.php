<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = [
        "username", "password", "role_id"
    ];
    protected $hidden = [
        "password", "role_id"
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}