@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>History Ordering</h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Ordering</a></li>
                                    <li class="active">History</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="table-responsive order-list-item">
                                    <table class="table" id="listOrder">
                                        <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Menu Product</th>
                                            <th>Grand Total</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="tbody">
                                            @foreach ($sales as $key=>$row)
                                                <tr>
                                                    <td>{{$row->number}}</td>
                                                    <td>{{$row->member->fullname}}</td>
                                                    <td>{{$row->created_at->format('d-m-Y H:i:s')}}</td>
                                                    <td>{{$row->detail->count()}}</td>
                                                    <td align="right">{{number_format($row->grand_total)}}</td>
                                                    <td>{{$row->service}}</td>
                                                    <td>{!! $row->payment_status !!}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-info viewData"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>                
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                        {{$sales->appends(request()->except('page'))->links()}}
                                </div>
							</div>
						</div><!-- /# column -->
					</div><!-- /# row -->
                </div><!-- /# main content -->
            </div><!-- /# container-fluid -->
@endsection
