<?php

namespace App\Repositories\Web;

use App\Models\User;
use Illuminate\Support\Facades\DB;

use Exception;

class UsersRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try {

            return $this->user->with('roles')
                              ->select('id', 'name', 'email')
                              ->selectRaw("DATE_FORMAT(created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                              ->where('aproved', false)
                              ->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function accept($user_id)
    {
        DB::beginTransaction();

        try {

            $this->user->where('id', $user_id)
                       ->update([
                           'aproved' => true
                       ]);

            DB::commit();

                return response(["Usuário (id: $user_id) aprovado com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante a aprovação']
                                ]
                            ]], 500);
        }
    }

    public function delete($user_id)
    {
        DB::beginTransaction();

        try {

            $this->user->where('id', $user_id)
                       ->delete();

            DB::commit();

                return response(["Usuário (id: $user_id) deletado com successo!"], 200);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response(['errors' => [
                                'users' => [
                                    ['Erro durante deletar o usuário']
                                ]
                            ]], 500);
        }
    }

    public function manageIndex()
    {
        try {

            return $this->user->with('roles')
                              ->select('id', 'name', 'email')
                              ->selectRaw("IF(active, 'Ativo', 'Inativo') as status")
                              ->selectRaw("DATE_FORMAT(created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                              ->where('aproved', true)
                              ->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }

    public function manageStore($request)
    {
        DB::beginTransaction();

        try {

            $user = $this->user->where('email', $request->email)
                                ->first();
            
            if($user == null){
                
                $user = $this->user->create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'aproved'  => true,
                    'active'   => true
                ]);

                $user->attachRoles([$request->role]);

                DB::commit();

                return ['success' => 'Usuário criado com sucesso'];
            } else
                $errors['errors'][] = 'Email já se encontra Cadastrado';

        } catch (\Throwable $th) {

            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }

    public function manageView($user_id)
    {
        try {
            
            return $this->user->with('roles')
                              ->find($user_id);

        } catch (\Throwable $th) {

            return response('', 500);
        }
    }

    public function manageUpdate($request)
    {
        DB::beginTransaction();

        try {

            $parms = ['name', 'email', 'password'];

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

            if($user_ct === null){
                $user_up = $this->user->find($request->user_id);
                $user_up->detachRoles([$user_up->roles[0]->id]);
                $user_up->attachRoles([$request->role]);
            } else if($user_ct->roles[0]->id != $request->role){
                $user_ct->detachRoles([$user_ct->roles[0]->id]);
                $user_ct->attachRoles([$request->role]);
            }

            DB::commit();

            return ['success' => 'Usuário editado com sucesso'];

        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();

            $errors['errors'][] = 'Algo de errado aconteceu';
            return $errors;
        }
    }
}
