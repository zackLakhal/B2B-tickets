@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-8 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">{{$departement->nom}}</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils client</li>
            <li class="breadcrumb-item text-themecolor">Gérer les clients</li>
            <li class="breadcrumb-item text-themecolor" value="{{$departement->client_id}}" id="id_c">{{$departement->client->nom}}</li>
            <li class="breadcrumb-item active" value="{{$departement->id}}" id="id_d">{{$departement->nom}}</li>

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
@if(auth::user()->role_id == 1 || auth::user()->role_id == 6 || auth::user()->role_id == 4)

<div class="row">
    <div class="col-12 m-t-30">
        <div class="card">
            <div class="card-body">

                <div class="button-group text-center">
                    <button type="button" id="newmodal" class="btn btn-lg btn-primary ">
                        <i class="fa fa-plus"></i> ajouter une nouvelle agence
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="">
    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter  text-white"></i></button>
</div>
@endif
<div class="row" id="bodytab">

</div>
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title text-center" style="font-weight : bold; font-size: 25px"> Filtrer <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">

            <div class="demo-radio-button">
                <input name="group1" type="radio" id="rd_nom" onclick="check(this)" checked />
                <label for="rd_nom">Par nom</label>
                <input name="group1" type="radio" id="rd_email" onclick="check(this)" />
                <label for="rd_email">Par email</label>

            </div>
            <div class="form-group" id="fl_nom">
                <label class="control-label ">Nom agence</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_nom" id="fv_nom">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">Email agence</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_email" id="fv_email">

                </select>
            </div>
            <div class="form-group" id="fl_ville">
                <label class="control-label ">ville</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_ville" id="fv_ville">

                </select>
            </div>
            <h4 class="card-title">actif et supprimé ?</h4>
            <div class="col-md-12">
                <div class="switch">
                    <label>Non
                        <input id="fv_dr" type="checkbox"><span class="lever switch-col-light-green"></span>Oui</label>
                </div>
            </div>
            <br>
            <div class="demo-radio-button" id="dr_group">
                <input name="deleted" type="radio" id="active" value="false" checked />
                <label for="active">actif</label>
                <input name="deleted" type="radio" id="deleted" value="true" />
                <label for="deleted">supprimé</label>

            </div>
            <br>
            <div class="button-group text-center">
                <button class="btn waves-effect waves-light btn-inverse" id="filter"> Chercher </button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" rqt="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="modalhead">

            </div>
            <div class="modal-body" id="modalbody">

                <div class="form-group" id="err-nom">
                    <label for="nom" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom" name="nom">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-email">
                    <label for="email" class="control-label"><b>email:</b></label>
                    <input type="text" class="form-control" id="email" name="email">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-password">
                    <label for="password" class="control-label"><b>mot de passe:</b></label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-control-feedback"> </small>
                </div>

                <div class="form-group" id="err-tel">
                    <label for="tel" class="control-label"><b>tel:</b></label>
                    <input type="text" class="form-control" id="tel" name="tel">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-ville">
                    <label class="control-label">ville</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="ville" id="ville">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-adress">
                    <label for="adress" class="control-label"><b>adress:</b></label>
                    <input type="text" class="form-control" id="adress" name="adress">
                    <small class="form-control-feedback"> </small>
                </div>

            </div>
            <div class="modal-footer" id="modalfooter">
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="affectation" tabindex="-1" rqt="dialog" aria-labelledby="affectationlabel">
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
</div> -->


<div class="modal fade" id="prod" tabindex="-1" rqt="dialog" aria-labelledby="prodlabel">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="prodhead">

            </div>
            <div class="modal-body " id="prodbody">

                <div class="form-group" id="err-data">
                    <label class="control-label">produits</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="produit" id="produit">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>

                <div class="list-group" id="equip_inputs">


                </div>


            </div>
            <div class="modal-footer" id="prodfooter">
            </div>
        </div>
    </div>
</div>
<!-- /.modal 2-->
<div class="modal fade bs-example-modal-sm" id="messagebox" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Message</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="content"> content will be here </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal 2 -->

