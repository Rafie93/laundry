<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenditure\Expenditure;
use Illuminate\Support\Facades\DB;
Use App\Models\Users\UserManajemen;


class ReportPengeluaranController extends Controller
{
    public function pengeluaran(Request $request)
    { 
        $outlet_id = $request->outlet_id;
        $start = $request->start ? $request->start : date('Y-m-d');
        $end = $request->end ? $request->end : date('Y-m-d');
        if (!$request->outlet_id) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                ->where('status',1)
                ->first();
            $outlet_id = $user->outlet_id;
        }
        
        $data = Expenditure::select('expenditure_category.name',
                                DB::raw("SUM(expenditure.cost) as nominal"))
                                ->groupBy('expenditure_category.name')
                                ->leftJoin('expenditure_category', 'expenditure_category.id', '=', 'expenditure.expenditure_category_id')
                                ->where('expenditure.outlet_id',$outlet_id)
                                ->when($request->start, function ($query) use ($request) {
                                    $query->whereDate('expenditure.date', '>=', "{$request->start}");
                                })
                                ->when($request->end, function ($query) use ($request) {
                                    $query->whereDate('expenditure.date', '<=', "{$request->end}");
                                })
                                ->get();


        $output = array(
            'success' => true,
            'jumlah' => $data->count(),
            'total' => $data->sum('nominal'),
            'data' => $data
        );
            
        return response()->json($output);
                    
    
    }
}
