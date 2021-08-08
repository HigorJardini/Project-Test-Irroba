<?php

namespace App\Http\Controllers\Web\Admin\Metters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RequestMetter;

use App\Services\Web\MettersService;

class MettersController extends Controller
{
    private $mettersService;

    public function __construct(
        MettersService $mettersService
    )
    {
        $this->middleware('auth');
        $this->mettersService = $mettersService;
    }
    
    public function index()
    {   
        $metters = $this->mettersService->index();
        return view('web.pages.metters.manage', compact(['metters']));
    }

    public function create()
    {
        $type = 'create';
        return view('web.pages.metters.updateOrCreate', compact('type'));
    }

    public function store(RequestMetter $request)
    {
        $result = $this->mettersService->store($request);
        $type = 'create';
        return view('web.pages.metters.updateOrCreate', compact('type','result'));
    }

    public function view($metter_id)
    {
        $metters = $this->mettersService->view($metter_id);
        $type = 'edit';
        return view('web.pages.metters.updateOrCreate', compact('type'))->with([
            'metters' => $metters
        ]);
    }

    public function update(Request $request)
    {
        $result = $this->mettersService->update($request);
        $metters  = $this->mettersService->view($request->metter_id);
        $type   = 'edit';
        return view('web.pages.metters.updateOrCreate', compact('type','result'))->with([
            'metters' => $metters
        ]);
    }

    public function delete($metter_id)
    {
        return $this->mettersService->delete($metter_id);
    }
}
