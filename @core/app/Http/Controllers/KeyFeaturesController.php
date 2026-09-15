<?php

namespace App\Http\Controllers;

use App\KeyFeatures;
use Illuminate\Http\Request;

class KeyFeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $all_key_features = KeyFeatures::all()->groupBy('lang');
        return view('backend.pages.key-features')->with(['all_key_features' => $all_key_features]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required|string|max:191',
            'icon' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'description' => 'required|string',
        ]);
        KeyFeatures::create($request->all());
        return redirect()->back()->with(['msg' => 'New Key Feature Added...','type' => 'success']);
    }

    public function update(Request $request){

        $this->validate($request,[
            'title' => 'required|string|max:191',
            'icon' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'description' => 'required|string',
        ]);
        KeyFeatures::find($request->id)->update($request->all());
        return redirect()->back()->with(['msg' => 'Key Feature Updated...','type' => 'success']);
    }

    public function delete($id){
        KeyFeatures::find($id)->delete();
        return redirect()->back()->with(['msg' => 'Delete Success...','type' => 'danger']);
    }

    public function bulk_action(Request $request){
        $all = KeyFeatures::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return (response()->json(['status' => 'ok']) &&
         redirect()->back()->with(['msg' => 'Key Feature Bulk Delete Success....','type' => 'danger']));
    }
}
