<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reclamation;
use Illuminate\Support\Facades\DB;
class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = DB::table('reclamations')
        ->leftJoin('anomalies', 'reclamations.anomalie_id', '=', 'anomalies.id')
        ->leftJoin('etats', 'reclamations.etat_id', '=', 'etats.id')
        ->leftJoin('affectations', 'reclamations.id', '=', 'affectations.reclamation_id')
        ->leftJoin('nstusers', 'affectations.nstuser_id', '=', 'nstusers.id')
        ->leftJoin('pvs', 'affectations.id', '=', 'pvs.affectation_id')
        ->leftJoin('souscriptions', 'reclamations.souscription_id', '=', 'souscriptions.id')
        ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
        ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
        ->leftJoin('agences', 'souscriptions.agence_id', '=', 'agences.id')
        ->leftJoin('departements', 'agences.departement_id', '=', 'departements.id')
        ->leftJoin('clients', 'departements.client_id', '=', 'clients.id')
        ->leftJoin('clientusers', 'agences.id', '=', 'clientusers.clientable_id')
        ->select('reclamations.id as reclamation_id',
        'reclamations.ref as reclamation_ref',
         'reclamations.commentaire as reclam_commentaire',
          'reclamations.checked_at',
           'reclamations.finished_at',
           'anomalies.value as anomalie',
            'etats.value as etat', 
             'affectations.accepted',
              'pvs.image as pv_image',
               'clientusers.nom as chef_nom',
                'clientusers.prénom as chef_prenom',
                 'clientusers.email as chef_email',
                  'clientusers.photo as chef_photo',
                   'clientusers.tel as chef_tel',
                    'nstusers.nom as tech_nom',
                     'nstusers.prénom as tech_prenom',
                      'nstusers.email as tech_email',
                       'nstusers.photo as tech_photo',
                        'nstusers.tel as tech_tel',
                         'souscriptions.id as ref_id',
                          'souscriptions.equip_ref as equip_ref',
                           'produits.nom as prod_nom',
                            'equipements.nom as equip_nom',
                             'agences.nom as agence_nom',
                              'departements.nom as depart_nom',
                              'clients.nom as client_nom')
        ->groupBy('reclamations.id')
        ->orderBy('reclamation_ref', 'desc')->get();
       
        return response()->json($reclamations);
    }
}
