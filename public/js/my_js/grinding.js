function acceptBasemold(){

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };


    // var inputBasemoldInfo = $('#formBasemoldTransaction').serialize();
    $.ajax({
        url: "accept_basemold",
        method: "post",
        data: $('#formApprovalBasemoldId').serialize(),
        dataType: "json",
        beforeSend: function(){
            
            $("#submit").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['result'] == 1){
                $('#approveBasemoldModal').modal('hide');
                $('#modalViewBasemoldDetails').modal('hide');
                $('#modalAcceptBasemoldDetails').modal('hide');

                $('#recievedRemarksId').val("");
                dataTableBasemoldGrinding.draw();

                toastr.success('Basemold Accepted');
                $("#submit").removeAttr('disabled');




            }
            else{
                toastr.error('Failed! Contact Administrator');
                $("#submit").removeAttr('disabled');


            }

            // console.log(response);

        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function disapproveBasemold(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "disapprove_basemold",
        method: "post",
        data: $('#formDisapproveBasemoldId').serialize(),
        dataType: "json",
       
        success: function(response){
            // if(response['result'] == 1){
            //     toastr.success('Basemold Successfully Not Accepted');
                
            //     $('#disapproveBasemoldModal').modal('hide');
            //     dataTableBasemold.draw();

            // }
            if(response['validation'] == 'hasError'){
                toastr.error('Disapproval of Basemold Fail!');

                if(response['error']['recievedDisRemarks'] === undefined){
                    $("#recievedDisRemarksId").removeClass('is-invalid');
                    $("#recievedDisRemarksId").attr('title', '');
                }
                else{
                    $("#recievedDisRemarksId").addClass('is-invalid');
                    $("#recievedDisRemarksId").attr('title', response['error']['recievedDisRemarks']);
                }
            }
            else{
                if(response['result'] == 1){
                    toastr.success('Basemold Successfully Not Accepted');
                
                    $('#disapproveBasemoldModal').modal('hide');
                    $('#modalAcceptBasemoldDetails').modal('hide');
                    
                    dataTableListAssetWip.draw();



                }

            }

        },
        // error: function(data, xhr, status){
        //     toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        //     $("#iBtnEditUserIcon").removeClass('fa fa-spinner fa-pulse');
        //     $("#btnEditUser").removeAttr('disabled');
        //     $("#iBtnEditUserIcon").addClass('fa fa-check');
        // }
    });
}


