<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptRec extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $reclamation;
    protected $user;
    //protected $affect;

    public function __construct($user,$reclamation)
    {
        $this->user = $user;
      //  $this->affect = $affect;
        $this->reclamation = $reclamation;

    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reclamation acceptée')
        ->markdown('emails.reclamations.accepted')->with([
            'user' => $this->user,
            'agence' => $this->reclamation->agence_nom,
            'ref' => $this->reclamation->reclamation_ref,
            'prod' => $this->reclamation->prod_nom,
            'anomalie' => $this->reclamation->anomalie,
            'accepted_at' => $this->reclamation->accepted_at,
            'tech' => $this->reclamation->tech_prenom." ".$this->reclamation->tech_prenom,
           
        ]);
    }
}
