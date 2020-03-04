<?php

namespace App\Http\Controllers\Productivity;

use Illuminate\Http\Request;
use App\Http\Events\Productivity\TaskCreated;
use App\Http\Events\Productivity\TaskRemoved;
use App\Laravue\Models\Productivity\Task;

class TaskController extends Controller
{
    public function fetchAll(){
            $tasks = Task::all();
            //return response()->json($tasks);
            return $tasks;
        }

        public function store(Request $request){
            $task = Task::create($request->all());
            broadcast(new TaskCreated($task));
            return response()->json("added");
        }

        public function delete($id){
            $task = Task::find($id);
            broadcast(new TaskRemoved($task));
            Task::destroy($id);
            return response()->json("deleted");
        }
}
