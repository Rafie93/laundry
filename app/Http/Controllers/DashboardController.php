<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Outlets\Merchant;
use  App\Models\User;
use App\Models\Subscribe\Subscribe;
use  App\Models\Outlets\Outlet;
Use App\Models\Users\UserManajemen;
use App\Models\Order\Order;
use App\Models\Order\OrderDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Outlets\Customer;
use App\Models\Expenditure\Expenditure;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $role = auth()->user()->role;
        $totalBerlangganan = Merchant::where('package_member_id','<>',1)->count();
        $totalBelumBerlangganan = Merchant::where('package_member_id',1)->count();

        $totalOutlet = Outlet::where('status',1)->count();
        $totalUser = User::where('role','<>',1)->count();
        if ($role==2 || $role == 3 || $role == 4) {
            $user = UserManajemen::where('user_id',auth()->user()->id)
                                    ->where('status',1)
                                    ->first();
            $owner = Merchant::where('owner_id',auth()->user()->id)->first();

            $outlet_id = $user->outlet_id;

            $pendaptaan = Order::select('order.number','customer.name as customer','order.date_pay as date',
                            DB::raw("SUM(order.grand_total) as nominal"))
                            ->groupBy('order.number','customer.name','order.date_pay')
                            ->leftJoin('customer', 'customer.id', '=', 'order.customer_id')
                            ->where(function ($query) use ($owner,$outlet_id) {
                                if (auth()->user()->role==2 ){
                                    $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
                                    $query->whereIn('order.outlet_id',$outlet);
                                }else{
                                    $query->where('order.outlet_id',$outlet_id);
                                }
                            })
                            ->where('order.status_payment',1)
                            ->where('order.status_order','<>',4)
                            ->whereDate('order.date_pay', '>=', date('Y-m-d'))
                            ->whereDate('order.date_pay', '<=', date('Y-m-d'))
                            ->get();
            $customer = Customer::orderBy('id','desc')
                            ->where(function ($query) use ($owner,$outlet_id) {
                                if (auth()->user()->role==2 ){
                                    $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
                                    $query->whereIn('outlet_id',$outlet);
                                }else{
                                    $query->where('outlet_id',$outlet_id);
                                }
                            })
                            ->get()->count();

            $outl = Outlet::orderBy('id','desc')
                            ->where(function ($query) use ($owner,$outlet_id) {
                                if (auth()->user()->role==2 ){
                                    $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
                                    $query->whereIn('id',$outlet);
                                }else{
                                    $query->where('id',$outlet_id);
                                }
                            })
                            ->get()->count();

            $pengeluaran = Expenditure::select('expenditure_category.name',
                                DB::raw("SUM(expenditure.cost) as nominal"))
                                ->groupBy('expenditure_category.name')
                                ->leftJoin('expenditure_category', 'expenditure_category.id', '=', 'expenditure.expenditure_category_id')
                                ->where(function ($query) use ($owner,$outlet_id) {
                                    if (auth()->user()->role==2 ){
                                        $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
                                        $query->whereIn('expenditure.outlet_id',$outlet);        
                                    }else{
                                        $query->where('expenditure.outlet_id',$outlet_id);
                                    }
                                })
                                 ->whereDate('expenditure.date', '>=', date('Y-m-d'))
                                 ->whereDate('expenditure.date', '<=', date('Y-m-d'))
                                ->get();


            $totalPendapatan = $pendaptaan->sum('nominal');
            $totalPelanggan = $customer;
            $totalOutlet = $outl;
            $totalPengeluaran = $pengeluaran->sum('nominal');
            return view('dashboard.outlet',compact('totalPendapatan','totalPelanggan','totalOutlet','totalPengeluaran'));
        }
        return view('dashboard.super',compact('totalBerlangganan','totalUser','totalOutlet','totalBelumBerlangganan'));
    }

    public function getPendapatanBerlangganan(Request $request)
    {
        $label = Subscribe::orderBy('month','asc')
                                        ->select(DB::raw('MONTH(date) month'))
                                        ->groupBy('month')
                                        ->whereYear('date', date('Y'))
                                        ->where('payment_status','paid')
                                        ->get();

        $dataset = array();
        $subDataKategori = Subscribe::select(DB::raw('package_member_id'))
                                    ->groupBy('package_member_id')
                                    ->whereYear('date', date('Y'))
                                    ->where('payment_status','paid')
                                    ->get();

        foreach ($subDataKategori as $rdk) {
            $data=array();
            foreach ($label as $month) {
                $pendaptaanSub = Subscribe::orderBy('month','asc')
                                        ->select(DB::raw('sum(amount) AS data'),
                                                    DB::raw('package_member_id'),
                                                    DB::raw('MONTH(date) month'))
                                                ->groupBy('package_member_id','month')
                                                ->where('package_member_id',$rdk->package_member_id)
                                                ->whereYear('date', date('Y'))
                                                ->whereMonth('date',$month->month)
                                                ->where('payment_status','paid')
                                                ->get();
                if ($pendaptaanSub->count()>0) {
                    foreach ($pendaptaanSub as $d) {
                        $data[] = $d->data;
                    }
                }else{
                    $data[] = 0;
                }
              
               
            }
            $dataset[] = array(
                'label' => $rdk->package->package,
                'data' => $data,
                'borderColor'=> $this->rand_color(),
                'borderWidth' => 3,
                'pointStyle' => 'circle',
                'pointRadius'=> 5,
                'pointBackgroundColor' => $this->rand_color(),
            );
        }

        $outLabel = array();
        foreach ($label as $lab) {
            $outLabel[] = $this->intToMonth($lab->month);
        }
       

        $output = array(
            'title' => "Pendapatan Berlangganan",
            'type' => "line",
            'labels' => $outLabel,
            'datasets' => $dataset
        );

        return response()->json(array(
            "data" => $output
        ));

    }

    public function getOutletTambahan()
    {
        $merchant = Merchant::select(DB::raw('count(id) AS data'),
                                      DB::raw('MONTH(created_at) month'))
                                ->groupBy('month')
                                ->whereYear('created_at', date('Y'))
                                ->get();
        $labels = array();
        $data = array();
        $background = array();
        foreach ($merchant as $key => $val) {
           $labels[] = $this->intToMonth($val->month);
           $data[] = $val->data;
           $background[] = $this->rand_color();
        }
        $dataset[]=array(
            'data' => $data,
            'backgroundColor' => $background,
        );
        $output = array(
            'labels' => $labels,
            'datasets' => $dataset,
        );
        return response()->json(array(
            "data" => $output
        ));            
    }

    public function getLayananBulanIni()
    {
        $role = auth()->user()->role;
        $user = UserManajemen::where('user_id',auth()->user()->id)
                                    ->where('status',1)
                                    ->first();
        $owner = Merchant::where('owner_id',auth()->user()->id)->first();

        $outlet_id = $user->outlet_id;
        
        $merchant = OrderDetail::select(DB::raw('count(order_detail.id) AS data'),
                                'order_detail.service_id')
                                ->leftJoin('order', 'order.id', '=', 'order_detail.order_id')
                                ->groupBy('order_detail.service_id')
                                ->where('order.status_order','<>',4)
                                ->where(function ($query) use ($owner,$outlet_id) {
                                    if (auth()->user()->role==2 ){
                                        $outlet = Outlet::select('id')->where('merchant_id',$owner->id)->get()->toArray();
                                        $query->whereIn('order.outlet_id',$outlet);
                                    }else{
                                        $query->where('order.outlet_id',$outlet_id);
                                    }
                                })
                                ->whereYear('date_entry', date('Y'))
                                ->whereMonth('date_entry',date('m'))
                                ->get();
        $labels = array();
        $data = array();
        $background = array();
        foreach ($merchant as $key => $val) {
           $labels[] = $val->service->name;
           $data[] = $val->data;
           $background[] = $this->rand_color();
        }
        $dataset[]=array(
            'data' => $data,
            'backgroundColor' => $background,
        );
        $output = array(
            'labels' => $labels,
            'datasets' => $dataset,
        );
        return response()->json(array(
            "data" => $output
        ));            
    }

    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    function intToMonth($num)
    {
        switch ($num) {
            case 1:
                    return "Januari";
                    break;
            case 2:
                    return "Februari";
                    break;
                case 3:
                    return "Maret";
                    break;
                case 4:
                    return "April";
                    break;
                case 5:
                    return "Mei";
                    break;
                case 6:
                    return "Juni";
                    break;
                case 7:
                    return "Juli";
                    break;
                case 8:
                    return "Agustus";
                    break;
                case 9:
                    return "September";
                    break;
                case 10:
                    return "Oktober";
                    break;
                case 11:
                    return "November";
                    break;
                case 12:
                    return "Desember";
                    break;
            
            default:
                return "";
                break;
        }
    }
}
