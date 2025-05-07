@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')

    <div class="content-wrapper">
        {{-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    
                    <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content"> --}}
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary mt-3">
                            <div class="card-body">
                                {{-- <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                            
                                    <li class="nav-item">
                                    <a class="nav-link active" id="reminder-tab" data-toggle="tab" href="#reminder" role="tab" aria-controls="reminder" aria-selected="true">TS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="reminder-archive-tab" data-toggle="tab" href="#reminderArchive" role="tab" aria-controls="archive" aria-selected="false">PPS</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="workloads-person-tab" data-toggle="tab" href="#workloadsPerson" role="tab" aria-controls="person" aria-selected="false">YEC D</a>
                                    </li>
                                </ul> --}}
                            <div style="float: left; display: none;">
                                <form id="formDateSearch">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">From</span>
                                        </div>
                                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo Date('Y-m-d'); ?>">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">To</span>
                                        </div>
                                        <input type="date" class="form-control" id="to_date" name="to_date"  value="<?php echo Date('Y-m-d'); ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div style="float: right; display: none;">
                                <button class="btn btn-primary" id="modalAddBaseMoldId" data-toggle="modal" data-target="#modalAddBaseMold"><i class="fa fa-plus"></i> Add BaseMold</button>
                            </div>
                            
                            
                            <br><br>
                            {{-- <div class="row justify-content-between">
                                <div class="form-group">
                                    <input type="text" >
                                    <input type="text" >
                                </div>
                                <div >
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddBaseMold">Add Base Mold</button>

                                </div>
                            </div><br> --}}
                                <div class="tab-content" id="myTabContent">
                                    <div class="table-responsive mt-2">
                                        <table id="tbl-list-receiving" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Cat</th>
                                                    <th>Date</th>
                                                    <th>PR Number</th>
                                                    <th>GR Number</th>
                                                    {{-- <th>No. of Item</th> --}}
                                                    <th>Code</th>
                                                    <th>Parts Name</th>
                                                    <th>Qty</th>
                                                    {{-- <th>Qty of Basemold</th> --}}
                                                    {{-- <th>Confirmed Qty</th> --}}
                                                    {{-- <th>Qty After Grinding</th> --}}
                                                    {{-- <th>Remarks</th> --}}
                                            
                                                    {{-- <th>Remarks(Variance)</th> --}}
                                                    {{-- <th>Status</th> --}}
                                                    {{-- <th>Date & Time Endorsed</th> --}}
                                                    {{-- <th>Recieved By</th> --}}
                                                    {{-- <th>Slip Control</th> --}}
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="modal fade" id="modalViewBasemoldDetails" data-backdrop="static" style="overflow: auto;">
                                    <div class="modal-dialog" style="width:100%;max-width:550px;"> 
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-info-circle"></i> Basemold Details</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                        

                                                    {{-- <div class="input-group input-group-sm mb-3">
                                                    
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">No of Items:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="NumItemsId" name="BasemoldNumItems" readonly>
                                    
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Quantity of Basemold:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="QtyBasemoldId" name="BasemoldQty" readonly>
                                    
                                                    </div> --}}
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Confirmed Quantity:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="ConfQtyId" name="BasemoldConfQty" readonly>
                                    
                                                    </div>

                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Remarks:</span>
                                                        </div>
                                                        
                                                        {{-- <input type="text" class="form-control" id="ConfAccptQtyId" name="BasemoldConfQty" readonly> --}}
                                                        <textarea class="form-control" name="" id="txtRemarks" rows="3" readonly></textarea>
                                    
                                                    </div>
                                                    {{-- <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Quantity after Grinding:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="QtyAfterGrindId" name="basemoldQtyAfterGrind" readonly>
                                    
                                                    </div> --}}
                                                </div>
                            
                                                
                                                <div class="modal-footer">
                                                    <div>
                                                        <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>
                                                    </div>
                                                    
                                                    {{-- <div>
                                                        <button class="btn btn-danger" id="btn-disapprove-id">Disapprove</button>
                                                        <button class="btn btn-success" id="btn-approve-id"  data-toggle="modal" data-target="#approveBasemoldModal">Approve</button>
                                                    </div> --}}
                                                </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="modalAcceptBasemoldDetails" data-backdrop="static" style="overflow: auto;">
                                    <div class="modal-dialog" style="width:100%;max-width:550px;"> 
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark">
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-info-circle"></i> Basemold Details</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                        

                                                    {{-- <div class="input-group input-group-sm mb-3">
                                                    
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">No of Items:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="NumAccptItemsId" name="BasemoldNumItems" readonly>
                                    
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Quantity of Basemold:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="QtyAccptBasemoldId" name="BasemoldQty" readonly>
                                    
                                                    </div> --}}
                                                    <div class="input-group input-group-sm mb-3 d-none">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Confirmed Quantity:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="ConfAccptQtyId" name="BasemoldConfQty" readonly>
                                    
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Remarks:</span>
                                                        </div>
                                                        
                                                        {{-- <input type="text" class="form-control" id="ConfAccptQtyId" name="BasemoldConfQty" readonly> --}}
                                                        <textarea class="form-control" name="" id="txtAccptRemarks" rows="3" readonly></textarea>
                                    
                                                    </div>
                                                    {{-- <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Quantity after Grinding:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="QtyAccptAfterGrindId" name="basemoldQtyAfterGrind" readonly>
                                    
                                                    </div> --}}
                                                </div>
                            
                                                
                                                <div class="modal-footer justify-content-between">
                                                    <div>
                                                        <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>
                                                    </div>
                                                    
                                                    <div>
                                                        <button class="btn btn-danger" id="btn-disapprove-id" data-toggle="modal" data-target="#disapproveBasemoldModal">Disapprove</button>
                                                        <button class="btn btn-success" id="btn-approve-id"  data-toggle="modal" data-target="#approveBasemoldModal">Approve</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="approveBasemoldModal" data-backdrop="static" style="overflow: auto;">
                                    <div class="modal-dialog" style="width: auto;"> 
                                        <div class="modal-content">
                                        
                                            <div class="modal-header bg-success">
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-exclamation-circle"></i> Approval of Basemold</h4>
                                                <button id="close1" class="close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                           
                                
                                            <form id="formApprovalBasemoldId">
                                                @csrf
                                                <div class="modal-body">
                                                    <label class="text-secondary" >Are you sure you want to approve this?</label>
                                                    {{-- <input type="text" id="delBasemoldId"><br> --}}
                                                    {{-- <label class="text-secondary" style="font-size: 1.2rem;"> Are you sure you want to approve this?</label><br><br> --}}
                                                    {{-- <div class="form-check float-right mb-2">
                                                        <input class="form-check-input" type="checkbox"  id="checkSpecialAcceptid" name="checkSpecialAccept" value="1">
                                                        <label class="form-check-label" for="checkSpecialAcceptid">
                                                        Special Accept
                                                        </label>
                                                    </div> --}}
                                                    <input type="hidden" id="idBasemoldId" name="BasemoldId">
                                                    <input type="hidden" id="idBasemoldCode" name="BasemoldCode">
                                                    <input type="hidden" id="idBasemoldPartname" name="BasemoldPartname">
                                                    <input type="hidden" id="idBasemoldPR" name="BasemoldPR">
                                                    <input type="hidden" id="idBasemoldGR" name="BasemoldGR">

                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Recieved Basemold Quantity:</span>
                                                        </div>
                                                        
                                                        <input type="text" class="form-control" id="qtyRecievedId" name="qtyRecieved" readonly>
                                    
                                                    </div>
            
            
            
                                                    {{-- <h5 class="text-secondary">Remarks:</h5>
                                                    <textarea rows="5" style="resize: none" class="form-control" name="recievedRemarks" id="recievedRemarksId"></textarea> --}}
                                            
                                                    
                                                
                                                </div>
                            
                                                
                                                <div class="modal-footer">
                                                    <button id="close1" class="btn btn-default">Cancel</button>
                                                    <button id="submit" class="btn btn-success">Yes</button>
                            
                                                    {{-- <button type="submit" class="btn btn-success">Yes</button> --}}
                                                </div>
                                            </form>
                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="disapproveBasemoldModal" data-backdrop="static" style="overflow: auto;">
                                    <div class="modal-dialog" style="width: auto;"> 
                                        <div class="modal-content">
                                        
                                            <div class="modal-header bg-danger">
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-exclamation-circle"></i> Disapproval of Basemold</h4>
                                                <button id="close1" class="close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formDisapproveBasemoldId">
                                                @csrf
                                                <div class="modal-body">
                                
                                                    {{-- <input type="text" id="delBasemoldId"><br> --}}
                                                    <label class="text-secondary" style="font-size: 1.2rem;"> Are you sure you want to disapprove this basemold?</label><br>
                                                    {{-- <div class="form-check float-right mb-2">
                                                        <input class="form-check-input" type="checkbox"  id="checkSpecialAcceptid" name="checkSpecialAccept" value="1">
                                                        <label class="form-check-label" for="checkSpecialAcceptid">
                                                        Special Accept
                                                        </label>
                                                    </div> --}}
                                                    <input type="hidden" id="idDisBasemoldId" name="BasemoldDisId">
                                                    {{-- <input type="text" id="idDisBasemoldCode" name="BasemoldCode">
                                                    <input type="text" id="idDisBasemoldPartname" name="BasemoldPartname"> --}}

                                                
            
            
            
                                                    <h5 class="text-secondary">Remarks:</h5>
                                                    <textarea rows="5" style="resize: none" class="form-control" name="recievedDisRemarks" id="recievedDisRemarksId"></textarea>
                                            
                                                    
                                                
                                                </div>
                            
                                                
                                                <div class="modal-footer">
                                                    <button id="close1" class="btn btn-default">Cancel</button>
                                                    <button id="submit_dis" class="btn btn-danger">Yes</button>
                            
                                                    {{-- <button type="submit" class="btn btn-success">Yes</button> --}}
                                                </div>
                                            </form>
                                        
                                        </div>
                                    </div>
                                </div>

                        </div>

                    </div>
                </div>
            </div>
        {{-- </section> --}}

    </div>


@section('js_content')
<script>
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
    theme: 'bootstrap4'
    });

    $(document).ready(function () {
        //PACKING LIST DATA TABLE
        var date_from = $("input[id='from_date']",$("#formDateSearch")).val();
        var date_to = $("input[id='to_date']",$("#formDateSearch")).val();
        dataTableBasemoldGrinding = $("#tbl-list-receiving").DataTable({
            "processing" : true,
            "serverSide" : true,
            // "order": [[ 2, "desc" ]],
            "ordering": false,

            "ajax" : {
                url: "get_basemold_info_grinding",
                data: function (param){
                    param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                    param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                }

            },
            "columns":[    
                { "data" : "status"},
                { "data" : "from"},
                { "data" : "date"},
                { "data" : "pr_number"},
                { "data" : "gr_number"},
                { "data" : "basemold.code"},
                { "data" : "basemold.part_name"},
                { "data" : "qty_confirmed"},
                // { "data" : "lot_no"},
                // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

        $(document).on('click', '.btn-basemold-view', function(){
            let basemoldId = $(this).attr('basemold-id');
            getBasemoldInfo(basemoldId);
        });
        $(document).on('click', '.btn-basemold-accept', function(){
            let basemoldId = $(this).attr('basemold-id');
            // console.log(basemoldId);
            getBasemoldInfo(basemoldId);
        });
        

        $('button[id=close1]').on('click', function(e){
            e.preventDefault();
            
            $('#approveBasemoldModal').modal('hide');
            $('#disapproveBasemoldModal').modal('hide');

        });


        $('#submit').on('click', function(e){
            e.preventDefault();
            acceptBasemold();
        });

        $('#submit_dis').on('click', function(e){
            e.preventDefault();
            disapproveBasemold();
        });

        
    });

</script>

@endsection

@endsection
