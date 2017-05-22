<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\User;
use Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }

    public function indexOld(Request $request){

        $email = $request->input('email');

        try{
            $user = User::where('email', $email)->get();
            return response()->json(['status'=>'success','data'=>$user[0]], 200);
        }catch(\QueryException $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function getUsers(){

        try{
            $users= User::all();
            return response()->json(['status'=>'success','data'=>$users], 200);
        }catch(\QueryException $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function index(){
        try{
            $users= User::all();
            return response()->json(['status'=>'success','data'=>$users], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function show($id){
        try{
            $user=User::find($id);
            return response()->json(['status'=>'success','data'=>$user], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function store(){
        try{
            $user = new User();
            $user->create(Input::all());
            return response()->json(['status'=>'success','data'=>$user], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function update($id){

        try{
            $user=User::find($id);//camelCase replaces "=" sign
            $user->fill(Input::all())->save();
            return response()->json(['status'=>'success','data'=>$user], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function destroy($id){

        try{
            if($id!=1){
                $user = User::find($id);
                $user->delete();
                return response()->json(['status'=>'success','data'=>'deleted'], 200);
            }else{
                return response()->json(['status'=>'error','data'=>'user admin can\'t remove'], 200);
            }
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function options()
    {
        return response()->json(['status'=>'ok'], 200);
    }
}
