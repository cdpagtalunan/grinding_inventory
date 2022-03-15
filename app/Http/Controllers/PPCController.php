<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CSVBasemoldImport;
use App\Imports\CSVTSBasemoldImport;


use App\Model\Basemold;
use App\Model\BasemoldRecieve;


use DataTables;
class PPCController extends Controller
{
    //
    public function get_basemold_info(Request $request){

        // return $request->date_to.$request->date_from;
        // $basemold = Basemold::where('date','>=',$request->date_from)
        //             ->where('date','<=',$request->date_to)
        //             ->where('logdel', 0)
        //             ->get();
        $basemold = BasemoldRecieve::with([
            'basemold'
        ])
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
        // $basemold = Basemold::
        //             get();

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
                $result .= '<center><button class="btn btn-info btn-sm  btn-basemold mr-1"  data-toggle="modal" data-target="#modalViewBasemoldDetails" basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button>';
                $result .= '<button class="btn btn-primary btn-sm  btn-edt-basemold mr-1"  data-toggle="modal" data-target="#modalAddBaseMold" basemold-id="'.$basemold->id.'"><i class="fa fa-edit"></i></button>';
                $result .= '<button class="btn btn-danger btn-sm btn-del-basemold" data-toggle="modal" data-target="#modalDelBaseMold"  basemold-id="'.$basemold->id.'"><i class="fa fa-times"></i></button></center>';
            }
            else if($basemold->status == 4){
                $result .= '<center><button class="btn btn-info btn-sm  btn-basemold mr-1"  data-toggle="modal" data-target="#modalViewBasemoldDetails" basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button>';
                $result .= '<button class="btn btn-primary btn-sm  btn-edt-basemold mr-1"  data-toggle="modal" data-target="#modalAddBaseMold" basemold-id="'.$basemold->id.'"><i class="fa fa-edit"></i></button></center>';
           
            }
            else{
                $result .= '<center><button class="btn btn-info btn-sm  btn-basemold mr-1"  data-toggle="modal" data-target="#modalViewBasemoldDetails" basemold-id="'.$basemold->id.'"><i class="fas fa-eye"></i></button></center>';

            }

          
          

