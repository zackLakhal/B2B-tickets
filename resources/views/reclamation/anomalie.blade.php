@extends('layouts.appback')

@section('content')
<div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Gérer les anomalies</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item text-themecolor">Reclamations</li>
                            <li class="breadcrumb-item active">Gérer les anomalies</li>
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
                             <button type="button" class="btn btn-primary pull-right" id="newmodal"  >+ nouvelle anomalie </button>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class=" text-center  table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th >Anomalie-id</th>
                                            <th >value</th>
                                            <th >Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id='bodytab'>
                                             
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th >Anomalie-id</th>
                                            <th >value</th>
                                            <th >Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                           

                            </div>
                        </div>
                    </div>
                </div>
                 <!-- /.modal 1-->
                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" id="modalhead">
                                                
                                            </div>
                                            <div class="modal-body">
                                                
                                                    <div class="form-group">
                                                        <label for="value" class="control-label"><b>value:</b></label>
                                                        <input type="text" class="form-control" id="value" name="value" >
                                                    </div>
                                                    
                                                
                                            </div>
                                            <div class="modal-footer" id="modalfooter">
                                            <button type="button" class="btn btn-info" id="save">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <!-- /.modal 1 -->

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
$( document ).ready(function() {
    init()
    });
    function message(objet,action,statut){
        var message;
        if (statut == "done") {
            message = "votre "+objet+" est "+action+" avec succès";
        } else {
            message = "votre "+objet+" n'est pas "+action;
        }
        $('#content').html(message);
        $('#messagebox').modal('show');
       
    }
    function init(){

    var buttonacive;
    var StringData =  $.ajax({
                        url: "http://127.0.0.1:8000/reclamation/anomalie/index",
                        dataType: "json",
                        type: "GET",
                        async: false,
                    }).responseText;
                    jsonData = JSON.parse(StringData);
                    $('#bodytab').html("");
                    for (let ind = 0; ind < jsonData.length; ind++) {
                        if(jsonData[ind].deleted_at  != null){
                            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin: 10px\"  onclick=\"restor("+jsonData[ind].id+","+ind+")\">restorer</button>"
                        }else{
                            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin: 10px\" onclick=\"delet("+jsonData[ind].id+","+ind+")\">supprimer</button>"
                        }
                        $('#bodytab').append("<tr id=\"row"+ind+"\">"+
                                            "<th >"+jsonData[ind].id+"</th>"+
                                           " <td id=\"value"+ind+"\">"+jsonData[ind].value+"</td>"+
                                            "<td>" +
                                            "<button class=\"btn btn-success\" style=\"margin: 10px\">Details</button>"+
                                            "<button class=\"btn btn-warning\"style=\"margin: 10px\" onclick=\"edit("+jsonData[ind].id+","+ind+")\">modifier</button>"+
                                            buttonacive  +
                                            "</td>"+
                                            "</tr>");
                    }
    }
    $('#newmodal').click(function() {
             $('#modalhead').html("<h4 class=\"modal-title\" >Nouvelle anomalie</h4>"+
                                "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
             $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");
            $('#exampleModal').modal('show');

            $('#value').val("");
            $('#save').click(function(){
                var inputs = { 
                "value":$('#value').val()
            } ;
        var StringData =  $.ajax({
                        url: "http://127.0.0.1:8000/reclamation/anomalie/create",
                        dataType: "json",
                        type: "GET",
                        async: false,
                        data: inputs
                    }).responseText;
                    jsonData = JSON.parse(StringData);
                    $('#exampleModal').modal('hide');
                    message("anomalie","ajouté",jsonData.check);
                    if(jsonData.anomalie.deleted_at  != null){
                            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin: 10px\"  onclick=\"restor("+jsonData.anomalie.id+","+jsonData.count+")\">restorer</button>"
                        }else{
                            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin: 10px\" onclick=\"delet("+jsonData.anomalie.id+","+jsonData.count+")\">supprimer</button>"
                        }
                        $('#bodytab').append("<tr id=\"row"+jsonData.count+"\">"+
                                            "<th >"+jsonData.anomalie.id+"</th>"+
                                           " <td id=\"value"+jsonData.count+"\">"+jsonData.anomalie.value+"</td>"+
                                            "<td>" +
                                            "<button class=\"btn btn-success\" style=\"margin: 10px\">Details</button>"+
                                            "<button class=\"btn btn-warning\"style=\"margin: 10px\" onclick=\"edit("+jsonData.anomalie.id+","+jsonData.count+")\">modifier</button>"+
                                            buttonacive  +
                                            "</td>"+
                                            "</tr>");
                 });
            }
        );  
    function restor(id,ind) {
        var StringData =  $.ajax({
                        url: "http://127.0.0.1:8000/reclamation/anomalie/restore/"+id,
                        dataType: "json",
                        type: "GET",
                        async: false
                    }).responseText;
                   
                    jsonData = JSON.parse(StringData);
                    console.log(jsonData)
                    message("anomalie","activé",jsonData.check);
                    if(jsonData.anomalie.deleted_at  != null){
                            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin: 10px\"  onclick=\"restor("+jsonData.anomalie.id+","+ind+")\">restorer</button>"
                        }else{
                            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin: 10px\" onclick=\"delet("+jsonData.anomalie.id+","+ind+")\">supprimer</button>"
                        }
                        $('#row'+ind).html(
                                            "<th >"+jsonData.anomalie.id+"</th>"+
                                           " <td id=\"value"+ind+"\">"+jsonData.anomalie.value+"</td>"+
                                            "<td>" +
                                            "<button class=\"btn btn-success\" style=\"margin: 10px\">Details</button>"+
                                            "<button class=\"btn btn-warning\"style=\"margin: 10px\" onclick=\"edit("+jsonData.anomalie.id+","+ind+")\">modifier</button>"+
                                            buttonacive  +
                                            "</td>");
    }
    function delet(id,ind) {
        var StringData =  $.ajax({
                        url: "http://127.0.0.1:8000/reclamation/anomalie/delete/"+id,
                        dataType: "json",
                        type: "GET",
                        async: false
                    }).responseText;
                    
                    jsonData = JSON.parse(StringData);
                    console.log(jsonData)
                    message("anomalie","désactivé",jsonData.check);
                    if(jsonData.anomalie.deleted_at  != null){
                            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin: 10px\"  onclick=\"restor("+jsonData.anomalie.id+","+ind+")\">restorer</button>"
                        }else{
                            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin: 10px\" onclick=\"delet("+jsonData.anomalie.id+","+ind+")\">supprimer</button>"
                        }
                        $('#row'+ind).html(
                                            "<th >"+jsonData.anomalie.id+"</th>"+
                                           " <td id=\"value"+ind+"\">"+jsonData.anomalie.value+"</td>"+
                                            "<td>" +
                                            "<button class=\"btn btn-success\" style=\"margin: 10px\">Details</button>"+
                                            "<button class=\"btn btn-warning\"style=\"margin: 10px\" onclick=\"edit("+jsonData.anomalie.id+","+ind+")\">modifier</button>"+
                                            buttonacive  +
                                            "</td>");
    }
    function edit(id,ind) {
        
        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier anomalie</h4>"+
                                "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
             $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
            $('#value').val($('#value'+ind).html());
            $('#exampleModal').modal('show');
            $('#edit').click(function(){
                var inputs = { 
                "value":$('#value').val()
            } ;
        var StringData =  $.ajax({
                        url: "http://127.0.0.1:8000/reclamation/anomalie/edit/"+id,
                        dataType: "json",
                        type: "GET",
                        async: false,
                        data: inputs
                    }).responseText;
                    jsonData = JSON.parse(StringData);
                    console.log(jsonData)
                    $('#exampleModal').modal('hide');
                    message("anomalie","modifié",jsonData.check);
                    if(jsonData.anomalie.deleted_at  != null){
                            buttonacive = "<button  class=\"btn btn-secondary\" style=\"margin: 10px\"  onclick=\"restor("+jsonData.anomalie.id+","+ind+")\">restorer</button>"
                        }else{
                            buttonacive = "<button  class=\"btn btn-danger\" style=\"margin: 10px\" onclick=\"delet("+jsonData.anomalie.id+","+ind+")\">supprimer</button>"
                        }
                        $('#row'+ind).html(
                                            "<th >"+jsonData.anomalie.id+"</th>"+
                                           " <td id=\"value"+ind+"\">"+jsonData.anomalie.value+"</td>"+
                                            "<td>" +
                                            "<button class=\"btn btn-success\" style=\"margin: 10px\">Details</button>"+
                                            "<button class=\"btn btn-warning\"style=\"margin: 10px\" onclick=\"edit("+jsonData.anomalie.id+","+ind+")\">modifier</button>"+
                                            buttonacive  +
                                            "</td>");
                 });
    }
</script>
@endsection