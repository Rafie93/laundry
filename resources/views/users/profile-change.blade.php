@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('myprofile')}}">Profile</a></li>
                        <li class="active">Edit Profile {{$data->fullname}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('profile.update')}}" method="POST">
                    {{ csrf_field() }}
                    
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('fullname') has-error @enderror">
                                        <label class="form-label">Nama*</label>
									    <input type="text"
                                             class="form-control @error('fullname') is-invalid @enderror" 
                                             placeholder="" 
                                             name="fullname" 
                                             value="{{old('fullname') ? old('fullname') : $data->fullname }}"
                                             required>
                                        @error('fullname')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('birthday') has-error @enderror">
                                        <label class="form-label">Birthday</label>
                                        <input type="text" 
                                            class="form-control tanggal @error('birthday') is-invalid @enderror" 
                                            placeholder="" 
                                            name="birthday"
                                            value="{{old('birthday') ? old('birthday') : $data->birthday}}">
                                        @error('birthday')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                     <div class="form-group @error('phone') has-error @enderror">
                                        <label class="form-label">Phone</label>
                                        <input type="text" 
                                            class="form-control @error('phone') is-invalid @enderror" 
                                            placeholder="" 
                                            name="phone"
                                            value="{{old('phone') ? old('phone') : $data->phone}}">
                                        @error('phone')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="form-label">Email*</label>
                                        <input type="text"  disabled
                                            class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="" 
                                            name="email" 
                                            value="{{old('email') ? old('email') : $data->email}}"
                                            required>

                                        @error('email')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                     <div class="form-group @error('gender') has-error @enderror">
                                        <label class="form-label">Gender </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" @if ($data->gender=="LK")
                                                checked
                                            @endif value="LK">
                                            <span class="form-check-label">
                                            LK
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender"  @if ($data->gender=="PR")
                                                checked
                                            @endif value="PR">
                                            <span class="form-check-label">
                                           PR
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
