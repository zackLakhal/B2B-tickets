<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatistiqueViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW views_statistique AS(
            SELECT 
                    produits.id AS prod_id,
                    produits.nom AS prod_nom,
                    equipements.id AS equip_id,
                    equipements.nom AS equip_nom,
                    souscriptions.id AS equip_ref_id,
                    souscriptions.equip_ref AS equip_ref,
                    agences.id AS agence_id,
                    agences.nom AS agence_nom,
                    departements.id AS depart_id,
                    departements.nom AS depart_nom,
                    clients.id AS client_id,
                    clients.nom AS client_nom,
                    reclamations.id AS reclamation_id,
                    reclamations.etat_id AS etat_id,
                    reclamations.created_at AS created_at,
                    reclamations.finished_at AS finished_at,
                    reclamations.checked_at AS checked_at
                 from reclamations
                        left join souscriptions on reclamations.souscription_id  =  souscriptions.id
                        left join produits on souscriptions.produit_id  =  produits.id
                        left join equipements on souscriptions.equipement_id  =  equipements.id
                        left join agences on souscriptions.agence_id  =  agences.id
                        left join departements on agences.departement_id  =  departements.id
                        left join clients on departements.client_id  =  clients.id
                GROUP BY reclamations.id)
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS views_statistique');
    }
}
