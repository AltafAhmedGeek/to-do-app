<?php

namespace App\Http\Controllers;

use App\Models\TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:tasks|max:255',
        ];
        $validator = Validator::make($request->only('name'), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 500);
        }
        $task = TaskModel::create(
            [
                'name' => $request->name
            ]
        );
        if ($task) {
            return response()->json(['status' => true, 'task' => $task]);
        }
        return response()->json(['status' => false], 500);
    }
    public function completed(TaskModel $task)
    {
        $updated = $task->update(['status' => 'Done']);
        if ($updated) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 500);
    }
    public function destroy($id)
    {
        $task = TaskModel::find($id);
        if ($task->delete()) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false], 500);
        }
    }
}
