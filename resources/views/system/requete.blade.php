@extends('layouts.appback')

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer les requests</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Système</li>
            <li class="breadcrumb-item active">Gérer les requests</li>
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
<div class="">
    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-filter  text-white"></i></button>
</div>

<div class="row" id="bodytab">

</div>
<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title text-center" style="font-weight : bold; font-size: 25px"> Filtrer <span><i class="ti-close right-side-toggle"></i></span> </div>
        <div class="r-panel-body">

            <div class="demo-radio-button">
                <input name="group1" type="radio" id="rd_ref" onclick="check(this)" checked />
                <label for="rd_ref">Par référence</label>
                <input name="group1" type="radio" id="rd_email" onclick="check(this)" />
                <label for="rd_email">Par email</label>

            </div>
            <div class="form-group" id="fl_ref">
                <label class="control-label ">référence</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_ref" id="fv_ref">

                </select>
            </div>
            <div class="form-group" id="fl_email">
                <label class="control-label ">Email de la demande</label>
                <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="fv_email" id="fv_email">

                </select>
            </div>
            <div class="col-md-12">
                <h4 class="card-title text-center">année</h4>
                <div id="year"></div>
            </div>
            <br>
            <div class="col-md-12">
                <h4 class="card-title text-center">mois</h4>
                <div id="mois"></div>
            </div>
            <br>
            <h4 class="card-title">Tout les demande</h4>
            <div class="col-md-12">
                <div class="switch">
                    <label>Non
                        <input id="fv_dr" type="checkbox" checked><span class="lever switch-col-light-green"></span>Oui</label>
                </div>
            </div>
            <br>
            <div class="demo-radio-button" id="dr_group">
                <input name="treated" type="radio" id="pending" value="false" checked />
                <label for="pending">en attente</label>
                <input name="treated" type="radio" id="treated" value="true" />
                <label for="treated">traité</label>
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
            <div class="modal-body text-center" id="modalbody">




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

    function init() {

        var buttonacive;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/system/request/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        $('#bodytab').html("");

        $('#fv_ref').html(" <option  value=\"0\"selected  >tout les requetes </option>")
        $('#fv_email').html(" <option  value=\"0\"selected  >tout les requetes </option>")
        for (let ind = 0; ind < jsonData.length; ind++) {

            $('#fv_ref').append("<option value=\"" + jsonData[ind].id + "\">" + jsonData[ind].ref + "</option>");
            $('#fv_email').append("<option value=\"" + jsonData[ind].id + "\">" + jsonData[ind].email + "</option>");


            if (jsonData[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData[ind].id + "," + ind + ")\">traiter</button>"
            } else {
                buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
            }
            $('#bodytab').append("<div class=\"col-md-4\" id=\"card" + ind + "\">" +

                "<div class=\"card text-center\">" +
                "<div class=\"card-body\">" +
                "<h3 class=\"card-title\"> Ref : <b> " + jsonData[ind].ref + "</b></h3> <hr>" +
                "<h4 class=\"card-title\">" + jsonData[ind].nom + "</h4>" +
                "<h4 class=\"card-title\">" + jsonData[ind].email + "</h4>" +
                "<h4 class=\"card-title\">" + jsonData[ind].tel + "</h4>" +
                "<h4 class=\"card-title\"> faite le : " + jsonData[ind].created_at + "</h4>" +
                "<p class=\"card-text\">" + jsonData[ind].message + "</p>" +
                "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData[ind].id + "," + ind + ")\">détail</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>");
        }
        $('#fv_ref').selectpicker('refresh');
        $('#fv_email').selectpicker('refresh');
        // $('#fv_dr').attr("checked", "");
        $('#fl_email').hide()
        $('#dr_group').hide()
        document.getElementsByTagName('fv_dr').checked = true;

        document.getElementsByTagName('rd_ref').checked = true;
    }

    $('#filter').click(function() {


        form_data = new FormData();
        var rqst_id;
        var is_treated;

        $('#rd_ref').is(':checked') ? rqst_id = $('#fv_ref').val() : rqst_id = $('#fv_email').val()
        $('#pending').is(':checked') ? is_treated = $('#pending').val() : is_treated = $('#treated').val()

        form_data.append("rqst_id", rqst_id);
        form_data.append("is_all", $('#fv_dr').is(':checked'));
        form_data.append("is_treated", is_treated);

        form_data.append("mois_from", $('#mois').data().from);
        form_data.append("mois_to", $('#mois').data().to);
        form_data.append("year_from", $('#year').data().from);
        form_data.append("year_to", $('#year').data().to);


        var buttonacive;

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/system/request/filter_index",
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

            if (jsonData[ind].deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData[ind].id + "," + ind + ")\">traiter</button>"
            } else {
                buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
            }
            $('#bodytab').append("<div class=\"col-md-4\" id=\"card" + ind + "\">" +

                "<div class=\"card text-center\">" +
                "<div class=\"card-body\">" +
                "<h3 class=\"card-title\"> Ref : <b> " + jsonData[ind].ref + "</b></h3> <hr>" +
                "<h4 class=\"card-title\">" + jsonData[ind].nom + "</h4>" +
                "<h4 class=\"card-title\">" + jsonData[ind].email + "</h4>" +
                "<h4 class=\"card-title\">" + jsonData[ind].tel + "</h4>" +
                "<h4 class=\"card-title\"> faite le : " + jsonData[ind].created_at + "</h4>" +
                "<p class=\"card-text\">" + jsonData[ind].message + "</p>" +
                "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData[ind].id + "," + ind + ")\">détail</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>");
        }
    });

    function traiter(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/system/request/traiter/" + id,
            dataType: "json",
            type: "GET",
            async: false
        }).responseText;

        jsonData = JSON.parse(StringData);

        $('#exampleModal').modal('hide');
        if (jsonData.rqt.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData.rqt.id + "," + ind + ")\">traiter</button>"
        } else {
            buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
        }
        $('#card' + ind).html("<div class=\"card text-center\">" +
            "<div class=\"card-body\">" +
            "<h3 class=\"card-title\"> Ref : <b> " + jsonData.ref + "</b></h3> <hr>" +
            "<h2 class=\"card-title\">" + jsonData.rqt.nom + "</h2>" +
            "<h4 class=\"card-title\">" + jsonData.rqt.email + "</h4>" +
            "<h4 class=\"card-title\">" + jsonData.rqt.tel + "</h4>" +
            "<h4 class=\"card-title\"> faite le : " + jsonData.rqt.created_at + "</h4>" +
            "<p class=\"card-text\">" + jsonData.rqt.message + "</p>" +
            "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData.rqt.id + "," + ind + ")\">détail</button>" +
            buttonacive +
            "</div>" +
            "</div>");
    }

    function detail(id, ind) {

        var buttonacive;



        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/system/request/detail/" + id,
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);

        $('#modalhead').html("<h3 class=\"modal-title\"> Ref : <b> " + jsonData.ref + "</b></h3> <hr>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");

        $('#modalbody').html(
            "<h2 class=\"card-title\">" + jsonData.nom + "</h2>" +
            "<h4 class=\"card-title\">" + jsonData.email + "</h4>" +
            "<h4 class=\"card-title\">" + jsonData.tel + "</h4>" +
            "<h4 class=\"card-title\">faite le : " + jsonData.created_at + "</h4>" +
            "<p class=\"card-text\">" + jsonData.message + "</p>"
        );

        if (jsonData.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-inverse\"  onclick=\"traiter(" + jsonData.id + "," + ind + ")\">traiter</button>"
        } else {
            buttonacive = " <a class=\"btn btn-secondary \" style=\"color:green\" type=\"button\"><span class=\"btn-label\" ><i class=\"fa fa-check\"></i></span>traité</a>"
        }

        $('#modalfooter').html(buttonacive);


        $('#exampleModal').modal('show');



    }

    function check(input) {

        if (input.id == 'rd_email') {
            $('#fl_ref').hide()
            $('#fl_email').show()
        } else {
            $('#fl_ref').show()
            $('#fl_email').hide()
        }
    }


    $('#fv_dr').on('change', function() {

        $(this).is(':checked') ? $('#dr_group').hide() : $('#dr_group').show()

    })
</script>
@endsection