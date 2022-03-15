<?php

namespace App\Imports;

use App\Model\Basemold;
use Maatwebsite\Excel\Concerns\ToModel;
// use Auth;

class CSVTSBasemoldImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Basemold([
            // 'date' => $row[0],
            // 'pr_number' => $row[1],
            // 'gr_number' => $row[2],
            // 'code' => $row[3],
            // 'partname' => $row[4],
            // 'lot_no' => $row[5],
            // 'from' => $row[6],
            // 'no_of_items' => $row[7],
            // 'qty_basemold' => $row[8],
            // 'qty_confirmed' => $row[9],
            // 'qty_after_grinding' => $row[10],
            // 'remarks' => $row[11],
            'date' => $row[0],
            'gr_number' => $row[1],
            'code' => $row[3],
            'partname' => $row[4],
            'qty_confirmed' => $row[6],
            'pr_number' => $row[7],
            'remarks' => $row[11],

        ]);
    }
}
