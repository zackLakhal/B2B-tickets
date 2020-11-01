<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Agence;
use App\Equipement;
use Illuminate\Support\Facades\DB;
use App\Clientuser;
use App\Anomalie;
use App\Client;
use App\Departement;
use App\Mailpend;
use App\Nstuser;
use App\Reclamation;
use App\Ville;
use Illuminate\Support\Facades\Auth;

class EspaceController extends Controller
{
    public function all_agences()
    {
        $agences = null;
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        switch ($auth->role_id) {

            case 4:
                $agences = DB::table('agences')
                    ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
                    ->select('agences.*', "departements.client_id")->where('departements.client_id', '=', $auth->clientable_id)->get();
                break;
            case 5:
                $agences = Agence::where('id', '=', $auth->clientable_id)->get();

                break;
            default:
                $agences = Agence::all();
                break;
        }

        $villes = array();
        $agence_clients = array();
        foreach ($agences as $agence) {

            $villes[] = Ville::find($agence->ville_id);
        }

        $clients = array();
        foreach ($agences as $agence) {
            $dep = Departement::find($agence->departement_id);
            $clients[$dep->id] = Client::find($dep->client_id);
            $agence_clients[] =  Client::find($dep->client_id);
        }


        $objet =  [
            'agences' => $agences,
            'villes' => $villes,
            'agence_clients' => $agence_clients,
            'clients' => $clients,
            'all_villes' => Ville::all()
        ];
        return response()->json($objet);
    }
    public function detail_agence($id)
    {

        $agence = Agence::find($id);
        $departement = $agence->departement;
        $client = $departement->client;

        $chef = Clientuser::where([
            ['clientable_id', '=', $agence->id],
            ['clientable_type', "=", "agence"],
        ])->first();

        $souscription = [
            'id' => $agence->id,
            'produits'  => DB::table('views_detail_souscription')
                ->leftJoin('produits', 'views_detail_souscription.prod_id', '=', 'produits.id')
                ->select('views_detail_souscription.prod_id', 'views_detail_souscription.prod_nom', 'produits.info', 'produits.image', 'views_detail_souscription.prod_etat')
                ->groupBy('prod_id', 'prod_etat')
                ->where('agence_id', $agence->id)
                ->get()

        ];


        $objet =  [
            'agence' => $agence,
            'souscription' => $souscription,
            'ville' => $agence->ville,
            'chef' => $chef,
            'departement' => $departement,
            'client' => $client
        ];
        return response()->json($objet);
    }

    public function get_equipements($id_a, $id_p)
    {

        $objet =  [
            'equipements' => DB::table('views_detail_souscription')
                ->leftJoin('equipements', 'views_detail_souscription.equip_id', '=', 'equipements.id')
                ->select('views_detail_souscription.ref_id', 'views_detail_souscription.equip_id', 'views_detail_souscription.ref', 'equipements.nom', 'equipements.modele', 'equipements.marque', 'equipements.info', 'equipements.image')
                ->where([
                    ['agence_id', $id_a],
                    ['prod_id',   $id_p],
                    ['ref', '<>',  NULL]
                ])->groupBy('equip_id')
                ->get()
        ];
        return response()->json($objet);
    }

    public function get_refs(Request $request, $id_a)
    {

        $objet = [
            'refs' =>  DB::table('views_detail_souscription')
                ->select('views_detail_souscription.ref_id', 'views_detail_souscription.equip_id', 'views_detail_souscription.ref', 'reclamations.etat_id')
                ->leftJoin('reclamations', 'views_detail_souscription.ref_id', '=', 'reclamations.souscription_id')
                ->where([
                    ['views_detail_souscription.agence_id', $id_a],
                    ['views_detail_souscription.prod_id',   $request->id_p],
                    ['views_detail_souscription.equip_id',   $request->id_e],
                    ['views_detail_souscription.ref', '<>',  NULL]
                ])->groupBy('views_detail_souscription.equip_id', 'views_detail_souscription.ref', 'views_detail_souscription.ref_id', 'reclamations.etat_id')
                ->get(),
            'anomalies' => Anomalie::all(),
            'equipement' => Equipement::find($request->id_e)

        ];

        return response()->json($objet);
    }

    public function add_reclamation(Request $request, $id_a)
    {
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        $validator = Validator::make($request->all(), [

            'ref' => 'required',
            'anomalie' => 'required',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }

        $agence = Agence::find($id_a);

        $reclamation = new Reclamation();

        $reclamation->clientuser_id = $agence->departement->client->id;
        $reclamation->souscription_id = $request->ref;
        $reclamation->anomalie_id = $request->anomalie;

        if ($request->filled('commentaire')) {
            $reclamation->commentaire = $request->commentaire;
        }

        $reclamation->save();

        $reclamation->ref = "" . date('Y') . "-R" . time() . "-" . $reclamation->id;
        $reclamation->save();
        $check="";
        if (is_null($reclamation)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $staff = "";
        $userstmp = Nstuser::whereIn('role_id', [1, 2])->get();
        $clientemp = Clientuser::where('created_by', $agence->departement->client->id)->first();

        foreach ($userstmp as $user) {
            $staff = $staff . "_" . $user->id;
        }
        $staff = "0" . $staff;


        $mail = new Mailpend();
        $mail->client = $clientemp->id;
        $mail->staff = $staff;
        $mail->reclamations = $reclamation->id;
        $mail->action = "created";
        $mail->save();

        $objet =  [
            'check' => $check,
            'reclamation' => $reclamation,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }
}
