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
                              ->selectRaw("DATE_FORMAT(created_at, \"%d/%m/%Y %H:%i:%s\") as date")
                              ->where('aproved', true)
                              ->paginate(20);

        } catch (\Throwable $th) {
            return response('', 500);
        }
    }
}
