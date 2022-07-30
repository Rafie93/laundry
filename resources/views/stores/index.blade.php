@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Data Outlet</li>
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
                                                    <input type="text" class="form-control gp-search" name="keyword" value="{{request('keyword')}}" placeholder="Cari Merchant Name / Outlet" value="" autocomplete="off">
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
                                <th>No</th>
                                <th>Merchant</th>
                                <th>Nama Outlet</th>
                                <th class="d-none d-xl-table-cell">Phone</th>
                                <th>Email</th>
                                <th class="d-none d-md-table-cell">Alamat</th>
                                <th>Paket</th>
                                <th>Expired</th>
                                <th>Transaksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        @foreach ($stores as $key=> $row)
                            <tr>
                                <td>{{$stores->firstItem() + $key }}</td>
                                <td>{{$row->merchant->name}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->address}} </td>
                                <td><a href="{{Route('paket')}}">
                                    {{$row->merchant->package->package}}</a></td>
                                <td>{{$row->merchant->expired}}</td>
                                <td>{{$row->order->count()}}</td>
                                  <td>
                                     <a href="{{Route('outlet.detail',$row->id)}}" class="btn btn-primary"><i class="glyphicon glyphicon-eyes-open"></i> VIEW</a>
                                     {{-- <a href="#" class="btn btn-danger delete"  r-name="{{ $row->title}}" r-id="{{ $row->id }}">
                                        <i class="glyphicon glyphicon-trash"></i> Delete</a> --}}
                                 </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$stores->appends(request()->except('page'))->links()}}

                </div>
                
                <br>
            </div>
        </div>
       
    </div>

</div>
@endsection