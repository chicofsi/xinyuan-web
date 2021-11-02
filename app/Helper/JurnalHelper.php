<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use GuzzleHttp\Client;


class JurnalHelper 
{

    public static function index()
    {
        $client = new Client([
            'base_uri' => 'https://api.jurnal.id/partner/core/api/v1/',
            'timeout'  => 30.0,
            'headers' => [
                'Authorization' => "Bearer 0abe1eb54edc4922aa99abe1099f301e",
                'apikey' => "d14b308eca384af46fd5b1f9356808de"
            ]
        ]);
        return $client;
    }
}
