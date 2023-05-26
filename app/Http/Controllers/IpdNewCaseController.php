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
}