function getWipBasemoldInfo(wipBasemoldId){
    $.ajax({
        url: "getWipBasemoldInfo",
        method: "get",
        data: {
            wipBasemoldId : wipBasemoldId
        },
        dataType: "json",
       
        success: function(response){
            console.log(response);

            if(response['count'] == 0){
                console.log('not')
                $('#asd').remove();
                $('#wipBasemoldPartCodeId').val(response['result'][0]['basemold']['code']);
                $('#wipBasemoldPartNameId').val(response['result'][0]['basemold']['part_name']);
                $('#wipBasemoldPRId').val(response['result'][0]['PR_number']);
                $('#wipBasemoldGRId').val(response['result'][0]['GR_number']);
                $('#setupRemarksId').val(response['result'][0]['remarks']);


                $('#transBasemoldPartCodeId').val(response['result'][0]['basemold']['code']);
                $('#transBasemoldPartNameId').val(response['result'][0]['basemold']['part_name']);
                $('#transBasemoldPartCodeId1').val("");
                $('#transBasemoldPartNameId1').val("");

                $('#transBasemoldGRId').val(response['result'][0]['GR_number']);
                $('#transBasemoldPRId').val(response['result'][0]['PR_number']);
                $('#transBasemoldId').val(response['result'][0]['basemold']['id']);
                $('#transBasemoldId').val(response['result'][0]['basemold']['id']);
                $('#transactionIdForTable').val(response['result'][0]['id']);
                $('#transactionIdForTable1').val("");
                $('#transaction-eoh-id').val(response['result'][0]['EOH']);
                $('#transaction-next-eoh-id').val(response['result'][0]['EOH']);


                
                $('#trans_fgs_code_id').val(response['code_part'][0]['ItemCode']);
                $('#trans_fgs_name_id').val(response['code_part'][0]['ItemName']);
                // trans_fgs_code_id
                // trans_fgs_name_id
            }
            else{
                console.log('glued');

                $('#asd').remove();
                $('#wipBasemoldPartCodeId').val(response['glued'][0]['basemold']['code']);
                $('#wipBasemoldPartNameId').val(response['glued'][0]['basemold']['part_name']);
                $('#wipBasemoldPRId').val(response['glued'][0]['PR_number']);
                $('#wipBasemoldGRId').val(response['glued'][0]['GR_number']);
                $('#setupRemarksId').val(response['glued'][0]['remarks']);
                


                $('#transBasemoldPartCodeId').val(response['glued'][0]['basemold']['code']);
                $('#transBasemoldPartNameId').val(response['glued'][0]['basemold']['part_name']);
                //ASSIGNING VALUE FOR GLUED MATERIAL
                $('#transBasemoldPartCodeId1').val(response['glued'][1]['basemold']['code']);
                $('#transBasemoldPartNameId1').val(response['glued'][1]['basemold']['part_name']);

                $('#transBasemoldGRId').val(response['glued'][0]['GR_number']);
                $('#transBasemoldPRId').val(response['glued'][0]['PR_number']);
              

                $('#trans_fgs_code_id').val(response['code_part'][0]['ItemCode']);
                $('#trans_fgs_name_id').val(response['code_part'][0]['ItemName']);
                

                $('#transBasemoldId').val(response['glued'][0]['basemold']['id']);
                $('#transBasemoldId1').val(response['glued'][1]['basemold']['id']);

                $('#transactionIdForTable').val(response['glued'][0]['id']);
                $('#transactionIdForTable1').val(response['glued'][1]['id']);
                let gluedEOH = parseInt(response['glued'][0]['EOH']) + parseInt(response['glued'][1]['EOH']);
                $('#transaction-eoh-id').val(gluedEOH);
                $('#transaction-next-eoh-id').val(gluedEOH);



                var labels = "";
                labels += "<div class='row' id='asd'>"
                labels += "<div class='form-group col-6'>";
                labels += "<input type='text' class='form-control' value='"+response['glued'][1]['basemold']['code']+"' readonly>";
                labels +="</div>";
                labels += "<div class='form-group col-6'>";
                labels += "<input type='text' class='form-control' value='"+response['glued'][1]['basemold']['part_name']+"' readonly>";
                labels +="</div>";
                labels +="</div>";

                $('#divGlued').append(labels);
            }

             
            // $('#wipBasemoldPartCodeId').val(response['result'][0]['basemold']['code']);
            // $('#wipBasemoldPartNameId').val(response['result'][0]['basemold']['part_name']);
            // $('#wipBasemoldPRId').val(response['result'][0]['PR_number']);
            // $('#wipBasemoldGRId').val(response['result'][0]['GR_number']);


            // $('#transBasemoldPartCodeId').val(response['result'][0]['basemold']['code']);
            // $('#transBasemoldPartNameId').val(response['result'][0]['basemold']['part_name']);
            // $('#transBasemoldGRId').val(response['result'][0]['GR_number']);
            // $('#transBasemoldPRId').val(response['result'][0]['PR_number']);
            // $('#transBasemoldId').val(response['result'][0]['basemold']['id']);
            // $('#transBasemoldId').val(response['result'][0]['basemold']['id']);
            // $('#transactionIdForTable').val(response['result'][0]['id']);
            // $('#transaction-eoh-id').val(response['result'][0]['EOH']);
            // $('#transaction-next-eoh-id').val(response['result'][0]['EOH']);



            

            
            
            
            // $('#wipBasemoldId').val(response['result'][0]['id']);
            // dataTableWipTransactionDetails.draw();
            // dataTablePreshipmentList.draw();

           

        },
      
    });
}



