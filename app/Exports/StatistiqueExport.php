<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use RegistersEventListeners;
use PHPExcel_Style_Border;

// use Maatwebsite\Excel\Concerns\WithHeadings;

class StatistiqueExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $line;
    function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */

    public function registerEvents(): array
    {

        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];

        $this->line = count($this->data[$this->data['stat_by']]) + 2;


        return [
            AfterSheet::class    => function (AfterSheet $event) use ($styleArray) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle($cellRange)->ApplyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('A' . $this->line . ':'.$this->data['nb_row'].'' . $this->line)->getFont()->setSize(14);
                $event->sheet->getStyle('A' . $this->line . ':'.$this->data['nb_row'].'' . $this->line)->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A' . $this->line . ':'.$this->data['nb_row'].'' . $this->line)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('C6C4C8');     
                
                // $event->sheet->getStyle('A9:G9')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A12:G12')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A19:G19')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A27:G27')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A31:G31')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A35:G35')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A36:G36')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A42:G42')->ApplyFromArray($styleArray);
                // $event->sheet->getStyle('A43:G43')->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A1:'.$this->data['nb_row'].'' . $this->line)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);

                if($this->data['stat_by'] == 'produit' || $this->data['stat_by'] == 'agence' ){
                    $event->sheet->getStyle('A' . $this->line . ':'.$this->data['nb_row'].'' . $this->line)->applyFromArray([
                        
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            ],
                        
                    ]);
                    $event->sheet->getStyle('A'.($this->line +1).':'.$this->data['nb_row'].''.($this->line + count($this->data['semi_total_'.$this->data['stat_by']])  + 1))->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]);
                    $event->sheet->getStyle('A' . ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1). ':'.$this->data['nb_row'].''. ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1))->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF0000');
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1). ':'.$this->data['nb_row'].''. ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1))->getFont()->setName('Calibri');
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1). ':'.$this->data['nb_row'].''. ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1))->getFont()->setSize(14);
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1). ':'.$this->data['nb_row'].''. ($this->line + count($this->data['semi_total_'.$this->data['stat_by']]) + 1))->ApplyFromArray($styleArray);

                }        
            },
        ];
    }





    public function view(): View
    {

        return view('exports.' . $this->data['stat_by'] . 'Export', ['data' => $this->data]);
    }
}
