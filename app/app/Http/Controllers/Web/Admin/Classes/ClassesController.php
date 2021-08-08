<?php

namespace App\Http\Controllers\Web\Admin\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestClasses;

use App\Services\Web\ClassesService;

class ClassesController extends Controller
{
    private $classesService;

    public function __construct(
        ClassesService $classesService
    )
    {
        $this->middleware('auth');
        $this->classesService = $classesService;
    }
    
    public function index()
    {   
        $classes = $this->classesService->index();
        return view('web.pages.classes.manage', compact(['classes']));
    }

    public function create()
    {
        $metters = $this->classesService->metter_list();
        $teachers = $this->classesService->teachers_list();

        $type = 'create';
        return view('web.pages.classes.updateOrCreate', compact('type'))->with([
            'metters'  => $metters,
            'teachers' => $teachers
        ]);
    }

    public function store(RequestClasses $request)
    {
        $result = $this->classesService->store($request);
        $metters = $this->classesService->metter_list();
        $teachers = $this->classesService->teachers_list();

        $type = 'create';
        return view('web.pages.classes.updateOrCreate', compact('type','result'))->with([
            'metters'  => $metters,
            'teachers' => $teachers
        ]);
    }

    public function view($class_id)
    {
        $classes = $this->classesService->view($class_id);
        $metters = $this->classesService->metter_list();
        $teachers = $this->classesService->teachers_list();

        $type = 'edit';
        return view('web.pages.classes.updateOrCreate', compact('type'))->with([
            'classes'  => $classes,
            'metters'  => $metters,
            'teachers' => $teachers
        ]);
    }

    public function update(RequestClasses $request)
    {
        $result = $this->classesService->update($request);
        $classes  = $this->classesService->view($request->class_id);
        $metters = $this->classesService->metter_list();
        $teachers = $this->classesService->teachers_list();

        $type   = 'edit';
        return view('web.pages.classes.updateOrCreate', compact('type','result'))->with([
            'classes'  => $classes,
            'metters'  => $metters,
            'teachers' => $teachers
        ]);
    }

    public function delete($class_id)
    {
        return $this->classesService->delete($class_id);
    }

    public function request($class_id)
    {
        return $this->classesService->request($class_id);
    }

    public function requestCancel($class_id)
    {
        return $this->classesService->requestCancel($class_id);
    }

    public function studentsIndex($class_id)
    {
        $class = $this->classesService->studentsClassIndex($class_id);
        $users = $this->classesService->studentsListIndex($class_id);

        return view('web.pages.classes.students')->with([
            'class' => $class,
            'users' => $users
        ]);
    }

    public function responseStaudentRequest(Request $request)
    {
        return $this->classesService->responseStaudentRequest($request);
    }

}
