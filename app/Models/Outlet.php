<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = "outlet_mstr";
    public $incrementing = false;
}