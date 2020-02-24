<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ville;
class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::withTrashed()->get();
        return response()->json($villes);

    }
    

    public function active_index(){

        $villes = Ville::all();
        return response()->json($villes);
    }

    public function deleted(){

        $villes = Ville::onlyTrashed();
        return response()->json($villes);
    }


    public function store(Request $request)
    {
        $ville = new Ville();
        $ville->nom = $request->nom;
        $ville->save();
        $check;
        $count = Ville::all()->count();
        if (is_null($ville)) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'count' => $count -1,
            'ville' => $ville
        ];
        return response()->json($objet);
    }

    public function edit(Request $request,$edit,$id)
    {

        $done = false;
        if ($edit == "delete") {
            $ville = Ville::find($id); 
            $ville->delete();
            $done = true;
        } 
        if($edit == "restore") {
            $ville = Ville::onlyTrashed()
                        ->where('id', $id)
                        ->first() ; 
            $ville->restore();
            $done = true;

        }
        if($edit == "edit") {
            $ville = Ville::withTrashed()
                        ->where('id', $id)
                        ->first();
            $ville->nom = $request->nom;
            $ville->save();
            $done = true;

        }

        $ville = Ville::withTrashed()
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
            'ville' => $ville
        ];
        return response()->json($objet);
    }
}
