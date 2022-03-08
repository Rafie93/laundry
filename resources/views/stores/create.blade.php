@inject('regionQuery', 'App\Models\Regions\RegionQuery')
@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
          
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('stores')}}">Data Store</a></li>
                        <li class="active">Tambah Store Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('stores.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Store*</label>
									    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                         placeholder="" name="name" required value="{{old('name')}}">
                                         @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('code') has-error @enderror">
                                        <label class="form-label">Code Store</label>
									    <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="" name="code" value="{{old('code')}}">
                                         @error('code')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                     <div class="form-group @error('phone') has-error @enderror">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="" name="phone" value="{{old('phone')}}">
                                         @error('phone')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group @error('email') has-error @enderror">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="" name="email" value="{{old('email')}}">
                                         @error('email')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                     <div class="form-group @error('state_id') has-error @enderror">
                                        <label class="form-label">Provinsi*</label>
                                        <select id="state_id" name="state_id" class="form-control" required>
                                            <option value="">--Pilih Provinsi--</option>
                                            @foreach ($regionQuery->getProvincesList() as $st)
                                             <option value="{{$st->id}}">{{$st->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="form-group @error('city_id') has-error @enderror">
                                        <label class="form-label">Kota*</label>
                                        <select id="city_id" name="city_id" class="form-control" required>
                                            <option value="">--Pilih Kota--</option>
                                            {{-- @foreach ($regionQuery->getCities(old('state_id')) as $st)
                                             <option value="{{$st->id}}">{{$st->name}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="form-group @error('address') has-error @enderror">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror">{{old('address')}}</textarea>
                                        @error('address')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group @error('latitude') has-error @enderror">
                                        <label class="form-label">Latitude</label>
                                        <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" placeholder="0.00" name="latitude" value="{{old('latitude')}}" >
                                         @error('latitude')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                     <div class="form-group @error('longitude') has-error @enderror">
                                        <label class="form-label">Longitude</label>
                                        <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" placeholder="0.00" name="longitude" value="{{old('longitude')}}" >
                                         @error('Longitude')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $longitude }}</strong>
                                                </span>
                                            @enderror
                                    </div>

                                    <div class="form-group @error('file') has-error @enderror">
                                        <label class="form-label">Logo</label>
                                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                                            @error('file')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
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
(function() {
    $.ajaxSetup({
        headers: {}
    });
    $("#state_id").change(function(e) {
        $("#city_id").val('');
        var province_id = $("#state_id").val();
        if (province_id == '') return false;
        $.get(
            "{{ route('api.regions.cities') }}",
            {
                province_id: province_id
            },
            function(data) {
                var string = '<option value="">-- Kota --</option>';
                $.each(data, function(index, value) {
                    string = string + `<option value="` + index + `">` + value + `</option>`;
                })
                $("#city_id").html(string);
            }
        );
    });

})();
</script>
@endsection