function wipTransaction(){
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "wipTransaction",
        method: "post",
        data: $('#formTransactionWip').serialize(),
        dataType: "json",
        beforeSend: function(){
            
            $("#btn-transaction-save").prop('disabled', 'disabled');
        },
        success: function(response){
            
            // console.log(response);

        

            if(response['validation'] == 'hasError'){
                toastr.error('Adding Transaction Fail!');
                if(response['error']['trans_date'] === undefined){
                    $("#trans_date_id").removeClass('is-invalid');
                    $("#trans_date_id").attr('title', '');
                }
                else{
                    $("#trans_date_id").addClass('is-invalid');
                    $("#trans_date_id").attr('title', response['error']['trans_date_id']);
                }
                if(response['error']['trans_fgs_code'] === undefined){
                    $("#trans_fgs_code_id").removeClass('is-invalid');
                    $("#trans_fgs_code_id").attr('title', '');
                }
                else{
                    $("#trans_fgs_code_id").addClass('is-invalid');
                    $("#trans_fgs_code_id").attr('title', response['error']['trans_fgs_code']);
                }
                if(response['error']['trans_fgs_name'] === undefined){
                    $("#trans_fgs_name_id").removeClass('is-invalid');
                    $("#trans_fgs_name_id").attr('title', '');
                }
                else{
                    $("#trans_fgs_name_id").addClass('is-invalid');
                    $("#trans_fgs_name_id").attr('title', response['error']['trans_fgs_name']);
                }
                if(response['error']['trans_b_out'] === undefined){
                    $("#trasaction-out-id").removeClass('is-invalid');
                    $("#trasaction-out-id").attr('title', '');
                }
                else{
                    $("#trasaction-out-id").addClass('is-invalid');
                    $("#trasaction-out-id").attr('title', response['error']['trans_b_out']);
                }
                if(response['error']['trans_fgs_in'] === undefined){
                    $("#trans-fgs-in-id").removeClass('is-invalid');
                    $("#trans-fgs-in-id").attr('title', '');
                }
                else{
                    $("#trans-fgs-in-id").addClass('is-invalid');
                    $("#trans-fgs-in-id").attr('title', response['error']['trans_fgs_in']);
                }
                $("#btn-transaction-save").removeAttr('disabled');

               
            }
            else if(response['result'] == 0){
                toastr.error('Basemold OUT Invalid!');  
                $("#trasaction-out-id").addClass('is-invalid');
                
                $("#btn-transaction-save").removeAttr('disabled');


            }
            else if(response['result'] == 1 ){
                
                toastr.success('Transaction Successful');
                $('#formTransactionWip')[0].reset();
                
                // dataTableWipTransactionDetails.draw();
                dataTableListAssetReworkVisual.draw();
                dataTableListAssetWip.draw();
                // resetEoh();
                // $('.collapse').collapse('hide');
                $('#WipBasemoldModal').modal('hide')
                



                $("#trans_date_id").removeClass('is-invalid');
                $("#trans_fgs_code_id").removeClass('is-invalid');
                $("#trans_fgs_name_id").removeClass('is-invalid');
                $("#trasaction-out-id").removeClass('is-invalid');
                $("#trans-fgs-in-id").removeClass('is-invalid');

                $("#btn-transaction-save").removeAttr('disabled');


            }

        },
      
    });
}

function getFgsCode(cboElement){
    $.ajax({
        url: 'get_fgs_code',
        method: 'get',
        dataType: 'json',
        success: function(JsonObject){
            // console.log(JsonObject);
            // console.log(JsonObject);
            // result = '<option  value="'+JsonObject['result']+'">';
            // cboElement.html(result);
            
            result = '';
            if(JsonObject['result'].length > 0){
                result = '<option value="0" selected disabled>--Select--</option>';
                for(let index = 0; index < JsonObject['result'].length; index++){
                    
                    result += '<option value="' + JsonObject['result'][index].fgs_code + '">';
                }
            }
        
            cboElement.html(result);

        },
    });
}

function getFgsName(code){
    $.ajax({
        url: 'get_fgs_name',
        method: 'get',
        data: {
            code : code,
        },
        dataType: 'json',
        success: function(response){
            // console.log(response['result'].length);
            if(response['result'].length != 0){
                $('#trans_fgs_name_id').val(response['result'][0]['fgs_name']);
            }
            else{
                $('#trans_fgs_name_id').val("");

            }

        },
    });
}


function getFgsInfo(fgsId){

    $.ajax({
        url: 'get_fgs_info',
        method: 'get',
        data: {
            fgsId : fgsId,
            
        },
        dataType: 'json',
        success: function(response){
            console.log(response);

            $('#fgsPartCodeId').val(response['result'][0]['fgs_details']['fgs_code']);
            $('#fgsPartNameId').val(response['result'][0]['fgs_details']['fgs_name']);
            $('#fgsPRId').val(response['result'][0]['PR_number']);
            $('#fgsGRId').val(response['result'][0]['GR_number']);

            $('#transactionIdForFgsTable').val(response['result'][0]['id']);
            $('#transactionFkFgsIdForFgsTable').val(response['result'][0]['fk_fgs_id']);
            $('#transaction-fgs-eoh-id').val(response['result'][0]['EOH'])
            $('#transaction-next-fgs-eoh-id').val(response['result'][0]['EOH']);

            $('#fgsRemarksId').val(response['result'][0]['remarks']);


        },
    });
}

