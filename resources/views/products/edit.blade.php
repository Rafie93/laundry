@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product')}}">Data Produk</a></li>
                        <li class="active">Edit Produk</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('product.update',$data->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label class="form-label">Kategori *</label>
                                        <select name="category_id" class="form-control select2" required>
                                            <option value="">--Pilih kategori--</option>
                                            @foreach ($categorys as $st)
                                                @if ($st->id == $data->category_id)
                                                    <option value="{{$st->id}}" selected>{{$st->name}}</option>                                                
                                                @else
                                                    <option value="{{$st->id}}">{{$st->name}}</option>                                                    
                                                @endif
                                            @endforeach
                                        </select>
                                    </div> 

                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Produk*</label>
                                        <input type="text" class="form-control @error('name') has-error @enderror"
                                        placeholder="" name="name" required value="{{old('name') ? old('name') : $data->name}}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('code') has-error @enderror">
                                        <label class="form-label">Code Produk</label>
                                        <input type="text" class="form-control @error('code') has-error @enderror" 
                                        placeholder="" name="code" value="{{old('code') ? old('code') : $data->code}}">
                                        @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    
                                    <div class="form-group @error('cost_of_goods') has-error @enderror">
                                        <label class="form-label">Harga Modal</label>
                                        <input type="number" class="form-control @error('cost_of_goods') has-error @enderror" 
                                        name="cost_of_goods" value="{{old('cost_of_goods') ? old('cost_of_goods') : $data->cost_of_goods}}" >
                                        @error('cost_of_goods')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('price_sales') has-error @enderror">
                                        <label class="form-label">Harga Jual *</label>
                                        <input type="number" class="form-control @error('price_sales') has-error @enderror" 
                                        name="price_sales" value="{{old('price_sales') ? old('price_sales') : $data->price_sales}}" >
                                        @error('price_sales')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div> 
                                     <div class="form-group @error('point_cashback') has-error @enderror">
                                        <label class="form-label">Poin For Cashback</label>
                                        <input type="number" class="form-control @error('point_cashback') has-error @enderror"
                                        placeholder="" name="point_cashback" value="{{old('point_cashback') ? old('point_cashback') : $data->point_cashback}}">
                                        @error('point_cashback')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('weight') has-error @enderror">
                                        <label class="form-label">Berat (gram)</label>
                                        <input type="number" step="0.1" class="form-control @error('weight') has-error @enderror"
                                        placeholder="" name="weight" value="{{old('weight') ? old('weight') : $data->weight}}">
                                        @error('weight')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                      <div class="form-group @error('time_duration') has-error @enderror">
                                        <label class="form-label">Time Duration (Menit)</label>
                                        <input type="number" class="form-control @error('time_duration') has-error @enderror"
                                        placeholder="" name="time_duration" value="{{old('time_duration') ? old('time_duration') : $data->time_duration}}">
                                        @error('time_duration')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
  
                                </div>                            
                            </div>
                            
                        </div>
                    </div>
            </div>
            </div>
            <div class="col-12 col-lg-6 col-xxl-6 d-flex">
                <div class="card flex-fill">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('file') has-error @enderror">
                                        <label class="form-label">Cover</label>
                                        <input type="file" name="file" class="form-control @error('file') has-error @enderror">
                                            @error('file')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                        <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" id="editor"
                                         class="form-control @error('description') has-error @enderror">
                                         {{old('description') ? old('description') : $data->description}}</textarea>
                                        @error('description')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                     <div class="form-group @error('is_stock') has-error @enderror">
                                            <label class="form-label col-md-4">Menggunakan Stock </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_stock"  value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_stock" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
                                    </div>

                                    <div class="form-group @error('long_delivery') has-error @enderror">
                                            <label class="form-label col-md-4">Dukungan Pengirman Lama</label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="long_delivery"  value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="long_delivery" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
                                    </div>

                                    <div class="form-group @error('is_show_men') has-error @enderror">
                                        <label class="form-label col-md-4">Tampil ke Menu </label>
                                        <label class="form-check form-check-inline col-md-4">
                                            <input class="form-check-input" type="radio" name="is_show_menu" checked value="1">
                                            <span class="form-check-label">
                                            Ya
                                            </span>
                                        </label>
                                        <label class="form-check form-check-inline col-md-4">
                                            <input class="form-check-input" type="radio" name="is_show_menu" value="0">
                                            <span class="form-check-label">
                                            Tidak
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-group @error('is_ppn') has-error @enderror">
                                            <label class="form-label col-md-4">PPN </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_ppn" value="1">
                                                <span class="form-check-label">
                                                Ya
                                                </span>
                                            </label>
                                            <label class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="is_ppn" checked value="0">
                                                <span class="form-check-label">
                                                Tidak
                                                </span>
                                    </div>
                                
                                    
                                </div>
                            
                            </div>
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <br/>
                    <button type="submit" class="btn btn-lg btn-info mg">UPDATE</button>
                    <br/>
                </div>
            </div>
    
        </form>
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '400px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection