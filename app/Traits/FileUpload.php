<?php

namespace App\Traits;

use URL;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait FileUpload
{
    public function uploadFile(UploadedFile $file, $uploadPath)
    {
        $file_name = Str::slug(time() . '.' . $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $file_name);
        $file_url = "/" . $uploadPath . "/" . $file_name;
        return $file_url;
    }

    public function updateFile(UploadedFile $file, $uploadPath, $oldFilePath)
    {
        $this->deleteFile($oldFilePath);
        return $this->uploadFile($file, $uploadPath);
    }

    public function deleteFile($filePath)
    {
        if (File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
    }
}
