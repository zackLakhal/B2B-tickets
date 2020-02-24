@extends('layouts.appback')

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
<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                             @endif
                             <button type="button" class="btn btn-primary pull-right" id="newmodal"  >+ nouveau role</button>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class=" text-center  table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                            <th >Role-id</th>
                                            <th >Nom</th>
                                            <th >Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id='bodytab'>
                                             
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th >Role-id</th>
                                            <th >Nom</th>
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
                                                        <label for="nom" class="control-label"><b>nom:</b></label>
                                                        <input type="text" class="form-control" id="nom" name="nom" >
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
