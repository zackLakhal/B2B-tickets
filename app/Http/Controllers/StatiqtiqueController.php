<?php

namespace App\Http\Controllers;

use App\Agence;
use App\Anomalie;
use Illuminate\Http\Request;
use App\Reclamation;
use App\Client;
use App\Departement;
use App\Equipement;
use App\Produit;
use App\Souscription;
use Illuminate\Support\Facades\DB;


class StatiqtiqueController extends Controller
{
    public function index()
    {

        $filtredQuery =   "select * ,
        avg( IF(checked_at IS NULL, TIMESTAMPDIFF(SECOND,created_at, finished_at) ,  TIMESTAMPDIFF(SECOND,created_at, checked_at))) AS avg_created_time,
        avg(TIMESTAMPDIFF(SECOND,checked_at, finished_at)) as avg_pending_time,
        count(reclamation_id) as nb_reclamation,
        SUM(IF(etat_id = 1 , 1 , 0)) AS nb_created,
        count(checked_at) as nb_pending,
        count(finished_at) as nb_closed
        from views_statistique 
        group by ";


        $data = [
            'client' => DB::select($filtredQuery . "client_id  order by client_id"),
            'departement'  => DB::select($filtredQuery . "depart_id  order by depart_id"),
            'agence'  => DB::select($filtredQuery . "agence_id, prod_id  order by agence_id"),
            'produit' => DB::select($filtredQuery . "prod_id, agence_id  order by prod_id"),
            'equipement' => DB::select($filtredQuery . " equip_id  order by equip_id"),
            'reference' =>  DB::select($filtredQuery . " equip_ref_id  order by equip_ref_id")
        ];




        return response()->json($data);
    }

