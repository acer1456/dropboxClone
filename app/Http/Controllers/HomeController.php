<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $directory = Storage::directories(Auth::user()->email);
        $files = Storage::allfiles(Auth::user()->email);
        return view('home', compact('files'));
        // $files = Storage::allfiles();
        // // $size = Storage::size($files);
        // return view('home', compact('files'));
    }

    // public function uploadFile(){
    //     return view('uploadfile');
    // }

    public function uploadFilePost(Request $request){
        $request->validate([
            'fileToUpload' => 'required|file|max:1024',
        ]);
        // $request->fileToUpload->putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
        $request->fileToUpload->storeAs(Auth::user()->email, $request->fileToUpload->getClientOriginalName());
        $files = Storage::allfiles(Auth::user()->email);
        return view('home', compact('files'));
    }
}
