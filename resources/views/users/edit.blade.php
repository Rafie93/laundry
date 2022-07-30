@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('user')}}">Data User</a></li>
                        <li class="active">Edit User {{$data->fullname}}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('user.update',$data->id)}}" method="POST">
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
                                        <input type="text" 
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
                                   
                                    <div class="form-group @error('role') has-error @enderror">
                                        <label class="form-label">Role</label>
                                        	<select name="role" id="role" class="form-control" required onchange="afterRole()">
                                                @if (Auth::user()->role==1)
                                                    <option value="1" {{$data->role==1 ? 'selected' : ''}}>Super Admin</option>                                                    
                                                @endif
                                                <option value="2" {{$data->role==2 ? 'selected' : ''}}>Owner Outlet</option>
                                                <option value="3" {{$data->role==3 ? 'selected' : ''}}>Admin Outlet</option>
                                                <option value="4" {{$data->role==4 ? 'selected' : ''}}>Kasir Outlet</option>
                                            </select>
                                    </div>
                                   
                                    @if (!Auth::user()->isSuperAdmin())
                                    <div id="store_for" class="mb-3">
                                        <label class="form-label">Outlet For</label>
                                            <select name="outlet_id" class="form-control" required>
                                                <option value="">--Pilih Store--</option>
                                                @foreach ($stores as $st)
                                                        @if ($st->id == $data->store_id)
                                                        <option  selected value="{{$st->id}}">{{$st->name}}</option>
                                                @else 
                                                    <option value="{{$st->id}}">{{$st->name}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div> 
                                     @endif
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
                                    <div class="form-group @error('status') has-error @enderror">
                                        <label class="form-label">Status </label>
                                        <label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"  @if ($data->status==1)
                                                checked
                                            @endif value="1">
                                            <span class="form-check-label">
                                            Aktif
                                            </span>
                                        </label>
										<label class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status"  @if ($data->gender==0)
                                                checked
                                            @endif value="0">
                                            <span class="form-check-label">
                                            Tidak Aktif
                                            </span>
                                        </label>
                                    </div>
                                   <div class="form-group @error('password_change') has-error @enderror">
                                        <i>*** Isi password jika ingin mengganti password baru</i>
                                        <label class="form-label">Password</label>
                                        <input type="password" 
                                            class="form-control @error('password_change') is-invalid @enderror" 
                                            placeholder="" 
                                            name="password_change"
                                            >
                                        @error('password_change')
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
                                            >
                                        @error('repassword')
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