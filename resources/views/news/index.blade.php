@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">News</li>
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
                                                <a href="{{Route('news.create')}}" class="btn btn-lg btn-info"> <i class="ace-icon fa fa-plus bigger-110"></i>
                                                    Add New News</a>
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
                                <th>Title</th>
                                <th>Tag</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($news as $key=> $row)
                            <tr>
                                <td>{{$news->firstItem() + $key }}</td>
                                <td>
                                    <img src="{{$row->cover()}}" height="100px" alt="" srcset="">
                                </td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->tag}}</td>
                                <td>
                                     <a href="{{Route('news.edit',$row->id)}}" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                     <a href="#" class="btn btn-danger delete"  r-name="{{ $row->title}}" r-id="{{ $row->id }}">
                                        <i class="glyphicon glyphicon-trash"></i> Delete</a>
                                 </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                     {{$news->appends(request()->except('page'))->links()}}

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
                         window.location =  "/news/"+id+"/delete";
                    }, 2000);
                });
            });
        } );

    </script>
@endsection