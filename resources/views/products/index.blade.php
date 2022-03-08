@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
         <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Data Produk</li>
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
                                                <a href="{{Route('product.create')}}" class="btn btn-lg btn-info"> <i class="ace-icon fa fa-plus bigger-110"></i>
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
                                <th>Cover</th>
                                <th>Name</th>
                                <th class="d-none d-xl-table-cell">Kategori</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                                <th>Is Ready</th>
                                <th>Terjual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $key=> $row)
                            <tr>
                                <td>{{$products->firstItem() + $key }}</td>
                                <td>
                                    <img src="{{$row->cover()}}" height="60px">
                                </td>
                                <td >
                                    @if ($row->code!=null)
                                        <i>{{$row->code}}</i><br/>
                                    @endif
                                   <strong> {{$row->name}} </strong>
                                </td>
                                <td>{{$row->category->name}}</td>
                                <td align="right"><strong> {{number_format($row->price_sales)}}</strong></td>
                                <td>{!!$row->DisplayStatus()!!}</td>
                                <td>{!!$row->DisplayReady()!!}</td>
                                <td align="center">{{$row->sales->count()}}</td>
                                <td>
                                    @if ($row->is_ready==0 && $row->status==0)
                                        <a href="{{Route('product.review',$row->id)}}" class="btn btn-primary" rel="noopener noreferrer"><i class="glyphicon glyphicon-eye-open"></i> Review</a>
                                    @else
                                        <a href="{{Route('product.detail',$row->id)}}" class="btn btn-primary" rel="noopener noreferrer"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>
                                    @endif
                                    <a href="{{Route('product.edit',$row->id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                     <a href="#" class="btn btn-danger delete"  r-name="{{$row->name}}" r-id="{{ $row->id }}">
                                        <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                     {{$products->appends(request()->except('page'))->links()}}

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
                    text: "Yakin ingin menghapus data produk  : "+name+" ini ?, semua terkait produk ini akan dihapus" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/product/"+id+"/delete";
                    }, 2000);
                });
            });
        } );

    </script>
@endsection