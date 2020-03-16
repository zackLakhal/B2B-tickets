@extends('layouts.appback')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Gérer staff client</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Utilisateurs</li>
            <li class="breadcrumb-item active">Gérer staff client</li>
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
                        <i class="fa fa-plus"></i> ajouter un nouveau Staff-Client
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="bodytab" class="row el-element-overlay">


</div>

<div class="modal fade" id="exampleModal" tabindex="-1" rqt="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" rqt="document">
        <div class="modal-content">
            <div class="modal-header" id="modalhead">

            </div>
            <div class="modal-body " id="modalbody">

                <div class="form-group">
                    <label for="email" class="control-label"><b>email:</b></label>
                    <input type="text" class="form-control" id="email" name="email">
                </div>
                <div class="form-group" id="password_div">
                    <label for="password" class="control-label"><b>mot de passe:</b></label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label class="control-label">Role</label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="role" id="role">

                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">travail pour </label>
                    <select class="form-control custom-select selectpicker  has-success" data-live-search="true" name="created_by" id="created_by">

                    </select>
                </div>
                <div class="form-group">
                    <label for="nom" class="control-label"><b>nom:</b></label>
                    <input type="text" class="form-control" id="nom" name="nom">
                </div>
                <div class="form-group">
                    <label for="prenom" class="control-label"><b>prénom:</b></label>
                    <input type="text" class="form-control" id="prenom" name="prenom">
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
        var affectation;
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-client/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
         
        $('#bodytab').html("");
        for (let ind = 0; ind < jsonData.users.length; ind++) {
            if (jsonData.users[ind].deleted_at == null) {
                buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
            } else {
                buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
            }
            if (jsonData.users[ind].is_affected) {
                affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:green;\" value=\"" + jsonData.users[ind].is_affected + "\">état : affecté</a>";
            } else {
                affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:red;\" value=\"" + jsonData.users[ind].is_affected + "\">état : non affecté</a>";
            }

            $('#bodytab').append("<div class=\"col-lg-4 col-md-6\" id=\"card" + ind + "\">" +
                "<div class=\"card\" >" +
                "<div class=\"el-card-item\">" +
                "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.users[ind].photo + "\" alt=\"user\" />" +
                "<div class=\"el-overlay scrl-up\">" +
                "<ul class=\"el-info\">" +
                "<li><a class=\"btn default btn-warning\" onclick=\"modifier(" + jsonData.users[ind].id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                buttonacive +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.users[ind].nom + " " + jsonData.users[ind].prénom + "</h3>" +
                "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                "<h4 class=\"mb-0\">" +
                "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                "Informations" +
                "</a>" +
                "</h4>" +
                "</div>" +
                "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.users[ind].email + "</a>" +
                "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.users[ind].tel + "</a>" +
                "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.users[ind].adress + "</a>" +
                "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.roles[ind].id + "\">" + jsonData.roles[ind].value + "</a>" +
                "<a class=\"list-group-item\" id=\"created_by" + ind + "\" value=\"" + jsonData.clients[ind].id + "\"> travail chez : " + jsonData.clients[ind].nom + "</a>" +
                affectation +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        }

        $('#role').html(" <option  value=\"0\"selected disabled >selectioner un role </option>")
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/system/role/active_index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);
         
        for (let ind = 0; ind < jsonData1.length; ind++) {
            $('#role').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].value + "</option>");
        }
        $('#role').selectpicker('refresh');

        $('#created_by').html(" <option  value=\"0\"selected disabled >selectioner un client </option>")
        var StringData1 = $.ajax({
            url: "http://127.0.0.1:8000/outils/clients/active_index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData1 = JSON.parse(StringData1);
         
        for (let ind = 0; ind < jsonData1.length; ind++) {
            $('#created_by').append("<option value=\"" + jsonData1[ind].id + "\">" + jsonData1[ind].nom + "</option>");
        }
        $('#created_by').selectpicker('refresh');


    }

    $('#newmodal').click(function() {
        $('#modalhead').html("<h4 class=\"modal-title\" >Nouveau staff-client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"save\">Enregistrer</button>");

        $('#role').val("");
        $('#role').selectpicker('refresh');
        $('#created_by').val("");
        $('#created_by').selectpicker('refresh');
        $('#nom').val("");
        $('#email').val("");
        $('#tel').val("");
        $('#adress').val("");
        $('#password_div').show();
        $('#password').val("");
        $('#exampleModal').modal('show');
        $('#save').click(function() {

            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("role", $('#role').val());
            form_data.append("created_by", $('#created_by').val());
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());
            form_data.append("password", $('#password').val());

            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-client/create",
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
            if (jsonData.user.deleted_at == null) {
                buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-trash\"></i></a></li>";
            } else {
                buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-reload\"></i></a></li>"
            }
            if (jsonData.user.is_affected) {
                affectation = "<a class=\"list-group-item\" id=\"affected" + jsonData.count + "\" style=\"color:green;\" value=\"" + jsonData.user.is_affected + "\">état : affecté</a>";
            } else {
                affectation = "<a class=\"list-group-item\" id=\"affected" + jsonData.count + "\" style=\"color:red;\" value=\"" + jsonData.user.is_affected + "\">état : non affecté</a>";
            }
            $('#bodytab').append("<div class=\"col-lg-4 col-md-6\" id=\"card" + jsonData.count + "\">" +
                "<div class=\"card\" >" +
                "<div class=\"el-card-item\">" +
                "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + jsonData.count + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
                "<div class=\"el-overlay scrl-up\">" +
                "<ul class=\"el-info\">" +
                "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + jsonData.count + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                buttonacive +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + jsonData.count + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
                "<div id=\"accordion" + jsonData.count + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + jsonData.count + "\">" +
                "<h4 class=\"mb-0\">" +
                "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + jsonData.count + "\" href=\"#collapseOne" + jsonData.count + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + jsonData.count + "\">" +
                "Informations" +
                "</a>" +
                "</h4>" +
                "</div>" +
                "<div id=\"collapseOne" + jsonData.count + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + jsonData.count + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"id=\"email" + jsonData.count + "\">" + jsonData.user.email + "</a>" +
                "<a class=\"list-group-item\" id=\"tel" + jsonData.count + "\">" + jsonData.user.tel + "</a>" +
                "<a class=\"list-group-item\" id=\"adress" + jsonData.count + "\">" + jsonData.user.adress + "</a>" +
                "<a class=\"list-group-item\" id=\"role" + jsonData.count + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
                "<a class=\"list-group-item\" id=\"created_by" + jsonData.count + "\" value=\"" + jsonData.client.id + "\"> travail chez : " + jsonData.client.nom + "</a>" +
                affectation +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        });
    });

    function supprimer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-client/delete/" + id,
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
         
        if (jsonData.user.deleted_at == null) {
            buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
        } else {
            buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
        }
        if (jsonData.user.is_affected) {
            affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:green;\" value=\"" + jsonData.user.is_affected + "\">état : affecté</a>";
        } else {
            affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:red;\" value=\"" + jsonData.user.is_affected + "\">état : non affecté</a>";
        }
        $('#card' + ind).html("<div class=\"card\" >" +
            "<div class=\"el-card-item\">" +
            "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
            "<div class=\"el-overlay scrl-up\">" +
            "<ul class=\"el-info\">" +
            "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
            buttonacive +
            "</ul>" +
            "</div>" +
            "</div>" +
            "<div class=\"el-card-content\">" +
            "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
            "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
            "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
            "<h4 class=\"mb-0\">" +
            "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
            "Informations" +
            "</a>" +
            "</h4>" +
            "</div>" +
            "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"list-group\">" +
            "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
            "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
            "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
            "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
            "<a class=\"list-group-item\" id=\"created_by" + ind + "\" value=\"" + jsonData.client.id + "\"> travail chez : " + jsonData.client.nom + "</a>" +
            affectation +
            "</div>" +
            "<div class=\"button-group text-center\">" +
            "<br>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function restorer(id, ind) {
        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/utilisateur/staff-client/restore/" + id,
            dataType: "json",
            async: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            processData: false,
            contentType: false
        }).responseText;

        jsonData = JSON.parse(StringData);
         
        if (jsonData.user.deleted_at == null) {
            buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
        } else {
            buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
        }
        if (jsonData.user.is_affected) {
            affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:green;\" value=\"" + jsonData.user.is_affected + "\">état : affecté</a>";
        } else {
            affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:red;\" value=\"" + jsonData.user.is_affected + "\">état : non affecté</a>";
        }
        $('#card' + ind).html("<div class=\"card\" >" +
            "<div class=\"el-card-item\">" +
            "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
            "<div class=\"el-overlay scrl-up\">" +
            "<ul class=\"el-info\">" +
            "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
            buttonacive +
            "</ul>" +
            "</div>" +
            "</div>" +
            "<div class=\"el-card-content\">" +
            "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
            "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
            "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
            "<h4 class=\"mb-0\">" +
            "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
            "Informations" +
            "</a>" +
            "</h4>" +
            "</div>" +
            "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
            "<div class=\"card-body\">" +
            "<div class=\"list-group\">" +
            "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
            "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
            "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
            "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
            "<a class=\"list-group-item\" id=\"created_by" + ind + "\" value=\"" + jsonData.client.id + "\"> travail chez : " + jsonData.client.nom + "</a>" +
            affectation +
            "</div>" +
            "<div class=\"button-group text-center\">" +
            "<br>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>");
    }

    function modifier(id, ind) {

        $('#modalhead').html("<h4 class=\"modal-title\" >Modifier staff-client</h4>" +
            "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>");
        $('#modalfooter').html("<button type=\"button\" class=\"btn btn-info\" id=\"edit\">Enregistrer</button>");

        $('#pic_id').html("<label for=\"avatar\">avatar</label>" +
            "<input type=\"file\" id=\"avatar\" name=\"avatar\" class=\"dropify\" data-default-file=\"" + $('#avatar' + ind).attr('src') + "\"  />");
        $('.dropify').dropify();

        var full_name = $('#full_name' + ind).html().split(" ");
        $('#nom').val(full_name[0]);
        $('#prenom').val(full_name[1]);
        $('#email').val($('#email' + ind).html());
        $('#tel').val($('#tel' + ind).html());
        $('#adress').val($('#adress' + ind).html());
        $('#password_div').hide();
        $('#role').val($('#role' + ind).attr('value'));
        $('#role').selectpicker('refresh');
        $('#created_by').val($('#created_by' + ind).attr('value'));
        $('#created_by').selectpicker('refresh');
        $('#exampleModal').modal('show');
        $('#edit').click(function() {

            form_data = new FormData();

            form_data.append("avatar", $('#avatar')[0].files[0]);
            form_data.append("role", $('#role').val());
            form_data.append("created_by", $('#created_by').val());
            form_data.append("nom", $('#nom').val());
            form_data.append("prenom", $('#prenom').val());
            form_data.append("email", $('#email').val());
            form_data.append("tel", $('#tel').val());
            form_data.append("adress", $('#adress').val());


            var StringData = $.ajax({
                url: "http://127.0.0.1:8000/utilisateur/staff-client/edit/" + id,
                dataType: "json",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: form_data,
                processData: false,
                contentType: false
            }).responseText;
            jsonData = JSON.parse(StringData);
             
            $('#exampleModal').modal('hide');
            if (jsonData.user.deleted_at == null) {
                buttonacive = "<li><a class=\"btn default btn-danger\"  onclick=\"supprimer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-trash\"></i></a></li>";
            } else {
                buttonacive = "<li><a class=\"btn default btn-success\"  onclick=\"restorer(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-reload\"></i></a></li>"
            }
            if (jsonData.user.is_affected) {
                affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:green;\" value=\"" + jsonData.user.is_affected + "\">état : affecté</a>";
            } else {
                affectation = "<a class=\"list-group-item\" id=\"affected" + ind + "\" style=\"color:red;\" value=\"" + jsonData.user.is_affected + "\">état : non affecté</a>";
            }
            $('#card' + ind).html("<div class=\"card\" >" +
                "<div class=\"el-card-item\">" +
                "<div class=\"el-card-avatar el-overlay-1\"> <img id=\"avatar" + ind + "\" src=\"{{ asset('storage') }}/" + jsonData.user.photo + "\" alt=\"user\" />" +
                "<div class=\"el-overlay scrl-up\">" +
                "<ul class=\"el-info\">" +
                "<li><a class=\"btn default btn-warning\"  onclick=\"modifier(" + jsonData.user.id + "," + ind + ")\"><i class=\"icon-wrench\"></i></a></li>" +
                buttonacive +
                "</ul>" +
                "</div>" +
                "</div>" +
                "<div class=\"el-card-content\">" +
                "<h3 class=\"box-title\" id=\"full_name" + ind + "\">" + jsonData.user.nom + " " + jsonData.user.prénom + "</h3>" +
                "<div id=\"accordion" + ind + "\" role=\"tablist\" class=\"minimal-faq\" aria-multiselectable=\"true\">" +
                "<div class=\"card-header\" role=\"tab\" id=\"headingOne" + ind + "\">" +
                "<h4 class=\"mb-0\">" +
                "<a class=\"btn waves-effect waves-light btn-primary\" style=\"color:white\" data-toggle=\"collapse\" data-parent=\"#accordion" + ind + "\" href=\"#collapseOne" + ind + "\" aria-expanded=\"false\" aria-controls=\"collapseOne" + ind + "\">" +
                "Informations" +
                "</a>" +
                "</h4>" +
                "</div>" +
                "<div id=\"collapseOne" + ind + "\" class=\"collapse\" role=\"tabpanel\" aria-labelledby=\"headingOne" + ind + "\">" +
                "<div class=\"card-body\">" +
                "<div class=\"list-group\">" +
                "<a class=\"list-group-item \"id=\"email" + ind + "\">" + jsonData.user.email + "</a>" +
                "<a class=\"list-group-item\" id=\"tel" + ind + "\">" + jsonData.user.tel + "</a>" +
                "<a class=\"list-group-item\" id=\"adress" + ind + "\">" + jsonData.user.adress + "</a>" +
                "<a class=\"list-group-item\" id=\"role" + ind + "\" value=\"" + jsonData.role.id + "\">" + jsonData.role.value + "</a>" +
                "<a class=\"list-group-item\" id=\"created_by" + ind + "\" value=\"" + jsonData.client.id + "\"> travail chez : " + jsonData.client.nom + "</a>" +
                affectation +
                "</div>" +
                "<div class=\"button-group text-center\">" +
                "<br>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");

        });
    }
</script>
@endsection