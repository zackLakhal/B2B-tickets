<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Agence;
use App\Produit;
use App\Equipement;
use DB;
use App\Clientuser;
use App\Souscription;
use App\Anomalie;
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
                    ->select('agences.*')->where([
                        ['agences.deleted_at', '=', null],
                        ['departements.client_id', '=', $auth->clientable_id]
                    ])->get();
                break;
            case 5:
                $agences = Agence::where('id', '=', $auth->clientable_id)->get();

                break;
            default:
                $agences = Agence::all();
                break;
        }


        $villes = array();
        foreach ($agences as $agence) {

            $villes[] = Ville::find($agence->ville_id);
        }


        $objet =  [
            'agences' => $agences,
            'villes' => $villes

        ];
        return response()->json($objet);
    }
    public function detail_agence($id)
    {
        $agence = Agence::find($id);
        $departement = $agence->departement;
        $client = $departement->client;

        // $chef = Clientuser::where([
        //     ['clientable_id', '=', $agence->id],
        //     ['clientable_type', "=", "agence"],
        // ])->first();

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
            //'chef' => $chef,
            'souscription' => $souscription,
            'ville' => $agence->ville,
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
                ])->groupBy('views_detail_souscription.equip_id', 'views_detail_souscription.ref', 'views_detail_souscription.ref_id')
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

        $reclamation = new Reclamation();
        
        $reclamation->clientuser_id = $auth;
        $reclamation->souscription_id = $request->ref;
        $reclamation->anomalie_id = $request->anomalie;

        if ($request->filled('info_p')) {
            $reclamation->commentaire = $request->commentaire;
        }

        $reclamation->save();

        $reclamation->ref = "" . date('Y') . "-R" . time() . "-" . $reclamation->id;
        $reclamation->save();
        $check;
        if (is_null($reclamation)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'reclamation' => $reclamation,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }
}
