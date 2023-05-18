@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)

<style>

/** SPINNER CREATION **/

.loader {
  position: relative;
  text-align: center;
  margin: 15px auto 35px auto;
  z-index: 9999;
  display: block;
  width: 80px;
  height: 80px;
  border: 10px solid rgba(0, 0, 0, .3);
  border-radius: 50%;
  border-top-color: #000;
  animation: spin .3s linear  infinite;
  -webkit-animation: spin .3s linear infinite;
}

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}




</style>

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
                    <div class="card card-primary mt-3" style="overflow: auto;">
                        <div class="card-body">
                        
                            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                        
                                    <li class="nav-item">
                                    <a class="nav-link active" id="wip-tab" data-toggle="tab" href="#wip" role="tab" aria-controls="wip" aria-selected="true">Set-up Tab</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="rework_visual-tab" data-toggle="tab" href="#rework_visual" role="tab" aria-controls="rework_visual" aria-selected="false">Rework and Visual Tab</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="fgs-tab" data-toggle="tab" href="#fgs" role="tab" aria-controls="fgs" aria-selected="false">Buy-off Tab</a>
                                    </li>
                                   
                            </ul>
                        <br>
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
                                
                                <div class="float-right">
                                    <a href="export" class="btn btn-primary"><i class="fas fa-file-excel"></i> Export Inventory</a>
                                </div>
                                <br><br>
                                
                                
                                <div class="tab-pane fade show active" id="wip" role="tabpanel" aria-labelledby="wip-tab">

                                    <div class="table-responsive mt-2">
                                        <table id="tbl-list-asset-wip" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                            
                                                    <th>Part Code</th>
                                                    <th>Parts Name</th>
                                                    <th>PR Number</th>
                                                    <th>GR Number</th>
                                                    <th>EOH</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="rework_visual" role="tabpanel" aria-labelledby="rework_visual-tab">

                                    <div class="table-responsive mt-2">
                                        <table id="tbl-list-asset-rework-visual" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                            
                                                    <th>Part Code</th>
                                                    <th>Parts Name</th>
                                                    <th>PR Number</th>
                                                    <th>GR Number</th>
                                                    <th>EOH</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="fgs" role="tabpanel" aria-labelledby="fgs-tab">
                                    <div class="table-responsive mt-2">
                                        <table id="tbl-list-asset-fgs" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                            <thead>
                                                <tr>
                                                  
                                                    <th>Part Code</th>
                                                    <th>Parts Name</th>
                                                    <th>PR Number</th>
                                                    <th>GR Number</th>
                                                    <th>EOH</th>
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

                {{-- MODAL FOR WIP BASEMOLD DETAILS --}}
                <div class="modal fade" id="WipBasemoldModal" data-backdrop="static" style="overflow: auto;">
                    <div class="modal-dialog" style="width:100%; min-width: 1000px;"> 
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Set-up Transaction</h4>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">PR Number:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldPRId" name="wipBasemoldPr" readonly>
                                        
                                        
                                    </div> 
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">GR Number:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldGRId" name="wipBasemoldPr" readonly>
                                        
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldPartCodeId" name="wipBasemoldPr" readonly>
                                        
                                        
                                    </div>
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldPartNameId" name="wipBasemoldPr" readonly> 
                                    </div>
                                
                                </div>
                                <div id="divGlued">
                                    {{-- <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldPartCodeId" name="wipBasemoldPr" readonly>
                                        
                                        
                                    </div>
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                        <input type="text" class="form-control" id="wipBasemoldPartNameId" name="wipBasemoldPr" readonly> 
                                    </div> --}}
                                
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label class="form-control-label text-secondary">Remarks:</label>
                                        <textarea class="form-control" name="" id="setupRemarksId" rows="2" readonly style="resize: none"></textarea>
                                    </div>
                                </div>
                                {{-- <hr class="row mt-0"> --}}
                                    
                                {{-- <a id="collapse_id" class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="width: 100%;">
                                    <i class="fa fa-plus"></i>
                                    Add Transaction
                                    
                                    
                                </a> --}}
                        
                                
                                {{-- <div class="collapse" id="collapseExample">
                                    <div class="card card-body" style="border: 1px solid #007BFF;"> --}}

                                        {{-- <form id="formTransactionWip" autocomplete="off">
                                            @csrf
                                            <input type="hidden"  id="transBasemoldPartCodeId" name="transBasemoldPartCode">
                                            <input type="hidden"  id="transBasemoldPartNameId" name="transBasemoldPartName"> 
                                            <input type="hidden"  id="transBasemoldId" name="transBasemoldId"> 
    
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Date:</label> 

                                                    <input type="date" name="trans_date" id="trans_date_id" class="form-control">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6"> 
                                                    <label class="form-control-label text-secondary">FGS Code:</label> 
                                                    <input type="text" class="form-control" id="trans_fgs_code_id" name="trans_fgs_code" list="fgs_code"> 
                                                    <datalist class="fgs_code" id="fgs_code">
                                                       
                                                    </datalist>
                                                </div>
                                                <div class="form-group col-6"> 
                                                    <label class="form-control-label text-secondary">FGS Name:</label> 
                                                    <input type="text" class="form-control" id="trans_fgs_name_id" name="trans_fgs_name" > 
                                                   
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">BOH:</label>
                                                    <input type="number" class="form-control" id="transaction-eoh-id" name="trans_boh" readonly>
                                                </div>
                                                
                                    
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Basemold OUT:</label>
                                                    <input type="number" class="form-control" id="trasaction-out-id" name="trans_b_out" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">FGS IN:</label>
                                                    <input type="number" class="form-control"  id="trans-fgs-in-id" name="trans_fgs_in" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Next EOH:</label>
                                                    <input type="number" class="form-control" id="transaction-next-eoh-id" name="trans_next_eoh" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-control-label text-secondary">Remarks:</label>
                                                    <textarea class="form-control" name="trans_remarks" id="" rows="2" style="resize: none"></textarea>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <div class="float-right">
                                                        <button class="btn btn-default" id="btn-wip-clear">Clear</button>
                                                        <button id="btn-transaction-save" class="btn btn-success">Save</button>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </form> --}}

                                        
                                        
                                    {{-- </div>
                                </div> --}}
                                <hr class="row mt-2">

                                <div class="row">
                                    <div class="col">
                                        {{-- <h5 class="text-secondary"><i class="fas fa-history"></i> Transaction History</h5> --}}
                                        <h5 class="text-secondary"><i class="fas fa-history"></i> Transaction</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <form id="formTransactionWip" autocomplete="off">
                                            @csrf
                                            <input type="hidden"  id="transBasemoldPartCodeId" name="transBasemoldPartCode">
                                            <input type="hidden"  id="transBasemoldPartNameId" name="transBasemoldPartName"> 

                                            {{-- HIDDEN INPUT FOR GLUED MATERIAL --}}
                                            <input type="hidden"  id="transBasemoldPartCodeId1" name="transBasemoldPartCode1"> 
                                            <input type="hidden"  id="transBasemoldPartNameId1" name="transBasemoldPartName1"> 
                                            {{-- END OF GLUED MATERIAL --}}

                                            <input type="hidden"  id="transBasemoldGRId" name="transBasemoldGR"> 
                                            <input type="hidden"  id="transBasemoldPRId" name="transBasemoldPR">
                                    
                                            <input type="hidden"  id="transBasemoldId" name="transBasemoldId"> 
                                            <input type="hidden"  id="transBasemoldId1" name="transBasemoldId1"> 
                                            <input type="hidden"  id="transactionIdForTable"  name="transactionIdForTable"> 
                                            {{-- HIDDEN INPUT FOR GLUED MATERIAL --}}
                                            <input type="hidden"  id="transactionIdForTable1"  name="transactionIdForTable1"> 
                                            {{-- END OF GLUED MATERIAL --}}


    
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Date:</label> 

                                                    <input type="date" name="trans_date" id="trans_date_id" class="form-control" value="<?php echo Date('Y-m-d'); ?>" readonly>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-6"> 
                                                    <label class="form-control-label text-secondary">Grinded Item Code:</label> 
                                                    <input type="text" class="form-control" id="trans_fgs_code_id" name="trans_fgs_code" list="fgs_code"> 
                                                    <datalist class="fgs_code" id="fgs_code">
                                                       
                                                    </datalist>
                                                </div>
                                                <div class="form-group col-6"> 
                                                    <label class="form-control-label text-secondary">Grinded Item Name:</label> 
                                                    <input type="text" class="form-control" id="trans_fgs_name_id" name="trans_fgs_name" > 
                                                   
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">BOH:</label>
                                                    <input type="number" class="form-control" id="transaction-eoh-id" name="trans_boh" readonly>
                                                </div>
                                                
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">Basemold OUT:</label>
                                                    <input type="number" class="form-control" id="trasaction-out-id" min="0" name="trans_b_out" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                    
                                               
                                                
                                                {{-- <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">FGS IN:</label>
                                                    <input type="number" class="form-control"  id="trans-fgs-in-id" name="trans_fgs_in" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div> --}}
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">Next EOH:</label>
                                                    <input type="number" class="form-control" id="transaction-next-eoh-id" name="trans_next_eoh" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                     
                                                    <label class="form-control-label text-secondary">Grinded Items IN:</label>
                                                    <input type="number" class="form-control"  id="grinded-items-in-id" name="trans_grinded_in_id" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Grinded Items NG:</label>
                                                    <input type="number" class="form-control"  id="trans-grinded-ng-id" name="trans_grinded_ng" value="0" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control-label text-secondary">Golden Sample:</label>
                                                    <input type="number" class="form-control"  id="trans-grinded-gsamp-id" name="trans_grinded_gsamp" value="0" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                                                </div>
                                                <div class="col-sm-3">
                                                    
                                                    <label class="form-control-label text-secondary" data-toggle="tooltip" data-placement="top" title="Automatic">Qty For Reworks & Visual (IN):<i class="fas fa-exclamation-circle"></i></label>
                                                    <input type="number" class="form-control"  id="trans-fgs-in-id" name="trans_fgs_in" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly>
                                                </div>



                                            </div>
                                            {{-- <div class="row">
                                                <div class="col">
                                                    <label class="form-control-label text-secondary">Remarks:</label>
                                                    <textarea class="form-control" name="trans_remarks" id="" rows="2" style="resize: none"></textarea>
                                                    
                                                </div>
                                            </div> --}}
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <div class="float-right">
                                                        {{-- <button class="btn btn-default" id="btn-wip-clear">Clear</button>
                                                        <button id="btn-transaction-save" class="btn btn-success">Save</button> --}}
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </form>
                                       
                                    </div>
                                </div>
                                
                                    
                            </div>
            
                                
                            <div class="modal-footer justify-content-between">
                                <div>
                                    <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-default">Close</button>
                                </div>
                                <div>
                                    <button class="btn btn-default" id="btn-wip-clear">Clear</button>
                                    <button id="btn-transaction-save" class="btn btn-success">Save</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="WipBasemoldRemarks" data-backdrop="static">
                    <div class="modal-dialog" style="min-width: 600px;">
                        <div class="modal-content">
                            
                                <div class="modal-header bg-dark">
                                    <h4 class="modal-title" style="color: white"><i class="fa fa-edit"></i> Edit</h4>
                                    <button id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color: white">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formRemarksWip">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="wipId" id="txtWipId">
    
                                            <div class="form-group col-6"> 
                                                <label class="form-control-label text-secondary">PR Number:</label> 
                                                <input type="text" class="form-control" id="txtPRNumberForWipRemarks" name="PRNumberForWipRemarks" readonly>
                                                
                                                
                                            </div> 
                                            <div class="form-group col-6"> 
                                                <label class="form-control-label text-secondary">GR Number:</label> 
                                                <input type="text" class="form-control" id="txtGRNumberForWipRemarks" name="GRNumberForWipRemarks" readonly>
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col"> 
                                                <label class="form-control-label text-secondary">Remarks:</label> 
                                                <textarea class="form-control" name="RemarksForWip" id="txtRemarksForWip" rows="5"></textarea>
                                                
                                                
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    
                                    <div class="float-right">
                                        <button class="btn btn-default" id="cancel1"  data-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button id="btn-remarks-wip-save" class="btn btn-success">Save</button>
                                    </div>
                                        
                                        
                                </div>
                                
                            </form>

                            
                        </div>
                    </div>
                </div>

                {{-- MODAL FOR REWORK AND VISUAL --}}
                <div class="modal fade" id="reworkVisualModal" data-backdrop="static" style="overflow: auto;">
                    <div class="modal-dialog" style="width:100%; min-width: 750px;"> 
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Rework & Visual</h4>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">PR Number:</label> 
                                        <input type="text" class="form-control" id="reworkPRNumuberId" name="" readonly>
                                        
                                        
                                    </div> 
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">GR Number:</label> 
                                        <input type="text" class="form-control" id="reworkGRNumuberId" name="" readonly>
                                        
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                        <input type="text" class="form-control" id="reworkPartCodeId" name="" readonly>
                                        
                                        
                                    </div>
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                        <input type="text" class="form-control" id="reworkPartNameId" name="" readonly> 
                                    </div>
                                
                                </div>
                                <div class="row">
                                    <div class="form-group col">
                                        <label class="form-control-label text-secondary">Remarks:</label>
                                        <textarea class="form-control" name="" id="reworkRemarksId" rows="2" readonly style="resize: none"></textarea>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive mt-2">
                                            <table id="tbl-rework-visual-transaction" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Qty</th>
                                                        <th>Status</th>
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
                {{-- MODAL FOR TRASACTION OF REWORK VISUAL --}}
                <div class="modal fade" id="reworkVisualTransactionModal" data-backdrop="static" style="overflow: auto;">
                    <div class="modal-dialog" style="width:100%; min-width: 300px;"> 
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Rework & Visual Transaction</h4>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white">&times;</span>
                                </button>
                            </div>

                            <form id="formReworkVisualTransaction">
                                @csrf
                                <input type="hidden" id="reworkVisualTransactId" name="reworkVisualTransactId">
                                <input type="hidden" id="reworkVisualId" name="reworkVisualId">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-control-label text-secondary">Qty for Rework & Visual:</label> 
                                            <input type="text" class="form-control" id="reworkVisualQtyId" name="reworkVisualQty" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-control-label text-secondary">Rework NG:</label> 
                                            <input type="number" class="form-control"  id="reworkNGId" name="reworkNG" value="0" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-control-label text-secondary">Visual NG:</label> 
                                            <input type="number" class="form-control"  id="visualNGId" name="visualNG" value="0" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label class="form-control-label text-secondary" data-toggle="tooltip" data-placement="top" title="Automatic">Buyoff QTY:<i class="fas fa-exclamation-circle"></i></label> 
                                            <input type="text" class="form-control" id="buyoffQtyId" name="buyoffQty" readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <div>
                                        <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                                        <button id="btn-reworkvisualtrasactionid" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
                {{-- MODAL FOR TRASACTION OF REWORK VISUAL EDIT--}}
                <div class="modal fade" id="reworkVisualModalEdit" data-backdrop="static" style="overflow: auto;">
                    <div class="modal-dialog" style="width:100%; min-width: 300px;"> 
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h4 class="modal-title" style="color: white"><i class="fa fa-edit"></i> Edit</h4>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white">&times;</span>
                                </button>
                            </div>
                            <form id="formVisualEdit">
                                @csrf
                                <input type="hidden" name="reworkId" id="txtReworkId">
                                <div class="modal-body">
                                    

                                    <div class="row">
                                        <div class="form-group col-6"> 
                                            <label class="form-control-label text-secondary">PR Number:</label> 
                                            <input type="text" class="form-control" id="txtGRNumberForEdit" name="GRNumberForEdit" readonly>
                                            
                                            
                                        </div> 
                                        <div class="form-group col-6"> 
                                            <label class="form-control-label text-secondary">GR Number:</label> 
                                            <input type="text" class="form-control" id="txtPRNumberForEdit" name="PRNumberForEdit" readonly>
                                            
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col"> 
                                            <label class="form-control-label text-secondary">Remarks:</label> 
                                            <textarea class="form-control" name="RemarksForEdit" id="txtRemarksForEdit" rows="5"></textarea>
                                            
                                            
                                        </div> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div>
                                        <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                                        <button id="btn-rework-edit-save" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                


                {{-- MODAL FOR FGS --}}
                <div class="modal fade" id="FgsModal" data-backdrop="static" style="overflow: auto;">
                    <div class="modal-dialog" style="width:100%; min-width: 900px;"> 
                        <div class="modal-content">
                            <div class="modal-header bg-dark">
                                <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Buy-off</h4>
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color: white">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">PR Number:</label> 
                                        <input type="text" class="form-control" id="fgsPRId" name="fgsPr" readonly>
                                        
                                        
                                    </div> 
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">GR Number:</label> 
                                        <input type="text" class="form-control" id="fgsGRId" name="fgsGr" readonly>
                                        
                                        
                                    </div>
                                </div>
                                <div class="row">
                                 
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Code:</label> 
                                        <input type="text" class="form-control" id="fgsPartCodeId" name="fgs-part-code" readonly>
                                        
                                        
                                    </div>
                                    <div class="form-group col-6"> 
                                        <label class="form-control-label text-secondary">Part Name:</label> 
                                        <input type="text" class="form-control" id="fgsPartNameId" name="fgs-part-name" readonly> 
                                    </div>
                                
                                </div>
                                <div class="row">
                                    <div class="form-group col"> 
                                        <label class="form-control-label text-secondary">Remarks:</label> 
                                        {{-- <input type="text" class="form-control" id="fgsPartNameId" name="fgs-part-name" readonly>  --}}
                                        <textarea name="fgsRemarks" id="fgsRemarksId" rows="2" class="form-control" style="resize: none;" readonly></textarea>
                                    </div>
                                
                                </div>

                                
                                <hr class="row mt-0">

                                <input type="hidden"  id="transactionIdForFgsTable"> 
                                <input type="hidden"  id="transactionFkFgsIdForFgsTable"> 
                                {{-- <a id="collapse_id" class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="width: 100%;">
                                    <i class="fa fa-plus"></i>
                                    Add Transaction
                                    
                                    
                                </a> 
                         --}}
                                
                                 {{-- <div class="collapse" id="collapseExample"> 
                                    <div>

                                        <form id="" autocomplete="off">
                                            @csrf
                                             
    
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">Date:</label> 

                                                    <input type="date" name="trans_date" id="trans_date_id" class="form-control">

                                                </div>
                                            </div>
                                           
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">BOH:</label>
                                                    <input type="number" class="form-control" id="transaction-fgs-eoh-id" name="trans_boh" readonly>
                                                </div>
                                                
                                    
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">FGS OUT:</label>
                                                    <input type="number" class="form-control" id="trasaction-fgs-out-id" name="trans_b_out" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                               
                                                <div class="col-sm-4">
                                                    <label class="form-control-label text-secondary">Next EOH:</label>
                                                    <input type="number" class="form-control" id="transaction-next-fgs-eoh-id" name="trans_next_eoh" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <label class="form-control-label text-secondary">Remarks:</label>
                                                    <textarea class="form-control" name="trans-fgs-remarks" id="" rows="2" style="resize: none"></textarea>
                                                    
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <div class="float-right">
                                                        <button class="btn btn-default" id="btn-fgs-clear">Clear</button>
                                                        <button id="btn-transaction-fgs-save" class="btn btn-success">Save</button>
                                                    </div>
                                                
                                                </div>
                                            </div>
                                        </form>

                                        
                                        
                                    </div>
                                </div>  --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive mt-2">
                                            <table id="tbl-fgs-shipment-details" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>PO Number</th>
                                                        <th>Parts Code</th>
                                                        <th>Device Name</th>
                                                        <th>Qty to Shipout</th>
                                                        <th>Status</th>
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


                <div class="modal fade" id="modalFgsRemarks" data-backdrop="static">
                    <div class="modal-dialog" style="min-width: 600px;">
                        <div class="modal-content">
                            
                                <div class="modal-header bg-dark">
                                    <h4 class="modal-title" style="color: white"><i class="fa fa-edit"></i> Edit</h4>
                                    <button id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color: white">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formRemarksFgs">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="fgdId" id="txtFgsId">
    
                                            <div class="form-group col-6"> 
                                                <label class="form-control-label text-secondary">PR Number:</label> 
                                                <input type="text" class="form-control" id="txtGRNumberForFgsRemarks" name="GRNumberForFgsRemarks" readonly>
                                                
                                                
                                            </div> 
                                            <div class="form-group col-6"> 
                                                <label class="form-control-label text-secondary">GR Number:</label> 
                                                <input type="text" class="form-control" id="txtPRNumberForFgsRemarks" name="PRNumberForFgrRemarks" readonly>
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col"> 
                                                <label class="form-control-label text-secondary">Remarks:</label> 
                                                <textarea class="form-control" name="RemarksForFgs" id="txtRemarksForFgs" rows="5"></textarea>
                                                
                                                
                                            </div> 
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    
                                    <div class="float-right">
                                        <button class="btn btn-default" id="cancel1"  data-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button id="btn-remarks-fgs-save" class="btn btn-success">Save</button>
                                    </div>
                                        
                                        
                                </div>
                                
                            </form>

                            
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="FgsAcceptModal" data-backdrop="static">
                    <div class="modal-dialog" style="min-width: 600px;">
                        <div class="modal-content">
                            
                                <div class="modal-header bg-dark">
                                    <h4 class="modal-title" style="color: white"><i class="fa fa-list"></i> Buy-off Transactions</h4>
                                    <button id="cancel" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color: white">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-control-label text-secondary">Part Code:</label> 
                                            <input type="text" id="trans_pcode" class="form-control" readonly>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-control-label text-secondary">Part Name:</label> 
                                            <input type="text" id="trans_pname" class="form-control" readonly>
                                        </div>  
                                        <div class="col-4">
                                            <label class="form-control-label text-secondary">Qty to Shipout:</label> 
                                            <input type="text" id="trans_qtyship" class="form-control" readonly>
                                        </div>  
                                    </div>
                                    <hr>
                            <form id="formTransactionFgs" autocomplete="off">
                                        @csrf
                                         
                                        <input type="hidden" id="shipout_id" name="idshipout">
                                        <input type="hidden" id="fgs_id" name="fgsId">
                                        <input type="hidden" id="fgs_pr" name="fgsPr">
                                        <input type="hidden" id="fgs_gr" name="fgsGr">
                                        <input type="hidden" id="fk_fgs_id" name="FkfgsId">
                                        <input type="hidden" id="trans_qtytoship" name="trans_qtytoship">
                                        <input type="hidden" id="fgs_remarks" name="fgs_remarks">


                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="form-control-label text-secondary">Date:</label> 
        
                                                <input type="date" name="trans_fgs_date" id="trans_fgs_date_id" class="form-control">
        
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="form-control-label text-secondary">BOH:</label>
                                                <input type="number" class="form-control" id="transaction-fgs-eoh-id" name="trans_fgs_boh" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-control-label text-secondary">Grinded Items OUT:</label>
                                                <input type="number" class="form-control" id="trasaction-fgs-out-id" name="trans_fgs_out" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                            {{-- <div class="col-sm-3">
                                                <label class="form-control-label text-secondary">Golden Sample:</label>
                                                <input type="number" class="form-control" id="transaction-fgs-gsamp-id" name="trans_fgs_gsamp" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="golden_sample" name="golden_sample">
                                                    <label class="form-check-label" for="golden_sample">
                                                        Golden Sample
                                                    </label>
                                                </div>
                                            </div> --}}
                                           
                                            <div class="col-sm-4">
                                                <label class="form-control-label text-secondary">Next EOH:</label>
                                                <input type="number" class="form-control" id="transaction-next-fgs-eoh-id" name="trans_fgs_next_eoh" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label class="form-control-label text-secondary">Remarks:</label>
                                                <textarea class="form-control" name="trans_fgs_remarks" id="trans_fgs_remarks" rows="2" style="resize: none"></textarea>
                                                
                                            </div>
                                        </div>
                                        
                                </div>
                                <div class="modal-footer">
                                    
                                    <div class="float-right">
                                        <button class="btn btn-default" id="cancel1"  data-dismiss="modal" aria-label="Close">Cancel</button>
                                        <button id="btn-transaction-fgs-save" class="btn btn-success">Save</button>
                                    </div>
                                        
                                        
                                </div>
                                
                            </form>

                            
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="loadMe" data-backdrop="static" role="dialog" aria-labelledby="loadMeLabel">
                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-body text-center">
                          <div class="loader"></div>
                        
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
    // setInterval(check, 1000);
    // check();

    // function check(){
    //     $.ajax({
    //         url: 'get_fgs_info',
    //         method: 'get',
    //         data: {
    //             fgsId : fgsId,
    //         },
    //         dataType: 'json',
    //         success: function(response){
               
    //         },
    //     });
    // }


    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();   



        dataTableListAssetWip = $("#tbl-list-asset-wip").DataTable({
            "processing" : true,
            "ordering": false,
            "serverSide" : true,

            "ajax" : {
                url: "get_wip_basemold",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                // { "data" : "id"},
                { "data" : "basemold.code"},
                { "data" : "basemold.part_name"},
                { "data" : "PR_number"},
                { "data" : "GR_number"},
                { "data" : "EOH"},
                // { "data" : "pr_number"},
                // { "data" : "code"},
                // { "data" : "part_name"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

        
        dataTableListAssetFgs = $("#tbl-list-asset-fgs").DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url: "get_fgs_details",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                // { "data" : "id"},
                { "data" : "fgs_details.fgs_code"},
                { "data" : "fgs_details.fgs_name"},
                { "data" : "PR_number"},
                { "data" : "GR_number"},
                { "data" : "EOH"},
                // { "data" : "pr_number"},
                // { "data" : "code"},
                // { "data" : "part_name"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

        dataTableListAssetReworkVisual = $("#tbl-list-asset-rework-visual").DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url: "get_rework_visual_details",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                // { "data" : "id"},
                { "data" : "fgs_details.fgs_code"},
                { "data" : "fgs_details.fgs_name"},
                { "data" : "PR_number"},
                { "data" : "GR_number"},
                { "data" : "EOH"},
                // { "data" : "pr_number"},
                // { "data" : "code"},
                // { "data" : "part_name"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });
        
        dataTableFgsShipmentDetails = $("#tbl-fgs-shipment-details").DataTable({
            "processing" : true,
            "serverSide" : true,
            "ordering": false,
            "deferLoading": 57,
            "ajax" : {
                url: "getFgsShipment",
                data: function (param){
                    param.fgsPRId =  $('#fgsPRId').val();
                    param.fgsGRId = $('#fgsGRId').val();
                    param.fgsPartCodeId = $('#fgsPartCodeId').val();
                    param.fgsPartNameId =  $('#fgsPartNameId').val();
                    param.transactionIdForFgsTable =  $('#transactionIdForFgsTable').val();
                }
            },
            "columns":[    
                { "data" : "date"},
                { "data" : "PONo"},
                { "data" : "Partscode"},
                { "data" : "DeviceName"},
                { "data" : "Qty"},
                // { "data" : "basemold_OUT"},
                // { "data" : "basemold_EOH"},
                { "data" : "status"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });

        dataTableReworkVisualTransaction = $("#tbl-rework-visual-transaction").DataTable({
            "processing" : true,
            "serverSide" : true,
            // "order": [[ 0, "desc" ]],
            "ordering": false,
            // "columnDefs" : [ {
            //     targets: [ 0 ],
            //     orderData: [ 1, 0 ]
            // }, ],
            "ajax" : {
                url: "get_rework_visual_transaction",
                data: function (param){
                    param.reworkPRNumuberId =  $('#reworkPRNumuberId').val();
                    param.reworkGRNumuberId = $('#reworkGRNumuberId').val();
                    param.reworkPartCodeId = $('#reworkPartCodeId').val();
                    param.reworkPartNameId =  $('#reworkPartNameId').val();
                    // param.transactionIdForFgsTable =  $('#transactionIdForFgsTable').val();
                }

            },
            "columns":[    
                { "data" : "date"},
                { "data" : "rework_visual_info.fgs_rework_IN"},
                // { "data" : "Partscode"},
                // { "data" : "DeviceName"},
                // { "data" : "remarks"},
                // // { "data" : "basemold_OUT"},
                // // { "data" : "basemold_EOH"},
                { "data" : "status"},
                // // // { "data" : "lot_no"},
                // // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });
        $(document).on('click', '.btn-basemold-wip', function(){
            let wipBasemoldId = $(this).attr('wip-basemold-id');
            getWipBasemoldInfo(wipBasemoldId);
            // console.log(wipBasemoldId);
            // getDataForTransaction(wipBasemoldId);
        });

        $(document).on('click', '.btn-fgs', function(){
            let fgsId = $(this).attr('fgs-id');
            getFgsInfo(fgsId);
            checkRapidTransaction(fgsId);
            $("#loadMe").modal("show");

            setTimeout(function() {
                $("#loadMe").modal("hide");
                $("#FgsModal").modal("show");
            }, 1000);
            // console.log(fgsId);
            // getDataForTransaction(wipBasemoldId);
        });

        $(document).on('click', '.btn-rework-visual', function(){
            let reworkVisualId = $(this).attr('rework-visual-id');
            getReworkVisualInfo(reworkVisualId);

            // console.log(reworkVisualId);
            // getDataForTransaction(wipBasemoldId);
        });
        $(document).on('click', '.btn-rework-visual-edit', function(){
            let reworkVisualForEditId = $(this).attr('rework-visual-id');
            getReworkVisualInfoForEdit(reworkVisualForEditId);

            // console.log(reworkVisualForEditId);
            // getDataForTransaction(wipBasemoldId);
        });
        

        // FUNCTION FOR REWORK & VISUAL TRANSACTION 
        $(document).on('click', '.btn-visual-rework-transact', function(){
            let reworkVisualTransactId = $(this).attr('rework-visual-transact-id');
            $('#reworkVisualTransactId').val(reworkVisualTransactId);

            // console.log(reworkVisualTransactId);
            getDataForReworkVisualTransaction(reworkVisualTransactId);
        });




        $('#trasaction-out-id').on('keyup', function(){
            let out = $(this).val();
            let eoh = $('#transaction-eoh-id').val();
            let subtract = eoh-out;
            $('#transaction-next-eoh-id').val(subtract);
        });

        // for auto computation for basemold transaction QTY Reworks & visual
        $('#grinded-items-in-id, #trans-grinded-ng-id, #trans-grinded-gsamp-id').on('keyup', function(){
            let grindedNG = 0, grindedGsamp = 0, grindedIn = 0;
            if($('#grinded-items-in-id').val() == ""){
                grindedIn = 0;
            }
            else{
                grindedIn = parseInt($('#grinded-items-in-id').val());
            }
            if($('#trans-grinded-ng-id').val() == ""){
                grindedNG = 0;
            }
            else{
                grindedNG = parseInt($('#trans-grinded-ng-id').val());
            }
            if($('#trans-grinded-gsamp-id').val() == ""){
                grindedGsamp = 0;
            }
            else{
                grindedGsamp = parseInt($('#trans-grinded-gsamp-id').val());
            }

            let reworkVisualValue = grindedIn-grindedNG-grindedGsamp;
            $('#trans-fgs-in-id').val(reworkVisualValue);
        });

        //AUTO CALCULATION OF REWORK AND VISUAL TRANSACTION
        $('#reworkNGId, #visualNGId').on('keyup', function(){
            let reworkNg =0, visualNg = 0;

            let reworkVisualQty = parseInt($('#reworkVisualQtyId').val());

            if($('#reworkNGId').val() != ""){
                reworkNg = parseInt($('#reworkNGId').val());
            }
            if( $('#visualNGId').val() != ""){
                visualNg = parseInt($('#visualNGId').val());
            }

            let Ng = reworkNg + visualNg;

            let forBuyoff = reworkVisualQty - Ng;

            $('#buyoffQtyId').val(forBuyoff);
        });
      
        //AUTO CALCULATION OF FGS TRANSACTION
        $('#trasaction-fgs-out-id, #transaction-fgs-gsamp-id').on('keyup', function(){
            var out = 0, gsamp = 0, calc = 0, subtract = 0;
            let eoh = $('#transaction-fgs-eoh-id').val();

            if($('#trasaction-fgs-out-id').val() == ''){
                var out = 0;
                var subtract = eoh-out;

            }
            else{
               
                var out = parseInt( $('#trasaction-fgs-out-id').val() );
                var subtract = eoh-out;

            }
            if($('input[name="golden_sample"]').prop("checked") == true){
                if($('#transaction-fgs-gsamp-id').val() == ''){
                    let gsamp = 0;
                    let calc = gsamp + out;
                    var subtract = eoh-calc;
                    $('#transaction-next-fgs-eoh-id').val(subtract);
                }
                else{
                    let gsamp = parseInt($('#transaction-fgs-gsamp-id').val());
                    let calc = gsamp + out;
                    let subtract = eoh-calc;
                    $('#transaction-next-fgs-eoh-id').val(subtract);
                }
            }
            else{
                $('#transaction-next-fgs-eoh-id').val(subtract);

            }

        });

        $('#btn-transaction-save').on('click', function(event){
            event.preventDefault();
            
            wipTransaction();
        })
        $('#btn-wip-clear').on('click', function(event){
            event.preventDefault();
            $('#formTransactionWip')[0].reset();
            var id = $('#transactionIdForTable').val();
            // console.log(id);
            getWipBasemoldInfo(id);

        })

        
        $('#trans_fgs_code_id').on('keyup', function(){
            getFgsCode($('.fgs_code'));
            var code = $('#trans_fgs_code_id').val();
            // console.log(code);
            getFgsName(code);
        });
        $('#collapse_id').on('click',function(){
            var id = $('#transactionIdForTable').val();
            // console.log(id);
            getWipBasemoldInfo(id);

        });

        //FOR CHECKBOX OF FGS GOLDEN SAMPLE
        $('input[name="golden_sample"]').click(function(){
            if($(this).prop("checked") == true){
                // console.log("Checkbox is checked.");
                $('#transaction-fgs-gsamp-id').prop('readonly',false);
            }
            else if($(this).prop("checked") == false){
                $('#transaction-fgs-gsamp-id').prop('readonly',true);

                $('#transaction-fgs-gsamp-id').val('')
            }
        });


       
        $(document).on('click', '.btn-fgs-accept', function(){
            let fgsShipoutId = $(this).attr('shipout-id');
            let fgsId = $('#transactionIdForFgsTable').val();
            let fkFgsId = $('#transactionFkFgsIdForFgsTable').val();
            let fgsPRId = $('#fgsPRId').val();
            let fgsGRId = $('#fgsGRId').val();
            
            
            getFgsInfoForTransaction(fgsId,fgsShipoutId);

            $('#shipout_id').val(fgsShipoutId);
            $('#fk_fgs_id').val(fkFgsId);
            $('#fgs_id').val(fgsId);
            $('#fgs_pr').val(fgsPRId);
            $('#fgs_gr').val(fgsGRId);
            
        });

        $('#btn-transaction-fgs-save').on('click', function(event){
            event.preventDefault();
            insertFgsTransaction();
            
        });

        $('#cancel, #cancel1').on('click', function(){
            $('#formTransactionFgs')[0].reset();
        });

      
        $('#btn-reworkvisualtrasactionid').on('click', function(event){
            event.preventDefault();
            reworkVisualTransaction();

        });
        $('#btn-rework-edit-save').on('click', function(event){
            event.preventDefault();
            reworkVisualEdit();
           

        });
        
        $(document).on('click','.btn-fgs-remarks', function(){
            let fgsId = $(this).attr('fgs-id');
            
            getFgsDetails(fgsId);
        });

        $('#btn-remarks-fgs-save').on('click', function(event){
            event.preventDefault();
            addRemarksFgs();
        })

        $(document).on('click', '.btn-wip-remarks', function(){
            // console.log('test');
            let wipId = $(this).attr('wip-basemold-id');

            getWipDetails(wipId);
        });

        $('#btn-remarks-wip-save').on('click', function(event){
            event.preventDefault();
            addRemarksWip();
        });
        


    });




</script>

@endsection

@endsection
