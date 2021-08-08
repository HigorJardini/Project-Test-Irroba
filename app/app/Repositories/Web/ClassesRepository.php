<?php

namespace App\Repositories\Web;

use App\Models\Classes;
use App\Models\Metters;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Exception;
use Laratrust;

class ClassesRepository
{
    private $classes;
    private $metters;
    private $user;

    public function __construct(
        Classes $classes,
        Metters $metters,
        User    $user
    )
    {
        $this->classes = $classes;
        $this->metters = $metters;
        $this->user    = $user;
    }

    public function index()
    {
        try {

            return $this->classes->with('user')
                                 ->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function store($request)
    {
        DB::beginTransaction();

        try{   

            if(Laratrust::isAbleTo('create-classes'))
                $teacher_id = $request->teacher;
            else
                $teacher_id = Auth::id();
        
            $this->classes->create([
                'metter_id'   => $request->id,
                'user_id'     => $teacher_id,
                'name'        => $request->name,
                'description' => $request->description
            ]);

            DB::commit();

            return ['success' => 'Aula criada com sucesso'];


        } catch (\Throwable $th) {

            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function view($classe_id)
    {
        try {
            
            return $this->classes->find($classe_id);

        } catch (\Throwable $th) {

            return response('', 500);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            if(Laratrust::isAbleTo('create-classes'))
                $teacher_id = $request->teacher;
            else
                $teacher_id = Auth::id();

            $this->classes->where('id', $request->classe_id)
                          ->update([
                                'metter_id'   => $request->id,
                                'user_id'     => $teacher_id,
                                'name'        => $request->name,
                                'description' => $request->description
                          ]);

            DB::commit();

            return ['success' => 'Aula atualizada com sucesso'];

        } catch (\Throwable $th) {

            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function delete($classe_id)
    {
        DB::beginTransaction();

        try {

            $this->classes->where('id', $classe_id)
                          ->delete();

            DB::commit();

                return response(["Matéria (id: $classe_id) deletada com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante deletar a matéria']
                                ]
                            ]], 500);
        }
    }

    public function metter_list()
    {
        try {
            
            return $this->metters->get();

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function teachers_list()
    {
        try {
            
            return $this->user->whereRoleIs('teacher')
                              ->get();

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }
    
}
