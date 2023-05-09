<?php

namespace App\Http\Controllers\Doctor\Order;

use App\Http\Controllers\Controller;
use App\Models\IpdOrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = [
                'hn'          => $request->hn,
                'an'          => $request->an,
                'order_date'  => DB::raw("CURRENT_DATE"),
                'order_time'  => DB::raw("CURRENT_TIME"),
                'doctor_code' => '',
                'created_by'  => null
            ];

            $master = IpdOrderMaster::make($data);
            $master->save();

            return response()->json([
                'message' => 'The order was added successfully',
                'master' => $master
            ]);
        } catch (\Exception $e) {
            return response()->json([ 
                'error' => 'Something went wrong saving the route',
                'message' => $master
            ], 400);
        }
    }
}
