<?php

namespace App\Http\Controllers\Api\Outlet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Users\UserManajemen;
Use App\Models\Outlets\Outlet;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                        ->where('status',1)
                                        ->first();

        $outletId = $user->outlet_id;
        $receipt = Outlet::find($outletId)->first();
        $data = array(
            'id' => $receipt->id,
            'name' => $receipt->name,
            'logo' => $receipt->isLogo(),
            'is_show_logo' => $receipt->is_show_logo,
            'margin_receipt' => $receipt->margin_receipt,
            'footnote' => $receipt->footnote
        );

        return response()->json(['success'=>true,'data'=>$data]);

    }

    public function update(Request $request)
    {
        $user = UserManajemen::where('user_id',auth()->user()->id)
        ->where('status',1)
        ->first();

        $outletId = $user->outlet_id;
        $receipt = Outlet::find($outletId);
        $receipt->update([
            'is_show_logo' => $request->is_show_logo,
            'margin_receipt' => $request->margin_receipt,
            'footnote' => $request->footnote
        ]);
        if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $outletId.date('ymd').'_'.time().'.'.$extension;
            $request->file('file')->move('images/logo-outlet/',$fileName);
            $receipt->update([
                'logo' => $fileName
            ]);
       }

       return response()->json([
        'success'=>true,
            'message'=>'Pengaturan Receipt Berhasil dilakukan'
        ], 200);
    }
}
