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

                                <div class="modal fade" id="modalPrintQrCode" data-backdrop="static" data-formid="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title"><i class="fas fa-info-circle fa-sm"></i> Basemold QR Code</h3>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form id="formQRBasemoldReceive" autocomplete="off">
                                                @csrf
                                                <div class="modal-body">
                                                        <input type="text" name="basemold_receive_id" id="basemoldReceiveId" hidden>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">Device Name:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="basemoldReceiveDeviceName" name="basemold_receive_device_name" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">PO No.:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="basemoldReceivePoNo" name="basemold_receive_po_no" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">PO Qty:</span>
                                                                    </div>
                                                                    <input type="number" min='0' class="form-control" id="basemoldReceivePoQty" name="basemold_receive_po_qty" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">Basemold Lot No.:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="basemoldLotNo" name="basemold_lot_no" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">SAT:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="basemoldSAT" name="basemold_sat" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">Selection Remarks:</span>
                                                                    </div>
                                                                    {{-- <select name="sel_remarks" id="selRemarks" class="form-control select2bs4"></select> --}}
                                                                    <input type="text" name="sel_remarks" id="selRemarks" class="form-control" list="remarkOptions" required>
                                                                    <datalist id="remarkOptions">
                                                                    </datalist>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2">
                                                            <div class="col-sm-12">
                                                                <div class="input-group input-group-sm mb-3">
                                                                    <div class="input-group-prepend w-50">
                                                                        <span class="input-group-text w-100">Golden Sample:</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" id="basemoldGoldSample" name="basemold_gold_sample" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="button" class="btn btn-default" id="close" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success" id="btnProceedPrintQR">Print</button>
                                                </div>
                                            </form>
                                        </div>
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

        $(document).on('click', '.btnPrintQRCode', function(){
            let basemoldInfo = $(this).attr('basemold-details');
            let parsedBasemoldInfo = JSON.parse(basemoldInfo)
            $('#basemoldReceiveId', $('#formQRBasemoldReceive')).val(parsedBasemoldInfo.id);
            $('#basemoldReceiveDeviceName', $('#formQRBasemoldReceive')).val(parsedBasemoldInfo.basemold.part_name);
            $('#basemoldReceivePoNo', $('#formQRBasemoldReceive')).val(parsedBasemoldInfo.pr_number);
            getDatalistRemarks();
            $('#modalPrintQrCode').modal('show');
        });

        $('#formQRBasemoldReceive').submit(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('print_basemold_qr_code') }}",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(){
                    // $('#btnProceedPrintQR').attr('disabled', true);
                },
                success: function (response) {
                    // console.log(response.data.sel_remarks);
                    if(response.result){
                        windowOpen(response.qrcode, response.label);
                        dataTableBasemoldGrinding.draw();
                        $('#modalPrintQrCode').modal('hide');
                    }else{
                        alert('Error! Please contact your system administrator.');
                    }
                },
                error: function(data, xhr, status){
                    alert('Error! Please contact your system administrator.');
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });

        $('#modalPrintQrCode').on('hidden.bs.modal', function () {
            console.log('Modal closed!');
            $('#formQRBasemoldReceive')[0].reset();
            $('#remarkOptions').html('');
        });

        $(document).on('click', '.btnReprintQr', function(){
            let basemoldId = $(this).attr('basemold-id');
            $.ajax({
                type: "GET",
                url: "{{ route('basemold_reprint_qr') }}",
                data:{
                    basemold_id: basemoldId
                },
                dataType: "json",
                beforeSend: function(){
                },
                success: function (response) {
                    if(response.result){
                        windowOpen(response.qrcode, response.label);
                    }else{
                        alert('Error! Please contact your system administrator.');
                    }
                },
                error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });
        
    });

    function getDatalistRemarks(){
        $.ajax({
            type: "GET",
            url: "{{ route('get_remarks') }}",
            // data: "",
            dataType: "json",
            beforeSend: function(){
            },
            success: function (response) {
                console.log(response);
                let options = '';
                response.forEach(response => {
                    options += `<option value="${response.remarks}">`;
                });
                $('#remarkOptions').html(options);
            },
            error: function(data, xhr, status){
                console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            }
        });
    }

    function windowOpen(qrCode, label){
        popup = window.open();
        let content = '';

        content += '<html>';
        content += '<head>';
        content += '<title></title>';
        content += '<style type="text/css">';
        content += '@media print { .pagebreak { page-break-before: always; } }';
        content += '</style>';
        content += '</head>';
        content += '<body>';
        content += '<table style="margin-left: -5px; margin-top: 15px;">';
        content += '<tr style="width: 290px;">';
        content += '<td style="vertical-align: bottom;">';
        content += '<img id="qrImage" src="' + qrCode + '" style="min-width: 75px; max-width: 75px;">';
        content += '</td>';
        content += '<td style="font-size: 10px; font-family: Calibri;">'+label+'</td>';
        content += '</tr>';
        content += '</table>';
        content += '<br>';
        content += '</body>';
        content += '</html>';
        popup.document.write(content);
        // popup.focus(); //required for IE
        // popup.print();
        popup.document.close();

        // Wait for the image to load before printing
        popup.onload = function() {
            const img = popup.document.getElementById('qrImage');
            if (img.complete) {
                popup.focus();
                popup.print();
                popup.close();
            } else {
                img.onload = function () {
                    popup.focus();
                    popup.print();
                    popup.close();
                };
            }
        };
    }
</script>

@endsection

@endsection
