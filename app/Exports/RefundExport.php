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
use App\Models\Transaction;

use App\Models\ProductType;
use App\Models\Product;
use App\Models\Factories;
use App\Models\ProductSize;
use App\Models\ProductColour;
use App\Models\ProductLogo;
use App\Models\ProductGrossWeight;
use App\Models\ProductWeight;

class RefundExport implements FromView, WithEvents
{
    protected $refund;

    public function __construct($company, $from, $to)
    {
        $this->refund=TransactionRefund::with('transaction','transactionreturn')->whereBetween('date', [$from, $to]);

        if($company!=0){
            $this->refund=$this->refund->whereHas('transaction', function ($query) {
                return $query->where('id_company', '=', $company);
            });
        }
        $this->refund = $this->refund->get();
        foreach ($this->refund as $key => $value) {
            foreach ($value->transactionreturn as $key_details => $value_detail) {
                $transactiondetails=TransactionDetails::where('id',$value_detail->id_transaction_details)->first();
                $product = Product::where('id',$transactiondetails->id_product)->first();
                $this->refund[$key]->transactionreturn[$key_details]->product_name = ProductType::where('id',$product->id_type)->first()->name." ".ProductSize::where('id',$product->id_size)->first()->width."X".ProductSize::where('id',$product->id_size)->first()->height." ".Factories::where('id',$product->id_factories)->first()->name." ".ProductColour::where('id',$product->id_colour)->first()->name." ".ProductLogo::where('id',$product->id_logo)->first()->name;
            }
        }
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
        return view('excel.refund', ['refund' => $this->refund]);
    }
}
