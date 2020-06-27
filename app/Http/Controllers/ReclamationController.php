<?php

namespace App\Http\Controllers;

use App\Agence;
use App\Anomalie;
use Illuminate\Http\Request;
use App\Reclamation;
use App\Client;
use App\Departement;
use App\Equipement;
use App\Exports\PvsExport;
use App\Produit;
use App\Souscription;
use Maatwebsite\Excel\Facades\Excel;
use mikehaertl\wkhtmlto\Pdf;
use App\Nstuser;
use App\Affectation;
use App\Clientuser;
use App\Closed;
use App\Pending;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Zipper;
class ReclamationController extends Controller
{
    public function index()
    {
        $where = null;
        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        switch ($auth->role_id) {
            case 3:
                $where = ['nstusers.id', '=', $auth->id];
                break;
            case 4:
                $where = ['clients.id', '=', $auth->created_by];
                break;
            case 5:
                $where = ['agences.id', '=', $auth->clientable_id];
                break;
            default:
                $where = ['reclamations.id', '<>', '0'];
                break;
        }
        $reclamations = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where([$where])
            ->groupBy('reclamations.id')
            ->orderBy('reclamation_ref', 'desc')->get();

        return response()->json($reclamations);
    }

    public function agence_dash(Request $request)
    {

        $clienttemps = null;
        $clientwhere = array();


        $user = intval($request->role_id) == 4 || intval($request->role_id) == 5 ? Clientuser::find(intval($request->id)) : Nstuser::find(intval($request->id));
        // return response()->json($request->all());
        $agencewhere = [['etats.id', '<>', intval($request->is_agence)]];
        switch ($user->role_id) {
            case 3:
                $clientwhere[1] = ['affectations.nstuser_id', '=', $user->id];
                $agencewhere[2] = ['affectations.nstuser_id', '=', $user->id];
                $clienttemps = Client::all();
                break;
            case 4:
                $clienttemps = Client::where('id', $user->created_by)->get();
                break;
            case 5:
                $clienttemps = Client::where('id', $user->created_by)->get();
                $clientwhere[1] = ['agences.id', '=', $user->clientable_id];
                $agencewhere[2] = ['agences.id', '=', $user->clientable_id];
                break;
            default:
                $clienttemps = Client::all();
                break;
        }

        $clients = array();

        foreach ($clienttemps as $key => $clienttemp) {
            $agences = array();
            $clientwhere[0] = ['departements.client_id', '=', $clienttemp->id];
            $temps = DB::table('agences')
                ->leftJoin('souscriptions', 'agences.id', '=', 'souscriptions.agence_id')
                ->leftJoin('reclamations', 'souscriptions.id', '=', 'reclamations.souscription_id')
                ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
                ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
                ->select(
                    'reclamations.ref as reclamation_ref',
                    'agences.nom as agence_nom',
                    'agences.id as agence_id',
                    'departements.client_id as client_id',
                )->where($clientwhere)
                ->groupBy('agences.id')
                ->orderBy('reclamation_ref', 'desc')->get();

            foreach ($temps as $key => $temp) {
                $agencewhere[1] = ['agences.id', '=', $temp->agence_id];
                $agences[] = [
                    'agence' => $temp,
                    'reclamations' => DB::table('reclamations')
                        ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
                        ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
                        ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
                        ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                        ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
                        ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
                        ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
                        ->select(

                            'reclamations.ref as reclamation_ref',
                            'reclamations.created_at',
                            'etats.id as etat_id',
                            'etats.value as etat',
                            'anomalies.value as anomalie',
                            'produits.nom as prod_nom',
                            'agences.nom as agence_nom',
                            'agences.id as agence_id',
                            'departements.client_id as client_id',
                        )->where($agencewhere)->groupBy('reclamations.id')
                        ->orderBy('reclamation_ref', 'desc')->get()
                ];
            }
            $clients[] = [
                'client' => $clienttemp,
                'agences' => $agences
            ];
        }

        return response()->json($clients);
    }


