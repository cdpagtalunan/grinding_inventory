<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use App\Model\RapidxLogin;
use App\Model\UserAccess;
use DataTables;


class UserController extends Controller
{
    //

    public function get_rapidx_userlist(){
        $user_list = RapidxLogin::where('user_stat', 1)->get();
        return response()->json(['users' => $user_list]);
    }

    public function add_user(Request $request){

        $data = $request->all();

        $validator = Validator::make($data, [
            'rapidx_user' => 'required',
            'user_level' => 'required', 

        ]);


        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{

            UserAccess::insert([
                'rapidx_id' => $request->rapidx_user,
                'access_id' => $request->user_level
            ]);
            
            return response()->json(['result' => $data]);
            
        }   
    }

    public function get_user(){
        $user_list = UserAccess::with([
            'rapid_login',
            'user_level'
        ])
        // ->where('logdel', 0)
        ->get();

        // return $test;

        
        return DataTables::of($user_list)
        ->addColumn('status', function($user){
            $result = "";
            if($user->logdel == 0 ){
                $result .= "<center><span class='badge badge-success'>Active</span></center>";
            }
            else if($user->logdel == 1){
                $result .= "<center><span class='badge badge-danger'>Disabled</span></center>";
            }
            // else if($basemold->status == 3){
            //     $result .= "<center><span class='badge badge-warning'>Accepted <br> With Remarks</span></center>";
            // }
            // else{
            //     $result .= "<center><span class='badge badge-danger'>Not Accepted</span></center>";
            // }

            return $result;
        })

        
        ->addColumn('action', function($user){
            $result = "";



            if($user->logdel == 0){
                $result .= '<center><button class="btn btn-info btn-sm  btn-edit-user mr-1"  data-toggle="modal" data-target="#modalEditUser" user-id="'.$user->id.'"><i class="fas fa-edit"></i></button>';
                $result .= '<button class="btn btn-danger btn-sm  btn-disable-user mr-1" data-toggle="modal" data-target="#modalDisableUser"  user-id="'.$user->id.'"><i class="fas fa-user-alt-slash"></i></button></center>';

            }
            else{
                $result .= '<center><button class="btn btn-success btn-sm  btn-enable-user mr-1" data-toggle="modal" data-target="#modalEnableUser" user-id="'.$user->id.'"><i class="fas fa-redo"></i></button>';

            }
          

          
          

            return $result;
        })

        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function disable_user(Request $request){

        $userId = $request->userId;

        UserAccess::where('id', $userId)
        ->update([
            'logdel' => 1
        ]);

        return response()->json(['result' => 1]);

    }

    public function enable_user(Request $request){

        $userId = $request->userId;

        UserAccess::where('id', $userId)
        ->update([
            'logdel' => 0
        ]);

        return response()->json(['result' => 1]);

    }


    public function get_user_id_for_edit(Request $request){
        
        $get_user = UserAccess::with([
            'rapid_login',
            'user_level'
        ])
        ->where('id', $request->userId)
        ->get();

        return response()->json(['result' => $get_user]);

        
    }


    public function edit_user(Request $request){
      
        UserAccess::where('id', $request->editUserId)
        ->update([
            'access_id' => $request->edt_user_level
        ]);


        return response()->json(['result' => 1]);

        
    }

    public function get_user_log(Request $request){
        
        $user_log = UserAccess::where('rapidx_id', $request->logId)
        ->where('logdel', 0)
        ->get();

        return response()->json(['result' => $user_log]);
    }

}
