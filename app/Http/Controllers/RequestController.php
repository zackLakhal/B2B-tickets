<?php

namespace App\Http\Controllers;

use App\Mail\closeRec;
use App\Mail\CreatedRec;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Newrqst;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RequestController extends Controller
{
    public function index()
    {
        $rqts = Newrqst::withTrashed()->get();
        return response()->json($rqts);

    }

    public function filter_index(Request $request)
    {
        
        $where = array();
        $having = array();
        $rqst = null;
        $request->rqst_id == "0" ?  :  $where[] = ['id','=',$request->rqst_id];
        
        if($request->is_all != "true"){
            $request->is_treated == 'true' ? $where[] = ['deleted_at','<>',null] : $where[] = ['deleted_at','=',null];

        }

        $mois_from = $request->input('mois_from');
        $mois_to = $request->input('mois_to');

        $year_from = $request->input('year_from');
        $year_to = $request->input('year_to');

        if($year_from != $year_to){
            array_push($having, " (YEAR( newrqsts.created_at ) BETWEEN '".$year_from."' AND '".$year_to."')  " );
        }else{
            array_push($having, " (YEAR( newrqsts.created_at ) = '".$year_from."')  " );

        }
        if($mois_from != $mois_to){
            array_push($having, " (MONTH( newrqsts.created_at ) BETWEEN '".$mois_from."' AND '".$mois_to."')  " );

        }else{
            array_push($having, " (MONTH( newrqsts.created_at ) = '".$mois_from."')  " );

        }
        $havingQuery = "";

        if(count($having) != 0 ){
            foreach ($having as $filter) {
                $havingQuery = $havingQuery  . $filter . " And " ;
            }
            $havingQuery = substr( $havingQuery , 0, -4);
        }


        $rqst = DB::table('newrqsts')
        ->select('newrqsts.*',DB::raw('YEAR( newrqsts.created_at) as rqst_year'),  DB::raw('MONTH( newrqsts.created_at ) as rqst_mois')
        )->where($where)->havingRaw($havingQuery)
        ->orderBy('newrqsts.created_at', 'desc')->get();

        return response()->json($rqst);

    }


    public function non_deleted(){

        $rqts = Newrqst::all();
        return response()->json($rqts);
    }

    public function deleted(){

        $rqts = Newrqst::onlyTrashed();
        return response()->json($rqts);
    }

    public function detail($id){

        $rqt = Newrqst::withTrashed()
                ->where('id', $id)
                ->first();
        return response()->json($rqt);
    }

    public function traiter($id)
    {

        $done = false;
        
            $temp = Newrqst::find($id); 
            $temp->delete();
            $done = true;
        

        $rqt = Newrqst::withTrashed()
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
            'rqt' => $rqt
        ];
        return response()->json($objet);
    }

    public function store(Request $request){

        
        $validator = Validator::make($request->all(), [

            'nom' => 'required',
            'email' => 'required',
            'gsm' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }


        $rqst = new Newrqst();
       
        $rqst->nom = $request->nom;
        $rqst->email = $request->email;
        $rqst->tel = $request->gsm;
        $rqst->message = $request->message;
        $rqst->save();
        $rqst->ref = "D-".date('Y')."-".time()."-".$rqst->id;
        $rqst->save();
        $check;
        $check = "done";

        $objet =  [
            'check' => $check,
            'rqst' => $rqst,
            'inputs' => $request->all()
        ];
        return response()->json($objet);

    }

    public function sendmail(){
        
        $to_email = "jiikasse1994@gmail.com";
        Mail::to($to_email)->send(new closeRec());
        
        
    
    }
    
}
