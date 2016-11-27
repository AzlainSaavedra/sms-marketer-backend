<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class VideoController extends Controller
{
    /*
     * Mostrar lista de recursos
     * @return Response
     * */
    public  function index(){
        $videos = \App\Models\Video::get();
        return response()->json([
            "msg"=>"success",
            "videos"=>$videos->toArray()
        ],200);
    }

    /*
     * Mostrar lista de recursos
     * */
    public  function store(){}

    /*
    * Mostrar lista de recursos
    * */
    public  function show($id){
        $videos = \App\Models\Video::find($id);
        return response()->json([
            "msg"=>"success",
            "videos"=>$videos->toArray()
        ],200);
    }

    /*
    * Mostrar lista de recursos
    * */
    public  function update(){}

    /*
     * Mostrar lista de recursos
     * */
    public  function destroy(){}
}
