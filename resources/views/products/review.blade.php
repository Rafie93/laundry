@extends('app.app')
@section('content')
   <div class="container-fluid">
    <div class="row">
         <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product')}}">Data Produk</a></li>
                        <li class="active">Review Produk Baru</li>
                        
                    </ol>
                </div>
            </div>
        </div>

          <div class="col-lg-5">
                <div class="card alert">
                    <div class="card-body">
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
                                    {{-- <div class="ratings">
                                        <h4>Ratings</h4>
                                        <div class="rating-star">
                                            <span>0</span>
                                            <i class="ti-star color-primary"></i>
                                            <i class="ti-star color-primary"></i>
                                            <i class="ti-star color-primary"></i>
                                            <i class="ti-star color-primary"></i>
                                            <i class="ti-star"></i>
                                        </div>
                                    </div> --}}
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
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active in" id="variant">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#variantModal">
                                    Add Variant
                                    </button>
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
                                                    <a href="" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a href="" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="image" >
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#imageModal">
                                    Add Image
                                    </button>
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

                                        @foreach ($images as $row)
                                            <tr>
                                                <td>{{$row->image}} </td>
                                                <td><img src="{{$row->images()}}" height="50px">
                                                </td>
                                                <td>
                                                      <a href="" class="btn btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a href="" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <br/>
                    <form action="{{Route('product.submit',$data->id)}}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-lg btn-primary mg">SUBMIT</button>
                    </form>
                    <br/>
                </div>
        </div>
       
    </div>

</div> 
{{-- Pop UP --}}
<div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="variantLabel">Tambah Variant</h5>
        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{Route('product.variant',$data->id)}}" method="POST">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" value="" required>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tipe</label>
                        <div class="col-sm-10">
                            <select name="type" id="type" required class="form-control">
                                <option value="1">Pilih Satu</option>
                                <option value="2">Pilih Banyak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br/>
                    <button type="button" class="btn btn-info" onclick="addRow()" >Add Pilihan</button>
                    <table class="table table-borderd" id="tableVariant">
                        <thead>
                            <tr>
                                <th>Nama Pilihan</th>
                                <th>+ Harga</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {!! Form::text("name_pilihan[]", "", ["class"=>"form-control","required"]) !!}      
                                </td>
                                <td>
                                    {!! Form::number("price_sales[]","0", ["class"=>"form-control","required"]) !!}      
                                </td>
                                <td>
                                    {!! Form::number("urutan[]", "1", ["class"=>"form-control"]) !!}   
                                </td>
                                <td></td>
                            </tr>
                            <span id="area_variant"></span>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- POP UP IMAGES --}}
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageLabel">Tambah Image</h5>
        <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{Route('product.images',$data->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Image</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="file" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
    $().ready(function() {

    });
    function addRow(){
        var markup = "<tr><td><input type='text' name='name_pilihan[]' class='form-control' required></td><td>"+
        "<input type='number' name='price_sales[]' class='form-control' required></td><td><input type='number' name='urutan[]' class='form-control' required></td></tr>";
        $("#tableVariant tbody").append(markup);
    }
</script>
@endsection