    public function get_techniciens($us_id)
    {

        $techniciens = array();
        $technicientemps = null;

        if ($us_id  == -1) {

            $technicientemps = Nstuser::where('role_id', 3)->get();
        } else {
            $technicientemps = Nstuser::where([
                ['role_id', 3],
                ['id', '<>', $us_id]
            ])->get();
        }

        foreach ($technicientemps as $technicientemp) {
            $techniciens[] = [
                'user' => $technicientemp,
                'nb_affect' => DB::table('affectations')
                    ->leftJoin('reclamations', 'reclamations.id', '=', 'affectations.reclamation_id')
                    ->leftJoin('etats', 'etats.id', '=', 'reclamations.etat_id')
                    ->select('reclamations.etat_id', DB::raw('count(reclamations.id) as nb'))->where([
                        ['reclamations.etat_id', '<>', 3],
                        ['affectations.nstuser_id', '=', $technicientemp->id]
                    ])->groupBy('reclamations.etat_id')->get()
            ];
        }
        return response()->json($techniciens);
    }



    public function set_techniciens(Request $request)
    {

        $rec = Reclamation::where('ref', $request->ref)->first();
        $affect = null;
        if ($request->old == -1) {
            $affect = new Affectation();
            $affect->reclamation_id = $rec->id;
        } else {
            $affect = Affectation::where('reclamation_id', $rec->id)->first();
            $affect->accepted = false;
        }

        $affect->nstuser_id = $request->id_u;
        $affect->save();

        $reclamation = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where('reclamations.ref', '=', $request->ref)
            ->groupBy('reclamations.id')->first();

        return response()->json($reclamation);
    }

    public function accepter(Request $request)
    {

        $rec = Reclamation::where('ref', $request->ref)->first();

        $affect = Affectation::where('reclamation_id', $rec->id)->first();
        $affect->accepted = true;
        $affect->accepted_at = date('Y-m-d H:i:s');
        $affect->save();

        $reclamation = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where('reclamations.ref', '=', $request->ref)
            ->groupBy('reclamations.id')->first();

        return response()->json($reclamation);
    }

    public function save_raport(Request $request)
    {

        $rec = Reclamation::where('ref', $request->ref)->first();
        $affect = Affectation::where('reclamation_id', $rec->id)->first();

        $rapport = null;
        $folder = "";
        if ($request->etat_id == 2) {
            $rapport =  new Pending();
            $folder = "pending_pvs";
            $rec->etat_id = 2;
            $rec->checked_at = date('Y-m-d H:i:s');
        } else {
            $rapport = new Closed();
            $folder = "closed_pvs";
            $rec->etat_id = 3;
            $rec->finished_at = date('Y-m-d H:i:s');
        }
        $rec->save();


        $rapport->ref = $rec->ref;
        $rapport->affectation_id = $affect->id;
        if ($request->etat_id == 3) {
            $rapport->type = $request->type;
        }
        $request->with_pv == 'true' ? $rapport->with_pv = true : $rapport->with_pv = false;
        $request->filled('commentaire') == true ? $rapport->commentaire = $request->commentaire : $rapport->commentaire = "";

        if ($request->with_pv == 'true' && $request->file('pv_image')) {
            $file = $request->file('pv_image');
            $image = $rec->ref . '.' . $file->getClientOriginalExtension();
            $path = $request->file('pv_image')->storeAs(
                $folder,
                $rec->id . "_" . $image
            );
            $rapport->pv = $path;
            // copy('/home/marocnst/public_html/storage/app/public/'.$path, '/home/marocnst/public_html/public/storage/'.$path);


        }
        $rapport->save();



        $reclamation = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where('reclamations.ref', '=', $request->ref)
            ->groupBy('reclamations.id')->first();

        return response()->json($reclamation);
    }

