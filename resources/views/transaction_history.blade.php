
@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')

<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary m-2">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                        
                                <li class="nav-item">
                                <a class="nav-link active" id="set-up-tab" data-toggle="tab" href="#setup" role="tab" aria-controls="setup" aria-selected="true">Set-up Transaction Tab</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="rework-visual-tab" data-toggle="tab" href="#reworkvisual" role="tab" aria-controls="reworkvisual" aria-selected="false">Rework and Visual Transaction Tab</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="buyoff-tab" data-toggle="tab" href="#buyoff" role="tab" aria-controls="buyoff" aria-selected="false">Buy-off Transaction Tab</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="setup" role="tabpanel" aria-labelledby="wip-tab">

                                    <div class="table-responsive mt-2">
                                        <table id="tbl-setup" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                            
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">PR Number</th>
                                                    <th rowspan="2">GR Number</th>
                                                    <th colspan="2" style="text-align: center;">Set-up</th>
                                                    <th rowspan="2" style="text-align: center;">Action</th>

                                                </tr>
                                               <tr>
                                                   <th style="text-align: center;">IN</th>
                                                   <th style="text-align: center;">OUT</th>
                                               </tr>
                                               {{-- <tr>
                                                <th rowspan="2" style="text-align: center;">Action</th>

                                               </tr> --}}
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="reworkvisual" role="tabpanel" aria-labelledby="rework-visual-tab">

                                    <div class="table-responsive mt-2">
                                        <table id="tbl-reworkvisual" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                            
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">PR Number</th>
                                                    <th rowspan="2">GR Number</th>
                                                    <th colspan="2" style="text-align: center;">Rework & Visual</th>
                                                    <th rowspan="2" style="text-align: center;">Action</th>

                                                </tr>
                                               <tr>
                                                   <th style="text-align: center;">IN</th>
                                                   <th style="text-align: center;">OUT</th>
                                               </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="buyoff" role="tabpanel" aria-labelledby="buyoff-tab">

                                    <div class="table-responsive mt-2">
                                        <table id="tbl-buyoff" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                            
                                                    <th rowspan="2">Date</th>
                                                    <th rowspan="2">PR Number</th>
                                                    <th rowspan="2">GR Number</th>
                                                    <th colspan="2" style="text-align: center;">Buy-off</th>
                                                    <th rowspan="2" style="text-align: center;">Action</th>

                                                </tr>
                                               <tr>
                                                   <th style="text-align: center;">IN</th>
                                                   <th style="text-align: center;">OUT</th>
                                               </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                
                                <div class="modal fade" id="modalSetupTransaction" data-backdrop="static" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-sm" style="min-width: 700px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Set-up Transaction Details</h4>
                                                <button id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="inputs">

                                                </div>
                                                {{-- <div class="row" id="inputs"> --}}
                                                    {{-- <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div>
                                                    <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                 
                                <div class="modal fade" id="modalReworkVisualTransaction" data-backdrop="static" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-sm" style="min-width: 700px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Set-up Transaction Details</h4>
                                                <button id="cancel-visual-rework" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="inputs-rework-visual">

                                                </div>
                                                {{-- <div class="row" id="inputs"> --}}
                                                    {{-- <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div>
                                                    <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalBuyoffTransaction" data-backdrop="static" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-sm" style="min-width: 700px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Set-up Transaction Details</h4>
                                                <button id="cancel-buyoff" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="inputs-buyoff">

                                                </div>
                                                {{-- <div class="row" id="inputs"> --}}
                                                    {{-- <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div>
                                                    <div class="form-group col-6"> 
                                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                                        <input type="text" class="form-control" id="" name="" readonly>
                                                    </div> --}}
                                                {{-- </div> --}}
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</div>
@section('js_content')
<script>
    $(document).ready(function () {
        
        dataTableListSetupTransaction= $("#tbl-setup").DataTable({
            "processing" : true,
            "ordering": false,
            "serverSide" : true,
            "ajax" : {
                url: "get_setup_transaction",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                { "data" : "transaction_date"},
                { "data" : "basemold_wip.PR_number"},
                { "data" : "basemold_wip.GR_number"},
                // { "data" : "PR_number"},
                // { "data" : "GR_number"},
                { "data" : "basemold_wip.IN"},
                { "data" : "basemold_wip.OUT"},
                // { "data" : "pr_number"},
                // { "data" : "code"},
                // { "data" : "part_name"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });
        dataTableListReworkVisualTransaction= $("#tbl-reworkvisual").DataTable({
            "processing" : true,
            "ordering": false,
            "serverSide" : true,
            "ajax" : {
                url: "get_rework_visual_transaction_history",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                { "data" : "transaction_date"},
                { "data" : "rework_visual.PR_number"},
                { "data" : "rework_visual.GR_number"},
                // // { "data" : "PR_number"},
                // // { "data" : "GR_number"},
                { "data" : "rework_visual.fgs_rework_IN"},
                { "data" : "rework_visual.fgs_rework_OUT"},
                // // { "data" : "pr_number"},
                // // { "data" : "code"},
                // // { "data" : "part_name"},
                // // // { "data" : "lot_no"},
                // // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

        dataTableListBuyoffTransaction= $("#tbl-buyoff").DataTable({
            "processing" : true,
            "ordering": false,
            "serverSide" : true,
            "ajax" : {
                url: "get_buyoff_transaction_history",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                { "data" : "transaction_date"},
                { "data" : "fgs_recieve.PR_number"},
                { "data" : "fgs_recieve.GR_number"},
                // // // { "data" : "PR_number"},
                // // // { "data" : "GR_number"},
                { "data" : "fgs_recieve.fgs_IN"},
                { "data" : "fgs_recieve.fgs_OUT"},
                // // { "data" : "pr_number"},
                // // { "data" : "code"},
                // // { "data" : "part_name"},
                // // // { "data" : "lot_no"},
                // // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

      


        $(document).on('click', '.btn-setup-transaction', function(){
            let setupTransactionId = $(this).attr('transaction-id');
            getSetupTransactionDetails(setupTransactionId);


            // console.log(setupTransactionId);
           
        });

        $('#cancel').on('click', function(){
            console.log("close");
            $('#test').remove();
        });

        $(document).on('click', '.btn-rework-visual-transaction', function(){
            let reworkVisualTransactionId = $(this).attr('transaction-id');
            getReworkVisualTransactionDetails(reworkVisualTransactionId);


            // console.log(reworkVisualTransactionId);
           
        });
        
        $('#cancel-visual-rework').on('click', function(){
            console.log("close");
            $('#test').remove();
        });

        $(document).on('click', '.btn-buyoff-transaction', function(){
            let buyoffTransactionId = $(this).attr('transaction-id');
            getBuyoffTransactionDetails(buyoffTransactionId);


            // console.log(buyoffTransactionId);
           
        });
            
        $('#cancel-buyoff').on('click', function(){
            console.log("close");
            $('#test').remove();
        });

     


        
    });

function getSetupTransactionDetails(setupTransactionId){
    $.ajax({
        url: 'get_setup_transaction_details',
        method: 'get',
        data:{
            setupTransactionId: setupTransactionId,
        },
        dataType: 'json',
        success: function(response){
            $("#inputs").append(response['result']);

        },
    });
}

function getReworkVisualTransactionDetails(reworkVisualTransactionId){
    $.ajax({
        url: 'get_rework_visual_transaction_details',
        method: 'get',
        data:{
            reworkVisualTransactionId: reworkVisualTransactionId,
        },
        dataType: 'json',
        success: function(response){
            $("#inputs-rework-visual").append(response['result']);

        },
    });
}

function getBuyoffTransactionDetails(buyoffTransactionId){
    $.ajax({
        url: 'get_buyoff_transaction_details',
        method: 'get',
        data:{
            buyoffTransactionId: buyoffTransactionId,
        },
        dataType: 'json',
        success: function(response){
            $("#inputs-buyoff").append(response['result']);

        },
    });
}
</script>

@endsection

@endsection
