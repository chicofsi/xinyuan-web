<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;

use App\Models\Sales;
use App\Models\Transaction;
use App\Models\Giro;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Bank;
use App\Models\TransactionDetails;
use App\Models\TransactionPayment;
use App\Models\PaymentAccount;
use App\Models\CustomerLevel;

use App\Helper\JurnalHelper;

class ManageFinanceReports extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');


        $this->client = JurnalHelper::index();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.finance.reports.index');
    }
    
    public function profitAndLoss(Request $request)
    {
        $reports = json_decode($this->client->request(
            'GET',
            'profit_and_loss',
            [
                'form_params' => 
                [
                    'start_date' => date("d/m/Y", strtotime($request->start_date)),
                    'end_date' => date("d/m/Y", strtotime($request->end_date))
                ]
            ]
        )->getBody()->getContents());
        return Response()->json($reports);
    }

    public function balanceSheet(Request $request)
    {
        $reports = json_decode($this->client->request(
            'GET',
            'balance_sheet',
            [
                'form_params' => 
                [
                    'end_date' => date("d/m/Y", strtotime($request->end_date))
                ]
            ]
        )->getBody()->getContents());
        return Response()->json($reports);
    }
}
