<?php

namespace App\Exports;

use App\Model\Basemold;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;





class UsersExport implements  FromView, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $get_basemoldwip;
    protected $get_fgs;

    
    function __construct($get_basemoldwip,$get_fgs,$get_rework_visual)
    {
        $this->get_basemoldwip = $get_basemoldwip;
        $this->get_fgs = $get_fgs;
        $this->get_rework_visual = $get_rework_visual;

        
    }

    public function view(): View {
       
            return view('exports.inventory', ['get_basemoldwip' => $this->get_basemoldwip, 'get_fgs' => $this->get_fgs, 'get_rework_visual' => $this->get_rework_visual]);
        
	}

    public function title(): string
    {
        return 'Grinding Inventory';
    }

     //for designs
     public function registerEvents(): array
     {
         
        $style1 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                // 'color'      =>  'red',
                'italic'      =>  true
            )
        );

       
         return [
             AfterSheet::class => function(AfterSheet $event) use ($style1)  {
               
                 $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(20);
                 $event->sheet->getDelegate()->getStyle('A1')->getAlignment()->setWrapText(true);
                 $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(35);
                 $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(25);

                 $event->sheet->getColumnDimension('A')->setWidth(35);
                 $event->sheet->getColumnDimension('B')->setWidth(35);
                 $event->sheet->getColumnDimension('C')->setWidth(25);
                 $event->sheet->getColumnDimension('D')->setWidth(25);


                 $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($style1);
                 $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($style1);
                 $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($style1);
                 $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($style1);

                //  $event->sheet->getDelegate()->getStyle('A2:X2')->getFont()->setSize(13);
               
             },
         ];
     }

    // public function collection()
    // {
    //     return Basemold::all();
    // }

    

 
}
