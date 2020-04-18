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
<div class="row" id="bodytab">

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
        var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);

        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.agences.length; ind++) {
            produit = "";
            if (jsonData.chefs[ind] == null) {
                chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">affecter un chef</button>"
            } else {
                chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chefs[ind].id + "\">" +
                    "<span class=\"tooltip-item\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.chefs[ind].photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].tel + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].adress + "</p>" +
                    "</span> </span>" +
                    "</span>";
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agences[ind].id + "," + ind + ")\">changer chef</button>"

            }
            if (jsonData.agences[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agences[ind].id + "," + ind + ")\">supprimer</button>" + buttonaffect;
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
                console.log(jsonData1)
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
                                "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";
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

                    "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agences[ind].id + "," + jsonData.souscriptions[ind].produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

            }
            $('#bodytab').append("<div class=\"col-12 \" id=\"card" + ind + "\">" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title \">" + jsonData.agences[ind].nom + "</h2>" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<h2  class=\"card-title text-center\" > informations</h2>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.agences[ind].email + "</h4>" +
                "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.agences[ind].tel + "</h4>" +
                "<h4 id=\"adress" + ind + "\" class=\"card-title\"> adresse : " + jsonData.agences[ind].adress + "</h4>" +
                "<h4 value=\"" + jsonData.villes[ind].id + "\" id=\"ville" + ind + "\" class=\"card-title\"> ville : " + jsonData.villes[ind].nom + "</h4>" +
                "<h4> Chef d'agence : " + chef + " </h4>" +
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
                "<div class=\"card-body\">" +
                "<h3 class=\"card-title text-center\">produits</h3>" +
                "<div class=\"button-group text-center\">" +
                "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agences[ind].id + "," + ind + ")\"> attacher produit</button>" +
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
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/system/ville/active_index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);

        for (let ind = 0; ind < jsonData1.length; ind++) {
            $('#ville').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].nom + "</option>");
        }
        $('#ville').selectpicker('refresh');



    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouvelle agence </h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#nom').val("");
        $('#email').val("");
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
            console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);

                $('#exampleModal').modal('hide');

                if (jsonData.chef == null) {
                    chef = " <span id=\"chef" + jsonData.count + "\" value=\"0\"> pas de chef d'agence</span>"
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + jsonData.count + ")\">affecter un chef</button>"
                } else {
                    chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + jsonData.count + "\" value=\"" + jsonData.chef.id + "\">" +
                        "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                        "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                        "<span class=\"tooltip-text p-t-10\">" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                        "</span> </span>" +
                        "</span>";
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + jsonData.count + ")\">changer chef</button>"

                }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + jsonData.count + ")\">supprimer</button>" + buttonaffect
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.agence.id + "," + jsonData.count + ")\">restorer</button>"
                }
                $('#bodytab').append("<div class=\"col-12 \" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + jsonData.count + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<div class=\"card-body\">" +
                    "<h4 id=\"email" + jsonData.count + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
                    "<h4 id=\"tel" + jsonData.count + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
                    "<h4 id=\"adress" + jsonData.count + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
                    "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + jsonData.count + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
                    "<h4> Chef d'agence : " + chef + " </h4>" +
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
                    "<div class=\"card-body\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
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
                printErrorMsg(jsonData.error);
            }
        });
    });



    function supprimer(id, ind) {
        var buttonacive;
        var butttondetail;
        var buttonaffect;
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


        produit = "";
        if (jsonData.chef == null) {
            chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" + buttonaffect;
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
                            "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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

                "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
                "</div>" +
                "</div>" +
                "</div>";

        }
        $('#card' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
            "<h4 id=\"adress" + ind + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
            "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
            "<h4> Chef d'agence : " + chef + " </h4>" +
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
            "<div class=\"card-body\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" +
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
        var buttonaffect;
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

        produit = "";
        if (jsonData.chef == null) {
            chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" + buttonaffect;
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
                            "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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

                "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
                "</div>" +
                "</div>" +
                "</div>";

        }
        $('#card' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
            "<h4 id=\"adress" + ind + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
            "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
            "<h4> Chef d'agence : " + chef + " </h4>" +
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
            "<div class=\"card-body\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" +
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
        var buttonaffect;
        var chef;
        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier agence</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
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

            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#exampleModal').modal('hide');
                produit = "";
                if (jsonData.chef == null) {
                    chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
                } else {
                    chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                        "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                        "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                        "<span class=\"tooltip-text p-t-10\">" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                        "</span> </span>" +
                        "</span>";
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

                }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" + buttonaffect;
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
                                    "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                                    "<span class=\"input-group-btn\">" +
                                    "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                                    "</span>" +
                                    "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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

                        "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }
                $('#card' + ind).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + ind + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<div class=\"card-body\">" +
                    "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
                    "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
                    "<h4 id=\"adress" + ind + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
                    "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
                    "<h4> Chef d'agence : " + chef + " </h4>" +
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
                    "<div class=\"card-body\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
                    "<div class=\"button-group text-center\">" +
                    "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" +
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
                printErrorMsg(jsonData.error);
            }
        });
    }

    function changer(id, place) {

        $('#affectationhead').html("<h4 class=\"modal-title\" >traitement chef</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        // $('#affectationfooter').html("<button type=\"hidden\"  id=\"id_d\" value=\""+id+"\">");
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-client/" + $('#id_c').val() + "/my_users_agence",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);

        $('#created_by').html("");
        for (let ind = 0; ind < jsonData1.users.length; ind++) {
            $('#created_by').append("<a  class=\"list-group-item value=\"" + jsonData1.users[ind].id + "\" onclick=\"select(" + id + "," + jsonData1.users[ind].id + "," + place + ")\"> <span class=\"mytooltip tooltip-effect-5\">" +
                "<span class=\"tooltip-item\">" + jsonData1.users[ind].nom + " " + jsonData1.users[ind].prénom + " - " + jsonData1.roles[ind].value + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData1.users[ind].photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData1.users[ind].nom + " " + jsonData1.users[ind].prénom + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData1.users[ind].email + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData1.users[ind].tel + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData1.roles[ind].value + "</p>" +
                "</span> </span>" +
                "</span></a>");

        }


        $('#affectation').css('padding-top', '15%');
        $('#affectation').modal('show');


    }

    function select(id_a, id_u, ind) {
        var buttonacive;
        var butttondetail;
        var buttonaffect;
        var chef;
        var inputs = {
            "id_a": id_a,
            "id_u": id_u,
            "current_u": $('#chef' + ind).attr('value')
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/" + $('#id_d').val() + "/agences/affecter",
            dataType: "json",
            type: "GET",
            async: false,
            data: inputs
        }).responseText;

        jsonData = JSON.parse(StringData);

        $('#affectation').modal('hide');
        produit = "";
        if (jsonData.chef == null) {
            chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef d'agence</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">affecter un chef</button>"
        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + ")\">supprimer</button>" + buttonaffect;
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
                            "<input type=\"text\" class=\"form-control\" name=\"name_ref" + jsonData1.refs[f].ref_id + "\" id=\"id_ref" + jsonData1.refs[f].ref_id + "\" value=\"" + val + "\">" +
                            "<span class=\"input-group-btn\">" +
                            "<button class=\"btn btn-info\" style=\"margin-left: 5px\" type=\"button\" onclick=\"save_ref('id_ref" + jsonData1.refs[f].ref_id + "')\">save </button>" +
                            "</span>" +
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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

                "<button type=\"button\" class=\"btn waves-effect waves-light btn-danger\" onclick=\"delet_prod(" + jsonData.agence.id + "," + jsonData.souscription.produits[j].prod_id + "," + ind + ")\">supprimer</button>" +
                "</div>" +
                "</div>" +
                "</div>";

        }
        $('#card' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + ind + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
            "<h4 id=\"adress" + ind + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
            "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + ind + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
            "<h4> Chef d'agence : " + chef + " </h4>" +
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
            "<div class=\"card-body\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn  btn-primary \" style=\"margin-bottom: 10px\"  onclick=\"add_produit(" + jsonData.agence.id + "," + ind + ")\"> attacher produit</button>" +
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
            console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);


                produit = "";
                if (jsonData.chef == null) {
                    chef = " <span id=\"chef" + place + "\" value=\"0\"> pas de chef d'agence</span>"
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">affecter un chef</button>"
                } else {
                    chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + place + "\" value=\"" + jsonData.chef.id + "\">" +
                        "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                        "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                        "<span class=\"tooltip-text p-t-10\">" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                        "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                        "</span> </span>" +
                        "</span>";
                    buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">changer chef</button>"

                }
                if (jsonData.agence.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + place + ")\">supprimer</button>" + buttonaffect;
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
                                    "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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
                    "<h2 id=\"nom" + place + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
                    "<div id=\"slimtest2\">" +
                    "<div class=\"row\">" +
                    "<div class=\"col-md-6 \" id=\"card" + place + "\">" +
                    "<div class=\"card \">" +
                    "<h2  class=\"card-title text-center\" > informations</h2>" +
                    "<div class=\"card-body\">" +
                    "<h4 id=\"email" + place + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
                    "<h4 id=\"tel" + place + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
                    "<h4 id=\"adress" + place + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
                    "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + place + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
                    "<h4> Chef d'agence : " + chef + " </h4>" +
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
                    "<div class=\"card-body\">" +
                    "<h3 class=\"card-title text-center\">produits</h3>" +
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
        console.log(jsonData)
        if ($.isEmptyObject(jsonData.error)) {

            clearInputsRef(jsonData.inputs, id.split("f")[1]);

            message("référance", "ajouté", jsonData.check);
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
        produit = "";
        if (jsonData.chef == null) {
            chef = " <span id=\"chef" + place + "\" value=\"0\"> pas de chef d'agence</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">affecter un chef</button>"
        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + place + "\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.agence.id + "," + place + ")\">changer chef</button>"

        }
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.agence.id + "," + place + ")\">supprimer</button>" + buttonaffect;
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
                            "<small id=\"s-err-value" + jsonData1.refs[f].ref_id + "\" style=\"color : red \" class=\"form-control-feedback\"> </small>";

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
            "<h2 id=\"nom" + place + "\" class=\"card-title \">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + place + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + place + "\" class=\"card-title\"> email : " + jsonData.agence.email + "</h4>" +
            "<h4 id=\"tel" + place + "\" class=\"card-title\"> tel : " + jsonData.agence.tel + "</h4>" +
            "<h4 id=\"adress" + place + "\" class=\"card-title\"> adresse : " + jsonData.agence.adress + "</h4>" +
            "<h4 value=\"" + jsonData.ville.id + "\" id=\"ville" + place + "\" class=\"card-title\"> ville : " + jsonData.ville.nom + "</h4>" +
            "<h4> Chef d'agence : " + chef + " </h4>" +
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
            "<div class=\"card-body\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
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
</script>
@endsection