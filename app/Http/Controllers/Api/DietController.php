<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    public function index(Request $request)
    {
        try {
            $result = Diet::query()
                ->when($request->get('input'), function($query, $search) {
                    return $query->where('diet_name', 'like', '%'.$search.'%');
                })->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json(['diets' => $result], 200);
    }
}
