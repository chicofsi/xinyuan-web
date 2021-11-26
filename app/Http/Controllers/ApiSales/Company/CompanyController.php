<?php

namespace App\Http\Controllers\ApiSales\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Models\Company;
use App\Models\WarehouseProduct;
use App\Models\Area;
use App\Models\Product;

use App\Helper\JurnalHelper;
use App\Http\Resources\Company as CompanyResource;


class CompanyController extends Controller
{
    public function companyList(Request $request)
    {
        $company=Company::where('active',1)->get();

        foreach ($company as $key => $value) {
            $dataCompany[$key]=new CompanyResource($value);
        }

        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Company List Success!','data'=> $dataCompany]), 200);
    }
}
