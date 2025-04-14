<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class IndoRegionController extends Controller
{
    public function provinces()
    {
        return Province::all();
    }

    public function regencies(Province $province): JsonResponse
    {
        return response()->json(
            Regency::where('province_id', $province->id)->get()
        );
    }

    public function districts(Regency $regency): JsonResponse
    {
        return response()->json(
            District::where('regency_id', $regency->id)->get()
        );
    }

    public function villages(District $district): JsonResponse
    {
        return response()->json(
            Village::where('district_id', $district->id)->get()
        );
    }
}
