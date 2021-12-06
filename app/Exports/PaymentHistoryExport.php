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

use App\Models\TransactionPayment;
use App\Models\PaymentAccount;

class PaymentHistoryExport implements FromView, WithEvents
{
    protected $payment;

    public function __construct($account, $company, $from, $to)
    {
        $this->payment=TransactionPayment::with('transaction','paymentaccount')->whereBetween('date', [$from, $to]);

        if($account!=0){
            $this->payment=$this->payment->where('id_payment_account',$account);
        }
        if($company!=0){
            $this->payment=$this->payment->whereHas('transaction', function ($query) {
                return $query->where('id_company', '=', $company);
            });
        }
        $this->payment = $this->payment->get();
        foreach ($this->payment as $key => $value) {
            $this->payment[$key]->transaction = Transaction::where('id',$value->id_transaction)->with('customer','transactiondetails','sales','company')->first();
            $this->payment[$key]->paymentaccount = PaymentAccount::with('bank')->where('id',$value->paymentaccount->id)->first();
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
        return view('excel.paymenthistory', ['payment' => $this->payment]);
    }
}
