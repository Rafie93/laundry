@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li class="active">Data Member</li>
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
                                <th>No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th class="d-none d-xl-table-cell">Phone</th>
                                <th class="d-none d-xl-table-cell">Email</th>
                                <th class="d-none d-md-table-cell">Birthday</th>
                                <th class="d-none d-md-table-cell">Gender</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $row)
                                <tr>
                                    <td>{{ $users->firstItem() + $key }}</td>
                                    <td>{{$row->code}}</td>
                                    <td>{{$row->fullname}}</td>
                                    <td>{{$row->phone}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->birthday}}</td>
                                    <td>{{$row->gender}}</td>
                                    <td>{{$row->IS_STATUS()}}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning">
                                            <i class="glyphicon glyphicon-list"></i> View (Log)</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 {{$users->appends(request()->except('page'))->links()}}
            </div>
        </div>
    
    </div>

</div>
@endsection