<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IpdsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        //return parent::toArray($request);
        return $this->collection->map(function($ipd) {
            return [
                'id' => $ipd->id,
                'an' => $ipd->an,
                'name' => $ipd->patient_name,
                'bedmoves' => $ipd->bedmoves(),
            ];
        });
    }
}
