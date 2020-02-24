<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class modelmigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'initialisation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //  $this->call('make:model', [
        //     'name' => 'Role',
        //     '--migration'  => true
        // ]);
        // $this->call('make:model', [
        //     'name' => 'Clientuser',
        //     '--migration'  => true
        // ]);
         $this->call('make:model', [
            'name' => 'Nstuser',
            '--migration'  => true
        ]);
        //  $this->call('make:model', [
        //     'name' => 'Newrqst',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Agence',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Departement',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Ville',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Client',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Produit',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Equipement',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Reclamation',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Etat',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Anomalie',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Affectation',
        //     '--migration'  => true
        // ]);
        //  $this->call('make:model', [
        //     'name' => 'Pv',
        //     '--migration'  => true
        // ]);

    }
}
