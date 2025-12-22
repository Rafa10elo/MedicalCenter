<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use App\Services\SpecialtyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private SpecialtyService $service) {}

    public function index(Request $request)
    {


        $lang = $request->header('lang', 'en');

        return SpecialtyResource::collection(
            $this->service->list($lang)
        );
    }



    public function store(StoreSpecialtyRequest $request)
    {
        $specialty = $this->service->create($request->validated());

        return new SpecialtyResource($specialty);
    }

    public function update(UpdateSpecialtyRequest $request, Specialty $specialty)
    {
        $specialty = $this->service->update($specialty, $request->validated());

        return new SpecialtyResource($specialty);
    }

    public function destroy(Specialty $specialty)
    {
        $this->service->delete($specialty);

        return response()->noContent();
    }
}
