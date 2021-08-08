<?php

namespace App\Repositories\Api;

use App\Models\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Laratrust;

class ClassesRepository
{

    private $classes;

    public function __construct(
                                   Classes $classes
                               )
    {
        $this->classes = $classes;
    }

    public function classes()
    {
        try {

            if(Laratrust::isAbleTo('read-all-classes'))
                return $this->classes->with(['user','metters', 'classes_solicitation'])
                                     ->get()
                                     ->toArray();
            else
                return $this->classes->with(['user','metters', 'classes_solicitation'])
                                     ->where('user_id', Auth::id())
                                     ->get()
                                     ->toArray();

            

        } catch (\Throwable $th) {
            return null;
        }
        
    }
    
}
