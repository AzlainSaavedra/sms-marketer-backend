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
        $domains = ['https://yeomandist.herokuappppppppppppppppppp.com'];

        if(isset($request->server()['HTTP_ORIGIN'])){
            $origin = $request->server()['HTTP_ORIGIN'];
            if(in_array($origin, $domains)){
                if ($request->isMethod('options')) {
                    return $next($request)->header('Access-Control-Allow-Origin' , '*')
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers', 'Access-Control-Allow-Origin, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Accept, Authorization, X-Requested-With');
                }else{
                    return $next($request)->header('Access-Control-Allow-Origin' , '*')
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
                }
            }
        }

        return $next($request);
    }
}
