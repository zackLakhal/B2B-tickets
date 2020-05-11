@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h2 class="text-themecolor m-b-0 m-t-0"> {{$client->nom}} </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils client</li>
            <li class="breadcrumb-item text-themecolor">Gérer les clients</li>
            <li class="breadcrumb-item active" value="{{$client->id}}" id="id_c">{{$client->nom}}</li>

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
                        <i class="fa fa-plus"></i> ajouter un nouveau département
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
                <label class="control-label ">Nom département</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_nom" id="fv_nom">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">Email département</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_email" id="fv_email">

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

                <div class="form-group" id="err-tel">
                    <label for="tel" class="control-label"><b>tel:</b></label>
                    <input type="text" class="form-control" id="tel" name="tel">
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
        var butttondetail;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        var role_id = $('#logged_info').attr('value');
        $('#bodytab').html("");

        $('#fv_nom').html(" <option  value=\"0\"selected  >tout les départements </option>")
        $('#fv_email').html(" <option  value=\"0\"selected  >tout les départements </option>")
        for (let ind = 0; ind < jsonData.departements.length; ind++) {

            // if (jsonData.chefs[ind] == null) {
            //   //  chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef de département</span>"
            //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departements[ind].id + "," + ind + ")\">affecter un chef</button>"
            // } else {
            //     // chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chefs[ind].id + "\">" +
            //     //     "<span class=\"tooltip-item\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</span> <span class=\"tooltip-content clearfix\">" +
            //     //     "<img src=\"{{ asset('storage') }}/" + jsonData.chefs[ind].photo + "\" width=\"180\" /><br />" +
            //     //     "<span class=\"tooltip-text p-t-10\">" +
            //     //     "<p class=\"card-text text-center\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</p>" +
            //     //     "<p class=\"card-text text-center\">" + jsonData.chefs[ind].email + "</p>" +
            //     //     "<p class=\"card-text text-center\">" + jsonData.chefs[ind].tel + "</p>" +
            //     //     "<p class=\"card-text text-center\">" + jsonData.chefs[ind].adress + "</p>" +
            //     //     "</span> </span>" +
            //     //     "</span>";
            //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departements[ind].id + "," + ind + ")\">changer chef</button>"

            // }

            $('#fv_nom').append("<option value=\"" + jsonData.departements[ind].id + "\">" + jsonData.departements[ind].nom + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData.departements[ind].id + "\">" + jsonData.departements[ind].email + "</option>");



            if (jsonData.departements[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departements[ind].id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departements[ind].id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departements[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-6\" id=\"card" + ind + "\" >" +
                "<div class=\"card \">" +
                "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departements[ind].nom + "</h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departements[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departements[ind].tel + "</spane></h4>" +
                ////"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                (role_id != '5' ? "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departements[ind].id + "," + ind + ")\">modifier</button>" : "") +
                (role_id != '5' ? buttonacive : "") +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }

        $('#fv_nom').selectpicker('refresh');
        $('#fv_email').selectpicker('refresh');
        // $('#fv_dr').attr("checked", "");
        $('#fl_email').hide()
        document.getElementsByTagName('fv_dr').checked = false;


        document.getElementsByTagName('rd_nom').checked = true;


    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau département </h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#nom').val("");
        $('#email').val("");
        $('#tel').val("");
        $('#exampleModal').modal('show');
        $('#save').click(function() {
            var inputs = {
                "nom": $('#nom').val(),
                "email": $('#email').val(),
                "tel": $('#tel').val(),
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/create",
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

                message("département", "ajouté", jsonData.check);


                // if (jsonData.chef == null) {
                //   //  chef = " <span id=\"chef" + jsonData.count + "\" value=\"0\"> pas de chef de département</span>"
                //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + jsonData.count + ")\">affecter un chef</button>"
                // } else {
                //     // chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + jsonData.count + "\" value=\"" + jsonData.chef.id + "\">" +
                //     //     "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                //     //     "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                //     //     "<span class=\"tooltip-text p-t-10\">" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                //     //     "</span> </span>" +
                //     //     "</span>";
                //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + jsonData.count + ")\">changer chef</button>"

                // }
                if (jsonData.departement.deleted_at == null) {
                    butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + jsonData.count + ")\">supprimer</button>" //+ buttonaffect
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + jsonData.count + ")\">restorer</button>"
                    butttondetail = ""
                }
                $('#bodytab').append("<div class=\"col-md-6\" id=\"card" + jsonData.count + "\" >" +
                    "<div class=\"card \">" +
                    "<h2  id=\"nom" + jsonData.count + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departement.nom + "</h2>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +
                    "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + jsonData.count + "\">" + jsonData.departement.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + jsonData.count + "\">" + jsonData.departement.tel + "</spane></h4>" +
                    //"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
                    "<br>" +
                    "<div class=\"button-group text-center\">" +
                    butttondetail +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + jsonData.count + ")\">modifier</button>" +
                    buttonacive +
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
        var departement_id;
        var is_deleted;

        $('#rd_nom').is(':checked') ? departement_id = $('#fv_nom').val() : departement_id = $('#fv_email').val()
        $('#active').is(':checked') ? is_deleted = $('#active').val() : is_deleted = $('#deleted').val()

        form_data.append("departement_id", departement_id);
        form_data.append("is_all", $('#fv_dr').is(':checked'));
        form_data.append("is_deleted", is_deleted);

        // console.log(jsonData)
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/filter_index",
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

        $('#bodytab').html("");

        for (let ind = 0; ind < jsonData.departements.length; ind++) {

         
            if (jsonData.departements[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departements[ind].id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departements[ind].id + "," + ind + ")\">supprimer</button>" //+ buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departements[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-6\" id=\"card" + ind + "\" >" +
                "<div class=\"card \">" +
                "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departements[ind].nom + "</h2>" +
                "<hr>" +
                "<div class=\"card-body\">" +
                "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departements[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departements[ind].tel + "</spane></h4>" +
                ////"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departements[ind].id + "," + ind + ")\">modifier</button>" +
                buttonacive +
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
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/delete/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);

        message("département", "supprimé", jsonData.check);


        // if (jsonData.chef == null) {
        //    // chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef de département</span>"
        //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

        // } else {
        //     // chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
        //     //     "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
        //     //     "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
        //     //     "<span class=\"tooltip-text p-t-10\">" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
        //     //     "</span> </span>" +
        //     //     "</span>";
        //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

        // }
        if (jsonData.departement.deleted_at == null) {
            butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departement.nom + "</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departement.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departement.tel + "</spane></h4>" +
            //"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
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
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/restore/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);
        message("département", "restoré", jsonData.check);

        // if (jsonData.chef == null) {
        //    // chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef de département</span>"
        //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

        // } else {
        //     // chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
        //     //     "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
        //     //     "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
        //     //     "<span class=\"tooltip-text p-t-10\">" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
        //     //     "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
        //     //     "</span> </span>" +
        //     //     "</span>";
        //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

        // }
        if (jsonData.departement.deleted_at == null) {
            butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departement.nom + "</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departement.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departement.tel + "</spane></h4>" +
            //"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier département</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
        $('#tel').val($('#tel' + ind).html());
        $('#exampleModal').modal('show');
        $('#edit').click(function() {
            var inputs = {
                "nom": $('#nom').val(),
                "email": $('#email').val(),
                "tel": $('#tel').val(),
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/edit/" + id,
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

                message("département", "modifié", jsonData.check);

                // if (jsonData.chef == null) {
                //    // chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef de département</span>"
                //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

                // } else {
                //     // chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
                //     //     "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                //     //     "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                //     //     "<span class=\"tooltip-text p-t-10\">" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                //     //     "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                //     //     "</span> </span>" +
                //     //     "</span>";
                //     //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

                // }
                if (jsonData.departement.deleted_at == null) {
                    butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect
                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
                    butttondetail = ""
                }
                $('#card' + ind).html("<div class=\"card \">" +
                    "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departement.nom + "</h2>" +
                    "<hr>" +
                    "<div class=\"card-body\">" +
                    "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departement.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departement.tel + "</spane></h4>" +
                    //"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
                    "<br>" +
                    "<div class=\"button-group text-center\">" +
                    butttondetail +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
                    buttonacive +
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
    //         url: "http://127.0.0.1:8000/utilisateur/staff-client/" + $('#id_c').val() + "/my_users_departement",
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

    // function select(id_d, id_u, ind) {
    //     var buttonacive;
    //     var butttondetail;
    //     //var buttonaffect;
    //     var chef;
    //     var inputs = {
    //         "id_d": id_d,
    //         "id_u": id_u,
    //         "current_u": $('#chef' + ind).attr('value')
    //     };
    //     var StringData = $.ajax({
    //         url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/affecter",
    //         dataType: "json",
    //         type: "GET",
    //         async: false,
    //         data: inputs
    //     }).responseText;

    //     jsonData = JSON.parse(StringData);

    //     $('#affectation').modal('hide');
    //     if (jsonData.chef == null) {
    //        // chef = " <span id=\"chef" + ind + "\" value=\"0\"> pas de chef de département</span>"
    //         //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

    //     } else {
    //         chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + ind + "\" value=\"" + jsonData.chef.id + "\">" +
    //             "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
    //             "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
    //             "<span class=\"tooltip-text p-t-10\">" +
    //             "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
    //             "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
    //             "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
    //             "<p  class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
    //             "</span> </span>" +
    //             "</span>";
    //         //buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

    //     }
    //     if (jsonData.departement.deleted_at == null) {
    //         butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
    //         buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" //+ buttonaffect
    //     } else {
    //         buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
    //         butttondetail = ""
    //     }
    //     $('#card' + ind).html("<div class=\"card \">" +
    //         "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"font-weight: bold;\">" + jsonData.departement.nom + "</h2>" +
    //         "<hr>"+

    //         "<div class=\"card-body\">" +
    //         "<h4  class=\"card-title\"><b> Email : </b><spane id=\"email" + ind + "\">" + jsonData.departement.email + "</spane></h4>" +
    //         "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.departement.tel + "</spane></h4>" +
    //         //"<h4 ><b> Chef de departement : </b>" + chef + " </h4>" +
    //         "<br>" +
    //         "<div class=\"button-group text-center\">" +
    //         butttondetail +
    //         "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
    //         buttonacive +
    //         "</div>" +
    //         "</div>" +
    //         "</div>");
    // }

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