@extends('layouts.appback')
@section('css')
<style>
    .left {
        display: block;
        float: left;
        width: 100px;
    }

    .right {
        display: block;
        float: right;
        width: 100px;
    }
</style>
@endsection
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor m-b-0 m-t-0">Home</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-themecolor"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item text-themecolor">Statistiques</li>
            <li class="breadcrumb-item active">Consulter les Statistiques</li>
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

<div class="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title text-center" style="font-weight : bold; font-size: 25px"> type statistique </div>
        <div class="r-panel-body">

            <div class="demo-radio-button">
                <input name="stat_group" type="radio" id="stat_client" onclick="check(this)" checked />
                <label for="stat_client">Par client</label>
                <input name="stat_group" type="radio" id="stat_reference" onclick="check(this)" />
                <label for="stat_reference">Par référence</label>
                <input name="stat_group" type="radio" id="stat_departement" onclick="check(this)" />
                <label for="stat_departement">Par departement</label>
                <input name="stat_group" type="radio" id="stat_agence" onclick="check(this)" />
                <label for="stat_agence">Par agence</label>
                <input name="stat_group" type="radio" id="stat_produit" onclick="check(this)" />
                <label for="stat_produit">Par produit</label>
                <input name="stat_group" type="radio" id="stat_equipement" onclick="check(this)" />
                <label for="stat_equipement">Par equipement</label>

            </div>

            <br>
            <div class="button-group text-center">
                <button class="btn waves-effect waves-light btn-inverse right-side-toggle"> fermer </button>

            </div>
        </div>
    </div>
</div>
<div id="link">

