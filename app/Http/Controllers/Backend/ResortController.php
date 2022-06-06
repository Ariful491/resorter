<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Backend\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Image;

class ResortController extends Controller
{
    /**
     * ResortController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function index(Request $request){

        if ($request->paginatItem){
            $paginator =  $request->paginatItem;
        }else{
            $paginator = 1;
        }
        if ($request->sort && $request->column){
            $sort =  $request->sort;
            $column =  $request->column;
        }else{
            $sort = 'desc';
            $column =  'id';
        }

        $list = Resort::orderBy($column,$sort)->when($request->searchValue,function ($query, $searchValue){
            return $query->where('name','like', "%{$searchValue}%")->orWhere('desc','like', "%{$searchValue}%");
        })->paginate($paginator);
        $coutList= Resort::count();
        $pageName='Resort';
        $urlName='resorts';
        return Inertia::render('Backend/Resort/Index')
            ->with('pageName', $pageName)
            ->with('urlName', $urlName)
            ->with('data', $list)
            ->with('countTotal', $list->count())
            ->with('paginate', $paginator)
            ->with('rows', $coutList);
    }

    public function create()
    {
        $pageName='Resort';
        $urlName='resorts';
        return Inertia::render('Backend/Resort/Add')
            ->with('pageName', $pageName)
            ->with('urlName', $urlName);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'code'=>'required',
//            'cat_values'=>'required',
            'status'=>'required',
        ]);

        $resort = new Resort();
        $resort->name = $request->name;
        $resort->code = $request->code;
        if($request->image){
            $file = explode(';',$request->image);
            $file = explode('/',$file[0]);
            $file_Extension  = end($file);
            $slug = $request->name.rand(1111,9999);
            $file_name = $slug.'.'.$file_Extension;
            Image::make($request->image)->save(public_path('uploads/cat_photos/').$file_name);
            $resort->image = 'uploads/cat_photos/'.$file_name;
        }
        $resort->desc = $request->desc;
        $resort->availability = $request->availability;
        $resort->price = $request->price;
//        $resort->cat_value = json_encode($request->cat_values);
        $resort->status = $request->status;
        $resort->save();
        return Redirect::route('resorts.index')->with('success','Resort has been added successfully!!');

    }

    public function show(Resort $resort)
    {

    }

    public function edit($id)
    {
        $pageName='Resort';
        $urlName='resorts';
        $data =  Resort::find($id);
        return Inertia::render('Backend/Resort/Edit')
            ->with('pageName', $pageName)
            ->with('item', $data)
            ->with('urlName', $urlName);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name'=>'required|max:50',
            'code'=>'required',
//            'cat_values'=>'required',
            'status'=>'required',
        ]);

        $resort = Resort::find($id);
        $resort->name = $request->name;
        $resort->code = $request->code;
        if($request->image){
            $file = explode(';',$request->image);
            $file = explode('/',$file[0]);
            $file_Extension  = end($file);
            $slug = $request->name.rand(1111,9999);
            $file_name = $slug.'.'.$file_Extension;
            Image::make($request->image)->save(public_path('uploads/cat_photos/').$file_name);
            $resort->image = 'uploads/cat_photos/'.$file_name;
        }
        $resort->desc = $request->desc;
        $resort->availability = $request->availability;
        $resort->price = $request->price;
//        $resort->cat_value = json_encode($request->cat_values);
        $resort->status = $request->status;
        $resort->save();
        return Redirect::route('resorts.index')->with('success','Resort has been updated successfully!!');
    }

    public function destroy( $id)
    {
        $resort=Resort::find($id);
         $resort->delete();
        return Redirect::route('resorts.index')->with('success','Resort has been deleted successfully!!');
    }
}
