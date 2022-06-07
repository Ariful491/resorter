<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Resort;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }

    public function index(Request $request){
        if ($request->paginatItem){
            $paginator =  $request->paginatItem;
        }else{
            $paginator = 10;
        }
        if ($request->sort && $request->column){
            $sort =  $request->sort;
            $column =  $request->column;
        }else{
            $sort = 'desc';
            $column =  'id';
        }

        $list = Book::with('resort')->orderBy($column,$sort)->when($request->searchValue,function ($query, $searchValue){
            return $query->where('name','like', "%{$searchValue}%")->orWhere('email','like', "%{$searchValue}%");
        })->when($request->from_date,function ($query, $from_date){
            return $query->where('from_date','>=',$from_date);
        })->when($request->to_date,function ($query, $to_date){
            return $query->where('to_date','<=',$to_date);
        })->paginate($paginator);


        $coutList= Book::with('resort')->count();
        $pageName='Book';
        $urlName='books';
        return Inertia::render('Backend/Book/Index')
            ->with('pageName', $pageName)
            ->with('urlName', $urlName)
            ->with('data', $list)
            ->with('countTotal', $list->count())
            ->with('paginate', $paginator)
            ->with('rows', $coutList);
    }

    public function create()
    {
//        $pageName='Resort';
//        $urlName='resorts';
//        return Inertia::render('Backend/Resort/Add')
//            ->with('pageName', $pageName)
//            ->with('urlName', $urlName);
    }


    public function store(Request $request)
    {
//        $this->validate($request,[
//            'name'=>'required|max:50',
//            'code'=>'required',
////            'cat_values'=>'required',
//            'status'=>'required',
//        ]);
//
//        $resort = new Resort();
//        $resort->name = $request->name;
//        $resort->code = $request->code;
//        if($request->image){
//            $file = explode(';',$request->image);
//            $file = explode('/',$file[0]);
//            $file_Extension  = end($file);
//            $slug = $request->name.rand(1111,9999);
//            $file_name = $slug.'.'.$file_Extension;
//            Image::make($request->image)->save(public_path('uploads/cat_photos/').$file_name);
//            $resort->image = 'uploads/cat_photos/'.$file_name;
//        }
//        $resort->desc = $request->desc;
//        $resort->availability = $request->availability;
//        $resort->price = $request->price;
////        $resort->cat_value = json_encode($request->cat_values);
//        $resort->status = $request->status;
//        $resort->save();
//        return Redirect::route('resorts.index')->with('success','Resort has been added successfully!!');

    }

    public function show($id)
    {

        $pageName='Book';
        $urlName='books';
        return Inertia::render('Backend/Book/View')
            ->with('pageName', $pageName)
            ->with('urlName', $urlName)
            ->with('item',Book::with('resort')->where('id',$id)->first());


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
        $book=Book::find($id);
        $book->delete();
        return Redirect::route('books.index')->with('success','Resort has been deleted successfully!!');
    }

    public function status( Request  $request)
    {
        if($request->status=='cancel'){
            Book::where('id',$request->id)->update(['status'=>"cancel"]);
            return Redirect::route('books.index')->with('success','Book has been canceled successfully!!');
        }else{
            $booking=Book::find($request->id);
            $book_lists = Book::where('resort_id',$booking->resort_id)->where('status','confirm')->whereBetween('from_date', [$booking->from_date, $booking->to_date])->whereBetween('to_date', [$booking->from_date, $booking->to_date])->count();
            if($book_lists>0){
                return Redirect::route('books.index')->with('success','This resort already booked try later!!');
            }else{
                $data = $booking->toArray();
                Mail::send('confirmation_mail',$data,function ($message) use($data){
                    $message->to(User::where('id',1)->value('email'));
                    $message->subject('Have a new booking');
                });
                Book::where('id',$request->id)->update(['status'=>"confirm"]);
                return Redirect::route('books.index')->with('success','ook has been confirmed successfully!!!!');
            }


        }


    }

}
