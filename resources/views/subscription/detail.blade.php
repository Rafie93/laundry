@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li>Transaksi Berlangganan</li>
                        <li class="activer">Detail</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
               
                <div class="table-responsive order-list-item">
                  <table class="table">
                    <tbody>
                        <tr>
                            <td>Status </td>
                            <td>{{$data->payment_status==null ? "Belum Dibayar " : $data->payment_status}}</td>
                        </tr>
                        <tr>
                            <td>Number Invoice </td>
                            <td>#{{$data->number}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal </td>
                            <td>{{$data->date}}</td>
                        </tr>
                        <tr>
                            <td>Merchant / Outlet </td>
                            <td>{{$data->merchant->name}}</td>
                        </tr>
                        <tr>
                            <td>Customer </td>
                            <td>{{$data->customer_name." ".$data->customer_phone}}</td>
                        </tr>
                        <tr>
                            <td>Paket </td>
                            <td>{{$data->package->package." (".$data->package->duration." ".$data->package->duration_day.")"}}</td>
                        </tr>
                        <tr>
                            <td>Grand Total </td>
                            <td>{{number_format($data->amount)}}</td>
                        </tr>
                        
                        @if ($data->payment())
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Detail Payment</td>
                            </tr>
                            <tr>
                                <td>Pay Number </td>
                                <td>{{$data->payment()->number}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Pay </td>
                                <td>{{$data->payment()->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Status </td>
                                <td>{{$data->payment()->status}}</td>
                            </tr>
                            <tr>
                                <td>Method </td>
                                <td>{{$data->payment()->payment_type}}</td>
                            </tr>
                            @if ($data->payment()->payment_type=="bank_transfer")
                                <tr>
                                    <td>Nama Bank </td>
                                    <td>{{$data->payment()->vendor_name}}</td>
                                </tr>
                            @endif
                        @endif
                        
                    </tbody>
                  </table>
                </div>
                
                <br>
            </div>
        </div>
       
    </div>

</div>
@endsection