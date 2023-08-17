<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoomsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        //return parent::toArray($request);
        return $this->collection->map(function($room) {
            return [
                'id' => $room->id,
                'name' => $room->room_name,
            ];
        });
    }
}