function getFgsInfoForTransaction(fgsId,fgsShipoutId, fgsPRId, fgsGRId){

    $.ajax({
        url: 'get_fgs_info_for_transaction',
        method: 'get',
        data: {
            fgsId : fgsId,
            fgsShipoutId : fgsShipoutId,
            fgsPR : fgsPRId,
            fgsGR : fgsGRId
        },
        dataType: 'json',
        success: function(response){

            $('#trans_pcode').val(response['result'][0]['fgs_details']['fgs_code']);
            $('#trans_pname').val(response['result'][0]['fgs_details']['fgs_name']);
            $('#trans_qtyship').val(response['shipout'][0]['Qty']);
            $('#trans_qtytoship').val(response['shipout'][0]['Qty']);

            $('#transactionIdForFgsTable').val(response['result'][0]['id']);
            $('#transactionFkFgsIdForFgsTable').val(response['result'][0]['fk_fgs_id']);
            $('#transaction-fgs-eoh-id').val(response['result'][0]['EOH'])
            $('#transaction-next-fgs-eoh-id').val(response['result'][0]['EOH']);

            $('#fgs_remarks').val(response['result'][0]['remarks']);


        },
    });
}





function checkRapidTransaction(fgsId){
    // console.log('asd');
    $.ajax({
        url: 'get_shipout',
        method: 'get',
        data: {
            fgsId : fgsId,
        },
        dataType: 'json',
        beforeSend: function(){
            $('#tbl-fgs-shipment-details tbody').empty();
        },
        success: function(response){
            console.log(response);
            
            dataTableFgsShipmentDetails.draw();
         
        },
    });
}

function insertFgsTransaction(){
    // console.log('qwe');
    $.ajax({
        url: 'insert_fgs_transaction',
        method: 'post',
        data: $('#formTransactionFgs').serialize(),
        dataType: 'json',
        beforeSend: function(){
            // $("#iBtnPaidIcon").addClass('fa fa-spinner fa-pulse');
            $("#btn-transaction-fgs-save").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Transaction Failed');
                if(response['error']['trans_fgs_date'] === undefined){
                    $("#trans_fgs_date_id").removeClass('is-invalid');
                    $("#trans_fgs_date_id").attr('title', '');
                }
                else{
                    $("#trans_fgs_date_id").addClass('is-invalid');
                    $("#trans_fgs_date_id").attr('title', response['error']['trans_fgs_date']);
                }
                if(response['error']['trans_fgs_out'] === undefined){
                    $("#trasaction-fgs-out-id").removeClass('is-invalid');
                    $("#trasaction-fgs-out-id").attr('title', '');
                }
                else{
                    $("#trasaction-fgs-out-id").addClass('is-invalid');
                    $("#trasaction-fgs-out-id").attr('title', response['error']['trans_fgs_out']);
                }
                $("#btn-transaction-fgs-save").removeAttr('disabled');

            }
            else if(response['result'] == '0'){
                toastr.error('Transaction Failed');

                    // $("#transaction-fgs-gsamp-id").removeClass('is-invalid');
                $("#trans_fgs_remarks").addClass('is-invalid');
                $("#trans_fgs_remarks").attr('title', '');
                $("#btn-transaction-fgs-save").removeAttr('disabled');

            }
            else{
                dataTableFgsShipmentDetails.draw();
                dataTableListAssetFgs.draw();
                $('#FgsAcceptModal').modal('hide');
                $('#FgsModal').modal('hide');
                $('#formTransactionFgs')[0].reset();
                toastr.success('Transaction Successful');

                $("#trans_fgs_date_id").removeClass('is-invalid');
                $("#trasaction-fgs-out-id").removeClass('is-invalid');
                $("#btn-transaction-fgs-save").removeAttr('disabled');


            }
         
        },
    });
}


function getReworkVisualInfo(reworkVisualId){
    // console.log(reworkVisualId);
    $.ajax({
        url: 'get_rework_visual_info_by_id',
        method: 'get',
        data: {
            reworkVisualId : reworkVisualId,
        },
        dataType: 'json',
        success: function(response){
            console.log(response);
            $('#reworkPRNumuberId').val(response['result'][0]['PR_number']);
            $('#reworkGRNumuberId').val(response['result'][0]['GR_number']);
            $('#reworkPartCodeId').val(response['result'][0]['fgs_details']['fgs_code']);
            $('#reworkPartNameId').val(response['result'][0]['fgs_details']['fgs_name']);
            $('#reworkRemarksId').val(response['result'][0]['remarks']);
            
            $('#reworkVisualId').val(response['result'][0]['id']);
            $('#reworkPR').val(response['result'][0]['PR_number']);
            $('#reworkGR').val(response['result'][0]['GR_number']);

            dataTableReworkVisualTransaction.draw();

        },
    });
}

