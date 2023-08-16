<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function getAllTasks(){
        try {
            return Task::all();
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 500);
        }

    }
    public function getTask($id){
        try {
            $task = Task::find($id);
            if(!$task){
                return response()->json(['message'=>'Task not found'], 404);
            }
            return response()->json($task);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 500);
        }
    }
    public function createTask(Request $request){
        try {
            $fileUploader = new FileUploadHelper();
            $file_name = $fileUploader->getFileName($request);
                if($file_name!==0){
                    $task = new Task;
                    $task->title=$request->title;
                    $task->description=$request->description;
                    $task->status=$request->status;
                    $task->file_name=$file_name;
                    $result = $task->save();
                    $fileUploader->upload($request, $file_name);
                    if($result){
                        return response()->json(['message'=>'Task Successfully Recorded', 'success'=>true], 200);
                    }
                }else{
                    return response()->json(['message'=>'There is a problem uploading your file.', 'success'=>false], 404);
                }

        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 500);
        }
    }
    //function to delete file from the uploads folder upon deletion of task in the database.
    public function deleteTask($id){
        try {
            $fileUploader = new FileUploadHelper();
            $task = Task::find($id);
            if($task){
                $status = $fileUploader->deleteFile($task->file_name);
                if($status===1||$status===-1){
                    $task->delete();
                    return response()->json(['message'=>'Task Successfully Deleted', 'success'=>true], 200);
                }else{
                    return response()->json(['message'=>$status, 'success'=>false], 404);
                }
            }else{
                return response()->json(['message'=>'Task not found' , 'success'=>false], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()], 500);
        }
    }

    public function editTask(Request $request, $id){
        try {
            $task = Task::find($id);
            $fileUploader = new FileUploadHelper();

            if($request->file->getClientOriginalName() === $task->file_name){
                $validatedData = $request->validate([
                    'title' => 'required',
                    'description'=>'nullable',
                    'status'=>'required',
                ]);
                if($task){
                    $task->update($validatedData);
                    return response()->json(['message'=>'Task Successfully Updated', 'success'=>true], 200);
                }else{
                    return response()->json(['message'=>'Task not found', 'success'=>false], 404);
                }
            }
            else{
                $file_name = $fileUploader->getFileName($request);
                if($file_name!==null){
                    $validatedData = $request->validate([
                        'title' => 'required',
                        'description'=>'nullable',
                        'status'=>'required',
                        'file_name'=>'nullable'
                    ]);

                    if($task){
                        // $task->update($validatedData);
                        $task->title= $validatedData['title'];
                        $task->description = $validatedData['description'];
                        $task->status = $validatedData['status'];
                        $task->file_name = $file_name;
                        $task->update();
                        $fileUploader->upload($request, $file_name);
                        return response()->json(['message'=>'Task Successfully Updated', 'success'=>true], 200);
                    }else{
                        return response()->json(['message'=>'Task not found', 'success'=>false], 404);
                    }
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()]);
        }
    }

    public function getFileObject($fileName){
        $filePath = public_path('uploads/' . $fileName);
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
            return response($fileContent, 200)
                ->header('Content-Type', mime_content_type($filePath));
        } else {
            return response()->json(['error' => 'File not found', 'success'=>false], 404);
        }
    }
}

