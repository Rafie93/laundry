<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information\News;
use Image;

class NewsController extends Controller
{
     public function index(Request $request)
    {
        $news = News::orderBy('id','desc')->paginate(10);
        return view('news.index',compact('news'));
    }

    public function create(Request $request)
    {
       return view('news.create');
    }

    public function edit(Request $request,$id)
    {
        $data = News::find($id);
       return view('news.edit',compact('data'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
        ]);
        
        $request->merge([
            'slug'=>$request->title,
            'createdAt' => auth()->user()->id
        ]);

        $news = News::create($request->all());
         if ($request->hasFile('cover')) {
            $originName = $request->file('cover')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('cover')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('cover')->move('images/news/',$fileName);
            $news->cover = $fileName;
            $news->save();
       }
        return redirect()->route('news')->with('message','News Baru Berhasil ditambahkan');
    }
    
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('images/news/',$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/news/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

   public function update(Request $request,$id)
    {        
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
        ]);
        $news = News::find($id);
        $news->update($request->all());
         if ($request->hasFile('file')) {
            $image_path = public_path().'/images/news/'.$news->cover;
            unlink($image_path);
            
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/news/',$fileName);
            $news->cover = $fileName;
            $news->save();
       }
        return redirect()->route('news')->with('message','News Baru Berhasil ditambahkan');
    }
    public function delete($id)
    {
        $news=News::find($id);
        $image_path = public_path().'/images/news/'.$news->cover;
        unlink($image_path);
        $news->delete();
        return redirect()->route('news')->with('message','Berhasil dihapus');
    }
}
