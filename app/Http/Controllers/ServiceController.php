<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('pages.services.index', [
            'services' => Service::query()->published()->get(),
            'projects' => Project::query()->published()->get(),
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('pages.services.show', [
            'service' => $service,
            'otherServices' => Service::query()->published()->whereKeyNot($service->getKey())->get(),
        ]);
    }
}
