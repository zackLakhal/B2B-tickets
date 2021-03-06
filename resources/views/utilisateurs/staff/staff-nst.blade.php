@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer staff nst</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Utilisateurs</li>
            <li class="breadcrumb-item active">Gérer staff nst</li>
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
@if(auth::user()->role_id == 1 || auth::user()->role_id == 6)
<div class="row">
    <div class="col-12 m-t-30">
        <div class="card">
            <div class="card-body">

                <div class="button-group text-center">
                    <button type="button" id="newmodal" class="btn btn-lg btn-primary ">
                        <i class="fa fa-plus"></i> ajouter un nouveau Staff-nst
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(auth::user()->role_id != 3 )
<div class="">
    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter  text-white"></i></button>
</div>
@endif
<div id="bodytab" class="row el-element-overlay">

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
                <label class="control-label ">Nom prénom</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_nom" id="fv_nom">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">staff Email</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_email" id="fv_email">

                </select>
            </div>
            @if(auth::user()->role_id != 2 )
            <div class="form-group" id="fl_role">
                <label class="control-label ">role</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_role" id="fv_role">

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
            @endif
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
            <div class="modal-body " id="modalbody">

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
                <div class="form-group" id="err-role">
                    <label class="control-label">Role</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="role" id="role">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-nom">
                    <label for="nom" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom" name="nom">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-prenom">
                    <label for="prenom" class="control-label"><b>prénom:</b></label>
                    <input type="text" class="form-control" id="prenom" name="prenom">
                    <small class="form-control-feedback"> </small>
                </div>

                <div class="form-group" id="err-tel">
                    <label for="tel" class="control-label"><b>tel:</b></label>
                    <input type="text" class="form-control" id="tel" name="tel">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group">
                    <label for="adress" class="control-label"><b>adress:</b></label>
                    <input type="text" class="form-control" id="adress" name="adress">
                </div>
                <div class="form-group" id="pic_id">
                    
                </div>
            </div>
            <div class="modal-footer" id="modalfooter">
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
            <div class="modal-body text-center" id="content"> content will be here </div>
            <div class="modal-footer" id="messagefooter">
            </div>
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
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-nst/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
         console.log(jsonData)
        $('#bodytab').html("");
        var role_id = $('#logged_info').attr('value');
        $('#fv_nom').html(" <option  value=\"0\"selected  >tout les staff </option>")
        $('#fv_email').html(" <option  value=\"0\"selected  >tout les staff </option>")
        for (let ind = 0; ind < jsonData.users.length; ind++) {

            $('#fv_nom').append("<option value=\"" + jsonData.users[ind].id + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData.users[ind].id + "\">" + jsonData.users[ind].email + "</option>");

              var ref_links = "";
            if (jsonData.users[ind].deleted_at == null) {
                buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
            } else {
                buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
            }

            var type = "";
            if (jsonData.roles[ind].id == 1) {
                type = "AD-";
            }
            if (jsonData.roles[ind].id == 2) {
                type = "CT-";
            }
            if (jsonData.roles[ind].id == 3) {
                type = "TE-";

                var et_1 = "0";
                var et_2 = "0";
                var et_3 = "0";

                for (let t = 0; t < 3; t++) {
                    if (jsonData.affectations[ind][t] != null) {
                        switch (jsonData.affectations[ind][t].etat_id) {
                            case '1':
                                et_1 = "" + jsonData.affectations[ind][t].nb;
                                break;

                            case '2':
                                et_2 = "" + jsonData.affectations[ind][t].nb;
                                break;

                            case '3':
                                et_3 = "" + jsonData.affectations[ind][t].nb;
                                break;
                        }
                    }

                }
                ref_links = "<div class=\"list-group\">" +
                    "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                    "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                    "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                    "</div>";
            }
            $('#bodytab').append("<div class=\"col-lg-4 col-md-6\" id=\"card" + ind + "\">" +
                "<div class=\"card\" >" +
                "<div class=\"el-card-item\">" +
                "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.users[ind].photo + "\" alt=\"user\" />" +
                "<div class=\"el-overlay scrl-up\">" +
                "<ul class=\"el-info\">" +
                "<li><a class=\"btn default btn-warning\" onclick=\"modifier(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                 (role_id == '1' || role_id == '6' ? buttonacive : "") +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</h3>" +
                "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                "<h4 class=\"mb-0\">" +
                "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                "Informations" +
                "</a>" +
                "</h4>" +
                "</div>" +
                "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.users[ind].email + "</a>" +
                "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.users[ind].tel + "</a>" +
                "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.users[ind].adress + "</a>" +
                "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.roles[ind].id + "\">" + jsonData.roles[ind].value + "</a>" +
                ref_links +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.users[ind].id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }

        $('#role').html(" <option  value=\"0\"selected disabled >selectioner un role </option>")
        $('#fv_role').html(" <option  value=\"0\"selected >tout les roles </option>")
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/system/role/active_index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);
        console.log(jsonData1)
        for (let ind = 0; ind < jsonData1.length; ind++) {
             if (jsonData1[ind].id != 4 && jsonData1[ind].id != 5) {
                $('#role').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].value + "</option>");
                $('#fv_role').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].value + "</option>");
            }
        }
        $('#role').selectpicker('refresh');
        $('#fv_role').selectpicker('refresh');
        $('#fv_nom').selectpicker('refresh');
        $('#fv_email').selectpicker('refresh');
        // $('#fv_dr').attr("checked", "");
        $('#fl_email').hide()
        document.getElementsByTagName('fv_dr').checked = false;


        document.getElementsByTagName('rd_nom').checked = true;


    }

    $('#filter').click(function() {



        form_data = new FormData();
        var user_id;
        var is_deleted;

        $('#rd_nom').is(':checked') ? user_id = $('#fv_nom').val() : user_id = $('#fv_email').val()
        $('#active').is(':checked') ? is_deleted = $('#active').val() : is_deleted = $('#deleted').val()

        form_data.append("user_id", user_id);
        form_data.append("role_id", $('#fv_role').val());
        form_data.append("is_all", $('#fv_dr').is(':checked'));
        form_data.append("is_deleted", is_deleted);

        // // console.log(jsonData)
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-nst/filter_index",
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
        var role_id = $('#logged_info').attr('value');
        $('#bodytab').html("");

        for (let ind = 0; ind < jsonData.users.length; ind++) {


              var ref_links = "";
            if (jsonData.users[ind].deleted_at == null) {
                buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
            } else {
                buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
            }

            var type = "";
            if (jsonData.roles[ind].id == 1) {
                type = "AD-";
            }
            if (jsonData.roles[ind].id == 2) {
                type = "CT-";
            }
            if (jsonData.roles[ind].id == 3) {
                type = "TE-";

                var et_1 = "0";
                var et_2 = "0";
                var et_3 = "0";

                for (let t = 0; t < 3; t++) {
                    if (jsonData.affectations[ind][t] != null) {
                        switch (jsonData.affectations[ind][t].etat_id) {
                            case '1':
                                et_1 = "" + jsonData.affectations[ind][t].nb;
                                break;

                            case '2':
                                et_2 = "" + jsonData.affectations[ind][t].nb;
                                break;

                            case '3':
                                et_3 = "" + jsonData.affectations[ind][t].nb;
                                break;
                        }
                    }

                }
                ref_links = "<div class=\"list-group\">" +
                    "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                    "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                    "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.users[ind].id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                    "</div>";
            }
            $('#bodytab').append("<div class=\"col-lg-4 col-md-6\" id=\"card" + ind + "\">" +
                "<div class=\"card\" >" +
                "<div class=\"el-card-item\">" +
                "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.users[ind].photo + "\" alt=\"user\" />" +
                "<div class=\"el-overlay scrl-up\">" +
                "<ul class=\"el-info\">" +
                "<li><a class=\"btn default btn-warning\" onclick=\"modifier(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                 (role_id == '1' || role_id == '6' ? buttonacive : "") +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</h3>" +
                "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                "<h4 class=\"mb-0\">" +
                "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                "Informations" +
                "</a>" +
                "</h4>" +
                "</div>" +
                "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.users[ind].email + "</a>" +
                "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.users[ind].tel + "</a>" +
                "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.users[ind].adress + "</a>" +
                "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.roles[ind].id + "\">" + jsonData.roles[ind].value + "</a>" +
                ref_links +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.users[ind].id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
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

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau staff-nst</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");
        $('.dropify').dropify();
        
       $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"{{ asset('storage/clients/placeholder.jpg') }}\"  />");
        $('.dropify').dropify();


        $('#role').val("");
        $('#role').selectpicker('refresh');
        $('#nom').val("");
        $('#prenom').val("");
        $('#email').val("");
        $('#tel').val("");
        $('#adress').val("");
        $('#err-password').show();
        $('#password').val("");
        $('#err-role').show();
        $('#role').val("");
        $('#exampleModal').modal('show');




        $('#save').click(function() {

            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("role", $('#role').val());
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("password", $('#password').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-nst/create",
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
             var ref_links = "";
            jsonData = JSON.parse(StringData);
             console.log(jsonData);
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#exampleModal').modal('hide');
                message("staff-nst", "ajouté", jsonData.check);
                if (jsonData.user.deleted_at == null) {
                    buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-trash\"></i></a></li>";
                } else {
                    buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-reload\"></i></a></li>"
                }
                var type = "";
                if (jsonData.role.id == 1) {
                    type = "AD-";
                }
                if (jsonData.role.id == 2) {
                    type = "CT-";
                }
                if (jsonData.role.id == 3) {
                    type = "TE-";

                    var et_1 = "0";
                    var et_2 = "0";
                    var et_3 = "0";

                    for (let t = 0; t < 3; t++) {
                        if (jsonData.affectation[t] != null) {
                            switch (jsonData.affectation[t].etat_id) {
                                case '1':
                                    et_1 = "" + jsonData.affectation[t].nb;
                                    break;

                                case '2':
                                    et_2 = "" + jsonData.affectation[t].nb;
                                    break;

                                case '3':
                                    et_3 = "" + jsonData.affectation[t].nb;
                                    break;
                            }
                        }

                    }
                    ref_links = "<div class=\"list-group\">" +
                        "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.user.id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                        "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.user.id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                        "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.user.id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                        "</div>";
                }
                $('#bodytab').append("<div class=\"col-lg-4 col-md-6\" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card\" >" +
                    "<div class=\"el-card-item\">" +
                    "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + jsonData.count + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
                    "<div class=\"el-overlay scrl-up\">" +
                    "<ul class=\"el-info\">" +
                    "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                    buttonacive +
                    "</ul>" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"el-card-content\">" +
                    "<h3 class=\"box-title\" id=\"full_name" + jsonData.count + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
                    "<div id=\"accordion" + jsonData.count + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                    "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + jsonData.count + "\">" +
                    "<h4 class=\"mb-0\">" +
                    "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + jsonData.count + "\" href=\"#collapseOne" + jsonData.count + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + jsonData.count + "\">" +
                    "Informations" +
                    "</a>" +
                    "</h4>" +
                    "</div>" +
                    "<div id=\"collapseOne" + jsonData.count + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + jsonData.count + "\">" +
                    "<div class=\"card-body\">" +
                    "<div class=\"list-group\">" +
                    "<a class=\"list-group-item \"id=\"email" + jsonData.count + "\">" + jsonData.user.email + "</a>" +
                    "<a class=\"list-group-item\" id=\"tel" + jsonData.count + "\">" + jsonData.user.tel + "</a>" +
                    "<a class=\"list-group-item\" id=\"adress" + jsonData.count + "\">" + jsonData.user.adress + "</a>" +
                    "<a class=\"list-group-item\" id=\"role" + jsonData.count + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
                    ref_links +
                    "</div>" +
                    "<div class=\"button-group text-center\">" +
                    "<br>" +
                    "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.user.id + "," + jsonData.count + ",'" + type + "')\"> générer mot de passe</button>" +
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

    function supprimer(id, ind) {
         var ref_links = "";
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-nst/delete/" + id,
            dataType: "json",
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            processData: false,
            contentType: false,
        }).responseText;

        jsonData = JSON.parse(StringData);
        message("staff-nst", "supprimé", jsonData.check);
        if (jsonData.user.deleted_at == null) {
            buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
        } else {
            buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
        }
        var type = "";
        if (jsonData.role.id == 1) {
            type = "AD-";
        }
        if (jsonData.role.id == 2) {
            type = "CT-";
        }
        if (jsonData.role.id == 3) {
            type = "TE-";

            var et_1 = "0";
            var et_2 = "0";
            var et_3 = "0";

            for (let t = 0; t < 3; t++) {
                if (jsonData.affectation[t] != null) {
                    switch (jsonData.affectation[t].etat_id) {
                        case '1':
                            et_1 = "" + jsonData.affectation[t].nb;
                            break;

                        case '2':
                            et_2 = "" + jsonData.affectation[t].nb;
                            break;

                        case '3':
                            et_3 = "" + jsonData.affectation[t].nb;
                            break;
                    }
                }

            }
            ref_links = "<div class=\"list-group\">" +
                "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.user.id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.user.id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.user.id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                "</div>";
        }
       
        $('#card' + ind).html("<div class=\"card\" >" +
            "<div class=\"el-card-item\">" +
            "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
            "<div class=\"el-overlay scrl-up\">" +
            "<ul class=\"el-info\">" +
            "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
            buttonacive +
            "</ul>" +
            "</div>" +
            "</div>" +
            "<div class=\"el-card-content\">" +
            "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
            "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
            "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
            "<h4 class=\"mb-0\">" +
            "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
            "Informations" +
            "</a>" +
            "</h4>" +
            "</div>" +
            "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"list-group\">" +
            "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
            "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
            "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
            "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
            ref_links +
            "</div>" +
            "<div class=\"button-group text-center\">" +
            "<br>" +
            "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.user.id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(id, ind) {
         var ref_links = "";
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-nst/restore/" + id,
            dataType: "json",
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            processData: false,
            contentType: false
        }).responseText;

        jsonData = JSON.parse(StringData);
        message("staff-nst", "restoré", jsonData.check);
        if (jsonData.user.deleted_at == null) {
            buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
        } else {
            buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
        }
        var type = "";
        if (jsonData.role.id == 1) {
            type = "AD-";
        }
        if (jsonData.role.id == 2) {
            type = "CT-";
        }
        if (jsonData.role.id == 3) {
            type = "TE-";

            var et_1 = "0";
            var et_2 = "0";
            var et_3 = "0";

            for (let t = 0; t < 3; t++) {
                if (jsonData.affectation[t] != null) {
                    switch (jsonData.affectation[t].etat_id) {
                        case '1':
                            et_1 = "" + jsonData.affectation[t].nb;
                            break;

                        case '2':
                            et_2 = "" + jsonData.affectation[t].nb;
                            break;

                        case '3':
                            et_3 = "" + jsonData.affectation[t].nb;
                            break;
                    }
                }

            }
            ref_links = "<div class=\"list-group\">" +
                "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.user.id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.user.id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.user.id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                "</div>";
        }
        $('#card' + ind).html("<div class=\"card\" >" +
            "<div class=\"el-card-item\">" +
            "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
            "<div class=\"el-overlay scrl-up\">" +
            "<ul class=\"el-info\">" +
            "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
            buttonacive +
            "</ul>" +
            "</div>" +
            "</div>" +
            "<div class=\"el-card-content\">" +
            "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
            "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
            "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
            "<h4 class=\"mb-0\">" +
            "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
            "Informations" +
            "</a>" +
            "</h4>" +
            "</div>" +
            "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"list-group\">" +
            "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
            "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
            "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
            "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
            ref_links +
            "</div>" +
            "<div class=\"button-group text-center\">" +
            "<br>" +
            "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.user.id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {

        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier staff-nst</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");

        $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"" + $('#avatar' + ind).attr('src') + "\"  />");
        $('.dropify').dropify();




        var full_name = $('#full_name' + ind).html().split(" ");
        $('#nom').val(full_name[0]);
        $('#prenom').val(full_name[1]);
        $('#email').val($('#email' + ind).html());
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#password').val("");
        $('#err-password').hide();
        $('#err-role').hide();
        $('#role').val($('#role' + ind).attr('value'));
        $('#role').selectpicker('refresh');
        $('#exampleModal').modal('show');
        $('#edit').click(function() {

            form_data = new FormData();
        console.log($('#role' + ind).attr('value'));
            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("role",$('#role' + ind).attr('value'));
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("img_histo",$('#dropify-preview-id').attr('style'));

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-nst/edit/" + id,
                dataType: "json",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: form_data,
                processData: false,
                contentType: false
            }).responseText;
            jsonData = JSON.parse(StringData);
             console.log(jsonData)
            var role_id = $('#logged_info').attr('value');
             var ref_links = "";
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);

                $('#exampleModal').modal('hide');
                message("staff-nst", "modifié", jsonData.check);
                if (jsonData.user.deleted_at == null) {
                    buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
                } else {
                    buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
                }
                var type = "";
                if (jsonData.role.id == 1) {
                    type = "AD-";
                }
                if (jsonData.role.id == 2) {
                    type = "CT-";
                }
                if (jsonData.role.id == 3) {
                    type = "TE-";

                    var et_1 = "0";
                    var et_2 = "0";
                    var et_3 = "0";

                    for (let t = 0; t < 3; t++) {
                        if (jsonData.affectation[t] != null) {
                            switch (jsonData.affectation[t].etat_id) {
                                case '1':
                                    et_1 = "" + jsonData.affectation[t].nb;
                                    break;

                                case '2':
                                    et_2 = "" + jsonData.affectation[t].nb;
                                    break;

                                case '3':
                                    et_3 = "" + jsonData.affectation[t].nb;
                                    break;
                            }
                        }

                    }
                    ref_links = "<div class=\"list-group\">" +
                        "<a href=\"/dashboard/reclamations/detail/1/" + jsonData.user.id + "\" class=\"list-group-item " + (et_1 == "0" ? " disabled " : "") + " list-group-item-danger\"><b> " + et_1 + " </b> réclamation en cours </a>" +
                        "<a href=\"/dashboard/reclamations/detail/2/" + jsonData.user.id + "\" class=\"list-group-item " + (et_2 == "0" ? " disabled " : "") + " list-group-item-warning\"><b> " + et_2 + " </b>réclamation en traitement</a>" +
                        "<a href=\"/dashboard/reclamations/detail/3/" + jsonData.user.id + "\" class=\"list-group-item " + (et_3 == "0" ? " disabled " : "") + " list-group-item-info\"><b> " + et_3 + " </b>réclamation clôturé</a>" +
                        "</div>";
                }
                $('#card' + ind).html("<div class=\"card\" >" +
                    "<div class=\"el-card-item\">" +
                    "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
                    "<div class=\"el-overlay scrl-up\">" +
                    "<ul class=\"el-info\">" +
                    "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                    (role_id == '1' || role_id == '6' ? buttonacive : "") +
                    "</ul>" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"el-card-content\">" +
                    "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
                    "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                    "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                    "<h4 class=\"mb-0\">" +
                    "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                    "Informations" +
                    "</a>" +
                    "</h4>" +
                    "</div>" +
                    "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                    "<div class=\"card-body\">" +
                    "<div class=\"list-group\">" +
                    "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
                    "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
                    "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
                    "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
                    ref_links +
                    "</div>" +
                    "<div class=\"button-group text-center\">" +
                    "<br>" +
                    "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.user.id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
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

    function pass_change(id, ind, type) {
        var pass = generatePassword(type)
        $('#messagefooter').html("<button type=\"button\" class=\"btn btn-inverse\" id=\"pass_edit\">Enregistrer</button>");
        $('#content').html("mot de pass généré est : <br><br><h2> " + pass + "</h2>");
        $('#messagebox').modal('show');

        $('#pass_edit').click(function() {

            var inputs = {
                "type": "staff",
                "id": id,
                "password": pass
            };


            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-client/save_pass",
                dataType: "json",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: inputs,
            }).responseText;
            jsonData = JSON.parse(StringData);

            $('#messagefooter').html("")
            // console.log(jsonData)
            var message = "";
            if (jsonData.check == "done") {
                message = "votre mot de passe est changé avec succès";
            } else {
                message = "votre mot de passe n'est pas changé";
            }
            $('#content').html(message);


        });


    }



    function generatePassword(type) {
        var length = 5,
            charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            retVal = type + "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
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