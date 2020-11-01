<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class CreatedRec extends Mailable
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
        
        
        return $this->subject('Nouvelle Reclamation')
        ->markdown('emails.reclamations.created')
        ->with([
            'user' => $this->user,
            'agence' => $this->reclamation->agence_nom,
            'ref' => $this->reclamation->reclamation_ref,
            'prod' => $this->reclamation->prod_nom,
            'anomalie' => $this->reclamation->anomalie,
            'created_at' => $this->reclamation->created_at,
           
        ]);
    }
}
