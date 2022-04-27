@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Paket Berlangganan</li>
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
                                            <div class="form-group col-lg-8" style="float: left">
                                                <a href="{{Route('paket.create')}}" class="btn btn-lg btn-info"> <i class="ace-icon fa fa-plus bigger-110"></i>
                                                    Add New Data</a>
                                            </div>

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
                                <th>No</th>
                                <th>Paket</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th style="text-align: center">Maks <br/>Transaksi</th>
                                <th>Kasir</th>
                                <th>Cabang</th>
                                <th>Footer</th>
                                <th>QRIS</th>
                                <th>Report to WA</th>
                                <th>Auto Send Nota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pakets as $key=> $row)
                            <tr>
                                <td>{{$pakets->firstItem() + $key }}</td>
                                <td>{{$row->package}}</td>
                                <td style="text-align: right">{{number_format($row->price)}}</td>
                                <td >{{$row->duration. " ".$row->duration_day}} </td>
                                <td style="text-align: center">{{$row->maks_transaksi==null?'unlimited':$row->maks_transaksi}}</td>
                                <td style="text-align: center">{{$row->cashier==null?'unlimited':$row->cashier}}</td>
                                <td style="text-align: center">{{$row->branch==null ? 'unlimited' : $row->branch}}</td>
                                <td style="text-align: center">{{$row->footer}}</td>
                                <td style="text-align: center">{{$row->qris}}</td>
                                <td style="text-align: center">{{$row->report_to_wa}}</td>
                                <td style="text-align: center">{{$row->auto_send_nota}}</td>
                                <td>
                                     <a href="{{Route('paket.edit',$row->id)}}"  class="btn btn-warning">
                                        <i class="glyphicon glyphicon-edit"></i> Edit</a>
                                    <a href="#" class="btn btn-danger delete"  r-name="{{ $row->package}}" r-id="{{ $row->id }}">
                                        <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                     {{$pakets->appends(request()->except('page'))->links()}}

                </div>
                
                <br>
            </div>
        </div>
       
    </div>

</div>
@endsection
@section('script')
<script>
        $().ready( function () {
            $(".delete").click(function() {
                var id = $(this).attr('r-id');
                var name = $(this).attr('r-name');
                swal({
                    title: 'Ingin Menghapus?',
                    text: "Yakin ingin menghapus data  : "+name+" ini ?" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/paket/"+id+"/delete";
                    }, 2000);
                });
            });
        } );

    </script>
@endsection