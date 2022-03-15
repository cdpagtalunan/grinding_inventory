<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use App\Model\WipTransaction;
use App\Model\Basemold;
use App\Model\BasemoldWip;
use App\Model\BasemoldRecieve;
use App\Model\FGS;
use App\Model\FgsRecieve;
use App\Model\RapidShipment;
use App\Model\FromRapidShipment;

use DataTables;

class TransactionController extends Controller
{
    //
    public function get_transaction(){
        $wip_transaction = WipTransaction::with([
            'basemold_recieve',
            'fgs_recieve',
            'Basemold_Wip',
            'rework_visual'
        ])
        ->where('logdel',0)
        ->get();

        return $wip_transaction;
    }


    public function get_setup_transaction(){
        $wip_transaction = WipTransaction::with([
            'basemold_recieve',
            'fgs_recieve',
            'basemold_wip',
            'rework_visual'
        ])
        ->whereNotNull('fk_basemold_id')
        ->where('logdel',0)
        ->orderBy('transaction_date', 'desc')
        ->get();

        // return $wip_transaction;

        return DataTables::of($wip_transaction)

        ->addColumn('action', function($wip_transaction){
            $result = "";
            

    
            $result .= '<center><button class="btn btn-info btn-sm btn-setup-transaction mr-1"  data-toggle="modal" data-target="#modalSetupTransaction"" transaction-id="'.$wip_transaction->id.'"><i class="fa fa-eye"></i></button></center>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    

    public function get_setup_transaction_details(Request $request){
        // return $request->setupTransactionId;

        $setup_transaction_details = WipTransaction::with([
            'basemold_recieve',
            'fgs_recieve',
            'basemold_wip.basemold',
            'rework_visual.fgs_details'
        ])
        ->where('id', $request->setupTransactionId)
        ->first();
        // return $setup_transaction_details;
        
        $result="";
        if($setup_transaction_details->fk_rework_visual_id != null){
            
            $result .='<div id="test">';

            $result .= '
            <div class="row">
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">For Set-up Part Code:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->basemold->code.'" readonly>
                </div>
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">For Set-up Part Name:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->basemold->part_name.'" readonly>
                </div>
                
            </div>
            <div class="row">
            <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Set-up NG:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->NG.'" readonly>
                </div><div class="form-group col-4">
                <label class="form-control-label text-secondary">For Set-up Golden Sample:</label> 
                <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->golden_sample.'" readonly>
            </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Set-up Out:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->OUT.'" readonly>
                </div>
            </div>
            ';


            // $result .='<div class="row">
           
            // </div>';


            $result  .='<hr>';

            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Code:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->rework_visual->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Name:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->rework_visual->fgs_details->fgs_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework & Visual In:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->rework_visual->fgs_rework_IN.'" readonly>
                </div>
            </div>';

            
            // $result .='<div class="row">
                
            // </div>';
            $result .='</div>';


        }
        else if($setup_transaction_details->fk_rework_visual_id == null){
            

            // return "in";
            $result .='<div id="test">';
            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Set-up Part Code:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->basemold->code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Set-up Part Name:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->basemold->part_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Set up In:</label> 
                    <input type="text" class="form-control" value="'.$setup_transaction_details->basemold_wip->IN.'" readonly>
                </div>
            </div>';


            // $result .='<div class="row">
            
            // </div>';

            $result .='</div>';
        }



        return response()->json(['result' => $result]);
        // return $setup_transaction_details;
    }


    public function get_rework_visual_transaction(){
        $rework_visual_transaction = WipTransaction::with([
            'basemold_recieve.basemold',
            'fgs_recieve.fgs_details',
            'basemold_wip.basemold',
            'rework_visual.fgs_details'
        ])
        ->whereNotNull('fk_rework_visual_id')
        ->where('logdel',0)
        ->orderBy('transaction_date', 'desc')
        ->get();

        // return $rework_visual_transaction;

        return DataTables::of($rework_visual_transaction)

        ->addColumn('action', function($rework_visual_transaction){
            $result = "";
            

    
            $result .= '<center><button class="btn btn-info btn-sm btn-rework-visual-transaction mr-1"  data-toggle="modal" data-target="#modalReworkVisualTransaction"" transaction-id="'.$rework_visual_transaction->id.'"><i class="fa fa-eye"></i></button></center>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }



    public function get_rework_visual_transaction_details(Request $request){
        $rework_visual_transaction_details = WipTransaction::with([
            'basemold_recieve.basemold',
            'fgs_recieve.fgs_details',
            'basemold_wip.basemold',
            'rework_visual.fgs_details'
        ])
        ->where('id', $request->reworkVisualTransactionId)
        ->where('logdel',0)
        ->orderBy('transaction_date', 'desc')
        ->first();

        $result = "";
        // return $rework_visual_transaction_details;
        if($rework_visual_transaction_details->fk_basemold_id != null){
            // return "in";
            $result .='<div id="test">';

            $result .= '
            <div class="row">
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">For Set-up Part Code:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->basemold_wip->basemold->code.'" readonly>
                </div>
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">For Set-up Part Name:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->basemold_wip->basemold->part_name.'" readonly>
                </div>
               
            </div>

            <div class="row">
                <div class="form-group col-4">
                        <label class="form-control-label text-secondary">For Set-up NG:</label> 
                        <input type="text" class="form-control" value="'.$rework_visual_transaction_details->basemold_wip->NG.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Set-up Golden Sample:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->basemold_wip->golden_sample.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Set-up Out:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->basemold_wip->OUT.'" readonly>
                </div>
            </div>
            
            ';

            $result  .='<hr>';

            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Code:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Name:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_details->fgs_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework & Visual In:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_rework_IN.'" readonly>
                </div>
            </div>';
            $result .='</div>';

        }
        else{
            // return "out";
            $result .='<div id="test">';
            $result .= '
            <div class="row">
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Code:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Name:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_details->fgs_name.'" readonly>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework NG:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_rework_NG.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Visual NG:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_visual_NG.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework & Visual OUT:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->rework_visual->fgs_rework_OUT.'" readonly>
                </div>
            </div>
            
            ';

            $result  .='<hr>';

            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Buy-off Code:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->fgs_recieve->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Buy-off Part Name:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->fgs_recieve->fgs_details->fgs_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Buy-off In:</label> 
                    <input type="text" class="form-control" value="'.$rework_visual_transaction_details->fgs_recieve->fgs_IN.'" readonly>
                </div>
            </div>';


            // $result .='<div class="row">
            
            // </div>';

            $result .='</div>';
        }

        return response()->json(['result' => $result]);

    }


    public function get_buyoff_transaction_history(){
        $buyoff_transaction = WipTransaction::with([
            'basemold_recieve.basemold',
            'fgs_recieve.fgs_details',
            'basemold_wip.basemold',
            'rework_visual.fgs_details'
        ])
        ->whereNotNull('fk_fgs_recieve_id')
        ->where('logdel',0)
        ->orderBy('transaction_date', 'desc')
        ->get();

        return DataTables::of($buyoff_transaction)

        ->addColumn('action', function($buyoff_transaction){
            $result = "";
            

    
            $result .= '<center><button class="btn btn-info btn-sm btn-buyoff-transaction mr-1"  data-toggle="modal" data-target="#modalBuyoffTransaction"" transaction-id="'.$buyoff_transaction->id.'"><i class="fa fa-eye"></i></button></center>';
            // $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
    
    
    
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
        // return $rework_visual_transaction;
    }


    public function get_buyoff_transaction_details(Request $request){
        $buyoff_transaction_details = WipTransaction::with([
            'basemold_recieve.basemold',
            'fgs_recieve.fgs_details',
            'basemold_wip.basemold',
            'rework_visual.fgs_details'
        ])
        ->where('id', $request->buyoffTransactionId)
        ->where('logdel',0)
        ->orderBy('transaction_date', 'desc')
        ->first();

        $result = "";
        // return $buyoff_transaction_details;
        if($buyoff_transaction_details->rework_visual == null){
            // return "Out";
            $result .='<div id="test">';
            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Buy-off Code:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">Buy-off Part Name:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_details->fgs_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Buy-off OUT:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_OUT.'" readonly>
                </div>
            </div>';
            $result .='
            <div class="row">
                <div class="col">
                    <label class="form-control-label text-secondary">Buy-off Remarks:</label> 
                  
                    <textarea class="form-control" readonly>'.$buyoff_transaction_details->remarks.'</textarea>
                </div>
            </div>
            ';
           

            $result .='</div>';


        }
        else{
            // return "IN";
            $result .='<div id="test">';
            $result .= '
            <div class="row">
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Code:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->rework_visual->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-6"> 
                    <label class="form-control-label text-secondary">Rework & Visual Part Name:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->rework_visual->fgs_details->fgs_name.'" readonly>
                </div>
                
            </div>
            <div class="row">
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework NG:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->rework_visual->fgs_rework_NG.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Visual NG:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->rework_visual->fgs_visual_NG.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">Rework & Visual OUT:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->rework_visual->fgs_rework_OUT.'" readonly>
                </div>
            </div>

            
            ';

            $result  .='<hr>';

            $result .= '
            <div class="row">
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Buy-off Code:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_details->fgs_code.'" readonly>
                </div>
                <div class="form-group col-4"> 
                    <label class="form-control-label text-secondary">For Buy-off Part Name:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_details->fgs_name.'" readonly>
                </div>
                <div class="form-group col-4">
                    <label class="form-control-label text-secondary">For Buy-off In:</label> 
                    <input type="text" class="form-control" value="'.$buyoff_transaction_details->fgs_recieve->fgs_IN.'" readonly>
                </div>
            </div>';
          



            // $result .='<div class="row">
            
            // </div>';

            $result .='</div>';

        }


        return response()->json(['result' => $result]);
    }

}
