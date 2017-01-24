<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Database\QueryException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Response;

class jwtLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'resetPassword','options']]);
    }

    public function index(Request $request)
    {
        return json_encode(["token_validate" => true]);
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $newPassword = str_random(5);

        try {
            User::where('email', $email)
                ->update(['password' => \Hash::make($newPassword)]);
            try {
                $message = "Su contraseña ha sido recuperada con exito!\nSu nueva contraseña es: $newPassword";

                \Mail::raw($message, function ($message) {
                    $message->subject('Recuperacion de contraseña');
                    $message->from(env('MAIL_DOMAIN_FROM'), 'Laravel App');
                    $message->to($GLOBALS['request']->input('email'));
                });

                return json_encode(["data" => "Success", "message" => "PASSWORD_RECOVERED"]);

            } catch (\Exception $ex) {

                return json_encode(["data" => "Error", "message" => "EMAIL_SEND_ERROR"]);

            }
        } catch (QueryException $ex) {

            return json_encode(["data" => "Error", "message" => "SQL_ERROR"]);

        }
    }

    public function passwordChange(Request $request)
    {
        $id = $request->input('id');
        $email = $request->input('email');
        $oldPass = $request->input('oldPass');
        $newPass = $request->input('newPass');

        $credentials = [
            'email' => $email,
            'password' => $oldPass
        ];

        try {
            if (\Auth::once($credentials)) { // esta es la función que afirma si los datos son correctos o no
                User::where('email', $email)
                    ->update(['password' => \Hash::make($newPass)]);

                $message = "Su contraseña ha sido cambiada con exito!";

                try {
                    $message = "Su contraseña ha sido cambiada con exito!";

                    \Mail::raw($message, function ($message) {
                        $message->subject('Cambio de contraseña');
                        $message->from(env('MAIL_DOMAIN_FROM'), 'Laravel App');
                        $message->to($GLOBALS['request']->input('email'));
                    });
                    return json_encode(["data" => "Success", "message" => "PASSWORD_RECOVERED_EMAIL_SENDED"]);
                } catch (\Exception $ex) {
                    return json_encode(["data" => "Success", "message" => "PASSWORD_RECOVERED_EMAIL_NOT_SENDED"]);
                }

            } else {

                return json_encode(["data" => "Error", "message" => "PASSWORD_NOT_MATCH"]);
            }
        } catch (\Exception $ex) {

            return json_encode(["data" => "Error", "message" => "SQL_ERROR", "Exception" => $ex]);

        }
    }


    public function login(Request $request)
    {
        // credenciales para loguear al usuario
        $credentials = $request->only('email', 'password');

        try {
            // si los datos de login no son correctos
            if (!$token = JWTAuth::attempt($credentials)) {
                return json_encode(["Error" => 'invalid_credentials']);
            }
        } catch (JWTException $e) {
            // si no se puede crear el token
            return json_encode(["Error" => 'could_not_create_token']);
        }

        // todo bien devuelve el token
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if (!$request->input('email') || !$request->input('nombre') || !$request->input('apellido') || !$request->input('password')) {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan datos necesarios para el proceso de alta.'])], 422);
        }

        try {
            // Insertamos una fila en Users con create pasándole todos los datos recibidos.
            // En $request->all() tendremos todos los campos del formulario recibidos.
            //$user = User::create($request->all());

            $user = new User();
            $user->password = $request->input('password');
            $user->email = $request->input('email');
            $user->rule_id = $request->input('rule_id');


            $client = new Client();
            $client->firstName = $request->input('nombre');
            $client->lastName = $request->input('apellido');
            $client->email = $request->input('email');


            \DB::transaction(function () use ($user, $client) {

                $user->save();
                $user->client()->save($client);
            });

            // Más información sobre respuestas en http://jsonapi.org/format/
            // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
            $response = Response::make(json_encode(['data' => $client]), 201)->header('Location', 'http://www.dominio.local/fabricantes/' . $user->id)->header('Content-Type', 'application/json');
            return $response;

        } catch (QueryException $ex) {
            $error_code = $ex->errorInfo[1];
            return json_encode(["Error" => $ex]);
        }


    }

    public function getUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // Token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function options()
    {
        return response()->json(['status'=>'ok'], 200);
    }
}
