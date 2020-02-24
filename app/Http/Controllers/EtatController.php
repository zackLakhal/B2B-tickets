<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etat;
class EtatController extends Controller
{
    public function index()
    {
        $etats = Etat::withTrashed()->get();
        return response()->json($etats);

    }

    public function non_deleted(){

        $etats = Etat::all();
        return response()->json($etats);
    }

    public function deleted(){

        $etats = Etat::onlyTrashed();
        return response()->json($etats);
    }

    public function store(Request $request)
    {
        $etat = new Etat();
        $etat->value = $request->value;
        $etat->save();
        $check;
        $count = Etat::all()->count();
        if (is_null($etat)) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'count' => $count -1,
            'etat' => $etat
        ];
        return response()->json($objet);
    }


    public function edit(Request $request,$edit,$id)
    {

        $done = false;
        if ($edit == "delete") {
            $etat = Etat::find($id); 
            $etat->delete();
            $done = true;
        } 
        if($edit == "restore") {
            $etat = Etat::onlyTrashed()
                        ->where('id', $id)
                        ->first() ; 
            $etat->restore();
            $done = true;

        }
        if($edit == "edit") {
            $etat = Etat::withTrashed()
                        ->where('id', $id)
                        ->first();
            $etat->value = $request->value;
            $etat->save();
            $done = true;

        }

        $etat = Etat::withTrashed()
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
            'etat' => $etat
        ];
        return response()->json($objet);
    }
}