</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body wizard-content">
                <div id="filters" role="tablist" class="minimal-faq" aria-multiselectable="false">
                    <div class="card m-b-0">
                        <div class="card-header text-center" role="tab" id="filterOne">
                            <h5 class="mb-0">
                                <a id="stat_button" data-toggle="collapse" data-parent="#filters" href="#filterCollapseOne" aria-expanded="true" aria-controls="filterCollapseOne" style="font-size:24px">
                                    Filtrer les statistiques
                                </a>
                            </h5>
                        </div>
                        <div id="filterCollapseOne" class="collapse" role="tabpanel" aria-labelledby="filterOne">
                            <div class="card-body tab-wizard wizard-circle" id="tab-wizard-stat">
                                <h6>filtrer les Sources</h6><br>
                                <section>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="client_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_client').show() :  $('#fl_client').hide()" />
                                                <label for="client_check">filter par client</label>
                                            </div> -->
                                            <div class="form-group" id="fl_client">
                                                <label for="fv_client" class="control-label " style="font-weight: bold">choix client</label>
                                                <!-- <select class="form-control has-success" multiple size="2" name="fv_client" onchange="filter_data(this)" id="fv_client"> -->
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_client" id="fv_client" onchange="filter_data(this)">

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4" style="display: none;">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="departement_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_departement').show() :  $('#fl_departement').hide()" />
                                                <label for="departement_check">filter par département</label>
                                            </div> -->
                                            <div class="form-group" id="fl_departement">
                                                <label for="fv_departement" class="control-label " style="font-weight: bold">choix département</label>
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_departement" onchange="filter_data(this)" id="fv_departement">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="agence_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_agence').show() :  $('#fl_agence').hide()" />
                                                <label for="agence_check">filter par agence</label>
                                            </div> -->
                                            <div class="form-group" id="fl_agence">
                                                <label for="fv_agence" class="control-label " style="font-weight: bold">choix agence</label>
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_agence" onchange="filter_data(this)" id="fv_agence">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="produit_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_produit').show() :  $('#fl_produit').hide()" />
                                                <label for="produit_check">filter par produit</label>
                                            </div> -->
                                            <div class="form-group" id="fl_produit">
                                                <label for="fv_produit" class="control-label " style="font-weight: bold">choix produit</label>
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_produit" onchange="filter_data(this)" id="fv_produit">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="equipement_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_equipement').show() :  $('#fl_equipement').hide()" />
                                                <label for="equipement_check">filter par équipement</label>
                                            </div> -->
                                            <div class="form-group" id="fl_equipement">
                                                <label for="fv_equipement" class="control-label " style="font-weight: bold">choix équipement</label>
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_equipement" onchange="filter_data(this)" id="fv_equipement">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- <div class="form-group">
                                                <input type="checkbox" id="ref_equip_check" class="filled-in chk-col-orange" onclick="$(this).is(':checked') ? $('#fl_ref_equip').show() :  $('#fl_ref_equip').hide()" />
                                                <label for="ref_equip_check">filter par équipement ref</label>
                                            </div> -->
                                            <div class="form-group" id="fl_ref_equip">
                                                <label for="fv_ref_equip" class="control-label " style="font-weight: bold">choix équipement ref</label>
                                                <select class="select2 m-b-10 select2-multiple" style="width: 100%" multiple="multiple" data-placeholder="tout" name="fv_ref_equip" id="fv_ref_equip">

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </section>

                                <!-- Step 2-->
                                <h6> filtrer les dates</h6>
                                <section>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">


                                            <div id="fl_time">
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">année</h4>
                                                    <div id="time_year"></div>
                                                </div>

                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">mois</h4>
                                                    <div id="time_mois"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h4 class="card-title text-center">jour</h4>
                                                    <div id="time_day"></div>
                                                </div>
                                            </div>

                                        </div>

                                </section>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="tab_client">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR CLIENT</h1>
                </div>
                <table id="foo-client" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">client</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>

                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_client" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <button id="client_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</buttonutton>
                        </span>
                    </div>

                    <tbody id="body_client">


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL CLIENT</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_client'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL </th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="tab_departement">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR DEPARTEMENT</h1>
                </div>
                <table id="foo-departement" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">département</th>
                            <th data-hide="phone, tablet">client</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>
                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_departement" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <buttpn id="departement_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</button>
                        </span>
                    </div>
                    <tbody id="body_departement">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL DEPARTEMENT</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_departement'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="tab_agence">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR AGENCE </h1>
                </div>
                <table id="foo-agence" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">agence</th>
                            <th>produit</th>
                            <th data-hide="phone, tablet">client</th>
                            <th data-hide="phone, tablet">departement</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>
                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_agence" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <button id="agence_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</button>
                        </span>
                    </div>
                    <tbody id="body_agence">


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL PAR AGENCE</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Agence</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </thead>
                        <tbody id='bodytab_agence_semi'>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL COMPLET</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_agence'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="tab_produit">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR PRODUIT</h1>
                </div>
                <table id="foo-produit" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">produit</th>
                            <th>agence</th>
                            <th data-hide="phone, tablet">client</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>
                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_produit" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <button id="produit_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</button>
                        </span>
                    </div>
                    <tbody id="body_produit">


                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL PAR PRODUIT</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>produit</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </thead>
                        <tbody id='bodytab_produit_semi'>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL COMPLET</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_produit'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="tab_equipement">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR EQUIPEMENT</h1>
                </div>
                <table id="foo-equipement" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">equipement</th>
                            <th data-hide="phone, tablet">produit</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>
                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_equipement" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <button id="equipement_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</button>
                        </span>
                    </div>
                    <tbody id="body_equipement">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL EQUIPEMENT</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_equipement'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="tab_reference">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h1>STATISTIQUE PAR REFERENCE</h1>
                </div>
                <table id="foo-reference" class="table table-bordered table-hover toggle-circle" data-page-size="7">
                    <thead>
                        <tr>
                            <th data-sort-initial="true" data-toggle="true">référence</th>
                            <th data-hide="phone, tablet">client</th>
                            <th data-hide="phone, tablet">departement</th>
                            <th data-hide="phone, tablet">agence</th>
                            <th data-hide="phone, tablet">produit</th>
                            <th data-hide="phone, tablet">equipement</th>
                            <th>nombre de réclamation</th>
                            <th>nombre de en cours</th>
                            <th>nombre de en traitement</th>
                            <th>nombre de clôturé</th>
                            <th>Moyenne en cours</th>
                            <th>Moyenne en traitement</th>
                        </tr>
                    </thead>
                    <div class="form-group" >
                        <span style="float:left; margin-bottom: 22px;"><button id="export_reference" class="btn btn-primary" style="font-size : 18px" onclick="exporter(this)">generer les statistiques EXCEL</button></span>
                        <span style="float:right;">
                            <button id="reference_link" class="btn btn-danger" onclick="print(this)">telecharger les PV</button>
                        </span>
                    </div>
                    <tbody id="body_reference">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="text-right">
                                    <ul class="pagination">
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="card-title text-center">
                    <h2 style="color: blue">TOTAL REFERENCE</h2>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="text-center  table table-bordered table-striped">

                        <tbody id='bodytab_reference'>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th> TOTAL </th>
                                <th>nombre de réclamation</th>
                                <th>nombre de en cours</th>
                                <th>nombre de en traitement</th>
                                <th>nombre de clôturé</th>
                                <th>Moyenne en cours</th>
                                <th>Moyenne en traitement</th>
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

