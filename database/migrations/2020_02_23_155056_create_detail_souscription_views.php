<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSouscriptionViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW views_detail_souscription AS(

        SELECT souscriptions.id AS ref_id, agences.id as agence_id, produits.id AS prod_id, 
        produits.nom AS prod_nom, souscriptions.active AS prod_etat,
        equipements.id AS equip_id, equipements.nom AS equip_nom,
        equipements.deleted_at as equip_deleted_at,souscriptions.equip_ref AS ref,
        souscriptions.deleted_at AS souscription_deleted_at

        FROM `souscriptions`
          LEFT JOIN `agences` ON agences.id=souscriptions.agence_id
          LEFT JOIN `equipements` ON equipements.id=souscriptions.equipement_id
          LEFT JOIN `produits` ON produits.id = souscriptions.produit_id


      )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS views_detail_souscription');
    }
}
