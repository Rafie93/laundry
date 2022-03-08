<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostController extends Controller
{
    public function index(Request $request)
    {
        $origin = $request->origin;
        $destination = $request->destination;
        $weight = $request->weight ? $request->weight : 1;
        $courier = $request->courier;

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => env('ONGKIR_URL')."cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=".$courier,
        CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: ".env('ONGKIR_API')
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $response=json_decode($response,true);
        $data = $response['rajaongkir']['results'][0]['costs'];
        return response($data);
    }
}
