<?php

namespace App\Http\Controllers;

use QrCode;
use App\Model\ReworkQr;
use Illuminate\Http\Request;
use App\Model\RapidPOReceive;
use App\Model\ReworkQrRemarksList;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function get_remarks(Request $request){
        $remarks = ReworkQrRemarksList::whereNull('deleted_at')->get();

        return $remarks;
    }

    public function print_rework_qr_code(Request $request){
        session_start();
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try{
            ReworkQrRemarksList::firstOrCreate(
                ['remarks' => $request->sel_remarks],
                ['created_at' => NOW()]
            );

            ReworkQr::insert([
                'rework_id' => $request->rework_id,
                'po_qty'              => $request->rework_po_qty,
                'rw_lot_no'           => $request->rework_lot_no,
                'rw_sat'              => $request->rework_sat,
                'sel_remarks'         => $request->sel_remarks,
                'rw_gold_sample'      => $request->rework_gold_sample,
                'created_by'          => $_SESSION['rapidx_user_id'],
                'created_at'          => NOW(),
            ]);

            $data = $request->except(['_token', 'rework_id']);

            $label = "<b>{$request->rework_po_no}</b><br>{$request->rework_device_name}<br>{$request->rework_po_qty}<br>{$request->rework_lot_no}<br>{$request->rework_sat}<br>{$request->sel_remarks}<br>{$request->rework_gold_sample}<br>";
            $qrcode = QrCode::format('png')
            ->size(200)->errorCorrection('H')
            ->generate(json_encode($data));
            $final_qr_code = "data:image/png;base64," . base64_encode($qrcode);

            DB::commit();

            return response()->json([
                'result'  => true,
                'message' => 'QR Code Printed Successfully',
                'qrcode'  => $final_qr_code,
                'label'    => $label
            ]);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    // public function basemold_reprint_qr(Request $request){
    //     $basemold_qr_raw_details = ReworkQr::with([
    //         'basemold_receive_details',
    //         'basemold_receive_details.basemold'
    //     ])
    //     ->where('basemold_receive_id', $request->basemold_id)->first();

    //     $qr_data = array(
    //         'basemold_gold_sample' => $basemold_qr_raw_details->rw_gold_sample,
    //         'basemold_lot_no' => $basemold_qr_raw_details->rw_lot_no,
    //         'basemold_receive_device_name' => $basemold_qr_raw_details->basemold_receive_details->basemold->part_name,
    //         'basemold_receive_po_no' => $basemold_qr_raw_details->basemold_receive_details->pr_number,
    //         'basemold_receive_po_qty' => $basemold_qr_raw_details->po_qty,
    //         'basemold_sat' => $basemold_qr_raw_details->rw_sat,
    //         'sel_remarks' => $basemold_qr_raw_details->sel_remarks,
    //     );
    //     $qrcode = QrCode::format('png')
    //     ->size(200)->errorCorrection('H')
    //     ->generate(json_encode($qr_data));
    //     $final_qr_code = "data:image/png;base64," . base64_encode($qrcode);

    //     $label = "<b>{$basemold_qr_raw_details->basemold_receive_details->pr_number}</b><br>{$basemold_qr_raw_details->basemold_receive_details->basemold->part_name}<br>{$basemold_qr_raw_details->po_qty}<br>{$basemold_qr_raw_details->rw_lot_no}<br>{$basemold_qr_raw_details->rw_sat}<br>{$basemold_qr_raw_details->sel_remarks}<br>";
        
    //     return response()->json([
    //         'result'  => true,
    //         'message' => 'QR Code Printed Successfully',
    //         'qrcode'  => $final_qr_code,
    //         'label'    => $label
    //     ]);
    // }

    public function get_po_receive_item_name(Request $request){
        $po_receive_details = RapidPOReceive::where('OrderNo', $request->pr_num)->where('logdel', 0)->first();

        return $po_receive_details;
    }
}
