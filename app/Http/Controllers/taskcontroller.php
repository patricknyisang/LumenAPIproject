<?php

namespace App\Http\Controllers;

use App\Models\TBtask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Store a new task
    public function store_task(Request $request)
    {
        $title = $request->get('title');  
        $descr = $request->get('description');
        $status = $request->get('status');
        $duedate = $request->get('due_date');
        $datecreated = Carbon::now();
        
        // Validate required fields
        if (empty($title)) {
            return response(['error' => true, 'message' => 'Enter task title'], 400);
        }
        if (empty($descr)) {
            return response(['error' => true, 'message' => 'Enter task description'], 400);
        }
        if (empty($status)) {
            return response(['error' => true, 'message' => 'Enter task status'], 400);
        }
        if (empty($duedate)) {
            return response(['error' => true, 'message' => 'Enter task due date'], 400);
        }

        // Create task data
        $createtask = [
            "title" => $title,
            "description" => $descr,
            "status" => $status,
            "due_date" => $duedate,
            "created_at" => $datecreated,
            "updated_at" => $datecreated,
        ];
        
        // Save task in the database
        TBtask::create($createtask);
        
        return response()->json(['error' => false, 'message' => 'Task successfully created'], 201);
    }

    // Get all tasks with pagination
    public function gettasks(Request $request)
    {
        try {
            // Get the number of items per page from query parameter or default to 10
            $perPage = $request->input('per_page', 10); // Default to 10 items per page
            
            // Fetch paginated tasks
            $tasks = TBtask::paginate($perPage);
            
            // Return paginated results as JSON
            return response()->json($tasks, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    // Delete a task by ID
    public function deleteitem($id)
    {
        try {
            $task = TBtask::findOrFail($id);
            $task->delete();
            return response()->json(['error' => false, 'message' => 'Task deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    // Update task by ID
    public function updatetask(Request $request, $id)
    {
        $title = $request->get('title');  
        $descr = $request->get('description');
        $status = $request->get('status');
        $duedate = $request->get('due_date');
        $dateupdated = Carbon::now();

        try {
            $task = TBtask::findOrFail($id); // Use findOrFail to handle not found
            $task->update([
                "title" => $title,
                "description" => $descr,
                "status" => $status,
                "due_date" => $duedate,
                "updated_at" => $dateupdated, 
            ]);

            return response()->json(['error' => false, 'message' => 'Task updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }
}
