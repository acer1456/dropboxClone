<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Storage;
use AFM\Rsync\Rsync;


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
        $auth = Auth::user()->email;
        $directory = storage_path('app/public/'.$auth);
        $origin = $directory;

        $target = '/Users/Wei/Desktop/sync';
        $rsync = new Rsync;
        $rsync->sync($origin, $target);

        // $directory = Storage::directories(Auth::user()->email);
        $files = Storage::allfiles($auth);
        return view('home', compact('files'));
        // $files = Storage::allfiles();
        // // $size = Storage::size($files);
        // return view('home', compact('files'));
    }

    // public function uploadFile(){
    //     return view('uploadfile');
    // }

    public function uploadFilePost(Request $request){
        // $request->validate([
        //     'fileToUpload' => 'required|file|max:1024',
        // ]);

        $this->validate($request, [
            'fileToUpload' => 'required',
        ]);

        if($request->hasfile('fileToUpload'))
        {
           foreach($request->file('fileToUpload') as $file)
           {
               $file->storeAs(Auth::user()->email, $file->getClientOriginalName());
           }
        }
        
        return back()->with('success', 'Data Your files has been successfully added');

    }
}
