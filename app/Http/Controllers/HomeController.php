<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use Storage;
use AFM\Rsync\Rsync;
use ViKon\Diff\Diff;



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

    public function onlineSyncToLocal()
    {
        $directory = storage_path('app/public/');
        $origin = $directory;
        $target = '/Users/Wei/Desktop/sync/';
        $rsync = new Rsync;
        $rsync->sync($origin, $target);
        return back()->with('success', 'Online data has been synced to local');
    }
    public function LocalSyncToOnline()
    {
        $directory = storage_path('app/public');
        $origin = $directory;
        $target = '/Users/Wei/Desktop/sync/';
        $rsync = new Rsync;
        $rsync->sync($target, $origin);
        return back()->with('success', 'Local data has been synced to online');
    }
    public function remove()
    {
        // $directory = storage_path('app');
        // $directories = Storage::allDirectories($directory);
        $files = Storage::allfiles();
        foreach ($files as $file) {
            Storage::delete($file);
        }
        return back()->with('success', 'All Data has been deleted');
    }
    public function index()
    {   
        // $directory = Storage::directories(Auth::user()->email);

        $files = Storage::allfiles();
        foreach ($files as $file) {
            Storage::setVisibility($file, 'public');
            echo Storage::getVisibility($file);
        }

        // $txt = storage_path('app/public/text.py');
        // $txt2 = Storage::get('test2.py');
        // $diff = Diff::compareFiles($txt, $txt2);
        // echo $diff->toHTML();

        return view('home', compact('files'));
    }

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
                    
               if(Storage::exists($file->getClientOriginalName())){
                    // $newsize = Storage::size($file);
                    // $oldsize = Storage::size(Storage::exists($file->getClientOriginalName()));
                    // if($newsize == $oldsize){
                        return back()->with('success', 'same file');
                    // }else{

                    // }
               }else{
                    $name = $file->getClientOriginalName();
                    $file->storeAs('', $name);
               }
           }
        }
        return back()->with('success', 'Data added');
    }
}



         