<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Laratrust;

use App\Repositories\Web\ClassesRepository;

use Exception;

class ClassesService
{
    private $classesRepository;

    public function __construct(ClassesRepository $classesRepository)
    {
        $this->classesRepository = $classesRepository;
    }

    public function index()
    {
        return $this->classesRepository->index();
    }

    public function store($request)
    {
        return $this->classesRepository->store($request);
    }

    public function view($classe_id)
    {
        return $this->classesRepository->view($classe_id);
    }

    public function update($classe_id)
    {
        return $this->classesRepository->update($classe_id);
    }

    public function delete($classe_id)
    {
        return $this->classesRepository->delete($classe_id);
    }

    public function metter_list()
    {
        return $this->classesRepository->metter_list();
    }

    public function teachers_list()
    {
        if(Laratrust::isAbleTo('update-classes-teacher'))
            return $this->classesRepository->teachers_list();
        else
            return [];
        
    }
}
