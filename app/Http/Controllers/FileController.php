<?php

namespace App\Http\Controllers;

use App\Services\File_Service;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $fileService;

    public function __construct(File_Service $fileService)
    {
        $this->fileService = $fileService;
    }

    public function uploadFile(Request $request, $group_id)
    {
        return $this->fileService->upload($request, $group_id);
    }

    public function downloadFile($file_id)
    {
        return $this->fileService->download($file_id);
    }

    public function checkOutFile($file_id)
    {
        $result = $this->fileService->checkOut($file_id);

        if ($result) {
            return response()->json(['message' => 'File successfully checked out.'], 200);
        } else {
            return response()->json(['message' => 'File is already checked out or unavailable.'], 403);
        }
    }

    public function checkInFile($file_id)
    {
        $result = $this->fileService->checkIn($file_id);

        if ($result) {
            return response()->json(['message' => 'File successfully checked in and unlocked.'], 200);
        } else {
            return response()->json(['message' => 'You do not have permission to check in this file or file is not checked out.'], 403);
        }
    }

}
