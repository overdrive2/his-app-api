<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomsCollection;
use App\Models\Room;
use App\Models\Ward;

class RoomController extends Controller
{
    public function index($id)
    {
        try {
            $rooms = Room::where('ward_id', $id)->orderBy('room_name', 'asc')->get();
            return response()->json(new RoomsCollection($rooms), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