    public function fill_list()
    {

        $data = array(
            'fv_client' => Client::withTrashed()->get(),
            'fv_departement'  => Departement::withTrashed()->get(),
            'fv_agence'  => Agence::withTrashed()->get(),
            'fv_produit' => Produit::withTrashed()->get(),
            'fv_equipement' => Equipement::all(),
            'fv_ref_equip' => Souscription::where('equip_ref', '<>', null)->get(),
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

        if ($input_values['fv_client'] == null) {
            $clients =  DB::table('clients')->select('*')->get();
            $client_ids = DB::table('clients')->select('*')->pluck('id');
        } else {
            $clients =  DB::table('clients')->select('*')->whereIn('id', explode(',', $request->fv_client))->get();
            $client_ids = DB::table('clients')->select('*')->whereIn('id', explode(',', $request->fv_client))->pluck('id');
        }

        if ($input_values['fv_departement'] == null) {
            $departements =  DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->whereIn('client_id', $client_ids)->pluck('id');
        } else {
            $departements =  DB::table('departements')->select('*')->whereIn('id', explode(',', $request->fv_departement))->whereIn('client_id', $client_ids)->get();
            $departement_ids = DB::table('departements')->select('*')->whereIn('id', explode(',', $request->fv_departement))->whereIn('client_id', $client_ids)->pluck('id');
        }

        if ($input_values['fv_agence'] == null) {
            $agences =  DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->whereIn('departement_id', $departement_ids)->pluck('id');
        } else {
            $agences =  DB::table('agences')->select('*')->whereIn('id', explode(',', $request->fv_agence))->whereIn('departement_id', $departement_ids)->get();
            $agence_ids = DB::table('agences')->select('*')->whereIn('id', explode(',', $request->fv_agence))->whereIn('departement_id', $departement_ids)->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($agence_ids); $i++) {
            $i == count($agence_ids) - 1 ?  $ags = $ags . " " . $agence_ids[$i] : $ags = $ags . " " . $agence_ids[$i] . " , ";
        }
        array_push($paramsQuery, " agence_id IN (" . $ags . ") ");

        if ($input_values['fv_produit'] == null) {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        } else {
            $produits =  DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('produits.id',  explode(',', $request->fv_produit))->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->get();
            $produit_ids = DB::table('souscriptions')
                ->leftJoin('produits', 'souscriptions.produit_id', '=', 'produits.id')
                ->select('produits.*')->whereIn('produits.id',  explode(',', $request->fv_produit))->whereIn('souscriptions.agence_id', $agence_ids)->groupBy('souscriptions.produit_id')->pluck('id');
        }

        $ags = "";
        for ($i = 0; $i < count($produit_ids); $i++) {
            $i == count($produit_ids) - 1 ?  $ags = $ags . " " . $produit_ids[$i] : $ags = $ags . " " . $produit_ids[$i] . " , ";
        }
        array_push($paramsQuery, " produit_id IN (" . $ags . ") ");

        if ($input_values['fv_equipement'] == null) {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
        } else {
            $equipements =  DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('equipements.id', explode(',', $request->fv_equipement))->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->get();
            $equipement_ids = DB::table('souscriptions')
                ->leftJoin('equipements', 'souscriptions.equipement_id', '=', 'equipements.id')
                ->select('equipements.*')->whereIn('equipements.id', explode(',', $request->fv_equipement))->whereIn('souscriptions.produit_id', $produit_ids)->groupBy('souscriptions.equipement_id')->pluck('id');
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



        $request->fv_client == null ?:  array_push($having, "( client_id IN (" . $request->fv_client . ") )");
        $request->fv_departement == null ?:  array_push($having, "( depart_id IN (" . $request->fv_departement . ") )");
        $request->fv_agence == null ?:  array_push($having, "( agence_id IN (" . $request->fv_agence . ") )");
        $request->fv_produit == null ?:  array_push($having, "( prod_id IN (" . $request->fv_produit . ") )");
        $request->fv_equipement == null ?:  array_push($having, "( equip_id IN (" . $request->fv_equipement . ") )");
        $request->fv_ref_equip == null ?:  array_push($having, "( equip_ref_id IN (" . $request->fv_ref_equip . ") )");




        $time_mois_from = $request->input('time_mois_from');
        $time_mois_to = $request->input('time_mois_to');

        $time_year_from = $request->input('time_year_from');
        $time_year_to = $request->input('time_year_to');

        $time_day_from = $request->input('time_day_from');
        $time_day_to = $request->input('time_day_to');

        if ($time_year_from != $time_year_to) {
            array_push($where, " (YEAR( created_at ) BETWEEN '" . $time_year_from . "' AND '" . $time_year_to . "')  ");
        } else {
            array_push($where, " (YEAR( created_at ) = '" . $time_year_from . "')  ");
        }
        if ($time_mois_from != $time_mois_to) {
            array_push($where, " (MONTH( created_at ) BETWEEN '" . $time_mois_from . "' AND '" . $time_mois_to . "')  ");
        } else {
            array_push($where, " (MONTH( created_at ) = '" . $time_mois_from . "')  ");
        }
        if ($time_day_from != $time_day_to) {
            array_push($where, " (DAY( created_at ) BETWEEN '" . $time_day_from . "' AND '" . $time_day_to . "')  ");
        } else {
            array_push($where, " (DAY( created_at ) = '" . $time_day_from . "')  ");
        }

      
        
        $filtredQuery =   "select * ,
        avg( IF(checked_at IS NULL, TIMESTAMPDIFF(SECOND,created_at, finished_at) ,  TIMESTAMPDIFF(SECOND,created_at, checked_at))) AS avg_created_time,
        avg(TIMESTAMPDIFF(SECOND,checked_at, finished_at)) as avg_pending_time,
        count(reclamation_id) as nb_reclamation,
        SUM(IF(etat_id = 1 , 1 , 0)) AS nb_created,
        count(checked_at) as nb_pending,
        count(finished_at) as nb_closed
        from views_statistique ";

        $totalQuery = "";

        $WhereQuery = "";

        if(count($where) != 0 ){
            foreach ($where as $filter) {
                $WhereQuery = $WhereQuery  . $filter . " And ";
            }
            $WhereQuery = substr($WhereQuery, 0, -4);
        }

        $havingQuery = "";
        $having_string ="";

        $totalQuery = $filtredQuery . " where " . $WhereQuery." and " ;

        if (count($having) == 0){
            $totalQuery = substr($totalQuery, 0, -4);
        }else {
            $having_string = " having ";
            foreach ($having as $filter) {
                $havingQuery = $havingQuery  . $filter . " And ";
            }
            $havingQuery = substr($havingQuery, 0, -4);
        }

        $totalQuery = $totalQuery." ".$havingQuery ;

        $filtredQuery = $filtredQuery . " where " . $WhereQuery . " group by ";

        $stat_by = "";
        switch ($request->stat_by) {
            case 'client':
                $stat_by = 'client_id';
                break;

            case 'agence':
                $stat_by = 'agence_id , prod_id';
                break;
            case 'produit':
                $stat_by = 'prod_id , agence_id';
                break;

            case 'equipement':
                $stat_by = 'equip_id';
                break;
            case 'departement':
                $stat_by = 'depart_id';
                break;

            case 'reference':
                $stat_by = 'equip_ref_id';
                break;
        }

        $filtredQuery = $filtredQuery . "" . $stat_by . " ".( count($having) == 0 ? " " : $having_string)." ". $havingQuery . " order by " . $stat_by;

        $data = [
            '' . $request->stat_by => DB::select($filtredQuery),
            'semi_total_' . $request->stat_by => ($request->stat_by == "produit" || $request->stat_by == "agence") ? DB::select($totalQuery." group by ".explode(',',$stat_by)[0]." order by " . $stat_by) : null ,
            'total_' . $request->stat_by => DB::select($totalQuery. " order by " . $stat_by),
            'stat_by' => $request->stat_by
        ];
        return response()->json($data);
    }
}
