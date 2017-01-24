<?php

namespace App\Http\Controllers;

use App\Rule;
use Exception;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index','options']]);
    }

    public function index(){
        try{
            $rules= Rule::all();
            return response()->json(['status'=>'success','data'=>$rules], 200);
        }catch(Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function show($id){
        try{
            $rule=Rule::find($id);
            return response()->json(['status'=>'success','data'=>$rule], 200);
        }catch(Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function store(){
        try{
            $rule = new Rule();
            $rule->create(Input::all());
            return response()->json(['status'=>'success','data'=>$rule], 200);
        }catch(Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function update($id){
        try{
            $rule=Rule::find($id);//camelCase replaces "=" sign
            $rule->fill(Input::all())->save();
            return response()->json(['status'=>'success','data'=>$rule], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function destroy($id){
        try{
            $rule = Rule::find($id);
            $rule->delete();
            return response()->json(['status'=>'success','data'=>'deleted'], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function options()
    {
        return response()->json(['status'=>'ok'], 200);
    }
}
