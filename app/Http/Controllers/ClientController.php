<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Departement;
use App\Agence;
use App\Clientuser;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{


    public function all_clients()
    {
        $clients = Client::withTrashed()->get();
        return response()->json($clients);
    }

    public function active_clients()
    {
        $clients = Client::all();
        return response()->json($clients);
    }


    public function delete_client($id)
    {

        $done = false;

        $temp = Client::find($id);
        $temp->delete();
        $done = true;


        $client = Client::withTrashed()
            ->where('id', $id)
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'client' => $client
        ];
        return response()->json($objet);
    }
    public function restore_client($id)
    {

        $done = false;

        $temp = Client::withTrashed()
            ->where('id', $id)
            ->first();
        $temp->restore();
        $done = true;


        $client = Client::withTrashed()
            ->where('id', $id)
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'client' => $client
        ];
        return response()->json($objet);
    }

    public function edit_client(Request $request, $id)
    {
        $done = false;

        $client = Client::withTrashed()
            ->where('id', $id)
            ->first();
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->tel = $request->tel;
        $client->adress = $request->adress;
        $file = $request->file('avatar');
        $image = time() . '.' . $file->getClientOriginalExtension();
        $path = $request->file('avatar')->storeAs(
            'clients',
            $client->id . "_" . $image
        );
        $client->photo = $path;
        $client->save();
        $done = true;

        $client = Client::withTrashed()
            ->where('id', $id)
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'client' => $client
        ];
        return response()->json($objet);
    }

    public function store_client(Request $request)
    {
        $client = new Client();
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->tel = $request->tel;
        $client->adress = $request->adress;
        $client->save();
        $file = $request->file('avatar');
        $image = time() . '.' . $file->getClientOriginalExtension();
        $path = $request->file('avatar')->storeAs(
            'clients',
            $client->id . "_" . $image
        );
        $client->photo = $path;
        $client->save();
        $check;
        $count = client::all()->count();
        if (is_null($client)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'client' => $client
        ];
        return response()->json($objet);
    }

    // departement functions

    public function all_departements($id_c)
    {
        $departements = Departement::withTrashed()
            ->where('client_id', $id_c)
            ->get();
        $chefs = array();
        foreach ($departements as $departement) {
            $chefs[] = Clientuser::where([
                ['clientable_id', '=', $departement->id],
                ['clientable_type', "=", "departement"],
            ])
                ->first();
        }
        $objet =  [
            'departements' => $departements,
            'chefs' => $chefs,

        ];
        return response()->json($objet);
    }

    public function affecter(Request $request, $id_c)
    {
        if ($request->current_u != 0) {
            $current_user =  Clientuser::where('id', $request->current_u)
                ->first();

            $current_user->clientable_id = null;
            $current_user->clientable_type = null;
            $current_user->is_affected = false;
            $current_user->save();
        }



        $user = Clientuser::where('id', $request->id_u)
            ->first();

        $user->clientable_id = $request->id_d;
        $user->clientable_type = "departement";
        $user->is_affected = true;
        $user->save();

        $departement = Departement::withTrashed()
            ->where('id', $request->id_d)
            ->first();

        $objet =  [
            'departement' => $departement,
            'chef' => $user,

        ];
        return response()->json($objet);
    }

    public function delete_departement($id_c, $id)
    {

        $done = false;

        $temp = Departement::find($id);
        $temp->delete();
        $done = true;


        $departement = Departement::withTrashed()
            ->where('id', $id)
            ->first();

        $chef = Clientuser::where([
            ['clientable_id', '=', $departement->id],
            ['clientable_type', "=", "departement"],
        ])
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            'chef' => $chef,
        ];
        return response()->json($objet);
    }
    public function restore_departement($id_c, $id)
    {

        $done = false;

        $temp =  Departement::withTrashed()
            ->where('id', $id)
            ->first();
        $temp->restore();
        $done = true;


        $departement = Departement::withTrashed()
            ->where('id', $id)
            ->first();

        $chef = Clientuser::where([
            ['clientable_id', '=', $departement->id],
            ['clientable_type', "=", "departement"],
        ])
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            'chef' => $chef,
        ];
        return response()->json($objet);
    }

    public function edit_departement(Request $request, $id_c, $id)
    {
        $done = false;

        $departement = Departement::withTrashed()
            ->where('id', $id)
            ->first();
        $departement->nom = $request->nom;
        $departement->email = $request->email;
        $departement->tel = $request->tel;
        $departement->save();
        $done = true;

        $chef = Clientuser::where([
            ['clientable_id', '=', $departement->id],
            ['clientable_type', "=", "departement"],
        ])
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            'chef' => $chef,
        ];
        return response()->json($objet);
    }

    public function store_departement(Request $request, $id_c)
    {
        $departement = new Departement();
        $departement->client_id = $id_c;
        $departement->nom = $request->nom;
        $departement->email = $request->email;
        $departement->tel = $request->tel;
        $departement->save();
        $check;
        $count = Departement::all()->count();
        if (is_null($departement)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'departement' => $departement
        ];
        return response()->json($objet);
    }

    public function all_agences($id_c, $id_d)
    {
        $agences = Agence::withTrashed()
            ->where('departement_id', $id_d)
            ->get();

        $chefs = array();
        $villes = array();
        $souscriptions = array();
        foreach ($agences as $agence) {
            $chefs[] = Clientuser::where([
                ['clientable_id', '=', $agence->id],
                ['clientable_type', "=", "agence"],
            ])
                ->first();
            $villes[] = $agence->ville;

            $souscriptions[] = [
                'id' => $agence->id,
                'produits'  => DB::table('views_detail_souscription')
                                ->select('prod_id', 'prod_nom','prod_etat')
                                ->groupBy('prod_id','prod_etat')
                                ->where('agence_id', $agence->id)
                                ->get()

            ];
                            
        }

        
        $objet =  [
            'agences' => $agences,
            'chefs' => $chefs,
            'villes' => $villes,
            'souscriptions' => $souscriptions

        ];
        return response()->json($objet);
    }

   


    public function delete_agence($id_c,$id_d, $id)
    {

        $done = false;

        $temp = Agence::find($id);
        $temp->delete();
        $done = true;


        $agence = Agence::withTrashed()
            ->where('id', $id)
            ->first();

        $chef = Clientuser::where([
            ['clientable_id', '=', $agence->id],
            ['clientable_type', "=", "agence"],
        ])->first();
        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                            ->select('prod_id', 'prod_nom','prod_etat')
                            ->groupBy('prod_id','prod_etat')
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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }
    public function restore_agence($id_c,$id_d, $id)
    {

        $done = false;

        $temp =  Agence::withTrashed()
            ->where('id', $id)
            ->first();
        $temp->restore();
        $done = true;


        $agence = Agence::withTrashed()
            ->where('id', $id)
            ->first();

        $chef = Clientuser::where([
            ['clientable_id', '=', $agence->id],
            ['clientable_type', "=", "agence"],
        ])->first();

        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                            ->select('prod_id', 'prod_nom','prod_etat')
                            ->groupBy('prod_id','prod_etat')
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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }

    public function edit_agence(Request $request, $id_c,$id_d, $id)
    {
        $done = false;

        $agence = Agence::withTrashed()
            ->where('id', $id)
            ->first();
        $agence->nom = $request->nom;
        $agence->email = $request->email;
        $agence->tel = $request->tel;
        $agence->adress = $request->adress;
        $agence->ville_id = $request->ville;
        
        $agence->save();
        $done = true;

        $chef = Clientuser::where([
            ['clientable_id', '=', $agence->id],
            ['clientable_type', "=", "agence"],
        ])->first();

        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                            ->select('prod_id', 'prod_nom','prod_etat')
                            ->groupBy('prod_id','prod_etat')
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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }

    public function store_agence(Request $request, $id_c,$id_d)
    {
        $agence = new Agence();
        $agence->departement_id = $id_d;
        $agence->nom = $request->nom;
        $agence->email = $request->email;
        $agence->tel = $request->tel;
        $agence->adress = $request->adress;
        $agence->ville_id = $request->ville;
        $agence->save();
        $check;
        $count = Agence::all()->count();
        if (is_null($agence)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'agence' => $agence,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }
    public function affecter_agence(Request $request, $id_c,$id_d)
    {
        if ($request->current_u != 0) {
            $current_user =  Clientuser::where('id', $request->current_u)
                ->first();

            $current_user->clientable_id = null;
            $current_user->clientable_type = null;
            $current_user->is_affected = false;
            $current_user->save();
        }



        $user = Clientuser::where('id', $request->id_u)
            ->first();

        $user->clientable_id = $request->id_a;
        $user->clientable_type = "agence";
        $user->is_affected = true;
        $user->save();

        $agence = Agence::withTrashed()
            ->where('id', $request->id_a)
            ->first();

        $objet =  [
            'agence' => $agence,
            'chef' => $user,
            'ville' => $agence->ville

        ];
        return response()->json($objet);
    }

}
