@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
    <div class="content-wrapper">
        {{-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Home</li>
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
                           
                            <div style="float: right;">
                                <button class="btn btn-info" id="modalImportTSBaseMoldId" data-toggle="modal" data-target="#modalImportTSBaseMold"><i class="fas fa-file-upload"></i> Import TS Basemold</button>
                                <button class="btn btn-info" id="modalImportBaseMoldId" data-toggle="modal" data-target="#modalImportPPSYECBaseMold"><i class="fas fa-file-upload"></i> Import PPS/YEC Basemold</button>
                                <button class="btn btn-info" id="modalAddBaseMoldId" data-toggle="modal" data-target="#modalAddBaseMold"><i class="fa fa-plus"></i> Add Basemold</button>
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
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- MODAL IMPORT BASEMOLD --}}
            <div class="modal fade" id="modalImportPPSYECBaseMold">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-dark">
                      <h4 class="modal-title"><i class="fas fa-file-import"></i> Import YEC/PPS Basemold</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                      </button>
                    </div>
                    <form method="post" id="formImportBasemold" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>File</label>
                                <input type="file" class="form-control" name="import_file" id="fileImportBasemold" required>
                                {{-- <a href="download_file">Download Sample</a> --}}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnImportBasemold" class="btn btn-success"><i id="iconImportBasemold" class="fa fa-check"></i> Import</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
              <!-- /.modal -->


            {{-- MODAL FOR TS BASEMOLD IMPORT --}}
            <div class="modal fade" id="modalImportTSBaseMold">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header bg-dark">
                      <h4 class="modal-title"><i class="fas fa-file-import"></i> Import TS Basemold</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                      </button>
                    </div>
                    <form method="post" id="formImportTSBasemold" enctype="multipart/form-data">
                      @csrf
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group">
                              <label>File</label>
                                <input type="file" class="form-control" name="import_file" id="fileImportBasemold" required>
                                {{-- <a href="download_file">Download Sample</a> --}}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnImporTSBasemold" class="btn btn-success"><i id="iconImportBasemold" class="fa fa-check"></i> Import</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
              <!-- /.modal -->

            {{-- MODAL ADD BASEMOLD --}}
            <div class="modal fade" id="modalAddBaseMold" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog"  style="width:100%;max-width:850px;"> 
                    <div class="modal-content">
                    
                        <div class="modal-header bg-dark" >
                            <h4 class="modal-title" style="color: white"><i class="fas fa-info-circle"></i> Basemold Details</h4>
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="formAddBasemoldId" autocomplete="off">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        
                                        <input type="hidden" id="basemoldId" name="basemoldId">
                                    
                                        <div class="row" style="display: flex; justify-content: space-between;">
                                            <div class="form-group col-sm-3"> 
                                                <label class="form-control-label">Date:</label> 
                                                <input type="text" class="form-control" id="txtAddDateid" name="add_date" value="<?php echo Date('Y-m-d'); ?>" readonly> 
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">PR Number:</label> 
                                                <input type="text" class="form-control" id="txtAddPrId" name="pr_number">
                                                
                                            </div>
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">GR Number:</label> 
                                                <input type="text" class="form-control" id="txtAddGrId" name="gr_number"> 
                                            </div>
                                        
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">Code:</label> 
                                                <input type="text" class="form-control" id="txtAddCodeId"  list="code" name="code"> 
                                                <datalist class="code" id="code">
                                                
                                                </datalist>
                                            </div>
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">Part Name:</label> 
                                                <input type="text" class="form-control" id="txtAddPartnameId" name="part_name"> 
                                            </div>
                                        
                                        </div>
                                        {{-- <div class="row">
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">No. of Items:</label> 
                                                <input type="number" class="form-control" id="txtAddNoItemsId" name="no_of_items"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div>
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">Lot No:</label> 
                                                <input type="text" class="form-control" id="txtAddLotNumberId" name="lot_no"> 
                                            </div>
                                        
                                        </div> --}}

                                        <div class="row">
                                            
                                            {{-- <div class="form-group col-sm-4"> 
                                                <label class="form-control-label">Qty of Basemold:</label> 
                                                <input type="number" class="form-control" id="txtAddQtyMoldId" name="qty_basemold" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div> --}}
                                            <div class="form-group col-sm-6"> 
                                                <label class="form-control-label">Confirmed QTY:</label> 
                                                <input type="number" class="form-control" id="txtAddConfirmedId" name="confirm_qty" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-control-label">From:</label> 
                                                <select name="basemold_cat" id="txtAddCatId"  class="form-control" >
                                                    <option value="" selected disabled>-Select-</option>
                                                    <option value="TS">TS</option>
                                                    <option value="PPS">PPS</option>
                                                    <option value="YEC DIRECT">YEC DIRECT</option>
                                                </select>
                                            </div>
                                            {{-- <div class="form-group col-sm-4"> 
                                                <label class="form-control-label">QTY after Grinding:</label> 
                                                <input type="number" class="form-control" id="txtAddQtyAfterGrind" name="qty_after_grind" onkeypress="return event.charCode >= 48 && event.charCode <= 57"> 
                                            </div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col form-group">
                                                <label class="form-control-label">Remark:</label> 
                                                <textarea class="form-control" name="addRemark" id="txtAddRemarks" rows="3"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
            
                    
                    </div>
                </div>
            </div>


            {{-- MODAL VIEW BASEMOLD --}}
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
                                
                                <input type="text" class="form-control" id="NumItemsId" readonly>
            
                            </div> --}}
                            {{-- <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1">Quantity of Basemold:</span>
                                </div>
                                
                                <input type="text" class="form-control" id="QtyBasemoldId" readonly>
            
                            </div> --}}
                            <div class="input-group input-group-sm mb-3 d-none">
                                <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1">Confirmed Quantity:</span>
                                </div>
                                
                                <input type="text" class="form-control" id="ConfQtyId" readonly>
            
                            </div>
                            {{-- <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1">Quantity after Grinding:</span>
                                </div>
                                
                                <input type="text" class="form-control" id="QtyAfterGrindId" readonly>
            
                            </div> --}}
                            {{-- <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                <span class="input-group-text w-100" id="basic-addon1">Remarks:</span>
                                </div>
                                <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                            
            
                            </div> --}}
                            
                            
                                <h6>Remarks:</h6>
                                
                                <textarea rows="5" class="form-control" style="resize: none" id="GrindRemarks"></textarea>
                            
            
                        
                        
                        </div>

                        
                        <div class="modal-footer">
                            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>
                            {{-- <button type="submit" class="btn btn-success">Yes</button> --}}
                        </div>
            
                    
                    </div>
                </div>
            </div>

            {{-- MODAL DELETE BASEMOLD --}}
            <div class="modal fade" id="modalDelBaseMold" data-backdrop="static" style="overflow: auto;">
                <div class="modal-dialog" style="width: auto;"> 
                    <div class="modal-content modal-sm">
                        <div class="modal-header bg-danger">
                            <h4 class="modal-title" style="color: white"><i class="fas fa-exclamation-circle"></i>Delete Basemold</h4>
                            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: white">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="delBasemoldId"><br>
                            <label class="text-secondary"> Are you sure you want to delete this?</label>
                        
                        </div>

                        
                        <div class="modal-footer">
                            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Cancel</button>
                            <button class="btn btn-danger" id="del-basemold">Yes</button>

                            {{-- <button type="submit" class="btn btn-success">Yes</button> --}}
                        </div>
            
                    
                    </div>
                </div>
            </div>
        {{-- </section> --}}
    </div>
    <!--     {{-- JS CONTENT --}} -->
