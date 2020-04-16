@extends('layouts.appback')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer les réclamations</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Reclamations</li>
            <li class="breadcrumb-item active">Gérer les réclamations</li>
        </ol>
    </div>
    <div class="col-md-7 col-4 align-self-center">
        <div class="d-flex m-t-10 justify-content-end">
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <!-- <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div> -->
            </div>
            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                <!-- <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div> -->
            </div>

        </div>
    </div>
</div>
<div class="row" id="bodytab">



</div>

<div class="modal fade" id="exampleModal" tabindex="-1" rqt="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="modalhead">

            </div>
            <div class="modal-body text-center" id="modalbody">




            </div>
            <div class="modal-footer" id="modalfooter">
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        init()
    });

    function init() {
        var chef;
        var tech;
        var affect;
        var buttonacive;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData);
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            console.log(jsonData[ind].chef_nom);
            if (jsonData[ind].chef_nom == null) {
                chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            } else {
                chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData[ind].chef_nom + " " + jsonData[ind].chef_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData[ind].chef_photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].chef_nom + " " + jsonData[ind].chef_prenom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].chef_email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].chef_tel + "</p>" +
                    "</span> </span>" +
                    "</span>";

            }
            if (jsonData[ind].tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData[ind].tech_nom + " " + jsonData[ind].tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData[ind].tech_photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].tech_nom + " " + jsonData[ind].tech_prenom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].tech_email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData[ind].tech_tel + "</p>" +
                    "</span> </span>" +
                    "</span>";

            }
            switch (jsonData[ind].accepted) {
                case null:
                    affect = " indéterminé "
                    break;

                case 1:
                    affect = " oui "
                    break;
                case 0:
                    affect = " non "
                    break;
            }

            $('#bodytab').append("<div class=\"col-12 \" >" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title \"> Réclamation N° : <strong>" + jsonData[ind].reclamation_ref + " </strong></h2>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<h2  class=\"card-title text-center\" > Source </h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"client" + ind + "\" class=\"card-title\"> <strong> client </strong>: " + jsonData[ind].client_nom + "</h4>" +
                "<h4 id=\"departement" + ind + "\" class=\"card-title\"> <strong> departement </strong>: " + jsonData[ind].depart_nom + "</h4>" +
                "<h4 id=\"agence" + ind + "\" class=\"card-title\"> <strong> agence </strong>: " + jsonData[ind].agence_nom + "</h4>" +
                "<h4 id=\"produit" + ind + "\" class=\"card-title\"> <strong> produit </strong>: " + jsonData[ind].prod_nom + "</h4>" +
                "<h4 id=\"equipement" + ind + "\" class=\"card-title\"> <strong> équipement </strong>: " + jsonData[ind].equip_nom + "</h4>" +
                "<h4 id=\"equip_ref" + ind + "\" class=\"card-title\"> <strong> référence d'équipement </strong>: " + jsonData[ind].equip_ref + "</h4>" +
                "<h4><strong> Chef d'agence </strong> :  " + chef + " </h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \">" +
                "<div class=\"card\" id=\"detail_recl" + ind + "\">" +
                "<h2  class=\"card-title text-center\" > détails </h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"anomalie" + ind + "\" class=\"card-title\"> <strong> anomalie </strong>: " + jsonData[ind].anomalie + "</h4>" +
                "<h4 id=\"etat" + ind + "\" class=\"card-title\"> <strong> etat </strong>: " + jsonData[ind].etat + "</h4>" +
                "<h4 id=\"reclam_commentaire" + ind + "\" class=\"card-title\"> <strong> commentaire </strong>: " + jsonData[ind].reclam_commentaire + "</h4>" +
                "<h4><strong> technicien </strong> :  " + tech + " </h4>" +
                "<h4 id=\"acceptation" + ind + "\" class=\"card-title\"> <strong>prise en charge </strong>: " + affect + "</h4>" +
                "<h4 id=\"checked_at" + ind + "\" class=\"card-title\"> <strong> depuis  </strong>: " + jsonData[ind].checked_at + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé en </strong>: " + jsonData[ind].finished_at + "</h4>" +
                "<h4 id=\"pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>: " + jsonData[ind].pv_image + "</h4>" +

                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "<div id=\"tach_button"+ind+"\" role=\"tablist\" aria-multiselectable=\"false\">" +
                "<div class=\"card m-b-0\">" +
                "<div style=\"text-align: center\" class=\"card-header\" role=\"tab\" id=\"tacheOne"+ind+"\">" +
                "<h5 class=\"mb-0\">" +
                "<a style=\"color:red;font:25px bold;\"  data-toggle=\"collapse\" data-parent=\"#tach_button"+ind+"\" href=\"#tach_coll"+ind+"\" aria-expanded=\"true\" aria-controls=\"tach_coll"+ind+"\">" +
                "Effectuer un traitement" +
                "</a>" +
                "</h5>" +
                "</div>" +
                "<div id=\"tach_coll"+ind+"\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"tacheOne"+ind+"\">" +
                "<div class=\"card-body\">" +
                "<div class=\"button-group text-center\">" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\" >Accepter</button>" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-secondary\" >Upload PV</button>" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\" >Affecter</button>" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\" >Changer état</button>" +    
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" >Annuler</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }
    }

    function traiter(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/traiter/" + id,
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;

        jsonData = JSON.parse(StringData);

        $('#exampleModal').modal('hide');
        if (jsonData.rqt.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData.rqt.id + "," + ind + ")\">traiter</button>"
        } else {
            buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
        }
        $('#card' + ind).html("<div class=\"card text-center\">" +
            "<div class=\"card-body\">" +
            "<h2 class=\"card-title\">" + jsonData.rqt.nom + "</h2>" +
            "<h4 class=\"card-title\">" + jsonData.rqt.email + "</h4>" +
            "<h4 class=\"card-title\">" + jsonData.rqt.tel + "</h4>" +
            "<p class=\"card-text\">" + jsonData.rqt.message + "</p>" +
            "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData.rqt.id + "," + ind + ")\">détail</button>" +
            buttonacive +
            "</div>" +
            "</div>");
    }

    function detail(id, ind) {

        var buttonacive;
        $('#modalhead').html("<h4 class=\"modal-title\" >detail request</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/detail/" + id,
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);


        $('#modalbody').html(
            "<h2 class=\"card-title\">" + jsonData.nom + "</h2>" +
            "<h4 class=\"card-title\">" + jsonData.email + "</h4>" +
            "<h4 class=\"card-title\">" + jsonData.tel + "</h4>" +
            "<p class=\"card-text\">" + jsonData.message + "</p>"
        );

        if (jsonData.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData.id + "," + ind + ")\">traiter</button>"
        } else {
            buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
        }

        $('#modalfooter').html(buttonacive);


        $('#exampleModal').modal('show');



    }
</script>
@endsection