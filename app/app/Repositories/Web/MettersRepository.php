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

    public function view($metter_id)
    {
        try {
            
            return $this->metters->find($metter_id);

        } catch (\Throwable $th) {

            return response('', 500);
        }
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            $this->metters->where('id', $request->metter_id)
                          ->update([
                'name' => $request->name
            ]);            

            DB::commit();

            return ['success' => 'Matéria editada com sucesso'];

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
