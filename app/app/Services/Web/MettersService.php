<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Web\MettersRepository;

use Exception;

class MettersService
{
    private $mettersRepository;

    public function __construct(MettersRepository $mettersRepository)
    {
        $this->mettersRepository = $mettersRepository;
    }

    public function index()
    {
        return $this->mettersRepository->index();
    }

    public function store($request)
    {
        return $this->mettersRepository->store($request);
    }

    public function view($metter_id)
    {
        return $this->mettersRepository->view($metter_id);
    }

    public function update($metter_id)
    {
        return $this->mettersRepository->update($metter_id);
    }

    public function delete($metter_id)
    {
        return $this->mettersRepository->delete($metter_id);
    }
}