@section('js_content')

<script>
    //  var dataTablePreshipment,dataTablePreshipmentList,dataTableForWhse,dataTableForWhseList;
    $(document).ready(function () {
        //PACKING LIST DATA TABLE
       
        dataTableBasemold = $("#tbl-list-receiving").DataTable({
            "processing" : true,
            "serverSide" : true,
            // "order": [[ 2, "desc" ]],
            "ordering": false,
            "ajax" : {
                url: "get_basemold_info",
               

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

    
        $('#formAddBasemoldId').on('submit', function(event){
            event.preventDefault();
            addBasemold();
        });


        $('#txtAddCodeId').on('keyup', function(){
            getProductCode($('.code'));
            var code = $('#txtAddCodeId').val();
            // console.log(code);
            getPartname(code);
        });

        $("#formDateSearch").submit(function(e){
            e.preventDefault();
            dataTableBasemold.draw();
        });

        $(document).on('click', '.btn-basemold', function(){
            let basemoldId = $(this).attr('basemold-id');
            
            getBasemoldInfo(basemoldId);
        });
        

        $(document).on('click', '.btn-edt-basemold', function(){
            let basemoldId = $(this).attr('basemold-id');
            
            getBasemoldInfoForEdit(basemoldId);
        });

        $(document).on('click', '.btn-del-basemold', function(){
            let basemoldId = $(this).attr('basemold-id');
            $('#delBasemoldId').val(basemoldId);
        });
        $(document).on('click', '#del-basemold', function(){
            var delId = $('#delBasemoldId').val();
            delBasemold(delId);
        });
        
        $(document).on('click', '#close', function(){
            $("#formAddBasemoldId")[0].reset();  
          
        });

        
        $('#formImportTSBasemold').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: 'import_ts_basemold',
                method: 'post',
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // alert('Loading...');
                    $('#btnImporTSBasemold').prop('disabled', 'disabled')
                   
                    // $("#btnSignOut").prop('disabled', 'disabled');
                },
                success: function(JsonObject){
                    if(JsonObject['result'] == 1){
                        toastr.success('Importing Success!');
                        dataTableBasemold.draw();
                        $("#modalImportTSBaseMold").modal('hide');
                        $('#formImportTSBasemold')[0].reset();
                        $("#btnImporTSBasemold").removeAttr('disabled');
                     


                    }
                    else{
                        toastr.error('Importing Failed!');
                        $("#modalImportTSBaseMold").modal('hide');
                        $("#btnImporTSBasemold").removeAttr('disabled');
                    


                    }
                },
                error: function(data, xhr, status){
                    toastr.error('Importing Failed!');
                    $("#btnImporTSBasemold").removeAttr('disabled');
                   

                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });

        $('#formImportBasemold').submit(function(event){
            event.preventDefault();
            $.ajax({
                url: 'import_basemold',
                method: 'post',
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // alert('Loading...');
                    $('#btnImportBasemold').prop('disabled', 'disabled')
                   
                    // $("#btnSignOut").prop('disabled', 'disabled');
                },
                success: function(JsonObject){
                    if(JsonObject['result'] == 1){
                        toastr.success('Importing Success!');
                        dataTableBasemold.draw();
                        $("#modalImportPPSYECBaseMold").modal('hide');
                        $('#formImportBasemold')[0].reset();
                        $("#btnImportBasemold").removeAttr('disabled');
                     


                    }
                    else{
                        toastr.error('Importing Failed!');
                        $("#modalImportPPSYECBaseMold").modal('hide');
                        $("#btnImportBasemold").removeAttr('disabled');
                    


                    }
                },
                error: function(data, xhr, status){
                    toastr.error('Importing Failed!');
                    $("#btnImportBasemold").removeAttr('disabled');
                   

                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });
       


    });



</script>
@endsection

@endsection
