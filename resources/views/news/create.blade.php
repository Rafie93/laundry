@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('news')}}">Data News</a></li>
                        <li class="active">Tambah News Baru</li>
                    </ol>
                </div>
            </div>
        </div>
           <form action="{{Route('news.store')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}   
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
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
                                <div class="form-group @error('tag') has-error @enderror">
                                    <label class="form-label">Tag</label>
                                    <input type="text" class="form-control @error('tag') has-error @enderror"
                                        placeholder="" name="tag" value="{{old('tag')}}">
                                        @error('tag')
                                            <span class="help-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>   
                                <div class="form-group @error('cover') has-error @enderror">
                                    <label class="form-label">Cover</label>
                                    <input type="file" class="form-control @error('cover') has-error @enderror"
                                        placeholder="" name="cover" value="{{old('cover')}}">
                                        @error('cover')
                                            <span class="help-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                 <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Deskripsi Lengkap </label>
                                        <textarea id="editor" name="description" class="form-control" id="" rows="13"></textarea>
                                          @error('description')
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
                                        Publish
                                        </span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" value="0">
                                        <span class="form-check-label">
                                        Draft
                                        </span>
                                    </label>
                                </div> 
                                
                            </div>
                        
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
     
        <div class="col-12 col-lg-12 col-xxl-12">
             <button type="submit" class="btn btn-lg btn-info mg">SIMPAN</button>

        </div>
     </form>

      
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '400px',
        filebrowserUploadUrl: "{{route('news.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endsection