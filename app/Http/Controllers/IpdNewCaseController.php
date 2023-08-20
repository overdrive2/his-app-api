<?php

namespace App\Http\Controllers;

use App\Models\His\HisIpdNewcase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IpdNewCaseController extends Controller
{
    public function store(Request $request)
    {
        $payLoad = json_decode($request->getContent(), true);

        $validator = Validator::make($payLoad, [
            'an' => 'required',
            'fullname' => 'required'
        ]);

        if ($validator->passes()) {
            HisIpdNewcase::create([
                'an' => $payLoad['an'],
                'fullname' => $payLoad['fullname'],
                'regdate' => $payLoad['regdate'],
                'regtime' => $payLoad['regtime'],
                'ward' => $payLoad['ward']
            ]);
            return response()->json([
                'message' => 'success'
            ], 200);
        } else {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
    }

    public function index()
    {
        return
            HisIpdNewcase::selectRaw("an, hn, ward, date_part('year', age(birthday::date)) as ay,
                date_part('month', age(birthday::date)) as am, pname, fname, lname, fullname, regdate, regtime")
                ->whereIn('ward', auth()->user()->wards()->pluck('ward_code'))
                ->get();
                    //->where('ward', Ward::find($this->ward_id)->ward_code);
        /*->when($this->filters['hn'], function($query, $val) {
            return $query->where('hn', str_pad($val, 9, '0', STR_PAD_LEFT));
        })
        ->when($this->filters['an'], function($query, $val) {
            return $query->where('an', str_pad($val, 9, '0', STR_PAD_LEFT));
        });*/
    }
}
