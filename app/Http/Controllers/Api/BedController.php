<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bed;

class BedController extends Controller
{
    public function show($id)
    {
        try {
            $bed = Bed::find($id);
            return response()->json($bed, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
