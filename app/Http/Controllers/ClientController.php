<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index(){
        try{
            $clients= Client::all();
            return response()->json(['status'=>'success','data'=>$clients], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function show($id){
        try{
            $client=Client::find($id);
            return response()->json(['status'=>'success','data'=>$client], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function update($id){

        try{
            $client=Client::find($id);//camelCase replaces "=" sign
            $client->fill(Input::all())->save();
            return response()->json(['status'=>'success','data'=>$client], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }

    public function destroy($id){

        try{
            $client = Client::find($id);
            $user = User::find($client->user_id);

            \DB::transaction(function() use ($user, $client) {

                $client->delete();
                $user->delete();
            });
            return response()->json(['status'=>'success','data'=>'deleted'], 200);
        }catch(\Exception $ex){
            return response()->json(['status'=>'Error','data'=>$ex], 500);
        }
    }


}
