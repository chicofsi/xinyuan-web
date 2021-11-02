<?php

namespace App\Http\Controllers\ApiSales\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ValueMessage;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\Area as AreaResource;

use App\Models\SalesToDo;

class TodoController extends Controller
{
    public function getTodo(Request $request)
    {
        $todo=SalesToDo::where('id_sales',$request->user()->id)->get();
        if($todo->isEmpty()){
            return response()->json(new ValueMessage(['value'=>0,'message'=>'To Do Empty!','data'=> '']), 404);
        }
        else{
            
        }
        return response()->json(new ValueMessage(['value'=>1,'message'=>'Get Todo Success!','data'=> $todo]), 200);
        
        

    }

    public function checkTodo(Request $request)
    {
        $todoId = $request->id_todo;
        $todo=SalesToDo::where('id_sales',$request->user()->id)->where('id',$todoId)->first();
        $todo=$todo->done;
        if($todo==0){
            $done=1;
        }else{
            $done=0;
        }

        $todo   =   SalesToDo::where('id',$todoId)->update(['done'=> $done,'done_date'=> Date('Y-m-d')]);
         
        return response()->json(new ValueMessage(['value'=>1,'message'=>'check todo Success!','data'=> '']), 200);
        
        

    }

}
