@extends('layouts.appback')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0"></h3>
        <h2 class="text-themecolor m-b-0 m-t-0"> {{$agence->nom}} </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils</li>
            <li class="breadcrumb-item active" value="{{$agence->id}}" id="id_a">{{$agence->nom}}</li>
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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> Equipements</h3>
                <div class="row justify-content-center" id="equip_list">
                    <div class="col-4 ">
                        <h3>pas d'équipement</h3>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="modalhead">
                <h4 class="modal-title">nouvelle réclamation </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="form-group text-center">
                    <h3 class="control-label" id="equip_nom"></h3>
                </div>
                <div id="pending_refs">

                </div>
                <br>
                <div class="form-group" id="err-ref">
                    <label class="control-label">Référence</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="ref" id="ref">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-anomalie">
                    <label class="control-label">Anomalie</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="anomalie" id="anomalie">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group">
                    <label for="commentaire" class="control-label"><b>commentaire</b></label>
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="5"></textarea>
                </div>


            </div>
            <div class="modal-footer" id="modalfooter">
                <button type="button" class="btn btn-info" id="save">Enregistrer</button>
            </div>
        </div>


    </div>

</div>

<div class="modal fade" id="editModal" tabindex="-1" rqt="dialog" aria-labelledby="editModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="edithead">

            </div>
            <div class="modal-body" id="editbody">

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
            <div class="modal-footer" id="editfooter">
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

        var chef;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#id_a').val() + "/detail",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        console.log(jsonData)
        $('#bodytab').html("");
        produit = "";
        if (jsonData.chef == null) {
            chef = " <span id=\"chef" + $('#id_a').val() + "\" value=\"0\"> pas de chef d'agence</span>"
        } else {
            chef = "<span class=\"mytooltip tooltip-effect-5\" id=\"chef" + $('#id_a').val() + "\" value=\"" + jsonData.chef.id + "\">" +
                "<span class=\"tooltip-item\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</span> <span class=\"tooltip-content clearfix\">" +
                "<img src=\"{{ asset('storage') }}/" + jsonData.chef.photo + "\" width=\"180\" /><br />" +
                "<span class=\"tooltip-text p-t-10\">" +
                "<p class=\"card-text text-center\">" + jsonData.chef.nom + " " + jsonData.chef.prénom + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.email + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.tel + "</p>" +
                "<p class=\"card-text text-center\">" + jsonData.chef.adress + "</p>" +
                "</span> </span>" +
                "</span>";

        }

        for (let j = 0; j < jsonData.souscription.produits.length; j++) {


            produit = produit +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a  id=\"nom_p" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + $('#id_a').val() + "\" href=\"#collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<span >" + jsonData.souscription.produits[j].prod_nom + "</span>" +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.souscription.produits[j].prod_id + "_" + jsonData.souscription.id + "\">" +
                "<div class=\"card-body\">" +
                "<img id=\"produit" + $('#id_a').val() + "\" src=\"{{ asset('storage') }}/" + jsonData.souscription.produits[j].image + "\" class=\"img-responsive img-thumbnail\" />" +
                "<div class=\"text-center\">" +
                "<div style=\"margin: 10px 0px\" class=\"col-lg-12 col-md-6 col-xlg-2 col-xs-12\">" +
                "<h2 ><b> Nom : </b>" + jsonData.souscription.produits[j].prod_nom + "</h2>" +
                "<p id=\"info_p" + $('#id_a').val() + "\"> <spane style=\" font-weight: bold\"> Détails : </spane> " +
                jsonData.souscription.produits[j].info +
                "</p>" +
                "</div>" +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<button type=\"button\" class=\"btn waves-effect waves-light btn-primary\"onclick=\"get_equipements(" + jsonData.souscription.produits[j].prod_id + ")\">afficher les équipements</button>" +
                "</div>" +
                "</div>" +
                "</div>";

        }
        var buttonpass =             "<button class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\" onclick=\"pass_change(" + jsonData.chef.id + ")\">Générer mot de passe</button>" 

        $('#bodytab').append("<div class=\"col-12 \" id=\"card" + $('#id_a').val() + "\">" +
            "<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + $('#id_a').val() + "\" class=\"card-title text-center\" style=\" font-weight: bold\">" + jsonData.agence.nom + "</h2>" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-md-6 \" id=\"card" + $('#id_a').val() + "\">" +
            "<div class=\"card \">" +
            "<h2  class=\"card-title text-center\" > informations</h2>" +
            "<hr>" +
            "<div class=\"card-body\">" +
            "<h4  class=\"card-title\"><b> Login : </b> <spane id=\"email" + $('#id_a').val() + "\">" + (jsonData.agence.email).split('@')[0] + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Departement : </b> <spane id=\"departement" + $('#id_a').val() + "\">" + jsonData.departement.nom + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Client : </b> <spane id=\"client" + $('#id_a').val() + "\">" + jsonData.client.nom + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Tel : </b> <spane id=\"tel" + $('#id_a').val() + "\">" + jsonData.agence.tel + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> Adresse : </b> <spane id=\"adress" + $('#id_a').val() + "\">" + jsonData.agence.adress + "</spane></h4>" +
            "<h4  class=\"card-title\"><b> ville : </b> <spane value=\"" + jsonData.ville.id + "\" id=\"ville" + $('#id_a').val() + "\">" + jsonData.ville.nom + "</spane></h4>" +
            // "<h4> <b>Chef d'agence : </b>" + chef + " </h4>" +
            
            "<div class=\"button-group text-center\">" +
            "<button class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.agence.id + "," + $('#id_a').val() + ")\">modifier</button>" +
            ( $('#logged_info').attr('value') == '5' ? "" : buttonpass) +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div class=\"col-lg-6 \">" +
            "<div class=\"card\" id=\"product\">" +
            "<h3 class=\"card-title text-center\">produits</h3>" +
            "<hr>" +
            "<div class=\"card-body\">" +
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

    }

    function get_equipements(produit) {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#id_a').val() + "/get_equipements/" + produit,
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;
        jsonData = JSON.parse(StringData);
        var role_id = $('#logged_info').attr('value');
        $('#equip_list').html("");
        for (let j = 0; j < jsonData.equipements.length; j++) {
            $('#equip_list').append("<div class=\"col-md-4\">" +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.equipements[j].equip_id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a id=\"nom_e" + jsonData.equipements[j].equip_id + "\" >" +
                jsonData.equipements[j].nom +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div class=\"card-body\">" +

                "<img class=\"card-img-top\" id=\"equip" + jsonData.equipements[j].equip_id + "\" src=\"{{ asset('storage') }}/" + jsonData.equipements[j].image + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h4 id=\"marque_e" + jsonData.equipements[j].equip_id + "\" class=\"card-title\"><b>Marque :  </b> " + jsonData.equipements[j].marque + "</h4>" +
                "<h4 id=\"modele_e" + jsonData.equipements[j].equip_id + "\" class=\"card-title\"><b>Modèle :  </b> " + jsonData.equipements[j].modele + "</h4>" +
                "<p class=\"card-text\" id=\"info_e" + jsonData.equipements[j].equip_id + "\"><spane style=\" font-weight: bold\"> Détails : </spane> " +
                jsonData.equipements[j].info +
                "</p>" +
                "<div class=\"button-group text-center\">" +
                (role_id != '2' && role_id != '3' ? "<button  class=\"btn btn-warning\" \" onclick=\"reclamer(" + produit + "," + jsonData.equipements[j].equip_id + ")\">réclamer sur l'équipement</button>" : "") +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>")

        }
    }

    function reclamer(produit, equip) {

        $('#ref').html("<option value=\"0\"selected disabled >selectioner une référance </option>")
        $('#anomalie').html(" <option  value=\"0\"selected disabled >selectioner une anomalie </option>")
        var inputs = {
            "id_p": produit,
            "id_e": equip
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#id_a').val() + "/get_refs",
            dataType: "json",
            type: "GET",
            data: inputs,
            async: false
        }).responseText;
        jsonData = JSON.parse(StringData);

        $('#pending_refs').html("");

        $('#equip_nom').html(jsonData.equipement.nom);
        for (let ind = 0; ind < jsonData.refs.length; ind++) {
            if (jsonData.refs[ind].etat_id != 1 && jsonData.refs[ind].etat_id != 2) {
                $('#ref').append("<option value=\"" + jsonData.refs[ind].ref_id + "\">" + jsonData.refs[ind].ref + "</option>");
            } else {
                $('#pending_refs').append("<small style=\"color : #fb052c\"><b>" + jsonData.refs[ind].ref + " :</b> sous réclamation </small> <br>")
            }
        }
        $('#ref').selectpicker('refresh');
        for (let ind = 0; ind < jsonData.anomalies.length; ind++) {
            $('#anomalie').append("<option value=\"" + jsonData.anomalies[ind].id + "\">" + jsonData.anomalies[ind].value + "</option>");
        }
        $('#anomalie').selectpicker('refresh');
        $('#commentaire').val("");

        $('#exampleModal').modal('show');

        $('#save').click(function() {

            var inputs = {
                "ref": $('#ref').val(),
                "anomalie": $('#anomalie').val(),
                "commentaire": $('#commentaire').val()

            };

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#id_a').val() + "/reclamer",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: inputs,
            }).responseText;
            jsonData = JSON.parse(StringData);
            // console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#exampleModal').modal('hide');
                message("réclamation", "ajouté", jsonData.check);
            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    }

    function modifier(id, ind) {
        var buttonacive;
        var butttondetail;
        //var buttonaffect;
        var chef;
        $('#edithead').html("<h4 class=\"modal-title\" >Modifier agence</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#editfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
        $('#password').val("");
        $('#err-password').hide();
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#ville').val($('#ville' + ind).attr('value'));
        $('#ville').selectpicker('refresh');
        $('#editModal').modal('show');
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
            console.log(jsonData)
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#editModal').modal('hide');
                message("agence", "modifié", jsonData.check);
                location.reload();
               

            } else {
                clearInputs(jsonData.inputs);
                printErrorMsg(jsonData.error);
            }
        });
    }

    function pass_change(id) {
        var pass = generatePassword("AG-")
        $('#messagefooter').html("<button type=\"button\" class=\"btn btn-inverse\" id=\"pass_edit\">Enregistrer</button>");
        $('#content').html("mot de pass généré est : <br><br><h2> " + pass + "</h2>");
        $('#messagebox').modal('show');

        $('#pass_edit').click(function() {

            var inputs = {
                "type": "client",
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
             console.log(jsonData)
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
</script>
@endsection