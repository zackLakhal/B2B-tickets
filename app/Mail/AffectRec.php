<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AffectRec extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $reclamation;
    protected $user;
  //  protected $affect;

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
        return $this->subject('Reclamation affectée')
        ->markdown('emails.reclamations.affected')->with([
            'user' => $this->user,
            'agence' => $this->reclamation->agence_nom,
            'ref' => $this->reclamation->reclamation_ref,
            'prod' => $this->reclamation->prod_nom,
            'anomalie' => $this->reclamation->anomalie,
            'affected_at' => $this->reclamation->affect_created_at,
           
        ]);
    }
}
