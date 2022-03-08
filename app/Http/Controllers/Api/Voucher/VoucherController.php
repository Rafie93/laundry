<?php

namespace App\Http\Controllers\Api\Voucher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shopp\StoreVoucher;
use App\Http\Resources\Voucher\VoucherList as ListResource;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $vouchers = StoreVoucher::orderBy('expired_at','asc')
                            ->where('expired_at','>',Carbon::now())
                            ->when($request->store_id, function ($query) use ($request) {
                                $query->where('store_id', $request->store_id);
                            })
                            
                            ->get();

        return new ListResource($vouchers);
    }
}
