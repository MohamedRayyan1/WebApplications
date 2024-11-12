<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\Group;
use App\Models\History;
use App\Models\Reservation;

class File_Repo
{

public function create_file(array $data , $group_id,$user_id)
{
    $file = new File();
    $file->fileName =$data['file']->getClientOriginalName();
    $file->filePath =$data['file']->store('uploads');
    $file->status =$data['status'];
    $file->group_id =$group_id;
    $file->user_id =$user_id;

    $file->save();
    return $file;
}

public function create_group(array $data)
{
    $group = new Group();
    $group->name = $data['name'];
    $group->description = $data['description'] ?? null;
    $group->save();

    return $group;
}


public function lockFile($file_id)
{
$file = File::find($file_id);
$file->status=1;
$file->save();
}

public function unlockFile($file_id)
{
$file = File::find($file_id);
$file->status=0;
$file->save();
}

public function get_file($file_id)
{
$file = File::find($file_id);
return $file;
}

public function get_files()
{
$file = File::get();
return $file;
}

public function reserve($file_id , $user_id)
{
$reservation=new Reservation();
$reservation->user_id=$user_id;
$reservation->file_id=$file_id;
$reservation->status='checked-out';
$reservation->save();
return $reservation ;
}


}
