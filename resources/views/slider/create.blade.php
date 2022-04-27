@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('slider')}}">Data Slider</a></li>
                        <li class="active">Tambah Slider Baru</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <form action="{{Route('slider.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}   
                    	<div class="row">
						<div class="col-12 col-lg-12">
							<div class="card">
								<div class="card-body">
                                    <div class="form-group @error('title') has-error @enderror">
                                        <label class="form-label">Title*</label>
									    <input type="text" class="form-control @error('title') has-error @enderror"
                                         placeholder="" name="title" value="{{old('title')}}">
                                         @error('title')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>  
                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" id="editor" class="description">{{old('description')}}</textarea>
									  
                                         @error('description')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                         @enderror
                                    </div>   
                                    <div class="form-group @error('file') has-error @enderror">
                                        <label class="form-label">Slide Image</label>
									    <input type="file" class="form-control @error('file') has-error @enderror"
                                         placeholder="" name="file" value="{{old('file')}}">
                                         @error('file')
                                                <span class="help-block" role="alert">
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
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '400px',
        filebrowserUploadUrl: "{{route('slider.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection