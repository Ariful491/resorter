<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Resort;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class FrontendController extends Controller
{
    public function index(){
           $resorts =  Resort::where('status','active')->orderBy('id','desc')->get();

            return Inertia::render('Welcome', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'resorts'=>$resorts,
            ]);

    }
    public function booking($id){
        $resort = Resort::where('id',$id)->where('status','active')->first();
        return Inertia::render('Booking', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'id'=>$id,
            'resort'=>$resort,
        ]);
    }
    public function bookingStore(Request  $request){
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required',
            'address'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',
        ]);
        $resort = Resort::find($request->id);
        if($resort->availability=="not_available"){
            return Redirect::route('/')->with('success','Sorry this resort is not available!!');
        }
        $book = new Book();
        $book->name = $request->name;
        $book->email = $request->email;
        $book->address = $request->address;
        $book->from_date = $request->from_date;
        $book->to_date = $request->to_date;
        $book->resort_id = $request->id;
        $book->status = 'pending';
        $book->save();

        $data=$book->toArray();
          Mail::send('book-mail',$data,function ($message) use($data){
          $message->to(User::where('id',1)->value('email'));
          $message->subject('Have a new booking');
          });
        return Redirect::route('/')->with('success','Congratulation!! You has been booked successfully');
    }
}
