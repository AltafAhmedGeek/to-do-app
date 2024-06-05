<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = TaskModel::get();
        return view('tasks', compact('tasks'));
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => "required|unique:task,name,NULL,id,deleted_at,NULL|max:255",
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }
        $task = TaskModel::create([
            'name' => $request->name,
            'status' => 'Pending'
        ]);
        if ($task) {
            return response()->json(['status' => true, 'task' => $task]);
        }
        return response()->json(['status' => false], 500);
    }

    public function completed(Request $request)
    {
        $task = TaskModel::find($request->id);
        if (!empty($task)) {
            $updated = $task->update(['status' => 'Done']);
            if ($updated) {
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 500);
    }
    public function destroy(Request $request)
    {
        $task = TaskModel::find($request->id);
        if (!empty($task)) {
            $deleted = $task->delete();
            if ($deleted) {
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 500);
    }
}
