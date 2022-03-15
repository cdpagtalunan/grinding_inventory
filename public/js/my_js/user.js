function getUserList(cboElement){
    let result = '<option value="0" selected disabled>N/A</option>';
    $.ajax({
        url: 'get_rapidx_userlist',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = '<option value="0" selected disabled> -- Loading -- </option>';
            cboElement.html(result);
        },
        success: function(JsonObject){
            result = '';
            if(JsonObject['users'].length > 0){
                result = '<option value="0" selected disabled>--Select--</option>';
                for(let index = 0; index < JsonObject['users'].length; index++){
                    
                    result += '<option value="' + JsonObject['users'][index].id + '">' + JsonObject['users'][index].name + '</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> -- No record found -- </option>';
            }

            cboElement.html(result);

        },
        error: function(data, xhr, status){
            result = '<option value=""> -- Reload Again -- </option>';
            cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

function addUser(){
    $.ajax({
        url: 'add_user',
        method: 'post',
        data: $('#formAddUser').serialize(),
        dataType: 'json',
        success: function(response){
           console.log(response);
            if(response['validation'] == 'hasError'){ 
                toastr.error('Adding User Fail!');

                if(response['error']['rapidx_user'] === undefined){
                    $("#selectAddRapidxUser").removeClass('is-invalid');
                    $("#selectAddRapidxUser").attr('title', '');
                }
                else{
                    $("#selectAddRapidxUser").addClass('is-invalid');
                    $("#selectAddRapidxUser").attr('title', response['error']['rapidx_user']);
                }
                if(response['error']['user_level'] === undefined){
                    $("#selectAddUserLevel").removeClass('is-invalid');
                    $("#selectAddUserLevel").attr('title', '');
                }
                else{
                    $("#selectAddUserLevel").addClass('is-invalid');
                    $("#selectAddUserLevel").attr('title', response['error']['user_level']);
                }

            }
            else{
                // console.log(response);
                toastr.success('Adding User Successful!');
                $('#modalAddUser').modal('hide');
                $('#formAddUser')[0].reset();
                dataTableListUser.draw();
               
            }

        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}

function disableUser(userId){
    $.ajax({
        url: 'disable_user',
        method: 'get',
        data: {
            userId : userId,
        },
        dataType: 'json',
        success: function(response){
           if(response['result'] == 1){
               toastr.success('Account Disable Successfully');
               dataTableListUser.draw();
               $('#modalDisableUser').modal('hide');
               
           }
           else{
                toastr.danger('Account Disabling Failed!');

           }

        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}

function enableUser(userId){
    $.ajax({
        url: 'enable_user',
        method: 'get',
        data: {
            userId : userId,
        },
        dataType: 'json',
        success: function(response){
           if(response['result'] == 1){
               toastr.success('Account Enable Successfully');
               dataTableListUser.draw();
               $('#modalEnableUser').modal('hide');
           }
           else{
                toastr.danger('Account Enabling Failed!');

           }

        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}

function getUserForEdit(userId){
    $.ajax({
        url: 'get_user_id_for_edit',
        method: 'get',
        data: {
            userId : userId,
        },
        dataType: 'json',
        success: function(response){
         
            
            // console.log(response);


            $('#edt_user_id').val(response['result'][0]['id']);
            $('#selectEditRapidxUser').val(response['result'][0]['rapid_login']['id']).trigger('change');
            $('#selectEditUserLevel').val(response['result'][0]['user_level']['id']).trigger('change');
        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}

function editUser(){
    $.ajax({
        url: 'edit_user',
        method: 'post',
        data: $('#formEditUser').serialize(),
        dataType: 'json',
        success: function(response){
         
            if(response['result'] == 1){
                toastr.success('Success');
                dataTableListUser.draw();
                $('#modalEditUser').modal('hide');

            }
            else{
                toastr.danger('Fail to Edit');
            }
            // console.log(response);

        },
        // error: function(data, xhr, status){
        //     result = '<option value=""> -- Reload Again -- </option>';
        //     cboElement.html(result);
        //     console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        // }
    });
}