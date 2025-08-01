<?php

namespace App\Domains\LeafLetMap\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\LeafLetMap\DTOs\LeafLetMapData;
use App\Domains\LeafLetMap\Actions\CreateLeafLetMapAction;
use App\Domains\LeafLetMap\Requests\CreateLeafLetMapRequest;

class LeafLetMapController extends Controller
{
    public function index()
    {
        return Inertia::render('LeafletMap/Index');
    }

    public function getPlaces(CreateLeafLetMapRequest $request, CreateLeafLetMapAction $action)
    {
        $dto = LeafLetMapData::fromArray($request->validated());
        $places = $action->execute($dto);

        return response()->json($places);
    }
}