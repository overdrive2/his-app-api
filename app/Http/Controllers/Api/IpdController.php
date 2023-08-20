<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IpdsCollection;
use App\Models\Ipd;

class IpdController extends Controller
{
    public function index($id)
    {
        try {
            $ipd = Ipd::where('id', $id)->first();
            return response()->json([
                'id' => $ipd->id,
                'an' => $ipd->an,
                'name' => $ipd->patient_name,
                'bedmoves' => $ipd->bedmoves(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
