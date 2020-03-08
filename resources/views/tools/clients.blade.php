@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer les clients</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Outils client</li>
            <li class="breadcrumb-item active">Gérer les clients</li>
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
                        <i class="fa fa-plus"></i> ajouter un nouveau client
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
                <div class="form-group">
                    <label for="adress" class="control-label"><b>adress:</b></label>
                    <input type="text" class="form-control" id="adress" name="adress">
                </div>

                <div class="form-group" id="pic_id">

                    <label for="avatar">avatar</label>
                    <input type="file" id="avatar" name="avatar" class="dropify" data-default-file="{{ asset('storage/avatars/placeholder.jpg') }}" />
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

    function init() {

        var buttonacive;
        var butttondetail;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.length; ind++) {
            if (jsonData[ind].deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + jsonData[ind].id + "/departements\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData[ind].id + "," + ind + ")\">supprimer</button>"
            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData[ind].id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#bodytab').append("<div class=\"col-md-4 m-t-30\" id=\"card" + ind + "\">" +
                "<div class=\"card \">" +
                "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData[ind].photo + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData[ind].nom + "</h2>" +
                "<h4 id=\"email" + ind + "\" class=\"card-title\">" + jsonData[ind].email + "</h4>" +
                "<h4 id=\"tel" + ind + "\" class=\"card-title\">" + jsonData[ind].tel + "</h4>" +
                "<p id=\"adress" + ind + "\" class=\"card-text\">" + jsonData[ind].adress + "</p>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData[ind].id + "," + ind + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }


    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#nom').val("");
        $('#email').val("");
        $('#tel').val("");
        $('#adress').val("");
        $('#exampleModal').modal('show');

        $('#save').click(function() {
            
            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("nom", $('#nom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
          
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/create",
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
             
            $('#exampleModal').modal('hide');
            if (jsonData.client.deleted_at == null) {
                butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + jsonData.count + ")\">supprimer</button>"

            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + jsonData.count + ")\">restorer</button>"
                butttondetail = "";
            }
            $('#bodytab').append("<div class=\"col-md-4 m-t-30\" id=\"card" + jsonData.count + "\">" +
                "<div class=\"card \">" +
                "<img class=\"card-img-top img-responsive\" id=\"avatar" + jsonData.count + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + jsonData.count + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
                "<h4 id=\"email" + jsonData.count + "\" class=\"card-title\">" + jsonData.client.email + "</h4>" +
                "<h4 id=\"tel" + jsonData.count + "\" class=\"card-title\">" + jsonData.client.tel + "</h4>" +
                "<p id=\"adress" + jsonData.count + "\" class=\"card-text\">" + jsonData.client.adress + "</p>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + jsonData.count + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        });
    });

    function supprimer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/delete/" + id,
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
         
        if (jsonData.client.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
            butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\">" + jsonData.client.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\">" + jsonData.client.tel + "</h4>" +
            "<p id=\"adress" + ind + "\" class=\"card-text\">" + jsonData.client.adress + "</p>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/restore/" + id,
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
         
        if (jsonData.client.deleted_at == null) {
            buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
            butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

        } else {
            buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
            butttondetail = ""
        }
        $('#card' + ind).html("<div class=\"card \">" +
            "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
            "<div class=\"card-body\">" +
            "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
            "<h4 id=\"email" + ind + "\" class=\"card-title\">" + jsonData.client.email + "</h4>" +
            "<h4 id=\"tel" + ind + "\" class=\"card-title\">" + jsonData.client.tel + "</h4>" +
            "<p id=\"adress" + ind + "\" class=\"card-text\">" + jsonData.client.adress + "</p>" +
            "<div class=\"button-group text-center\">" +
            butttondetail +
            "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" +
            buttonacive +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {

        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");
        
        $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"" + $('#avatar' + ind).attr('src') + "\"  />");
        $('.dropify').dropify();

        $('#nom').val($('#nom' + ind).html());
        $('#email').val($('#email' + ind).html());
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#exampleModal').modal('show');
        $('#edit').click(function() {
            form_data = new FormData();

form_data.append("avatar", $('#avatar')[0].files[0]);
form_data.append("nom", $('#nom').val());
form_data.append("email", $('#email').val());
form_data.append("tel", $('#tel').val());
form_data.append("adress", $('#adress').val());
           
            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/outils/clients/edit/" + id,
                dataType: "json",
                type: "GET",
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
             
            $('#exampleModal').modal('hide');
            if (jsonData.client.deleted_at == null) {
                buttonacive = "<button  class=\"btn btn-danger\"  onclick=\"supprimer(" + jsonData.client.id + "," + ind + ")\">supprimer</button>"
                butttondetail = "<a href=\"/outils/clients/" + jsonData.client.id + "/departements\" class=\"btn waves-effect waves-light btn-success \" color: white; style=\"margin-right: 10px\" >détails</a>";

            } else {
                buttonacive = "<button  class=\"btn btn-secondary\" \" onclick=\"restorer(" + jsonData.client.id + "," + ind + ")\">restorer</button>"
                butttondetail = ""
            }
            $('#card' + ind).html("<div class=\"card \">" +
                "<img class=\"card-img-top img-responsive\" id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.client.photo + "\" alt=\"Card image cap\">" +
                "<div class=\"card-body\">" +
                "<h2 id=\"nom" + ind + "\" class=\"card-title text-center\">" + jsonData.client.nom + "</h2>" +
                "<h4 id=\"email" + ind + "\" class=\"card-title\">" + jsonData.client.email + "</h4>" +
                "<h4 id=\"tel" + ind + "\" class=\"card-title\">" + jsonData.client.tel + "</h4>" +
                "<p id=\"adress" + ind + "\" class=\"card-text\">" + jsonData.client.adress + "</p>" +
                "<div class=\"button-group text-center\">" +
                butttondetail +
                "<button  class=\"btn waves-effect waves-light btn-warning\" style=\"margin-right: 10px\" onclick=\"modifier(" + jsonData.client.id + "," + ind + ")\">modifier</button>" +
                buttonacive +
                "</div>" +
                "</div>" +
                "</div>");

        });
    }
</script>
@endsection