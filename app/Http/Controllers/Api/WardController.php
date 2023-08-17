<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WardsCollection;
use App\Models\Ward;

class WardController extends Controller
{
    public function index()
    {
        try {
            $wards = Ward::where('active', true)->orderBy('name', 'asc')->get();
            return response()->json(new WardsCollection($wards), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
