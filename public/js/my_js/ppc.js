function addBasemold(){
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
    // console.log($('#addBasemoldId').serialize());
    $.ajax({
        url: "add_basemold",
        method: "post",
        data: $('#formAddBasemoldId').serialize(),
        dataType: "json",
       
        success: function(response){
            if(response['validation'] == 'hasError'){
                toastr.error('Adding Basemold Fail!');

                if(response['error']['pr_number'] === undefined){
                    $("#txtAddPrId").removeClass('is-invalid');
                    $("#txtAddPrId").attr('title', '');
                }
                else{
                    $("#txtAddPrId").addClass('is-invalid');
                    $("#txtAddPrId").attr('title', response['error']['pr_number']);
                }
                if(response['error']['code'] === undefined){
                    $("#txtAddCodeId").removeClass('is-invalid');
                    $("#txtAddCodeId").attr('title', '');
                }
                else{
                    $("#txtAddCodeId").addClass('is-invalid');
                    $("#txtAddCodeId").attr('title', response['error']['code']);
                }
                if(response['error']['part_name'] === undefined){
                    $("#txtAddPartnameId").removeClass('is-invalid');
                    $("#txtAddPartnameId").attr('title', '');
                }
                else{
                    $("#txtAddPartnameId").addClass('is-invalid');
                    $("#txtAddPartnameId").attr('title', response['error']['part_name']);
                }
                // if(response['error']['no_of_items'] === undefined){
                //     $("#txtAddNoItemsId").removeClass('is-invalid');
                //     $("#txtAddNoItemsId").attr('title', '');
                // }
                // else{
                //     $("#txtAddNoItemsId").addClass('is-invalid');
                //     $("#txtAddNoItemsId").attr('title', response['error']['no_of_items']);
                // }
                // if(response['error']['lot_no'] === undefined){
                //     $("#txtAddLotNumberId").removeClass('is-invalid');
                //     $("#txtAddLotNumberId").attr('title', '');
                // }
                // else{
                //     $("#txtAddLotNumberId").addClass('is-invalid');
                //     $("#txtAddLotNumberId").attr('title', response['error']['lot_no']);
                // }

                // if(response['error']['qty_basemold'] === undefined){
                //     $("#txtAddQtyMoldId").removeClass('is-invalid');
                //     $("#txtAddQtyMoldId").attr('title', '');
                // }
                // else{
                //     $("#txtAddQtyMoldId").addClass('is-invalid');
                //     $("#txtAddQtyMoldId").attr('title', response['error']['qty_basemold']);
                // }
                if(response['error']['confirm_qty'] === undefined){
                    $("#txtAddConfirmedId").removeClass('is-invalid');
                    $("#txtAddConfirmedId").attr('title', '');
                }
                else{
                    $("#txtAddConfirmedId").addClass('is-invalid');
                    $("#txtAddConfirmedId").attr('title', response['error']['confirm_qty']);
                }
                // if(response['error']['qty_after_grind'] === undefined){
                //     $("#txtAddQtyAfterGrind").removeClass('is-invalid');
                //     $("#txtAddQtyAfterGrind").attr('title', '');
                // }
                // else{
                //     $("#txtAddQtyAfterGrind").addClass('is-invalid');
                //     $("#txtAddQtyAfterGrind").attr('title', response['error']['qty_after_grind']);
                // }
                // if(response['error']['qty_after_grind'] === undefined){
                //     $("#txtAddCatId").removeClass('is-invalid');
                //     $("#txtAddCatId").attr('title', '');
                // }
                // else{
                //     $("#txtAddCatId").addClass('is-invalid');
                //     $("#txtAddCatId").attr('title', response['error']['qty_after_grind']);
                // }
            }else if(response['result'] == 1 ){
                $("#formAddBasemoldId")[0].reset();  
                $("#modalAddBaseMold").modal('hide');
                dataTableBasemold.draw();
                toastr.success('Adding Basemold Success!');


                $("#txtAddPrId").removeClass('is-invalid');
                $("#txtAddCodeId").removeClass('is-invalid');
                $("#txtAddPartnameId").removeClass('is-invalid');
                // $("#txtAddNoItemsId").removeClass('is-invalid');
                // $("#txtAddLotNumberId").removeClass('is-invalid');
                // $("#txtAddQtyMoldId").removeClass('is-invalid');
                $("#txtAddConfirmedId").removeClass('is-invalid');
                // $("#txtAddQtyAfterGrind").removeClass('is-invalid');

            }
            else if(response['result'] == 2 ){
                $("#formAddBasemoldId")[0].reset();  
                $("#modalAddBaseMold").modal('hide');
                dataTableBasemold.draw();
                toastr.success('Editing Basemold Success!');


                $("#txtAddPrId").removeClass('is-invalid');
                $("#txtAddCodeId").removeClass('is-invalid');
                $("#txtAddPartnameId").removeClass('is-invalid');
                // $("#txtAddNoItemsId").removeClass('is-invalid');
                // $("#txtAddLotNumberId").removeClass('is-invalid');
                // $("#txtAddQtyMoldId").removeClass('is-invalid');
                $("#txtAddConfirmedId").removeClass('is-invalid');
                // $("#txtAddQtyAfterGrind").removeClass('is-invalid');
            }
            else{
                toastr.danger('Process Fail Please Contact ISS!');
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

function getBasemoldInfo(basemoldId){
    $.ajax({
        url: "get_basemold_for_view",
        method: "get",
        data: {
            basemoldId : basemoldId,
        },
        dataType: "json",
        success: function(response){
            
            //VALUE FOR PPC.BLADE.PHP MODAL
            $('#NumItemsId').val(response['result'][0]['no_of_items']);
            $('#QtyBasemoldId').val(response['result'][0]['qty_basemold']);
            $('#ConfQtyId').val(response['result'][0]['qty_confirmed']);
            $('#QtyAfterGrindId').val(response['result'][0]['qty_after_grinding']);
            $('#GrindRemarks').val(response['result'][0]['remarks']);


            //VALUE FOR GRINDING.BLADE.PHP ACCEPT MODAL
            $('#NumAccptItemsId').val(response['result'][0]['no_of_items']);
            $('#QtyAccptBasemoldId').val(response['result'][0]['qty_basemold']);
            $('#ConfAccptQtyId').val(response['result'][0]['qty_confirmed']);
            $('#QtyAccptAfterGrindId').val(response['result'][0]['qty_after_grinding']);
            $('#txtRemarks').val(response['result'][0]['remarks']);
            $('#txtAccptRemarks').val(response['result'][0]['remarks']);
            


            
            //VALUE FOR GRINDING.BLADE.PHP MODAL FINAL ACCEPT
            $('#idBasemoldCode').val(response['result'][0]['basemold']['code']);
            $('#idBasemoldPartname').val(response['result'][0]['basemold']['part_name']);
            $('#qtyRecievedId').val(response['result'][0]['qty_confirmed']);
            $('#idBasemoldId').val(response['result'][0]['id']);
            $('#idBasemoldGR').val(response['result'][0]['gr_number']);
            $('#idBasemoldPR').val(response['result'][0]['pr_number']);
            // console.log(response);


            //VALUE FOR GRINDING.BLADE.PHP MODAL DISAPPROVE
            // $('#idDisBasemoldCode').val(response['result'][0]['code']);
            // $('#idDisBasemoldPartname').val(response['result'][0]['part_name']);
            // $('#qtyDisRecievedId').val(response['result'][0]['qty_basemold']);
            $('#idDisBasemoldId').val(response['result'][0]['id']);


            
            

        },
    });
}


function getProductCode(cboElement){
    $.ajax({
        url: 'get_code',
        method: 'get',
        dataType: 'json',
        success: function(JsonObject){
            // console.log(JsonObject);
            // result = '<option  value="'+JsonObject['result']+'">';
            // cboElement.html(result);
            
            result = '';
            if(JsonObject['result'].length > 0){
                result = '<option value="0" selected disabled>--Select--</option>';
                for(let index = 0; index < JsonObject['result'].length; index++){
                    
                    result += '<option value="' + JsonObject['result'][index].code + '">';
                }
            }
        
            cboElement.html(result);

        },
    });
}

function getPartname(code){
    $.ajax({
        url: 'get_partname_by_code',
        method: 'get',
        data: {
            code : code,
        },
        dataType: 'json',
        success: function(response){
            // console.log(response['result'].length);
            if(response['result'].length != 0){
                $('#txtAddPartnameId').val(response['result'][0]['part_name']);
            }
            else{
                $('#txtAddPartnameId').val("");

            }
            
        },
    });
}


function getBasemoldInfoForEdit(basemoldId){
    // console.log(basemoldId);

    $.ajax({
        url: 'get_basemold_info_for_edit',
        method: 'get',
        data: {
            basemoldId : basemoldId,
        },
        dataType: 'json',
        success: function(response){
     
            $('#basemoldId').val(response['result'][0]['id']);
            $('#txtAddDateid').val(response['result'][0]['date']);
            $('#txtAddPrId').val(response['result'][0]['pr_number']);
            $('#txtAddGrId').val(response['result'][0]['gr_number']);
            $('#txtAddCodeId').val(response['result'][0]['basemold']['code']);
            $('#txtAddPartnameId').val(response['result'][0]['basemold']['part_name']);
            $('#txtAddCatId').val(response['result'][0]['from']).trigger('change');
            // $('#txtAddNoItemsId').val(response['result'][0]['no_of_items']);
            // $('#txtAddLotNumberId').val(response['result'][0]['lot_no']);
            // $('#txtAddQtyMoldId').val(response['result'][0]['qty_basemold']);
            $('#txtAddConfirmedId').val(response['result'][0]['qty_confirmed']);
            // $('#txtAddQtyAfterGrind').val(response['result'][0]['qty_after_grinding']);
            $('#txtAddRemarks').val(response['result'][0]['remarks']);

            
        
         
        },
    });
}


function delBasemold(delId){
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
        url: 'delete_basemold',
        method: 'get',
        data: {
            delId : delId,
        },
        dataType: 'json',
        success: function(response){
            toastr.success('Deleting Basemold Successful');
            dataTableBasemold.draw();
            $('#modalDelBaseMold').modal('hide');
            
        },
    });
}


