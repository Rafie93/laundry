@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('method')}}">Data Metode Pembayaran</a></li>
                        <li class="active">Tambah Method Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('method.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('type') has-error @enderror">
                                        <label class="form-label">Type*</label>
									     <select name="type" class="form-control">
                                            <option value="Transfer">Transfer / EDC</option>
                                            <option value="E-Wallet">E-Wallet</option>

                                         </select>
                                         @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   
                                   

                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama*</label>
									    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         placeholder="" name="name" required value="{{old('name')}}">
                                         @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   

                                    <div class="form-group @error('logo') has-error @enderror">
                                        <label class="form-label">Logo*</label>
									    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                         placeholder="" name="logo" required value="{{old('logo')}}">
                                         @error('logo')
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