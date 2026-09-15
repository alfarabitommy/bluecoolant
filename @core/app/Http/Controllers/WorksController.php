<?php

namespace App\Http\Controllers;

use App\Language;
use App\Works;
use App\WorksCategory;
use App\WorksImage;
use App\WorksIndustry;
use App\WorksOem;
use App\WorksPackaging;
use App\WorksSectors;
use App\WorksSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Str;

class WorksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $all_works = DB::table('works as a')
                    ->leftJoin(DB::raw('(SELECT works_id, MIN(id) as min_id, image FROM works_image GROUP BY works_id) as b'), 'a.id', '=', 'b.works_id')
                    ->select('*', 'a.id as id', 'a.lang as lang')
                    ->where('a.status', 'publish')
                    ->get()
                    ->groupBy('lang');
                    
        $work_category = WorksCategory::where(['status'=> 'publish','lang' => 'en'])->get();
        $work_sectors = WorksSectors::where(['status'=> 'publish','lang' => 'en'])->get();
        $all_language = Language::all();
        return view('backend.pages.works.index')->with(['all_works' => $all_works, 'works_category' => $work_category,'works_sectors' => $work_sectors,'all_language' => $all_language]);
    }

    public function add(){
      $work_category = WorksCategory::where(['status'=> 'publish','lang' => get_default_language()])->get();
      $work_sectors = WorksSectors::where(['status'=> 'publish','lang' => get_default_language()])->get();
      $work_subcategory = WorksSubcategory::where(['status'=> 'publish','lang' => get_default_language()])->get();
      $all_language = Language::all();
      $all_oem = WorksOem::all();
      $all_industry = WorksIndustry::all();
      $all_packaging = WorksPackaging::all();

      return view('backend.pages.works.new')->with([
          'works_category' => $work_category,
          'works_sectors' => $work_sectors,
          'works_subcategory' => $work_subcategory,
          'all_language' => $all_language,
          'all_oem' => $all_oem,
          'all_industry' => $all_industry,
          'all_packaging' => $all_packaging,
      ]);
    }

    public function store(Request $request)
    {
      $this->validate($request, [
           'title' => 'required|string|max:191',
           'start_date' => 'nullable|string|max:191',
           'end_date' => 'nullable|string|max:191',
           'lang' => 'nullable|string|max:191',
           'slug' => 'nullable|string|max:191',
           'clients' => 'nullable|string',
           'description' => 'required|string',
           'categories_id' => 'required',
           'meta_description' => 'nullable|string|max:191',
           'meta_tags' => 'nullable|string|max:191',
           'status' => 'required|string|max:191',
           "file" => "mimetypes:application/pdf|max:10420",
           'file_tds' => "mimetypes:application/pdf|max:10420",
       ]);
       $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
       $check_slug = Works::where('slug',$blog_slug)->get();

       if (count($check_slug) > 0){
           $blog_slug .= count($check_slug) + 1;
       }

       $ListSectors = '';
       if(is_array($request->sectors_id)){
        $ListSectors = implode(',', $request->sectors_id);
       }

       $list_oem = '';
       if(is_array($request->oem_id)){
            $list_oem = implode(',', $request->oem_id);
       }

       $list_industry = '';
       if(is_array($request->industry_id)){
            $list_industry = implode(',', $request->industry_id);
       }

       $list_packaging = '';
       if(is_array($request->packaging_id)){
            $list_packaging = implode(',', $request->packaging_id);
       }

       $arr_create = [
           'title' => $request->title,
           'slug' => $blog_slug,
           'gallery' => $request->gallery,
           'meta_description' => $request->meta_description,
           'meta_tags' => $request->meta_tags,
           'start_date' => $request->start_date,
           'end_date' => $request->end_date,
           'lang' => $request->lang,
           'clients' => $request->clients,
           'description' => $request->description,
           'status' => $request->status,
           'meta_title' => $request->meta_title,
           'categories_id' => serialize($request->categories_id),
           'category_id'=>$request->categories_id,
           'subcategory_id' => $request->subcategories_id,
           'sectors_id'=>$ListSectors,
           'oem_id' => $list_oem,
           'industry_id' => $list_industry,
           'packaging_id' => $list_packaging,
           'benefit' => $request->benefit,
       ];

       $nama_file='';
        if(isset($_FILES['file'])){
            if($_FILES['file']['name']){
                $file = $request->file('file');
            
                $nama_file = time()."_".$file->getClientOriginalName();
     
                $tujuan_upload = 'assets/uploads/catalog';
                $file->move($tujuan_upload,$nama_file);

                $arr_create['file'] = $nama_file;
            }
        }

        $nama_file_tds='';
        if(isset($_FILES['file_tds'])){
            if($_FILES['file_tds']['name']){
                $file_tds = $request->file('file_tds');
            
                $nama_file_tds = time()."_".$file_tds->getClientOriginalName();
     
                $tujuan_upload_tds = 'assets/uploads/tds';
                $file_tds->move($tujuan_upload_tds,$nama_file_tds);

                $arr_create['tds'] = $nama_file_tds;
            }
        }
       
       Works::create($arr_create);

       return redirect()->back()->with(['msg' => __('New product Added...'), 'type' => 'success']);
    }

  public function clone(Request $request){
    $work_item = Works::findOrFail($request->item_id);

    $blog_slug = $work_item->slug;

    $check_slug = Works::where('slug',$work_item->slug)->get();
    if (count($check_slug) > 0){
        $blog_slug .= count($check_slug) + 1;
    }
    
    Works::findOrFail($work_item->id)->create(
        [
            'title' => $work_item->title,
            'slug' => $blog_slug,
            'gallery' => $work_item->gallery,
            'meta_description' => $work_item->meta_description,
            'meta_tags' => $work_item->meta_tags,
            'start_date' => $work_item->start_date,
            'end_date' => $work_item->end_date,
            'lang' => $work_item->lang,
            'clients' => $work_item->clients,
            'description' => $work_item->description,
            'meta_title' => $work_item->meta_title,
            'status' => 'draft',
            'categories_id' => serialize($work_item->categories_id),
            'category_id'=>$work_item->category_id,
            'subcategory_id'=>$work_item->subcategory_id,
            'sectors_id'=>$work_item->sectors_id,
            'oem_id' => $work_item->oem_id,
            'industry_id' => $work_item->industry_id,
            'file' => $work_item->file,
            'packaging_id' => $work_item->packaging_id,
            'benefit' => $work_item->benefit,
            'tds' => $work_item->tds,
        ]
    );

    return redirect()->back()->with(['msg' => __('Clone Success...'), 'type' => 'danger']);
}

    public function edit(Request  $request,$id){
        $work_item = Works::findOrFail($id);
        $all_category = WorksCategory::where('lang',$work_item->lang)->get();
        $all_subcategory = WorksSubcategory::where('lang', $work_item->lang)->get();
        $all_sectors = WorksSectors::where('lang',$work_item->lang)->get();
        $all_languages = Language::all();
        $all_oem = WorksOem::all();
        $all_industry = WorksIndustry::all();
        $all_packaging = WorksPackaging::all();

        return view('backend.pages.works.edit')->with([
            'all_category' => $all_category,
            'all_subcategory' => $all_subcategory,
            'all_sectors' => $all_sectors,
            'all_languages' => $all_languages,
            'work_item' => $work_item,
            'all_oem' => $all_oem,
            'all_industry' => $all_industry,
            'all_packaging' => $all_packaging,
        ]);
  }

    public function update(Request $request)
    {
      $this->validate($request, [
          'title' => 'required|string|max:191',
          'start_date' => 'nullable|string|max:191',
          'end_date' => 'nullable|string|max:191',
          'lang' => 'nullable|string|max:191',
          'slug' => 'nullable|string|max:191',
          'clients' => 'nullable|string',
          'description' => 'required|string',
          'categories_id' => 'required',
          'meta_description' => 'nullable|string|max:191',
          'meta_tags' => 'nullable|string|max:191',
          'status' => 'required|string|max:191',
          "file" => "mimetypes:application/pdf|max:10420",
          "file_tds" => "mimetypes:application/pdf|max:10420",
      ]);

      $blog_slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
      
      $ListSectors = '';
      if(is_array($request->sectors_id)){
       $ListSectors = implode(',', $request->sectors_id);
      }

      $list_oem = '';
      if(is_array($request->oem_id)){
        $list_oem = implode(',', $request->oem_id);
      }

      $list_industry = '';
      if(is_array($request->industry_id)){
        $list_industry = implode(',', $request->industry_id);
      }

      $list_packaging = '';
      if(is_array($request->packaging_id)){
        $list_packaging = implode(',', $request->packaging_id);
      }

      $arr_update = [
        'title' => $request->title,
        'slug' => $blog_slug,
        'gallery' => $request->gallery,
        'meta_description' => $request->meta_description,
        'meta_tags' => $request->meta_tags,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'lang' => $request->lang,
        'clients' => $request->clients,
        'description' => $request->description,
        'status' => $request->status,
        'meta_title' => $request->meta_title,
        'categories_id' => serialize($request->categories_id),
        'category_id'=>$request->categories_id,
        'subcategory_id'=>$request->subcategories_id,
        'sectors_id'=>$ListSectors,
        'oem_id' => $list_oem,
        'industry_id' => $list_industry,
        'packaging_id' => $list_packaging,
        'benefit' => $request->benefit,
      ];


      	// menyimpan data file yang diupload ke variabel $file
        // var_dump($_FILES['file']);
        // die();
        $nama_file='';
        if(isset($_FILES['file'])){
            if($_FILES['file']['name']){
                $file = $request->file('file');
            
                $nama_file = time()."_".$file->getClientOriginalName();
     
                $tujuan_upload = 'assets/uploads/catalog';
                $file->move($tujuan_upload,$nama_file);

                $arr_update['file'] = $nama_file;
            }
        } 

        $nama_file_tds='';
        if(isset($_FILES['file_tds'])){
            if($_FILES['file_tds']['name']){
                $file_tds = $request->file('file_tds');
            
                $nama_file_tds = time()."_".$file_tds->getClientOriginalName();
     
                $tujuan_upload_tds = 'assets/uploads/tds';
                $file_tds->move($tujuan_upload_tds,$nama_file_tds);

                $arr_update['tds'] = $nama_file_tds;
            }
        }

        Works::findOrFail($request->id)->update($arr_update);
        
        return redirect()->back()->with(['msg' => __('Product Updated...'), 'type' => 'success']);
    }

    public function delete($id)
    {
        Works::findOrFail($id)->delete();
       return redirect()->back()->with(['msg' => __('Delete Success...'), 'type' => 'danger']);
    }
    

    public function category_index()
    {
        $all_category = WorksCategory::all()->groupBy('lang');
        return view('backend.pages.works.category')->with(['all_category' => $all_category]);
    }

    public function category_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Category Added...',
            'type' => 'success'
        ]);
    }

    public function category_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksCategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => 'Category Update Success...',
            'type' => 'success'
        ]);
    }

    public function category_delete(Request $request, $id)
    {
        if (Works::where('categories_id', $id)->first()) {
            return redirect()->back()->with([
                'msg' => 'You Can Not Delete This Category, It Already Associated With A Products ...',
                'type' => 'danger'
            ]);
        }
        WorksCategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Category Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function category_by_slug(Request $request){
        $all_category = WorksCategory::where('lang',$request->lang)->get();
        return response()->json($all_category);
    }

        public function bulk_action(Request $request){
        $all = Works::findOrFail($request->ids);
        foreach($all as $item){
            if ($request->type == 'delete'){
                $item->delete();
            }else{
                $item->status = $request->type;
                $item->save();
            }
        }
        return response()->json(['status' => 'ok']);
    }

    public function category_bulk_action(Request $request){
        $all = WorksCategory::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return (response()->json(['status' => 'ok']) &&
         redirect()->back()->with(['msg' => 'Work Category Bulk Delete Success....','type' => 'danger']));
    }

    // Subcategory
    public function subcategory_index()
    {
        $all_subcategory = DB::table('works_subcategory as a')
                            ->leftJoin('works_categories as b', 'a.category_id','=','b.id')
                            ->select('a.id','a.name','a.lang','a.status','a.category_id','b.name as category_name')
                            ->get()
                            ->groupBy('lang');

        $en_category = WorksCategory::where('lang', 'en')->get();
        return view('backend.pages.works.subcategory')->with(['all_subcategory' => $all_subcategory, 'en_category' => $en_category]);
    }

    public function get_category_by_lang_ajax(Request $request)
    {
        $lang = $request->lang;

        $categories = WorksCategory::where('lang', $lang)->get();
        return response()->json($categories);
    }

    public function subcategory_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'category_id' => 'required'
        ]);

        WorksSubcategory::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Subcategory Added...',
            'type' => 'success'
        ]);
    }

    public function subcategory_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'category_id' => 'required'
        ]);

        WorksSubcategory::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
            'category_id' => $request->category_id,
        ]);

        return redirect()->back()->with([
            'msg' => 'Subcategory Update Success...',
            'type' => 'success'
        ]);
    }

    public function subcategory_delete(Request $request, $id)
    {
        if (Works::where('subcategory_id', $id)->first()) {
            return redirect()->back()->with([
                'msg' => 'You Can Not Delete This Subcategory, It Already Associated With A Products ...',
                'type' => 'danger'
            ]);
        }
        WorksSubcategory::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Subcategory Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function subcategory_bulk_action(Request $request){
        $all = WorksSubcategory::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return (response()->json(['status' => 'ok']) &&
         redirect()->back()->with(['msg' => 'Work Subcategory Bulk Delete Success....','type' => 'danger']));
    }

    public function sectors_index()
    {
        $all_sectors = WorksSectors::all()->groupBy('lang');
        return view('backend.pages.works.sectors')->with(['all_sectors' => $all_sectors]);
    }

    public function sectors_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksSectors::create($request->all());

        return redirect()->back()->with([
            'msg' => 'New Sectors Added...',
            'type' => 'success'
        ]);
    }

    public function sectors_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'lang' => 'required|string|max:191',
            'status' => 'required|string|max:191'
        ]);

        WorksSectors::find($request->id)->update([
            'name' => $request->name,
            'status' => $request->status,
            'lang' => $request->lang,
        ]);

        return redirect()->back()->with([
            'msg' => 'Sectors Update Success...',
            'type' => 'success'
        ]);
    }

    public function sectors_delete(Request $request, $id)
    {
        if (Works::where('sectors_id', $id)->first()) {
            return redirect()->back()->with([
                'msg' => 'You Can Not Delete This Sectors, It Already Associated With A Products ...',
                'type' => 'danger'
            ]);
        }
        WorksSectors::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Sectors Delete Success...',
            'type' => 'danger'
        ]);
    }

    public function sectors_by_slug(Request $request){
        $all_sectors = WorksSectors::where('lang',$request->lang)->get();
        return response()->json($all_sectors);
    }

    public function sectors_bulk_action(Request $request){
        $all = WorksSectors::find($request->ids);
        foreach($all as $item){
            $item->delete();
        }
        return (response()->json(['status' => 'ok']) &&
         redirect()->back()->with(['msg' => 'Work Sectors Bulk Delete Success....','type' => 'danger']));
    }

    // Products Image
    public function works_image()
    {
        $works_image = DB::table('works_image as a')
                        ->leftJoin('works as b', 'a.works_id','=','b.id')
                        ->select('a.id','a.image','b.title','a.lang')
                        ->get()
                        ->groupBy('lang');

        return view('backend.pages.works.images')->with([
            'works_image' => $works_image,
        ]);
    }

    public function add_image(){
      $en_works = Works::where('lang', 'en')->get();

      return view('backend.pages.works.new_image')->with([
          'en_works' => $en_works,
      ]);
    }

    public function get_product_by_lang_ajax(Request $request)
    {
        $lang = $request->lang;

        $products = Works::where('lang', $lang)->get();
        return response()->json($products);
    }

    public function store_image(Request $request)
    {
        $this->validate($request, [
            'product' => 'required',
            'image' => 'nullable|string|max:191',
            'lang' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        DB::table('works_image')->insert(
            [
                'works_id' => $request->product,
                'image' => $request->image,
                'lang' => $request->lang,
                'created_at' => $now,
                'updated_at' => $now
            ]
        );

        return redirect()->back()->with(['msg' => __('New Product Image Added...'), 'type' => 'success']);
    }

    public function edit_image($id)
    {
        $work_image = WorksImage::findOrFail($id);
        $works_lang = Works::where('lang', $work_image->lang)->get();

        return view('backend.pages.works.edit_image')->with([
            'work_image' => $work_image,
            'works_lang' => $works_lang
        ]);
    }

    public function update_image(Request $request, $id)
    {
        $this->validate($request, [
            'product' => 'required',
            'image' => 'nullable|string|max:191',
            'lang' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksImage::findOrFail($id)->update(
            [
                'works_id' => $request->product,
                'image' => $request->image,
                'lang' => $request->lang,
                'updated_at' => $now,
            ]
        );
        
        return redirect()->back()->with(['msg' => __('Works Image Updated...'), 'type' => 'success']);
    }

    public function delete_image($id)
    {
        $image = DB::table('works_image as a')
                    ->leftJoin('media_uploads as b', 'a.image','=','b.id')
                    ->where('a.id', $id)
                    ->select('a.id','a.image','b.path')
                    ->first();

        WorksImage::findOrFail($id)->delete();

        // delete file ?
        /*if ($image) {
            DB::table('media_uploads')->where('id', $image->image)->delete();

            $link = $image->path;
            $file = 'assets/uploads/media-uploader/'.$link;
            if (file_exists($file)) {
                unlink($file);
            }

            $file_grid = 'assets/uploads/media-uploader/grid-'.$link;
            if (file_exists($file_grid)) {
                unlink($file_grid);
            }

            $file_thumb = 'assets/uploads/media-uploader/thumb-'.$link;
            if (file_exists($file_thumb)) {
                unlink($file_thumb);
            }

            $file_large = 'assets/uploads/media-uploader/large-'.$link;
            if (file_exists($file_large)) {
                unlink($file_large);
            }
        }*/
        
        return redirect()->back()->with(['msg' => __('Delete Success...'), 'type' => 'danger']);
    }

    public function bulk_action_image(Request $request)
    {
        $all = WorksImage::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }

        return (response()->json(['status' => 'ok'])) &&
            redirect()->back()->with(['msg' => 'Image Bulk Delete Success...', 'type' => 'danger']);
    }

    // OEMs
    public function oem_index()
    {
        $all_oem = WorksOem::all();
        return view('backend.pages.works.oem')->with(['all_oem' => $all_oem]);
    }

    public function store_oem(Request $request)
    {
        $this->validate($request, [
            'spec' => 'required|string|max:50'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksOem::create([
            'spec' => $request->spec,
            'approval' => $request->approval,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'New OEM Added...',
            'type' => 'success'
        ]);
    }

    public function update_oem(Request $request)
    {
        $this->validate($request, [
            'spec' => 'required|string|max:50'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksOem::find($request->id)->update([
            'spec' => $request->spec,
            'approval' => $request->approval,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'OEM Update Success...',
            'type' => 'success'
        ]);
    }

    public function delete_oem($id)
    {
        WorksOem::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'OEM Deleted Succesfully...',
            'type' => 'danger'
        ]);
    }

    public function oem_bulk_action(Request $request)
    {
        $all = WorksOem::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }

        return (response()->json(['status' => 'ok'])) &&
            redirect()->back()->with(['msg' => 'OEM Bulk Delete Success...', 'type' => 'danger']);
    }

    // Industries
    public function industry_index()
    {
        $all_industry = WorksIndustry::all();
        return view('backend.pages.works.industries')->with(['all_industry' => $all_industry]);
    }

    public function store_industry(Request $request)
    {
        $this->validate($request, [
            'spec' => 'required|string|max:50',
            'approval' => 'max:100'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksIndustry::create([
            'spec' => $request->spec,
            'approval' => $request->approval,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'New Industry Added...',
            'type' => 'success'
        ]);
    }

    public function update_industry(Request $request)
    {
        $this->validate($request, [
            'spec' => 'required|string|max:50',
            'approval' => 'max:100'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksIndustry::find($request->id)->update([
            'spec' => $request->spec,
            'approval' => $request->approval,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'Industry Update Success...',
            'type' => 'success'
        ]);
    }

    public function delete_industry($id)
    {
        WorksIndustry::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Industry Deleted Succesfully...',
            'type' => 'danger'
        ]);
    }

    public function industry_bulk_action(Request $request)
    {
        $all = WorksIndustry::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }

        return (response()->json(['status' => 'ok'])) &&
            redirect()->back()->with(['msg' => 'Industry Bulk Delete Success...', 'type' => 'danger']);
    }
    
    // Packagings
    public function packaging_index()
    {
        $all_packaging = WorksPackaging::all();
        return view('backend.pages.works.packagings')->with(['all_packaging' => $all_packaging]);
    }

    public function store_packaging(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksPackaging::create([
            'name' => $request->name,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'New Packaging Added...',
            'type' => 'success'
        ]);
    }

    public function update_packaging(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        WorksPackaging::find($request->id)->update([
            'name' => $request->name,
            'updated_at' => $now
        ]);

        return redirect()->back()->with([
            'msg' => 'Packaging Update Success...',
            'type' => 'success'
        ]);
    }

    public function delete_packaging($id)
    {
        WorksPackaging::find($id)->delete();
        return redirect()->back()->with([
            'msg' => 'Packaging Deleted Succesfully...',
            'type' => 'danger'
        ]);
    }

    public function packaging_bulk_action(Request $request)
    {
        $all = WorksPackaging::find($request->ids);
        foreach ($all as $item) {
            $item->delete();
        }

        return (response()->json(['status' => 'ok'])) &&
            redirect()->back()->with(['msg' => 'Packaging Bulk Delete Success...', 'type' => 'danger']);
    }
}