    public function get_reclamation(Request $request)
    {

        $conditions = array();
        if ($request->type == 'ref') {
            $conditions[] = ['reclamations.ref', '=', $request->value];
        } else {
            $conditions[] = ['affectations.nstuser_id', '=', $request->value];
            $conditions[] = ['etats.id', '=', $request->type];
        }



        $reclamations = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where($conditions)
            ->groupBy('reclamations.id')->get();

        return response()->json($reclamations);
    }

    public function get_rapport(Request $request)
    {
        $rapport = null;
        $request->etat_id == 2 ? $rapport = Pending::where('ref', $request->ref)->first() : $rapport = Closed::where('ref', $request->ref)->first();
        return response()->json($rapport);
    }

    public function edit_raport(Request $request)
    {
        $rec = Reclamation::where('ref', $request->ref)->first();

        $rapport = null;
        $folder = "";
        if ($request->etat_id == 2) {
            $rapport =   Pending::find($request->rapport_id);
            $folder = "pending_pvs";
        } else {
            $rapport =  Closed::find($request->rapport_id);
            $folder = "closed_pvs";
        }

        if ($request->etat_id == 3) {
            $rapport->type = $request->type;
        }
        $request->with_pv == 'true' ? $rapport->with_pv = true : $rapport->with_pv = false;
        $request->filled('commentaire') == true ? $rapport->commentaire = $request->commentaire : $rapport->commentaire = "";

        if ($request->with_pv == 'true' && $request->file('pv_image')) {
            $file = $request->file('pv_image');
            $image = $rec->ref . '.' . $file->getClientOriginalExtension();
            $path = $request->file('pv_image')->storeAs(
                $folder,
                $rec->id . "_" . $image
            );
            $rapport->pv = $path;
            // copy('/home/marocnst/public_html/storage/app/public/'.$path, '/home/marocnst/public_html/public/storage/'.$path);

        }
        $rapport->save();



        $reclamation = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->where('reclamations.ref', '=', $request->ref)
            ->groupBy('reclamations.id')->first();

        return response()->json($reclamation);
    }