@endsection
@section('script')
<script>
    $(document).ready(function() {
        init()

    });

    function message(objet, action, statut) {
        var message;
        if (statut == "done") {
            message = "votre " + objet + " est " + action + " avec succès";
        } else {
            message = "votre " + objet + " n'est pas " + action;
        }
        $('#content').html(message);
        $('#messagebox').modal('show');

    }

    function init() {

        var buttonacive;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        // // console.log(jsonData)
        $('#bodytab').html("");
        var role_id = $('#logged_info').attr('value');

        $('#fv_nom').html(" <option  value=\"0\"selected  >tout les agences </option>")
        $('#fv_email').html(" <option  value=\"0\"selected  >tout les agences </option>")
        for (let ind = 0; ind < jsonData.agences.length; ind++) {
            $('#fv_nom').append("<option value=\"" + jsonData.agences[ind].id + "\">" + jsonData.agences[ind].nom + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData.agences[ind].id + "\">" + jsonData.agences[ind].email + "</option>");

            produit = "";
            // if (jsonData.chefs[ind] == null) {
            //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">affecter un chef</button>"
            // } else {
            //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chefs[ind].id + "\">" +
            //         "<span class=\"tooltip-item\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</span> <span class=\"tooltip-content clearfix\">" +
            //         "<img src=\"{{ asset('storage') }}/" + jsonData.chefs[ind].photo + "\" width=\"180\" /><br />" +
            //         "<span class=\"tooltip-text p-t-10\">" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].email + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].tel + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].adress + "</p>" +
            //         "</span> </span>" +
            //         "</span>";
            //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">changer chef</button>"

            // }
            if (jsonData.agences[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agences[ind].id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agences[ind].id + "," + ind + ")\">restorer</button>"
            }

            for (let j = 0; j < jsonData.souscriptions[ind].produits.length; j++) {
                var qt_ne = 0.00;
                equipements = "";
                var inputs = {
                    "id_a": jsonData.souscriptions[ind].id,
                    "id_p": jsonData.souscriptions[ind].produits[j].prod_id
                };
                var StringData1 = $.ajax({
                    url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                    dataType: "json",
                    type: "GET",
                    async: false,
                    data: inputs
                }).responseText;
                jsonData1 = JSON.parse(StringData1);
                //// console.log(jsonData1)
                for (let k = 0; k < jsonData1.equipements.length; k++) {
                    refs = "";

                    for (let f = 0; f < jsonData1.refs.length; f++) {
                        if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                            var val = "";
                            if (jsonData1.refs[f].ref != null) {
                                val = jsonData1.refs[f].ref
                            }
                            refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                                "<input type=\"text\" "+ (role_id == '1' || role_id == '6' ? "" : " disabled " ) +" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                                "<span class=\"input-group-btn\">" +
                                "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                                "</span>" +
                                "<br>" +
                                "</div>" +
                                "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                            if (jsonData1.refs[f].ref_ne != 0) {
                                qt_ne++;
                            }
                        }


                    }

                    equipements = equipements +
                        "<div class=\"ribbon-wrapper card\">" +
                        "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                        "<div class=\"ribbon-content\" >" +
                        refs +
                        "</div>" +
                        "</div>";


                }
                var color = "";
                switch (qt_ne) {
                    case 0:
                        color = "red";
                        break;

                    case jsonData1.refs.length:
                        color = "green";
                        break;

                    default:
                        color = "yellow";
                        break;
                }

                produit = produit +
                    "<div class=\"card\">" +
                    "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<h5 class=\"mb-0 text-center\">" +
                    "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<span style=\"float:left\">" + jsonData.souscriptions[ind].produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                    "</a>" +
                    "</h5>" +
                    "</div>" +

                    "<div id=\"collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<div class=\"card-body\">" +
                    "<div>" +
                    "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                    equipements +
                    "</div>" +
                    "</div>" +
                    "<div class=\"button-group text-center\">" +
                    (role_id == '1' || role_id == '6'  ? "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agences[ind].id + "," + jsonData.souscriptions[ind].produits[j].prod_id + "," + ind + ")\">supprimer</button>" : "") +
                    "</div>" +
                    "</div>" +
                    "</div>";

            }
            $('#bodytab').append("<div class=\"col-12 \" id=\"card" + ind + "\">" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agences[ind].nom + "</h2>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<h2  class=\"card-title text-center\" > informations</h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agences[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agences[ind].tel + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.villes[ind].id + "\" id=\"ville" + ind + "\">" + jsonData.villes[ind].nom + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agences[ind].adress + "</spane></h4>" +
                //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agences[ind].id + "," + ind + ")\">modifier</button>" +
                (role_id != '5' ? buttonacive : "") +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \">" +
                "<div class=\"card\" id=\"product\">" +
                "<h3 class=\"card-title text-center\">produits</h3>" +
                "<hr>" +
                "<div class=\"card-body\">" +

                "<div class=\"button-group text-center\">" +
                (role_id == '1' || role_id == '6'  ? "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agences[ind].id + "," + ind + ")\"> attacher produit</button>" : "") +
                "</div>" +
                "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                produit +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }

        $('#ville').html(" <option  value=\"0\"selected disabled >selectioner une ville </option>")
        $('#fv_ville').html(" <option  value=\"0\"selected >tout les villes </option>")

        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/system/ville/active_index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);

        for (let ind = 0; ind < jsonData1.length; ind++) {
            $('#ville').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].nom + "</option>");
            $('#fv_ville').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].nom + "</option>");

        }
        $('#ville').selectpicker('refresh');
        $('#fv_ville').selectpicker('refresh');

        $('#fv_nom').selectpicker('refresh');
        $('#fv_email').selectpicker('refresh');
        // $('#fv_dr').attr("checked", "");
        $('#fl_email').hide()
        document.getElementsByTagName('fv_dr').checked = false;


        document.getElementsByTagName('rd_nom').checked = true;



    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouvelle agence </h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#nom').val("");
        $('#email').val("");
        $('#password').val("");
        $('#err-password').show();
        $('#tel').val("");
        $('#adress').val("");
        $('#ville').val("");
        $('#ville').selectpicker('refresh');
        $('#exampleModal').modal('show');
        $('#save').click(function() {
            var inputs = {
                "nom": $('#nom').val(),
                "email": $('#email').val(),
                "tel": $('#tel').val(),
                "adress": $('#adress').val(),
                "ville": $('#ville').val(),
                "password": $('#password').val(),
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/create",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: inputs
            }).responseText;
            jsonData = JSON.parse(StringData);
            var role_id = $('#logged_info').attr('value');
            // // console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);

                $('#exampleModal').modal('hide');
                message("agence", "ajouté", jsonData.check);

                // if (jsonData.chef == null) {
                //     chef = " <span id=\"chef" + jsonData.count + "\" value=\"0\"> pas de chef d'agence</span>"
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + jsonData.count + ")\">affecter un chef</button>"
                // } else {
                //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + jsonData.count + "\" value=\"" + jsonData.chef.id + "\">" +
                //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                //         "<span class=\"tooltip-text p-t-10\">" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                //         "</span> </span>" +
                //         "</span>";
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + jsonData.count + ")\">changer chef</button>"

                // }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + jsonData.count + ")\">supprimer</button>" //+ buttonaffect
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + jsonData.count + ")\">restorer</button>"
                }
                $('#bodytab').append("<div class=\"col-12 \" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + jsonData.count + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +
                    "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + jsonData.count + "\">" + jsonData.agence.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + jsonData.count + "\">" + jsonData.agence.tel + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + jsonData.count + "\">" + jsonData.ville.nom + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + jsonData.count + "\">" + jsonData.agence.adress + "</spane></h4>" +
                    //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
                    "<br>" +
                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + jsonData.count + ")\">modifier</button>" +
                    buttonacive +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-6 \">" +
                    "<div class=\"card\" id=\"product\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +

                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + jsonData.count + ")\"> attacher produit</button>" +
                    "</div>" +
                    "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +

                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>");

            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    });

    $('#filter').click(function() {

        form_data = new FormData();
        var agence_id;
        var is_deleted;

        $('#rd_nom').is(':checked') ? agence_id = $('#fv_nom').val() : agence_id = $('#fv_email').val()
        $('#active').is(':checked') ? is_deleted = $('#active').val() : is_deleted = $('#deleted').val()

        form_data.append("agence_id", agence_id);
        form_data.append("ville_id", $('#fv_ville').val());
        form_data.append("is_all", $('#fv_dr').is(':checked'));
        form_data.append("is_deleted", is_deleted);

        var buttonacive;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/filter_index",
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
        // // console.log(jsonData)
        var role_id = $('#logged_info').attr('value');
        $('#bodytab').html("");

        for (let ind = 0; ind < jsonData.agences.length; ind++) {

            produit = "";
            // if (jsonData.chefs[ind] == null) {
            //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">affecter un chef</button>"
            // } else {
            //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chefs[ind].id + "\">" +
            //         "<span class=\"tooltip-item\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</span> <span class=\"tooltip-content clearfix\">" +
            //         "<img src=\"{{ asset('storage') }}/" + jsonData.chefs[ind].photo + "\" width=\"180\" /><br />" +
            //         "<span class=\"tooltip-text p-t-10\">" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].email + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].tel + "</p>" +
            //         "<p class=\"card-text text-center\">" + jsonData.chefs[ind].adress + "</p>" +
            //         "</span> </span>" +
            //         "</span>";
            //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">changer chef</button>"

            // }
            if (jsonData.agences[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agences[ind].id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agences[ind].id + "," + ind + ")\">restorer</button>"
            }

            for (let j = 0; j < jsonData.souscriptions[ind].produits.length; j++) {
                var qt_ne = 0.00;
                equipements = "";
                var inputs = {
                    "id_a": jsonData.souscriptions[ind].id,
                    "id_p": jsonData.souscriptions[ind].produits[j].prod_id
                };
                var StringData1 = $.ajax({
                    url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                    dataType: "json",
                    type: "GET",
                    async: false,
                    data: inputs
                }).responseText;
                jsonData1 = JSON.parse(StringData1);
                //// console.log(jsonData1)
                for (let k = 0; k < jsonData1.equipements.length; k++) {
                    refs = "";

                    for (let f = 0; f < jsonData1.refs.length; f++) {
                        if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                            var val = "";
                            if (jsonData1.refs[f].ref != null) {
                                val = jsonData1.refs[f].ref
                            }
                            refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                                "<input type=\"text\" "+ (role_id == '1' || role_id == '6' ? "" : " disabled " ) +" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                                "<span class=\"input-group-btn\">" +
                                "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                                "</span>" +
                                "<br>" +
                                "</div>" +
                                "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                            if (jsonData1.refs[f].ref_ne != 0) {
                                qt_ne++;
                            }
                        }


                    }

                    equipements = equipements +
                        "<div class=\"ribbon-wrapper card\">" +
                        "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                        "<div class=\"ribbon-content\" >" +
                        refs +
                        "</div>" +
                        "</div>";


                }
                var color = "";
                switch (qt_ne) {
                    case 0:
                        color = "red";
                        break;

                    case jsonData1.refs.length:
                        color = "green";
                        break;

                    default:
                        color = "yellow";
                        break;
                }

                produit = produit +
                    "<div class=\"card\">" +
                    "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<h5 class=\"mb-0 text-center\">" +
                    "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<span style=\"float:left\">" + jsonData.souscriptions[ind].produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                    "</a>" +
                    "</h5>" +
                    "</div>" +

                    "<div id=\"collapseex" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscriptions[ind].produits[j].prod_id + "_" + jsonData.souscriptions[ind].id + "\">" +
                    "<div class=\"card-body\">" +
                    "<div>" +
                    "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                    equipements +
                    "</div>" +
                    "</div>" +
                    "<div class=\"button-group text-center\">" +
                    (role_id == '1' || role_id == '6'  ? "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agences[ind].id + "," + jsonData.souscriptions[ind].produits[j].prod_id + "," + ind + ")\">supprimer</button>" : "") +
                    "</div>" +
                    "</div>" +
                    "</div>";

            }
            $('#bodytab').append("<div class=\"col-12 \" id=\"card" + ind + "\">" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agences[ind].nom + "</h2>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<h2  class=\"card-title text-center\" > informations</h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agences[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agences[ind].tel + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.villes[ind].id + "\" id=\"ville" + ind + "\">" + jsonData.villes[ind].nom + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agences[ind].adress + "</spane></h4>" +
                //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agences[ind].id + "," + ind + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \">" +
                "<div class=\"card\" id=\"product\">" +
                "<h3 class=\"card-title text-center\">produits</h3>" +
                "<hr>" +
                "<div class=\"card-body\">" +

                "<div class=\"button-group text-center\">" +
                (role_id == '1' || role_id == '6'  ? "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agences[ind].id + "," + ind + ")\"> attacher produit</button>" : "") +
                "</div>" +
                "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                produit +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }
    });



    function supprimer(id, ind) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/delete/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);
        // console.log(jsonData)
        message("agence", "supprimé", jsonData.check);
        var role_id = $('#logged_info').attr('value');
        produit = "";
        // if (jsonData.chef == null) {
        //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
        // } else {
        //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
        //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
        //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
        //         "<span class=\"tooltip-text p-t-10\">" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
        //         "</span> </span>" +
        //         "</span>";
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

        // }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + ind + ")\">restorer</button>"
        }

        for (let j = 0; j < jsonData.souscription.produits.length; j++) {
            var qt_ne = 0.00;
            equipements = "";
            var inputs = {
                "id_a": jsonData.souscription.id,
                "id_p": jsonData.souscription.produits[j].prod_id
            };
            var StringData1 = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                dataType: "json",
                type: "GET",
                async: false,
                data: inputs
            }).responseText;
            jsonData1 = JSON.parse(StringData1);

            for (let k = 0; k < jsonData1.equipements.length; k++) {
                refs = "";

                for (let f = 0; f < jsonData1.refs.length; f++) {
                    if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                        var val = "";
                        if (jsonData1.refs[f].ref != null) {
                            val = jsonData1.refs[f].ref
                        }
                        refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                            "<input type=\"text\" "+ (role_id == '1' || role_id == '6' ? "" : " disabled " ) +" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<br>" +
                            "</div>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                        if (jsonData1.refs[f].ref_ne != 0) {
                            qt_ne++;
                        }
                    }


                }
                equipements = equipements +
                    "<div class=\"ribbon-wrapper card\">" +
                    "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                    "<div class=\"ribbon-content\" >" +
                    refs +
                    "</div>" +
                    "</div>";

            }
            var color = "";
            switch (qt_ne) {
                case 0:
                    color = "red";
                    break;

                case jsonData1.refs.length:
                    color = "green";
                    break;

                default:
                    color = "yellow";
                    break;
            }

            produit = produit +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<div class=\"card-body\">" +
                "<div>" +
                "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                equipements +
                "</div>" +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                (role_id == '1' || role_id == '6'  ? "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" : "") +
                "</div>" +
                "</div>" +
                "</div>";

        }

        $('#card' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agence.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agence.tel + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\">" + jsonData.ville.nom + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agence.adress + "</spane></h4>" +
            //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"product\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            (role_id == '1' || role_id == '6'  ? "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" : "") +
            "</div>" +
            "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
            produit +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(id, ind) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/restore/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);
        message("agence", "restauré", jsonData.check);
        var role_id = $('#logged_info').attr('value');
        produit = "";
        // if (jsonData.chef == null) {
        //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
        // } else {
        //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
        //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
        //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
        //         "<span class=\"tooltip-text p-t-10\">" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
        //         "</span> </span>" +
        //         "</span>";
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

        // }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + ind + ")\">restorer</button>"
        }

        for (let j = 0; j < jsonData.souscription.produits.length; j++) {
            var qt_ne = 0.00;
            equipements = "";
            var inputs = {
                "id_a": jsonData.souscription.id,
                "id_p": jsonData.souscription.produits[j].prod_id
            };
            var StringData1 = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                dataType: "json",
                type: "GET",
                async: false,
                data: inputs
            }).responseText;
            jsonData1 = JSON.parse(StringData1);

            for (let k = 0; k < jsonData1.equipements.length; k++) {
                refs = "";

                for (let f = 0; f < jsonData1.refs.length; f++) {
                    if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                        var val = "";
                        if (jsonData1.refs[f].ref != null) {
                            val = jsonData1.refs[f].ref
                        }
                        refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                            "<input type=\"text\" "+ (role_id == '1' || role_id == '6' ? "" : " disabled " ) +" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<br>" +
                            "</div>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";

                        "</div>";
                        if (jsonData1.refs[f].ref_ne != 0) {
                            qt_ne++;
                        }
                    }


                }
                equipements = equipements +
                    "<div class=\"ribbon-wrapper card\">" +
                    "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                    "<div class=\"ribbon-content\" >" +
                    refs +
                    "</div>" +
                    "</div>";

            }
            var color = "";
            switch (qt_ne) {
                case 0:
                    color = "red";
                    break;

                case jsonData1.refs.length:
                    color = "green";
                    break;

                default:
                    color = "yellow";
                    break;
            }

            produit = produit +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<div class=\"card-body\">" +
                "<div>" +
                "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                equipements +
                "</div>" +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                (role_id == '1' || role_id == '6'  ? "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" : "") +
                "</div>" +
                "</div>" +
                "</div>";

        }
        $('#card' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agence.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agence.tel + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\">" + jsonData.ville.nom + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agence.adress + "</spane></h4>" +
            //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"product\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            (role_id == '1' || role_id == '6'  ? "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" : "") +
            "</div>" +
            "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
            produit +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier agence</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
        $('#password').val("");
        $('#err-password').hide();
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#ville').val($('#ville' + ind).attr('value'));
        $('#ville').selectpicker('refresh');
        $('#exampleModal').modal('show');
        $('#edit').click(function() {
            var inputs = {
                "nom": $('#nom').val(),
                "email": $('#email').val(),
                "tel": $('#tel').val(),
                "adress": $('#adress').val(),
                "ville": $('#ville').val(),
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/edit/" + id,
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: inputs
            }).responseText;
            jsonData = JSON.parse(StringData);
            var role_id = $('#logged_info').attr('value');
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#exampleModal').modal('hide');
                message("agence", "modifié", jsonData.check);

                produit = "";
                // if (jsonData.chef == null) {
                //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
                // } else {
                //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                //         "<span class=\"tooltip-text p-t-10\">" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                //         "</span> </span>" +
                //         "</span>";
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

                // }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + ind + ")\">restorer</button>"
                }

                for (let j = 0; j < jsonData.souscription.produits.length; j++) {
                    var qt_ne = 0.00;
                    equipements = "";
                    var inputs = {
                        "id_a": jsonData.souscription.id,
                        "id_p": jsonData.souscription.produits[j].prod_id
                    };
                    var StringData1 = $.ajax({
                        url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                        dataType: "json",
                        type: "GET",
                        async: false,
                        data: inputs
                    }).responseText;
                    jsonData1 = JSON.parse(StringData1);

                    for (let k = 0; k < jsonData1.equipements.length; k++) {
                        refs = "";

                        for (let f = 0; f < jsonData1.refs.length; f++) {
                            if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                                var val = "";
                                if (jsonData1.refs[f].ref != null) {
                                    val = jsonData1.refs[f].ref
                                }
                                refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                                    "<input type=\"text\" "+ (role_id == '1' || role_id == '6' ? "" : " disabled " ) +" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                                    "<span class=\"input-group-btn\">" +
                                    "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                                    "</span>" +
                                    "<br>" +
                                    "</div>" +
                                    "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                                if (jsonData1.refs[f].ref_ne != 0) {
                                    qt_ne++;
                                }
                            }


                        }
                        equipements = equipements +
                            "<div class=\"ribbon-wrapper card\">" +
                            "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                            "<div class=\"ribbon-content\" >" +
                            refs +
                            "</div>" +
                            "</div>";

                    }
                    var color = "";
                    switch (qt_ne) {
                        case 0:
                            color = "red";
                            break;

                        case jsonData1.refs.length:
                            color = "green";
                            break;

                        default:
                            color = "yellow";
                            break;
                    }

                    produit = produit +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<div class=\"card-body\">" +
                        "<div>" +
                        "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                        equipements +
                        "</div>" +
                        "</div>" +
                        "<div class=\"button-group text-center\">" +
                        (role_id == '1' || role_id == '6'  ? "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" : "") +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }
                $('#card' + ind).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +
                    "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agence.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agence.tel + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\">" + jsonData.ville.nom + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agence.adress + "</spane></h4>" +
                    //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
                    "<br>" +
                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + ind + ")\">modifier</button>" +
                    buttonacive +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-6 \">" +
                    "<div class=\"card\" id=\"product\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +

                    "<div class=\"button-group text-center\">" +
                    (role_id == '1' || role_id == '6'  ? "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" : "") +
                    "</div>" +
                    "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    produit +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>");

            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    }

    // function changer(id, place) {

    //     $('#affectationhead').html("<h4 class=\"modal-title\" >traitement chef</h4>" +
    //         "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
    //     // $('#affectationfooter').html("<button type=\"hidden\"  id=\"id_d\" value=\""+id+"\">");
    //     var StringData1 = $.ajax({
    //         url: "http://127.0.0.1:8000/utilisateur/staff-client/" + $('#id_c').val() + "/my_users_agence",
    //         dataType: "json",
    //         type: "GET",
    //         async: false,
    //     }).responseText;
    //     jsonData1 = JSON.parse(StringData1);

    //     $('#created_by').html("");
    //     for (let ind = 0; ind < jsonData1.users.length; ind++) {
    //         $('#created_by').append("<a  class=\"list-group-item value=\"" + jsonData1.users[ind].id + "\" onclick=\"select(" + id + "," + jsonData1.users[ind].id + "," + place + ")\"> <span class=\"mytooltip tooltip-effect-5\">" +
    //             "<span class=\"tooltip-item\">" + jsonData1.users[ind].nom + " " + jsonData1.users[ind].prénom + " - " + jsonData1.roles[ind].value + "</span> <span class=\"tooltip-content clearfix\">" +
    //             "<img src=\"{{ asset('storage') }}/" + jsonData1.users[ind].photo + "\" width=\"180\" /><br />" +
    //             "<span class=\"tooltip-text p-t-10\">" +
    //             "<p class=\"card-text text-center\">" + jsonData1.users[ind].nom + " " + jsonData1.users[ind].prénom + "</p>" +
    //             "<p  class=\"card-text text-center\">" + jsonData1.users[ind].email + "</p>" +
    //             "<p  class=\"card-text text-center\">" + jsonData1.users[ind].tel + "</p>" +
    //             "<p  class=\"card-text text-center\">" + jsonData1.roles[ind].value + "</p>" +
    //             "</span> </span>" +
    //             "</span></a>");

    //     }


    //     $('#affectation').css('padding-top', '15%');
    //     $('#affectation').modal('show');


    // }

    // function select(id_a, id_u, ind) {
    //     var buttonacive;
    //     var butttondetail;
    //     //var buttonaffect;
    //     var chef;
    //     var inputs = {
    //         "id_a": id_a,
    //         "id_u": id_u,
    //         "current_u": $('#chef' + ind).attr('value')
    //     };
    //     var StringData = $.ajax({
    //         url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/affecter",
    //         dataType: "json",
    //         type: "GET",
    //         async: false,
    //         data: inputs
    //     }).responseText;

    //     jsonData = JSON.parse(StringData);

    //     $('#affectation').modal('hide');
    //     produit = "";
    //     // if (jsonData.chef == null) {
    //     //     chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
    //     //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
    //     // } else {
    //     //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
    //     //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
    //     //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
    //     //         "<span class=\"tooltip-text p-t-10\">" +
    //     //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
    //     //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
    //     //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
    //     //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
    //     //         "</span> </span>" +
    //     //         "</span>";
    //     //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

    //     // }
    //     if (jsonData.agence.deleted_at == null) {
    //         buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
    //     } else {
    //         buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + ind + ")\">restorer</button>"
    //     }

    //     for (let j = 0; j < jsonData.souscription.produits.length; j++) {
    //         var qt_ne = 0.00;
    //         equipements = "";
    //         var inputs = {
    //             "id_a": jsonData.souscription.id,
    //             "id_p": jsonData.souscription.produits[j].prod_id
    //         };
    //         var StringData1 = $.ajax({
    //             url: "http://127.0.0.1:8000/outils/produits/equip_prod",
    //             dataType: "json",
    //             type: "GET",
    //             async: false,
    //             data: inputs
    //         }).responseText;
    //         jsonData1 = JSON.parse(StringData1);

    //         for (let k = 0; k < jsonData1.equipements.length; k++) {
    //             refs = "";

    //             for (let f = 0; f < jsonData1.refs.length; f++) {
    //                 if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
    //                     var val = "";
    //                     if (jsonData1.refs[f].ref != null) {
    //                         val = jsonData1.refs[f].ref
    //                     }
    //                     refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
    //                         "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
    //                         "<span class=\"input-group-btn\">" +
    //                         "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
    //                         "</span>" +
    //                         "<br>" +
    //                         "</div>" +
    //                         "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
    //                     if (jsonData1.refs[f].ref_ne != 0) {
    //                         qt_ne++;
    //                     }
    //                 }


    //             }
    //             equipements = equipements +
    //                 "<div class=\"ribbon-wrapper card\">" +
    //                 "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
    //                 "<div class=\"ribbon-content\" >" +
    //                 refs +
    //                 "</div>" +
    //                 "</div>";

    //         }
    //         var color = "";
    //         switch (qt_ne) {
    //             case 0:
    //                 color = "red";
    //                 break;

    //             case jsonData1.refs.length:
    //                 color = "green";
    //                 break;

    //             default:
    //                 color = "yellow";
    //                 break;
    //         }

    //         produit = produit +
    //             "<div class=\"card\">" +
    //             "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
    //             "<h5 class=\"mb-0 text-center\">" +
    //             "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
    //             "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
    //             "</a>" +
    //             "</h5>" +
    //             "</div>" +

    //             "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
    //             "<div class=\"card-body\">" +
    //             "<div>" +
    //             "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
    //             equipements +
    //             "</div>" +
    //             "</div>" +
    //             "<div class=\"button-group text-center\">" +

    //             "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agence.id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
    //             "</div>" +
    //             "</div>" +
    //             "</div>";

    //     }
    //     $('#card' + ind).html("<div class=\"card\">" +
    //         "<div class=\"card-body\">" +
    //         "<h2 id=\"nom" + ind + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
    //         "<div id=\"slimtest2\">" +
    //         "<div class=\"row\">" +
    //         "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
    //         "<div class=\"card \">" +
    //         "<h2  class=\"card-title text-center\" > informations</h2>" +
    //         "<hr>" +
    //         "<div class=\"card-body\">" +
    //         "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.agence.email + "</spane></h4>" +
    //         "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.agence.tel + "</spane></h4>" +
    //         "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\">" + jsonData.ville.nom + "</spane></h4>" +
    //         "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + ind + "\">" + jsonData.agence.adress + "</spane></h4>" +
    //         //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
    //         "<br>" +
    //         "<div class=\"button-group text-center\">" +
    //         "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + ind + ")\">modifier</button>" +
    //         buttonacive +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "<div class=\"col-lg-6 \">" +
    //         "<div class=\"card\" id=\"product\">" +
    //         "<h3 class=\"card-title text-center\">produits</h3>" +
    //         "<hr>" +
    //         "<div class=\"card-body\">" +
    //         "<div class=\"button-group text-center\">" +
    //         "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" +
    //         "</div>" +
    //         "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
    //         produit +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>" +
    //         "</div>");
    // }


    function add_produit(id, place) {



        var inputs = {
            "agence": id
        };
        var StringData2 = $.ajax({
            url: "http://127.0.0.1:8000/outils/produits/active_index",
            dataType: "json",
            type: "GET",
            async: false,
            data: inputs
        }).responseText;
        jsonData2 = JSON.parse(StringData2);

        $('#produit').html("<option value=\"0\" selected disabled >selectioner un produit </option>");
        $('#produit').selectpicker('refresh');
        for (let inc = 0; inc < jsonData2.length; inc++) {
            $('#produit').append("<option value=\"" + jsonData2[inc].id + "\">" + jsonData2[inc].nom + "</option>");
        }
        $('#produit').selectpicker('refresh');
        $('#equip_inputs').html("");

        $('#prodhead').html("<h4 class=\"modal-title\" >ajouter produit</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#prodfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save_new_p\">Enregistrer</button>");

        $('#prod').modal('show');

        $('#produit').change(function() {
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/" + $('#produit').val() + "/equipements/index",
                dataType: "json",
                type: "GET",
                async: false,
            }).responseText;

            jsonData = JSON.parse(StringData);

            $('#equip_inputs').html("");
            for (let inc = 0; inc < jsonData.length; inc++) {
                $('#equip_inputs').append("<div class=\"form-group col-lg-12\">" +
                    "<label class=\"control-label\">" + jsonData[inc].nom + " </label>" +
                    "<input class=\"vertical-spin\" id=\"" + jsonData[inc].id + "\" type=\"text\" value=\"0\" name=\"equip_input[]\" data-bts-button-down-class=\"btn btn-secondary btn-outline\" data-bts-button-up-class=\"btn btn-secondary btn-outline\">" +
                    "</div>");
            }

            $(".vertical-spin").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'ti-plus',
                verticaldownclass: 'ti-minus'
            });
            var vspinTrue = $(".vertical-spin").TouchSpin({
                verticalbuttons: true
            });
            if (vspinTrue) {
                $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
            }

        });

        $('#save_new_p').click(function() {

            var values = [];
            $("input[name='equip_input[]']").each(function() {
                values.push({
                    prod_id: $('#produit').val(),
                    id: $(this).attr('id'),
                    number: $(this).val()
                });

            });
            var inputs = {
                "agence": id,
                "data": values
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/attach_prod",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: inputs
            }).responseText;
            jsonData = JSON.parse(StringData);
            // console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                message("produit", "ajouté", jsonData.check);


                produit = "";
                // if (jsonData.chef == null) {
                //     chef = " <span id=\"chef" + place + "\" value=\"0\"> pas de chef d'agence</span>"
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">affecter un chef</button>"
                // } else {
                //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + place + "\" value=\"" + jsonData.chef.id + "\">" +
                //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                //         "<span class=\"tooltip-text p-t-10\">" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                //         "</span> </span>" +
                //         "</span>";
                //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">changer chef</button>"

                // }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + place + ")\">supprimer</button>" //+ buttonaffect;
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + place + ")\">restorer</button>"
                }

                for (let j = 0; j < jsonData.souscription.produits.length; j++) {
                    var qt_ne = 0.00;
                    equipements = "";
                    var inputs = {
                        "id_a": jsonData.souscription.id,
                        "id_p": jsonData.souscription.produits[j].prod_id
                    };
                    var StringData1 = $.ajax({
                        url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                        dataType: "json",
                        type: "GET",
                        async: false,
                        data: inputs
                    }).responseText;
                    jsonData1 = JSON.parse(StringData1);

                    for (let k = 0; k < jsonData1.equipements.length; k++) {
                        refs = "";

                        for (let f = 0; f < jsonData1.refs.length; f++) {
                            if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                                var val = "";
                                if (jsonData1.refs[f].ref != null) {
                                    val = jsonData1.refs[f].ref
                                }
                                refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                                    "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                                    "<span class=\"input-group-btn\">" +
                                    "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                                    "</span>" +
                                    "<br>" +
                                    "</div>" +
                                    "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                                if (jsonData1.refs[f].ref_ne != 0) {
                                    qt_ne++;
                                }
                            }


                        }
                        equipements = equipements +
                            "<div class=\"ribbon-wrapper card\">" +
                            "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                            "<div class=\"ribbon-content\" >" +
                            refs +
                            "</div>" +
                            "</div>";

                    }
                    var color = "";
                    switch (qt_ne) {
                        case 0:
                            color = "red";
                            break;

                        case jsonData1.refs.length:
                            color = "green";
                            break;

                        default:
                            color = "yellow";
                            break;
                    }

                    produit = produit +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + place + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                        "<div class=\"card-body\">" +
                        "<div>" +
                        "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                        equipements +
                        "</div>" +
                        "</div>" +
                        "<div class=\"button-group text-center\">" +

                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agence.id + "," + jsonData.souscription.produits[j].prod_id + "," + place + ")\">supprimer</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }
                $('#prod').modal('hide');
                $('#card' + place).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + place + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + place + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +
                    "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + place + "\">" + jsonData.agence.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + place + "\">" + jsonData.agence.tel + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + place + "\">" + jsonData.ville.nom + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + place + "\">" + jsonData.agence.adress + "</spane></h4>" +
                    //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
                    "<br>" +
                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + place + ")\">modifier</button>" +
                    buttonacive +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-6 \">" +
                    "<div class=\"card\" id=\"product\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +

                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + place + ")\"> attacher produit</button>" +
                    "</div>" +
                    "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    produit +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>");
            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    }

    function save_ref(id) {

        var inputs = {
            "id": id.split("f")[1],
            "value": $('#' + id).val()
        };


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/produits/save_ref",
            dataType: "json",
            type: "GET",
            data: inputs,
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        // console.log(jsonData)
        if ($.isEmptyObject(jsonData.error)) {

            clearInputsRef(jsonData.inputs, id.split("f")[1]);

            message("référance", "ajouté", jsonData.check);
            location.reload(); 
        } else {
            printErrorMsgRef(jsonData.error, id.split("f")[1]);
        }
    }

    function delet_prod(id_a, id_p, place) {

        var inputs = {
            "agence": id_a,
            "produit": id_p
        };

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/produits/detach_prod",
            dataType: "json",
            type: "GET",
            data: inputs,
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        message("produit", "détaché", jsonData.check);
        produit = "";
        // if (jsonData.chef == null) {
        //     chef = " <span id=\"chef" + place + "\" value=\"0\"> pas de chef d'agence</span>"
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">affecter un chef</button>"
        // } else {
        //     chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + place + "\" value=\"" + jsonData.chef.id + "\">" +
        //         "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
        //         "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
        //         "<span class=\"tooltip-text p-t-10\">" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
        //         "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
        //         "</span> </span>" +
        //         "</span>";
        //     buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">changer chef</button>"

        // }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + place + ")\">supprimer</button>" //+ buttonaffect;
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + place + ")\">restorer</button>"
        }

        for (let j = 0; j < jsonData.souscription.produits.length; j++) {
            var qt_ne = 0.00;
            equipements = "";
            var inputs = {
                "id_a": jsonData.souscription.id,
                "id_p": jsonData.souscription.produits[j].prod_id
            };
            var StringData1 = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/equip_prod",
                dataType: "json",
                type: "GET",
                async: false,
                data: inputs
            }).responseText;
            jsonData1 = JSON.parse(StringData1);

            for (let k = 0; k < jsonData1.equipements.length; k++) {
                refs = "";

                for (let f = 0; f < jsonData1.refs.length; f++) {
                    if (jsonData1.refs[f].equip_id == jsonData1.equipements[k].equip_id) {
                        var val = "";
                        if (jsonData1.refs[f].ref != null) {
                            val = jsonData1.refs[f].ref
                        }
                        refs = refs + "<div class=\"input-group\" style=\"margin:5px 0px\" id=\"err-value" + jsonData1.refs[f].ref_id + "\">" +
                            "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<br>" +
                            "</div>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" > </small>";
                        if (jsonData1.refs[f].ref_ne != 0) {
                            qt_ne++;
                        }
                    }


                }
                equipements = equipements +
                    "<div class=\"ribbon-wrapper card\">" +
                    "<div class=\"ribbon ribbon-default\"> " + jsonData1.equipements[k].equip_nom + "</div>" +
                    "<div class=\"ribbon-content\" >" +
                    refs +
                    "</div>" +
                    "</div>";

            }
            var color = "";
            switch (qt_ne) {
                case 0:
                    color = "red";
                    break;

                case jsonData1.refs.length:
                    color = "green";
                    break;

                default:
                    color = "yellow";
                    break;
            }

            produit = produit +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a style=\"color : " + color + "\" id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + place + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<span style=\"float:left\">" + jsonData.souscription.produits[j].prod_nom + "</span> <span style=\"float:right\">valide à " + (((qt_ne).toFixed(2) / jsonData1.refs.length) * 100).toFixed(0) + "%</span>" +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<div class=\"card-body\">" +
                "<div>" +
                "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                equipements +
                "</div>" +
                "</div>" +
                "<div class=\"button-group text-center\">" +

                "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agence.id + "," + jsonData.souscription.produits[j].prod_id + "," + place + ")\">supprimer</button>" +
                "</div>" +
                "</div>" +
                "</div>";

        }
        $('#prod').modal('hide');
        $('#card' + place).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + place + "\" class=\"card-title text-center \" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + place + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + place + "\">" + jsonData.agence.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + place + "\">" + jsonData.agence.tel + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Ville : </b><spane value=\"" + jsonData.ville.id + "\" id=\"ville" + place + "\">" + jsonData.ville.nom + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Adresse : </b><spane id=\"adress" + place + "\">" + jsonData.agence.adress + "</spane></h4>" +
            //"<h4><b> Chef d'agence : </b>" + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + place + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"product\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + place + ")\"> attacher produit</button>" +
            "</div>" +
            "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
            produit +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");

    }

    function printErrorMsg(msg) {


        $.each(msg, function(key, value) {

            $("#err-" + key).addClass('has-danger');
            $("#err-" + key).find("small").html(value);

        });

    }

    function clearInputs(msg) {


        $.each(msg, function(key, value) {

            $("#err-" + key).removeClass('has-danger');
            $("#err-" + key).find("small").html("");

        });

    }

    function printErrorMsgRef(msg, id) {


        $.each(msg, function(key, value) {

            $("#err-" + key + "" + id).addClass('has-danger');
            $("#s-err-" + key + "" + id).html(value);

        });

    }

    function clearInputsRef(msg, id) {


        $.each(msg, function(key, value) {

            $("#err-" + key + "" + id).removeClass('has-danger');
            $("#s-err-" + key + "" + id).html("");

        });

    }


    function check(input) {

        if (input.id == 'rd_email') {
            $('#fl_nom').hide()
            $('#fl_email').show()
        } else {
            $('#fl_nom').show()
            $('#fl_email').hide()
        }
    }


    $('#fv_dr').on('change', function() {


        $(this).is(':checked') ? $('#dr_group').hide() : $('#dr_group').show()

    })
</script>
@endsection