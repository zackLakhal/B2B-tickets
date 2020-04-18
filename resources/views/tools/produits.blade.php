@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h2 class="text-themecolor m-b-0 m-t-0"> Gérer les produits </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils client</li>
            <li class="breadcrumb-item text-themecolor">Gérer les produits</li>

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
                        <i class="fa fa-plus"></i> ajouter un nouveau produit
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

                <div class="form-group" id="err-nom_p">
                    <label for="nom_p" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom_p" name="nom_p">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group">
                    <label for="info_p" class="control-label"><b>informations :</b></label>
                    <input type="text" class="form-control" id="info_p" name="info_p">
                </div>

                <div class="form-group" id="pic_id">

                    <label for="produit">produit</label>
                    <input type="file" id="produit" name="produit" class="dropify" data-default-file="{{ asset('storage/produits/placeholder.jpg') }}" />
                </div>

            </div>
            <div class="modal-footer" id="modalfooter">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="equipementmodal" tabindex="-1" rqt="dialog" aria-labelledby="equipementlabel">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="equipementhead">

            </div>
            <div class="modal-body" id="equipementbody">

                <div class="form-group" id="err-nom_e">
                    <label for="nom_e" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom_e" name="nom_e">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-marque_e">
                    <label for="marque_e" class="control-label"><b>marke :</b></label>
                    <input type="text" class="form-control" id="marque_e" name="marque_e">
                    <small class="form-control-feedback"> </small>
                </div>

                <div class="form-group" id="err-modele_e">
                    <label for="modele_e" class="control-label"><b>modèle:</b></label>
                    <input type="text" class="form-control" id="modele_e" name="modele_e">
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-info_e">
                    <label for="info_e" class="control-label"><b>informations :</b></label>
                    <input type="text" class="form-control" id="info_e" name="info_e">
                </div>

                <div class="form-group" id="eic_id">

                    <label for="equip">equipement</label>
                    <input type="file" id="equip" name="equip" class="dropify" data-default-file="{{ asset('storage/produits/placeholder.jpg') }}" />
                </div>


            </div>
            <div class="modal-footer" id="equipementfooter">
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

        var buttonaciveproduit;
        var buttonaciveequipement;

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/produits/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);

        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            $('#accordionexample' + ind).html("");
            equips = "";
            if (jsonData[ind].deleted_at == null) {
                buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData[ind].id + "," + ind + ", -1)\">supprimer</button>"
            } else {
                buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData[ind].id + "," + ind + ", -1)\">restorer</button>"
            }

            for (let j = 0; j < jsonData[ind].equipements.length; j++) {
                if (jsonData[ind].equipements[j].active == 1) {
                    buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData[ind].id + "," + ind + "," + jsonData[ind].equipements[j].id + ")\">supprimer</button>"
                } else {
                    buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData[ind].id + "," + ind + "," + jsonData[ind].equipements[j].id + ")\">restorer</button>"
                }
                equips = equips +
                    "<div class=\"card\">" +
                    "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData[ind].equipements[j].id + "\">" +
                    "<h5 class=\"mb-0 text-center\">" +
                    "<a id=\"nom_e" + jsonData[ind].equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData[ind].equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData[ind].equipements[j].id + "\">" +
                    jsonData[ind].equipements[j].nom +
                    "</a>" +
                    "</h5>" +
                    "</div>" +

                    "<div id=\"collapseex" + jsonData[ind].equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData[ind].equipements[j].id + "\">" +
                    "<div class=\"card-body\">" +

                    "<img class=\"card-img-top\" id=\"equip" + jsonData[ind].equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData[ind].equipements[j].image + "\" alt=\"Card image cap\">" +
                    "<div class=\"card-body\">" +
                    "<h4 id=\"marque_e" + jsonData[ind].equipements[j].id + "\" class=\"card-title\">" + jsonData[ind].equipements[j].marque + "</h4>" +
                    "<h4 id=\"modele_e" + jsonData[ind].equipements[j].id + "\" class=\"card-title\">" + jsonData[ind].equipements[j].modele + "</h4>" +
                    "<p class=\"card-text\" id=\"info_e" + jsonData[ind].equipements[j].id + "\">" +
                    jsonData[ind].equipements[j].info +
                    "</p>" +
                    "<div class=\"button-group text-center\">" +
                    "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData[ind].id + "," + ind + "," + jsonData[ind].equipements[j].id + ")\">modifier</button>" +
                    buttonaciveequipement +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
            }
            $('#bodytab').append("<div class=\"col-12 \" id=\"pd_" + ind + "\">" +
                "<div class=\"card\" >" +
                "<div class=\"card-body\">" +


                "<div class=\"row\">" +
                "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData[ind].image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
                "<div class=\"col-lg-4 col-md-4\">" +
                "<div class=\"card-title text-center\">" +
                "<h2 id=\"nom_p" + ind + "\">" + jsonData[ind].nom + "</h2>" +
                "<p id=\"info_p" + ind + "\">" +
                jsonData[ind].info +
                "</p>" +
                "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData[ind].id + "," + ind + ")\">modifier</button>" +
                buttonaciveproduit +
                "</div>" +

                "</div>" +
                "</div>" +
                "<div class=\"col-lg-4 col-md-4 text-center\" >" +
                "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData[ind].id + "," + ind + ")\"> nouveau equipement</button>" +
                "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                equips +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }


    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau produit</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save_p\">Enregistrer</button>");

        $('#nom_p').val("");
        $('#info_p').val("");
        $('#exampleModal').modal('show');

        $('#save_p').click(function() {

            form_data = new FormData();

            form_data.append("produit", $('#produit')[0].files[0]);
            form_data.append("nom_p", $('#nom_p').val());
            form_data.append("info_p", $('#info_p').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/create",
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
            if ($.isEmptyObject(jsonData.error)) {
                
                clearInputs(jsonData.inputs);

                $('#exampleModal').modal('hide');
                message("produit", "ajouté", jsonData.check);
                equips = "";
                $('#accordionexample' + jsonData.count).html("");
                if (jsonData.produit.deleted_at == null) {
                    buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + jsonData.count + ", -1)\">supprimer</button>"
                } else {
                    buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + jsonData.count + ", -1)\">restorer</button>"
                }

                for (let j = 0; j < jsonData.produit.equipements.length; j++) {
                    if (jsonData.produit.equipements[j].active == 1) {
                        buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + jsonData.count + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
                    } else {
                        buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + jsonData.count + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
                    }
                    equips = equips +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + jsonData.count + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].nom +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<div class=\"card-body\">" +

                        "<img class=\"card-img-top\" id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                        "<div class=\"card-body\">" +
                        "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                        "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                        "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].info +
                        "</p>" +
                        "<div class=\"button-group text-center\">" +
                        "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + jsonData.count + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                        buttonaciveequipement +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                }
                $('#bodytab').append("<div class=\"col-12 \" id=\"pd_" + jsonData.count + "\">" +
                    "<div class=\"card\">" +
                    "<div class=\"card-body\">" +


                    "<div class=\"row\">" +
                    "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + jsonData.count + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
                    "<div class=\"col-lg-4 col-md-4\">" +
                    "<div class=\"card-title text-center\">" +
                    "<h2 id=\"nom_p" + jsonData.count + "\">" + jsonData.produit.nom + "</h2>" +
                    "<p id=\"info_p" + jsonData.count + "\">" +
                    jsonData.produit.info +
                    "</p>" +
                    "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + jsonData.count + ")\">modifier</button>" +
                    buttonaciveproduit +
                    "</div>" +

                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-4 col-md-4 text-center\" >" +
                    "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + jsonData.count + ")\"> nouveau equipement</button>" +
                    "<div id=\"accordionexample" + jsonData.count + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    equips +
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




    function supprimer(type, p_id, ind, e_id) {
        var link = "";
        var equips = "";
        if (type == 'produit') {
            link = "http://127.0.0.1:8000/outils/produits/delete/" + p_id;
        }
        if (type == 'equipement') {
            link = "http://127.0.0.1:8000/outils/produits/" + p_id + "/equipements/delete/" + e_id;
        }
        var StringData = $.ajax({
            url: link,
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
        console.log(jsonData)
        message(type, "supprimé", jsonData.check);
        if (jsonData.produit.deleted_at == null) {
            buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">supprimer</button>"
        } else {
            buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">restorer</button>"
        }

        for (let j = 0; j < jsonData.produit.equipements.length; j++) {
            if (jsonData.produit.equipements[j].active == 1) {
                buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
            } else {
                buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
            }
            equips = equips +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                jsonData.produit.equipements[j].nom +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                "<div class=\"card-body\">" +

                "<img class=\"card-img-top\"  id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                jsonData.produit.equipements[j].info +
                "</p>" +
                "<div class=\"button-group text-center\">" +
                "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                buttonaciveequipement +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>"
        }
        $('#accordionexample' + ind).html("");
        $('#pd_' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +


            "<div class=\"row\">" +
            "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
            "<div class=\"col-lg-4 col-md-4\">" +
            "<div class=\"card-title text-center\">" +
            "<h2 id=\"nom_p" + ind + "\">" + jsonData.produit.nom + "</h2>" +
            "<p id=\"info_p" + ind + "\">" +
            jsonData.produit.info +
            "</p>" +
            "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + ind + ")\">modifier</button>" +
            buttonaciveproduit +
            "</div>" +

            "</div>" +
            "</div>" +
            "<div class=\"col-lg-4 col-md-4 text-center\" >" +
            "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + ind + ")\"> nouveau equipement</button>" +
            "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
            equips +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(type, p_id, ind, e_id) {


        var link = "";
        var equips = "";
        if (type == 'produit') {
            link = "http://127.0.0.1:8000/outils/produits/restore/" + p_id;
        }
        if (type == 'equipement') {
            link = "http://127.0.0.1:8000/outils/produits/" + p_id + "/equipements/restore/" + e_id;
        }
        var StringData = $.ajax({
            url: link,
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
        message(type, "restoré", jsonData.check);
        if (jsonData.produit.deleted_at == null) {
            buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">supprimer</button>"
        } else {
            buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">restorer</button>"
        }

        for (let j = 0; j < jsonData.produit.equipements.length; j++) {
            if (jsonData.produit.equipements[j].active == 1) {
                buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
            } else {
                buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
            }
            equips = equips +
                "<div class=\"card\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                "<h5 class=\"mb-0 text-center\">" +
                "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                jsonData.produit.equipements[j].nom +
                "</a>" +
                "</h5>" +
                "</div>" +

                "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                "<div class=\"card-body\">" +

                "<img class=\"card-img-top\"  id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                jsonData.produit.equipements[j].info +
                "</p>" +
                "<div class=\"button-group text-center\">" +
                "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                buttonaciveequipement +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>"
        }
        $('#accordionexample' + ind).html("");
        $('#pd_' + ind).html("<div class=\"card\">" +
            "<div class=\"card-body\">" +


            "<div class=\"row\">" +
            "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
            "<div class=\"col-lg-4 col-md-4\">" +
            "<div class=\"card-title text-center\">" +
            "<h2 id=\"nom_p" + ind + "\">" + jsonData.produit.nom + "</h2>" +
            "<p id=\"info_p" + ind + "\">" +
            jsonData.produit.info +
            "</p>" +
            "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + ind + ")\">modifier</button>" +
            buttonaciveproduit +
            "</div>" +

            "</div>" +
            "</div>" +
            "<div class=\"col-lg-4 col-md-4 text-center\" >" +
            "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + ind + ")\"> nouveau equipement</button>" +
            "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
            equips +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier_produit(id, ind) {

        var equips = "";
        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier produit</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");

        $('#pic_id').html("<label for=\"produit\">produit</label>" +
            "<input type=\"file\" id=\"produit\" name=\"produit\" class=\"dropify\" data-default-file=\"" + $('#produit' + ind).attr('src') + "\"  />");
        $('.dropify').dropify();

        $('#nom_p').val($('#nom_p' + ind).html());
        $('#info_p').val($('#info_p' + ind).html());
        $('#exampleModal').modal('show');
        $('#edit').click(function() {
            form_data = new FormData();

            form_data.append("produit", $('#produit')[0].files[0]);
            form_data.append("nom_p", $('#nom_p').val());
            form_data.append("info_p", $('#info_p').val());
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/edit/" + id,
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
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#exampleModal').modal('hide');
                message("produit", "modifié", jsonData.check);
                if (jsonData.produit.deleted_at == null) {
                    buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">supprimer</button>"
                } else {
                    buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">restorer</button>"
                }

                for (let j = 0; j < jsonData.produit.equipements.length; j++) {
                    if (jsonData.produit.equipements[j].active == 1) {
                        buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
                    } else {
                        buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
                    }
                    equips = equips +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].nom +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<div class=\"card-body\">" +

                        "<img class=\"card-img-top\"  id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                        "<div class=\"card-body\">" +
                        "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                        "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                        "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].info +
                        "</p>" +
                        "<div class=\"button-group text-center\">" +
                        "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                        buttonaciveequipement +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                }
                $('#accordionexample' + ind).html("");
                $('#pd_' + ind).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +


                    "<div class=\"row\">" +
                    "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
                    "<div class=\"col-lg-4 col-md-4\">" +
                    "<div class=\"card-title text-center\">" +
                    "<h2 id=\"nom_p" + ind + "\">" + jsonData.produit.nom + "</h2>" +
                    "<p id=\"info_p" + ind + "\">" +
                    jsonData.produit.info +
                    "</p>" +
                    "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + ind + ")\">modifier</button>" +
                    buttonaciveproduit +
                    "</div>" +

                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-4 col-md-4 text-center\" >" +
                    "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + ind + ")\"> nouveau equipement</button>" +
                    "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    equips +
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

    function ajouter(id, ind) {


        $('#equipementhead').html("<h4 class=\"modal-title\" >ajouter equipement</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#equipementfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save_e\">Enregistrer</button>");

        $('#equipementmodal').modal('show');

        $('#nom_e').val("");
        $('#info_e').val("");
        $('#modele_e').val("");
        $('#marque_e').val("");

        $('#save_e').click(function() {
            var equips = "";
            form_data = new FormData();

            form_data.append("equip", $('#equip')[0].files[0]);
            form_data.append("nom_e", $('#nom_e').val());
            form_data.append("info_e", $('#info_e').val());
            form_data.append("modele_e", $('#modele_e').val());
            form_data.append("marque_e", $('#marque_e').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/" + id + "/equipements/create",
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
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);
                $('#equipementmodal').modal('hide');
                message("equipement", "ajouté", jsonData.check);
                if (jsonData.produit.deleted_at == null) {
                    buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">supprimer</button>"
                } else {
                    buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">restorer</button>"
                }

                for (let j = 0; j < jsonData.produit.equipements.length; j++) {
                    if (jsonData.produit.equipements[j].active == 1) {
                        buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
                    } else {
                        buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
                    }
                    equips = equips +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].nom +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<div class=\"card-body\">" +

                        "<img class=\"card-img-top\"  id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                        "<div class=\"card-body\">" +
                        "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                        "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                        "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].info +
                        "</p>" +
                        "<div class=\"button-group text-center\">" +
                        "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                        buttonaciveequipement +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                }
                $('#accordionexample' + ind).html("");
                $('#pd_' + ind).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +


                    "<div class=\"row\">" +
                    "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
                    "<div class=\"col-lg-4 col-md-4\">" +
                    "<div class=\"card-title text-center\">" +
                    "<h2 id=\"nom_p" + ind + "\">" + jsonData.produit.nom + "</h2>" +
                    "<p id=\"info_p" + ind + "\">" +
                    jsonData.produit.info +
                    "</p>" +
                    "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + ind + ")\">modifier</button>" +
                    buttonaciveproduit +
                    "</div>" +

                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-4 col-md-4 text-center\" >" +
                    "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + ind + ")\"> nouveau equipement</button>" +
                    "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    equips +
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

    function modifier_equipement(id, ind, id_e) {

        var equips = "";
        $('#equipementhead').html("<h4 class=\"modal-title\" >Modifier equipement</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#equipementfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit_e\">Enregistrer</button>");

        $('#eic_id').html("<label for=\"equip\">equipement</label>" +
            "<input type=\"file\" id=\"equip\" name=\"equip\" class=\"dropify\" data-default-file=\"" + $('#equip' + id_e).attr('src') + "\"  />");
        $('.dropify').dropify();

        $('#nom_e').val($('#nom_e' + id_e).html());
        $('#info_e').val($('#info_e' + id_e).html());
        $('#modele_e').val($('#modele_e' + id_e).html());
        $('#marque_e').val($('#marque_e' + id_e).html());
        $('#equipementmodal').modal('show');

        $('#edit_e').click(function() {
            form_data = new FormData();

            form_data.append("equip", $('#equip')[0].files[0]);
            form_data.append("nom_e", $('#nom_e').val());
            form_data.append("info_e", $('#info_e').val());
            form_data.append("modele_e", $('#modele_e').val());
            form_data.append("marque_e", $('#marque_e').val());
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/produits/" + id + "/equipements/edit/" + id_e,
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
            if ($.isEmptyObject(jsonData.error)) {

                clearInputs(jsonData.inputs);

                $('#equipementmodal').modal('hide');
                message("equipement", "modifié", jsonData.check);
                if (jsonData.produit.deleted_at == null) {
                    buttonaciveproduit = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">supprimer</button>"
                } else {
                    buttonaciveproduit = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('produit'," + jsonData.produit.id + "," + ind + ", -1)\">restorer</button>"
                }

                for (let j = 0; j < jsonData.produit.equipements.length; j++) {
                    if (jsonData.produit.equipements[j].active == 1) {
                        buttonaciveequipement = "<button  class=\"btn btn-danger\"  onclick=\"supprimer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">supprimer</button>"
                    } else {
                        buttonaciveequipement = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer('equipement'," + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">restorer</button>"
                    }
                    equips = equips +
                        "<div class=\"card\">" +
                        "<div class=\"card-header\" role=\"tab\" id=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<h5 class=\"mb-0 text-center\">" +
                        "<a id=\"nom_e" + jsonData.produit.equipements[j].id + "\" data-toggle=\"collapse\" data-parent=\"#accordionexample" + ind + "\" href=\"#collapseex" + jsonData.produit.equipements[j].id + "\" aria-expanded=\"false\" aria-controls=\"collapseex" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].nom +
                        "</a>" +
                        "</h5>" +
                        "</div>" +

                        "<div id=\"collapseex" + jsonData.produit.equipements[j].id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"heading" + jsonData.produit.equipements[j].id + "\">" +
                        "<div class=\"card-body\">" +

                        "<img class=\"card-img-top\"  id=\"equip" + jsonData.produit.equipements[j].id + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.equipements[j].image + "\" alt=\"Card image cap\">" +
                        "<div class=\"card-body\">" +
                        "<h4 id=\"marque_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].marque + "</h4>" +
                        "<h4 id=\"modele_e" + jsonData.produit.equipements[j].id + "\" class=\"card-title\">" + jsonData.produit.equipements[j].modele + "</h4>" +
                        "<p class=\"card-text\" id=\"info_e" + jsonData.produit.equipements[j].id + "\">" +
                        jsonData.produit.equipements[j].info +
                        "</p>" +
                        "<div class=\"button-group text-center\">" +
                        "<button  class=\"btn btn-warning\" \" onclick=\"modifier_equipement(" + jsonData.produit.id + "," + ind + "," + jsonData.produit.equipements[j].id + ")\">modifier</button>" +
                        buttonaciveequipement +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                }
                $('#accordionexample' + ind).html("");
                $('#pd_' + ind).html("<div class=\"card\">" +
                    "<div class=\"card-body\">" +


                    "<div class=\"row\">" +
                    "<div class=\"col-lg-4 col-md-4\"><img id=\"produit" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.produit.image + "\" class=\"img-responsive img-thumbnail\" /></div>" +
                    "<div class=\"col-lg-4 col-md-4\">" +
                    "<div class=\"card-title text-center\">" +
                    "<h2 id=\"nom_p" + ind + "\">" + jsonData.produit.nom + "</h2>" +
                    "<p id=\"info_p" + ind + "\">" +
                    jsonData.produit.info +
                    "</p>" +
                    "<div class=\"button-group\" style=\"position: absolute; bottom: 0;  left: 0%;right: 0%; \">" +
                    "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier_produit(" + jsonData.produit.id + "," + ind + ")\">modifier</button>" +
                    buttonaciveproduit +
                    "</div>" +

                    "</div>" +
                    "</div>" +
                    "<div class=\"col-lg-4 col-md-4 text-center\" >" +
                    "<button  class=\"btn  btn-success \" style=\"margin-bottom: 10px\" onclick=\"ajouter(" + jsonData.produit.id + "," + ind + ")\"> nouveau equipement</button>" +
                    "<div id=\"accordionexample" + ind + "\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                    equips +
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