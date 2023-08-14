<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function getAllTasks(){
        try {
            return Task::all();
        } catch (\Throwable $th) {
            throw $th;
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
            return response()->json(['message'=>$th]);
        }
    }
    public function createTask(Request $request){
        try {
            $task = new Task;
            $task->title=$request->title;
            $task->description=$request->description;
            $task->status=$request->status;
            $task->file_name=$request->file;
            $result = $task->save();
            if($result){
                return response()->json(['message'=>'Task Successfully Recorded'], 200);
            }
        } catch (\Throwable $th) {
            return ['message'=>$th];
        }
    }
    public function deleteTask($id){
        try {
            $task = Task::find($id);
            if($task){
                $task->delete();
                return response()->json(['message'=>'Task Successfully Deleted'], 200);
            }else{
                return response()->json(['message'=>'Task not found'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th]);
        }
    }

    public function editTask(Request $request, $id){
        $task = Task::find($id);
        $validatedData = $request->validate([
            'title' => 'required',
        ]);
        try {
            if($task){
                $task->update($validatedData);
                return response()->json(['message'=>'Task Successfully Updated'], 200);
            }else{
                return response()->json(['message'=>'Task not found'], 404);
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>'error']);
        }



    }
}
