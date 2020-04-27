<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Produit;
use App\Equipement;
use DB;
use App\Agence;
use App\Clientuser;
use App\Souscription;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::withTrashed()->get();
        $equipements = array();
        foreach ($produits as $produit) {
            $equipements[$produit->id] = $produit->equipements;
        }
        return response()->json($produits);
    }

    public function active_produits(Request $request)
    {
        $temps = DB::table('souscriptions')
            ->select('produit_id')
            ->groupBy('produit_id')
            ->where('agence_id', $request->agence)->get();
        $affected_ids = array();
        foreach ($temps as $temp) {
            $affected_ids[] = $temp->produit_id;
        }
        $produits = Produit::whereNotIn('id', $affected_ids)->get();
        return response()->json($produits);
    }

    public function store_produit(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'nom_p' => 'required|unique:produits,nom',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        $produit = new Produit();


        $produit->nom = $request->nom_p;

        if ($request->filled('info_p')) {
            $produit->info = $request->info_p;
        }


        $produit->save();

        if ($request->file('produit')) {
            $file = $request->file('produit');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('produit')->storeAs(
                'produits',
                $produit->id . "_" . $image
            );
            $produit->image = $path;
            $produit->save();
        } else {
            $produit->image = "produits/placeholder.jpg";
            $produit->save();
        }


        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        $count = Produit::all()->count();
        if (is_null($produit)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'produit' => $produit,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function edit_produit(Request $request, $id)
    {
        $done = false;

      
        $produit = Produit::withTrashed()
            ->where('id', $id)
            ->first();
            $validator;
        if ($request->filled('nom_p') && $request->nom_p == $produit->nom) {
            $validator = Validator::make($request->all(), [

                'nom_p' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [

                'nom_p' => 'required|unique:produits,nom',

            ]);
        }


        $produit->nom = $request->nom_p;
        if ($request->filled('info_p')) {
            $produit->info = $request->info_p;
        }


        $produit->save();

        if ($request->file('produit')) {
            $file = $request->file('produit');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('produit')->storeAs(
                'produits',
                $produit->id . "_" . $image
            );
            $produit->image = $path;
            $produit->save();
        } else {
            $produit->image = "produits/placeholder.jpg";
            $produit->save();
        }

        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;
        $done = true;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function delete_produit($id)
    {
        
        $done = false;

        $temp = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $temp->delete();
        $done = true;


        $produit = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit
        ];
        return response()->json($objet);
    }
    public function restore_produit($id)
    {

        $done = false;

        $temp = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $temp->restore();
        $done = true;


        $produit = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit
        ];
        return response()->json($objet);
    }

    public function delete_equipement($p_id, $id)
    {

        $done = false;

        $temp = Equipement::find($id);
        $temp->active = false;
        $temp->save();

        $done = true;
        $produit = Produit::withTrashed()
            ->where('id', $p_id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit
        ];
        return response()->json($objet);
    }
    public function restore_equipement($p_id, $id)
    {

        $done = false;

        $temp = Equipement::find($id);
        $temp->active = true;
        $temp->save();

        $done = true;
        $produit = Produit::withTrashed()
            ->where('id', $p_id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit
        ];
        return response()->json($objet);
    }

    public function store_equipement(Request $request, $id)
    {
        $done = false;

        $validator = Validator::make($request->all(), [

            'nom_e' => 'required',
            'modele_e' => 'required',
            'marque_e' => 'required',

        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        $temp = new Equipement();
        $temp->produit_id = $id;
        $temp->nom = $request->nom_e;
        $temp->modele = $request->modele_e;
        $temp->marque = $request->marque_e;

        if ($request->filled('info_e')) {
            $temp->info = $request->info_e;
        }

        $temp->save();


        if ($request->file('equip')) {
            $file = $request->file('equip');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('equip')->storeAs(
                'produits',
                $temp->id . "_" . $image
            );
            $temp->image = $path;
            $temp->save();
        } else {
            $temp->image = "produits/placeholder.jpg";
            $temp->save();
        }

        $done = true;

        $produit = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function edit_equipement(Request $request, $id, $e_id)
    {
        $done = false;

        $validator = Validator::make($request->all(), [

            'nom_e' => 'required',
            'modele_e' => 'required',
            'marque_e' => 'required',

        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }
        $temp = Equipement::find($e_id);
        $temp->nom = $request->nom_e;

        $temp->modele = $request->modele_e;
        $temp->marque = $request->marque_e;

        if ($request->filled('info_e')) {
            $temp->info = $request->info_e;
        }

        $temp->save();

        if ($request->file('equip')) {
            $file = $request->file('equip');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('equip')->storeAs(
                'produits',
                $temp->id . "_" . $image
            );
            $temp->image = $path;
            $temp->save();
        } else {
            $temp->image = "produits/placeholder.jpg";
            $temp->save();
        }

        $done = true;

        $produit = Produit::withTrashed()
            ->where('id', $id)
            ->first();
        $equipements = array();

        $equipements[$produit->id] = $produit->equipements;

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'produit' => $produit,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }


    public function equip_prod(Request $request)
    {

        $objet =  [
            'equipements' => DB::table('views_detail_souscription')
                ->select('equip_id', 'equip_nom')
                ->groupBy('equip_id')
                ->where([
                    ['agence_id', $request->id_a],
                    ['prod_id',   $request->id_p],
                ])->get(),
            'refs' => DB::table('views_detail_souscription')
                ->select('ref_id', 'equip_id', 'ref', DB::raw('count(ref) as ref_ne'))
                ->where([
                    ['agence_id', $request->id_a],
                    ['prod_id',   $request->id_p],
                ])->groupBy('equip_id', 'ref', 'ref_id')
                ->get()
        ];
        return response()->json($objet);
    }

    public function index_equipement($produit_id)
    {
        $produit = Produit::find($produit_id);
        return response()->json($produit->equipements);
    }

    public function attach_prod(Request $request)
    {
        $done = false;
       
        $validator = Validator::make($request->all(), [

            'data' => 'required',
    

        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        foreach ($request->data as $data) {

            for ($i = 0; $i < (int) $data['number']; $i++) {
                $scr = new Souscription();
                $scr->agence_id =  $request->agence;
                $scr->produit_id =  $data['prod_id'];
                $scr->equipement_id =  $data['id'];
                $scr->save();
            }
        }
        $done = true;
        $agence = Agence::withTrashed()
            ->where('id', $request->agence)
            ->first();

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $agence->id],
        //     ['clientable_type', "=", "agence"],
        // ])->first();

        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                ->select('prod_id', 'prod_nom', 'prod_etat')
                ->groupBy('prod_id', 'prod_etat')
                ->where('agence_id', $agence->id)
                ->get()

        ];

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'agence' => $agence,
           // 'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function detach_prod(Request $request)
    {
        $done = false;

        //    $scrs =
        Souscription::where([
            ['agence_id', '=', $request->agence],
            ['produit_id', "=", $request->produit],
        ])->delete();
        // foreach ($scrs as $scr) {
        //     $scr->delete()
        // }
        $done = true;
        $agence = Agence::withTrashed()
            ->where('id', $request->agence)
            ->first();

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $agence->id],
        //     ['clientable_type', "=", "agence"],
        // ])->first();

        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                ->select('prod_id', 'prod_nom', 'prod_etat')
                ->groupBy('prod_id', 'prod_etat')
                ->where('agence_id', $agence->id)
                ->get()

        ];

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'agence' => $agence,
          //  'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }

    public function save_ref(Request $request)
    {
        
        $scr = Souscription::find($request->id);

        $validator;
        if ($request->filled('value') && $request->value == $scr->equip_ref) {
            $validator = Validator::make($request->all(), [

                'value' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [

                'value' => 'required|unique:souscriptions,equip_ref',

            ]);
        }

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        $scr->equip_ref = $request->value;
        $scr->save();

        $objet =  [
            'check' => "done",
            'souscription' => $scr,
            'inputs' => $request->all()
         
        ];

        return response()->json($objet);
    }
}
