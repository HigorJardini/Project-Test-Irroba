<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassesSolicitation extends Model
{
    protected $fillable = [
                            'class_id',
                            'user_id',
                            'accept',
                            'reason',
                            'canceled',
                            'accepted_at',
                            'canceled_at'
                          ];

    public $timestamps = true;

    protected $table = 'classes_solicitation';

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'id', 'class_id');
    }

}