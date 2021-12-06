<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Giro;

class GiroExport implements FromView, WithEvents
{
    protected $giro;

    public function __construct($company, $from, $to)
    {
        $this->giro=Giro::with('customer','transaction','paymentaccount','bank')->whereBetween('date_received', [$from, $to]);

        if($company!=0){
            $this->giro=$this->giro->whereHas('transaction', function ($query) {
                return $query->where('id_company', '=', $company);
            });
        }
        $this->giro = $this->giro->get();
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                foreach(range('A','K') as $columnID) {
                    $event->sheet->getDelegate()->getColumnDimension($columnID)->setAutoSize('true');
                }
     
            },
        ];
    }

    public function view(): View
    {
        return view('excel.giro', ['giro' => $this->giro]);
    }
}
