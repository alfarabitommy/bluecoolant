<?php

namespace App\Http\Controllers;

use App\HeaderSlider;
use App\Language;
use Illuminate\Http\Request;

class HeaderSliderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){

//        $grouped_by = HeaderSlider::all()->groupBy('lang');
//        return $grouped_by;
        $all_header_slider = HeaderSlider::all()->groupBy('lang'); //HeaderSlider::all();
        $all_language = Language::all();
        return view('backend.pages.home.header')->with(['all_header_slider' => $all_header_slider,'all_language' => $all_language]);
    }

    public function store(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'btn_01_text' => 'nullable|string|max:191',
            'btn_02_text' => 'nullable|string|max:191',
            'btn_01_url' => 'nullable|string|max:191',
            'btn_02_url' => 'nullable|string|max:191',
            'btn_01_status' => 'nullable|string|max:191',
            'btn_02_status' => 'nullable|string|max:191',
            'description' => 'required|string',
            'image' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191'
        ]);

         HeaderSlider::create([
            'title' => $request->title,
            'btn_01_text' => $request->btn_01_text,
            'btn_02_text' => $request->btn_02_text,
            'btn_01_url' => $request->btn_01_url,
            'btn_02_url' => $request->btn_02_url,
            'btn_01_status' => $request->btn_01_status,
            'btn_02_status' => $request->btn_02_status,
            'description' => $request->description,
            'image' => $request->image,
            'lang' => $request->lang
          ]);

          return redirect()->back()->with(['msg' => 'New Header Slider Added...','type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'btn_01_text' => 'nullable|string|max:191',
            'btn_02_text' => 'nullable|string|max:191',
            'btn_01_url' => 'nullable|string|max:191',
            'btn_02_url' => 'nullable|string|max:191',
            'btn_01_status' => 'nullable|string|max:191',
            'btn_02_status' => 'nullable|string|max:191',
            'description' => 'required|string',
            'image' => 'nullable|string|max:191',
            'lang' => 'required|string|max:191'
        ]);

        HeaderSlider::find($request->id)->update([
            'title' => $request->title,
            'btn_01_text' => $request->btn_01_text,
            'btn_02_text' => $request->btn_02_text,
            'btn_01_url' => $request->btn_01_url,
            'btn_02_url' => $request->btn_02_url,
            'btn_01_status' => $request->btn_01_status,
            'btn_02_status' => $request->btn_02_status,
            'description' => $request->description,
            'image' => $request->image,
            'lang' => $request->lang
        ]);

        return redirect()->back()->with(['msg' => 'Header Slider Updated...','type' => 'success']);
    }

      public function delete($id){
        HeaderSlider::find($id)->delete();
       return redirect()->back()->with(['msg' => __('Delete Success...'),'type' => 'danger']);
      }

      public function bulk_action(Request $request){
          $all = HeaderSlider::find($request->ids);
          foreach($all as $item){
              $item->delete();
          }
          return (response()->json(['status' => 'ok']) &&
           redirect()->back()->with(['msg' => 'Header Bulk Delete Success....','type' => 'danger']));
      }

}
