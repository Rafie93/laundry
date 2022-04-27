@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('paket')}}">Data Paket Berlangganan</a></li>
                        <li class="active">Tambah Paket Berlangganan Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('paket.store')}}" method="POST">
                    {{ csrf_field() }}   
                    <div class="row">
						<div class="col-6 col-lg-6">
							<div class="card">
								<div class="card-body">

                                    <div class="form-group @error('package') has-error @enderror">
                                        <label class="form-label">Nama Paket*</label>
									    <input type="text" class="form-control @error('package') is-invalid @enderror"
                                         placeholder="" name="package" required value="{{old('package')}}">
                                         @error('package')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   
                                    
                                    <div class="form-group @error('price') has-error @enderror">
                                        <label class="form-label">Harga*</label>
									    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                         placeholder="" name="price" required value="{{old('price')}}">
                                         @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('duration') has-error @enderror">
                                        <label class="form-label">Durasi*</label>
									    <input type="number" class="form-control @error('duration') is-invalid @enderror"
                                         placeholder="" name="duration" required value="{{old('duration')}}">
                                         @error('duration')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('duration_day') has-error @enderror">
                                        <label class="form-label">Durasi Day*</label>
									     <select name="duration_day" class="form-control">
                                             <option value="day">Day</option>
                                             <option value="month">Month</option>
                                             <option value="year">Year</option>
                                         </select>
                                         @error('duration_day')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('maks_transaksi') has-error @enderror">
                                        <label class="form-label">Maks Transksi*</label>
									    <input type="number" class="form-control @error('maks_transaksi') is-invalid @enderror"
                                         placeholder="kosongkan untuk unlimited" name="maks_transaksi"  value="{{old('maks_transaksi')}}">
                                         @error('maks_transaksi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                    
                                    <div class="form-group @error('branch') has-error @enderror">
                                        <label class="form-label">Maks Cabang Outlet*</label>
									    <input type="number" class="form-control @error('branch') is-invalid @enderror"
                                         placeholder="kosongkan untuk unlimited" name="branch"  value="{{old('branch')}}">
                                         @error('branch')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                  
                                    
                                  
                                   
                                   
								</div>
							</div>
						</div>
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group @error('cashier') has-error @enderror">
                                        <label class="form-label">Maks Kasir*</label>
									    <input type="number" class="form-control @error('cashier') is-invalid @enderror"
                                         placeholder="kosongkan untuk unlimited" name="cashier"  value="{{old('cashier')}}">
                                         @error('cashier')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                    

                                    <div class="form-group @error('footer') has-error @enderror">
                                        <label class="form-label">Is Footer*</label>
									     <select name="footer" class="form-control">
                                             <option value="Yes">Yes</option>
                                             <option value="No">No</option>
                                         </select>
                                         @error('footer')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 
                                    <div class="form-group @error('qris') has-error @enderror">
                                        <label class="form-label">Is qris*</label>
									     <select name="qris" class="form-control">
                                             <option value="Yes">Yes</option>
                                             <option value="No">No</option>
                                         </select>
                                         @error('qris')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('report_to_wa') has-error @enderror">
                                        <label class="form-label">Report to Wa*</label>
									     <select name="report_to_wa" class="form-control">
                                             <option value="Yes">Yes</option>
                                             <option value="No">No</option>
                                         </select>
                                         @error('report_to_wa')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                    <div class="form-group @error('auto_send_nota') has-error @enderror">
                                        <label class="form-label">Auto Send Nota*</label>
									     <select name="auto_send_nota" class="form-control">
                                             <option value="Yes">Yes</option>
                                             <option value="No">No</option>
                                         </select>
                                         @error('auto_send_nota')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div> 

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-lg btn-info mg">SIMPAN</button>

                                </div>
                            </div>
                        </div>
					</div>
                </form>
            </div>
        </div>
      
    </div>

</div>
@endsection