@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('layanan')}}">Data Layanan</a></li>
                        <li class="active">Tambah Layanan Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('layanan.store')}}" method="POST">
                    {{ csrf_field() }}   
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">

                                    <div class="form-group @error('category_id') has-error @enderror">
                                        <label class="form-label">Kategori Layanan*</label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                             name="category_id" required>
                                          <option value="">Pilih Kategori Layanan</option>
                                          @foreach($categories as $category)
                                          <option value="{{$category->id}}">{{$category->name}}</option>
                                          @endforeach
                                        </select>
                                         @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Varian Layanan*</label>
									    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         placeholder="" name="name" required value="{{old('name')}}">
                                         @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   
                                    
                                    <div class="form-group @error('price') has-error @enderror">
                                        <label class="form-label">Harga Layanan*</label>
									    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                         placeholder="" name="price" required value="{{old('price')}}">
                                         @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                    
                                    <div class="form-group @error('satuan') has-error @enderror">
                                        <label class="form-label">Satuan</label>
                                        <select class="form-control @error('satuan') is-invalid @enderror"
                                             name="satuan">
                                          <option value="">Pilih Satuan</option>
                                          @foreach($satuans as $satuan)
                                          <option value="{{$satuan->alias}}">{{$satuan->alias}}</option>
                                          @endforeach
                                        </select>
                                         @error('satuan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('estimasi_type') has-error @enderror">
                                        <label class="form-label">Estimasi Tipe Layanan *<label>
                                        <select required class="form-control @error('estimasi_type') is-invalid @enderror"
                                             name="estimasi_type">
                                             <option value="Hari">Hari</option>
                                              <option value="Jam">Jam</option>
                                          
                                        </select>
                                         @error('estimasi_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('estimasi') has-error @enderror">
                                        <label class="form-label">Estimasi Layanan *</label>
									    <input type="number" class="form-control @error('estimasi') is-invalid @enderror"
                                         placeholder="" name="estimasi" required value="{{old('estimasi')}}">
                                         @error('estimasi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                   
                                   
								</div>
                                <button type="submit" class="btn btn-lg btn-info mg">SIMPAN</button>
                            
							</div>
                              
						</div>
					</div>
                </form>
            </div>
        </div>
      
    </div>

</div>
@endsection