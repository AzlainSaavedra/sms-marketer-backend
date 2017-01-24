<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MailController extends Controller
{
    //
    public function send(Request $request)
    {

        if (!$request->input('from') || !$request->input('to') || !$request->input('subject') || !$request->input('message'))
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return json_encode(["data"=>"Error", "message"=>"incompleteData"]);
        }

        \Mail::raw($GLOBALS['request']->input('message'), function($message)
        {
            $message->subject($GLOBALS['request']->input('subject'));
            $message->from(env('MAIL_DOMAIN_FROM') , 'Laravel App');
            $message->to($GLOBALS['request']->input('to'));
        });
        return json_encode(["data"=>"Success", "message"=>"email sended"]);
    }
}
