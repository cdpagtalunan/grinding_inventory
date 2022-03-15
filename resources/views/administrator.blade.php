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
                            <div class="float-right mb-2">
                                <button class="btn btn-primary" id="modalAddUserId" data-toggle="modal" data-target="#modalAddUser"><i class="fas fa-user-plus"></i> Add User</button>
                            </div>
                        
                            
                            <div class="table-responsive mt-2">
                                <table id="tbl-user-list" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>User Access</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="modal fade" id="modalAddUser" data-backdrop="static" style="overflow: auto;">
                                <div class="modal-dialog"  style="width:100%;max-width:500px;"> 
                                    <div class="modal-content">
                                        <form id="formAddUser">
                                            @csrf
                                            <div class="modal-header bg-dark" >
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-user-plus"></i> Add User</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100" id="basic-addon1">Name:</span>
                                                            </div>
                                                            
                                                            <select class="form-control sel-rapidx-user-list select2bs4" id="selectAddRapidxUser" name="rapidx_user">
    
                                                            </select>
    
                                        
                                                        </div>
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100" id="basic-addon1">Access Level:</span>
                                                            </div>
                                                            
                                                            <select class="form-control" name="user_level" id="selectAddUserLevel">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <option value="1">Administration</option>
                                                                <option value="2">PPC</option>
                                                                <option value="3">Grinding</option>
                                                            </select>
                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="modal-footer justify-content-between">
                                                <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                                                <button type="submit" id="btn-save-user" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                            <div class="modal fade" id="modalEditUser" data-backdrop="static" style="overflow: auto;">
                                <div class="modal-dialog"  style="width:100%;max-width:500px;"> 
                                    <div class="modal-content">
                                        <form id="formEditUser">
                                            @csrf
                                            <div class="modal-header bg-dark" >
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-user-edit"></i> Edit User</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="hidden" id="edt_user_id" name="editUserId">

                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100" id="basic-addon1">Name:</span>
                                                            </div>
                                                            
                                                            <select class="form-control sel-rapidx-user-list select2bs4" id="selectEditRapidxUser" name="edt_rapidx_user" disabled>
    
                                                            </select>
    
                                        
                                                        </div>
                                                        <div class="input-group input-group-sm mb-3">
                                                            <div class="input-group-prepend w-25">
                                                            <span class="input-group-text w-100" id="basic-addon1">Access Level:</span>
                                                            </div>
                                                            
                                                            <select class="form-control" name="edt_user_level" id="selectEditUserLevel">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <option value="1">Administration</option>
                                                                <option value="2">PPC</option>
                                                                <option value="3">Grinding</option>
                                                            </select>
                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="modal-footer justify-content-between">
                                                <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">Close</button>
                                                <button type="submit" id="btn-save-user" class="btn btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="modalDisableUser" data-backdrop="static" style="overflow: auto;">
                                <div class="modal-dialog"  style="width:100%;max-width:500px;"> 
                                    <div class="modal-content">
                                       
                                            <div class="modal-header bg-danger" >
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-user-slash"></i> Disable User</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="hidden" id="disable_user_id" name="disableUserId">
                                                    
                                                    <h5>Are you sure you want to disable this user?</h5>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="modal-footer justify-content-between">
                                                <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">No</button>
                                                <button type="submit" id="btn-disable-user" class="btn btn-success">Yes</button>
                                            </div>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modalEnableUser" data-backdrop="static" style="overflow: auto;">
                                <div class="modal-dialog"  style="width:100%;max-width:500px;"> 
                                    <div class="modal-content">
                                       
                                            <div class="modal-header bg-info" >
                                                <h4 class="modal-title" style="color: white"><i class="fas fa-redo"></i> Enable User</h4>
                                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true" style="color: white">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col">
                                                    <input type="hidden" id="enable_user_id" name="enableUserId">
                                                    
                                                    <h5>Are you sure you want to enable this user?</h5>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="modal-footer justify-content-between">
                                                <button class="btn btn-default" id="close" class="close" data-dismiss="modal" aria-label="Close">No</button>
                                                <button type="submit" id="btn-enable-user" class="btn btn-success">Yes</button>
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
        getUserList($('.sel-rapidx-user-list'));

        
        dataTableListUser = $("#tbl-user-list").DataTable({
            "processing" : true,
            "serverSide" : true,
            "order": [[ 0, "desc" ]],
            "ajax" : {
                url: "get_user",
                // data: function (param){
                //     param.date_from = $("input[name='from_date']", $("#formDateSearch")).val();
                //     param.date_to = $("input[id='to_date']",$("#formDateSearch")).val();
                // }

            },
            "columns":[    
                { "data" : "status"},
                { "data" : "rapid_login.name"},
                { "data" : "rapid_login.username"},
                { "data" : "user_level.level"},

                // { "data" : "EOH"},
                // { "data" : "pr_number"},
                // { "data" : "code"},
                // { "data" : "part_name"},
                // // { "data" : "lot_no"},
                // // { "data" : "logdel"},
                { "data" : "action"},
                
            ],
        });



        $('.select2bs4').select2({
                theme: 'bootstrap4'
        });

        $('#formAddUser').submit(function(event){
            event.preventDefault();
            addUser();
        });

        $(document).on('click', '.btn-disable-user', function(){
            let userId = $(this).attr('user-id');
            $('#disable_user_id').val(userId);
            // disableUser(userId);
            // console.log(userId);
        });

        $('#btn-disable-user').on('click', function(){
            var userId = $('#disable_user_id').val();
            disableUser(userId);

        })

        $(document).on('click', '.btn-enable-user', function(){
            let userId = $(this).attr('user-id');
            $('#enable_user_id').val(userId);

            // enableUser(userId);
            // console.log(userId);
        });
        $('#btn-enable-user').on('click', function(){
            var userId = $('#enable_user_id').val();
            enableUser(userId);


        })
        

        $(document).on('click', '.btn-edit-user', function(){
            let userId = $(this).attr('user-id');
            getUserForEdit(userId);
            // console.log(userId);
        });
        
        $('#formEditUser').submit(function(event){
            event.preventDefault();
            editUser();
        });



    });
    
</script>
@endsection

@endsection
