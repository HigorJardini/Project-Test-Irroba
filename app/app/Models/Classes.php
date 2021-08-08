<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    protected $fillable = [
                            'metter_id',
                            'user_id',
                            'name',
                            'description'
                          ];

    public $timestamps = true;

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function metters()
    {
        return $this->belongsTo(Metters::class, 'metter_id', 'id');
    }

    public function classes_solicitation()
    {
        return $this->hasMany(ClassesSolicitation::class, 'classe_id', 'id');
    }

}