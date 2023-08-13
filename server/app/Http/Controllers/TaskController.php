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
            return DB::select("select * from tbl_task");
        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function createTask(Request $request){
        // try {

        //     return response()->json(['message' => 'Data inserted successfully'], 201);
        // } catch (\Throwable $th) {
        //     return response()->json(['message' => $th]);
        // }
        $task = new Task;
        $task->title=$request->title;
        $task->description=$request->description;
        $task->status=$request->status;
        $task->file_name=$request->file;
        $result = $task->save();
        if($result){
            return ['message'=>'Task Recorded Successfully', 'code'=>200];
        }else{
            return ['message'=>'Error saving task'];
        }
    }
}
