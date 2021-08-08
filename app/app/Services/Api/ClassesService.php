<?php

namespace App\Services\Api;

use App\Repositories\Api\ClassesRepository;

class ClassesService
{
    private $classesRepository;

    public function __construct(
                                    ClassesRepository $classesRepository
                               )
    {
        $this->classesRepository = $classesRepository;
    }

    public function classes()
    {
        $classes = $this->classesRepository->classes();

        if($classes !== null)
            return [
                'http_code' => 200,
                'return'   => $classes
            ];
        else   
            return [
                'http_code' => 200,
                'return'   => ['message' => "Classes not found"]
            ];
    }

    
}
