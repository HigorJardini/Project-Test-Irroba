<?php

namespace App\Repositories\Web;

use App\Models\Metters;
use Illuminate\Support\Facades\DB;

use Exception;

class MettersRepository
{
    private $metters;

    public function __construct(Metters $metters)
    {
        $this->metters = $metters;
    }

    public function index()
    {
        try {

            return $this->metters->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function store($request)
    {
        DB::beginTransaction();

        try{   
        
                $this->metters->create([
                    'name' => $request->name
                ]);

                DB::commit();

                return ['success' => 'Matéria criada com sucesso'];


        } catch (\Throwable $th) {

            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function view($user_id)
    {
        try {
            
            return $this->user->with('roles')
                              ->find($user_id);

        } catch (\Throwable $th) {

            return response('', 500);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            $parms = ['name', 'email'];

            $user_ct = $this->user->with('roles')
                                  ->where('email',$request->email)
                                  ->first();

            if($user_ct != null && $user_ct->id != $request->user_id)
                $errors['errors'][] = 'Email já se encontra Cadastrado';

            if(isset($errors))
                return $errors;

            $arr = [];

            foreach($request->only($parms) as $key => $index){
                if(($index != '' || !empty($index)) && $key != 'role')
                    if($key == 'password')
                        $arr[$key] = bcrypt($index);
                    else
                        $arr[$key] = $index;
            }

            $arr['active'] = $request->status;

            $this->user->find($request->user_id)->update($arr);

            if($user_ct->roles[0]->id != $request->role){
                $user_ct->detachRoles([$user_ct->roles[0]->id]);
                $user_ct->attachRoles([$request->role]);
            }

            DB::commit();

            return ['success' => 'Usuário editado com sucesso'];

        } catch (\Throwable $th) {

            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function delete($metter_id)
    {
        DB::beginTransaction();

        try {

            $this->metters->where('id', $metter_id)
                          ->delete();

            DB::commit();

                return response(["Matéria (id: $metter_id) deletada com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante deletar a matéria']
                                ]
                            ]], 500);
        }
    }
}
