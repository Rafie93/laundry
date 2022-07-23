@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li>Data Outlet</li>
                        <li class="active">Outlet {{$outlet->name}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <table class="table table-condensed table-bordered">
                        <tr>
                            <td class="col-xs-2 text-center">Merchant</td>
                            <td class="col-xs-2 text-center">Nama Outlet</td>
                            <td class="col-xs-2 text-center">Phone Outlet</td>
                            <td class="col-xs-2 text-center">Email Outlet</td>
                            <td class="col-xs-2 text-center">Expired</td>
                            <td class="col-xs-2 text-center">Status</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="border-top: none;">{{$outlet->merchant->name}}</td>
                            <td class="text-center" style="border-top: none;">{{$outlet->name}}</td>
                            <td class="text-center" style="border-top: none;">{{$outlet->phone}}</td>
                            <td class="text-center" style="border-top: none;">{{$outlet->email}}</td>
                            <td class="text-center" style="border-top: none;">{{$outlet->merchant->expired}}</td>
                            <td class="text-center" style="border-top: none;">{{$outlet->merchant->isStatusDisplay()}}</td>
                           
                        </tr>
                    </table>
                </div>
            
                <br>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" id="riwayattransaksi-tab" data-toggle="tab" href="#riwayattransaksi" role="tab" aria-controls="riwayattransaksi" aria-selected="true" aria-expanded="true">Transaksi Outlet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pelaku-tab" data-toggle="tab" href="#pelaku" role="tab" aria-controls="pelaku" aria-selected="false" aria-expanded="false">History Berlangganan</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active in" id="riwayattransaksi">
                        <div class="table-responsive order-list-item">
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Status</th>
                                    <th>Date Entry</th>
                                    <th>Customer</th>
                                    <th>Layanan</th>
                                    <th>Sub Total</th>
                                    <th>Diskon</th>
                                    <th>Grand Total</th>
                                    <th>Date Estimasi</th>
                                    <th>Date Proses</th>
                                    <th>Date Taken</th>
                                    <th>Date Complete</th>
                                    <th>Metode Payment</th>
                                    <th>Status Payment</th>
                                    <th>Kasir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $row)
                                    <tr>
                                        <td>{{$row->number}}</td>
                                        <td>{{$row->isStatusOrder()}}</td>
                                        <td>{{$row->date_entry}}</td>
                                        <td>{{$row->customer->name}}</td>
                                        <td></td>
                                        <td align="right">{{$row->subtotal}}</td>
                                        <td align="right">{{$row->discount}}</td>
                                        <td align="right">{{$row->grand_total}}</td>
                                        <td>{{$row->date_estimasi}}</td>
                                        <td>{{$row->date_process}}</td>
                                        <td>{{$row->date_taken}}</td>
                                        <td>{{$row->date_complete}}</td>
                                        <td>{{$row->metode_payment}}</td>
                                        <td>{{$row->status_order == 1 ? 'Dibayar' : 'Belum Dibayar'}}</td>
                                        <td>{{$row->creator->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$order->appends(request()->except('page'))->links()}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

</div>
@endsection