function getDataForReworkVisualTransaction(reworkVisualTransactId){
    // console.log(reworkVisualTransactId);
    $.ajax({
        url: 'get_data_for_rework_visual_transaction',
        method: 'get',
        data: {
            reworkVisualTransactId : reworkVisualTransactId,
        },
        dataType: 'json',
        success: function(response){
        //    console.log(response);

            $('#reworkVisualQtyId').val(response['result'][0]['rework_visual_info']['fgs_rework_IN']);
            
            
        },
    });
}

function reworkVisualTransaction(){
    $.ajax({
        url: 'inset_rework_visual_transaction',
        method: 'post',
        data: $('#formReworkVisualTransaction').serialize(),
        dataType: 'json',
        beforeSend: function(){
            $("#btn-reworkvisualtrasactionid").prop('disabled', 'disabled');
        },
        success: function(response){
            if(response['result'] == 0){
                toastr.error('Transaction Failed');
                $("#btn-reworkvisualtrasactionid").removeAttr('disabled');

            }
            else{
                $('#reworkVisualModal').modal('hide');
                $('#reworkVisualTransactionModal').modal('hide');
                $('#formReworkVisualTransaction')[0].reset();
                toastr.success('Transaction Successful');
                dataTableListAssetReworkVisual.draw();
                dataTableListAssetFgs.draw();
                $("#btn-reworkvisualtrasactionid").removeAttr('disabled');
            }
           

            

        },
    });
}

function getReworkVisualInfoForEdit(reworkVisualForEditId){
    $.ajax({
        url: 'get_rework_visual_info_for_edit',
        method: 'get',
        data: {
            reworkVisualForEditId : reworkVisualForEditId,
        },
        dataType: 'json',
        success: function(response){

            // console.log(response);
            $('#txtGRNumberForEdit').val(response['result'][0]['GR_number']);
            $('#txtPRNumberForEdit').val(response['result'][0]['PR_number']);
            $('#txtRemarksForEdit').val(response['result'][0]['remarks'])
            $('#txtReworkId').val(response['result'][0]['id']);
            


        },
    });
}

function reworkVisualEdit(){
    $.ajax({
        url: 'insert_rework_visual_edit',
        method: 'post',
        data: $('#formVisualEdit').serialize(),
        dataType: 'json',
        success: function(response){
            toastr.success('Successfully Added!');
            $('#formVisualEdit')[0].reset();
            $('#reworkVisualModalEdit').modal('hide');
        },
    });
}


function getFgsDetails(fgsId){
   
    $.ajax({
        url: 'get_fgs_details_for_remarks',
        method: 'get',
        data:{
            fgsId:fgsId 
        },
        dataType: 'json',
        success: function(response){
            // console.log(response);
            
            $('#txtFgsId').val(response['result'][0]['id']);

            $('#txtGRNumberForFgsRemarks').val(response['result'][0]['GR_number']);
            $('#txtPRNumberForFgsRemarks').val(response['result'][0]['PR_number']);
            $('#txtRemarksForFgs').val(response['result'][0]['remarks']);

            

        },
    });
}

function addRemarksFgs(){
  
    $.ajax({
        url: 'add_remarks_fgs',
        method: 'post',
        data: $('#formRemarksFgs').serialize(),
        dataType: 'json',
        success: function(response){
            toastr.success('Buyoff Successfully Edited');
            $('#modalFgsRemarks').modal('hide');
        },
    });
}


function getWipDetails(wipId){
    $.ajax({
        url: 'get_wip_details_for_remarks',
        method: 'get',
        data: {
            wipId : wipId,
        },
        dataType: 'json',
        success: function(response){
            $('#txtGRNumberForWipRemarks').val(response['widDetails'][0]['GR_number']);
            $('#txtPRNumberForWipRemarks').val(response['widDetails'][0]['PR_number']);
            $('#txtRemarksForWip').val(response['widDetails'][0]['remarks']);
            $('#txtWipId').val(response['widDetails'][0]['id']);
        },
    });
}

function addRemarksWip(){
    $.ajax({
        url: 'add_remarks_wip',
        method: 'post',
        data: $('#formRemarksWip').serialize(),
        dataType: 'json',
        success: function(response){
            toastr.success('Set-up Successfully Edited');
            $('#WipBasemoldRemarks').modal('hide');
        },
    });
}

