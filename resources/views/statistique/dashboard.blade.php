@extends('layouts.appback')
@section('refresh')
<!-- <meta http-equiv="refresh" content="5"/> -->
endsection
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
<div class="row" id="bodytab">

</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        init()

    });

    function init() {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/dashboard/agence_dash",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
    //    console.log(jsonData)
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            agence = "";

            for (let j = 0; j < jsonData[ind].agences.length; j++) {
                var nb = 0;
                refs = "";
                var color_agence = "color:#1d643b;background-color:#96f1bc";


                for (let k = 0; k < jsonData[ind].agences[j].reclamations.length; k++) {
                    var ref_color ;
                    
                    if(jsonData[ind].agences[j].reclamations[k].etat_id == 1){
                        nb++;
                        ref_color = "danger";
                    }else{
                        ref_color = "warning";
                    }
                    refs = refs +
                        "<div class=\"col-12\">" +
                        "<div class=\"ribbon-wrapper-reverse card\">" +
                        "<div class=\"ribbon ribbon-bookmark ribbon-left ribbon-"+ref_color+"\">Ref : "+ jsonData[ind].agences[j].reclamations[k].reclamation_ref +"</div>" +
                        "<h4><b>Etat : </b> "+ jsonData[ind].agences[j].reclamations[k].etat +"</h4>" +
                        "<h4><b>Date : </b> "+ jsonData[ind].agences[j].reclamations[k].created_at +"</h4>" +
                        "<div class=\"button-group text-right\">" +
                        "<button class=\"btn waves-effect waves-light btn-inverse\" style=\"margin-right: 10px\">Détails</button>" +
                        "</div>" +
                        "</div>" +
                        "</div>";

                }

             //   console.log(jsonData[ind].agences[j].reclamations.length);
                
               if(jsonData[ind].agences[j].reclamations.length > 0){
                   if(nb == 0){
                    color_agence = "color:#857b26;background-color:#fff8b3";
                   }else{
                    color_agence = "color:#761b18;background-color:#f4b0af";
                   }
               }

                agence = agence +
                    "<div class=\"card\">" +
                    "<div style=\""+color_agence+"\" class=\"card-header\" role=\"tab\" id=\"headingOne"+jsonData[ind].agences[j].agence.agence_id+"\">" +
                    "<h5 class=\"mb-0\">" +
                    "<a data-toggle=\"collapse\" data-parent=\"#accordionexample\" href=\"#collapseexaOne"+jsonData[ind].agences[j].agence.agence_id+"\" aria-expanded=\"false\" aria-controls=\"collapseexaOne"+jsonData[ind].agences[j].agence.agence_id+"\">" +
                    "<span style=\"color : #455a64; float:left\">"+jsonData[ind].agences[j].agence.agence_nom+"</span> <span style=\"color : #455a64; float:right\">"+jsonData[ind].agences[j].reclamations.length+" réclamations</span>" +
                    "</a>" +
                    "</h5>" +
                    "</div>" +
                    "<div id=\"collapseexaOne"+jsonData[ind].agences[j].agence.agence_id+"\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne"+jsonData[ind].agences[j].agence.agence_id+"\">" +
                    "<div class=\"card-body\">" +
                    refs+
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
    }
</script>
@endsection