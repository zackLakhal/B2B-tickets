<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Anomalie;
class AnomalieController extends Controller
{
    public function index()
    {
        $anomalies = Anomalie::withTrashed()->get();
        return response()->json($anomalies);

    }

    public function non_deleted(){

        $anomalies = Anomalie::all();
        return response()->json($anomalies);
    }

    public function deleted(){

        $anomalies = Anomalie::onlyTrashed();
        return response()->json($anomalies);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'value' => 'required|unique:anomalies',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()]);
        }

        $anomalie = new Anomalie();
        $anomalie->value = $request->value;
        $anomalie->save();
        $check;
        $count = Anomalie::all()->count();
        if (is_null($anomalie)) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'count' => $count -1,
            'anomalie' => $anomalie,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }


    public function edit(Request $request,$edit,$id)
    {

        $done = false;
        if ($edit == "delete") {
            $anomalie = Anomalie::find($id); 
            $anomalie->delete();
            $done = true;
        } 
        if($edit == "restore") {
            $anomalie = Anomalie::onlyTrashed()
                        ->where('id', $id)
                        ->first() ; 
            $anomalie->restore();
            $done = true;

        }
        if($edit == "edit") {

            $validator = Validator::make($request->all(), [

                'value' => 'required|unique:anomalies',
            ]);
    
    
            if ($validator->fails()) {
    
                return response()->json(['error' => $validator->errors()]);
            }

            $anomalie = Anomalie::withTrashed()
                        ->where('id', $id)
                        ->first();
            $anomalie->value = $request->value;
            $anomalie->save();
            $done = true;

        }

        $anomalie = Anomalie::withTrashed()
                    ->where('id', $id)
                    ->first();
        
    $check;
        if ( !$done) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'anomalie' => $anomalie,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }
}
