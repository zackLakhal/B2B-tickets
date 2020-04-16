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
<div class="row" id="bodytab">



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
                "<p class=\"card-text\">" + jsonData[ind].message + "</p>" +
                "<button  class=\"btn btn-warning\" style=\"margin-right: 10px\" onclick=\"detail(" + jsonData[ind].id + "," + ind + ")\">détail</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>");
        }
    }

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
</script>
@endsection