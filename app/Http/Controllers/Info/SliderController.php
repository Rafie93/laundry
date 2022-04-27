<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information\Slider;
use Image;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Slider::orderBy('id','desc')
                        ->paginate(10);
       
        return view('slider.index',compact('sliders'));
    }

    public function create(Request $request)
    {
       return view('slider.create');
    }

    public function edit(Request $request,$id)
    {
        $data = Slider::find($id);
       return view('slider.edit',compact('data'));
    }

    public function store(Request $request)
    {        
        $this->validate($request,[
            'title' => 'required',
            'file' => 'required'
        ]);
        

        $slider = Slider::create($request->all());
         if ($request->hasFile('file')) {
            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/slider/',$fileName);
            $slider->file = $fileName;
            $slider->save();
       }
        return redirect()->route('slider')->with('message','Slider Baru Berhasil ditambahkan');
    }
    public function update(Request $request)
    {        
        $this->validate($request,[
            'title' => 'required',
            'slide' => 'required'
        ]);
        $slider = Slider::find($id);
        $slider->update($request->all());
         if ($request->hasFile('file')) {
            $image_path = public_path().'/images/slider/'.$slider->slide;
            unlink($image_path);

            $originName = $request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('file')->move('images/slider/',$fileName);
            $slider->file = $fileName;
            $slider->save();
       }
        return redirect()->route('slider')->with('message','Slider Baru Berhasil ditambahkan');
    }

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('images/slider/',$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/slider/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }
     public function delete($id)
    {
        $slider=Slider::find($id);
        $image_path = public_path().'/images/slider/'.$slider->slide;
        unlink($image_path);
        $slider->delete();
        return redirect()->route('slider')->with('message','Berhasil dihapus');
    }
}