<!-- <script src="{{ asset('plugins/Chart.js/chartjs.init.js') }}"></script>
<script src="{{ asset('plugins/Chart.js/Chart.min.js') }}"></script> -->
<script>
    $(document).ready(function() {
        fill_list();
        init()

        var foo_client = $('#foo-client').footable();
        var foo_departement = $('#foo-departement').footable();
        var foo_agence = $('#foo-agence').footable();
        var foo_produit = $('#foo-produit').footable();
        var foo_equipement = $('#foo-equipement').footable();
        var foo_reference = $('#foo-reference').footable();

      
        $(".select2").select2();
        var ids = ['client', 'departement', 'agence', 'produit', 'equipement']
        for (var id in ids) {
            $('#tab_' + ids[id]).hide()
        }

        $('#stat_client').trigger('click');
        filter_all()
    });

    function filter_all() {

        form_data = new FormData();


        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip']
        var date_types = ['time_year', 'time_mois', 'time_day']

        var stat_ids = ['client', 'departement', 'agence', 'produit', 'equipement', 'reference']
        for (var val in stat_ids) {

            if ($('#stat_' + stat_ids[val]).is(':checked')) {

                form_data.append('stat_by', stat_ids[val]);
                break;
            }
        }

        for (var val in ids) {
            form_data.append(ids[val], $('#' + ids[val]).val());
        }

        for (var j in date_types) {
            form_data.append(date_types[j] + "_from", $('#' + date_types[j]).data().from);
            form_data.append(date_types[j] + "_to", $('#' + date_types[j]).data().to);
        }


        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/statistiques/filter_index",
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
        $('#body_' + jsonData.stat_by).html("");
        $('#bodytab_' + jsonData.stat_by).html("");
        $('#bodytab_' + jsonData.stat_by + '_semi').html("");
        switch (jsonData.stat_by) {
            case 'client':
                for (var data in jsonData.client) {
                    $('#body_client').append("<tr>" +
                        "<td>" + jsonData.client[data].client_nom + "</td>" +
                        "<td>" + jsonData.client[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.client[data].nb_created + "</td>" +
                        "<td>" + jsonData.client[data].nb_pending + "</td>" +
                        "<td>" + jsonData.client[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.client[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.client[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.client[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.client[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_client) {
                    $('#bodytab_client').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_client[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_client[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_client[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_client[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_client[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_client[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_client[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_client[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }

                break;

            case 'agence':
                for (var data in jsonData.agence) {
                    $('#body_agence').append("<tr>" +
                        "<td>" + jsonData.agence[data].agence_nom + "</td>" +
                        "<td>" + jsonData.agence[data].prod_nom + "</td>" +
                        "<td>" + jsonData.agence[data].client_nom + "</td>" +
                        "<td>" + jsonData.agence[data].depart_nom + "</td>" +
                        "<td>" + jsonData.agence[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.agence[data].nb_created + "</td>" +
                        "<td>" + jsonData.agence[data].nb_pending + "</td>" +
                        "<td>" + jsonData.agence[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.agence[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.agence[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.agence[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.agence[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.semi_total_agence) {
                    $('#bodytab_agence_semi').append("<tr style=\"font-weight: bold\">" +
                        "<td> " + jsonData.semi_total_agence[data].agence_nom + "</td>" +
                        "<td>" + jsonData.semi_total_agence[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.semi_total_agence[data].nb_created + "</td>" +
                        "<td>" + jsonData.semi_total_agence[data].nb_pending + "</td>" +
                        "<td>" + jsonData.semi_total_agence[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.semi_total_agence[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.semi_total_agence[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.semi_total_agence[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.semi_total_agence[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_agence) {
                    $('#bodytab_agence').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_agence[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_agence[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_agence[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_agence[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_agence[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_agence[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_agence[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_agence[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                break;
            case 'produit':
                for (var data in jsonData.produit) {
                    $('#body_produit').append("<tr>" +
                        "<td>" + jsonData.produit[data].prod_nom + "</td>" +
                        "<td>" + jsonData.produit[data].agence_nom + "</td>" +
                        "<td>" + jsonData.produit[data].client_nom + "</td>" +
                        "<td>" + jsonData.produit[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.produit[data].nb_created + "</td>" +
                        "<td>" + jsonData.produit[data].nb_pending + "</td>" +
                        "<td>" + jsonData.produit[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.produit[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.produit[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.produit[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.produit[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.semi_total_produit) {
                    $('#bodytab_produit_semi').append("<tr style=\"font-weight: bold\">" +
                        "<td> " + jsonData.semi_total_produit[data].prod_nom + "</td>" +
                        "<td>" + jsonData.semi_total_produit[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.semi_total_produit[data].nb_created + "</td>" +
                        "<td>" + jsonData.semi_total_produit[data].nb_pending + "</td>" +
                        "<td>" + jsonData.semi_total_produit[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.semi_total_produit[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.semi_total_produit[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.semi_total_produit[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.semi_total_produit[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_produit) {
                    $('#bodytab_produit').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_produit[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_produit[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_produit[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_produit[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_produit[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_produit[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_produit[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_produit[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                break;

            case 'equipement':
                for (var data in jsonData.equipement) {
                    $('#body_equipement').append("<tr>" +
                        "<td>" + jsonData.equipement[data].equip_nom + "</td>" +
                        "<td>" + jsonData.equipement[data].prod_nom + "</td>" +
                        "<td>" + jsonData.equipement[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.equipement[data].nb_created + "</td>" +
                        "<td>" + jsonData.equipement[data].nb_pending + "</td>" +
                        "<td>" + jsonData.equipement[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.equipement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.equipement[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.equipement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.equipement[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_equipement) {
                    $('#bodytab_equipement').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_equipement[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_equipement[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_equipement[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_equipement[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_equipement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_equipement[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_equipement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_equipement[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                break;
            case 'departement':
                for (var data in jsonData.departement) {
                    $('#body_departement').append("<tr>" +
                        "<td>" + jsonData.departement[data].depart_nom + "</td>" +
                        "<td>" + jsonData.departement[data].client_nom + "</td>" +
                        "<td>" + jsonData.departement[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.departement[data].nb_created + "</td>" +
                        "<td>" + jsonData.departement[data].nb_pending + "</td>" +
                        "<td>" + jsonData.departement[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.departement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.departement[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.departement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.departement[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_departement) {
                    $('#bodytab_departement').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_departement[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_departement[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_departement[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_departement[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_departement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_departement[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_departement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_departement[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                break;

            case 'reference':
                for (var data in jsonData.reference) {
                    $('#body_reference').append("<tr>" +
                        "<td>" + jsonData.reference[data].equip_ref + "</td>" +
                        "<td>" + jsonData.reference[data].client_nom + "</td>" +
                        "<td>" + jsonData.reference[data].depart_nom + "</td>" +
                        "<td>" + jsonData.reference[data].agence_nom + "</td>" +
                        "<td>" + jsonData.reference[data].prod_nom + "</td>" +
                        "<td>" + jsonData.reference[data].equip_nom + "</td>" +
                        "<td>" + jsonData.reference[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.reference[data].nb_created + "</td>" +
                        "<td>" + jsonData.reference[data].nb_pending + "</td>" +
                        "<td>" + jsonData.reference[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.reference[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.reference[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.reference[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.reference[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                for (var data in jsonData.total_reference) {
                    $('#bodytab_reference').append("<tr style=\"font-weight: bold\">" +
                        "<td> TOUT </td>" +
                        "<td>" + jsonData.total_reference[data].nb_reclamation + "</td>" +
                        "<td>" + jsonData.total_reference[data].nb_created + "</td>" +
                        "<td>" + jsonData.total_reference[data].nb_pending + "</td>" +
                        "<td>" + jsonData.total_reference[data].nb_closed + " </td>" +
                        "<td>" + (jsonData.total_reference[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.total_reference[data].avg_created_time)) + " </td>" +
                        "<td>" + (jsonData.total_reference[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.total_reference[data].avg_pending_time)) + "</td>" +
                        "</tr>")
                }
                break;
        }
        //  $('#foo-'+jsonData.stat_by).footable();
        $('#foo-' + jsonData.stat_by).data('footable').redraw();
        $('#'+jsonData.stat_by+'_link').attr('href', "")
        $('#'+jsonData.stat_by+'_link').css('color','');


    }

    function exporter(input) {
      //  console.log("here")
        form_data = {};


        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip']
        var date_types = ['time_year', 'time_mois', 'time_day']

        var stat_ids = ['client', 'departement', 'agence', 'produit', 'equipement', 'reference']
        for (var val in stat_ids) {

            if (input.id == 'export_' + stat_ids[val]) {
                    
                form_data['stat_by'] = stat_ids[val];
                break;
            }
        }

        for (var val in ids) {
            var string = ""
            if($('#' + ids[val]).val() != null){
                for(var temp in $('#' + ids[val]).val()){
                    string = string + ($('#' + ids[val]).val())[temp]+","
                }
                string=  string.slice(0,string.length - 1)
            }
            form_data[ids[val]] = string;
        }

        for (var j in date_types) {
            form_data[date_types[j] + "_from"] = $('#' + date_types[j]).data().from;
            form_data[date_types[j] + "_to"] = $('#' + date_types[j]).data().to;
        }

        var StringData = $.ajax({
            url: 'http://127.0.0.1:8000/statistiques/export_stat',
            dataType: "json",
            type: "GET",
            async: false,
            data: form_data
        }).responseText;
         jsonData = JSON.parse(StringData);
         //console.log(jsonData)
         var url = "{{ asset('storage')}}/excel_stats/"+form_data['stat_by']+"s/"+form_data['stat_by']+"_"+jsonData+"_stat.xlsx";
         window.open(url);
     //   $('#'+form_data['stat_by']+'_link').attr('href', "{{ asset('storage')}}/excel_stats/"+form_data['stat_by']+"s/"+form_data['stat_by']+"_"+jsonData+"_stat.xlsx")
     //   $('#'+form_data['stat_by']+'_link').css('color','green');

    }

    function print(input) {
     
        form_data = {};


        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement', 'fv_ref_equip']
        var date_types = ['time_year', 'time_mois', 'time_day']

        var stat_ids = ['client', 'departement', 'agence', 'produit', 'equipement', 'reference']
        for (var val in stat_ids) {

            if (input.id == 'export_' + stat_ids[val]) {
                    
                form_data['stat_by'] = stat_ids[val];
                break;
            }
        }

        for (var val in ids) {
            var string = ""
            if($('#' + ids[val]).val() != null){
                for(var temp in $('#' + ids[val]).val()){
                    string = string + ($('#' + ids[val]).val())[temp]+","
                }
                string=  string.slice(0,string.length - 1)
            }
            form_data[ids[val]] = string;
        }

        for (var j in date_types) {
            form_data[date_types[j] + "_from"] = $('#' + date_types[j]).data().from;
            form_data[date_types[j] + "_to"] = $('#' + date_types[j]).data().to;
        }

        var StringData = $.ajax({
            url: 'http://127.0.0.1:8000/statistiques/print_pv',
            dataType: "json",
            type: "GET",
            async: false,
            data: form_data
        }).responseText;
         jsonData = JSON.parse(StringData);
        
         var url = "{{ asset('storage/documents')}}/"+jsonData.file;
         console.log(url)
         window.open(url);
     //   $('#'+form_data['stat_by']+'_link').attr('href', "{{ asset('storage')}}/excel_stats/"+form_data['stat_by']+"s/"+form_data['stat_by']+"_"+jsonData+"_stat.xlsx")
     //   $('#'+form_data['stat_by']+'_link').css('color','green');

    }

    function init() {

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/statistiques/index",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
        //console.log(jsonData)
        for (var data in jsonData.client) {
            $('#body_client').append("<tr>" +
                "<td>" + jsonData.client[data].client_nom + "</td>" +
                "<td>" + jsonData.client[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.client[data].nb_created + "</td>" +
                "<td>" + jsonData.client[data].nb_pending + "</td>" +
                "<td>" + jsonData.client[data].nb_closed + " </td>" +
                "<td>" + (jsonData.client[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.client[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.client[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.client[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }

        for (var data in jsonData.departement) {
            $('#body_departement').append("<tr>" +
                "<td>" + jsonData.departement[data].depart_nom + "</td>" +
                "<td>" + jsonData.departement[data].client_nom + "</td>" +
                "<td>" + jsonData.departement[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.departement[data].nb_created + "</td>" +
                "<td>" + jsonData.departement[data].nb_pending + "</td>" +
                "<td>" + jsonData.departement[data].nb_closed + " </td>" +
                "<td>" + (jsonData.departement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.departement[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.departement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.departement[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }

        for (var data in jsonData.equipement) {
            $('#body_equipement').append("<tr>" +
                "<td>" + jsonData.equipement[data].equip_nom + "</td>" +
                "<td>" + jsonData.equipement[data].prod_nom + "</td>" +
                "<td>" + jsonData.equipement[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.equipement[data].nb_created + "</td>" +
                "<td>" + jsonData.equipement[data].nb_pending + "</td>" +
                "<td>" + jsonData.equipement[data].nb_closed + " </td>" +
                "<td>" + (jsonData.equipement[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.equipement[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.equipement[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.equipement[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }

        for (var data in jsonData.reference) {
            $('#body_reference').append("<tr>" +
                "<td>" + jsonData.reference[data].equip_ref + "</td>" +
                "<td>" + jsonData.reference[data].client_nom + "</td>" +
                "<td>" + jsonData.reference[data].depart_nom + "</td>" +
                "<td>" + jsonData.reference[data].agence_nom + "</td>" +
                "<td>" + jsonData.reference[data].prod_nom + "</td>" +
                "<td>" + jsonData.reference[data].equip_nom + "</td>" +
                "<td>" + jsonData.reference[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.reference[data].nb_created + "</td>" +
                "<td>" + jsonData.reference[data].nb_pending + "</td>" +
                "<td>" + jsonData.reference[data].nb_closed + " </td>" +
                "<td>" + (jsonData.reference[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.reference[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.reference[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.reference[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }

        for (var data in jsonData.agence) {
            $('#body_agence').append("<tr>" +
                "<td>" + jsonData.agence[data].agence_nom + "</td>" +
                "<td>" + jsonData.agence[data].prod_nom + "</td>" +
                "<td>" + jsonData.agence[data].client_nom + "</td>" +
                "<td>" + jsonData.agence[data].depart_nom + "</td>" +
                "<td>" + jsonData.agence[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.agence[data].nb_created + "</td>" +
                "<td>" + jsonData.agence[data].nb_pending + "</td>" +
                "<td>" + jsonData.agence[data].nb_closed + " </td>" +
                "<td>" + (jsonData.agence[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.agence[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.agence[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.agence[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }

        for (var data in jsonData.produit) {
            $('#body_produit').append("<tr>" +
                "<td>" + jsonData.produit[data].prod_nom + "</td>" +
                "<td>" + jsonData.produit[data].agence_nom + "</td>" +
                "<td>" + jsonData.produit[data].client_nom + "</td>" +
                "<td>" + jsonData.produit[data].nb_reclamation + "</td>" +
                "<td>" + jsonData.produit[data].nb_created + "</td>" +
                "<td>" + jsonData.produit[data].nb_pending + "</td>" +
                "<td>" + jsonData.produit[data].nb_closed + " </td>" +
                "<td>" + (jsonData.produit[data].avg_created_time == null ? 'N/A' : secondsToDhms(jsonData.produit[data].avg_created_time)) + " </td>" +
                "<td>" + (jsonData.produit[data].avg_pending_time == null ? 'N/A' : secondsToDhms(jsonData.produit[data].avg_pending_time)) + "</td>" +
                "</tr>")
        }



    }


    function fill_list() {

        $('#fv_client').html("")
        $('#fv_departement').html("")
        $('#fv_agence').html("")
        $('#fv_produit').html("")
        $('#fv_equipement').html("")
        $('#fv_ref_equip').html("")

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/statistiques/fill_list",
            dataType: "json",
            type: "GET",
            async: false,
        }).responseText;
        jsonData = JSON.parse(StringData);
         // console.log(jsonData)

        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement']



        for (let ind = 0; ind < ids.length; ind++) {
            for (let j = 0; j < jsonData[ids[ind]].length; j++) {
                $('#' + ids[ind]).append("<option " + (jsonData['inputs'][ids[ind]] != 0 ? " selected " : " ") + " value=\"" + jsonData[ids[ind]][j].id + "\">" + jsonData[ids[ind]][j].nom + "</option>");
            }
        }

        for (let j = 0; j < jsonData['fv_ref_equip'].length; j++) {
            $('#fv_ref_equip').append("<option value=\"" + jsonData['fv_ref_equip'][j].equip_ref + "\">" + jsonData['fv_ref_equip'][j].equip_ref + "</option>");
        }


    }

    function filter_data(declancheur) {

        var ids = ['fv_client', 'fv_departement', 'fv_agence', 'fv_produit', 'fv_equipement']
        var checks = new Object();
        form_data = new FormData();
        var check = false;
        form_data.append('declancheur_id', declancheur.id);
        for (var val in ids) {
            form_data.append(ids[val], $('#' + ids[val]).val());
            form_data.append("check_" + ids[val], check);
            checks[ids[val]] = check;
            if (ids[val] == declancheur.id) {
                check = true;
            }
        }

        var StringData = $.ajax({
            url: "http://127.0.0.1:8000/statistiques/filter_data",
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
        // console.log(jsonData)
        for (var val in checks) {
            if (checks[val]) {
                $('#' + val).html("")
            }
        }

        // console.log(jsonData['inputs']['fv_produit'])
        for (var ind in checks) {
            for (let j = 0; j < jsonData[ind].length; j++) {
                if (checks[ind]) {
                    
                    $('#' + ind).append("<option " + (jsonData['inputs'][checks[ind]] != 0 && jsonData['inputs'][checks[ind]] != null ? " selected " : " ") + " value=\" " + jsonData[ind][j].id + "\" >" + jsonData[ind][j].nom + "</option>");
                }
            }
        }
        $('#fv_ref_equip').html("")
        for (let j = 0; j < jsonData['fv_ref_equip'].length; j++) {

            $('#fv_ref_equip').append("<option value=\"" + jsonData['fv_ref_equip'][j].equip_ref + "\">" + jsonData['fv_ref_equip'][j].equip_ref + "</option>");
        }

    }


    function check(input) {

        var ids = ['client', 'departement', 'agence', 'produit', 'equipement', 'reference']
        var filters = ['fl_client', 'fl_departement', 'fl_agence', 'fl_produit', 'fl_equipement', 'fl_ref_equip']

        var filters_to_show = new Object();
        filters_to_show['client'] = ['fl_client'];
        filters_to_show['departement'] = ['fl_client', 'fl_departement'];
        filters_to_show['agence'] = ['fl_client', 'fl_departement', 'fl_agence', 'fl_produit'];
        filters_to_show['produit'] = ['fl_client', 'fl_departement', 'fl_agence', 'fl_produit'];
        filters_to_show['equipement'] = ['fl_produit', 'fl_equipement'];
        filters_to_show['reference'] = ['fl_client', 'fl_departement', 'fl_agence', 'fl_produit', 'fl_equipement', 'fl_ref_equip'];



        for (var id in ids) {
            $('#' + filters[id]).hide()
            if (input.id == "stat_" + ids[id]) {
                $('#tab_' + ids[id]).show()
                for (var inp in filters_to_show[ids[id]]) {
                    $('#' + filters_to_show[ids[id]][inp]).show()
                }
            } else {
                $('#tab_' + ids[id]).hide()
            }

        }
        if (input.id == 'stat_agence') {
            $('#fl_produit').show()
        }
        fill_list()
        filter_all()

    }

    function secondsToDhms(seconds) {
        seconds = Number(seconds);
        var d = Math.floor(seconds / (3600 * 24));
        var h = Math.floor(seconds % (3600 * 24) / 3600);
        var m = Math.floor(seconds % 3600 / 60);
        var s = Math.floor(seconds % 60);

        var dDisplay = d > 0 ? d + (d == 1 ? " j: " : " j: ") : "";
        var hDisplay = h > 0 ? h + (h == 1 ? " h: " : " h: ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " min: " : " min: ") : "";
        var sDisplay = s > 0 ? s + (s == 1 ? " sec" : " sec") : "";
        return dDisplay + hDisplay + mDisplay + sDisplay;
    }
</script>
<script type="text/javascript">
    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', function() {
        $("#time_mois").ionRangeSlider({
            type: "double",
            min: 1,
            max: 12
        });

        $("#time_year").ionRangeSlider({
            type: "double",
            min: 2018,
            max: new Date().getFullYear()
        });

        $("#time_day").ionRangeSlider({
            type: "double",
            min: 1,
            max: 31
        });
    }); //script 
</script>

@endsection