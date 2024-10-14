<?php

namespace App\Http\Controllers;

use App\Models\TBtask;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
class taskcontroller extends Controller
{
    public function store_task(Request $request) {
        $title = $request->get('tittle');
        $descr = $request->get('description');
        $status = $request->get('status');
        $duedate = $request->get('due_date');
        $datecreated = Carbon::now();
        $dateupdated = Carbon::now();
    
        // Validations
        if ($title == null) {
            return response(['error' => true, 'message' => 'Enter task title']);
        }
        if ($descr == null) {
            return response(['error' => true, 'message' => 'Enter task description']);
        }
        if ($status == null) {
            return response(['error' => true, 'message' => 'Enter task status']);
        }
        if ($duedate == null) {
            return response(['error' => true, 'message' => 'Enter task due date']);
        }
        if ($datecreated == null) {
            return response(['error' => true, 'message' => 'Enter task date created']);
        }
        if ($dateupdated == null) {
            return response(['error' => true, 'message' => 'Enter task date updated']);
        }
        // Prepare data for insertion
        $createtask = [
            "tittle" => $title,
            "description" => $descr,
            "status" => $status,
            "due_date" => $duedate,
            "created_at" => $datecreated,
            "updated_at" => $dateupdated,
        ];
    
        // Insert the data into the database
        TBtask::create($createtask);
    
        // Return success response
        return response(['error' => false, 'message' => 'task successfully created']);
    }


    public function gettasks(){
        try {
            $date = Carbon::now();
            $fetchtask = TBtask::all();
            $taskall = [];
    
            foreach($fetchtask as $item) {
                $taskall[] = [
                    "tittle" => $item->{'tittle'},
                    "description" => $item->{'description'},
                    "status" => $item->{'status'},
                    "due_date" => $item->{'due_date'},
                    "created_at" => $item->{'created_at'},
                    "updated_at" => $item->{'updated_at'},
                ];
            }
    
            return response()->json($taskall, 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    

    public function deleteitem($id){

        TBtask::where(['taskid' => $id], true)->delete();
    
        return redirect()->route('fetch')->with('success', 'Post updated successfully!');
    }


     //update function
     public function updatetask(Request $request,$id){
        $title = $request->get('tittle');
        $descr = $request->get('description');
        $status = $request->get('status');
        $duedate = $request->get('due_date');
        $datecreated = Carbon::now();
        $dateupdated = Carbon::now();

   TBitems::where(['item_id' => $id])->update([
        "tittle" => $title,
            "description" => $descr,
            "status" => $status,
            "due_date" => $duedate,
            "created_at" => $datecreated,
            "updated_at" => $dateupdated, 
    ]);
    return redirect(url('edithurl'))->with ('message', 'Update successfully');
}


}