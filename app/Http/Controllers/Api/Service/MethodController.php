<?php

namespace App\Http\Controllers\Api\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sistem\PaymentMethod;
use App\Http\Resources\Service\MethodList as ListResource;

class MethodController extends Controller
{
    public function index(Request $request)
    {
        $method = PaymentMethod::orderBy('id','asc')
                    ->paginate(20);
                    
        return new ListResource($method);
    }
}
