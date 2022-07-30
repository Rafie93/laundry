@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Transaksi Berlangganan</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <div class="card-header">
                    <form method="get" action="{{ url()->current() }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="form-group col-sm-12">
                                        <div class="row">
                                            <div class="form-group col-lg-4" style="float: right">

                                                <div class="input-group">
                                                    <input type="text" class="form-control gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari" value="" autocomplete="off">
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-default no-border btn-sm gp-search">
                                                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>

                </div>
                <div class="table-responsive order-list-item">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th style="text-align: center">Aksi</th>
                                <th style="text-align: center">Tanggal</th>
                                <th style="text-align: center">Number</th>
                                <th style="text-align: center">Merchant / Owner</th>
                                <th style="text-align: center">Outlet</th>
                                <th style="text-align: center">Paket</th>
                                <th style="text-align: center">Biaya</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Metode Pembayaran</th>
                                <th style="text-align: center">Customer</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscribes as $key=> $row)
                            <tr>
                                <td>{{$subscribes->firstItem() + $key }}</td>
                                <td>
                                    <a href="{{Route('purchase.detail',$row->id)}}" class="btn btn-info"><i class="glyphicon glyphicon-eye-open"></i> View</a>
                                </td>
                                <td>{{$row->date}}</td>
                                <td>{{$row->number}}</td>
                                <td>{{$row->merchant->name}}</td>
                                <td style="width: 15%">
                                    @foreach ($row->merchant->outlet as $item)
                                        {{$item->name}}<br>
                                    @endforeach
                                </td>
                                <td>{{$row->package->package}}</td>
                                <td style="text-align: right">{{number_format($row->amount)}}</td>
                                <td style="text-align: center">
                                    @if ($row->payment_status == 'unpaid' || $row->payment_status == null || $row->payment_status == "")
                                        <span class="label label-warning">Belum Lunas</span>
                                    @else 
                                        <span class="label label-success">Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->payment())
                                        {{$row->payment()->payment_type}}
                                        @if ($row->payment()->payment_type=="bank_transfer")
                                            <br>
                                            {{$row->payment()->vendor_name}}
                                        @endif
                                        <br>
                                        {{$row->payment()->created_at}}

                                    @endif
                                </td>
                                <td>{{$row->customer_name}}<br>{{$row->customer_phone}}</td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                     {{$subscribes->appends(request()->except('page'))->links()}}

                </div>
                
                <br>
            </div>
        </div>
       
    </div>

</div>
@endsection