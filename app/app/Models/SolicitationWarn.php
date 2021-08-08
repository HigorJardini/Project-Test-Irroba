<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitationWarn extends Model
{
    protected $fillable = [
                            'classe_solicitation_id',
                            'warned',
                            'warned_at'
                          ];

    public $timestamps = true;

    protected $table = 'solicitation_warn';

    use SoftDeletes;

    public function classes_solicitation()
    {
        return $this->belongsTo(ClassesSolicitation::class, 'classe_solicitation_id', 'id');
    }

}