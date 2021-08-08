<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metters extends Model
{
    protected $fillable = [
                            'name'
                          ];

    public $timestamps = true;

    use SoftDeletes;

}