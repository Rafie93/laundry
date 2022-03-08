@extends('app.app')
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 p-0">
            <div class="page-header">
                <div class="page-title">
                    <ol class="breadcrumb text-left">
                        <li><a href="{{Route('event.running')}}">Subscription</a></li>
                        <li><a href="{{Route('event.list')}}">Data Event</a></li>
                        <li class="active">Add Event</li>
                    </ol>
                </div>
            </div>
        </div>   
        <form action="{{Route('event.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
                    
        <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                
                                    <div class="form-group @error('name') has-error @enderror">
                                        <label class="form-label">Nama Event *</label>
                                        <input type="text" class="form-control"
                                        placeholder="" name="name" required value="{{old('name')}}">
                                        @error('name')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('category') has-error @enderror">
                                        <label class="form-label">Category Event</label>
                                        {{-- <input type="text" class="form-control"
                                        placeholder="" name="category" value="{{old('category')}}"> --}}
                                        <select name="category" id="category" class="form-control">
                                            <option value="Offline">Offline</option>
                                            <option value="Online">Online</option>
                                        </select>
                                        @error('category')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group" id="link_online">
                                        <label class="form-label">Online Links</label>
                                        <input type="text" class="form-control"
                                        placeholder="" name="online_link" id="online_link" value="{{old('online_link')}}">
                                       
                                    </div>

                                    <div class="form-group @error('date') has-error @enderror">
                                        <label class="form-label">Tanggal Mulai Event</label>
                                        <input type="date" class="form-control" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="date" required value="{{old('date') ? old('date') : date('Y-m-d')}}">
                                        @error('date')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('date_end') has-error @enderror">
                                        <label class="form-label">Tanggal Berakhir Event</label>
                                        <input type="date" class="form-control" data-date="" data-date-format="DD-MM-YYYY" 
                                        placeholder="" name="date_end" required value="{{old('date_end') ? old('date_end') : date('Y-m-d')}}">
                                        @error('date_end')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                             
                                     <div class="form-group @error('price') has-error @enderror">
                                        <label class="form-label">Harga *</label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="price" required value="{{old('price')}}">
                                        @error('price')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="card-body">
                                    <div class="form-group @error('description') has-error @enderror">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" id="editor" class="form-control">{{old('description')}}</textarea>
                                        @error('description')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div> 
                                </div>                            
                            </div>
                            
                        </div>
                    </div>
            </div>
        </div>
         <div class="col-12 col-lg-6 col-xxl-6 d-flex">
            <div class="card flex-fill">
                <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                     <div class="form-group @error('point_cashback') has-error @enderror">
                                        <label class="form-label">Point Cashback </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="point_cashback" required value="{{old('point_cashback') ? old('point_cashback') : 0}}">
                                        @error('point_cashback')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                     <div class="form-group @error('kouta') has-error @enderror">
                                        <label class="form-label">Kouta Event </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="kouta" required value="{{old('kouta') ? old('kouta') : ''}}">
                                        @error('kouta')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                     <div class="form-group @error('min_purchased') has-error @enderror">
                                        <label class="form-label">Minimal Purchased </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="min_purchased" required value="{{old('min_purchased') ? old('min_purchased') : 1}}">
                                        @error('min_purchased')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                     <div class="form-group @error('max_purchased') has-error @enderror">
                                        <label class="form-label">Maximal Purchased </label>
                                        <input type="number" class="form-control"
                                        placeholder="" name="max_purchased" required value="{{old('max_purchased') ? old('max_purchased') : 5}}">
                                        @error('max_purchased')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>


                                      <div class="form-group @error('cover') has-error @enderror">
                                        <label class="form-label">Cover </label>
                                        <input type="file" name="cover" class="form-control">
                                        @error('cover')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>

                                    <div class="form-group @error('term_condition') has-error @enderror">
                                        <label class="form-label">Term & Condition</label>
                                        <textarea name="term_condition" id="editor2" class="form-control">{{old('term_condition')}}</textarea>
                                        @error('term_condition')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                </div>                            
                            </div>
                            
                        </div>
                    </div>
            </div>
        </div>
    
        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
            <div class="card flex-fill">
                <br/>
                <button type="submit" class="btn btn-lg btn-info mg">SIMPAN</button>
                <br/>
            </div>
        </div>

        </form>
    </div>

</div>
@endsection
@section('script')
<script>
  CKEDITOR.replace('editor', {
        height  : '200px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
 CKEDITOR.replace('editor2', {
        height  : '200px',
        filebrowserUploadUrl: "{{route('product.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $(document).ready(function(){
        $("#link_online").hide();

        $('select[name=category]').change(function(){
                let cat = $("#category").val();
                if(cat=="Online"){
                    $("#link_online").show();
                }else{
                    $("#link_online").hide();
                    $("#online_link").val('');
                }
			});
    });

    
</script>
@endsection