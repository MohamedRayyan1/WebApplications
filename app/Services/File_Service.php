<?php
namespace App\Services;

use App\Models\File;
use App\Models\Reservation;
use App\Repositories\File_Repo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class File_Service
{
private $file_Repo;

public function __construct(File_Repo $file_Repo) {
    $this->file_Repo = $file_Repo;
}

public function upload(Request $request ,$group_id)
{
    $validator = $request->validate([
        'file' => 'required|file|mimes:txt,pdf,docx|max:2048',
        'status' => 'required',
    ]);
    $path= $request->file('file')->store('uploads');
    $user_id =Auth::user()->id;
    $file=$this->file_Repo->create_file($validator , $group_id , $user_id);
    return response()->json([
        'success' => $file,
       ]);
}

public function check_lock($file_id)
{

    $file = $this->file_Repo->get_file($file_id);
        if($file->status == 0)
            return false ;

        if($file->status == 1)
            return true ;
}

// public function checkOut($file_id)
// {
//     if($this->check_lock($file_id)){
//     return false ;
//     }
//     $file = $this->file_Repo->get_file($file_id);

//     $file->status = 1 ;
//     $user_id=auth()->user()->id;
//     $this->file_Repo->reserve($file_id , $user_id);
//     return true ;
// }
public function checkOut($file_id)
{
    if ($this->check_lock($file_id)) {
        return false ;
        }
    $file = $this->file_Repo->get_file($file_id);
    $this->file_Repo->lockFile($file_id);
    $user_id = auth()->user()->id;
    $this->file_Repo->reserve($file_id, $user_id);
    return response()->json([

        'message' => true ,
        'success' => 'File checked out successfully. You can now download and edit the file.',
        'download_path' => Storage::url($file->filePath),
    ]);
}

public function checkIn($file_id)
{
    if($this->check_lock($file_id)){
        $lastReservation = Reservation::where('file_id', $file_id)->orderBy('created_at', 'desc')->first();
       if($lastReservation && auth()->user()->id === $lastReservation->user_id){

           $file = $this->file_Repo->get_file($file_id);
           $user_id=auth()->user()->id;
           $reserve =$this->file_Repo->reserve($file_id , $user_id);
           $reserve->status = 'checked-in';
           $reserve->save();
           $file->status = 0 ;
           $file->save();

           return true ;
        }
    }
    return false ;
}



public function download($file_id)
{
    $file = $this->file_Repo->get_file($file_id);

    if (!Storage::exists($file->filePath)) {
        return response()->json(['message' => 'File not found'], 404);
    }
    return Storage::download($file->filePath, $file->fileName);
}

public function createGroup(Request $request)
{
    $validator = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);
    $group = $this->file_Repo->create_group($validator);
    return response()->json([
        'success' => true,
        'group' => $group,
    ]);
}



}
