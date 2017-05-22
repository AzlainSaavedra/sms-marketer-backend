<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $domains = [
            'http://sms-marketer-v2.dyndns-web.com:8082'
            ,'http://bpd.dyndns-web.com:8082'
            ,'http://localhost:3333'
            ,'http://localhost:4200'
            ,'http://localhost:63342'
            ,'http://0.0.0.0:3333'
            ,'http://smsmarketerv2.front.apache:8082'
        ];


        if(isset($request->server()['HTTP_ORIGIN'])){
            $origin = $request->server()['HTTP_ORIGIN'];
            if(in_array($origin, $domains)){
                if ($request->isMethod('options')) {
                    return $next($request)
			
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers','Access-Control-Allow-Origin, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Accept, Authorization, X-Requested-With');
                }else{
                    return $next($request)
			
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
                }
            }
        }

       	return $next($request)->header('Access-Control-Allow-Origin', '*');
 	//return $next($request);
    }
}
