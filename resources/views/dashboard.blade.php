@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3" id="d-basemold" style="display: none">
                                    <a href="ppc">

                                        <div class="info-box  elevation-2">
                                        <span class="info-box-icon bg-info elevation-1" style=""><i class="fas fa-pallet"></i></span>
                                            
                                        <div class="info-box-content mt-2">
                                            <span class="info-box-text" ><h5> Basemold</h5></span>
                                        
                                        </div>

                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </a>

                                </div>
                                <div class="col-12 col-sm-12 col-md-3" id="d-recieving" style="display: none">
                                    <a href="grinding_receiving">

                                        <div class="info-box  elevation-2">
                                        <span class="info-box-icon bg-info elevation-1" style=""><i class="fas fa-file-download"></i></span>
                                            
                                        <div class="info-box-content mt-2">
                                            <span class="info-box-text"><h5> Production Receiving</h5></span>
                                        
                                        </div>

                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </a>

                                </div>
                               
                            {{-- </div>
                            <div class="row"> --}}
                                <div class="col-12 col-sm-12 col-md-3" id="d-assets" style="display: none">
                                    <a href="grinding_asset">

                                        <div class="info-box  elevation-2">
                                        <span class="info-box-icon bg-info elevation-1" style=""><i class="fas fa-folder"></i></span>
                                            
                                        <div class="info-box-content mt-2">
                                            <span class="info-box-text"><h5> Production Assets</h5></span>
                                        
                                        </div>

                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </a>

                                </div>

                                <div class="col-12 col-sm-12 col-md-3" id="d-admin" style="display: none"> 
                                    <a href="administrator">

                                        <div class="info-box  elevation-2">
                                        <span class="info-box-icon bg-info elevation-1" style=""><i class="fa fa-users"></i></span>
                                            
                                        <div class="info-box-content mt-2">
                                            <span class="info-box-text"><h5> User Management</h5></span>
                                        
                                        </div>

                                        <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </a>

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
    // verifyUser();

    // function verifyUser(){
    //     // var logName = $('#login_name').val();
    //     var logId = $('#login_id').val();

    //     console.log(logId);

    //     $.ajax({
    //         url: "get_user_log",
    //         method: "get",
    //         data: {
    //             logId : logId
    //         },
    //         dataType: "json",
        
    //         success: function(response){
                
    //             // console.log(response['result'].length);
    //             // console.log(response);
                  
    //             // if(response['result'].length == 0){
    //             //     window.location.href = 'error';
    //             // }
    //             // else{
    //             //     for(i = 0; i<response['result'].length;i++){
                       
                    

    //             //         if(response['result'][i]['access_id'] == 1){
    //             //             $('#d-basemold').css('display','block');
    //             //             $('#d-recieving').css('display','block');
    //             //             $('#d-assets').css('display','block');
    //             //             $('#d-admin').css('display','block');
    //             //         }
    //             //         if(response['result'][i]['access_id'] == 2){
    //             //             $('#d-basemold').css('display','block');

    //             //         }
    //             //         if(response['result'][i]['access_id'] == 3){
                        
    //             //             $('#d-recieving').css('display','block');
    //             //             $('#d-assets').css('display','block');
    //             //         }
    //             //     }
    //             // } 
    //         },
       
    //     });
    // }

</script>

@endsection
@endsection