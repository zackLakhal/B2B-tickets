@extends('layouts.appback')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Espace client</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils</li>
            <li class="breadcrumb-item active">Espace client</li>
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
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                @if(auth::user()->role_id == 6 || auth::user()->role_id == 1 || auth::user()->role_id == 4)
                <button type="button" class="btn btn-primary pull-right" id="newmodal">+ nouvelle agence</button>
                @endif
                <div class="table-responsive m-t-40">

                    <table id="myTable" class=" text-center  table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Agence</th>
                                <th>Client</th>
                                <th>Ville</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id='bodytab'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Agence</th>
                                <th>Client</th>
                                <th>Ville</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


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

                <div class="form-group" id="err-client">
                    <label class="control-label ">Nom client</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="client" id="client">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-nom">
                    <label for="nom" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom" name="nom">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-email">
                    <label for="email" class="control-label"><b>Login:</b></label>
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

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData);
        $('#bodytab').html("");
        $('#client').html(" <option  value=\"0_0\" disabled selected  >selectioner un client </option>")
        $('#ville').html(" <option  value=\"0\" disabled selected  >selectioner une ville </option>")
       
       
        for (let ind = 0; ind < jsonData.agences.length; ind++) {
            buttonacive = ""
            if (jsonData.agences[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-danger\" style=\"margin-right: 10px\"  onclick=\"supprimer(" + jsonData.agences[ind].id + "," + ind + "," + jsonData.agences[ind].departement_id + "," + jsonData.agences[ind].client_id + ")\">supprimer</button>" //+ buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin-right: 10px\" onclick=\"restorer(" + jsonData.agences[ind].id + "," + ind + "," + jsonData.agences[ind].departement_id + "," + jsonData.agences[ind].client_id + ")\">restorer</button>"
            }



            $('#bodytab').append("<tr id=\"row" + ind + "\">" +
                "<th >" + jsonData.agences[ind].nom + "</th>" +
                "<th id=\"value" + ind + "\">" + jsonData.agence_clients[ind].nom + "</th>" +
                "<th >" + jsonData.villes[ind].nom + "</th>" +
                "<td>" +
                ( $('#logged_info').attr('value') == '5' ? "" : buttonacive) +
                "<a href=\"/outils/espace-client/agence/" + jsonData.agences[ind].id + "\" class=\"btn btn-success\" >Details</a>" +
                "</td>" +
                "</tr>");
        }

       for (ind in jsonData.clients){
            $('#client').append("<option value=\"" + ind + "_"+jsonData.clients[ind].id+"\">" + jsonData.clients[ind].nom + "</option>");
        }
        for (jjj in jsonData.all_villes){
            $('#ville').append("<option value=\"" + jsonData.all_villes[jjj].id + "\">" + jsonData.all_villes[jjj].nom + "</option>");
        }
        $('#ville').selectpicker('refresh');
        $('#client').selectpicker('refresh');
        
    }

    function supprimer(id, ind, dep_id, client_id) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + client_id + "/departements/" + dep_id + "/agences/delete/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);
       // console.log(jsonData)
        //message("agence", "supprimé", jsonData.check);
        buttonacive = ""
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin-right: 10px\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + "," + jsonData.agence.departement_id + "," + jsonData.agence.client_id + ")\">supprimer</button>" //+ buttonaffect;
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin-right: 10px\" onclick=\"restorer(" + jsonData.agence.id + "," + ind + "," + jsonData.agence.departement_id + "," + jsonData.agence.client_id + ")\">restorer</button>"
        }



        $('#row' + ind).html("<th >" + jsonData.agence.nom + "</th>" +
            " <th id=\"value" + ind + "\">" + jsonData.agence_client.nom + "</th>" +
            "<th >" + jsonData.ville.nom + "</th>" +
            "<td>" +
            buttonacive +
            "<a href=\"/outils/espace-client/agence/" + jsonData.agence.id + "\" class=\"btn btn-success\" >Details</a>" +
            "</td>");


    }

    function restorer(id, ind, dep_id, client_id) {


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + client_id + "/departements/" + dep_id + "/agences/restore/" + id,
            type: "POST",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        }).responseText;

        jsonData = JSON.parse(StringData);
        //console.log(jsonData)
        //   message("agence", "restoré", jsonData.check);

        buttonacive = ""
        if (jsonData.agence.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin-right: 10px\"  onclick=\"supprimer(" + jsonData.agence.id + "," + ind + "," + jsonData.agence.departement_id + "," + jsonData.agence.client_id + ")\">supprimer</button>" //+ buttonaffect;
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin-right: 10px\" onclick=\"restorer(" + jsonData.agence.id + "," + ind + "," + jsonData.agence.departement_id + "," + jsonData.agence.client_id + ")\">restorer</button>"
        }



        $('#row' + ind).html("<th >" + jsonData.agence.nom + "</th>" +
            " <th id=\"value" + ind + "\">" + jsonData.agence_client.nom + "</th>" +
            "<th >" + jsonData.ville.nom + "</th>" +
            "<td>" +
            ( $('#logged_info').attr('value') == '5' ? "" : buttonacive) +
            "<a href=\"/outils/espace-client/agence/" + jsonData.agence.id + "\" class=\"btn btn-success\" >Details</a>" +
            "</td>");


    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouvelle agence </h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");
        $('#client').val("");
        $('#nom').val("");
        $('#email').val("");
        $('#password').val("");
        $('#tel').val("");
        $('#adress').val("");
        $('#ville').val("");
        $('#ville').selectpicker('refresh');
        $('#exampleModal').modal('show');
        $('#save').click(function() {
            var text = "";
            $('#client').val() === null ? text = "0_0" : text = $('#client').val()
            //console.log( text.split("_"))
            var inputs = {
                "client": text.split("_")[1],
                "nom": $('#nom').val(),
                "email": $('#email').val(),
                "tel": $('#tel').val(),
                "adress": $('#adress').val(),
                "ville": $('#ville').val(),
                "password": $('#password').val(),
            };
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/" + text.split('_')[1] + "/departements/" + text.split('_')[0] + "/agences/create",
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

                $('#exampleModal').modal('hide');
                message("agence", "ajouté", jsonData.check);

                $('#bodytab').append("<tr id=\"row" + ind + "\">" +
                "<th >" + jsonData.agence.nom + "</th>" +
                "<th >" + jsonData.ville.nom + "</th>" +
                " <th id=\"value" + ind + "\">" + jsonData.agence.adress + "</th>" +
                "<td>" +
                buttonacive +
                "<a href=\"/outils/espace-client/agence/" + jsonData.agence.id + "\" class=\"btn btn-success\" >Details</a>" +
                "</td>" +
                "</tr>");

            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    });


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
</script>
@endsection