@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('user')}}">Data User</a></li>
                        <li class="active">Tambah User Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('user.store')}}" method="POST">
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
                                             value="{{old('fullname')}}"
                                             required>
                                        @error('fullname')
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
                                            value="{{old('phone')}}">
                                        @error('phone')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="form-label">Email*</label>
                                        <input type="text" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="" 
                                            name="email" 
                                            value="{{old('email')}}"
                                            required>

                                        @error('email')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('password') has-error @enderror">
                                        <label class="form-label">Password*</label>
                                        <input type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            placeholder="" 
                                            name="password"
                                            required>
                                        @error('password')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('repassword') has-error @enderror">
                                        <label class="form-label">Re-Password*</label>
                                        <input type="password" 
                                            class="form-control @error('repassword') is-invalid @enderror" 
                                            placeholder="" 
                                            name="repassword" 
                                            required>
                                        @error('repassword')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group @error('role') has-error @enderror">
                                        <label class="form-label">Role</label>
                                        	<select name="role" id="role" class="form-control" required onchange="afterRole()">
                                                @if (Auth::user()->role==11)
                                                    <option value="11">Super Admin</option>                                                    
                                                @endif
                                                <option value="12">Admin Store</option>
                                                <option value="13">CS Store</option>
                                                <option value="14">Kasir Store</option>
                                                <option value="16">Kurir</option>
                                            </select>
                                    </div>
                                    @if (Auth::user()->IN_STORE())
                                        {!! Form::hidden('store_id', Auth::user()->store_id) !!}
                                    @else
                                        <div id="store_for" class="mb-3">
                                            <label class="form-label">Store For</label>
                                                <select name="store_id" class="form-control" >
                                                    <option value="">--Pilih Store--</option>
                                                    @foreach ($stores as $st)
                                                        <option value="{{$st->id}}">{{$st->name}}</option>
                                                    @endforeach
                                                </select>
                                      </div> 
                                    @endif
                                     <div class="form-group @error('gender') has-error @enderror">
                                        <label class="form-label">Gender </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" checked value="LK">
                                            <span class="form-check-label">
                                            LK
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="PR">
                                            <span class="form-check-label">
                                           PR
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-group @error('status') has-error @enderror">
                                        <label class="form-label">Status </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" checked value="1">
                                            <span class="form-check-label">
                                            Aktif
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" value="0">
                                            <span class="form-check-label">
                                            Tidak Aktif
                                            </span>
                                        </label>
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
@section('script')
 <script>
     $(function() {
       afterRole();
    });
     function afterRole(){
        var role = $("#role").val();
        if(role!=11 && role!=''){
            $("#store_for").show();
        }
        else{
            $("#store_id").val('');
            $("#store_for").hide();
        }
     }
 </script>   
@endsection