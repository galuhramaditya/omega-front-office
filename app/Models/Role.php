<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
    protected $fillable = [
        "name", "level"
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, "page_roles");
    }
}