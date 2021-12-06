<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memos;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MemoResource;

class MemoController extends Controller
{
    // Function: Retrieves data from the database for Memo page
    public function index(){ 
        $memos = Memos::all();

        //return view('memos.index', ['memos'=>$memos]);
        return MemoResource::collection($memos);
    }

    // Function: Retrieves specific memo record
    public function show($id){
        $memo = Memos::findOrFail($id);

        return new MemoResource($memo);
    }

    // Function: Stores new Memo in db 
    public function store(Request $request){
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'mimes:jpeg,png' // Only allow .jpg, and .png file types.
            ]);

            // Saving the file locally in the storage/public/ folder under a new folder named /memoFiles (php artisan storage:link)
            $request->file->store('memoFiles', 'public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $memo = new Memos();

            $memo->title = request('title');
            $memo->short_desc = request('desc');
            $memo->effectivity_date = request('effDate');
            $memo->issued_date = request('issDate');
            $memo->file_path = $request->file->hashName();

            $memo->save(); // saving the record.
        }

        return response()->json('Memo created!');
    }

    //Function: Deletes a Memo from the db
    public function destroy($id){
        $memo = Memos::findOrFail($id);
        $image_path = public_path('storage/memoFiles/'.$memo->file_path);
        unlink($image_path);
        
        $memo->delete();

        return response()->json('Memo Deleted');
    }

    //Function: Updates an existing memo from the db
    public function update(Request $request, $id){
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => 'mimes:jpeg,png' // Only allow .jpg, and .png file types.
            ]);

            // Store the record, using the new file hashname which will be it's new filename identity.
            $memo = Memos::findOrFail($id);

            $memo->title = request('title');
            $memo->short_desc = request('desc');
            $memo->effectivity_date = request('effDate');
            $memo->issued_date = request('issDate');

            $image_path = public_path('storage/memoFiles/'.$memo->file_path);
            if(file_exists($image_path)){
                unlink($image_path);
            }
            $memo->file_path = $request->file->hashName();

            // Saving the file locally in the storage/public/ folder under a new folder named /memoFiles
            $request->file->store('memoFiles', 'public');

            $memo->save(); // saving the record.
        }

        return response()->json('Memo updated!');
    }

}
