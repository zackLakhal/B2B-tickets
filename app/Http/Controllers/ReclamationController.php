<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reclamation;
use App\Client;
use App\Nstuser;
use App\Affectation;
use Illuminate\Support\Facades\DB;
use App\Raport;
use DateTime;
class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('raports', 'affectations.id', '=', 'raports.affectation_id')
            ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
            ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
            ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
            ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
            ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
            ->leftJoin('clients', 'departements.client_id', '=', 'clients.id')
            // ->leftJoin('clientusers', 'agences.id', '=', 'clientusers.clientable_id')
            ->select(
                'reclamations.id as reclamation_id',
                'reclamations.ref as reclamation_ref',
                'reclamations.commentaire as reclam_commentaire',
                'reclamations.created_at',
                'reclamations.checked_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'raports.pv as pv_image',
                'raports.with_pv as with_pv',
                //    'clientusers.nom as chef_nom',
                //     'clientusers.prénom as chef_prenom',
                //      'clientusers.email as chef_email',
                //       'clientusers.photo as chef_photo',
                //        'clientusers.tel as chef_tel',
                'nstusers.nom as tech_nom',
                'nstusers.prénom as tech_prenom',
                'nstusers.email as tech_email',
                'nstusers.photo as tech_photo',
                'nstusers.tel as tech_tel',
                'nstusers.adress as tech_adress',
                'souscriptions.id as ref_id',
                'souscriptions.equip_ref as equip_ref',
                'produits.nom as prod_nom',
                'equipements.nom as equip_nom',
                'agences.nom as agence_nom',
                'departements.nom as depart_nom',
                'clients.nom as client_nom'
            )
            ->groupBy('reclamations.id')
            ->orderBy('reclamation_ref', 'desc')->get();

        return response()->json($reclamations);
    }

    public function agence_dash()
    {

        $clients = array();
        $clienttemps = Client::all();
 

        foreach ($clienttemps as $key => $clienttemp) {
            $agences = array();

            $temps = DB::table('agences')
            ->leftJoin('souscriptions', 'agences.id', '=', 'souscriptions.agence_id')
              ->leftJoin('reclamations', 'souscriptions.id', '=', 'reclamations.souscription_id')
            ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
            ->select(
                'reclamations.ref as reclamation_ref',
                'agences.nom as agence_nom',
                'agences.id as agence_id',
                'departements.client_id as client_id',
            )->where('departements.client_id' ,'=',$clienttemp->id)
            ->groupBy('agences.id')
            ->orderBy('reclamation_ref', 'desc')->get();

            foreach ($temps as $key => $temp) {
                $agences[] = [
                    'agence' => $temp,
                    'reclamations' => DB::table('reclamations')
                    ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
                    ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
                    ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
                    ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
                    ->select(
                         
                        'reclamations.ref as reclamation_ref',
                        'reclamations.created_at',
                        'etats.id as etat_id',
                        'etats.value as etat',
                        'agences.nom as agence_nom',
                        'agences.id as agence_id',
                        'departements.client_id as client_id',
                    )->where([
                        ['agences.id' ,'=',$temp->agence_id],
                        ['etats.id','<>'  , 3],
                    ]) ->groupBy('reclamations.id')
                    ->orderBy('reclamation_ref', 'desc')->get()
                ];
            }

            $clients[] = [
                'client' => $clienttemp,
                'agences'=> $agences 
            ];
        }

        return response()->json($clients);


    }
    public function get_techniciens()
    {
        $techniciens = array();
        $technicientemps = Nstuser::where('role_id',3)->get();
        foreach ($technicientemps as $technicientemp) {
            $techniciens[] = [
                'user' => $technicientemp,
                'nb_affect' => DB::table('affectations')
                ->leftJoin('reclamations', 'reclamations.id', '=', 'affectations.reclamation_id')
                ->select('affectations.id')->where([
                    ['reclamations.etat_id','<>',3],
                    ['affectations.nstuser_id','=',$technicientemp->id]
                ])->count()
            ];
        }
        return response()->json($techniciens);
    }

    public function set_techniciens(Request $request)
    {
        $rec = Reclamation::where('ref',$request->ref)->first();

        $affect = new Affectation();
        $affect->reclamation_id = $rec->id;
        $affect->nstuser_id = $request->id_u;
        $affect->save();
      
        $reclamation = DB::table('reclamations')
        ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
        ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
        ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
        ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
        ->leftJoin('raports', 'affectations.id', '=', 'raports.affectation_id')
        ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
        ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
        ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
        ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
        ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
        ->leftJoin('clients', 'departements.client_id', '=', 'clients.id')
        ->select(
            'reclamations.id as reclamation_id',
            'reclamations.ref as reclamation_ref',
            'reclamations.commentaire as reclam_commentaire',
            'reclamations.created_at',
            'reclamations.checked_at',
            'reclamations.finished_at',
            'anomalies.value as anomalie',
            'etats.value as etat',
            'etats.id as etat_id',
            'affectations.id as affectation_id',
            'affectations.accepted',
            'raports.pv as pv_image',
            'raports.with_pv as with_pv',
            'nstusers.nom as tech_nom',
            'nstusers.prénom as tech_prenom',
            'nstusers.email as tech_email',
            'nstusers.photo as tech_photo',
            'nstusers.tel as tech_tel',
            'nstusers.adress as tech_adress',
            'souscriptions.id as ref_id',
            'souscriptions.equip_ref as equip_ref',
            'produits.nom as prod_nom',
            'equipements.nom as equip_nom',
            'agences.nom as agence_nom',
            'departements.nom as depart_nom',
            'clients.nom as client_nom'
        )->where('reclamations.ref','=',$request->ref)
        ->groupBy('reclamations.id')->first();

    return response()->json($reclamation);
    }

    public function accepter(Request $request)
    {
       
        $rec = Reclamation::where('ref',$request->ref)->first();

        $affect = Affectation::where('reclamation_id',$rec->id)->first();
        $affect->accepted = true;
        $affect->save();

        $rec->etat_id = 2;
        $rec->checked_at = date('Y-m-d H:i:s');
        $rec->save();
      
        $reclamation = DB::table('reclamations')
        ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
        ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
        ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
        ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
        ->leftJoin('raports', 'affectations.id', '=', 'raports.affectation_id')
        ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
        ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
        ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
        ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
        ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
        ->leftJoin('clients', 'departements.client_id', '=', 'clients.id')
        ->select(
            'reclamations.id as reclamation_id',
            'reclamations.ref as reclamation_ref',
            'reclamations.commentaire as reclam_commentaire',
            'reclamations.created_at',
            'reclamations.checked_at',
            'reclamations.finished_at',
            'anomalies.value as anomalie',
            'etats.value as etat',
            'etats.id as etat_id',
            'affectations.id as affectation_id',
            'affectations.accepted',
            'raports.pv as pv_image',
            'raports.with_pv as with_pv',
            'nstusers.nom as tech_nom',
            'nstusers.prénom as tech_prenom',
            'nstusers.email as tech_email',
            'nstusers.photo as tech_photo',
            'nstusers.tel as tech_tel',
            'nstusers.adress as tech_adress',
            'souscriptions.id as ref_id',
            'souscriptions.equip_ref as equip_ref',
            'produits.nom as prod_nom',
            'equipements.nom as equip_nom',
            'agences.nom as agence_nom',
            'departements.nom as depart_nom',
            'clients.nom as client_nom'
        )->where('reclamations.ref','=',$request->ref)
        ->groupBy('reclamations.id')->first();

    return response()->json($reclamation);
    }

    public function save_raport(Request $request)
    {
       
        $rec = Reclamation::where('ref',$request->ref)->first();
        $affect = Affectation::where('reclamation_id',$rec->id)->first();
        
        $rapport = new Raport();
        $rapport->ref = $rec->ref;
        $rapport->affectation_id = $affect->id;
        $rapport->type = $request->type;
        $request->with_pv == 'true' ? $rapport->with_pv = true : $rapport->with_pv = false ;
        $request->filled('commentaire') == true ? $rapport->commentaire = $request->commentaire : $rapport->commentaire = "" ;
        
        if ($request->with_pv == 'true' && $request->file('pv_image')) {
            $file = $request->file('pv_image');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('pv_image')->storeAs(
                'pvs',
                $rec->id . "_" . $image
            );
            $rapport->pv = $path;
        } 
        $rapport->save();



        $rec->etat_id = 3;
        $rec->finished_at = date('Y-m-d H:i:s');
        $rec->save();
      
        $reclamation = DB::table('reclamations')
        ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
        ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
        ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
        ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
        ->leftJoin('raports', 'affectations.id', '=', 'raports.affectation_id')
        ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
        ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
        ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
        ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
        ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
        ->leftJoin('clients', 'departements.client_id', '=', 'clients.id')
        ->select(
            'reclamations.id as reclamation_id',
            'reclamations.ref as reclamation_ref',
            'reclamations.commentaire as reclam_commentaire',
            'reclamations.created_at',
            'reclamations.checked_at',
            'reclamations.finished_at',
            'anomalies.value as anomalie',
            'etats.value as etat',
            'etats.id as etat_id',
            'affectations.id as affectation_id',
            'affectations.accepted',
            'raports.pv as pv_image',
            'raports.with_pv as with_pv',
            'nstusers.nom as tech_nom',
            'nstusers.prénom as tech_prenom',
            'nstusers.email as tech_email',
            'nstusers.photo as tech_photo',
            'nstusers.tel as tech_tel',
            'nstusers.adress as tech_adress',
            'souscriptions.id as ref_id',
            'souscriptions.equip_ref as equip_ref',
            'produits.nom as prod_nom',
            'equipements.nom as equip_nom',
            'agences.nom as agence_nom',
            'departements.nom as depart_nom',
            'clients.nom as client_nom'
        )->where('reclamations.ref','=',$request->ref)
        ->groupBy('reclamations.id')->first();

    return response()->json($reclamation);
    }
}
