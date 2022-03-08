@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('category')}}">Data Kategori</a></li>
                        <li class="active">Edit Kategori {{$data->name}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('category.update',$data->id)}}" method="POST">
                    {{ csrf_field() }}   
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama*</label>
									    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         placeholder="" name="name" required value="{{old('name') ? old('name') : $data->name}}">
                                         @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>     
                                    <div class="form-group @error('status') has-error @enderror">
                                        <label class="form-label">Status </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" @if ($data->status==1)
                                                checked
                                            @endif value="1">
                                            <span class="form-check-label">
                                            Aktif
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="0" @if ($data->status==0)
                                                checked
                                            @endif>
                                            <span class="form-check-label">
                                            Tidak Aktif
                                            </span>
                                        </label>
                                    </div>
                                   
								</div>
                                <button type="submit" class="btn btn-lg btn-info mg">UPDATE</button>
                            
							</div>
                              
						</div>
					</div>
                </form>
            </div>
        </div>
      
    </div>

</div>
@endsection