<?php

namespace App\Http\Controllers;

use QrCode;
use Illuminate\Http\Request;
use App\Model\BasemoldReceiveQr;
use Illuminate\Support\Facades\DB;
use App\Model\BasemoldQrRemarksList;

class CommonController extends Controller
{
    public function get_remarks(Request $request){
        $remarks = BasemoldQrRemarksList::whereNull('deleted_at')->get();

        return $remarks;
    }

    public function print_basemold_qr_code(Request $request){
        session_start();
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try{
            BasemoldQrRemarksList::firstOrCreate(
                ['remarks' => $request->sel_remarks],
                ['created_at' => NOW()]
            );

            BasemoldReceiveQr::insert([
                'basemold_receive_id' => $request->basemold_receive_id,
                'po_qty'              => $request->basemold_receive_po_qty,
                'bm_lot_no'           => $request->basemold_lot_no,
                'bm_sat'              => $request->basemold_sat,
                'sel_remarks'         => $request->sel_remarks,
                'bm_gold_sample'      => $request->basemold_gold_sample,
                'created_by'          => $_SESSION['rapidx_user_id'],
                'created_at'          => NOW(),
            ]);

            $data = $request->except(['_token', 'basemold_receive_id']);

            $label = "<b>{$request->basemold_receive_po_no}</b><br>{$request->basemold_receive_device_name}<br>{$request->basemold_receive_po_qty}<br>{$request->basemold_lot_no}<br>{$request->basemold_sat}<br>{$request->sel_remarks}<br>";
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

    public function basemold_reprint_qr(Request $request){
        $basemold_qr_raw_details = BasemoldReceiveQr::with([
            'basemold_receive_details',
            'basemold_receive_details.basemold'
        ])
        ->where('basemold_receive_id', $request->basemold_id)->first();

        $qr_data = array(
            'basemold_gold_sample' => $basemold_qr_raw_details->bm_gold_sample,
            'basemold_lot_no' => $basemold_qr_raw_details->bm_lot_no,
            'basemold_receive_device_name' => $basemold_qr_raw_details->basemold_receive_details->basemold->part_name,
            'basemold_receive_po_no' => $basemold_qr_raw_details->basemold_receive_details->pr_number,
            'basemold_receive_po_qty' => $basemold_qr_raw_details->po_qty,
            'basemold_sat' => $basemold_qr_raw_details->bm_sat,
            'sel_remarks' => $basemold_qr_raw_details->sel_remarks,
        );
        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate(json_encode($qr_data));
        $final_qr_code = "data:image/png;base64," . base64_encode($qrcode);

        $label = "<b>{$basemold_qr_raw_details->basemold_receive_details->pr_number}</b><br>{$basemold_qr_raw_details->basemold_receive_details->basemold->part_name}<br>{$basemold_qr_raw_details->po_qty}<br>{$basemold_qr_raw_details->bm_lot_no}<br>{$basemold_qr_raw_details->bm_sat}<br>{$basemold_qr_raw_details->sel_remarks}<br>";
        
        return response()->json([
            'result'  => true,
            'message' => 'QR Code Printed Successfully',
            'qrcode'  => $final_qr_code,
            'label'    => $label
        ]);
    }
}
