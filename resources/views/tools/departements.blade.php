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
<div class="row" id="bodytab">


</div>

<div class="modal fade" id="exampleModal" tabindex="-1" rqt="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="modalhead">

            </div>
            <div class="modal-body" id="modalbody">

                <div class="form-group">
                    <label for="nom" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom" name="nom">
                </div>
                <div class="form-group">
                    <label for="email" class="control-label"><b>email:</b></label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="tel" class="control-label"><b>tel:</b></label>
                    <input type="text" class="form-control" id="tel" name="tel">
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

        var buttonacive;
        var butttondetail;
        var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData);
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.departements.length; ind++) {

            if (jsonData.chefs[ind] == null) {
                chef = " <span id=\"chef"+ind+"\" value=\"0\"> pas de chef de département</span>"
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departements[ind].id + "," + ind + ")\">affecter un chef</button>"
            } else {
                chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+ind+"\" value=\"" + jsonData.chefs[ind].id + "\">" +
                    "<span class=\"tooltip-item\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.chefs[ind].photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].nom + " " + jsonData.chefs[ind].prénom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].tel + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chefs[ind].adress + "</p>" +
                    "</span> </span>" +
                    "</span>";
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departements[ind].id + "," + ind + ")\">changer chef</button>"

            }
            if (jsonData.departements[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departements[ind].id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departements[ind].id + "," + ind + ")\">supprimer</button>" + buttonaffect;
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departements[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-6\" id=\"card" + ind + "\" >" +
                "<div class=\"card \">" +
                "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departements[ind].nom + "</h2>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.departements[ind].email + "</h4>" +
                "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.departements[ind].tel + "</h4>" +
                "<h4 > Chef de departement : " + chef + " </h4>" +
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
                dataType: "json",
                type: "GET",
                async: false,
                data: inputs
            }).responseText;
            jsonData = JSON.parse(StringData);
            console.log(jsonData)
            $('#exampleModal').modal('hide');

            if (jsonData.chef == null) {
                chef = " <span id=\"chef"+jsonData.count+"\" value=\"0\"> pas de chef de département</span>"
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + jsonData.count + ")\">affecter un chef</button>"
            } else {
                chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+jsonData.count+"\" value=\"" + jsonData.chef.id + "\">" +
                    "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                    "</span> </span>" +
                    "</span>";
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + jsonData.count + ")\">changer chef</button>"

            }
            if (jsonData.departement.deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + jsonData.count + ")\">supprimer</button>" + buttonaffect
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + jsonData.count + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-6\" id=\"card" + jsonData.count + "\" >" +
                "<div class=\"card \">" +
                "<h2  id=\"nom" + jsonData.count + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departement.nom + "</h2>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"email" + jsonData.count + "\" class=\"card-title\"> email : " + jsonData.departement.email + "</h4>" +
                "<h4 id=\"tel" + jsonData.count + "\" class=\"card-title\"> tel : " + jsonData.departement.tel + "</h4>" +
                "<h4> Chef de departement : " + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + jsonData.count + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        });
    });



    function supprimer(id, ind) {
        var buttonacive;
        var butttondetail;
        var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/delete/" + id,
            dataType: "json",
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;

        jsonData = JSON.parse(StringData);
        console.log(jsonData)

        if (jsonData.chef == null) {
            chef = " <span id=\"chef"+ind+"\" value=\"0\"> pas de chef de département</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+ind+"\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.departement.deleted_at == null) {
            butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" + buttonaffect
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departement.nom + "</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.departement.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.departement.tel + "</h4>" +
            "<h4> Chef de departement : " + chef + " </h4>" +
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
        var buttonaffect;
        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/restore/" + id,
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;

        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        if (jsonData.chef == null) {
            chef = " <span id=\"chef"+ind+"\" value=\"0\"> pas de chef de département</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+ind+"\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.departement.deleted_at == null) {
            butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" + buttonaffect
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departement.nom + "</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.departement.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.departement.tel + "</h4>" +
            "<h4> Chef de departement : " + chef + " </h4>" +
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
        var buttonaffect;
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
                dataType: "json",
                type: "GET",
                async: false,
                data: inputs
            }).responseText;
            jsonData = JSON.parse(StringData);
            console.log(jsonData)
            $('#exampleModal').modal('hide');
            if (jsonData.chef == null) {
                chef = " <span id=\"chef"+ind+"\" value=\"0\"> pas de chef de département</span>"
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

            } else {
                chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+ind+"\" value=\"" + jsonData.chef.id + "\">" +
                    "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                    "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                    "<span class=\"tooltip-text p-t-10\">" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                    "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                    "</span> </span>" +
                    "</span>";
                buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

            }
            if (jsonData.departement.deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" + buttonaffect
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#card' + ind).html("<div class=\"card \">" +
                "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departement.nom + "</h2>" +
                "<div class=\"card-body\">" +
                "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.departement.email + "</h4>" +
                "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.departement.tel + "</h4>" +
                "<h4> Chef de departement : " + chef + " </h4>" +
                "<br>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>");
        });
    }

    function changer(id, place) {

        $('#affectationhead').html("<h4 class=\"modal-title\" >traitement chef</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        // $('#affectationfooter').html("<button type=\"hidden\"  id=\"id_d\" value=\""+id+"\">");
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-client/" + $('#id_c').val() + "/my_users",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);
        console.log(jsonData1);
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

    function select(id_d, id_u, ind) {
        var buttonacive;
        var butttondetail;
        var buttonaffect;
        var chef;
        var inputs = {
            "id_d": id_d,
            "id_u": id_u,
            "current_u": $('#chef' + ind).attr('value')
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/" + $('#id_c').val() + "/departements/affecter",
            dataType: "json",
            type: "GET",
            async: false,
            data: inputs
        }).responseText;

        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#affectation').modal('hide');
        if (jsonData.chef == null) {
            chef = " <span id=\"chef"+ind+"\" value=\"0\"> pas de chef de département</span>"
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">affecter un chef</button>"

        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef"+ind+"\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p  class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";
            buttonaffect = "<button  class=\"btn btn-inverse\"  onclick=\"changer(" + jsonData.departement.id + "," + ind + ")\">changer chef</button>"

        }
        if (jsonData.departement.deleted_at == null) {
            butttondetail = "<a href=\"/outils/clients/" + $('#id_c').val() + "/departements/" + jsonData.departement.id + "/agences\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.departement.id + "," + ind + ")\">supprimer</button>" + buttonaffect
        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.departement.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<h2  id=\"nom" + ind + "\"class=\"card-title text-center\" style=\"color: blue;\">" + jsonData.departement.nom + "</h2>" +
            "<div class=\"card-body\">" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\"> email : " + jsonData.departement.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\"> tel : " + jsonData.departement.tel + "</h4>" +
            "<h4> Chef de departement : " + chef + " </h4>" +
            "<br>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.departement.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }
</script>
@endsection