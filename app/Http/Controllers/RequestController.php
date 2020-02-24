<?php

namespace App\Http\Controllers;

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
}