    public function filter_agence_dash(Request $request)
    {
        // return response()->json($request->all());

        $clients = array();
        $clienttemps = null;
        $request->id == "0" ? $clienttemps =  Client::all() : $clienttemps =  Client::where('id', $request->id)->get();




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
                )->where('departements.client_id', '=', $clienttemp->id)
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
                            ['agences.id', '=', $temp->agence_id],
                            ['etats.id', '<>', 3],
                        ])->groupBy('reclamations.id')
                        ->orderBy('reclamation_ref', 'desc')->get()
                ];
            }

            $clients[] = [
                'client' => $clienttemp,
                'agences' => $agences
            ];
        }

        return response()->json($clients);
    }

    public function fill_list()
    {

        // $data = array(
        //     'fv_client' => Client::withTrashed()->get(),
        //     'fv_departement'  => Departement::withTrashed()->get(),
        //     'fv_agence'  => Agence::withTrashed()->get(),
        //     'fv_produit' => Produit::withTrashed()->get(),
        //     'fv_equipement' => Equipement::all(),
        //     'fv_ref_equip' => Souscription::where('equip_ref', '<>', null)->get(),
        //    
        //     'auth' => (Auth::user()->role_id == 4 || Auth::user()->role_id == 5 ? Clientuser::find(Auth::user()->id) : Nstuser::find(Auth::user()->id))
        // );

        // return response()->json($data);
        // $auth = Auth::user()->role_id == 4 || Auth::user()->role_id == 5 ? Clientuser::find(Auth::user()->id) : Nstuser::find(Auth::user()->id);


        $ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip'];
        $input_values = array();



        $auth = null;
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        foreach ($ids as $id) {
            $input_values[$id] = 0;
        }
        if ($auth->role_id == 4) {
            $input_values['fv_client'] = $auth->created_by;
        }
        $tech = null;
        if ($auth->role_id == 3) {
            $tech = Nstuser::where('id', $auth->id)->get();
            $input_values['fv_tech'] = $auth->id;
        } else {
            $tech = Nstuser::where('role_id', 3)->get();
            $input_values['fv_tech'] = 0;
        }
        if ($auth->role_id == 5) {
            $agence = Agence::find($auth->clientable_id);
            $departement = Departement::find($agence->departement_id);
            $input_values['fv_agence'] = $agence->id;
            $input_values['fv_departement'] = $departement->id;
            $input_values['fv_client'] = $departement->client_id;
        }

        $clients = null;
        $client_ids = null;

        $departements = null;
        $departement_ids = null;

        $agences = null;
        $agence_ids = null;

        $produits = null;
        $produit_ids = null;

        $equipements = null;
        $equipement_ids = null;

        $ref_equips = null;

        $queryRef = " equip_ref IS NOT NULL  and  ";
        $paramsQuery = array();

        if ($input_values['fv_client'] == 0) {
            $clients =  DB::table('clients')->select('*')->get();
            $client_ids = DB::table('clients')->select('*')->pluck('id');
        } else {
            $clients =  DB::table('clients')->select('*')->where('id', '=', $input_values['fv_client'])->get();
            $client_ids = DB::table('clients')->select('*')->where('id', '=', $input_values['fv_client'])->pluck('id');
        }

        if ($input_values['fv_departement'] == 0) {
            $departements =  DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->pluck('id');
        } else {
            $departements =  DB::table('departements')->select('*')->where('id', '=', $input_values['fv_departement'])->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->where('id', '=', $input_values['fv_departement'])->whereIn('client_id', $client_ids)->pluck('id');
        }

        if ($input_values['fv_agence'] == 0) {
            $agences =  DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->pluck('id');
        } else {
            $agences =  DB::table('agences')->select('*')->where('id', '=', $input_values['fv_agence'])->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->where('id', '=', $input_values['fv_agence'])->whereIn('departement_id', $departement_ids)->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($agence_ids); $i++) {
            $i == count($agence_ids) - 1 ?  $ags = $ags . " " . $agence_ids[$i] : $ags = $ags . " " . $agence_ids[$i] . " , ";
        }
        array_push($paramsQuery, " agence_id IN (" . $ags . ") ");

        if ($input_values['fv_produit'] == 0) {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        } else {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->where('produits.id', '=', $input_values['fv_produit'])->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->where('produits.id', '=', $input_values['fv_produit'])->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($produit_ids); $i++) {
            $i == count($produit_ids) - 1 ?  $ags = $ags . " " . $produit_ids[$i] : $ags = $ags . " " . $produit_ids[$i] . " , ";
        }
        array_push($paramsQuery, " produit_id IN (" . $ags . ") ");

        if ($input_values['fv_equipement'] == 0) {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
        } else {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->where('equipements.id', '=', $input_values['fv_equipement'])->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->where('equipements.id', '=', $input_values['fv_equipement'])->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($equipement_ids); $i++) {
            $i == count($equipement_ids) - 1 ?  $ags = $ags . " " . $equipement_ids[$i] : $ags = $ags . " " . $equipement_ids[$i] . " , ";
        }
        array_push($paramsQuery, " equipement_id IN (" . $ags . ") ");

        if (count($paramsQuery) == 0) {
            $queryRef = substr($queryRef, 0, -5);
        } else {
            foreach ($paramsQuery as $filter) {
                $queryRef = $queryRef  . $filter . " And ";
            }
            $queryRef = substr($queryRef, 0, -4);
        }

        if (count($agence_ids) == 0 || count($equipement_ids) == 0 || count($produit_ids) == 0) {
            $ref_equips = [];
        } else {
            $ref_equips =  DB::table('souscriptions')->select('*')
                ->whereRaw($queryRef)
                ->groupBy('equip_ref')->get();
        }

        $data = array(
            'fv_client' => $clients,
            'fv_departement'  => $departements,
            'fv_agence'  => $agences,
            'fv_produit' => $produits,
            'fv_equipement' => $equipements,
            'fv_ref_equip' => $ref_equips,
            'fv_anomalie' => Anomalie::withTrashed()->get(),
            'fv_tech' => $tech,
            'inputs' => $input_values
        );

        return response()->json($data);
    }

    public function filter_data(Request $request)
    {

        $ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip'];
        $input_values = array();
        foreach ($ids as $id) {
            if ($request->input("check_" . $id) == "true") {
                $input_values[$id] = 0;
            } else {
                $input_values[$id] = $request->input($id);
            }
        }
        $clients = null;
        $client_ids = null;

        $departements = null;
        $departement_ids = null;

        $agences = null;
        $agence_ids = null;

        $produits = null;
        $produit_ids = null;

        $equipements = null;
        $equipement_ids = null;

        $ref_equips = null;

        $queryRef = " equip_ref IS NOT NULL  and  ";
        $paramsQuery = array();

        if ($input_values['fv_client'] == 0) {
            $clients =  DB::table('clients')->select('*')->get();
            $client_ids = DB::table('clients')->select('*')->pluck('id');
        } else {
            $clients =  DB::table('clients')->select('*')->where('id', '=', $request->fv_client)->get();
            $client_ids = DB::table('clients')->select('*')->where('id', '=', $request->fv_client)->pluck('id');
        }

        if ($input_values['fv_departement'] == 0) {
            $departements =  DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->pluck('id');
        } else {
            $departements =  DB::table('departements')->select('*')->where('id', '=', $request->fv_departement)->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->where('id', '=', $request->fv_departement)->whereIn('client_id', $client_ids)->pluck('id');
        }

        if ($input_values['fv_agence'] == 0) {
            $agences =  DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->pluck('id');
        } else {
            $agences =  DB::table('agences')->select('*')->where('id', '=', $request->fv_agence)->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->where('id', '=', $request->fv_agence)->whereIn('departement_id', $departement_ids)->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($agence_ids); $i++) {
            $i == count($agence_ids) - 1 ?  $ags = $ags . " " . $agence_ids[$i] : $ags = $ags . " " . $agence_ids[$i] . " , ";
        }
        array_push($paramsQuery, " agence_id IN (" . $ags . ") ");

        if ($input_values['fv_produit'] == 0) {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        } else {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->where('produits.id', '=', $request->fv_produit)->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->where('produits.id', '=', $request->fv_produit)->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($produit_ids); $i++) {
            $i == count($produit_ids) - 1 ?  $ags = $ags . " " . $produit_ids[$i] : $ags = $ags . " " . $produit_ids[$i] . " , ";
        }
        array_push($paramsQuery, " produit_id IN (" . $ags . ") ");

        if ($input_values['fv_equipement'] == 0) {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
        } else {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->where('equipements.id', '=', $request->fv_equipement)->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->where('equipements.id', '=', $request->fv_equipement)->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($equipement_ids); $i++) {
            $i == count($equipement_ids) - 1 ?  $ags = $ags . " " . $equipement_ids[$i] : $ags = $ags . " " . $equipement_ids[$i] . " , ";
        }
        array_push($paramsQuery, " equipement_id IN (" . $ags . ") ");

        if (count($paramsQuery) == 0) {
            $queryRef = substr($queryRef, 0, -5);
        } else {
            foreach ($paramsQuery as $filter) {
                $queryRef = $queryRef  . $filter . " And ";
            }
            $queryRef = substr($queryRef, 0, -4);
        }

        if (count($agence_ids) == 0 || count($equipement_ids) == 0 || count($produit_ids) == 0) {
            $ref_equips = [];
        } else {
            $ref_equips =  DB::table('souscriptions')->select('*')
                ->whereRaw($queryRef)
                ->groupBy('equip_ref')->get();
        }

        $data = array(
            'fv_client' => $clients,
            'fv_departement'  => $departements,
            'fv_agence'  => $agences,
            'fv_produit' => $produits,
            'fv_equipement' => $equipements,
            'fv_ref_equip' => $ref_equips,
            'inputs' => $input_values
        );

        return response()->json($data);
    }

    public function filter_index(Request $request)
    {
        $where = array();
        $having = array();

        // $ids = ['fv_reclamation','fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip', 'fv_anomalie', 'fv_tech'];
        // $dates = ['created', 'accepted', 'pending', 'closed'];
        // $date_types = ['year', 'mois', 'day'];
        array_push($having, " `reclamations`.`id` <> '0' ");
        if ($request->fv_reclamation != "0") {
            array_push($where, " `reclamations`.`id` =  '" . $request->fv_reclamation . "' ");
        } else {
            array_push($where, " `reclamations`.`id` <> '0' ");

            $request->fv_etat == null ?:  array_push($where, " `etats`.`id` IN  (" . $request->fv_etat . ") ");
            $request->fv_client == "0" ?:  array_push($where, " `clients`.`id` =  '" . $request->fv_client . "' ");
            $request->fv_departement == "0" ?:  array_push($where, " `departements`.`id` =  '" . $request->fv_departement . "' ");
            $request->fv_agence == "0" ?:  array_push($where, " `souscriptions`.`agence_id` =  '" . $request->fv_agence . "' ");
            $request->fv_produit == "0" ?:  array_push($where, " `souscriptions`.`produit_id` =  '" . $request->fv_produit . "' ");
            $request->fv_equipement == "0" ?:  array_push($where, " `souscriptions`.`equipement_id` =  '" . $request->fv_equipement . "' ");
            $request->fv_ref_equip == "0" ?:  array_push($where, " `souscriptions`.`equip_ref` =  '" . $request->fv_ref_equip . "' ");
            $request->fv_anomalie == "0" ?:  array_push($where, " `anomalies`.`id` =  '" . $request->fv_anomalie . " ");



            if (!($request->non_affected == "true" &&  $request->is_accepted == "false" && $request->is_pending == "false")) {

                $request->fv_tech == "0" ?:  array_push($where, " `nstusers`.`id` =  '" . $request->fv_tech . "' ");
            }
            if (!($request->non_affected == "true" &&  $request->is_accepted == "true" && $request->is_pending == "true") && !($request->non_affected == "false" &&  $request->is_accepted == "false" && $request->is_pending == "false")) {
                $temps = "";

                $QR = " ( ";
                $request->non_affected != "true" ?: $QR = $QR . "  `affectations`.`id` IS NULL OR  ";

                $request->is_pending != "true" ?: $temps = $temps . " 0 , ";
                $request->is_accepted != "true" ?: $temps = $temps . " 1 , ";

                $temps = $temps . " 2 ";



                array_push($where, $QR . " affectations.accepted IN (" . $temps . ") )");
            }

            if ($request->non_affected == "false" &&  $request->is_accepted == "false" && $request->is_pending == "false") {
                array_push($where, " ( `affectations`.`id` IS NULL OR affectations.accepted IN ( 0 , 1 ) )");
            }

            if ($request->fv_created == "true") {

                $mois_created_from = $request->input('mois_created_from');
                $mois_created_to = $request->input('mois_created_to');

                $year_created_from = $request->input('year_created_from');
                $year_created_to = $request->input('year_created_to');

                $day_created_from = $request->input('day_created_from');
                $day_created_to = $request->input('day_created_to');

                if ($year_created_from != $year_created_to) {
                    array_push($having, " (YEAR( reclamations.created_at ) BETWEEN '" . $year_created_from . "' AND '" . $year_created_to . "')  ");
                } else {
                    array_push($having, " (YEAR( reclamations.created_at ) = '" . $year_created_from . "')  ");
                }
                if ($mois_created_from != $mois_created_to) {
                    array_push($having, " (MONTH( reclamations.created_at ) BETWEEN '" . $mois_created_from . "' AND '" . $mois_created_to . "')  ");
                } else {
                    array_push($having, " (MONTH( reclamations.created_at ) = '" . $mois_created_from . "')  ");
                }
                if ($day_created_from != $day_created_to) {
                    array_push($having, " (DAY( reclamations.created_at ) BETWEEN '" . $day_created_from . "' AND '" . $day_created_to . "')  ");
                } else {
                    array_push($having, " (DAY( reclamations.created_at ) = '" . $day_created_from . "')  ");
                }
            }

            if ($request->fv_accepted == "true") {

                $mois_accepted_from = $request->input('mois_accepted_from');
                $mois_accepted_to = $request->input('mois_accepted_to');

                $year_accepted_from = $request->input('year_accepted_from');
                $year_accepted_to = $request->input('year_accepted_to');

                $day_accepted_from = $request->input('day_accepted_from');
                $day_accepted_to = $request->input('day_accepted_to');

                if ($year_accepted_from != $year_accepted_to) {
                    array_push($having, " (YEAR( affectations.accepted_at ) BETWEEN '" . $year_accepted_from . "' AND '" . $year_accepted_to . "')  ");
                } else {
                    array_push($having, " (YEAR( affectations.accepted_at ) = '" . $year_accepted_from . "')  ");
                }
                if ($mois_accepted_from != $mois_accepted_to) {
                    array_push($having, " (MONTH( affectations.accepted_at ) BETWEEN '" . $mois_accepted_from . "' AND '" . $mois_accepted_to . "')  ");
                } else {
                    array_push($having, " (MONTH( affectations.accepted_at ) = '" . $mois_accepted_from . "')  ");
                }
                if ($day_accepted_from != $day_accepted_to) {
                    array_push($having, " (DAY( affectations.accepted_at ) BETWEEN '" . $day_accepted_from . "' AND '" . $day_accepted_to . "')  ");
                } else {
                    array_push($having, " (DAY( affectations.accepted_at ) = '" . $day_accepted_from . "')  ");
                }
            }
            $check_pending = false;

            if ($request->fv_etat != null) {
                $temps = explode(",", $request->fv_etat);
                foreach ($temps as $temp) {
                    if ($temp == "2") {
                        $check_pending = true;
                        break;
                    }
                }
            }

            if ($check_pending == true && $request->fv_pending == "true") {

                $mois_pending_from = $request->input('mois_pending_from');
                $mois_pending_to = $request->input('mois_pending_to');

                $year_pending_from = $request->input('year_pending_from');
                $year_pending_to = $request->input('year_pending_to');

                $day_pending_from = $request->input('day_pending_from');
                $day_pending_to = $request->input('day_pending_to');

                if ($year_pending_from != $year_pending_to) {
                    array_push($having, " (YEAR( reclamations.checked_at ) BETWEEN '" . $year_pending_from . "' AND '" . $year_pending_to . "')  ");
                } else {
                    array_push($having, " (YEAR( reclamations.checked_at ) = '" . $year_pending_from . "')  ");
                }
                if ($mois_pending_from != $mois_pending_to) {
                    array_push($having, " (MONTH( reclamations.checked_at ) BETWEEN '" . $mois_pending_from . "' AND '" . $mois_pending_to . "')  ");
                } else {
                    array_push($having, " (MONTH( reclamations.checked_at ) = '" . $mois_pending_from . "')  ");
                }
                if ($day_pending_from != $day_pending_to) {
                    array_push($having, " (DAY( reclamations.checked_at ) BETWEEN '" . $day_pending_from . "' AND '" . $day_pending_to . "')  ");
                } else {
                    array_push($having, " (DAY( reclamations.checked_at ) = '" . $day_pending_from . "')  ");
                }
            }

            if ($request->fv_closed == "true") {

                $mois_closed_from = $request->input('mois_closed_from');
                $mois_closed_to = $request->input('mois_closed_to');

                $year_closed_from = $request->input('year_closed_from');
                $year_closed_to = $request->input('year_closed_to');

                $day_closed_from = $request->input('day_closed_from');
                $day_closed_to = $request->input('day_closed_to');

                if ($year_closed_from != $year_closed_to) {
                    array_push($having, " (YEAR( reclamations.finished_at ) BETWEEN '" . $year_closed_from . "' AND '" . $year_closed_to . "')  ");
                } else {
                    array_push($having, " (YEAR( reclamations.finished_at ) = '" . $year_closed_from . "')  ");
                }
                if ($mois_closed_from != $mois_closed_to) {
                    array_push($having, " (MONTH( reclamations.finished_at ) BETWEEN '" . $mois_closed_from . "' AND '" . $mois_closed_to . "')  ");
                } else {
                    array_push($having, " (MONTH( reclamations.finished_at ) = '" . $mois_closed_from . "')  ");
                }
                if ($day_closed_from != $day_closed_to) {
                    array_push($having, " (DAY( reclamations.finished_at ) BETWEEN '" . $day_closed_from . "' AND '" . $day_closed_to . "')  ");
                } else {
                    array_push($having, " (DAY( reclamations.finished_at ) = '" . $day_closed_from . "')  ");
                }
            }
        }

        $WhereQuery = "  ";

        if (count($where) != 0) {
            foreach ($where as $filter) {
                $WhereQuery = $WhereQuery  . $filter . " And ";
            }
            $WhereQuery = substr($WhereQuery, 0, -4);
        }



        $havingQuery = "";

        if (count($having) != 0) {
            foreach ($having as $filter) {
                $havingQuery = $havingQuery  . $filter . " And ";
            }
            $havingQuery = substr($havingQuery, 0, -4);
        }

        $reclamations = DB::table('reclamations')
            ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
            ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
            ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
            ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
            ->leftJoin('closeds', 'affectations.id', '=', 'closeds.affectation_id')
            ->leftJoin('pendings', 'affectations.id', '=', 'pendings.affectation_id')
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
                'reclamations.checked_at as pending_at',
                'reclamations.finished_at',
                'anomalies.value as anomalie',
                'etats.value as etat',
                'etats.id as etat_id',
                'affectations.id as affectation_id',
                'affectations.accepted',
                'affectations.accepted_at as accepted_at',
                'pendings.pv as pending_pv_image',
                'pendings.with_pv as pending_with_pv',
                'closeds.pv as closed_pv_image',
                'closeds.with_pv as closed_with_pv',
                'nstusers.id as tech_id',
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
            )->whereRaw($WhereQuery)
            ->groupBy('reclamations.id')
            ->havingRaw($havingQuery)->get();

        return response()->json($reclamations);
    }

    public function print()
    {
        // ['date' => $date,'iffac' => $iffac,'purcent'=>$purcent,'partner'=>$partner, 'details'=>$details , 'comission_partner'=>$comission_partner, 'prix_total'=>$prix_total, 'comission_demander'=>$comission_demander , 'quantitys'=>$quantitys]
        // return Excel::download(new PvsExport(), 'pvs.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        // return (new PvsExport)->download('invoices.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        // $path = 'http://127.0.0.1:8000/storage/pending_pvs/3_1592164489.jpg';
        // $type = pathinfo($path, PATHINFO_EXTENSION);
        // $data = file_get_contents($path);
        // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // $pdf = PDF::loadView('exports.pdf_pv', ['data' => $base64]);

        //  $pdf->save(storage_path().'_pvs.pdf');
        // return $pdf->download('pvs.pdf');

        // $pdf = new Pdf;

        // $pdf->addPage('<html><h2> Reclamation Ref : ilhbflhkcbdjhbf</h2>
        // <br><br>
        // <img src="'.$base64.'" alt="" width="100%" height="100%"></html>');

        // On some systems you may have to set the path to the wkhtmltopdf executable
        // $pdf->binary = 'C:\...';

        $headers = ["Content-Type"=>"application/zip"];
        $files = glob(public_path('storage\pending_pvs\*'));
        //dd($files);
        Zipper::make('storage\documents\mytest3.zip')->add($files)->close();
        return response()->download(public_path('storage\documents\mytest3.zip'),'mytest3.zip',$headers);


       
        
    }
}
