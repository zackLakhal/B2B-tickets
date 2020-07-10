@extends('layouts.appback')

@section('refresh')
<!-- <meta http-equiv="refresh" content="5"/> -->
@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Home</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Statistiques</li>
            <li class="breadcrumb-item active">Dashboard</li>
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
@if(auth::user()->role_id != 5 && auth::user()->role_id != 4 && auth::user()->role_id != 6 )
<div class="">
    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter  text-white"></i></button>
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
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="nom" id="nom">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">Email client</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="email" id="email">

                </select>
            </div>
            <div class="button-group text-center">
                <button class="btn waves-effect waves-light btn-inverse" id="filter"> Chercher </button>

            </div>
        </div>
    </div>
</div>
@endif

@if( auth::user()->role_id == 4 )
<div class="">
    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter  text-white"></i></button>
</div>
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title text-center" style="font-weight : bold; font-size: 25px"> Filtrer <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">
            <div class="form-group" id="fl_nom">
                <label class="control-label ">Nom agence</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="nom" id="nom">

                </select>
            </div>
            <div class="button-group text-center">
                <button class="btn waves-effect waves-light btn-inverse" onclick="filter2()"> changer </button>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row" id="bodytab">

</div>


<div class="modal fade" id="exampleModal" tabindex="-1" rqt="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">

            <div class="modal-header" id="modalhead">
                <h4 class="modal-title">nouvelle réclamation </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body" id="modalbody">

                <!-- <div class="form-group text-center">
                    <h3 class="control-label"> nouvelle réclamation</h3>
                </div> -->

                <div id="pending_refs">

                </div>
                <br>
                <div class="form-group" id="err-produit_list">
                    <label class="control-label">Produits</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="false" name="produit_list" id="produit_list">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
                <div class="form-group" id="err-equip_list">
                    <label class="control-label">Equipements</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="false" name="equip_list" id="equip_list">

                    </select>
                    <small class="form-control-feedback"> </small>
                </div>
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

