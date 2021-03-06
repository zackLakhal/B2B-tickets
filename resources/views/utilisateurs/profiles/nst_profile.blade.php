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


<div id="bodytab" class="row el-element-overlay">

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
        $('#logged_info').attr('value') == '4' ? init_client() :  init_nst();
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

    function init_nst() {

        var buttonacive;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/profile/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#bodytab').html("");
        var role_id = $('#logged_info').attr('value');
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
                "<li><a class=\"btn default btn-warning\" onclick=\"modifier_nst(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                //   (role_id == '1' || role_id == '6' ? buttonacive : "") +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</h3>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.users[ind].id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
                "</div>" +
                // "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                // "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                // "<h4 class=\"mb-0\">" +
                // "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                // "Informations" +
                // "</a>" +
                // "</h4>" +
                // "</div>" +
                // "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                // "<div class=\"card-body\">" +


                // "</div>" +
                // "</div>" +
                // "</div>" +

                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\" card col-lg-8 col-md-6\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"><b>Email :</b><spane id=\"email" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].email + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Tel :</b><spane id=\"tel" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].tel + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Adress : </b><spane id=\"adress" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].adress + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Role :</b><spane id=\"role" + ind + "\" value=\"" + jsonData.roles[ind].id + "\" style=\"margin-left : 10px;\">" + jsonData.roles[ind].value + "</spane></a>" +
                "</div>" +
                ref_links +
                "</div>" +
                "</div>"
            );
        }

    }

    function init_client() {

        var buttonacive;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/profile/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#bodytab').html("");
        var role_id = $('#logged_info').attr('value');
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
                "<li><a class=\"btn default btn-warning\" onclick=\"modifier_client(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                //   (role_id == '1' || role_id == '6' ? buttonacive : "") +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</h3>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "<button class=\"btn waves-effect waves-light btn-inverse\" onclick=\"pass_change(" + jsonData.users[ind].id + "," + ind + ",'" + type + "')\"> générer mot de passe</button>" +
                "</div>" +
                // "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                // "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                // "<h4 class=\"mb-0\">" +
                // "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                // "Informations" +
                // "</a>" +
                // "</h4>" +
                // "</div>" +
                // "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                // "<div class=\"card-body\">" +


                // "</div>" +
                // "</div>" +
                // "</div>" +

                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\" card col-lg-8 col-md-6\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"><b>Email :</b><spane id=\"email" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].email + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Tel :</b><spane id=\"tel" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].tel + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Adress : </b><spane id=\"adress" + ind + "\" style=\"margin-left : 10px;\">" + jsonData.users[ind].adress + "</spane></a>" +
                "<a class=\"list-group-item\" ><b>Role :</b><spane id=\"role" + ind + "\" value=\"" + jsonData.roles[ind].id + "\" style=\"margin-left : 10px;\">" + jsonData.roles[ind].value + "</spane></a>" +
                "<a class=\"list-group-item\" ><b> travail chez : </b><spane id=\"created_by" + ind + "\" value=\"" + jsonData.clients[ind].id + "\">" + jsonData.clients[ind].nom + "</spane></a>" +
                "</div>" +
                ref_links +
                "</div>" +
                "</div>"
            );
        }

    }

    function modifier_nst(id, ind) {

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
        $('#exampleModal').modal('show');
        $('#edit').click(function() {

            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("role", $('#logged_info').attr('value'));
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
                    "<li><a class=\"btn default btn-warning\"  onclick=\"modifier_nst(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                    // (role_id == '1' || role_id == '6' ? buttonacive : "") +
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
                    location.reload();
            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }

        });
    }

    function modifier_client(id, ind) {

        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier staff-client</h4>" +
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
        $('#exampleModal').modal('show');
        $('#edit').click(function() {
            console.log($('#created_by' + ind).attr('value'))
            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("created_by", $('#created_by' + ind).attr('value'));
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("role", $('#logged_info').attr('value'));
            form_data.append("img_histo",$('#dropify-preview-id').attr('style'));
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-client/edit/" + id,
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
                    "<li><a class=\"btn default btn-warning\"  onclick=\"modifier_client(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                    // (role_id == '1' || role_id == '6' ? buttonacive : "") +
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
                    "<a class=\"list-group-item\"  value=\"" + jsonData.client.id + "\"><b> travail chez : </b><spane id=\"created_by" + ind + "\">" + jsonData.client.nom + "</spane></a>" +

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
                    location.reload();
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