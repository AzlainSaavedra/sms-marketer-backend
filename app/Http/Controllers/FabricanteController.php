<?php

namespace App\Http\Controllers;
use App\Fabricante;

use Illuminate\Http\Request;

use App\Http\Requests;

// Activamos uso de caché.
use Illuminate\Support\Facades\Cache;

use Response;

class FabricanteController extends Controller
{


    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

/*    // Configuramos en el constructor del controlador la autenticación usando el Middleware auth.basic,
    // pero solamente para los métodos de crear, actualizar y borrar.
    public function __construct()
    {
        $this->middleware('auth.basic',['only'=>['index','store','update','destroy']]);
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Devuelve todos los fabricantes en JSON.
        // return Fabricante::all();

        // Mejora en la respuesta.
        // Devolvemos explícitamente el código 200 http de datos encontrados.
        // Se puede poner como 404 cuando no se encuentra nada.
        //return response()->json(['datos'=>Fabricante::all()],200);

        // Activamos la caché de los resultados.
        //  Cache::remember('tabla', $minutes, function()
        $fabricantes=Cache::remember('fabricantes',20/60, function()
        {
            // Caché válida durante 20 segundos.
            return Fabricante::all();
        });

        // Con caché.
        return response()->json(['status'=>'ok','data'=>$fabricantes], 200);

        // Sin caché.
        //return response()->json(['status'=>'ok','data'=>Fabricante::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Primero comprobaremos si estamos recibiendo todos los campos.
        if (!$request->input('nombre') || !$request->input('direccion') || !$request->input('telefono'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }

        // Insertamos una fila en Fabricante con create pasándole todos los datos recibidos.
        // En $request->all() tendremos todos los campos del formulario recibidos.
        $nuevoFabricante=Fabricante::create($request->all());

        // Más información sobre respuestas en http://jsonapi.org/format/
        // Devolvemos el código HTTP 201 Created – [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
        $response = Response::make(json_encode(['data'=>$nuevoFabricante]), 201)->header('Location', 'http://www.dominio.local/fabricantes/'.$nuevoFabricante->id)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // return "Se muestra Fabricante con id: $id";
        // Buscamos un fabricante por el id.
        $fabricante=Fabricante::find($id);

        // Si no existe ese fabricante devolvemos un error.
        if (!$fabricante)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
        }

        return response()->json(['status'=>'ok','data'=>$fabricante],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Comprobamos si el fabricante que nos están pasando existe o no.
        $fabricante=Fabricante::find($id);

        // Si no existe ese fabricante devolvemos un error.
        if (!$fabricante)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
        }

        // Listado de campos recibidos teóricamente.
        $nombre=$request->input('nombre');
        $direccion=$request->input('direccion');
        $telefono=$request->input('telefono');

        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        // El método de la petición se sabe a través de $request->method();
        if ($request->method() === 'PATCH')
        {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;

            // Actualización parcial de campos.
            if ($nombre)
            {
                $fabricante->nombre = $nombre;
                $bandera=true;
            }

            if ($direccion)
            {
                $fabricante->direccion = $direccion;
                $bandera=true;
            }


            if ($telefono)
            {
                $fabricante->telefono = $telefono;
                $bandera=true;
            }

            if ($bandera)
            {
                // Almacenamos en la base de datos el registro.
                $fabricante->save();
                return response()->json(['status'=>'ok','data'=>$fabricante], 200);
            }
            else
            {
                // Se devuelve un array errors con los errores encontrados y cabecera HTTP 304 Not Modified – [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo
                // Este código 304 no devuelve ningún body, así que si quisiéramos que se mostrara el mensaje usaríamos un código 200 en su lugar.
                return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de fabricante.'])],304);
            }
        }


        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$nombre || !$direccion || !$telefono)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
        }

        $fabricante->nombre = $nombre;
        $fabricante->direccion = $direccion;
        $fabricante->telefono = $telefono;

        // Almacenamos en la base de datos el registro.
        $fabricante->save();
        return response()->json(['status'=>'ok','data'=>$fabricante], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
