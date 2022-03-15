<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\UsersExport;

use App\Model\BasemoldWip;
use App\Model\FgsRecieve;
use App\Model\ReworkVisual;



class InvExcelController extends Controller
{
    //

    public function export() 
    {


        // TO EXPORT INVENTORY OF FOR SET UP(TBL_BASEMOLD_WIP)
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
        
        // $wip_basemold1 = collect($wip_basemold1)->unique('GR_number')->flatten(1);
        $wip_basemold2 = $wip_basemold->merge($wip_basemold1);
        $wip_basemold2 = collect($wip_basemold2)->where('EOH','!=', 0)->flatten(1);



        // TO EXPORT INVENTORY OF FOR BUYOFF(TBL_FGS_RECIEVE)
        $get_fgs = FgsRecieve::with([
            'fgs_details'
        ])
        ->where('PR_number','!=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
        $get_fgs1 = FgsRecieve::with([
            'fgs_details'
        ])
        ->where('PR_number','=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();

       
        // $get_fgs = collect($get_fgs)->unique('fk_fgs_id')->flatten(1);
        $get_fgs = collect($get_fgs)->unique('PR_number')->flatten(1);
        $get_fgs1 = collect($get_fgs1)->unique('GR_number')->flatten(1);

        $get_fgs2 = $get_fgs->merge($get_fgs1);
        $get_fgs2 = collect($get_fgs2)->where('EOH','!=', 0)->flatten(1);




        // TO EXPORT INVENTORY OF FOR REWORK AND VISUAL(TBL_REWORK_VISUAL)
        $get_rework_visual = ReworkVisual::with([
            'fgs_details'
        ])
        ->where('PR_number','!=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();
        $get_rework_visual1 = ReworkVisual::with([
            'fgs_details'
        ])
        ->where('PR_number','=',null)
        ->orderBy('id', 'desc')
        ->where('logdel', 0)
        ->get();

       
        // $get_fgs = collect($get_fgs)->unique('fk_fgs_id')->flatten(1);
        $get_rework_visual = collect($get_rework_visual)->unique('PR_number')->flatten(1);
        $get_rework_visual1 = collect($get_rework_visual1)->unique('GR_number')->flatten(1);

        $get_rework_visual2 = $get_rework_visual->merge($get_rework_visual1);
        $get_rework_visual2 = collect($get_rework_visual2)->where('EOH','!=', 0)->flatten(1);

        

        
        // return $get_basemoldwip;
        $date = date('Ymd',strtotime(NOW()));
        return Excel::download(new UsersExport($wip_basemold2,$get_fgs2,$get_rework_visual2), 'Inventory data (GRINDING) - '.$date.'.xlsx');
    }
}
