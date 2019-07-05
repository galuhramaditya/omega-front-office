<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = "pages";
    protected $fillable = [
        "name", "url"
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Role::class, "page_roles");
    }
}