@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('product')}}">Data Product Bundle</a></li>
                        <li class="active">Generate Voucher Bundle {{ $bundle->name }}</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('bundle.generate_voucher',$bundle->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('code') has-error @enderror">
                                        <label class="form-label">Code Voucher</label>
                                        <input type="text" class="form-control @error('code') has-error @enderror" placeholder="" name="code" value="{{old('code')}}">
                                        @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Voucher*</label>
                                        <input type="text" class="form-control @error('name') has-error @enderror"
                                        placeholder="" name="name" required value="{{old('name') ? old('name') : $bundle->name }}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                
                                    <div class="form-group @error('price') has-error @enderror">
                                        <label class="form-label">Harga Bundle *</label>
                                        <input type="number" class="form-control @error('price') has-error @enderror" 
                                        name="price" value="{{old('price') ? old('price') : $bundle->price_sales}}" >
                                        @error('price')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div> 

                                     <div class="form-group @error('quantity') has-error @enderror">
                                        <label class="form-label">Jumlah Klaim</label>
                                        <input type="number" class="form-control @error('quantity') has-error @enderror"
                                        placeholder="" name="quantity" value="{{old('quantity') ? old('quantity') : 1}}">
                                        @error('point_cashback')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" id="editor" class="form-control @error('description') has-error @enderror">{{old('description')}}</textarea>
                                        @error('description')
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
                                    
                                    
                                    <div class="form-group @error('day') has-error @enderror">
                                        <label class="form-label">Hari</label>
                                        <input type="text" required class="form-control @error('day') has-error @enderror"
                                        placeholder="" name="day" value="{{old('day') ? old('day') : ''}}">
                                        @error('point_cashback')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group @error('expired') has-error @enderror">
                                        <label class="form-label">Masa Berlaku*</label>
                                        <input type="text" required class="form-control tanggal @error('expired') has-error @enderror"
                                        placeholder="" name="expired" value="{{old('expired') ? old('expired') : ''}}">
                                        @error('point_cashback')
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
          
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill" >
                    <div style="float: right">
                        <button type="submit" class="btn btn-lg btn-info mg">SUBMIT</button>
                    </div>
                    <br/><br/>
                </div>
            </div>
    
        </form>
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '380px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

</script>
@endsection