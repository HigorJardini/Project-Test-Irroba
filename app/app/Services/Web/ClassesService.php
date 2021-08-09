<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Laratrust\LaratrustFacade as Laratrust;

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
        $classes = $this->classesRepository->index();

        $user_id =  Auth::id();
        
        foreach($classes as $key => $class){

            $students = [];

            foreach($class->classes_solicitation as $students_request){
                $students[] = [
                    'user_id' => $students_request->user_id,
                    'accept'  => $students_request->accept,
                    'reason'  => $students_request->reason
                ];
            }

            if(in_array($user_id, array_column($students, 'user_id'))){
                $search = array_search($user_id, array_column($students, 'user_id'));

                if(!is_bool($search)){
                    $classes[$key]->solicitation_exist = [
                        'status' => true,
                        'accept' => $students[$search]['accept'],
                        'reason' => $students[$search]['reason']
                    ];
                }   
                
            } else{
                $classes[$key]->solicitation_exist = [
                    'status' => false,
                    'accept' => false,
                    'reason' => false
                ];
            }
        }

        return $classes;
    }

    public function store($request)
    {
        return $this->classesRepository->store($request);
    }

    public function view($class_id)
    {
        return $this->classesRepository->view($class_id);
    }

    public function update($class_id)
    {
        return $this->classesRepository->update($class_id);
    }

    public function delete($class_id)
    {
        return $this->classesRepository->delete($class_id);
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

    public function request($class_id)
    {
        return $this->classesRepository->request($class_id);
    }

    public function requestCancel($class_id)
    {
        return $this->classesRepository->requestCancel($class_id);
    }

    public function studentsClassIndex($class_id)
    {
        return $this->classesRepository->studentsClassIndex($class_id);
    }

    public function studentsListIndex($class_id)
    {
        return $this->classesRepository->studentsListIndex($class_id);
    }

    public function responseStaudentRequest($request)
    {
        return $this->classesRepository->responseStaudentRequest($request);
    }
}
