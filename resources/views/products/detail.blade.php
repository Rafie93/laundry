@extends('app.app')
@section('content')
   <div class="container-fluid">
    <div class="row">
         <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product')}}">Data Produk</a></li>
                        <li class="active">Detail Produk</li>
                        
                    </ol>
                </div>
            </div>
        </div>

          <div class="col-lg-5">
                <div class="card alert">
                    <div class="card-body">
                         <div class="form-group" style="float: right">
                            <a href="{{Route('product.edit',$data->id)}}" class="btn btn-lg btn-info"> <i class="glyphicon glyphicon-edit"></i>
                                Edit Data</a>
                        </div>
                        <br/>
                        <div class="user-profile">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="user-photo m-b-30">
                                        <img class="img-responsive" src="{{$data->cover()}}" alt="" />
                                    </div>
                                  
                                </div>
                                <div class="col-lg-7">
                                    <div class="user-profile-name">{{$data->name}}</div>
                                    <div class="user-Location">{{$data->code}}</div>
                                    <div class="user-job-title">{{$data->category->name}}</div>
                                    <div class="ratings">
                                        <h4>Ratings</h4>
                                        <div class="rating-star">
                                            <span>0</span>
                                            {{-- <i class="ti-star color-primary"></i>
                                            <i class="ti-star color-primary"></i> --}}
                                            <i class="ti-star"></i>
                                            <i class="ti-star"></i>
                                            <i class="ti-star"></i>
                                            <i class="ti-star"></i>
                                            <i class="ti-star"></i>
                                        </div>
                                    </div> 
                                    {{-- <div class="user-send-message"><button class="btn btn-primary btn-addon" type="button"><i class="ti-email"></i>Send Message</button></div> --}}
                                    <div class="custom-tab user-profile-tab">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab"></a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="1">
                                                <div class="contact-information">
                                                    <h4>Produk information</h4>
                                                    <div class="address-content">
                                                        <span class="contact-title">Harga Modal </span>
                                                        <span class="badge badge-grey">Rp. {{number_format($data->cost_of_goods)}}</span>
                                                    </div>
                                                    <div class="email-content">
                                                        <span class="contact-title">Harga Jual </span>
                                                        <span class="badge badge-primary">Rp. {{number_format($data->price_sales)}}</span>
                                                    </div>
                                                     <div class="website-content">
                                                        <span class="contact-title">Point Cashback </span>
                                                        <span class="contact-website">{{$data->point_cashback}}</span>
                                                    </div>
                                                     <div class="website-content">
                                                        <span class="contact-title">Time Duration </span>
                                                        <span class="contact-website">{{$data->time_duration}}</span>
                                                    </div>
                                                    <div class="website-content">
                                                        <span class="contact-title">Use Stock </span>
                                                        <span class="contact-website">{{$data->IS_STOCK()}}</span>
                                                    </div>
                                                    <div class="website-content">
                                                        <span class="contact-title">Pengiriman Lama </span>
                                                        <span class="contact-website">{{$data->LONG_DELIVERY()}}</span>
                                                    </div>
                                                    <div class="website-content">
                                                        <span class="contact-title">Status </span>
                                                        <span class="contact-website">{!!$data->DisplayStatus()!!}</span>
                                                    </div>
                                                    <div class="skype-content">
                                                        <span class="contact-title">Show Menu </span>
                                                        <span class="contact-skype">{{$data->SHOW_MENU()}}</span>
                                                    </div>
                                                    <div class="skype-content">
                                                        <span class="contact-title">Ready </span>
                                                        <span class="contact-skype">{!!$data->DisplayReady()!!}</span>
                                                    </div>
                                                   
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    {!!$data->description!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /# column -->
           <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" id="variant-tab" data-toggle="tab" href="#variant" role="tab" 
                                aria-controls="variant" aria-selected="true">Variant</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="image-tab" data-toggle="tab" href="#image" role="tab" aria-controls="image" aria-selected="false">Image</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ulasan-tab" data-toggle="tab" href="#ulasan" role="tab" aria-controls="ulasan" 
                                aria-selected="false">Ulasan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" 
                                aria-selected="false">History Order</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active in" id="variant">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Variant</th>
                                            <th>Tipe</th>
                                            <th>Pilihan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($variants->count()==0)
                                            <tr>
                                                <td colspan="4">Tidak Ada Data</td>
                                            </tr>
                                        @endif
                                        @foreach ($variants as $row)
                                            <tr>
                                                <td>{{$row->name}}</td>
                                                <td>{{$row->is_type()}}</td>
                                                <td>
                                                    @php $cont = count($row->getOptions());
                                                    for ($i=0; $i < $cont ; $i++) { 
                                                        echo $row->getOptions()[$i]['name']." => ".number_format($row->getOptions()[$i]['price'])."<br>";
                                                    }

                                                    @endphp
                                                    
                                                </td>
                                                <td>
                                                    {{-- <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#variantModal">
                                                        <i class="glyphicon glyphicon-edit"></i></a> --}}
                                                    <a href="#" class="btn btn-danger delete-variant"  r-name="{{$row->name}}" r-id="{{ $row->id }}">
                                                         <i class="glyphicon glyphicon-trash"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="image" >
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Filname</th>
                                            <th>Image</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @if ($images->count()==0)
                                            <tr>
                                                <td colspan="3">Tidak Ada Data</td>
                                            </tr>
                                        @endif

                                        @foreach ($images as $row)
                                            <tr>
                                                <td>{{$row->image}} </td>
                                                <td><img src="{{$row->images()}}" height="50px">
                                                </td>
                                                <td>
                                                      <a href="#" class="btn btn-danger delete-image"  r-name="{{$row->cover}}" r-id="{{ $row->id }}">
                                                         <i class="glyphicon glyphicon-trash"></i> </a>                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                             <div class="tab-pane" id="ulasan" >
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Rate</th>
                                            <th>Ulasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data->reviews->count()==0)
                                            <tr>
                                                <td colspan="3">Tidak Ada Data : {{$data->reviews->count()}}</td>
                                            </tr>
                                        @else 
                                            @foreach ($data->reviews->get() as $row)
                                            <tr>
                                                <td>{{$row->rating}}
                                                </td>
                                                <td>{{$row->reviews}}</td>
                                            </tr>
                                            @endforeach 
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="history" >
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @if ($data->sales->count()==0)
                                            <tr>
                                                <td colspan="3">Tidak Ada Data : {{$data->sales->count()}}</td>
                                            </tr>
                                        @else 
                                            @foreach ($data->sales->get() as $row)
                                            <tr>
                                                <td></td>
                                                <td>{{$row->qty}}</td>
                                                <td>{{$row->subtotal}}</td>
                                            </tr>
                                            @endforeach 
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div> 
@endsection
@section('script')
<script>
        $().ready( function () {
            $(".delete-variant").click(function() {
                var id = $(this).attr('r-id');
                var name = $(this).attr('r-name');
                swal({
                    title: 'Ingin Menghapus?',
                    text: "Yakin ingin menghapus variant produk  : "+name+" ini ?" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/product/variant/"+id+"/delete";
                    }, 2000);
                });
            });

            //
            $(".delete-image").click(function() {
                var id = $(this).attr('r-id');
                var name = $(this).attr('r-name');
                swal({
                    title: 'Ingin Menghapus?',
                    text: "Yakin ingin menghapus image produk  : "+name+" ini ?" ,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    setTimeout(function(){
                         window.location =  "/product/image/"+id+"/delete";
                    }, 2000);
                });
            });
        } );


    </script>
@endsection