<!-- /.modal 2-->
<div class="modal fade bs-example-modal-sm" id="messagebox" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Message</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="content"> </div>
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

        '{{ auth::user()->role_id }}' == '4' || '{{ auth::user()->role_id }}' == '5' ? init2(): init();

    });

    function init() {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/dashboard/agence_dash",
            dataType: "json",
            type: "GET",
            data: {
                role_id: $('#logged_info').attr('value'),
                id: ' {{ auth::user()->id }} ',
                is_agence: 3
            },
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        // console.log(jsonData)
        $('#nom').html(" <option  value=\"0\"selected  >tout les client </option>")
        $('#email').html(" <option  value=\"0\"selected  >tout les client </option>")

        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            $('#nom').append("<option value=\"" + jsonData[ind].client.id + "\">" + jsonData[ind].client.nom + "</option>");
            $('#email').append("<option value=\"" + jsonData[ind].client.id + "\">" + jsonData[ind].client.email + "</option>");
            agence = "";

            for (let j = 0; j < jsonData[ind].agences.length; j++) {
                var nb = 0;
                refs = "";
                var color_agence = "color:#1d643b;background-color:#96f1bc";


                for (let k = 0; k < jsonData[ind].agences[j].reclamations.length; k++) {
                    var ref_color;

                    if (jsonData[ind].agences[j].reclamations[k].etat_id == 1) {
                        nb++;
                        ref_color = "danger";
                    } else {
                        ref_color = "warning";
                    }
                    refs = refs +
                        "<div class=\"col-12\">" +
                        "<div class=\"ribbon-wrapper-reverse card\">" +
                        "<div class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\">Ref : " + jsonData[ind].agences[j].reclamations[k].reclamation_ref + "</div>" +
                        "<h4><b>Etat : </b> " + jsonData[ind].agences[j].reclamations[k].etat + "</h4>" +
                        "<h4><b>Date : </b> " + jsonData[ind].agences[j].reclamations[k].created_at + "</h4>" +
                        "<div class=\"button-group text-right\">" +
                        "<a href=\"/dashboard/reclamations/detail/ref/" + jsonData[ind].agences[j].reclamations[k].reclamation_ref + "\" class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\">Détails</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }

                //   // console.log(jsonData[ind].agences[j].reclamations.length);

                if (jsonData[ind].agences[j].reclamations.length > 0) {
                    if (nb == 0) {
                        color_agence = "color:#857b26;background-color:#fff8b3";
                    } else {
                        color_agence = "color:#761b18;background-color:#f4b0af";
                    }
                }

                agence = agence +
                    "<div class=\"card\">" +
                    "<div style=\"" + color_agence + "\" class=\"card-header\" role=\"tab\" id=\"headingOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<h5 class=\"mb-0\">" +
                    "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\" aria-expanded=\"false\" aria-controls=\"collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<span style=\"color : #455a64; float:left\">" + jsonData[ind].agences[j].agence.agence_nom + "</span> <span style=\"color : #455a64; float:right\">" + jsonData[ind].agences[j].reclamations.length + " réclamations</span>" +
                    "</a>" +
                    "</h5>" +
                    "</div>" +
                    "<div id=\"collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<div class=\"card-body\">" +
                    refs +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<br>";

            }
            $('#bodytab').append(" <div class=\"col-12\" id=\"card" + ind + "\">" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card\">" +
                "<div class=\"card \" style=\"color:#385d7a;background-color:#d6eeff\">" +
                "<div class=\"card-body\">" +
                "<h2 class=\"card-title text-center\"> <b> " + jsonData[ind].client.nom + "</b><hr></h2>" +
                "<h4 class=\"card-title\"><b> Email : </b> " + jsonData[ind].client.email + " </h4>" +
                "<h4 class=\"card-title\"><b> Tel : </b>  " + jsonData[ind].client.tel + "</h4>" +
                "<h4 class=\"card-title\"><b> Adresse : </b>" + jsonData[ind].client.adress + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \" id=\"agence\">" +
                "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                agence +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");




        }
        $('#nom').selectpicker('refresh');
        $('#email').selectpicker('refresh');
        $('#fl_email').hide()
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

    $('#filter').click(function() {

        // console.log(jsonData)

        form_data = new FormData();
        var id;

        $('#rd_nom').is(':checked') ? id = $('#nom').val() : id = $('#email').val()


        form_data.append("id", id);
        form_data.append("role_id",  $('#logged_info').attr('value'));
        form_data.append("is_agence",  3);


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/dashboard/filter_agence_dash",
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
        for (let ind = 0; ind < jsonData.length; ind++) {
            $('#nom').append("<option value=\"" + jsonData[ind].client.id + "\">" + jsonData[ind].client.nom + "</option>");
            $('#email').append("<option value=\"" + jsonData[ind].client.id + "\">" + jsonData[ind].client.email + "</option>");
            agence = "";

            for (let j = 0; j < jsonData[ind].agences.length; j++) {
                var nb = 0;
                refs = "";
                var color_agence = "color:#1d643b;background-color:#96f1bc";


                for (let k = 0; k < jsonData[ind].agences[j].reclamations.length; k++) {
                    var ref_color;

                    if (jsonData[ind].agences[j].reclamations[k].etat_id == 1) {
                        nb++;
                        ref_color = "danger";
                    } else {
                        ref_color = "warning";
                    }
                    refs = refs +
                        "<div class=\"col-12\">" +
                        "<div class=\"ribbon-wrapper-reverse card\">" +
                        "<div class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\">Ref : " + jsonData[ind].agences[j].reclamations[k].reclamation_ref + "</div>" +
                        "<h4><b>Etat : </b> " + jsonData[ind].agences[j].reclamations[k].etat + "</h4>" +
                        "<h4><b>Date : </b> " + jsonData[ind].agences[j].reclamations[k].created_at + "</h4>" +
                        "<div class=\"button-group text-right\">" +
                        "<a href=\"/dashboard/reclamations/detail/ref/" + jsonData[ind].agences[j].reclamations[k].reclamation_ref + "\" class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\">Détails</a>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }

                //   // console.log(jsonData[ind].agences[j].reclamations.length);

                if (jsonData[ind].agences[j].reclamations.length > 0) {
                    if (nb == 0) {
                        color_agence = "color:#857b26;background-color:#fff8b3";
                    } else {
                        color_agence = "color:#761b18;background-color:#f4b0af";
                    }
                }

                agence = agence +
                    "<div class=\"card\">" +
                    "<div style=\"" + color_agence + "\" class=\"card-header\" role=\"tab\" id=\"headingOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<h5 class=\"mb-0\">" +
                    "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\" aria-expanded=\"false\" aria-controls=\"collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<span style=\"color : #455a64; float:left\">" + jsonData[ind].agences[j].agence.agence_nom + "</span> <span style=\"color : #455a64; float:right\">" + jsonData[ind].agences[j].reclamations.length + " réclamations</span>" +
                    "</a>" +
                    "</h5>" +
                    "</div>" +
                    "<div id=\"collapseexaOne" + jsonData[ind].agences[j].agence.agence_id + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + jsonData[ind].agences[j].agence.agence_id + "\">" +
                    "<div class=\"card-body\">" +
                    refs +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "<br>";

            }
            $('#bodytab').append(" <div class=\"col-12\" id=\"card" + ind + "\">" +
                "<div class=\"card\">" +
                "<div class=\"card-body\">" +
                "<div id=\"slimtest2\">" +
                "<div class=\"row\">" +
                "<div class=\"col-md-6 \" id=\"card\">" +
                "<div class=\"card \" style=\"color:#385d7a;background-color:#d6eeff\">" +
                "<div class=\"card-body\">" +
                "<h2 class=\"card-title text-center\"> <b> " + jsonData[ind].client.nom + "</b><hr></h2>" +
                "<h4 class=\"card-title\"><b> Email : </b> " + jsonData[ind].client.email + " </h4>" +
                "<h4 class=\"card-title\"><b> Tel : </b>  " + jsonData[ind].client.tel + "</h4>" +
                "<h4 class=\"card-title\"><b> Adresse : </b>" + jsonData[ind].client.adress + "</h4>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<div class=\"col-lg-6 \" id=\"agence\">" +
                "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +
                agence +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");




        }

    });
    // dash_agence


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

    function init2() {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/dashboard/agence_dash",
            dataType: "json",
            type: "GET",
            data: {
                role_id: $('#logged_info').attr('value'),
                id: ' {{ auth::user()->id }} ',
                is_agence: 0
            },
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
         console.log(jsonData)
        $('#bodytab').html("");
        $('#nom').html("");

        for (let i = 0; i < jsonData[0].agences.length; i++) {
            if (i == 0) {
                $('#nom').append("<option  value=\"" + jsonData[0].agences[i].agence.agence_id + "\" selected >" + jsonData[0].agences[i].agence.agence_nom + "</option>");
            } else {
                $('#nom').append("<option  value=\"" + jsonData[0].agences[i].agence.agence_id + "\" >" + jsonData[0].agences[i].agence.agence_nom + "</option>");

            }
        }
        $('#nom').selectpicker('refresh');

        var counts = [];
        for (let j = 1; j < 4; j++) {
            counts[j] = 0;
            $('#refs_etat' + j).html("");
        }

        $('#bodytab').append(" <div class=\"col-12\" id=\"card" + 0 + "\">" +
            "<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-lg-12 \" id=\"agence\">" +
            "<span style=\"float:left; font-size: 20px; font-weight: bold\" id=\"agence_info\" value=\"" + jsonData[0].agences[0].agence.agence_id + "\" > " + jsonData[0].agences[0].agence.agence_nom + " </span>" +
            "<div class=\"row\">" +
            "<div class=\"col-lg-12\">" +
            "<div class=\"form-group\">" +
            "<button class=\"btn btn-primary float-right\" id=\"new_rec\"> + Ajouter une Réclamation</button><br><br>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +

            "<div class=\"card\">" +
            "<div style=\"color:#761b18;background-color:#f4b0af\" class=\"card-header\" role=\"tab\" id=\"headingOne1\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne1\" aria-expanded=\"false\" aria-controls=\"collapseexaOne1\">" +
            "<span style=\"color : #455a64; float:left\"> En cours </span> <span style=\"color : #455a64; float:right\" id=\"count_etat1\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne1\" class=\"collapse show\" role=\"tabpanel\" aria-labelledby=\"headingOne1\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat1\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "<div class=\"card\">" +
            "<div style=\"color:#857b26;background-color:#fff8b3\" class=\"card-header\" role=\"tab\" id=\"headingOne3\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne3\" aria-expanded=\"false\" aria-controls=\"collapseexaOne3\">" +
            "<span style=\"color : #455a64; float:left\"> En traitement </span> <span style=\"color : #455a64; float:right\" id=\"count_etat2\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne3\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne3\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat2\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "<div class=\"card\">" +
            "<div style=\"color:#385d7a;background-color:#d6eeff\" class=\"card-header\" role=\"tab\" id=\"headingOne2\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne2\" aria-expanded=\"false\" aria-controls=\"collapseexaOne2\">" +
            "<span style=\"color : #455a64; float:left\"> clôturé </span> <span style=\"color : #455a64; float:right\" id=\"count_etat3\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne2\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne2\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat3\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
        // $('#agence_info').attr('value', );
        // $('#agence_info').html();
        for (let k = 0; k < jsonData[0].agences[0].reclamations.length; k++) {
            var ref_color;

            if (jsonData[0].agences[0].reclamations[k].etat_id == 1) {
                //  nb++;
                ref_color = "danger";
            }

            if (jsonData[0].agences[0].reclamations[k].etat_id == 2) {
                ref_color = "warning";
            }
            if (jsonData[0].agences[0].reclamations[k].etat_id == '3') {
                ref_color = "info";
            }

            counts[parseInt("" + jsonData[0].agences[0].reclamations[k].etat_id)]++;
            $('#refs_etat' + jsonData[0].agences[0].reclamations[k].etat_id).append("<div class=\"col-6\">" +
                "<div class=\"ribbon-wrapper-reverse card\">" +
                "<div class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\">Ref : " + jsonData[0].agences[0].reclamations[k].reclamation_ref + "</div>" +
                "<h4><b>Produit : </b> " + jsonData[0].agences[0].reclamations[k].prod_nom + "</h4>" +
                "<h4><b>Anomalie : </b> " + jsonData[0].agences[0].reclamations[k].anomalie + "</h4>" +
                "<h4><b>Etat : </b> " + jsonData[0].agences[0].reclamations[k].etat + "</h4>" +
                "<h4><b>Date : </b> " + jsonData[0].agences[0].reclamations[k].created_at + "</h4>" +
                "<div class=\"button-group text-right\">" +
                "<a href=\"/dashboard/reclamations/detail/ref/" + jsonData[0].agences[0].reclamations[k].reclamation_ref + "\" class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\">Détails</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<br>");
            // console.log(parseInt("" + jsonData[0].agences[0].reclamations[k].etat_id))
            $('#count_etat' + jsonData[0].agences[0].reclamations[k].etat_id).html(counts[parseInt("" + jsonData[0].agences[0].reclamations[k].etat_id)] + " réclamations")
        }


        $('#new_rec').click(function() {
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/detail",
                dataType: "json",
                type: "GET",
                async: false,
            }).responseText;
            jsonData = JSON.parse(StringData);
            // console.log(jsonData);


            $('#produit_list').html(" <option  value=\"0\"selected disabled >selectioner un produit </option>");
            $('#equip_list').html(" <option  value=\"0\"selected disabled >selectioner un equipement </option>");
            $('#ref').html("<option value=\"0\"selected disabled >selectioner une référance </option>")
            $('#pending_refs').html("");
            $('#commentaire').val("");


            for (let ind = 0; ind < jsonData.souscription.produits.length; ind++) {
                $('#produit_list').append("<option value=\"" + jsonData.souscription.produits[ind].prod_id + "\">" + jsonData.souscription.produits[ind].prod_nom + "</option>");
            }

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/reclamation/anomalie/active_index",
                dataType: "json",
                type: "GET",
                async: false,
            }).responseText;
            jsonData = JSON.parse(StringData);
            //    console.log(jsonData);
            $('#anomalie').html(" <option  value=\"0\"selected disabled >selectioner une anomalie </option>")

            for (let ind = 0; ind < jsonData.length; ind++) {
                $('#anomalie').append("<option value=\"" + jsonData[ind].id + "\">" + jsonData[ind].value + "</option>");
            }
            $('#produit_list').selectpicker('refresh');
            $('#anomalie').selectpicker('refresh');
            $('#equip_list').selectpicker('refresh');
            $('#ref').selectpicker('refresh');
            $('#exampleModal').modal('show');
        });

    }

    function filter2() {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/dashboard/agence_dash",
            dataType: "json",
            type: "GET",
            data: {
                role_id: $('#logged_info').attr('value'),
                id: ' {{ auth::user()->id }} ',
                is_agence: 0
            },
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);

        $('#bodytab').html("");

        var counts = [];
        for (let j = 1; j < 4; j++) {
            counts[j] = 0;
            $('#refs_etat' + j).html("");
        }

        var select
        for (let i = 0; i < jsonData[0].agences.length; i++) {
            if (jsonData[0].agences[i].agence.agence_id == $("#nom").val()) {
                select = i;
                break;
            }
        }
        // console.log(select)

        $('#bodytab').append(" <div class=\"col-12\" id=\"card" + 0 + "\">" +
            "<div class=\"card\">" +
            "<div class=\"card-body\">" +
            "<div id=\"slimtest2\">" +
            "<div class=\"row\">" +
            "<div class=\"col-lg-12 \" id=\"agence\">" +
            "<span style=\"float:left; font-size: 20px; font-weight: bold\" id=\"agence_info\" value=\"" + jsonData[0].agences[select].agence.agence_id + "\" > " + jsonData[0].agences[select].agence.agence_nom + " </span>" +
            "<div class=\"row\">" +
            "<div class=\"col-lg-12\">" +
            "<div class=\"form-group\">" +
            "<button class=\"btn btn-primary float-right\" id=\"new_rec\"> + Ajouter une Réclamation</button><br><br>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<div id=\"accordionexample\" class=\"accordion\" role=\"tablist\" aria-multiselectable=\"true\">" +

            "<div class=\"card\">" +
            "<div style=\"color:#761b18;background-color:#f4b0af\" class=\"card-header\" role=\"tab\" id=\"headingOne1\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne1\" aria-expanded=\"false\" aria-controls=\"collapseexaOne1\">" +
            "<span style=\"color : #455a64; float:left\"> En cours </span> <span style=\"color : #455a64; float:right\" id=\"count_etat1\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne1\" class=\"collapse show\" role=\"tabpanel\" aria-labelledby=\"headingOne1\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat1\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "<div class=\"card\">" +
            "<div style=\"color:#857b26;background-color:#fff8b3\" class=\"card-header\" role=\"tab\" id=\"headingOne3\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne3\" aria-expanded=\"false\" aria-controls=\"collapseexaOne3\">" +
            "<span style=\"color : #455a64; float:left\"> En traitement </span> <span style=\"color : #455a64; float:right\" id=\"count_etat2\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne3\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne3\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat2\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "<div class=\"card\">" +
            "<div style=\"color:#385d7a;background-color:#d6eeff\" class=\"card-header\" role=\"tab\" id=\"headingOne2\">" +
            "<h5 class=\"mb-0\">" +
            "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne2\" aria-expanded=\"false\" aria-controls=\"collapseexaOne2\">" +
            "<span style=\"color : #455a64; float:left\"> clôturé </span> <span style=\"color : #455a64; float:right\" id=\"count_etat3\"> 0 réclamations </span>" +
            "</a>" +
            "</h5>" +
            "</div>" +
            "<div id=\"collapseexaOne2\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne2\">" +
            "<div class=\"card-body\" >" +
            "<div class=\"row\" id=\"refs_etat3\">" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "<br>" +

            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
        // $('#agence_info').attr('value', );
        // $('#agence_info').html();
        for (let k = 0; k < jsonData[0].agences[select].reclamations.length; k++) {
            var ref_color;

            if (jsonData[0].agences[select].reclamations[k].etat_id == 1) {
                //  nb++;
                ref_color = "danger";
            }

            if (jsonData[0].agences[select].reclamations[k].etat_id == 2) {
                ref_color = "warning";
            }
            if (jsonData[0].agences[select].reclamations[k].etat_id == '3') {
                ref_color = "info";
            }

            counts[parseInt("" + jsonData[0].agences[select].reclamations[k].etat_id)]++;
            $('#refs_etat' + jsonData[0].agences[select].reclamations[k].etat_id).append("<div class=\"col-6\">" +
                "<div class=\"ribbon-wrapper-reverse card\">" +
                "<div class=\"ribbon ribbon-bookmark ribbon-left ribbon-" + ref_color + "\">Ref : " + jsonData[0].agences[select].reclamations[k].reclamation_ref + "</div>" +
                "<h4><b>Produit : </b> " + jsonData[0].agences[select].reclamations[k].prod_nom + "</h4>" +
                "<h4><b>Anomalie : </b> " + jsonData[0].agences[select].reclamations[k].anomalie + "</h4>" +
                "<h4><b>Etat : </b> " + jsonData[0].agences[select].reclamations[k].etat + "</h4>" +
                "<h4><b>Date : </b> " + jsonData[0].agences[select].reclamations[k].created_at + "</h4>" +
                "<div class=\"button-group text-right\">" +
                "<a href=\"/dashboard/reclamations/detail/ref/" + jsonData[0].agences[select].reclamations[k].reclamation_ref + "\" class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\">Détails</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<br>");
            // console.log(parseInt("" + jsonData[0].agences[select].reclamations[k].etat_id))
            $('#count_etat' + jsonData[0].agences[select].reclamations[k].etat_id).html(counts[parseInt("" + jsonData[0].agences[select].reclamations[k].etat_id)] + " réclamations")
        }


        $('#new_rec').click(function() {
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/detail",
                dataType: "json",
                type: "GET",
                async: false,
            }).responseText;
            jsonData = JSON.parse(StringData);
            // console.log(jsonData);


            $('#produit_list').html(" <option  value=\"0\"selected disabled >selectioner un produit </option>");
            $('#equip_list').html(" <option  value=\"0\"selected disabled >selectioner un equipement </option>");
            $('#ref').html("<option value=\"0\"selected disabled >selectioner une référance </option>")
            $('#pending_refs').html("");
            $('#commentaire').val("");


            for (let ind = 0; ind < jsonData.souscription.produits.length; ind++) {
                $('#produit_list').append("<option value=\"" + jsonData.souscription.produits[ind].prod_id + "\">" + jsonData.souscription.produits[ind].prod_nom + "</option>");
            }

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/reclamation/anomalie/active_index",
                dataType: "json",
                type: "GET",
                async: false,
            }).responseText;
            jsonData = JSON.parse(StringData);
            //    console.log(jsonData);
            $('#anomalie').html(" <option  value=\"0\"selected disabled >selectioner une anomalie </option>")

            for (let ind = 0; ind < jsonData.length; ind++) {
                $('#anomalie').append("<option value=\"" + jsonData[ind].id + "\">" + jsonData[ind].value + "</option>");
            }
            $('#produit_list').selectpicker('refresh');
            $('#anomalie').selectpicker('refresh');
            $('#equip_list').selectpicker('refresh');
            $('#ref').selectpicker('refresh');
            $('#exampleModal').modal('show');
        });

    }

    $('#produit_list').change(function() {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/get_equipements/" + $('#produit_list').val(),
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;
        jsonData = JSON.parse(StringData);
        var role_id = $('#logged_info').attr('value');
        $('#equip_list').html(" <option  value=\"0\"selected disabled >selectioner un equipement </option>");
        for (let ind = 0; ind < jsonData.equipements.length; ind++) {
            $('#equip_list').append("<option value=\"" + jsonData.equipements[ind].equip_id + "\">" + jsonData.equipements[ind].nom + "</option>");
        }
        $('#equip_list').selectpicker('refresh');
    });

    $('#produit_list').change(function() {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/get_equipements/" + $('#produit_list').val(),
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;
        jsonData = JSON.parse(StringData);
        var role_id = $('#logged_info').attr('value');
        $('#equip_list').html(" <option  value=\"0\"selected disabled >selectioner un equipement </option>");
        for (let ind = 0; ind < jsonData.equipements.length; ind++) {
            $('#equip_list').append("<option value=\"" + jsonData.equipements[ind].equip_id + "\">" + jsonData.equipements[ind].nom + "</option>");
        }
        $('#equip_list').selectpicker('refresh');
    });

    $('#equip_list').change(function() {
        $('#ref').html("<option value=\"0\"selected disabled >selectioner une référance </option>")
        var inputs = {
            "id_p": $('#produit_list').val(),
            "id_e": $('#equip_list').val()
        };
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/get_refs",
            dataType: "json",
            type: "GET",
            data: inputs,
            async: false
        }).responseText;
        jsonData = JSON.parse(StringData);
        //console.log(jsonData)
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
    });

    $('#save').click(function() {

        var inputs = {
            "ref": $('#ref').val(),
            "anomalie": $('#anomalie').val(),
            "commentaire": $('#commentaire').val()

        };

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/espace-client/agence/" + $('#agence_info').attr('value') + "/reclamer",
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
            location.reload(true);
        } else {
            clearInputs(jsonData.inputs);
            printErrorMsg(jsonData.error);
        }
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