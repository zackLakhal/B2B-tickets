<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Newrqst;
class RequestController extends Controller
{
    public function index()
    {
        $rqts = Newrqst::withTrashed()->get();
        return response()->json($rqts);

    }

    public function non_deleted(){

        $rqts = Newrqst::all();
        return response()->json($rqts);
    }

    public function deleted(){

        $rqts = Newrqst::onlyTrashed();
        return response()->json($rqts);
    }

    public function detail($id){

        $rqt = Newrqst::withTrashed()
                ->where('id', $id)
                ->first();
        return response()->json($rqt);
    }

    public function traiter($id)
    {

        $done = false;
        
            $temp = Newrqst::find($id); 
            $temp->delete();
            $done = true;
        

        $rqt = Newrqst::withTrashed()
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
            'rqt' => $rqt
        ];
        return response()->json($objet);
    }

    public function store(Request $request){

        
        $validator = Validator::make($request->all(), [

            'nom' => 'required',
            'email' => 'required',
            'gsm' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }


        $rqst = new Newrqst();
       
        $rqst->nom = $request->nom;
        $rqst->email = $request->email;
        $rqst->tel = $request->gsm;
        $rqst->message = $request->message;
        $rqst->save();
        $rqst->ref = "RQST-".date('Y')."-".time()."-".$rqst->id;
        $rqst->save();
        $check;
        $check = "done";

        $objet =  [
            'check' => $check,
            'rqst' => $rqst,
            'inputs' => $request->all()
        ];
        return response()->json($objet);

    }
}
