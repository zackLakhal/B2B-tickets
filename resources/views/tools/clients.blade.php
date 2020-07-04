@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer les clients</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils client</li>
            <li class="breadcrumb-item active">Gérer les clients</li>
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
                        <i class="fa fa-plus"></i> ajouter un nouveau client
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
                <label class="control-label ">Nom client</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_nom" id="fv_nom">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">Email client</label>
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
                <div class="form-group" id="err-adress">
                    <label for="adress" class="control-label"><b>adress:</b></label>
                    <input type="text" class="form-control" id="adress" name="adress">
                    <small class="form-control-feedback"> </small>
                </div>

                <div class="form-group" id="pic_id">

                    <label for="avatar">avatar</label>
                    <input type="file" id="avatar" name="avatar" class="dropify" data-default-file="{{ asset('storage/clients/placeholder.jpg') }}" />
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
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
         console.log(jsonData)
        $('#bodytab').html("");

        $('#fv_nom').html(" <option  value=\"0\"selected  >tout les clients </option>")
        $('#fv_email').html(" <option  value=\"0\"selected  >tout les clients </option>")
        var role_id = $('#logged_info').attr('value');
        for (let ind = 0; ind < jsonData.clients.length; ind++) {

            $('#fv_nom').append("<option value=\"" + jsonData.clients[ind].id + "\">" + jsonData.clients[ind].nom + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData.clients[ind].id + "\">" + jsonData.clients[ind].email + "</option>");


            if (jsonData.clients[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + jsonData.clients[ind].id + "/departements/"+jsonData.departements[ind].id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.clients[ind].id + "," + ind + ")\">supprimer</button>"
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.clients[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-4 m-t-30\" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.clients[ind].photo + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.clients[ind].nom + "</h2>" +
                "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + ind + "\">" + jsonData.clients[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.clients[ind].tel + "</spane></h4>" +
                "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + ind + "\">" + jsonData.clients[ind].adress + "</spane></p>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                (role_id != '2' && role_id != '3' && role_id != '5' ? "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.clients[ind].id + "," + ind + ")\">modifier</button>" : "") +
                (role_id == '6' || role_id == '1' ? buttonacive : "") +
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
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"{{ asset('storage/clients/placeholder.jpg') }}\"  />");
        $('.dropify').dropify();

        $('#nom').val("");
        $('#email').val("");
        $('#err-password').show();
        $('#password').val("");
        $('#tel').val("");
        $('#adress').val("");

        $('#exampleModal').modal('show');

        $('#save').click(function() {

            form_data = new FormData();
            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("nom", $('#nom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("password", $('#password').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/create",
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
            // console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);

                $('#exampleModal').modal('hide');

                message("client", "ajouté", jsonData.check);

                if (jsonData.client.deleted_at == null) {
                    butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements/"+jsonData.departement.id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + jsonData.count + ")\">supprimer</button>"

                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + jsonData.count + ")\">restorer</button>"
                    butttondetail = "";
                }
                $('#bodytab').append("<div class=\"col-md-4 m-t-30\" id=\"card" + jsonData.count + "\">" +
                    "<div class=\"card \">" +
                    "<img class=\"card-img-top img-responsive\" id=\"avatar" + jsonData.count + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + jsonData.count + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
                    "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + jsonData.count + "\">" + jsonData.client.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + jsonData.count + "\">" + jsonData.client.tel + "</spane></h4>" +
                    "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + jsonData.count + "\">" + jsonData.client.adress + "</spane></p>" +
                    "<div class=\"button-group text-center\">" +
                    butttondetail +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + jsonData.count + ")\">modifier</button>" +
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
        var client_id;
        var is_deleted;

        $('#rd_nom').is(':checked') ? client_id = $('#fv_nom').val() : client_id = $('#fv_email').val()
        $('#active').is(':checked') ? is_deleted = $('#active').val() : is_deleted = $('#deleted').val()

        form_data.append("client_id", client_id);
        form_data.append("is_all", $('#fv_dr').is(':checked'));
        form_data.append("is_deleted", is_deleted);

        // // console.log(jsonData)
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/filter_index",
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

        for (let ind = 0; ind < jsonData.clients.length; ind++) {

            $('#fv_nom').append("<option value=\"" + jsonData.clients[ind].id + "\">" + jsonData.clients[ind].nom + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData.clients[ind].id + "\">" + jsonData.clients[ind].email + "</option>");


            if (jsonData.clients[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + jsonData.clients[ind].id + "/departements/"+jsonData.departements[ind].id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.clients[ind].id + "," + ind + ")\">supprimer</button>"
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.clients[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-4 m-t-30\" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.clients[ind].photo + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.clients[ind].nom + "</h2>" +
                "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + ind + "\">" + jsonData.clients[ind].email + "</spane></h4>" +
                "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.clients[ind].tel + "</spane></h4>" +
                "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + ind + "\">" + jsonData.clients[ind].adress + "</spane></p>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.clients[ind].id + "," + ind + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }
    });

    function supprimer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/delete/" + id,
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
        message("client", "supprimé", jsonData.check);
        console.log(jsonData)
        if (jsonData.client.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
            butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements/"+jsonData.departement.id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
            "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + ind + "\">" + jsonData.client.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.client.tel + "</spane></h4>" +
            "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + ind + "\">" + jsonData.client.adress + "</spane></p>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/restore/" + id,
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
        message("client", "restoré", jsonData.check);

        if (jsonData.client.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
            butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements/"+jsonData.departement.id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
            "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + ind + "\">" + jsonData.client.email + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.client.tel + "</spane></h4>" +
            "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + ind + "\">" + jsonData.client.adress + "</spane></p>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {

        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");

        $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"" + $('#avatar' + ind).attr('src') + "\"  />");
        $('.dropify').dropify();

        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#password').val("");
        $('#err-password').hide();
        $('#exampleModal').modal('show');

        $('#edit').click(function() {
            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("nom", $('#nom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/edit/" + id,
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
            var role_id = $('#logged_info').attr('value');
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);


                $('#exampleModal').modal('hide');

                message("client", "modifié", jsonData.check);

                if (jsonData.client.deleted_at == null) {
                    buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
                    butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements/"+jsonData.departement.id+"/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

                } else {
                    buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
                    butttondetail = ""
                }
                $('#card' + ind).html("<div class=\"card \">" +
                    "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
                    "<div class=\"card-body\">" +
                    "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
                    "<h4  class=\"card-title\"><b>Email :</b><spane id=\"email" + ind + "\">" + jsonData.client.email + "</spane></h4>" +
                    "<h4  class=\"card-title\"><b> Tel : </b><spane id=\"tel" + ind + "\">" + jsonData.client.tel + "</spane></h4>" +
                    "<p  class=\"card-text\"><spane style=\"font-weight: bold; color : #455a64;\"> Adresse :</spane> <br><spane id=\"adress" + ind + "\">" + jsonData.client.adress + "</spane></p>" +
                    "<div class=\"button-group text-center\">" +
                    butttondetail +
                    (role_id != '2' && role_id != '3' && role_id != '5' ? "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" : "") +
                    (role_id == '6' || role_id == '1' ? buttonacive : "") +
                    "</div>" +
                    "</div>" +
                    "</div>");

            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }

        });
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