<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

use App\Services\Api\ClassesService;

class ClassesController extends Controller
{

    private $classesService;

    public function __construct(
                                 ClassesService $classesService
                               )
    {
        $this->classesService = $classesService;
    }

    public function classes()
    {
        $classes = $this->classesService->classes();
        return response()->json($classes['return'], $classes['http_code']);
    }

    
}