            return $result;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }

    public function add_basemold(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all(); // collect all input fields

        // return $data;

        $validator = Validator::make($data, [
            // 'pr_number' => 'required|string|max:255',
            'basemold_cat' => 'required',
            'code' => 'required|string|max:255',
            'part_name' => 'required|string|max:255',
            // 'no_of_items' => 'required|int',
            // 'lot_no' => 'required|string|max:255',
            // 'qty_basemold' => 'required|int',
            'confirm_qty' => 'required|int',
            // 'qty_after_grind' => 'required|int',

        ]);


        if($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }
        else{
            
            // FOR EDITING BASEMOLD
            if($request->basemoldId != null){


                BasemoldRecieve::where('id',$request->basemoldId)
                ->update([
                    // 'date' => $request->add_date,
                    'pr_number' => $request->pr_number,
                    'gr_number' => $request->gr_number,
                    // 'lot_no' => $request->lot_no,
                    'from' => $request->basemold_cat,
                    // 'no_of_items' => $request->no_of_items,
                    // 'qty_basemold' => $request->qty_basemold,
                    'qty_confirmed' => $request->confirm_qty,
                    'remarks' => $request->addRemark,
                    'status' => 0,
                    // 'qty_after_grinding' => $request->qty_after_grind,
                ]);

                Basemold::where('id', $request->fk_basemold_id)
                ->update([
                    'code' => $request->pr_number,
                    'part_name' => $request->gr_number
                ]);

                
                return response()->json(['result' => "2"]);
            }
            // FOR ADDING BASEMOLD
            else{
                $check_basemold_exist = Basemold::where('code',$request->code )
                                        ->where('part_name', $request->part_name)
                                        ->get();


                if(count($check_basemold_exist) == 0){
                    Basemold::insert([
                    
                        'code' => $request->code,
                        'part_name' => $request->part_name,
                        
                    ]);
                    $basemold = Basemold::where('code', $request->code)
                    ->where('part_name', $request->part_name)
                    ->first();
                    // return $basemold;
                    BasemoldRecieve::insert([
                        'date' => $request->add_date,
                        'fk_basemold_id' => $basemold->id,
                        'pr_number' => $request->pr_number,
                        'gr_number' => $request->gr_number,
                        // 'lot_no' => $request->lot_no,
                        'from' => $request->basemold_cat,
                        // 'no_of_items' => $request->no_of_items,
                        // 'qty_basemold' => $request->qty_basemold,
                        'qty_confirmed' => $request->confirm_qty,
                        'remarks' => $request->addRemark,
                        'created_by' => $_SESSION['rapidx_user_id'],
                        'created_at' => NOW(),
                        // 'qty_after_grinding' => $request->qty_after_grind,
                    ]);
                    return response()->json(['result' => "1"]);

                }
                else{
                    $basemold = Basemold::where('code', $request->code)
                    ->where('part_name', $request->part_name)
                    ->first();
                    // return $basemold;
                    BasemoldRecieve::insert([
                        'date' => $request->add_date,
                        'fk_basemold_id' => $basemold->id,
                        'pr_number' => $request->pr_number,
                        'gr_number' => $request->gr_number,
                        // 'lot_no' => $request->lot_no,
                        'from' => $request->basemold_cat,
                        // 'no_of_items' => $request->no_of_items,
                        // 'qty_basemold' => $request->qty_basemold,
                        'qty_confirmed' => $request->confirm_qty,
                        'remarks' => $request->addRemark,
                        'created_by' => $_SESSION['rapidx_user_id'],
                        'created_at' => NOW(),
                        // 'qty_after_grinding' => $request->qty_after_grind,
                    ]);
                    return response()->json(['result' => "1"]);

                }
                

            }


            
        }




    }

    public function get_basemold_for_view(Request $request){

        $get_basemold = BasemoldRecieve::with([
            'basemold'
        ])
        ->where('id',$request->basemoldId)->get();


        return response()->json(['result' => $get_basemold]);

    }

    public function get_code(){
        $get_code_and_name = Basemold::distinct()
                            ->where('logdel', 0)
                            ->get('code');


        return response()->json(['result' => $get_code_and_name]);

    }
    public function get_partname_by_code(Request $request){
        $partname = Basemold::where('code', $request->code)->where('logdel',0)->get('part_name');

        return response()->json(['result' => $partname]);
    }


    public function get_basemold_info_for_edit(Request $request){
        $basemold_info = BasemoldRecieve::with([
            'basemold'
        ])
        ->where('id', $request->basemoldId)->get();

        return response()->json(['result' => $basemold_info]);
    }

    public function delete_basemold(Request $request){
        $del_basemold = BasemoldRecieve::where('id',$request->delId)
                ->update([
                    'logdel' => 1
                ]);
        return response()->json(['result' => 1]);
    }


    public function import_basemold(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        
        $collections = Excel::toCollection(new CSVBasemoldImport, request()->file('import_file'));

        try{
            for($index = 1; $index < count($collections[0]); $index++){
                if($collections[0][$index][2] == null && $collections[0][$index][3] == null && $collections[0][$index][6] == null){

                }
                else{
                    $check_basemold_exist = Basemold::where('code',$collections[0][$index][2] )
                    ->where('part_name', $collections[0][$index][3])
                    ->get();
    
                    // return count($check_basemold_exist);
                    if(count($check_basemold_exist) == 0){
                    // $coll[] = "walang kapareho";
    
                        
                        $imported_basemold_id = Basemold::insertGetId([
                           'code' => $collections[0][$index][2],
                           'part_name' => $collections[0][$index][3]
                        ]);
        
                        BasemoldRecieve::insert([
                           'date' => date("Y-m-d", strtotime($collections[0][$index][0])),
                           'fk_basemold_id' => $imported_basemold_id,
                           'pr_number' => $collections[0][$index][4],
                           'gr_number' => $collections[0][$index][5],
                        //    'lot_no' => $collections[0][$index][5],
                           'from' =>  strtoupper($collections[0][$index][1]),
                        //    'no_of_items' =>  $collections[0][$index][7],
                        //    'qty_basemold' =>  $collections[0][$index][8],
                           'qty_confirmed' =>  $collections[0][$index][6],
                        //    'qty_after_grinding' =>  $collections[0][$index][10],
                           'remarks' =>  $collections[0][$index][7],
                           'created_by' => $_SESSION['rapidx_user_id'],
                           'created_at' => NOW(),
                       ]);
        
                        
                    }
                    else{
                    // $coll[] = "meron";
                        
                        $imported_basemold_id1 = Basemold::where('code', $collections[0][$index][2])
                        ->where('part_name', $collections[0][$index][3])
                        ->first();
        
                        BasemoldRecieve::insert([
                        'date' => date("Y-m-d", strtotime($collections[0][$index][0])),
                        'fk_basemold_id' => $imported_basemold_id1->id,
                        'pr_number' => $collections[0][$index][4],
                        'gr_number' => $collections[0][$index][5],
                        // 'lot_no' => $collections[0][$index][5],
                        'from' =>  strtoupper($collections[0][$index][1]),
                        // 'no_of_items' =>  $collections[0][$index][7],
                        // 'qty_basemold' =>  $collections[0][$index][8],
                        'qty_confirmed' =>  $collections[0][$index][6],
                        // 'qty_after_grinding' =>  $collections[0][$index][10],
                        'remarks' =>  $collections[0][$index][7],
                        'created_by' => $_SESSION['rapidx_user_id'],
                        'created_at' => NOW(),
                        ]);
                        
                    
        
        
        
                    }
                }

                
            }
            // return $coll;
            return response()->json(['result' => 1]);

        }
        catch(\Exception $e) {
           
        }
        
    }

    public function import_ts_basemold(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        $collections = Excel::toCollection(new CSVTSBasemoldImport, request()->file('import_file'));
        // return $collections;
        // try{
            for($index = 4; $index < count($collections[0]); $index++){
                if(($collections[0][$index][3] == null && $collections[0][$index][4] == null) && $collections[0][$index][6] == null){
                    return response()->json(['result' => 1]);
                }

                else if(($collections[0][$index][3] == null && $collections[0][$index][4] == null) && $collections[0][$index][6] != null){
                    // return response()->json(['result' => 1]);
                    // return "";
                    
                    // $basemold = BasemoldRecieve::where('id', $basemold_id)
                    // ->get();

                    // $glued_qty = $basemold[0]->qty_confirmed + $collections[0][$index][6];


                    // // return $glued_qty;
                    // BasemoldRecieve::where('id', $basemold_id)
                    // ->update([
                    //     'qty_confirmed' => $glued_qty,
                    // ]);

                    $basemold = BasemoldRecieve::where('id', $basemold_id)
                    ->get();

                    BasemoldRecieve::insert([
                        'date' => $basemold[0]->date,
                        'fk_basemold_id' => $basemold[0]->fk_basemold_id,
                        'pr_number' => $basemold[0]->pr_number,
                        'gr_number' => $basemold[0]->gr_number,
                        'from' => 'TS',
                        'qty_confirmed' => $collections[0][$index][6],
                        'remarks' => $basemold[0]->remarks,
                        'created_by' => $_SESSION['rapidx_user_id'],
                        'created_at' => NOW(),
                    ]);
                    
                    

                 
                }
                else{
                    

                    $check_basemold_exist = Basemold::where('code',$collections[0][$index][3] )
                    ->where('part_name', $collections[0][$index][4])
                    ->get();
                    
                    // return $collections[0][$index];



                    $excel_date = $collections[0][$index][0]; //here is that value 41621 or 41631
                    $unix_date = ($excel_date - 25569) * 86400;
                    $excel_date = 25569 + ($unix_date / 86400);
                    $unix_date = ($excel_date - 25569) * 86400;

                    if(count($check_basemold_exist) == 0){
                        

                        $imported_basemold_id = Basemold::insertGetId([
                            'code' => $collections[0][$index][3],
                            'part_name' => $collections[0][$index][4]
                        ]);

                        $basemold_id = BasemoldRecieve::insertGetId([
                            'date' => gmdate("Y-m-d", $unix_date),
                            'fk_basemold_id' => $imported_basemold_id,
                            'pr_number' => $collections[0][$index][7],
                            'gr_number' => $collections[0][$index][1],
                            'from' =>  'TS',
                            'qty_confirmed' =>  $collections[0][$index][6],
                            'remarks' =>  $collections[0][$index][11],
                            'created_by' => $_SESSION['rapidx_user_id'],
                            'created_at' => NOW(),
                        ]);
                    }
                    else{


                        $imported_basemold_id1 = Basemold::where('code', $collections[0][$index][3])
                        ->where('part_name', $collections[0][$index][4])
                        ->first();

                        // $get_basemold_exist = BasemoldRecieve::where('fk_basemold_id', $imported_basemold_id1->id)
                        // ->where('pr_number', $collections[0][$index][7])
                        // ->where('gr_number', $collections[0][$index][1])
                        // ->where('from', 'TS' )
                        // ->where('qty_confirmed', $collections[0][$index][5])
                        // ->where('remarks', $collections[0][$index][11])
                        // ->where('status', 0)
                        // ->get();


                        // return $test;
                        $basemold_id = BasemoldRecieve::insertGetId([
                            'date' => gmdate("Y-m-d", $unix_date),
                            'fk_basemold_id' => $imported_basemold_id1->id,
                            'pr_number' => $collections[0][$index][7],
                            'gr_number' => $collections[0][$index][1],
                            'from' =>  'TS',
                            'qty_confirmed' =>  $collections[0][$index][6],
                            'remarks' =>  $collections[0][$index][11],
                            'created_by' => $_SESSION['rapidx_user_id'],
                            'created_at' => NOW(),
                        ]);
                        
                    }
    
                }
            }

            return response()->json(['result' => 1]);

        // }
        // catch(\Exception $e) {
           
        // }
    }

    public function download_file(Request $request){
       
        $file =  storage_path() . "/app/public/testfolder/testimport.xlsx";
        // return $employee_infos;
        return Response::download($file);  
    }
}

