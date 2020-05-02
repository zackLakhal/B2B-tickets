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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body wizard-content">
                <div id="filters" role="tablist" class="minimal-faq" aria-multiselectable="false">
                    <div class="card m-b-0">
                        <div class="card-header text-center" role="tab" id="filterOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" data-parent="#filters" href="#filterCollapseOne" aria-expanded="true" aria-controls="filterCollapseOne" style="font-size:24px">
                                    Filtrer les réclamations
                                </a>
                            </h5>
                        </div>
                        <div id="filterCollapseOne" class="collapse show" role="tabpanel" aria-labelledby="filterOne">
                            <div class="card-body tab-wizard wizard-circle" id="tab-wizard">
                                <br>
                                <h6>filtrer par réclamation</h6>
                                <section>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="demo-radio-button">
                                                <input class="radio-col-light-green" name="group1" type="radio" id="rd_list" onclick="check(this)" checked />
                                                <label for="rd_list">Choisir dans la liste</label>
                                                <input class="radio-col-light-green" name="group1" type="radio" id="rd_manuel" onclick="check(this)" />
                                                <label for="rd_manuel">Entrer manuellement</label>

                                            </div>
                                            <div class="form-group" id="fl_ref_text">
                                                <label for="fv_ref_text" style="font-weight: bold">entrer réclamation</label>
                                                <input type="text" class="form-control" id="fv_ref_text" name="fv_ref_text">
                                            </div>
                                            <div class="form-group" id="fl_ref_select">
                                                <label for="fv_ref_select" style="font-weight: bold" class="control-label ">choix réclamation</label>
                                                <select class="form-control custom-select  has-success" data-live-search="true" name="fv_ref_select" id="fv_ref_select">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">

                                            <h4 class="card-title text-center">Prise en charge : N/A ?</h4>
                                            <div class="col-md-12 text-center">
                                                <div class="switch">
                                                    <label>Non
                                                        <input id="fv_dr" type="checkbox"><span class="lever switch-col-light-green"></span>Oui</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group text-center" id="dr_group">
                                                <input type="checkbox" id="accepted" class="filled-in chk-col-light-green" checked />
                                                <label style="margin-right: 10px" for="accepted">accepté : oui </label>

                                                <input type="checkbox" id="pending" class="filled-in chk-col-light-green" checked />
                                                <label for="pending">accepté : non</label>
                                            </div>

                                        </div>
                                    </div>
                                </section>
                                <h6>filtrer les Sources</h6><br>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="client_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_client').show() :  $('#fl_client').hide()" />
                                                <label for="client_check">filter par client</label>
                                            </div> -->
                                            <div class="form-group" id="fl_client">
                                                <label for="fv_client" class="control-label " style="font-weight: bold">choix client</label>
                                                <select class="form-control custom-select  has-success" name="fv_client" onchange="filter_data(this)" id="fv_client">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="departement_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_departement').show() :  $('#fl_departement').hide()" />
                                                <label for="departement_check">filter par département</label>
                                            </div> -->
                                            <div class="form-group" id="fl_departement">
                                                <label for="fv_departement" class="control-label " style="font-weight: bold">choix département</label>
                                                <select class="form-control custom-select  has-success" name="fv_departement" onchange="filter_data(this)" id="fv_departement">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="agence_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_agence').show() :  $('#fl_agence').hide()" />
                                                <label for="agence_check">filter par agence</label>
                                            </div> -->
                                            <div class="form-group" id="fl_agence">
                                                <label for="fv_agence" class="control-label " style="font-weight: bold">choix agence</label>
                                                <select class="form-control custom-select  has-success" name="fv_agence" onchange="filter_data(this)" id="fv_agence">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="produit_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_produit').show() :  $('#fl_produit').hide()" />
                                                <label for="produit_check">filter par produit</label>
                                            </div> -->
                                            <div class="form-group" id="fl_produit">
                                                <label for="fv_produit" class="control-label " style="font-weight: bold">choix produit</label>
                                                <select class="form-control custom-select  has-success" name="fv_produit" onchange="filter_data(this)" id="fv_produit">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="equipement_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_equipement').show() :  $('#fl_equipement').hide()" />
                                                <label for="equipement_check">filter par équipement</label>
                                            </div> -->
                                            <div class="form-group" id="fl_equipement">
                                                <label for="fv_equipement" class="control-label " style="font-weight: bold">choix équipement</label>
                                                <select class="form-control custom-select  has-success" name="fv_equipement" onchange="filter_data(this)" id="fv_equipement">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="ref_equip_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_ref_equip').show() :  $('#fl_ref_equip').hide()" />
                                                <label for="ref_equip_check">filter par équipement ref</label>
                                            </div> -->
                                            <div class="form-group" id="fl_ref_equip">
                                                <label for="fv_ref_equip" class="control-label " style="font-weight: bold">choix équipement ref</label>
                                                <select class="form-control custom-select  has-success" name="fv_ref_equip" id="fv_ref_equip">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </section>
                                <!-- Step 2 -->
                                <h6>filtrer les details</h6>
                                <section>
                                    <div class="row justify-content-center">
                                        <div class="col-md-4 text-center">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="anomalie_check" class="filled-in chk-col-pink" onclick="$(this).is(':checked') ? $('#fl_anomalie').show() :  $('#fl_anomalie').hide()" />
                                                <label for="anomalie_check">filter par anomalie</label>
                                            </div> -->
                                            <div class="form-group" id="fl_anomalie">
                                                <label for="fv_anomalie" class="control-label " style="font-weight: bold">choix anomalie</label>
                                                <select class="form-control custom-select  has-success" name="fv_anomalie" id="fv_anomalie">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="etat_check" class="filled-in chk-col-pink" onclick="etat_filter(this)" />
                                                <label for="etat_check">filter par etat</label>
                                            </div> -->
                                            <div class="form-group " id="fl_etat">
                                                <label for="fv_etat" class="control-label " style="font-weight: bold">choix etat</label>
                                                <select id="fv_etat" class="selectpicker" multiple data-style="form-control btn-info">
                                                    <option value="1">en cours</option>
                                                    <option value="2">en traitement</option>
                                                    <option value="3">cloturé</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center" id="tech_group">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="tech_check" class="filled-in chk-col-pink" onclick="$(this).is(':checked') ? $('#fl_tech').show() :  $('#fl_tech').hide()" />
                                                <label for="tech_check">filter par technicien</label>
                                            </div> -->
                                            <div class="form-group" id="fl_tech">
                                                <label for="fv_tech" class="control-label " style="font-weight: bold">choix technicien</label>
                                                <select class="form-control custom-select  has-success" data-live-search="true" name="fv_tech" id="fv_tech">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 3 -->
                                <h6> filtrer les dates</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-3">

                                            <h4 class="card-title text-center"> créé le : </h4>
                                            <div class="col-md-12 text-center">
                                                <div class="switch">
                                                    <label>Non
                                                        <input id="fv_created" type="checkbox"  onchange="$(this).is(':checked') ? $('#fl_created').show() : $('#fl_created').hide() "><span class="lever switch-col-deep-purple"></span>Oui</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div id="fl_created">
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">année</h4>
                                                    <div id="year_created"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">mois</h4>
                                                    <div id="mois_created"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">jour</h4>
                                                    <div id="day_created"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <h4 class="card-title text-center"> Accepté le : </h4>
                                            <div class="col-md-12 text-center">
                                                <div class="switch">
                                                    <label>Non
                                                        <input id="fv_accepted" type="checkbox" onchange="$(this).is(':checked') ? $('#fl_accepted').show() : $('#fl_accepted').hide() "><span class="lever switch-col-deep-purple"></span>Oui</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div id="fl_accepted">
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">année</h4>
                                                    <div id="year_accepted"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">mois</h4>
                                                    <div id="mois_accepted"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">jour</h4>
                                                    <div id="day_accepted"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <h4 class="card-title text-center"> en traitement le : </h4>
                                            <div class="col-md-12 text-center">
                                                <div class="switch">
                                                    <label>Non
                                                        <input id="fv_pending" type="checkbox" onchange="$(this).is(':checked') ? $('#fl_pending').show() : $('#fl_pending').hide() "><span class="lever switch-col-deep-purple"></span>Oui</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div id="fl_pending">
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">année</h4>
                                                    <div id="year_pending"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">mois</h4>
                                                    <div id="mois_pending"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">jour</h4>
                                                    <div id="day_pending"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <h4 class="card-title text-center"> Clôturé le :</h4>
                                            <div class="col-md-12 text-center">
                                                <div class="switch">
                                                    <label>Non
                                                        <input id="fv_closed" type="checkbox" onchange="$(this).is(':checked') ? $('#fl_closed').show() : $('#fl_closed').hide() "><span class="lever switch-col-deep-purple"></span>Oui</label>
                                                </div>
                                            </div>
                                            <br>
                                            <div id="fl_closed">
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">année</h4>
                                                    <div id="year_closed"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">mois</h4>
                                                    <div id="mois_closed"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">jour</h4>
                                                    <div id="day_closed"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </section>
                                <div id="extra_space">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                <div class="form-group" id="assitance_type">
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


        var tech;
        var affect;

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData);
        $('#bodytab').html("");
        $('#fv_ref_select').html(" <option  value=\"0\" selected  >tout les réclamations </option>")
        for (let ind = 0; ind < jsonData.length; ind++) {
            $('#fv_ref_select').append(" <option  value=\"" + jsonData[ind].reclamation_id + "\"> " + jsonData[ind].reclamation_ref + " </option>")

            if (jsonData[ind].tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData[ind].tech_nom + " " + jsonData[ind].tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData[ind].tech_photo + "\" width=\"220\" /><br />" +
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
            var pending_with_pv;
            var closed_with_pv;



            switch (jsonData[ind].accepted) {
                case null:
                    affect = " N/A ";
                    acceptation = "";
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
                    if (jsonData[ind].accepted) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">clôturer</button>";

                    } else {
                        traitement = "";
                    }
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">clôturer</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"

                    if (jsonData[ind].pending_at == null) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    } else {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    }
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData[ind].affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData[ind].tech_id + " ,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">changer</a>"
            }

            if (jsonData[ind].pending_with_pv) {
                pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData[ind].pending_pv_image + "\" target=\"_blank\"> en traitement </a></h4>";
            } else {
                pending_with_pv = "";
            }

            if (jsonData[ind].closed_with_pv) {
                closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData[ind].closed_pv_image + "\" target=\"_blank\"> clôturé </a></h4>";
            } else {
                closed_with_pv = "";
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
                "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData[ind].accepted_at == null ? "N/A" : jsonData[ind].accepted_at) + "</h4>" +
                "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData[ind].pending_at == null ? "N/A" : jsonData[ind].pending_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData[ind].finished_at == null ? "N/A" : jsonData[ind].finished_at) + "</h4>" +
                pending_with_pv +
                closed_with_pv +
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

                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "</div>" +
                "</div>");
        }
        $('#fl_ref_text').hide();
        // $('#fl_client').hide();
        // $('#fl_departement').hide();
        // $('#fl_agence').hide();
        // $('#fl_produit').hide();
        // $('#fl_ref_equip').hide()
        // $('#fl_equipement').hide();
        // $('#fl_anomalie').hide();
        // $('#fl_tech').hide();
        // $('#fl_etat').hide();
        //$('#extra_space').hide();

        document.getElementsByTagName('fv_dr').checked = false;

        document.getElementsByTagName('fl_created').checked = false;
        document.getElementsByTagName('fl_accepted').checked = false;
        document.getElementsByTagName('fl_pending').checked = false;
        document.getElementsByTagName('fl_closed').checked = false;

        $('#fl_created').hide()
        $('#fl_accepted').hide()
        $('#fl_pending').hide()
        $('#fl_closed').hide()

        fill_list();
    }


    function filter_all() {

       

        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip', 'fv_anomalie', 'fv_etat', 'fv_tech']
        var dates = ['created', 'accepted', 'pending', 'closed']
        var date_types = ['year', 'mois', 'day']

        form_data = new FormData();

        var recl_id 
        $('#rd_list').is(':checked') ? recl_id = $('#fv_ref_select').val() : recl_id = $('#fv_ref_text').val()
        form_data.append('fv_reclamation', recl_id);

        form_data.append('non_affected', $('#fv_dr').is(':checked'));
        form_data.append('is_accepted', $('#accepted').is(':checked'));
        form_data.append('is_pending', $('#pending').is(':checked'));

        form_data.append('reclamation_id', recl_id);


        for (var val in ids) {
            form_data.append(ids[val], $('#' + ids[val]).val());
        }

        for (var i in dates) {
            
            form_data.append('fv_' + dates[i], $('#fv_' + dates[i]).is(':checked'));
            for (var j in date_types) {
                form_data.append(date_types[j] + "_" + dates[i] + "_from", $('#' + date_types[j] + "_" + dates[i]).data().from);
                form_data.append(date_types[j] + "_" + dates[i] + "_to", $('#' + date_types[j] + "_" + dates[i]).data().to);
            }
        }



        var tech;
        var affect;

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/filter_index",
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
        console.log(jsonData);
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {

            if (jsonData[ind].tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData[ind].tech_nom + " " + jsonData[ind].tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData[ind].tech_photo + "\" width=\"220\" /><br />" +
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
            var pending_with_pv;
            var closed_with_pv;



            switch (jsonData[ind].accepted) {
                case null:
                    affect = " N/A ";
                    acceptation = "";
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
                    if (jsonData[ind].accepted) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">clôturer</button>";

                    } else {
                        traitement = "";
                    }
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">clôturer</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"

                    if (jsonData[ind].pending_at == null) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    } else {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    }
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData[ind].affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData[ind].tech_id + " ,'" + jsonData[ind].reclamation_ref + "'," + ind + ")\">changer</a>"
            }

            if (jsonData[ind].pending_with_pv) {
                pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData[ind].pending_pv_image + "\" target=\"_blank\"> en traitement </a></h4>";
            } else {
                pending_with_pv = "";
            }

            if (jsonData[ind].closed_with_pv) {
                closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData[ind].closed_pv_image + "\" target=\"_blank\"> clôturé </a></h4>";
            } else {
                closed_with_pv = "";
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
                "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData[ind].accepted_at == null ? "N/A" : jsonData[ind].accepted_at) + "</h4>" +
                "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData[ind].pending_at == null ? "N/A" : jsonData[ind].pending_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData[ind].finished_at == null ? "N/A" : jsonData[ind].finished_at) + "</h4>" +
                pending_with_pv +
                closed_with_pv +
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

                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +

                "</div>" +
                "</div>");
        }
    }

    function affecter(us_id, id, place) {

        $('#affectationhead').html("<h4 class=\"modal-title\" >selectionner un technicien</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        // $('#affectationfooter').html("<button type=\"hidden\"  id=\"id_d\" value=\""+id+"\">");
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/get_techniciens/" + us_id,
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#created_by').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            var affect = ""

            switch (jsonData[ind].nb_affect.length) {
                case 0:
                    affect = "0 en cours et 0 en traitement ";
                    break;
                case 1:
                    jsonData[ind].nb_affect[0].etat_id == 1 ? affect = jsonData[ind].nb_affect[0].nb + " en cours et 0 en traitement " : affect = " 0  en cours  et " + jsonData[ind].nb_affect[0].nb + "  en traitement"

                    break;
                case 2:
                    affect = jsonData[ind].nb_affect[0].nb + " en cours  et " + jsonData[ind].nb_affect[1].nb + " en traitement"
                    break;
            }

            $('#created_by').append("<a  class=\"list-group-item value=\"" + jsonData[ind].user.id + "\" onclick=\"select(" + us_id + ",'" + id + "'," + jsonData[ind].user.id + "," + place + ")\"> <span class=\"mytooltip tooltip-effect-5\">" +
                "<span class=\"tooltip-item\"> <b>" + jsonData[ind].user.nom + " " + jsonData[ind].user.prénom + "</b> <br>" + affect + " </span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData[ind].user.photo + "\" width=\"220\" /><br />" +
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

    function select(old, ref, id_u, ind) {
        var tech;
        var affect;
        var inputs = {
            "ref": ref,
            "id_u": id_u,
            "old": old
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
                "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"220\" /><br />" +
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
        var pending_with_pv;
        var closed_with_pv;




        switch (jsonData.accepted) {
            case null:
                affect = " N/A ";
                acceptation = "";
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
                if (jsonData.accepted) {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";

                } else {
                    traitement = "";
                }
                download_pdf = "";
                break;

            case 2:
                ref_color = "warning";
                det_color = "color:#857b26;background-color:#fff8b3"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                    "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";
                download_pdf = "";
                break;
            case 3:
                ref_color = "info";
                det_color = "color:#385d7a;background-color:#d6eeff"
                if (jsonData.pending_at == null) {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                } else {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                }
                download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                break;
        }



        if (jsonData.affectation_id == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData.tech_id + " ,'" + jsonData.reclamation_ref + "'," + ind + ")\">changer</a>"
        }
        if (jsonData.pending_with_pv) {
            pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.pending_pv_image + "\" target=\"_blank\"> en traitement</a></h4>";
        } else {
            pending_with_pv = "";
        }
        if (jsonData.closed_with_pv) {
            closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.closed_pv_image + "\" target=\"_blank\"> clôturé</a></h4>";
        } else {
            closed_with_pv = "";
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
            "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.accepted_at == null ? "N/A" : jsonData.accepted_at) + "</h4>" +
            "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData.pending_at == null ? "N/A" : jsonData.pending_at) + "</h4>" +
            "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
            pending_with_pv +
            closed_with_pv +
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
            "<div id=\"tach_coll" + ind + "\" class=\"collapse  show\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            affectation +
            acceptation +
            traitement +
            download_pdf +

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
                "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"220\" /><br />" +
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
        var pending_with_pv;
        var closed_with_pv;



        switch (jsonData.accepted) {
            case null:
                affect = " N/A ";
                acceptation = "";
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
                if (jsonData.accepted) {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";

                } else {
                    traitement = "";
                }
                download_pdf = "";
                break;

            case 2:
                ref_color = "warning";
                det_color = "color:#857b26;background-color:#fff8b3"
                traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                    "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";
                download_pdf = "";
                break;
            case 3:
                ref_color = "info";
                det_color = "color:#385d7a;background-color:#d6eeff"
                if (jsonData.pending_at == null) {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                } else {
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                }
                download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                break;
        }





        if (jsonData.affectation_id == null) {
            affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
        } else {
            affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData.tech_id + " ,'" + jsonData.reclamation_ref + "'," + ind + ")\">changer</a>"
        }


        if (jsonData.pending_with_pv) {
            pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.pending_pv_image + "\" target=\"_blank\"> en traitement</a></h4>";
        } else {
            pending_with_pv = "";
        }
        if (jsonData.closed_with_pv) {
            closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.closed_pv_image + "\" target=\"_blank\"> clôturé</a></h4>";
        } else {
            closed_with_pv = "";
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
            "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.accepted_at == null ? "N/A" : jsonData.accepted_at) + "</h4>" +
            "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData.pending_at == null ? "N/A" : jsonData.pending_at) + "</h4>" +
            "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
            pending_with_pv +
            closed_with_pv +
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
            "<div id=\"tach_coll" + ind + "\" class=\"collapse  show\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            affectation +
            acceptation +
            traitement +
            download_pdf +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");


    }





    function traiter(etat_id, id, ind) {


        var title = "";

        etat_id == 2 ? title = " mettre en traitement " : title = " clôturer "


        // var buttonacive;
        $('#modalhead').html("<h4 class=\"modal-title\" >" + title + "</h4>" +
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

        etat_id == 2 ? $('#assitance_type').hide() : $('#assitance_type').show()


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
            form_data.append("etat_id", etat_id);

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
            var pending_with_pv;
            var closed_with_pv;

            if (jsonData.tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"220\" /><br />" +
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
                    acceptation = "";
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
                    if (jsonData.accepted) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";

                    } else {
                        traitement = "";
                    }
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"
                    if (jsonData.pending_at == null) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    } else {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    }
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData.affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData.tech_id + " ,'" + jsonData.reclamation_ref + "'," + ind + ")\">changer</a>"
            }

            if (jsonData.pending_with_pv) {
                pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.pending_pv_image + "\" target=\"_blank\"> en traitement </a></h4>";
            } else {
                pending_with_pv = "";
            }

            if (jsonData.closed_with_pv) {
                closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.closed_pv_image + "\" target=\"_blank\"> clôturé</a></h4>";
            } else {
                closed_with_pv = "";
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
                "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.accepted_at == null ? "N/A" : jsonData.accepted_at) + "</h4>" +
                "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData.pending_at == null ? "N/A" : jsonData.pending_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
                pending_with_pv +
                closed_with_pv +
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
                "<div id=\"tach_coll" + ind + "\" class=\"collapse  show\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"button-group text-center\">" +
                affectation +
                acceptation +
                traitement +
                download_pdf +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");

        });
    }

    function edit(etat_id, id, ind) {


        var title = "";
        var start_pv = ""
        if (etat_id == 2) {
            title = " rapport en traitement ";
            $('#assitance_type').hide();
            start_pv = "pend_";
        } else {
            title = " rapport clôturer ";
            $('#assitance_type').show();
            start_pv = "clo_";
        }


        // var buttonacive;
        $('#modalhead').html("<h4 class=\"modal-title\" >" + title + "</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");

        $('#ref_rapport').html(" Ref : <b>" + id + "</b>");

        var inputs = {
            "etat_id": etat_id,
            "ref": id,
        };

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/get_rapport",
            dataType: "json",
            type: "get",
            async: false,
            data: inputs,
        }).responseText;

        jsonData = JSON.parse(StringData);
        console.log(jsonData.id)

        if (jsonData.with_pv) {
            $('#pv_id').show()
            $('#with_pv').val('true');

        } else {
            $('#pv_id').hide()
            $('#with_pv').val('false');
        }

        $('#with_pv').selectpicker('refresh');


        $('#type').val(jsonData.type);
        $('#type').selectpicker('refresh');

        $('#commentaire').val(jsonData.commentaire);


        $('#pv_id').html("<label for=\"pv_image\">image PV</label>" +
            "<input type=\"file\" id=\"pv_image\" name=\"pv_image\" class=\"dropify\" data-default-file=\"" + $('#' + start_pv + "pv" + ind).find('a').attr('href') + "\"  />");
        $('.dropify').dropify();

        $('#exampleModal').modal('show');

        $('#with_pv').change(function() {

            if ($(this).val() == 'true') {

                $('#pv_id').show();
            } else {
                $('#pv_id').hide();
            }
        });

        $('#edit').click(function() {

            form_data = new FormData();

            form_data.append("pv_image", $('#pv_image')[0].files[0]);
            form_data.append("type", $('#type').val());
            form_data.append("with_pv", $('#with_pv').val());
            form_data.append("commentaire", $('#commentaire').val());

            form_data.append("rapport_id", jsonData.id);
            form_data.append("etat_id", etat_id);
            form_data.append("ref", id);

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/reclamation/recls/edit_raport",
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
            console.log(jsonData)
            var tech;
            var affect;

            var ref_color = "";
            var det_color = "";
            var affectation;
            var acceptation;
            var traitement;
            var download_pdf;
            var pending_with_pv;
            var closed_with_pv;

            if (jsonData.tech_nom == null) {
                tech = " <span id=\"tech" + ind + "\" value=\"0\"> pas de technicien affecté</span>"
            } else {
                tech = "<span class=\"mytooltip tooltip-effect-5\" id=\"tech" + ind + "\" >" +
                    "<span class=\"tooltip-item\">" + jsonData.tech_nom + " " + jsonData.tech_prenom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.tech_photo + "\" width=\"220\" /><br />" +
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
                    acceptation = "";
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
                    if (jsonData.accepted) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-warning\"  onclick=\"traiter(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">mettre en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";

                    } else {
                        traitement = "";
                    }
                    download_pdf = "";
                    break;

                case 2:
                    ref_color = "warning";
                    det_color = "color:#857b26;background-color:#fff8b3"
                    traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\"  onclick=\"traiter(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">clôturer</button>";
                    download_pdf = "";
                    break;
                case 3:
                    ref_color = "info";
                    det_color = "color:#385d7a;background-color:#d6eeff"
                    if (jsonData.pending_at == null) {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    } else {
                        traitement = "<button type=\"button\" class=\"btn waves-effect waves-light btn-info\"  onclick=\"edit(2,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport en traitement</button>" +
                            "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"  onclick=\"edit(3,'" + jsonData.reclamation_ref + "'," + ind + ")\">rapport clôturé</button>";
                    }
                    download_pdf = "<button type=\"button\" class=\"btn waves-effect waves-light btn-instagram\" >Exporter PDF</button>";
                    break;
            }


            if (jsonData.affectation_id == null) {
                affectation = "<button type=\"button\" class=\"btn waves-effect waves-light btn-inverse\"  onclick=\"affecter(-1 ,'" + jsonData.reclamation_ref + "'," + ind + ")\">affecter</button>"
            } else {
                affectation = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\" onclick=\"affecter(" + jsonData.tech_id + " ,'" + jsonData.reclamation_ref + "'," + ind + ")\">changer</a>"
            }

            if (jsonData.pending_with_pv) {
                pending_with_pv = "<h4 id=\"pend_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.pending_pv_image + "\" target=\"_blank\"> en traitement </a></h4>";
            } else {
                pending_with_pv = "";
            }

            if (jsonData.closed_with_pv) {
                closed_with_pv = "<h4 id=\"clo_pv" + ind + "\" class=\"card-title\"> <strong> lien pv </strong>:<a href=\"{{ asset('storage') }}/" + jsonData.closed_pv_image + "\" target=\"_blank\"> clôturé</a></h4>";
            } else {
                closed_with_pv = "";
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
                "<h4 id=\"accepted_at" + ind + "\" class=\"card-title\"> <strong> accepté le  </strong>: " + (jsonData.accepted_at == null ? "N/A" : jsonData.accepted_at) + "</h4>" +
                "<h4 id=\"pending_at" + ind + "\" class=\"card-title\"> <strong> en traitement le  </strong>: " + (jsonData.pending_at == null ? "N/A" : jsonData.pending_at) + "</h4>" +
                "<h4 id=\"finished_at" + ind + "\" class=\"card-title\"> <strong> terminé le </strong>: " + (jsonData.finished_at == null ? "N/A" : jsonData.finished_at) + "</h4>" +
                pending_with_pv +
                closed_with_pv +
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
                "<div id=\"tach_coll" + ind + "\" class=\"collapse  show\" role=\"tabpanel\" aria-labelledby=\"tacheOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"button-group text-center\">" +
                affectation +
                acceptation +
                traitement +
                download_pdf +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");

        });
    }

    function check(input) {

        if (input.id == 'rd_manuel') {
            $('#fl_ref_select').hide()
            $('#fl_ref_text').show()
        } else {
            $('#fl_ref_select').show()
            $('#fl_ref_text').hide()
        }
    }



    function etat_filter(input) {

        if (!$(input).is(':checked')) {
            $('#fl_etat').hide()
            $('#extra_space').hide()
        } else {
            $('#fl_etat').show()
            $('#extra_space').show()
        }
    }

    function fill_list() {

        $('#fv_client').html(" <option  value=\"0\"selected >tout  </option>")
        $('#fv_departement').html(" <option  value=\"0\"selected >tout  </option>")
        $('#fv_agence').html(" <option  value=\"0\"selected >tout </option>")
        $('#fv_produit').html(" <option  value=\"0\"selected >tout  </option>")
        $('#fv_equipement').html(" <option  value=\"0\"selected >tout  </option>")
        $('#fv_ref_equip').html(" <option  value=\"0\"selected >tout  </option>")
        $('#fv_anomalie').html(" <option  value=\"0\"selected >tout </option>")
        $('#fv_tech').html(" <option  value=\"0\"selected >tout les  </option>")


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/fill_list",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        // console.log(jsonData)

        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement']



        for (let ind = 0; ind < ids.length; ind++) {
            for (let j = 0; j < jsonData[ids[ind]].length; j++) {
                $('#' + ids[ind]).append("<option value=\"" + jsonData[ids[ind]][j].id + "\">" + jsonData[ids[ind]][j].nom + "</option>");
            }
        }

        for (let j = 0; j < jsonData['fv_ref_equip'].length; j++) {
            $('#fv_ref_equip').append("<option value=\"" + jsonData['fv_ref_equip'][j].equip_ref + "\">" + jsonData['fv_ref_equip'][j].equip_ref + "</option>");
        }

        for (let j = 0; j < jsonData['fv_anomalie'].length; j++) {
            $('#fv_anomalie').append("<option value=\"" + jsonData['fv_anomalie'][j].id + "\">" + jsonData['fv_anomalie'][j].value + "</option>");
        }

        for (let j = 0; j < jsonData['fv_tech'].length; j++) {
            $('#fv_tech').append("<option value=\"" + jsonData['fv_tech'][j].id + "\">" + jsonData['fv_tech'][j].nom + " " + jsonData['fv_tech'][j].prénom + "</option>");
        }

    }

    function filter_data(declancheur) {

        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement']
        var checks = new Object();
        form_data = new FormData();
        var check = false;
        form_data.append('declancheur_id', declancheur.id);
        for (var val in ids) {
            form_data.append(ids[val], $('#' + ids[val]).val());
            form_data.append("check_" + ids[val], check);
            checks[ids[val]] = check;
            if (ids[val] == declancheur.id) {
                check = true;
            }
        }

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/reclamation/recls/filter_data",
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

        console.log(jsonData)

        for (var val in checks) {
            if (checks[val]) {
                $('#' + val).html(" <option value=\"0\"  selected >tout  </option>")
            }
        }


        for (var ind in checks) {
            for (let j = 0; j < jsonData[ind].length; j++) {
                if (checks[ind]) {
                    $('#' + ind).append("<option value=\"" + jsonData[ind][j].id + "\" >" + jsonData[ind][j].nom + "</option>");
                }
            }
        }
        $('#fv_ref_equip').html(" <option  value=\"0\"selected >tout  </option>")
        for (let j = 0; j < jsonData['fv_ref_equip'].length; j++) {

            $('#fv_ref_equip').append("<option value=\"" + jsonData['fv_ref_equip'][j].equip_ref + "\">" + jsonData['fv_ref_equip'][j].equip_ref + "</option>");
        }

    }
</script>
<script type="text/javascript">
    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', function() {
        $("#mois_created").ionRangeSlider({
            type: "double",
            min: 1,
            max: 12,
        });

        $("#year_created").ionRangeSlider({
            type: "double",
            min: 2018,
            max: new Date().getFullYear()
        });

        $("#day_created").ionRangeSlider({
            type: "double",
            min: 1,
            max: 31
        });

        $("#mois_accepted").ionRangeSlider({
            type: "double",
            min: 1,
            max: 12
        });

        $("#year_accepted").ionRangeSlider({
            type: "double",
            min: 2018,
            max: new Date().getFullYear()
        });

        $("#day_accepted").ionRangeSlider({
            type: "double",
            min: 1,
            max: 31
        });

        $("#mois_pending").ionRangeSlider({
            type: "double",
            min: 1,
            max: 12
        });

        $("#year_pending").ionRangeSlider({
            type: "double",
            min: 2018,
            max: new Date().getFullYear()
        });

        $("#day_pending").ionRangeSlider({
            type: "double",
            min: 1,
            max: 31
        });
        $("#mois_closed").ionRangeSlider({
            type: "double",
            min: 1,
            max: 12
        });

        $("#year_closed").ionRangeSlider({
            type: "double",
            min: 2018,
            max: new Date().getFullYear()
        });

        $("#day_closed").ionRangeSlider({
            type: "double",
            min: 1,
            max: 31
        });
    }); //script 
</script>
@endsection