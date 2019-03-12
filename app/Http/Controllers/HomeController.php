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

    public function sync()
    {
        $directory = storage_path('app/public');
        $origin = $directory;
        $target = '/Users/Wei/Desktop/sync';
        $rsync = new Rsync;
        $rsync->sync($origin, $target);
        return back()->with('success', 'Data has been synced');
    }
    public function remove()
    {
        $directory = storage_path('app');
        // $directories = Storage::allDirectories($directory);
        $dirs = Storage::directories($directory);
        foreach ($dirs as $dir) {
            Storage::deleteDirectory($dir);
        }
        return back()->with('success', 'All Data has been deleted');
    }
    public function index()
    {   
        // $directory = Storage::directories(Auth::user()->email);
        $files = Storage::allfiles();

        // foreach ($files as $file) {
        //     $deletefile = Storage::delete($file);
        // }

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
            //    Storage::mimeType($file);
            //    Storage::exists($file);
            //    Storage::type($file);
            //    Storage::size($file);
            //    Storage::lastModified($file);
                    
               if(Storage::exists($file->getClientOriginalName())){
                    // $newsize = Storage::size($file);
                    // $oldsize = Storage::size(Storage::exists($file->getClientOriginalName()));
                    // if($newsize == $oldsize){
                        return back()->with('success', 'same file');
                    // }else{

                    // }
               }else{
                    $file->storeAs('', $file->getClientOriginalName());
                    return back()->with('success', 'Data added');
               }
           }
        }

    }
}
