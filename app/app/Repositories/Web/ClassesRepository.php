<?php

namespace App\Repositories\Web;

use App\Models\ClassesSolicitation;
use App\Models\SolicitationWarn;
use App\Models\Classes;
use App\Models\Metters;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Exception;
use Laratrust\LaratrustFacade as Laratrust;

class ClassesRepository
{
    private $classes;
    private $metters;
    private $user;
    private $classesSolicitation;
    private $solicitationWarn;

    public function __construct(
        Classes             $classes,
        Metters             $metters,
        User                $user,
        ClassesSolicitation $classesSolicitation,
        SolicitationWarn    $solicitationWarn
    )
    {
        $this->classes             = $classes;
        $this->metters             = $metters;
        $this->user                = $user;
        $this->classesSolicitation = $classesSolicitation;
        $this->solicitationWarn    = $solicitationWarn;
    }

    public function index()
    {
        try {

            if(Laratrust::isAbleTo('read-all-classes'))
                return $this->classes->with(['user','metters', 'classes_solicitation'])
                                     ->paginate(20);
            else
                return $this->classes->with(['user','metters', 'classes_solicitation'])
                                     ->where('user_id', Auth::id())
                                     ->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function store($request)
    {
        DB::beginTransaction();

        try{   

            if(Laratrust::isAbleTo('update-classes-teacher'))
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
            dd($th);
            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function view($class_id)
    {
        try {
            
            return $this->classes->find($class_id);

        } catch (\Throwable $th) {

            return response('', 500);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            if(Laratrust::isAbleTo('update-classes-teacher'))
                $teacher_id = $request->teacher;
            else
                $teacher_id = Auth::id();

            $this->classes->where('id', $request->class_id)
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

    public function delete($class_id)
    {
        DB::beginTransaction();

        try {

            $this->classes->where('id', $class_id)
                          ->delete();

            DB::commit();

            return response(["Mat??ria (id: $class_id) deletada com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante deletar a mat??ria']
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

    public function request($class_id)
    {
        DB::beginTransaction();

        try {

            $exist = $this->classesSolicitation->where('class_id', $class_id)
                                               ->where('user_id', Auth::id())
                                               ->first();

            if($exist == null){
                $this->classesSolicitation->create([
                    'class_id' => $class_id,
                    'user_id'   => Auth::id()
                ]);
    
                DB::commit();

                return response(["Solicita????o (id: $class_id) criada com successo, aguarde aprova????o!"], 200);

            } else {
                DB::rollBack();

                return response(['errors' => [
                                    'users' => [
                                        ["Usu??rio j?? possui uma solicita????o ativa para est?? aula."]
                                    ]
                                ]], 400);
            }

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante a solici????o de entrar na aula']
                                ]
                            ]], 500);
        }
    }

    public function requestCancel($class_id)
    {
        DB::beginTransaction();

        try {

            $this->classesSolicitation->where('class_id', $class_id)
                                      ->where('user_id', Auth::id())
                                      ->update([
                                          'canceled'    => true,
                                          'canceled_at' => date('Y-m-d H:i:s')
                                      ]);
                                    
            $this->classesSolicitation->where('class_id', $class_id)
                                      ->where('user_id', Auth::id())
                                      ->delete();
            DB::commit();

            return response(["Participa????o na aula (id: $class_id) foi cancelada com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante o cancelamento da participa????o']
                                ]
                            ]], 500);
        }
    }

    public function studentsClassIndex($class_id)
    {
        try {
            
            return $this->classes->find($class_id);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function studentsListIndex($class_id)
    {
        try {
            
            return $this->classesSolicitation->with('user')
                                             ->where('class_id', $class_id)
                                             ->paginate(20);
            

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function responseStaudentRequest($request)
    {

        DB::beginTransaction();

        try {
            
            if($request->response == '1'){
                $this->classesSolicitation->where('id', $request->request_id)
                                          ->update([
                                              'accept'      => 1,
                                              'reason'      => null,
                                              'accepted_at' => date('Y-m-d H:i:s')
                                          ]);

                $reponse = ["Participa????o aceita com successo!"];
            } else {
                $this->classesSolicitation->where('id', $request->request_id)
                                          ->update([
                                              'accept'      => 0,
                                              'reason'      => $request->reason,
                                              'accepted_at' => date('Y-m-d H:i:s')
                                          ]);
                $reponse = ["Participa????o negada com successo!"];
            }

            $this->solicitationWarn->create([
                'classe_solicitation_id' => $request->request_id
            ]);

            DB::commit();

            return response($reponse, 200);

        } catch (\Throwable $th) {
            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante o cancelamento da participa????o']
                                ]
                            ]], 500);
        }
    }
    
}
