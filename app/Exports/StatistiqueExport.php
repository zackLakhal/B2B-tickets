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

        $this->line = count($this->data[$this->data['stat_by']]) + 3;


        return [
            AfterSheet::class    => function (AfterSheet $event) use ($styleArray) {

                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont()->setSize(50);
              //  $event->sheet->getStyle('A1:W1')->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A1:W1')->applyFromArray([

                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ]
                ]);

                $event->sheet->getDelegate()->getStyle('A2:W2')->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle('A2:W2')->getFont()->setSize(14);
                $event->sheet->getStyle('A2:W2')->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A2:W2')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('C6C4C8');

                $event->sheet->getDelegate()->getStyle('A' . $this->line . ':' . $this->data['nb_row'] . '' . $this->line)->getFont()->setSize(14);
                $event->sheet->getStyle('A' . $this->line . ':' . $this->data['nb_row'] . '' . $this->line)->ApplyFromArray($styleArray);
                $event->sheet->getStyle('A' . $this->line . ':' . $this->data['nb_row'] . '' . $this->line)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5EEA67');

                $event->sheet->getStyle('A2:' . $this->data['nb_row'] . '' . $this->line)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ]
                ]);

                if ($this->data['stat_by'] == 'produit' || $this->data['stat_by'] == 'agence') {
                    $event->sheet->getStyle('A' . $this->line . ':' . $this->data['nb_row'] . '' . $this->line)->applyFromArray([

                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],

                    ]);
                    $event->sheet->getStyle('A' . ($this->line + 1) . ':' . $this->data['nb_row'] . '' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']])  + 1))->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]);
                    $event->sheet->getStyle('A' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1) . ':' . $this->data['nb_row'] . '' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1))->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('DEEA67');
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1) . ':' . $this->data['nb_row'] . '' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1))->getFont()->setName('Calibri');
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1) . ':' . $this->data['nb_row'] . '' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1))->getFont()->setSize(14);
                    $event->sheet->getDelegate()->getStyle('A' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1) . ':' . $this->data['nb_row'] . '' . ($this->line + count($this->data['semi_total_' . $this->data['stat_by']]) + 1))->ApplyFromArray($styleArray);
                }
            },
        ];
    }





    public function view(): View
    {

        return view('exports.' . $this->data['stat_by'] . 'Export', ['data' => $this->data]);
    }
}
