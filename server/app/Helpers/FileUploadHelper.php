<?php
// these are helper functions for uploading file in the uploads folder
namespace App\Helpers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class FileUploadHelper{
    //function to upload the file
    public function upload(Request $request, $fileName){
        try {
            if($request->hasFile('file')){
                $file = $request->file('file');
                $path = public_path('uploads');

                $file->move($path, $fileName);

                return 1;
            }else{
                return null;
            }
        } catch (\Throwable $th) {
            return 0;
        }
    }
    //function to get a unique file name of the selected file.
    public function getFileName(Request $request){
        try {
            if($request->hasFile('file')){
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();

                return $fileName;
            }else{
                return null;
            }
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function deleteFile($fileName){
        try {
            $path='uploads/'.$fileName;
            if(File::exists($path)){
                File::delete($path);
                return 1;
            }else{
                return -1;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
