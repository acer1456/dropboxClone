<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // $files = Storage::files($directory);
        // $contents = Storage::get($files);

        $files = Storage::allfiles();
        $size = Storage::size($files);
        return view('home', compact('files'));
    }

    // public function uploadFile(){
    //     return view('uploadfile');
    // }

    public function uploadFilePost(Request $request){
        $request->validate([
            'fileToUpload' => 'required|file|max:1024',
        ]);
        $request->fileToUpload->store('logos');
        return view('home');

    }
}
