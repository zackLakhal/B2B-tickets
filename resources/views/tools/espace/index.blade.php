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
                <div class="table-responsive m-t-40">
                    <table id="myTable" class=" text-center  table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Agence</th>
                                <th>Ville</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id='bodytab'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Agence</th>
                                <th>Ville</th>
                                <th>Adresse</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>


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
    // function message(objet,action,statut){
    //     var message;
    //     if (statut == "done") {
    //         message = "votre "+objet+" est "+action+" avec succès";
    //     } else {
    //         message = "votre "+objet+" n'est pas "+action;
    //     }
    //     $('#content').html(message);
    //     $('#messagebox').modal('show');

    // }
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
        for (let ind = 0; ind < jsonData.agences.length; ind++) {

            $('#bodytab').append("<tr id=\"row" + ind + "\">" +
                "<th >" + jsonData.agences[ind].nom + "</th>" +
                "<th >" + jsonData.villes[ind].nom + "</th>" +
                " <th id=\"value" + ind + "\">" + jsonData.agences[ind].adress + "</th>" +
                "<td>" +
                "<a href=\"/outils/espace-client/agence/"+jsonData.agences[ind].id+"\" class=\"btn btn-primary\" >Details</a>" +
                "</td>" +
                "</tr>");
        }
    }
</script>
@endsection