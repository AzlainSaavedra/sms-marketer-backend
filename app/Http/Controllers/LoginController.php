<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{


    // Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
    // pero solamente para los métodos de crear, actualizar y borrar.
    public function __construct()
    {
        if(!$this->middleware('auth.basic',['only'=>['store']])){
            return Response::json(array(["validated"=>false]));
        }
    }


    public function store(Request $request){

        return Response::json(array(["validated"=>true]));

    }
}
