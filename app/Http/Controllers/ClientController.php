<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Client;
use App\Departement;
use App\Agence;
use App\Clientuser;
use App\Nstuser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{


    public function all_clients()
    {
        $clients = null;
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        switch ($auth->role_id) {
            case 4:
                $clients = Client::where('id', $auth->created_by)->get();
                break;
            case 5:
                $clients = Client::where('id', $auth->created_by)->get();
                break;
            default:
                $clients = Client::withTrashed()->get();
                break;
        }
        $departements = array();
        foreach ($clients as  $client) {
            $departements[] = Departement::where('client_id', $client->id)->first();
        }

        $obj = [
            'clients' => $clients,
            'departements' => $departements
        ];


        return response()->json($obj);
    }

    public function filter_all_clients(Request $request)
    {
        $filters = array();
        $clients = null;
        $request->client_id == "0" ? $filters[] = ['id', '<>', 0] :  $filters[] = ['id', '=', $request->client_id];


        if ($request->is_all == "true") {
            $clients = Client::where($filters)->withTrashed()->get();
        } else {

            $request->is_deleted == 'true' ?  $clients = Client::onlyTrashed()->where($filters)->get() : $clients = Client::where($filters)->get();
        }
        //return response()->json($request->all());
        //return response()->json($filters);
        $departements = array();
        foreach ($clients as  $client) {
            $departements[] = Departement::where('client_id', $client->id)->first();
        }

        $obj = [
            'clients' => $clients,
            'departements' => $departements
        ];


        return response()->json($obj);
    }

    public function active_clients()
    {
        $clients = null;
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        switch ($auth->role_id) {
            case 4:
                $clients = Client::where('id', $auth->created_by)->get();
                break;
            case 5:
                $clients = Client::where('id', $auth->created_by)->get();
                break;
            default:
                $clients = Client::all();
                break;
        }

        return response()->json($clients);
    }


    public function delete_client($id)
    {

        $done = false;

        $temp = Client::find($id);
        $userclient = Clientuser::where('email', '=', $temp->email)->first();
        $departement = Departement::where('client_id', $id)->first();
        $temp->delete();
        $departement->delete();
        $userclient->delete();
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
            'client' => $client,
            'departement' => $departement
        ];
        return response()->json($objet);
    }
    public function restore_client($id)
    {

        $done = false;

        $temp = Client::withTrashed()
            ->where('id', $id)
            ->first();
        $departement = Departement::withTrashed()
            ->where('client_id', $id)
            ->first();

        $userclient = Clientuser::withTrashed()
            ->where('email', '=', $temp->email)->first();
        $temp->restore();
        $departement->restore();
        $userclient->restore();
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
            'client' => $client,
            'departement' => $departement
        ];
        return response()->json($objet);
    }

    public function edit_client(Request $request, $id)
    {
        $done = false;

        $client = Client::withTrashed()
            ->where('id', $id)
            ->first();


        $validator = null;

        if ($request->filled('nom') && $request->filled('email') && $request->nom == $client->nom && $request->email == $client->email) {
            $validator = Validator::make($request->all(), [

                'nom' => 'required',
                'adress' => 'required',
                'email' => 'required',
                'tel' => 'required',
            ]);
        } else {
            if ($request->nom != $client->nom && $request->email != $client->email) {
                $validator = Validator::make($request->all(), [

                    'nom' => 'required|unique:clients',
                    'adress' => 'required',
                    'email' => 'required|unique:clientusers',
                    'tel' => 'required',
                ]);
            } else {
                if ($request->nom != $client->nom && $request->email == $client->email) {

                    $validator = Validator::make($request->all(), [

                        'nom' => 'required|unique:clients',
                        'adress' => 'required',
                        'email' => 'required',
                        'tel' => 'required',
                    ]);
                }
                if ($request->nom == $client->nom && $request->email != $client->email) {
                    $validator = Validator::make($request->all(), [

                        'nom' => 'required',
                        'adress' => 'required',
                        'email' => 'required|unique:clientusers',
                        'tel' => 'required',
                    ]);
                }
            }
        }

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }



        $userclient = Clientuser::withTrashed()
            ->where('email', '=', $request->email)->first();
        $temp = explode("@", $request->email);
        $userclient->name = $temp[0];
        $userclient->email = $request->email;
        $userclient->save();

        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->tel = $request->tel;
        $client->adress = $request->adress;

        $departement = Client::withTrashed()
            ->where('client_id', '=', $client->id)->first();
        $departement->email = "dep_" . $request->email;
        $departement->tel = $request->tel;
        $departement->save();

        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs(
                'clients',
                $client->id . "_" . $image
            );
            $client->photo = $path;
            $client->save();
            // copy('/home/marocnst/public_html/storage/app/public/'.$path, '/home/marocnst/public_html/public/storage/'.$path);

        } else {
            $client->photo = "clients/placeholder.jpg";
            $client->save();
            // copy('/home/marocnst/public_html/storage/app/public/clients/placeholder.jpg', '/home/marocnst/public_html/public/storage/clients/placeholder.jpg');

        }



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
            'client' => $client,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function store_client(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'nom' => 'required|unique:clients',
            'adress' => 'required',
            'email' => 'required|unique:clientusers',
            'tel' => 'required',
            'password' => 'required|min:8',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }


        $client = new Client();
        $client->nom = $request->nom;
        $client->email = $request->email;
        $client->tel = $request->tel;
        $client->adress = $request->adress;
        $client->save();

        $user = new Clientuser();
        $temp = explode("@", $request->email);
        $user->name = $temp[0];
        $user->prénom = $temp[0];
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 4;
        $user->created_by = $client->id;
        $user->clientable_id = $client->id;
        $user->clientable_type = "client";
        $user->save();

        $departement = new Departement();
        $departement->nom = "Departement global";
        $departement->email = "dep_" . $request->email;
        $departement->tel = $request->tel;
        $departement->client_id = $client->id;
        $departement->save();



        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs(
                'clients',
                $client->id . "_" . $image
            );
            $client->photo = $path;
            $client->save();
            // copy('/home/marocnst/public_html/storage/app/public/'.$path, '/home/marocnst/public_html/public/storage/'.$path);

        } else {
            $client->photo = "clients/placeholder.jpg";
            $client->save();
            // copy('/home/marocnst/public_html/storage/app/public/clients/placeholder.jpg', '/home/marocnst/public_html/public/storage/clients/placeholder.jpg');

        }

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
            'client' => $client,
            'inputs' => $request->all(),
            'departement' => $departement
        ];
        return response()->json($objet);
    }

    // departement functions

    public function all_departements($id_c)
    {
        $departements = null;
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        switch ($auth->role_id) {
            case 5:
                $departements = DB::table('departements')
                    ->leftJoin('agences', 'agences.departement_id', '=', 'departements.id')
                    ->select('departements.*')->where([
                        ['departements.deleted_at', '=', null],
                        ['agences.id', '=', $auth->clientable_id]
                    ])->get();
                break;

            default:
                $departements = Departement::withTrashed()
                    ->where('client_id', $id_c)
                    ->get();
                break;
        }

        // $chefs = array();
        // foreach ($departements as $departement) {
        //     $chefs[] = Clientuser::where([
        //         ['clientable_id', '=', $departement->id],
        //         ['clientable_type', "=", "departement"],
        //     ])
        //         ->first();
        // }
        $objet =  [
            'departements' => $departements,
            //'chefs' => $chefs,

        ];
        return response()->json($objet);
    }

    public function filter_all_departements($id_c, Request $request)
    {


        $filters = array();
        $filters[] = ['client_id', $id_c];
        $departements = null;
        $request->departement_id == "0" ? $filters[] = ['id', '<>', 0] :  $filters[] = ['id', '=', $request->departement_id];


        if ($request->is_all == "true") {
            $departements = Departement::where($filters)->withTrashed()->get();
        } else {

            $request->is_deleted == 'true' ?  $departements = Departement::onlyTrashed()->where($filters)->get() : $departements = Departement::where($filters)->get();
        }



        // $chefs = array();
        // foreach ($departements as $departement) {
        //     $chefs[] = Clientuser::where([
        //         ['clientable_id', '=', $departement->id],
        //         ['clientable_type', "=", "departement"],
        //     ])
        //         ->first();
        // }
        $objet =  [
            'departements' => $departements,
            //'chefs' => $chefs,

        ];
        return response()->json($objet);
    }

    // public function affecter(Request $request, $id_c)
    // {
    //     if ($request->current_u != 0) {
    //         $current_user =  Clientuser::where('id', $request->current_u)
    //             ->first();

    //         $current_user->clientable_id = null;
    //         $current_user->clientable_type = null;
    //         $current_user->is_affected = false;
    //         $current_user->save();
    //     }



    //     $user = Clientuser::where('id', $request->id_u)
    //         ->first();

    //     $user->clientable_id = $request->id_d;
    //     $user->clientable_type = "departement";
    //     $user->is_affected = true;
    //     $user->save();

    //     $departement = Departement::withTrashed()
    //         ->where('id', $request->id_d)
    //         ->first();

    //     $objet =  [
    //         'departement' => $departement,
    //         'chef' => $user,

    //     ];
    //     return response()->json($objet);
    // }

    public function delete_departement($id_c, $id)
    {

        $done = false;

        $temp = Departement::find($id);
        $temp->delete();
        $done = true;


        $departement = Departement::withTrashed()
            ->where('id', $id)
            ->first();

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $departement->id],
        //     ['clientable_type', "=", "departement"],
        // ])
        //     ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            // 'chef' => $chef,
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

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $departement->id],
        //     ['clientable_type', "=", "departement"],
        // ])
        //     ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            // 'chef' => $chef,
        ];
        return response()->json($objet);
    }

    public function edit_departement(Request $request, $id_c, $id)
    {
        $done = false;



        $departement = Departement::withTrashed()
            ->where('id', $id)
            ->first();


        $validator = Validator::make($request->all(), [

            'nom' => 'required',
            'email' => 'required',
            'tel' => 'required',

        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }


        $departement->nom = $request->nom;
        $departement->email = $request->email;
        $departement->tel = $request->tel;
        $departement->save();
        $done = true;

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $departement->id],
        //     ['clientable_type', "=", "departement"],
        // ])
        //     ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'departement' => $departement,
            //'chef' => $chef,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function store_departement(Request $request, $id_c)
    {


        $validator = Validator::make($request->all(), [

            'nom' => 'required',
            'email' => 'required',
            'tel' => 'required',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }
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
            'departement' => $departement,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function all_agences($id_c, $id_d)
    {
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        $agences = null;
        switch ($auth->role_id) {
            case 5:
                $agences = Agence::where('id', '=', $auth->clientable_id)
                    ->get();
                break;

            default:
                $agences = Agence::withTrashed()
                    ->where('departement_id', '=', $id_d)
                    ->get();
                break;
        }



           $chefs = array();
        $villes = array();
        $souscriptions = array();
        foreach ($agences as $agence) {
            $chefs[] = Clientuser::where([
                ['clientable_id', '=', $agence->id],
                ['clientable_type', "=", "agence"],
            ])->first();
            $villes[] = $agence->ville;

            $souscriptions[] = [
                'id' => $agence->id,
                'produits'  => DB::table('views_detail_souscription')
                    ->select('prod_id', 'prod_nom', 'prod_etat')
                    ->groupBy('prod_id', 'prod_etat')
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

    public function filter_all_agences($id_c, $id_d, Request $request)
    {


        $filters = array();
        $filters[] = ['departement_id', '=', $id_d];
        $agences = null;
        $request->agence_id == "0" ? $filters[] = ['id', '<>', 0] :  $filters[] = ['id', '=', $request->agence_id];

        if ($request->ville_id != "0") {
            $filters[] = ['ville_id', '=', $request->ville_id];
        }
        if ($request->is_all == "true") {
            $agences = Agence::where($filters)->withTrashed()->get();
        } else {

            $request->is_deleted == 'true' ?  $agences = Agence::onlyTrashed()->where($filters)->get() : $agences = Agence::where($filters)->get();
        }

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
                    ->select('prod_id', 'prod_nom', 'prod_etat')
                    ->groupBy('prod_id', 'prod_etat')
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




    public function delete_agence($id_c, $id_d, $id)
    {

        $done = false;

        $temp = Agence::find($id);
        $userclient = Clientuser::where('email', '=', $temp->email)->first();
        // return response()->json($userclient);
        $temp->delete();
        $userclient->delete();
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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }
    public function restore_agence($id_c, $id_d, $id)
    {

        $done = false;

        $temp =  Agence::withTrashed()
            ->where('id', $id)
            ->first();
        $userclient = Clientuser::withTrashed()
            ->where('email', '=', $temp->email)->first();
        $temp->restore();
        $userclient->restore();
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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville
        ];
        return response()->json($objet);
    }

    public function edit_agence(Request $request, $id_c, $id_d, $id)
    {
        $done = false;

        $agence = Agence::withTrashed()
            ->where('id', $id)
            ->first();

        $validator;
        if (count(explode('@', $request->email)) < 2) {
            $request->email = $request->email . '@gmail.com';
        }
        if ($request->filled('email') &&  $request->email == $agence->email) {
            $validator = Validator::make($request->all(), [

                'nom' => 'required',
                'adress' => 'required',
                'email' => 'required',
                'tel' => 'required',
                'ville' => 'required|gt:0',
            ]);
        } else {

            $validator = Validator::make($request->all(), [

                'nom' => 'required',
                'adress' => 'required',
                'email' => 'required|unique:clientusers',
                'tel' => 'required',
                'ville' => 'required|gt:0',
            ]);
        }



        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }

        $agence->nom = $request->nom;
        $agence->email = $request->email;

        $userclient = Clientuser::withTrashed()
            ->where('email', '=', $request->email)->first();
        $temp = explode("@", $request->email);
        $userclient->name = $temp[0];
        $userclient->email = $request->email;
        $userclient->save();

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
            'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function store_agence(Request $request, $id_c, $id_d)
    {
        if (count(explode('@', $request->email)) < 2) {
            $request->email = $request->email . '@gmail.com';
        }

        $validator = Validator::make($request->all(), [

            'client' => 'required|gt:0',
            'nom' => 'required',
            'email' => 'required|unique:clientusers|regex:/^\S*$/u',
            'tel' => 'required',
            'adress' => 'required',
            'ville' => 'required|gt:0',
            'password' => 'required|min:8',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }

        $agence = new Agence();
        $agence->departement_id = $id_d;
        $agence->nom = $request->nom;
        $agence->email = $request->email;
        $agence->tel = $request->tel;
        $agence->adress = $request->adress;
        $agence->ville_id = $request->ville;
        $agence->save();

        $user = new Clientuser();
        $temp = explode("@", $request->email);
        $user->name = $temp[0];
        $user->prénom = $temp[0];
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 5;
        $user->created_by = $id_c;
        $user->clientable_id = $agence->id;
        $user->clientable_type = "agence";
        $user->save();


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
            'chef' => $user,
            'ville' => $agence->ville,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }
    // public function affecter_agence(Request $request, $id_c, $id_d)
    // {
    //     if ($request->current_u != 0) {
    //         $current_user =  Clientuser::where('id', $request->current_u)
    //             ->first();

    //         $current_user->clientable_id = null;
    //         $current_user->clientable_type = null;
    //         $current_user->is_affected = false;
    //         $current_user->save();
    //     }



    //     $user = Clientuser::where('id', $request->id_u)
    //         ->first();

    //     $user->clientable_id = $request->id_a;
    //     $user->clientable_type = "agence";
    //     $user->is_affected = true;
    //     $user->save();

    //     $agence = Agence::withTrashed()
    //         ->where('id', $request->id_a)
    //         ->first();

    //     $souscription = [
    //         'id' => $agence->id,
    //         'produits'  => DB::table('views_detail_souscription')
    //             ->select('prod_id', 'prod_nom', 'prod_etat')
    //             ->groupBy('prod_id', 'prod_etat')
    //             ->where('agence_id', $agence->id)
    //             ->get()

    //     ];

    //     $objet =  [
    //         'agence' => $agence,
    //         'chef' => $user,
    //         'souscription' => $souscription,
    //         'ville' => $agence->ville

    //     ];
    //     return response()->json($objet);
    // }
}
