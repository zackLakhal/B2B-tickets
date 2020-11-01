<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class pendRec extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $reclamation;
    protected $user;

    public function __construct($user,$reclamation)
    {
        $this->user = $user;
        $this->reclamation = $reclamation;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->subject('Reclamation en traitement')
        ->markdown('emails.reclamations.pending')->with([
            'user' => $this->user,
            'agence' => $this->reclamation->agence_nom,
            'ref' => $this->reclamation->reclamation_ref,
            'prod' => $this->reclamation->prod_nom,
            'anomalie' => $this->reclamation->anomalie,
            'pending_at' => $this->reclamation->pending_at,
            'tech' => $this->reclamation->tech_prenom." ".$this->reclamation->tech_prenom,
            'pv' => $this->reclamation->pending_pv_image
           
        ]);
    }
}
