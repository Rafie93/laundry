@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('myprofile')}}">Profile</a></li>
                        <li class="active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('profile.password.update')}}" method="POST">
                    {{ csrf_field() }}
                    
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                      <div class="form-group @error('old_password') has-error @enderror">
                                        <label class="form-label">Password Old*</label>
                                        <input type="password" 
                                            class="form-control @error('old_password') is-invalid @enderror" 
                                            placeholder="" 
                                            name="old_password" 
                                            value="{{old('old_password')}}"
                                            required>
                                        @error('old_password')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                       <div class="form-group @error('password_new') has-error @enderror">
                                        <label class="form-label">New Password*</label>
                                        <input type="password" 
                                            class="form-control @error('password_new') is-invalid @enderror" 
                                            placeholder="" 
                                            value="{{old('password_new')}}"
                                            name="password_new" 
                                            required>
                                        @error('passwordnew')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                       <div class="form-group @error('password_confirmation') has-error @enderror">
                                        <label class="form-label">Re-Password*</label>
                                        <input type="password" 
                                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                                            placeholder="" 
                                            name="password_confirmation" 
                                            value="{{old('password_confirmation')}}"
                                            required>
                                        @error('password_confirmation')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
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
