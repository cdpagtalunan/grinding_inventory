<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use App\Model\Basemold;
use App\Model\BasemoldWip;
use App\Model\BasemoldRecieve;
use App\Model\FGS;
use App\Model\WipTransaction;
use App\Model\FgsRecieve;
use App\Model\RapidShipment;
use App\Model\FromRapidShipment;
use App\Model\ReworkVisual;
use App\Model\ReworkVisualTransaction;
use App\Model\RapidPOReceive;
use DataTables;

class GrindingController_orig030922 extends Controller
{
    public function get_basemold_info_grinding(Request $request){
        $basemold = BasemoldRecieve::with([
            'basemold'
        ])
        ->where('logdel', 0)
        ->whereIn('status', [0,1,3])
        ->orderBy('id', 'desc')
        ->get();

        return DataTables::of($basemold)
        ->addColumn('status', function($basemold){
            $result = "";
            if($basemold->status == 0 ){
                $result .= "<center><span class='badge badge-secondary'>Pending</span></center>";
            }
            else if($basemold->status == 1){
                $result .= "<center><span class='badge badge-success'>Accepted</span></center>";
            }
            else if($basemold->status == 3){
                $result .= "<center><span class='badge badge-warning'>Accepted <br> With Remarks</span></center>";
            }
            else{
                $result .= "<center><span class='badge badge-danger'>Not Accepted</span></center>";
            }

            return $result;
        })


        ->addColumn('action', function($basemold){
            $result = "";
            if($basemold->status == 0 ){
                $result .= '<center><button class="btn btn-info btn-sm  btn-basemold-accept mr-1"  data-toggle="modal" data-target="#modalAcceptBasemoldDetails" basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button>';
            }
            else{
                $result .= "<center>";
                
                $result .= '<button class="btn btn-info btn-sm btn-basemold-view mr-1"  data-toggle="modal" data-target="#modalViewBasemoldDetails" basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button>';
                $result .= "<button class='btn btn-warning btn-sm mr-1 btnPrintQRCode' basemold-details='{$basemold}'><i class='fas fa-print'></i></button>";
                $result .= "</center>";

            }
            return $result;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }


    public function accept_basemold(Request $request){
        
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        // return $data;
        
        $basemold_id = Basemold::where('code', $request->BasemoldCode)
        ->where('part_name', $request->BasemoldPartname)
        ->get('id');

        // return $basemold_id;


        $get_wip_basemold_existing = BasemoldWip::where('fk_basemold_id', $basemold_id[0]->id)
        ->where('PR_number', $request->BasemoldPR)
        // ->Where('GR_number', $request->BasemoldGR)
        ->get();
        
        // return count($get_wip_basemold_existing);

                            
        if(count($get_wip_basemold_existing) == 0){
            
            //insert basemold on tbl_wip_basemold when accepted when there is no existing data on db
            $basemold_wip_id = BasemoldWip::insertGetId([
                // 'code' => $request->BasemoldCode,
                // 'partname' => $request->BasemoldPartname,
                'fk_basemold_id'=> $basemold_id[0]->id,
                'PR_number' => $request->BasemoldPR,
                'gr_number' => $request->BasemoldGR,
                'IN' => $request->qtyRecieved,
                'EOH' =>  $request->qtyRecieved,
                'accept_by' => $_SESSION['rapidx_user_id'],
                'created_at' => NOW()

            ]);

            //change the status of basemold  receiving status
            if($request->recievedRemarks == null){
                BasemoldRecieve::where('id', $request->BasemoldId)
                    ->update([
                        'status' => 1
                    ]);
            }
            else{
                BasemoldRecieve::where('id', $request->BasemoldId)
                    ->update([
                        'status' => 3,
                        'remarks' => $request->recievedRemarks
                    ]);
            }

            //insert on tbl_wip_transaction for records
            WipTransaction::insert([
                'fk_basemold_recieve_id' => $request->BasemoldId,
                'fk_basemold_id' => $basemold_wip_id,
                'transaction_date' => NOW(),
                // 'remarks' => $request->recievedRemarks
            ]);

            return response()->json(['result' => 1, 'basemold_wip_id' => $basemold_wip_id]);
        }
        else{
       
            // return $get_wip_basemold_existing;
            if($get_wip_basemold_existing[0]->PR_number == $request->BasemoldPR && $get_wip_basemold_existing[0]->PR_number != null){
                // return "test";
                $get_wip_basemold_existing = BasemoldWip::where('fk_basemold_id', $basemold_id[0]->id)
                ->where('PR_number', $request->BasemoldPR)
                // ->orWhere('GR_number', $request->BasemoldGR)
                ->orderBy('id','desc')
                ->first();

                // return $get_wip_basemold_existing;

                $eoh = $get_wip_basemold_existing->EOH;
                $final_eoh = 0;
                $final_eoh =  $eoh + $request->qtyRecieved;
    
                BasemoldWip::where('id', $get_wip_basemold_existing->id)
                ->update([
                    'logdel' => 1,
                ]);
                
                
                $basemold_wip_id  = BasemoldWip::insertGetId([
                    'fk_basemold_id' => $basemold_id[0]->id,
                    'PR_number' => $request->BasemoldPR,
                    'gr_number' => $request->BasemoldGR,
                    'IN' => $request->qtyRecieved,
                    'EOH' =>  $final_eoh,
                    'accept_by' => $_SESSION['rapidx_user_id'],
                    'created_at' => NOW()

                ]);
                if($request->recievedRemarks == null){
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 1
                        ]);
                }
                else{
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 3,
                            'remarks' => $request->recievedRemarks
                        ]);
                }
                WipTransaction::insert([
                    'fk_basemold_recieve_id' => $request->BasemoldId,
                    'fk_basemold_id' => $basemold_wip_id,
                    'transaction_date' => NOW(),
                    // 'remarks' => $request->recievedRemarks
                ]);
            }
            else if(($get_wip_basemold_existing[0]->GR_number == $request->BasemoldGR || strtoupper($request->BasemoldGR) == 'FROM STOCK') && ($get_wip_basemold_existing[0]->GR_number != null && $get_wip_basemold_existing[0]->GR_number != "N/A")){
                // return "parehas";
                $get_wip_basemold_existing = BasemoldWip::where('fk_basemold_id', $basemold_id[0]->id)
                ->where('PR_number', $request->BasemoldPR)
                ->orWhere('GR_number', $request->BasemoldGR)
                ->orderBy('id','desc')
                ->first();
                // return $get_wip_basemold_existing;

                $eoh = $get_wip_basemold_existing->EOH;
                $final_eoh = 0;
                $final_eoh =  $eoh + $request->qtyRecieved;
    
                BasemoldWip::where('id', $get_wip_basemold_existing->id)
                ->update([
                    'logdel' => 1,
                ]);
                
                
                $basemold_wip_id  = BasemoldWip::insertGetId([
                    'fk_basemold_id' => $basemold_id[0]->id,
                    'PR_number' => $request->BasemoldPR,
                    'gr_number' => $request->BasemoldGR,
                    'IN' => $request->qtyRecieved,
                    'EOH' =>  $final_eoh,
                    'accept_by' => $_SESSION['rapidx_user_id'],
                    'created_at' => NOW()

                ]);
                if($request->recievedRemarks == null){
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 1
                        ]);
                }
                else{
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 3,
                            'remarks' => $request->recievedRemarks
                        ]);
                }
                WipTransaction::insert([
                    'fk_basemold_recieve_id' => $request->BasemoldId,
                    'fk_basemold_id' => $basemold_wip_id,
                    'transaction_date' => NOW(),
                    // 'remarks' => $request->recievedRemarks
                ]);
        
            }
            else{
                $basemold_wip_id = BasemoldWip::insertGetId([
                    // 'code' => $request->BasemoldCode,
                    // 'partname' => $request->BasemoldPartname,
                    'fk_basemold_id'=> $basemold_id[0]->id,
                    'PR_number' => $request->BasemoldPR,
                    'gr_number' => $request->BasemoldGR,
                    'IN' => $request->qtyRecieved,
                    'EOH' =>  $request->qtyRecieved,
                    'accept_by' => $_SESSION['rapidx_user_id'],
                    'created_at' => NOW()
    
                ]);
    
                //change the status of basemold  receiving status
                if($request->recievedRemarks == null){
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 1
                        ]);
                }
                else{
                    BasemoldRecieve::where('id', $request->BasemoldId)
                        ->update([
                            'status' => 3,
                            'remarks' => $request->recievedRemarks
                        ]);
                }
    
                //insert on tbl_wip_transaction for records
                WipTransaction::insert([
                    'fk_basemold_recieve_id' => $request->BasemoldId,
                    'fk_basemold_id' => $basemold_wip_id,
                    'transaction_date' => NOW(),
                    // 'remarks' => $request->recievedRemarks
                ]);
            }

            
    

            return response()->json(['result' => 1, 'basemold_wip_id' => $basemold_wip_id]);
        }




            // return response()->json(['result' => count($get_wip_basemold_existing)]);

    }

    public function disapprove_basemold(Request $request){

        $data = $request->all(); 

        $validator = Validator::make($data, [
            'recievedDisRemarks' => 'required|string'
        ]);

        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
             BasemoldRecieve::where('id', $request->BasemoldDisId)
            ->update([
                'remarks' => $request->recievedDisRemarks,
                'status' => 4
            ]);

            return response()->json(['result' => 1]);


        }


       


    }


    public function get_wip_basemold(){

        $wip_basemold = BasemoldWip::with([
            'basemold'
        ])
        ->where('PR_number','!=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
  
        $wip_basemold1 = BasemoldWip::with([
            'basemold'
        ])
        ->where('PR_number','=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
        
       
        // $wip_basemold = collect($wip_basemold)->unique('PR_number')->flatten(1);
        $wip_basemold = collect($wip_basemold)->where('EOH', '!=', 0)->flatten(1);
        // $wip_basemold1 = collect($wip_basemold1)->unique('GR_number')->flatten(1);
        $wip_basemold1 = collect($wip_basemold1)->where('EOH', '!=', 0)->flatten(1);

        // $wip_basemold = collect($wip_basemold)->unique('fk_basemold_id')->flatten(1);
        $wip_basemold2 = $wip_basemold->merge($wip_basemold1);

        // return $wip_basemold2;

        // $wip_basemold = BasemoldWip::with([
        //     'basemold'
        // ])
        // ->orderBy('id', 'desc')
        // ->where('logdel', 0)->get();
        // // $wip_basemold = collect($wip_basemold)->unique('fk_basemold_id')->flatten(1);

        // // return $wip_basemold;
        return DataTables::of($wip_basemold2)
        ->addColumn('action', function($basemold){
            $result = "";
            
                $result .= '<center><button class="btn btn-info btn-sm  btn-basemold-wip mr-1"  data-toggle="modal" data-target="#WipBasemoldModal" wip-basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button>';
                $result .= '<button class="btn btn-secondary btn-sm btn-wip-remarks mr-1"  data-toggle="modal" data-target="#WipBasemoldRemarks" wip-basemold-id="'.$basemold->id.'"><i class="fas fa-edit"></i></button>';
                
            
    
            // $result .= '<button class="btn btn-primary btn-sm  btn-edt-basemold mr-1"  data-toggle="modal" data-target="#modalAddBaseMold" basemold-id="'.$basemold->id.'"><i class="fa fa-edit"></i></button>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    

        
        // return response()->json(['result' => $wip_basemold ]);

      

    }

    public function getWipBasemoldInfo(Request $request){

       
        $grinding_wip = BasemoldWip::with([
            'basemold'
        ])
        ->where('id', $request->wipBasemoldId)
        ->get();


        if($grinding_wip[0]->PR_number != null || $grinding_wip[0]->PR_number != 'N/A'){
            $rapid_code_itemname_for_automation = RapidPOReceive::where('OrderNo',$grinding_wip[0]->PR_number)
            // ->orWhere('OrderNo', $grinding_wip[0]->GR_number)
            ->where('logdel', 0)
            ->get();
        }
        else{
            $rapid_code_itemname_for_automation = RapidPOReceive::where('OrderNo', $grinding_wip[0]->GR_number)
            ->where('logdel', 0)
            ->get();
        }
        
        
        // return $rapid_code_itemname_for_automation;
      
        $glued_wip = BasemoldWip::with([
            'basemold'
        ])
        ->where('PR_number',$grinding_wip[0]->PR_number)
        ->where('logdel', 0)
        ->get();
        $glued_wip = collect($glued_wip)->unique('fk_basemold_id')->flatten(1);


        // return $glued_wip;
      
        if(count($glued_wip)>1){
            // return "glued";
            return response()->json([ 'glued' => $glued_wip, 'count' => 1, 'code_part' => $rapid_code_itemname_for_automation ]);

        }
        else{
            // return "not";
            return response()->json(['result' => $grinding_wip, 'count' => 0,  'code_part' => $rapid_code_itemname_for_automation]);


        }



    }

    // public function getWipBasemoldInfoForTransaction(Request $request){
        

    //     $wip_transaction = WipTransaction::with([
    //         'basemold',
    //         'fgs'
    //     ])
    //     ->where('fk_basemold_id', $request->transacId)
    //     ->orderBy('id', 'desc')
    //     ->get();
    //     // return $wip_transaction;
    //     return DataTables::of($wip_transaction)
    //     ->make(true);
        
       
        
     

    // }

    public function wipTransaction(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;

        $validator = Validator::make($data, [
            'trans_date' => 'required',
            'trans_fgs_code' => 'required',
            'trans_fgs_name' => 'required|string',
            'trans_b_out' => 'required|int',
            'trans_fgs_in' => 'required|int',
            

        ]);

        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
            $fgs_eoh = 0;
            $final_eoh = 0;
            $glued_out = 0;
            $glued_trans_next_eoh = 0;

            $check_fgs = FGS::where('fgs_code', $request->trans_fgs_code)
            ->where('fgs_name', $request->trans_fgs_name)
            ->where('logdel', 0)
            ->get();

            if(count($check_fgs) == 0){

                // FOR GLUED MATERIAL
                if($request->transactionIdForTable1 == null){
                    // return "not";
                    BasemoldWip::where('id', $request->transactionIdForTable)
                    ->update([
                        'logdel' => 1,
                    ]);
    
                    $basemold_wip_id = BasemoldWip::insertGetId([
                       'fk_basemold_id' => $request->transBasemoldId,
                       'PR_number' => $request->transBasemoldPR,
                       'GR_number' => $request->transBasemoldGR,
                       'OUT' =>  $request->trans_b_out,
                       'NG' => $request->trans_grinded_ng,
                       'golden_sample' => $request->trans_grinded_gsamp,
                       'EOH' => $request->trans_next_eoh,
                       'created_at' => NOW()
                    ]);

                    $fgs_id = FGS::insertGetId([
                    'fgs_code' => $request->trans_fgs_code,
                   'fgs_name' => $request->trans_fgs_name
                    ]);

                    $fgs_rework_visual_id = ReworkVisual::insertGetId([
                        'fk_fgs_id' => $fgs_id,
                        'PR_number'=> $request->transBasemoldPR,
                        'GR_number' => $request->transBasemoldGR,
                        'fgs_rework_IN' => $request->trans_fgs_in,
                        'EOH' => $request->trans_fgs_in,
                        'created_at' => NOW()
                    ]);

                    ReworkVisualTransaction::insert([
                        'date' => $request->trans_date,
                        'fk_rework_id' => $fgs_rework_visual_id,
                    ]);

                    
                    wipTransaction::insert([
                        'fk_basemold_id' => $basemold_wip_id,
                        'fk_rework_visual_id' => $fgs_rework_visual_id,
                        'transaction_date' => NOW(),
                        'remarks' => $request->trans_remarks
                    ]);


                }else{
                    if(($request->trans_b_out%2) != 0){
                        return response()->json(['result' => 0]);
                    }
                    else{
                        $glued_out = $request->trans_b_out/2;
                        $glued_trans_next_eoh = $request->trans_next_eoh/2;

                        

                        BasemoldWip::where('id', $request->transactionIdForTable)
                        ->orWhere('id', $request->transactionIdForTable1)
                        ->update([
                            'logdel' => 1,
                        ]);
        
                        $basemold_wip_id = BasemoldWip::insertGetId([
                        'fk_basemold_id' => $request->transBasemoldId,
                        'PR_number' => $request->transBasemoldPR,
                        'GR_number' => $request->transBasemoldGR,
                        'OUT' =>  $glued_out,
                        'NG' => $request->trans_grinded_ng,
                        'golden_sample' => $request->trans_grinded_gsamp,
                        'EOH' => $glued_trans_next_eoh,
                        'created_at' => NOW()
                        ]);

                        $basemold_wip_id1 = BasemoldWip::insertGetId([
                        'fk_basemold_id' => $request->transBasemoldId1,
                        'PR_number' => $request->transBasemoldPR,
                        'GR_number' => $request->transBasemoldGR,
                        'OUT' =>  $glued_out,
                        'NG' => $request->trans_grinded_ng,
                        'golden_sample' => $request->trans_grinded_gsamp,
                        'EOH' => $glued_trans_next_eoh,
                        'created_at' => NOW()
                        ]);

                        $fgs_id = FGS::insertGetId([
                            'fgs_code' => $request->trans_fgs_code,
                           'fgs_name' => $request->trans_fgs_name
                        ]);
        
                        $fgs_rework_visual_id = ReworkVisual::insertGetId([
                            'fk_fgs_id' => $fgs_id,
                            'PR_number'=> $request->transBasemoldPR,
                            'GR_number' => $request->transBasemoldGR,
                            'fgs_rework_IN' => $request->trans_fgs_in,
                            'EOH' => $request->trans_fgs_in,
                            'created_at' => NOW()
                        ]);
        
                        ReworkVisualTransaction::insert([
                            'date' => $request->trans_date,
                            'fk_rework_id' => $fgs_rework_visual_id,
                        ]);
        
                        
                        wipTransaction::insert([
                            'fk_basemold_id' => $basemold_wip_id,
                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                            'transaction_date' => NOW(),
                            'remarks' => $request->trans_remarks
                        ]);

                        wipTransaction::insert([
                            'fk_basemold_id' => $basemold_wip_id1,
                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                            'transaction_date' => NOW(),
                            'remarks' => $request->trans_remarks
                        ]);
                    }
                }
               return response()->json(['result' => 1]);

            }
            else{
                $fgs_id = FGS::where('fgs_code', $request->trans_fgs_code)
               ->where('fgs_name', $request->trans_fgs_name)
               ->where('logdel', 0)
               ->first();


                $get_fgs_recieve_data = ReworkVisual::where('fk_fgs_id', $fgs_id->id)
                ->where('logdel', 0)
                ->orderBy('id', 'desc')
                ->first();

                // return $get_fgs_recieve_data;

                if($get_fgs_recieve_data == null){
                  
                    // FOR GLUE MATERIAL
                    if($request->transactionIdForTable1 == null){
                        // return "not";
                        BasemoldWip::where('id', $request->transactionIdForTable)
                        ->update([
                            'logdel' => 1,
                        ]);
        
                        $basemold_wip_id = BasemoldWip::insertGetId([
                           'fk_basemold_id' => $request->transBasemoldId,
                           'PR_number' => $request->transBasemoldPR,
                           'GR_number' => $request->transBasemoldGR,
                           'OUT' =>  $request->trans_b_out,
                           'NG' => $request->trans_grinded_ng,
                           'golden_sample' => $request->trans_grinded_gsamp,
                           'EOH' => $request->trans_next_eoh,
                           'created_at' => NOW()
                        ]);

                        $fgs_rework_visual_id = ReworkVisual::insertGetId([
                            'fk_fgs_id' => $fgs_id->id,
                            'PR_number'=> $request->transBasemoldPR,
                            'GR_number' => $request->transBasemoldGR,
                            'fgs_rework_IN' => $request->trans_fgs_in,
                            'EOH' => $request->trans_fgs_in,
                            'created_at' => NOW()
                        ]);
    
                        ReworkVisualTransaction::insert([
                            'date' => $request->trans_date,
                            'fk_rework_id' => $fgs_rework_visual_id,
                        ]);
    
    
                        wipTransaction::insert([
                            'fk_basemold_id' => $basemold_wip_id,
                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                            'transaction_date' => NOW(),
                            'remarks' => $request->trans_remarks
                        ]);
    
                    }
                    else{
                        if(($request->trans_b_out%2) != 0){
                            return response()->json(['result' => 0]);
                        }
                        else{
                            $glued_out = $request->trans_b_out/2;
                            $glued_trans_next_eoh = $request->trans_next_eoh/2;
        
                            BasemoldWip::where('id', $request->transactionIdForTable)
                            ->orWhere('id', $request->transactionIdForTable1)
                            ->update([
                                'logdel' => 1,
                            ]);
            
                            $basemold_wip_id = BasemoldWip::insertGetId([
                            'fk_basemold_id' => $request->transBasemoldId,
                            'PR_number' => $request->transBasemoldPR,
                            'GR_number' => $request->transBasemoldGR,
                            'OUT' =>  $glued_out,
                            'NG' => $request->trans_grinded_ng,
                            'golden_sample' => $request->trans_grinded_gsamp,
                            'EOH' => $glued_trans_next_eoh,
                            'created_at' => NOW()
                            ]);
        
                            $basemold_wip_id1 = BasemoldWip::insertGetId([
                            'fk_basemold_id' => $request->transBasemoldId1,
                            'PR_number' => $request->transBasemoldPR,
                            'GR_number' => $request->transBasemoldGR,
                            'OUT' =>  $glued_out,
                            'NG' => $request->trans_grinded_ng,
                            'golden_sample' => $request->trans_grinded_gsamp,
                            'EOH' => $glued_trans_next_eoh,
                            'created_at' => NOW()
                            ]);

                            $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                'fk_fgs_id' => $fgs_id->id,
                                'PR_number'=> $request->transBasemoldPR,
                                'GR_number' => $request->transBasemoldGR,
                                'fgs_rework_IN' => $request->trans_fgs_in,
                                'EOH' => $request->trans_fgs_in,
                                'created_at' => NOW()
                            ]);
        
                            ReworkVisualTransaction::insert([
                                'date' => $request->trans_date,
                                'fk_rework_id' => $fgs_rework_visual_id,
                            ]);
        
        
                            wipTransaction::insert([
                                'fk_basemold_id' => $basemold_wip_id,
                                'fk_rework_visual_id' => $fgs_rework_visual_id,
                                'transaction_date' => NOW(),
                                'remarks' => $request->trans_remarks
                            ]);


                            wipTransaction::insert([
                                'fk_basemold_id' => $basemold_wip_id1,
                                'fk_rework_visual_id' => $fgs_rework_visual_id,
                                'transaction_date' => NOW(),
                                'remarks' => $request->trans_remarks
                            ]);
                        }
                    }
                    
                   

                    return response()->json(['result' => 1]);

                }
                else{
                    
                    $get_fgs_recieve_data1 = ReworkVisual::where('PR_number',$request->transBasemoldPR)
                    ->where('fk_fgs_id', $fgs_id->id)
                    // ->orWhere('GR_number', $request->transBasemoldGR)
                    ->where('logdel', 0)
                    ->orderBy('id', 'desc')
                    ->first();

                    // return $get_fgs_recieve_data1;

                    if($get_fgs_recieve_data1 == null){
                        // return "maglalagay ng bago";
                        // FOR GLUED MATERIAL
                        if($request->transactionIdForTable1 == null){
                            // return "not";
                            BasemoldWip::where('id', $request->transactionIdForTable)
                            ->update([
                                'logdel' => 1,
                            ]);
            
                            $basemold_wip_id = BasemoldWip::insertGetId([
                               'fk_basemold_id' => $request->transBasemoldId,
                               'PR_number' => $request->transBasemoldPR,
                               'GR_number' => $request->transBasemoldGR,
                               'OUT' =>  $request->trans_b_out,
                               'NG' => $request->trans_grinded_ng,
                               'golden_sample' => $request->trans_grinded_gsamp,
                               'EOH' => $request->trans_next_eoh,
                               'created_at' => NOW()
                            ]);

                            $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                'fk_fgs_id' => $fgs_id->id,
                                'PR_number'=> $request->transBasemoldPR,
                                'GR_number' => $request->transBasemoldGR,
                                'fgs_rework_IN' => $request->trans_fgs_in,
                                'EOH' => $request->trans_fgs_in,
                                'created_at' => NOW()
                            ]);
    
                            ReworkVisualTransaction::insert([
                                'date' => $request->trans_date,
                                'fk_rework_id' => $fgs_rework_visual_id,
                            ]);
                            
                            wipTransaction::insert([
                                'fk_basemold_id' => $basemold_wip_id,
                                'fk_rework_visual_id' => $fgs_rework_visual_id,
                                'transaction_date' => NOW(),
                                'remarks' => $request->trans_remarks
                            ]);
        
        
                        }else{
                            // return "glued";
                            if(($request->trans_b_out%2) != 0){
                                return response()->json(['result' => 0]);
                            }
                            else{

                                $glued_out = $request->trans_b_out/2;
                                $glued_trans_next_eoh = $request->trans_next_eoh/2;
            
                                BasemoldWip::where('id', $request->transactionIdForTable)
                                ->orWhere('id', $request->transactionIdForTable1)
                                ->update([
                                    'logdel' => 1,
                                ]);
                
                                $basemold_wip_id = BasemoldWip::insertGetId([
                                'fk_basemold_id' => $request->transBasemoldId,
                                'PR_number' => $request->transBasemoldPR,
                                'GR_number' => $request->transBasemoldGR,
                                'OUT' =>  $glued_out,
                                'NG' => $request->trans_grinded_ng,
                                'golden_sample' => $request->trans_grinded_gsamp,
                                'EOH' => $glued_trans_next_eoh,
                                'created_at' => NOW()
                                ]);
            
                                $basemold_wip_id1 = BasemoldWip::insertGetId([
                                'fk_basemold_id' => $request->transBasemoldId1,
                                'PR_number' => $request->transBasemoldPR,
                                'GR_number' => $request->transBasemoldGR,
                                'OUT' =>  $glued_out,
                                'NG' => $request->trans_grinded_ng,
                                'golden_sample' => $request->trans_grinded_gsamp,
                                'EOH' => $glued_trans_next_eoh,
                                'created_at' => NOW()
                                ]);

                                $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                    'fk_fgs_id' => $fgs_id->id,
                                    'PR_number'=> $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'fgs_rework_IN' => $request->trans_fgs_in,
                                    'EOH' => $request->trans_fgs_in,
                                    'created_at' => NOW()
                                ]);
        
                                ReworkVisualTransaction::insert([
                                    'date' => $request->trans_date,
                                    'fk_rework_id' => $fgs_rework_visual_id,
                                ]);
                                
                                wipTransaction::insert([
                                    'fk_basemold_id' => $basemold_wip_id,
                                    'fk_rework_visual_id' => $fgs_rework_visual_id,
                                    'transaction_date' => NOW(),
                                    'remarks' => $request->trans_remarks
                                ]);

                                wipTransaction::insert([
                                    'fk_basemold_id' => $basemold_wip_id1,
                                    'fk_rework_visual_id' => $fgs_rework_visual_id,
                                    'transaction_date' => NOW(),
                                    'remarks' => $request->trans_remarks
                                ]);
                            }
                        }
                        return response()->json(['result' => 1]);

                    }
                    else{

                        if( $get_fgs_recieve_data1->GR_number == $request->transBasemoldGR || strtoupper($request->transBasemoldGR) == 'FROM STOCK' || $get_fgs_recieve_data1->PR_number == $request->transBasemoldPR){
                            if($get_fgs_recieve_data1->remarks == null){
                                

                                $fgs_eoh = $get_fgs_recieve_data1->EOH;
                                $final_eoh =  $fgs_eoh + $request->trans_fgs_in;
    
                                // return $get_fgs_recieve_data1;
                                // FOR GLUED MATERIAL
                                if($request->transactionIdForTable1 == null){
                                    // return "not and may parehas na";
                                    BasemoldWip::where('id', $request->transactionIdForTable)
                                    ->update([
                                        'logdel' => 1,
                                    ]);
                    
                                    $basemold_wip_id = BasemoldWip::insertGetId([
                                        'fk_basemold_id' => $request->transBasemoldId,
                                        'PR_number' => $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'OUT' =>  $request->trans_b_out,
                                        'NG' => $request->trans_grinded_ng,
                                        'golden_sample' => $request->trans_grinded_gsamp,
                                        'EOH' => $request->trans_next_eoh,
                                        'created_at' => NOW()
                                    ]);

                                    $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                        'fk_fgs_id' => $fgs_id->id,
                                        'PR_number'=> $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'fgs_rework_IN' => $request->trans_fgs_in,
                                        'EOH' => $final_eoh,
                                        'remarks' => $get_fgs_recieve_data1->remarks,
                                        'created_at' => NOW()
                                    ]);
            
                                    ReworkVisualTransaction::insert([
                                        'date' => $request->trans_date,
                                        'fk_rework_id' => $fgs_rework_visual_id,
                                    ]);

                                    wipTransaction::insert([
                                        'fk_basemold_id' => $basemold_wip_id,
                                        'fk_rework_visual_id' => $fgs_rework_visual_id,
                                        'transaction_date' => NOw(),
                                        'remarks' => $request->trans_remarks
                                    ]);
                
                
                                }
                                else{
                                    // return "glued and may parehas na";
                                  

                                    if(($request->trans_b_out%2) != 0){
                                        return response()->json(['result' => 0]);
                                    }
                                    else{
                                      

                                        $glued_out = $request->trans_b_out/2;
                                        $glued_trans_next_eoh = $request->trans_next_eoh/2;
                    

                                        BasemoldWip::where('id', $request->transactionIdForTable)
                                        ->orWhere('id', $request->transactionIdForTable1)
                                        ->update([
                                            'logdel' => 1,
                                        ]);
                        
                                        $basemold_wip_id = BasemoldWip::insertGetId([
                                        'fk_basemold_id' => $request->transBasemoldId,
                                        'PR_number' => $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'OUT' =>  $glued_out,
                                        'NG' => $request->trans_grinded_ng,
                                        'golden_sample' => $request->trans_grinded_gsamp,
                                        'EOH' => $glued_trans_next_eoh,
                                        'created_at' => NOW()
                                        ]);
                    
                                        $basemold_wip_id1 = BasemoldWip::insertGetId([
                                        'fk_basemold_id' => $request->transBasemoldId1,
                                        'PR_number' => $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'OUT' =>  $glued_out,
                                        'NG' => $request->trans_grinded_ng,
                                        'golden_sample' => $request->trans_grinded_gsamp,
                                        'EOH' => $glued_trans_next_eoh,
                                        'created_at' => NOW()
                                        ]);
    
                                        $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                            'fk_fgs_id' => $fgs_id->id,
                                            'PR_number'=> $request->transBasemoldPR,
                                            'GR_number' => $request->transBasemoldGR,
                                            'fgs_rework_IN' => $request->trans_fgs_in,
                                            'EOH' => $final_eoh,
                                            'created_at' => NOW()
                                        ]);
                
                                        ReworkVisualTransaction::insert([
                                            'date' => $request->trans_date,
                                            'fk_rework_id' => $fgs_rework_visual_id,
                                        ]);
                                        
                                        wipTransaction::insert([
                                            'fk_basemold_id' => $basemold_wip_id,
                                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                                            'transaction_date' => NOw(),
                                            'remarks' => $request->trans_remarks
                                        ]);
    
                                        wipTransaction::insert([
                                            'fk_basemold_id' => $basemold_wip_id1,
                                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                                            'transaction_date' => NOw(),
                                            'remarks' => $request->trans_remarks
                                        ]);
                                    }
                                    
                                // return $glued_trans_next_eoh;
                
                                }
                                return response()->json(['result' => 1]);
                            }
                            else{

                                $fgs_eoh = $get_fgs_recieve_data1->EOH;
                                $final_eoh =  $fgs_eoh + $request->trans_fgs_in;
                
                            
                                // FOR GLUED MATERIAL
                                if($request->transactionIdForTable1 == null){
                                    // return "not";
                                    BasemoldWip::where('id', $request->transactionIdForTable)
                                    ->update([
                                        'logdel' => 1,
                                    ]);
                    
                                    $basemold_wip_id = BasemoldWip::insertGetId([
                                    'fk_basemold_id' => $request->transBasemoldId,
                                    'PR_number' => $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'OUT' =>  $request->trans_b_out,
                                    'NG' => $request->trans_grinded_ng,
                                    'golden_sample' => $request->trans_grinded_gsamp,
                                    'EOH' => $request->trans_next_eoh,
                                    'created_at' => NOW()
                                    ]);

                                    $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                    'fk_fgs_id' => $fgs_id->id,
                                    'PR_number'=> $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'fgs_rework_IN' => $request->trans_fgs_in,
                                    'EOH' => $final_eoh,
                                    'remarks' => $get_fgs_recieve_data1->remarks,
                                    'created_at' => NOW()
                                    ]);
            
                                    ReworkVisualTransaction::insert([
                                        'date' => $request->trans_date,
                                        'fk_rework_id' => $fgs_rework_visual_id,
                                    ]);

                                    wipTransaction::insert([
                                        'fk_basemold_id' => $basemold_wip_id,
                                        'fk_rework_visual_id' => $fgs_rework_visual_id,
                                        'transaction_date' => NOw(),
                                        'remarks' => $request->trans_remarks
                                    ]);

                            
                
                
                                }
                                else{
                                    // return "glued";

                                    if(($request->trans_b_out%2) != 0){
                                        return response()->json(['result' => 0]);
                                    }
                                    else{
                                        $glued_out = $request->trans_b_out/2;
                                        $glued_trans_next_eoh = $request->trans_next_eoh/2;
                    
                                        BasemoldWip::where('id', $request->transactionIdForTable)
                                        ->orWhere('id', $request->transactionIdForTable1)
                                        ->update([
                                            'logdel' => 1,
                                        ]);
                        
                                        $basemold_wip_id = BasemoldWip::insertGetId([
                                        'fk_basemold_id' => $request->transBasemoldId,
                                        'PR_number' => $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'OUT' =>  $glued_out,
                                        'NG' => $request->trans_grinded_ng,
                                        'golden_sample' => $request->trans_grinded_gsamp,
                                        'EOH' => $glued_trans_next_eoh,
                                        'created_at' => NOW()
                                        ]);
                    
                                        $basemold_wip_id1 = BasemoldWip::insertGetId([
                                        'fk_basemold_id' => $request->transBasemoldId1,
                                        'PR_number' => $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'OUT' =>  $glued_out,
                                        'NG' => $request->trans_grinded_ng,
                                        'golden_sample' => $request->trans_grinded_gsamp,
                                        'EOH' => $glued_trans_next_eoh,
                                        'created_at' => NOW()
                                        ]);

                                        $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                            'fk_fgs_id' => $fgs_id->id,
                                            'PR_number'=> $request->transBasemoldPR,
                                            'GR_number' => $request->transBasemoldGR,
                                            'fgs_rework_IN' => $request->trans_fgs_in,
                                            'EOH' => $final_eoh,
                                            'remarks' => $get_fgs_recieve_data1->remarks,
                                            'created_at' => NOW()
                                        ]);
                
                                        ReworkVisualTransaction::insert([
                                            'date' => $request->trans_date,
                                            'fk_rework_id' => $fgs_rework_visual_id,
                                        ]);
        
                                        wipTransaction::insert([
                                            'fk_basemold_id' => $basemold_wip_id,
                                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                                            'transaction_date' => NOw(),
                                            'remarks' => $request->trans_remarks
                                        ]);

                                        wipTransaction::insert([
                                            'fk_basemold_id' => $basemold_wip_id1,
                                            'fk_rework_visual_id' => $fgs_rework_visual_id,
                                            'transaction_date' => NOW(),
                                            'remarks' => $request->trans_remarks
                                        ]);
                
                                    }
                                }
                            
                                return response()->json(['result' => 1]);
                            }
                            
                        }
                        else{
                            // return "hindi";
                            if($request->transactionIdForTable1 == null){
                                // return "not";
                                BasemoldWip::where('id', $request->transactionIdForTable)
                                ->update([
                                    'logdel' => 1,
                                ]);
                
                                $basemold_wip_id = BasemoldWip::insertGetId([
                                   'fk_basemold_id' => $request->transBasemoldId,
                                   'PR_number' => $request->transBasemoldPR,
                                   'GR_number' => $request->transBasemoldGR,
                                   'OUT' =>  $request->trans_b_out,
                                   'NG' => $request->trans_grinded_ng,
                                   'golden_sample' => $request->trans_grinded_gsamp,
                                   'EOH' => $request->trans_next_eoh,
                                   'created_at' => NOW()
                                ]);
    
                                $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                    'fk_fgs_id' => $fgs_id->id,
                                    'PR_number'=> $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'fgs_rework_IN' => $request->trans_fgs_in,
                                    'EOH' => $request->trans_fgs_in,
                                    'created_at' => NOW()
                                ]);
        
                                ReworkVisualTransaction::insert([
                                    'date' => $request->trans_date,
                                    'fk_rework_id' => $fgs_rework_visual_id,
                                ]);
                                
                                wipTransaction::insert([
                                    'fk_basemold_id' => $basemold_wip_id,
                                    'fk_rework_visual_id' => $fgs_rework_visual_id,
                                    'transaction_date' => NOW(),
                                    'remarks' => $request->trans_remarks
                                ]);
                                return response()->json(['result' => 1]);
                                
            
                            }else{
                                if(($request->trans_b_out%2) != 0){
                                    return response()->json(['result' => 0]);
                                }
                                else{
                                    $glued_out = $request->trans_b_out/2;
                                    $glued_trans_next_eoh = $request->trans_next_eoh/2;
                
                                    BasemoldWip::where('id', $request->transactionIdForTable)
                                    ->orWhere('id', $request->transactionIdForTable1)
                                    ->update([
                                        'logdel' => 1,
                                    ]);
                    
                                    $basemold_wip_id = BasemoldWip::insertGetId([
                                    'fk_basemold_id' => $request->transBasemoldId,
                                    'PR_number' => $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'OUT' =>  $glued_out,
                                    'NG' => $request->trans_grinded_ng,
                                    'golden_sample' => $request->trans_grinded_gsamp,
                                    'EOH' => $glued_trans_next_eoh,
                                    'created_at' => NOW()
                                    ]);
                
                                    $basemold_wip_id1 = BasemoldWip::insertGetId([
                                    'fk_basemold_id' => $request->transBasemoldId1,
                                    'PR_number' => $request->transBasemoldPR,
                                    'GR_number' => $request->transBasemoldGR,
                                    'OUT' =>  $glued_out,
                                    'NG' => $request->trans_grinded_ng,
                                    'golden_sample' => $request->trans_grinded_gsamp,
                                    'EOH' => $glued_trans_next_eoh,
                                    'created_at' => NOW()
                                    ]);
    
                                    $fgs_rework_visual_id = ReworkVisual::insertGetId([
                                        'fk_fgs_id' => $fgs_id->id,
                                        'PR_number'=> $request->transBasemoldPR,
                                        'GR_number' => $request->transBasemoldGR,
                                        'fgs_rework_IN' => $request->trans_fgs_in,
                                        'EOH' => $request->trans_fgs_in,
                                        'created_at' => NOW()
                                    ]);
            
                                    ReworkVisualTransaction::insert([
                                        'date' => $request->trans_date,
                                        'fk_rework_id' => $fgs_rework_visual_id,
                                    ]);
                                    
                                    wipTransaction::insert([
                                        'fk_basemold_id' => $basemold_wip_id,
                                        'fk_rework_visual_id' => $fgs_rework_visual_id,
                                        'transaction_date' => NOW(),
                                        'remarks' => $request->trans_remarks
                                    ]);
    
                                    wipTransaction::insert([
                                        'fk_basemold_id' => $basemold_wip_id1,
                                        'fk_rework_visual_id' => $fgs_rework_visual_id,
                                        'transaction_date' => NOW(),
                                        'remarks' => $request->trans_remarks
                                    ]);
                                }
                                return response()->json(['result' => 1]);

                            }
                        }                        
                    }
                }
            }
        }
    }


    public function get_fgs_code(Request $request){
        $get_fgs_code = FGS::distinct()
        ->where('logdel', 0)
        ->get('fgs_code');

        return response()->json(['result' => $get_fgs_code]);
    }

    public function get_fgs_name(Request $request){
        $get_fgs_name = FGS::where('fgs_code', $request->code)
        ->where('logdel', 0)
        ->get('fgs_name');

        return response()->json(['result' => $get_fgs_name]);
    }


    public function get_fgs_details(){
        // $fgs_details = FgsRecieve::with([
        //     'fgs_details'
        // ])
        // ->orderBy('id', 'desc')
        // ->where('logdel', 0)
        // ->get();

        $fgs_details = FgsRecieve::with([
            'fgs_details'
        ])
        ->where('PR_number','!=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
  
        $fgs_details1 = FgsRecieve::with([
            'fgs_details'
        ])
        ->where('PR_number','=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();

          
        $fgs_details = collect($fgs_details)->unique('PR_number')->flatten(1);
        $fgs_details = collect($fgs_details)->where('EOH', '!=', 0)->flatten(1);
        $fgs_details1 = collect($fgs_details1)->unique('GR_number')->flatten(1);
        $fgs_details1 = collect($fgs_details1)->where('EOH', '!=', 0)->flatten(1);
        // $wip_basemold = collect($wip_basemold)->unique('fk_basemold_id')->flatten(1);
        $fgs_details2 = $fgs_details->merge($fgs_details1);
        // return $fgs_details;
        
        return DataTables::of($fgs_details2)
        ->addColumn('action', function($fgs){
            $result = "";
            
                $result .= '<center><button class="btn btn-info btn-sm  btn-fgs mr-1"  data-toggle="modal" fgs-id="'.$fgs->id.'"><i class="fas fa-eye"></i></button>';
         
                $result .= '<button class="btn btn-secondary btn-sm btn-fgs-remarks mr-1"  data-toggle="modal" data-target="#modalFgsRemarks" fgs-id="'.$fgs->id.'"><i class="fas fa-edit"></i></button>';
    
            // $result .= '<button class="btn btn-primary btn-sm  btn-edt-basemold mr-1"  data-toggle="modal" data-target="#modalAddBaseMold" basemold-id="'.$basemold->id.'"><i class="fa fa-edit"></i></button>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function get_fgs_info(Request $request){

        $fgs_recieve_details = FgsRecieve::with([
            'fgs_details'
        ])
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->where('id', $request->fgsId)
        ->get();

        $fgs_details1 = collect($fgs_recieve_details)->unique('fk_fgs_id')->flatten(1);
        


       


        // return $fgs_recieve_details;

        // $fgs_details = FGS::where('id' => )
      

        return response()->json(['result' => $fgs_details1]);
    }
    public function get_fgs_info_for_transaction(Request $request){

        $fgs_recieve_details = FgsRecieve::with([
            'fgs_details'
        ])
        ->where('logdel', 0)
        // ->where('id', $request->fgsId)
        ->where('PR_number', $request->fgsPR)
        ->where('GR_number', $request->fgsGR)
        ->orderBy('id', 'desc')
        ->get();

        $fgs_details1 = collect($fgs_recieve_details)->unique('fk_fgs_id')->flatten(1);


        $get_rapid_shipout_info_by_id = FromRapidShipment::where('id', $request->fgsShipoutId)
        ->get();


        // return $fgs_recieve_details;

        // $fgs_details = FGS::where('id' => )
      

        return response()->json(['result' => $fgs_details1, 'shipout' => $get_rapid_shipout_info_by_id]);
    }

    
    

    public function getFgsInfoForTransaction(Request $request){
        

        $fgs_recieve_details = FgsRecieve::with([
            'fgs_details'
        ])
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->where('fk_fgs_id', $request->transacId)
        ->first();


        return $fgs_recieve_details;
        // return DataTables::of($fgs_recieve_details)
        // ->make(true);
        
    }



    public function get_shipout(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_fgs_details = FgsRecieve::with([
            'fgs_details'
        ])
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->where('id', $request->fgsId)
        ->first();

        if($get_fgs_details->PR_number != null || $get_fgs_details->PR_number != "N/A"){
            // return "test";
            $rapid_shipment = RapidShipment::where('PONo',$get_fgs_details->PR_number)
            ->whereBetween('LastUpdate', ['2022-02-01 00:00:00', date("Y-m-d H:i:s")])
            ->where('Partscode', $get_fgs_details->fgs_details->fgs_code)
            ->where('logdel', 0)
            ->orderBy('id', 'desc')
            ->get();
        }
        else{
            $rapid_shipment = RapidShipment::whereBetween('LastUpdate', ['2022-02-01 00:00:00', date("Y-m-d H:i:s")])
            ->where('DeviceName',  $get_fgs_details->fgs_details->fgs_name)
            ->where('Partscode', $get_fgs_details->fgs_details->fgs_code)
            ->where('logdel', 0)
            ->Where('PONo',$get_fgs_details->GR_number)
            ->orderBy('id', 'desc')
            ->get();
        }

        //INSERTING NEW TRANSACTION
        for($i = 0; $i < count($rapid_shipment); $i++){
            $check_shipment_from_rapidx = FromRapidShipment::where('rapid_id', $rapid_shipment[$i]->id)
            ->get();
            if(count($check_shipment_from_rapidx) == 0){

                FromRapidShipment::insert([
                    'rapid_id' => $rapid_shipment[$i]->id,
                    'PONo' => $rapid_shipment[$i]->PONo,
                    'Partscode' => $rapid_shipment[$i]->Partscode,
                    'DeviceName' => $rapid_shipment[$i]->DeviceName,
                    'Qty' => $rapid_shipment[$i]->Qty,
                    'logdel' => $rapid_shipment[$i]->logdel,
                    'LastUpdate' => $rapid_shipment[$i]->LastUpdate,
                ]);
            }
            else{
            }

        }
    
       
        $get_rapidx_tbl_rapid_shipment_for_del = FromRapidShipment::where('PONo', $get_fgs_details->PR_number)
        ->get();
       
        for($x = 0; $x<count($get_rapidx_tbl_rapid_shipment_for_del); $x++){
           
            $rapid_shipment_for_del = RapidShipment::where('id', $get_rapidx_tbl_rapid_shipment_for_del[$x]->rapid_id)
            ->first();
    
            if($get_rapidx_tbl_rapid_shipment_for_del[$x]->logdel == $rapid_shipment_for_del->logdel){
                
            }
            else{
                FromRapidShipment::where('rapid_id', $rapid_shipment_for_del->id)
                ->update([
                    'logdel' => 1
                ]);
            }

        }
        return response()->json(['result' => $rapid_shipment, 'test' => $get_fgs_details]);

    }


    public function getFgsShipment(Request $request){

        $fgsPRId = $request->fgsPRId;
        $fgsGRId = $request->fgsGRId;
        $fgsPartCodeId = $request->fgsPartCodeId;
        $fgsPartNameId = $request->fgsPartNameId;
        // $transactionIdForFgsTable = $request->transactionIdForFgsTable;


        $get_fgs_shipment_details = FromRapidShipment::where('Partscode', $fgsPartCodeId)
        // ->orWhere('DeviceName', $fgsPartNameId)
        ->where('PONo', $fgsPRId)
        ->where('logdel', 0)
        ->orWhere('PONo', $fgsGRId)
        ->orderBy('LastUpdate','DESC')
        ->get();

        return DataTables::of($get_fgs_shipment_details)
        ->addColumn('date', function($get_fgs_shipment_details){
            $result = "";
            $date = $get_fgs_shipment_details->LastUpdate;
            // $result = date_format($date,'m-d-Y');
            $result = date('m-d-Y', strtotime($date));  
            return $result;
        })
        ->addColumn('status', function($get_fgs_shipment_details){
        $result = "";
        if($get_fgs_shipment_details->rapid_status == 0){
            $result .="<center><span class='badge badge-secondary'>Pending</span></center>";
        }
        else{
            $result .="<center><span class='badge badge-success'>Confirmed</span></center>";
        }
        return $result;
        })
        ->addColumn('action', function($get_fgs_shipment_details){
            $result = "";
            if($get_fgs_shipment_details->rapid_status == 0){
                $result .= '<center><button class="btn btn-info btn-sm  btn-fgs-accept mr-1"  data-toggle="modal" data-target="#FgsAcceptModal" shipout-id="'.$get_fgs_shipment_details->id.'"><i class="fas fa-bars"></i></button>';
            }
            else{
            }
            return $result;
        })
        ->rawColumns(['date','status','action'])
        ->make(true);
    }

    public function insert_fgs_transaction(Request $request){

        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;

        $validator = Validator::make($data, [
            'trans_fgs_date' => 'required',
            'trans_fgs_out' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
            // if($request->golden_sample == 1){
            // return response()->json(['goldSampleValidation' => '0']);

            // }
            // else{


                if($request->trans_fgs_out > $request->trans_qtytoship){ //CONDITION KAPAG ANG GRINDED ITEMS OUT AY MAS MALAKI KESA SA QTY TO SHIPOUT SA BUYOFF TRANSACTION MODAL
                    // return "sobra";
                    if($request->trans_fgs_remarks == null){
                        
                        return response()->json(['result' => '0']);

                    }
                    else{
                         // UPDATE THE DATATABLE IN FGS TRANSACTION
                        FromRapidShipment::where('id',$request->idshipout)
                        ->update([
                            'rapid_status' => 1
                        ]);
            
                        $fgs_recieve_id = FgsRecieve::insertGetId([
                            'fk_fgs_id' => $request->FkfgsId,
                            'PR_number' => $request->fgsPr,
                            'GR_number' => $request->fgsGr,
                            'fgs_OUT' => $request->trans_fgs_out,
                            'EOH' => $request->trans_fgs_next_eoh,
                            'remarks' => $request->fgs_remarks
                        ]);

                        wipTransaction::insert([
                            'fk_fgs_recieve_id' => $fgs_recieve_id,
                            'remarks' => $request->trans_fgs_remarks,
                            'transaction_date' => NOW()
                        ]);
                        // return $fgs_recieve_id;

                        return response()->json(['result' => '1', 'buyoff_id' => $fgs_recieve_id, 'remarks' => $request->trans_fgs_remarks]);
                    }
                }
                else{
                    // UPDATE THE DATATABLE IN FGS TRANSACTION
                    FromRapidShipment::where('id',$request->idshipout)
                    ->update([
                        'rapid_status' => 1
                    ]);
        
                    $fgs_recieve_id = FgsRecieve::insertGetId([
                        'fk_fgs_id' => $request->FkfgsId,
                        'PR_number' => $request->fgsPr,
                        'GR_number' => $request->fgsGr,
                        'fgs_OUT' => $request->trans_fgs_out,
                        'EOH' => $request->trans_fgs_next_eoh,
                        'remarks' => $request->fgs_remarks
                    ]);

                    wipTransaction::insert([
                        'fk_fgs_recieve_id' => $fgs_recieve_id,
                        'remarks' => $request->trans_fgs_remarks,
                        'transaction_date' => NOW()
                    ]);
                    // return $fgs_recieve_id;

                    return response()->json(['result' => '1', 'buyoff_id' => $fgs_recieve_id, 'remarks' => '']);

                }
             
            // }
        }
    }


    public function get_rework_visual_details(){
        // $rework_visual_details = ReworkVisual::with([
        //     'fgs_details'
        // ])
        // ->orderBy('id', 'desc')
        // ->where('logdel', 0)
        // ->get();

        $rework_visual_details = ReworkVisual::with([
            'fgs_details'
        ])
        ->where('PR_number','!=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
  
        $rework_visual_details1 = ReworkVisual::with([
            'fgs_details'
        ])
        ->where('PR_number','=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();

       
        // $fgs_details = collect($fgs_details)->unique('fk_fgs_id')->flatten(1);
        $rework_visual_details = collect($rework_visual_details)->unique('PR_number')->flatten(1);
        $rework_visual_details = collect($rework_visual_details)->where('EOH', '!=', 0)->flatten(1);
        $rework_visual_details1 = collect($rework_visual_details1)->unique('GR_number')->flatten(1);
        $rework_visual_details1 = collect($rework_visual_details1)->where('EOH', '!=', 0)->flatten(1);

        // $rework_visual_details = collect($rework_visual_details)->unique('PR_number')->flatten(1);
        $rework_visual_details2 = $rework_visual_details->merge($rework_visual_details1);



        // return $fgs_details;
        
        return DataTables::of($rework_visual_details2)
        ->addColumn('action', function($rework_visual_details){
            $result = "";
            
                $result .= '<center><button class="btn btn-info btn-sm  btn-rework-visual mr-1" data-target="#reworkVisualModal"  data-toggle="modal" rework-visual-id="'.$rework_visual_details->id.'"><i class="fas fa-eye"></i></button>';
                $result .= '<button class="btn btn-secondary btn-sm  btn-rework-visual-edit mr-1" data-target="#reworkVisualModalEdit"  data-toggle="modal" rework-visual-id="'.$rework_visual_details->id.'"><i class="fa fa-edit"></i></button></center>';
         
    
            // $result .= '<button class="btn btn-primary btn-sm  btn-edt-basemold mr-1"  data-toggle="modal" data-target="#modalAddBaseMold" basemold-id="'.$basemold->id.'"><i class="fa fa-edit"></i></button>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function get_rework_visual_info_by_id(Request $request){

        $rework_visual_details = ReworkVisual::with([
            'fgs_details'
        ])
        ->where('id', $request->reworkVisualId)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
        

        return response()->json(['result' => $rework_visual_details]);

    }

    public function get_rework_visual_transaction(Request $request){

        if($request->reworkPRNumuberId != null){
            $rework_visual_transaction = ReworkVisualTransaction::with([
                'rework_visual_info',
                'rework_visual_info.fgs_details'
            ])
            // ->where('rework_visual_info.PR_number', $request->reworkPRNumuberId)
            ->where('logdel', 0)
            ->orderBy('id', 'desc')
            ->get();
            
            $rework_visual_transaction = collect($rework_visual_transaction)
            ->where('rework_visual_info.PR_number', $request->reworkPRNumuberId)
            ->where('rework_visual_info.fgs_details.fgs_code', $request->reworkPartCodeId)
            ->where('rework_visual_info.fgs_details.fgs_name', $request->reworkPartNameId);
        }
        else{
            $rework_visual_transaction = ReworkVisualTransaction::with([
                'rework_visual_info',
                'rework_visual_info.fgs_details'
            ])
            // ->where('rework_visual_info.PR_number', $request->reworkPRNumuberId)
            ->where('logdel', 0)
            ->orderBy('id', 'desc')
            ->get();
            
            $rework_visual_transaction = collect($rework_visual_transaction)
            ->where('rework_visual_info.GR_number', $request->reworkGRNumuberId)
            ->where('rework_visual_info.fgs_details.fgs_code', $request->reworkPartCodeId)
            ->where('rework_visual_info.fgs_details.fgs_name', $request->reworkPartNameId);
        }
       
        // ->whereIn('rework_visual_info.GR_number', $request->reworkGRNumuberId);

        // $rework_visual_transaction = collect($rework_visual_transaction)->orWhere('rework_visual_info.GR_number', $request->reworkGRNumuberId);

        // return $rework_visual_transaction;
        
     
        return DataTables::of($rework_visual_transaction)
        ->addColumn('status', function($rework_visual_transaction){
            $result = "";

            if($rework_visual_transaction->status == 0){
                $result = "<center><span class='badge badge-secondary'>For Rework & Visual</span></center>";
            }
            else{
                $result = "<center><span class='badge badge-success'>Done</span></center>";

            }
          

            return $result;
        })
        ->addColumn('action', function($rework_visual_transaction){
            $result = "";
            if($rework_visual_transaction->status == 0){
                $result .= '<center><button class="btn btn-info btn-sm btn-visual-rework-transact mr-1" data-target="#reworkVisualTransactionModal"  data-toggle="modal" rework-visual-transact-id="'.$rework_visual_transaction->id.'"><i class="fas fa-eye"></i></button>';

            }

    
    
            return $result;
        })
        ->rawColumns(['status','action'])
        ->make(true);

        // return $test;
    }

    public function get_data_for_rework_visual_transaction(Request $request){
        

        $reworktransaction = ReworkVisualTransaction::with([
            'rework_visual_info'
        ])
        ->where('id', $request->reworkVisualTransactId)
        ->get();


        return response()->json(['result' => $reworktransaction]);
    }

    public function inset_rework_visual_transaction(Request $request){
        date_default_timezone_set('Asia/Manila');
        

        $data = $request->all();
        if($request->visualNG == null){
            $request->visualNG = 0;
        }
        if($request->reworkNG == null){
            $request->reworkNG = 0;

        }
        $subtractedEOH = 0;

        if($request->buyoffQty != null){

            // $reworkvisualdata = ReworkVisual::where('id', $request->reworkVisualId)
            $reworkvisualdata = ReworkVisual::where('PR_number', $request->reworkPR)
            ->where('GR_number', $request->reworkGR)
            ->orderBy('id', 'desc')
            ->get();

            $NG = $request->visualNG + $request->reworkNG;
            $subtractedEOH = $reworkvisualdata[0]->EOH - $request->reworkVisualQty;

            // return $subtractedEOH;
            // return $subtractedEOH;
            $rework_visual_id = ReworkVisual::insertGetId([
                'fk_fgs_id' => $reworkvisualdata[0]->fk_fgs_id,
                'PR_number' => $reworkvisualdata[0]->PR_number,
                'GR_number' => $reworkvisualdata[0]->GR_number,
                'fgs_rework_out' => $request->reworkVisualQty,
                'fgs_rework_NG' => $request->reworkNG,
                'fgs_visual_NG' => $request->visualNG,
                'EOH' => $subtractedEOH
            ]);
        
            ReworkVisualTransaction::where('id', $request->reworkVisualTransactId)
            ->update([
                'status' => 1
            ]);


            

            $get_fgs_recieve = FgsRecieve::where('fk_fgs_id', $reworkvisualdata[0]->fk_fgs_id)
            ->where('PR_number', $reworkvisualdata[0]->PR_number)
            ->where('logdel', 0)
            ->orWhere('GR_number', $reworkvisualdata[0]->GR_number)
            ->orderBy('id','desc')
            ->get();



            if(count($get_fgs_recieve) == 0){
                // return "lagay bago";

                $fgs_recieve_id = FgsRecieve::insertGetId([
                    'fk_fgs_id' => $reworkvisualdata[0]->fk_fgs_id,
                    'PR_number'=> $reworkvisualdata[0]->PR_number,
                    'GR_number' => $reworkvisualdata[0]->GR_number,
                    'fgs_IN' => $request->buyoffQty,
                    'EOH' => $request->buyoffQty,
                    'created_at' => NOW()
                ]);


                wipTransaction::insert([
                    'fk_rework_visual_id' => $rework_visual_id,
                    'fk_fgs_recieve_id' => $fgs_recieve_id,
                    'transaction_date' => NOW()
                ]);
        
                return response()->json(['result' => 1]);

        
            }
            else{

                $get_fgs_recieve_for_update = FgsRecieve::where('fk_fgs_id', $reworkvisualdata[0]->fk_fgs_id)
                ->where('PR_number', $reworkvisualdata[0]->PR_number)
                ->where('logdel', 0)
                // ->orWhere('GR_number', $reworkvisualdata[0]->GR_number)
                ->orderBy('id','desc')
                ->first();

                if($get_fgs_recieve_for_update == null){
                    // return "wala";
                    $fgs_recieve_id = FgsRecieve::insertGetId([
                        'fk_fgs_id' => $reworkvisualdata[0]->fk_fgs_id,
                        'PR_number'=> $reworkvisualdata[0]->PR_number,
                        'GR_number' => $reworkvisualdata[0]->GR_number,
                        'fgs_IN' => $request->buyoffQty,
                        'EOH' => $request->buyoffQty,
                        'created_at' => NOW()
                    ]);
    
    
                    wipTransaction::insert([
                        'fk_rework_visual_id' => $rework_visual_id,
                        'fk_fgs_recieve_id' => $fgs_recieve_id,
                        'transaction_date' => NOW()
                    ]);
            
                    return response()->json(['result' => 1]);

                }
                else{
                    if($reworkvisualdata[0]->GR_number == $get_fgs_recieve_for_update->GR_number || strtoupper($get_fgs_recieve_for_update->GR_number) == 'FROM STOCK'){
                        // return "parehas";
                         $updatedEOH = $get_fgs_recieve_for_update->EOH + $request->buyoffQty;
    
                        $fgs_recieve_id = FgsRecieve::insertGetId([
                            'fk_fgs_id' => $reworkvisualdata[0]->fk_fgs_id,
                            'PR_number'=> $reworkvisualdata[0]->PR_number,
                            'GR_number' => $reworkvisualdata[0]->GR_number,
                            'fgs_IN' => $request->buyoffQty,
                            'EOH' => $updatedEOH,
                            'created_at' => NOW()
                        ]);
    
                        wipTransaction::insert([
                            'fk_rework_visual_id' => $rework_visual_id,
                            'fk_fgs_recieve_id' => $fgs_recieve_id,
                            'transaction_date' => NOW()
    
                        ]);
    
                        return response()->json(['result' => 1]);
                        
                    }
                    else{
                        // return "hindi parehas";
                        $fgs_recieve_id = FgsRecieve::insertGetId([
                            'fk_fgs_id' => $reworkvisualdata[0]->fk_fgs_id,
                            'PR_number'=> $reworkvisualdata[0]->PR_number,
                            'GR_number' => $reworkvisualdata[0]->GR_number,
                            'fgs_IN' => $request->buyoffQty,
                            'EOH' => $request->buyoffQty,
                            'created_at' => NOW()
                        ]);
        
        
                        wipTransaction::insert([
                            'fk_rework_visual_id' => $rework_visual_id,
                            'fk_fgs_recieve_id' => $fgs_recieve_id,
                            'transaction_date' => NOW()
                        ]);
                
                        return response()->json(['result' => 1]);
                    }
                }
                // return $updatedEOH;
            }
        }
        else{
            return response()->json(['result' => 0]);
        }

        
        
       
        
    }

    public function get_rework_visual_info_for_edit(Request $request){
        $rework_visual_info = ReworkVisual::where('id', $request->reworkVisualForEditId)
        ->get();

        // return $rework_visual_info;

        return response()->json(['result' => $rework_visual_info]);
    }

    public function insert_rework_visual_edit(Request $request){
        $data = $request->all();

        ReworkVisual::where('id', $request->reworkId)
        ->update([
            'remarks' => $request->RemarksForEdit,
        ]);

        // return $data;
        return response()->json(["result" => 1]);
    }

    public function get_fgs_details_for_remarks(Request $request){
        $fgs_details = FgsRecieve::where('id', $request->fgsId)->get();

        

        return response()->json(['result' => $fgs_details]);
    }

    public function add_remarks_fgs(Request $request){
        FgsRecieve::where('id', $request->fgdId)
        ->update([
            'remarks' => $request->RemarksForFgs,
        ]);

        return response()->json(['result' => 1]);
    }

    public function get_wip_details_for_remarks(Request $request){
        $wip_details = BasemoldWip::with([
            'basemold'
        ])
        ->where('id', $request->wipId)->get();

        return response()->json(['widDetails' => $wip_details]);


    }
    public function add_remarks_wip(Request $request){
        BasemoldWip::where('id', $request->wipId)
        ->update([
            'remarks' => $request->RemarksForWip,
        ]);

        return response()->json(['result' => 1]);
    }
   
   
}





