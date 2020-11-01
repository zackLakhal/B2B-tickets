<?php

namespace App\Console;

use App\Mail\AcceptRec;
use App\Mail\AffectRec;
use App\Mail\closeRec;
use App\Mail\CreatedRec;
use App\Mail\EditRap;
use App\Mail\pendRec;
use App\Mailpend;
use App\Nstuser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {

            $email = Mailpend::where('id', '<>', 0)->first();
            $to_email = "jiikasse1994@gmail.com";

            if (!empty($email)) {
                $users = Nstuser::WhereIn('id', explode('_', $email->staff))->get();

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
                        'reclamations.created_at',
                        'reclamations.checked_at as pending_at',
                        'reclamations.finished_at',
                        'anomalies.value as anomalie',
                        'etats.value as etat',
                        'etats.id as etat_id',
                        'affectations.id as affectation_id',
                        'affectations.accepted',
                        'affectations.created_at as affect_created_at',
                        'affectations.accepted_at as accepted_at',
                        'pendings.pv as pending_pv_image',
                        'pendings.with_pv as pending_with_pv',
                        'closeds.pv as closed_pv_image',
                        'closeds.with_pv as closed_with_pv',
                        'nstusers.id as tech_id',
                        'nstusers.nom as tech_nom',
                        'nstusers.prénom as tech_prenom',
                        'produits.nom as prod_nom',
                        'equipements.nom as equip_nom',
                        'agences.nom as agence_nom',
                        'clients.nom as client_nom',
                        'clients.id as client_id'
                    )->where('reclamations.id', '=', $email->reclamations)
                    ->groupBy('reclamations.id')->first();
                //dd($reclamation);

                switch ($email->action) {
                    case 'created':
                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new CreatedRec($user->prénom . " " . $user->nom, $reclamation));
                        }
                        break;
                    case 'affected':
                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new AffectRec($user->prénom . " " . $user->nom, $reclamation));
                        }
                        break;
                    case 'accepted':
                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new AcceptRec($user->prénom . " " . $user->nom, $reclamation));
                        }
                        break;
                    case 'pending':
                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new pendRec($user->prénom . " " . $user->nom, $reclamation));
                        }
                        break;

                    case 'closed':
                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new closeRec($user->prénom . " " . $user->nom, $reclamation));
                        }
                        break;

                    default:

                        foreach ($users as  $user) {
                            Mail::to($to_email)->send(new EditRap($user->prénom . " " . $user->nom, $email->action, $reclamation));
                        }
                        break;
                }



                $email->delete();
            }
        })->everyMinute();



        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
