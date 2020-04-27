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
            <div class="modal-body" id="modalbody">

                <div class="form-group text-center">
                    <h3 class="control-label" id="ref_rapport"></h3>
                </div>

                <div class="form-group">
                    <label class="control-label">type de d'assisstance</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="false" name="type" id="type">
                        <option value="à distance" selected>à distance </option>
                        <option value="deplacement">deplacement</option>
                    </select>
                </div>
                <div class="form-group" id="err-anomalie">
                    <label class="control-label">avec PV ?</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="false" name="with_pv" id="with_pv">
                        <option value="false" selected>non</option>
                        <option value="true">oui </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="commentaire" class="control-label"><b>commentaire</b></label>
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="5"></textarea>
                </div>

                <div class="form-group" id="pv_id">
                    <label for="pv_image">image PV</label>
                    <input type="file" id="pv_image" name="pv_image" class="dropify" />
                </div>

            </div>
            <div class="modal-footer" id="modalfooter">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="affectation" tabindex="-1" rqt="dialog" aria-labelledby="affectationlabel">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="affectationhead">

            </div>
            <div class="modal-body text-center" id="affectationbody">

                <div class="list-group" id="created_by">

                </div>
            </div>
            <div class="modal-footer" id="affectationfooter">
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
        //var chef;
        var tech;
        var affect;

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        // console.log(jsonData);
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            // console.log(jsonData[ind].chef_nom);
            // if (jsonData[ind].chef_nom == null) {
            //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            // } else {
            //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" >" +
            //         "<span class=\"tooltip-item\">" + jsonData[ind].chef_nom + " " + jsonData[ind].chef_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
            //         "<img src=\"{{ asset('storage') }}/" + jsonData[ind].chef_photo + "\" width=\"180\" /><br />" +
            //         "<span class=\"tooltip-text p-t-10\">" +
            //         "<p class=\"card-text text-center\">" + jsonData[ind].chef_nom + " " + jsonData[ind].chef_prenom + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData[ind].chef_email + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData[ind].chef_tel + "</p>" +
            //         "</span> </span>" +
            //         "</span>";

            // }
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
                    "<p class=\"card-text text-center\">" + jsonData[ind].tech_adress + "</p>" +
                    "</span> </span>" +
                    "</span>";

            }
            var ref_color = "";
            var det_color = "";
            var affectation;
            var acceptation;
            var traitement;
            var download_pdf;



            switch (jsonData[ind].accepted) {
                case null:
                    affect = " N/A ";
                    acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">accepter</button>";
                    break;

                case 0:
                    affect = " non "
                    acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">accepter</button>";
                    break;

                case 1:
                    affect = " oui "
                    acceptation = "<a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>accepté</a>"
                    break;

            }

            switch (jsonData[ind].etat_id) {
                case 1:
                    ref_color = "danger";
                    det_color = "color:#761b18;background-color:#f4b0af"
                    traitement = "";
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">traiter</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">modifier rapport</button>";
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData[ind].affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
            }

            if (jsonData[ind].accepted == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData[ind].reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
            }

            $('#bodytab').append("<div class=\"col-12 \" >" +
                "<div id=\"card" + ind + "\"  class=\"ribbon-wrapper-reverse card\">" +
                "<div id=\"ref" + ind + "\" class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\" style=\"font-weight: bold; font-size : 25px\">Ref : " + jsonData[ind].reclamation_ref + "</div>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" >" +
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
                "<h4 id=\"created_at" + ind + "\"><strong> Créé le </strong>: " + jsonData[ind].created_at + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \">" +
                "<div class=\"card\" id=\"detail_recl" + ind + "\" style=\"" + det_color + "\">" +
                "<h2  class=\"card-title text-center\" > détails </h2>" +
                "<hr>" +
                "<div class=\"card-body\" >" +
                "<h4 id=\"anomalie" + ind + "\" class=\"card-title\"> <strong> anomalie </strong>: " + jsonData[ind].anomalie + "</h4>" +
                "<h4 id=\"etat" + ind + "\" class=\"card-title\"> <strong> etat </strong>: " + jsonData[ind].etat + "</h4>" +
                "<h4 id=\"reclam_commentaire" + ind + "\" class=\"card-title\"> <strong> commentaire </strong>: " + jsonData[ind].reclam_commentaire + "</h4>" +
                "<h4><strong> technicien </strong> :  " + tech + " </h4>" +
                "<h4 id=\"acceptation" + ind + "\" class=\"card-title\"> <strong>prise en charge </strong>: " + affect + "</h4>" +
                "<h4 id=\"checked_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData[ind].checked_at == null ? "N/A" : jsonData[ind].checked_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData[ind].finished_at == null ? "N/A" : jsonData[ind].finished_at) + "</h4>" +
                // "<h4 id=\"pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>: " + jsonData[ind].pv_image + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "<div id=\"tach_button" + ind + "\" role=\"tablist\" aria-multiselectable=\"false\">" +
                "<div class=\"card m-b-0\">" +
                "<div style=\"text-align: center\" class=\"card-header\" role=\"tab\" id=\"tacheOne" + ind + "\">" +
                "<h5 class=\"mb-0\">" +
                "<a style=\"color:red;font:25px bold;\"  data-toggle=\"collapse\" data-parent=\"#tach_button" + ind + "\" href=\"#tach_coll" + ind + "\" aria-expanded=\"true\" aria-controls=\"tach_coll" + ind + "\">" +
                "Effectuer un traitement" +
                "</a>" +
                "</h5>" +
                "</div>" +
                "<div id=\"tach_coll" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"button-group text-center\">" +
                affectation +
                acceptation +
                traitement +
                download_pdf +
                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-success\" >Accepter</button>" +
                // "<button type=\"button\" class=\"btn waves-effect waves-light btn-secondary\" >Upload PV</button>" +
                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  >Traiter</button>" +
                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "</div>" +
                "</div>");
        }
    }

    function affecter(id, place) {

        $('#affectationhead').html("<h4 class=\"modal-title\" >selectionner un technicien</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        // $('#affectationfooter').html("<button type=\"hidden\"  id=\"id_d\" value=\""+id+"\">");
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/get_techniciens",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#created_by').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            $('#created_by').append("<a  class=\"list-group-item value=\"" + jsonData[ind].user.id + "\" onclick=\"select('" + id + "'," + jsonData[ind].user.id + "," + place + ")\"> <span class=\"mytooltip tooltip-effect-5\">" +
                "<span class=\"tooltip-item\"> <b>" + jsonData[ind].user.nom + " " + jsonData[ind].user.prénom + "    -    " + jsonData[ind].nb_affect + "</b> affectations en cours</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData[ind].user.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData[ind].user.nom + " " + jsonData[ind].user.prénom + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData[ind].user.email + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData[ind].user.tel + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData[ind].user.adress + "</p>" +
                "</span> </span>" +
                "</span></a>");

        }


        $('#affectation').css('padding-top', '15%');
        $('#affectation').modal('show');


    }

    function select(ref, id_u, ind) {
        var tech;
        var affect;
        var inputs = {
            "ref": ref,
            "id_u": id_u
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/set_techniciens",
            dataType: "json",
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: inputs
        }).responseText;

        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#affectation').modal('hide');

        if (jsonData.tech_nom == null) {
            tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
        } else {
            tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                "<span class=\"tooltip-item\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_adress + "</p>" +
                "</span> </span>" +
                "</span>";

        }

        var ref_color = "";
        var det_color = "";
        var affectation;
        var acceptation;
        var traitement;
        var download_pdf;



        switch (jsonData.accepted) {
            case null:
                affect = " N/A ";
                acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                break;

            case 0:
                affect = " non "
                acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                break;

            case 1:
                affect = " oui "
                acceptation = "<a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>accepté</a>"
                break;

        }

        switch (jsonData.etat_id) {
            case 1:
                ref_color = "danger";
                det_color = "color:#761b18;background-color:#f4b0af"
                traitement = "";
                download_pdf = "";
                break;

            case 2:
                ref_color = "warning";
                det_color = "color:#857b26;background-color:#fff8b3"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter('" + jsonData.reclamation_ref + "'," + ind + ")\">traiter</button>";
                download_pdf = "";
                break;
            case 3:
                ref_color = "info";
                det_color = "color:#385d7a;background-color:#d6eeff"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit('" + jsonData.reclamation_ref + "'," + ind + ")\">modifier rapport</button>";
                download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>";
                break;
        }


        if (jsonData.affectation_id == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
        }

        if (jsonData.accepted == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
        }




        $('#card' + ind).html(

            "<div id=\"ref" + ind + "\" class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\" style=\"font-weight: bold; font-size : 25px\">Ref : " + jsonData.reclamation_ref + "</div>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" >" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > Source </h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"client" + ind + "\" class=\"card-title\"> <strong> client </strong>: " + jsonData.client_nom + "</h4>" +
            "<h4 id=\"departement" + ind + "\" class=\"card-title\"> <strong> departement </strong>: " + jsonData.depart_nom + "</h4>" +
            "<h4 id=\"agence" + ind + "\" class=\"card-title\"> <strong> agence </strong>: " + jsonData.agence_nom + "</h4>" +
            "<h4 id=\"produit" + ind + "\" class=\"card-title\"> <strong> produit </strong>: " + jsonData.prod_nom + "</h4>" +
            "<h4 id=\"equipement" + ind + "\" class=\"card-title\"> <strong> équipement </strong>: " + jsonData.equip_nom + "</h4>" +
            "<h4 id=\"equip_ref" + ind + "\" class=\"card-title\"> <strong> référence d'équipement </strong>: " + jsonData.equip_ref + "</h4>" +
            "<h4 id=\"created_at" + ind + "\"><strong> Créé le </strong>: " + jsonData.created_at + "</h4>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"detail_recl" + ind + "\" style=\"" + det_color + "\">" +
            "<h2  class=\"card-title text-center\" > détails </h2>" +
            "<hr>" +
            "<div class=\"card-body\" >" +
            "<h4 id=\"anomalie" + ind + "\" class=\"card-title\"> <strong> anomalie </strong>: " + jsonData.anomalie + "</h4>" +
            "<h4 id=\"etat" + ind + "\" class=\"card-title\"> <strong> etat </strong>: " + jsonData.etat + "</h4>" +
            "<h4 id=\"reclam_commentaire" + ind + "\" class=\"card-title\"> <strong> commentaire </strong>: " + jsonData.reclam_commentaire + "</h4>" +
            "<h4><strong> technicien </strong> :  " + tech + " </h4>" +
            "<h4 id=\"acceptation" + ind + "\" class=\"card-title\"> <strong>prise en charge </strong>: " + affect + "</h4>" +
            "<h4 id=\"checked_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.checked_at == null ? "N/A" : jsonData.checked_at) + "</h4>" +
            "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
            // "<h4 id=\"pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>: " + jsonData.pv_image + "</h4>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +

            "<div id=\"tach_button" + ind + "\" role=\"tablist\" aria-multiselectable=\"false\">" +
            "<div class=\"card m-b-0\">" +
            "<div style=\"text-align: center\" class=\"card-header\" role=\"tab\" id=\"tacheOne" + ind + "\">" +
            "<h5 class=\"mb-0\">" +
            "<a style=\"color:red;font:25px bold;\"  data-toggle=\"collapse\" data-parent=\"#tach_button" + ind + "\" href=\"#tach_coll" + ind + "\" aria-expanded=\"true\" aria-controls=\"tach_coll" + ind + "\">" +
            "Effectuer un traitement" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"tach_coll" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            affectation +
            acceptation +
            traitement +
            download_pdf +

            //"<button type=\"button\" class=\"btn waves-effect waves-light btn-success\" >Accepter</button>" +
            // "<button type=\"button\" class=\"btn waves-effect waves-light btn-secondary\" >Upload PV</button>" +
            // "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  >Traiter</button>" +
            // "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");


    }

    function accepter(ref, ind) {
        var tech;
        var affect;
        var inputs = {
            "ref": ref
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/accepter",
            dataType: "json",
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: inputs
        }).responseText;

        jsonData = JSON.parse(StringData);


        if (jsonData.tech_nom == null) {
            tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
        } else {
            tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                "<span class=\"tooltip-item\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.tech_adress + "</p>" +
                "</span> </span>" +
                "</span>";

        }

        var ref_color = "";
        var det_color = "";
        var affectation;
        var acceptation;
        var traitement;
        var download_pdf;



        switch (jsonData.accepted) {
            case null:
                affect = " N/A ";
                acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                break;

            case 0:
                affect = " non "
                acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                break;

            case 1:
                affect = " oui "
                acceptation = "<a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>accepté</a>"
                break;

        }

        switch (jsonData.etat_id) {
            case 1:
                ref_color = "danger";
                det_color = "color:#761b18;background-color:#f4b0af"
                traitement = "";
                download_pdf = "";
                break;

            case 2:
                ref_color = "warning";
                det_color = "color:#857b26;background-color:#fff8b3"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter('" + jsonData.reclamation_ref + "'," + ind + ")\">traiter</button>";
                download_pdf = "";
                break;
            case 3:
                ref_color = "info";
                det_color = "color:#385d7a;background-color:#d6eeff"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit('" + jsonData.reclamation_ref + "'," + ind + ")\">modifier rapport</button>";
                download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>";
                break;
        }


        if (jsonData.affectation_id == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
        }

        if (jsonData.accepted == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
        }




        $('#card' + ind).html(

            "<div id=\"ref" + ind + "\" class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\" style=\"font-weight: bold; font-size : 25px\">Ref : " + jsonData.reclamation_ref + "</div>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" >" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > Source </h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"client" + ind + "\" class=\"card-title\"> <strong> client </strong>: " + jsonData.client_nom + "</h4>" +
            "<h4 id=\"departement" + ind + "\" class=\"card-title\"> <strong> departement </strong>: " + jsonData.depart_nom + "</h4>" +
            "<h4 id=\"agence" + ind + "\" class=\"card-title\"> <strong> agence </strong>: " + jsonData.agence_nom + "</h4>" +
            "<h4 id=\"produit" + ind + "\" class=\"card-title\"> <strong> produit </strong>: " + jsonData.prod_nom + "</h4>" +
            "<h4 id=\"equipement" + ind + "\" class=\"card-title\"> <strong> équipement </strong>: " + jsonData.equip_nom + "</h4>" +
            "<h4 id=\"equip_ref" + ind + "\" class=\"card-title\"> <strong> référence d'équipement </strong>: " + jsonData.equip_ref + "</h4>" +
            "<h4 id=\"created_at" + ind + "\"><strong> Créé le </strong>: " + jsonData.created_at + "</h4>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"detail_recl" + ind + "\" style=\"" + det_color + "\">" +
            "<h2  class=\"card-title text-center\" > détails </h2>" +
            "<hr>" +
            "<div class=\"card-body\" >" +
            "<h4 id=\"anomalie" + ind + "\" class=\"card-title\"> <strong> anomalie </strong>: " + jsonData.anomalie + "</h4>" +
            "<h4 id=\"etat" + ind + "\" class=\"card-title\"> <strong> etat </strong>: " + jsonData.etat + "</h4>" +
            "<h4 id=\"reclam_commentaire" + ind + "\" class=\"card-title\"> <strong> commentaire </strong>: " + jsonData.reclam_commentaire + "</h4>" +
            "<h4><strong> technicien </strong> :  " + tech + " </h4>" +
            "<h4 id=\"acceptation" + ind + "\" class=\"card-title\"> <strong>prise en charge </strong>: " + affect + "</h4>" +
            "<h4 id=\"checked_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.checked_at == null ? "N/A" : jsonData.checked_at) + "</h4>" +
            "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
            // "<h4 id=\"pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>: " + jsonData.pv_image + "</h4>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +

            "<div id=\"tach_button" + ind + "\" role=\"tablist\" aria-multiselectable=\"false\">" +
            "<div class=\"card m-b-0\">" +
            "<div style=\"text-align: center\" class=\"card-header\" role=\"tab\" id=\"tacheOne" + ind + "\">" +
            "<h5 class=\"mb-0\">" +
            "<a style=\"color:red;font:25px bold;\"  data-toggle=\"collapse\" data-parent=\"#tach_button" + ind + "\" href=\"#tach_coll" + ind + "\" aria-expanded=\"true\" aria-controls=\"tach_coll" + ind + "\">" +
            "Effectuer un traitement" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"tach_coll" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            affectation +
            acceptation +
            traitement +
            download_pdf +

            //"<button type=\"button\" class=\"btn waves-effect waves-light btn-success\" >Accepter</button>" +
            // "<button type=\"button\" class=\"btn waves-effect waves-light btn-secondary\" >Upload PV</button>" +
            //"<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  >Traiter</button>" +
            // "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");


    }



    // function traiter(id, ind) {
    //     var StringData = $.ajax({
    //         url: "http://127.0.0.1:8000/reclamation/recls/traiter/" + id,
    //         dataType: "json",
    //         type: "GET",
    //         async: false
    //     }).responseText;

    //     jsonData = JSON.parse(StringData);

    //     $('#exampleModal').modal('hide');
    //     if (jsonData.rqt.deleted_at == null) {
    //         buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData.rqt.id + "," + ind + ")\">traiter</button>"
    //     } else {
    //         buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
    //     }
    //     $('#card' + ind).html("<div class=\"card text-center\">" +
    //         "<div class=\"card-body\">" +
    //         "<h2 class=\"card-title\">" + jsonData.rqt.nom + "</h2>" +
    //         "<h4 class=\"card-title\">" + jsonData.rqt.email + "</h4>" +
    //         "<h4 class=\"card-title\">" + jsonData.rqt.tel + "</h4>" +
    //         "<p class=\"card-text\">" + jsonData.rqt.message + "</p>" +
    //         "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData.rqt.id + "," + ind + ")\">détail</button>" +
    //         buttonacive +
    //         "</div>" +
    //         "</div>");
    // }

    function traiter(id, ind) {




        // var buttonacive;
        $('#modalhead').html("<h4 class=\"modal-title\" >Rapport de traitement</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#ref_rapport').html(" Ref : <b>" + id + "</b>");
        $('#pv_id').hide();

        $('#type').val('à distance');
        $('#type').selectpicker('refresh');

        $('#with_pv').val('false');
        $('#with_pv').selectpicker('refresh');

        $(".dropify-clear").trigger("click");

        $('#commentaire').val("");


        $('#exampleModal').modal('show');

        $('#with_pv').change(function() {

            if ($(this).val() == 'true') {

                $('#pv_id').show();
            } else {
                $('#pv_id').hide();
            }
        });



        $('#save').click(function() {

            form_data = new FormData();

            form_data.append("pv_image", $('#pv_image')[0].files[0]);
            form_data.append("type", $('#type').val());
            form_data.append("with_pv", $('#with_pv').val());
            form_data.append("commentaire", $('#commentaire').val());

            form_data.append("ref", id);

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/reclamation/recls/save_raport",
                dataType: "json",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: form_data,
                processData: false,
                contentType: false,
            }).responseText;

            jsonData = JSON.parse(StringData);
            $('#exampleModal').modal('hide');

            var tech;
            var affect;

            var ref_color = "";
            var det_color = "";
            var affectation;
            var acceptation;
            var traitement;
            var download_pdf;

            if (jsonData.tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.tech_email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.tech_tel + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.tech_adress + "</p>" +
                    "</span> </span>" +
                    "</span>";

            }




            switch (jsonData.accepted) {
                case null:
                    affect = " N/A ";
                    acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                    break;

                case 0:
                    affect = " non "
                    acceptation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-success\"  onclick=\"accepter('" + jsonData.reclamation_ref + "'," + ind + ")\">accepter</button>";
                    break;

                case 1:
                    affect = " oui "
                    acceptation = "<a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>accepté</a>"
                    break;

            }

            switch (jsonData.etat_id) {
                case 1:
                    ref_color = "danger";
                    det_color = "color:#761b18;background-color:#f4b0af"
                    traitement = "";
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter('" + jsonData.reclamation_ref + "'," + ind + ")\">traiter</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit('" + jsonData.reclamation_ref + "'," + ind + ")\">modifier rapport</button>";
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData.affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
            }

            if (jsonData.accepted == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter('" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>affecté</a>"
            }




            $('#card' + ind).html(

                "<div id=\"ref" + ind + "\" class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\" style=\"font-weight: bold; font-size : 25px\">Ref : " + jsonData.reclamation_ref + "</div>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" >" +
                "<div class=\"card \">" +
                "<h2  class=\"card-title text-center\" > Source </h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"client" + ind + "\" class=\"card-title\"> <strong> client </strong>: " + jsonData.client_nom + "</h4>" +
                "<h4 id=\"departement" + ind + "\" class=\"card-title\"> <strong> departement </strong>: " + jsonData.depart_nom + "</h4>" +
                "<h4 id=\"agence" + ind + "\" class=\"card-title\"> <strong> agence </strong>: " + jsonData.agence_nom + "</h4>" +
                "<h4 id=\"produit" + ind + "\" class=\"card-title\"> <strong> produit </strong>: " + jsonData.prod_nom + "</h4>" +
                "<h4 id=\"equipement" + ind + "\" class=\"card-title\"> <strong> équipement </strong>: " + jsonData.equip_nom + "</h4>" +
                "<h4 id=\"equip_ref" + ind + "\" class=\"card-title\"> <strong> référence d'équipement </strong>: " + jsonData.equip_ref + "</h4>" +
                "<h4 id=\"created_at" + ind + "\"><strong> Créé le </strong>: " + jsonData.created_at + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \">" +
                "<div class=\"card\" id=\"detail_recl" + ind + "\" style=\"" + det_color + "\">" +
                "<h2  class=\"card-title text-center\" > détails </h2>" +
                "<hr>" +
                "<div class=\"card-body\" >" +
                "<h4 id=\"anomalie" + ind + "\" class=\"card-title\"> <strong> anomalie </strong>: " + jsonData.anomalie + "</h4>" +
                "<h4 id=\"etat" + ind + "\" class=\"card-title\"> <strong> etat </strong>: " + jsonData.etat + "</h4>" +
                "<h4 id=\"reclam_commentaire" + ind + "\" class=\"card-title\"> <strong> commentaire </strong>: " + jsonData.reclam_commentaire + "</h4>" +
                "<h4><strong> technicien </strong> :  " + tech + " </h4>" +
                "<h4 id=\"acceptation" + ind + "\" class=\"card-title\"> <strong>prise en charge </strong>: " + affect + "</h4>" +
                "<h4 id=\"checked_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.checked_at == null ? "N/A" : jsonData.checked_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
                // "<h4 id=\"pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>: " + jsonData.pv_image + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "<div id=\"tach_button" + ind + "\" role=\"tablist\" aria-multiselectable=\"false\">" +
                "<div class=\"card m-b-0\">" +
                "<div style=\"text-align: center\" class=\"card-header\" role=\"tab\" id=\"tacheOne" + ind + "\">" +
                "<h5 class=\"mb-0\">" +
                "<a style=\"color:red;font:25px bold;\"  data-toggle=\"collapse\" data-parent=\"#tach_button" + ind + "\" href=\"#tach_coll" + ind + "\" aria-expanded=\"true\" aria-controls=\"tach_coll" + ind + "\">" +
                "Effectuer un traitement" +
                "</a>" +
                "</h5>" +
                "</div>" +
                "<div id=\"tach_coll" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"button-group text-center\">" +
                affectation +
                acceptation +
                traitement +
                download_pdf +

                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-success\" >Accepter</button>" +
                // "<button type=\"button\" class=\"btn waves-effect waves-light btn-secondary\" >Upload PV</button>" +
                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  >Traiter</button>" +
                //"<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\" >Exporter PDF</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");



        });



    }
</script>
@endsection