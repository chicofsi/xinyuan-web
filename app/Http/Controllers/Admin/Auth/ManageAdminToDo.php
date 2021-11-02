<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\AdminToDo;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Transaction;

class ManageAdminToDo extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo=AdminToDo::where('id_admin',Auth::id())->get();
        if($todo->isEmpty()){
            $todolist="EMPTY";
        }else{
            $todolist="";
            foreach ($todo as $key => $value) {
                if($value->done==1){
                    $todolist.= "<li class='clearfix'>
                                            <span class='drag-marker'>
                                            <i></i>
                                            </span>
                                            <div class='todo-check pull-left'>
                                                <input type='checkbox' id='todo-check' checked />
                                                <label for='todo-check'></label>
                                                <input type='hidden' value='".$value->id."' id='id_todo'  />
                                            </div>
                                            <p class='todo-title line-through'>".$value->message."</p><p class=''>Date Task Done: ".$value->done_date."</p>
                                            <div class='todo-actionlist pull-right clearfix'>
                                                
                                                <a href='#'  class='remove-todo'><i class='fas fa-trash'></i></a>
                                            </div>
                                        </li>";

                }else{
                    $todolist.= "<li class='clearfix'>
                                            <span class='drag-marker'>
                                            <i></i>
                                            </span>
                                            <div class='todo-check pull-left'>
                                                <input type='checkbox' id='todo-check'  />
                                                <label for='todo-check'></label>
                                                <input type='hidden' value='".$value->id."' id='id_todo'  />
                                            </div>
                                            <p class='todo-title '>".$value->message."</p>
                                            <div class='todo-actionlist pull-right clearfix'>
                                                <a href='#' class='remove-todo'><i class='fas fa-trash'></i></a>
                                            </div>
                                        </li>";
                }
                
            }
        }

        return $todolist;
        
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adminId = Auth::id();
        
        $target   =   AdminToDo::create(
                    [
                    'id_admin' => $adminId, 
                    'message' => $request->message, 
                    'done' => 0
                    ]);    
                         
        return Response()->json($target);
        
    }

    public function toggle(Request $request)
    {
        $todoId = $request->id;
        $todo=AdminToDo::where('id',$todoId)->first();
        $todo=$todo->done;
        if($todo==0){
            $done=1;
        }else{
            $done=0;
        }

        $todo   =   AdminToDo::where('id',$todoId)->update(['done'=> $done,'done_date'=> Date('Y-m-d')]);
                         
        return Response()->json($todo);
        
    }

    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(Request $request)
    {
        $todo = AdminToDo::where('id',$request->id)->delete();
        return Response()->json($todo);
    }
}
