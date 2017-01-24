<?php

namespace App\Http\Controllers;
use Mailgun\Mailgun;
use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    //



    public function index(){
        $mg = new Mailgun(env('pubkey-f6eca11d280751230aaad6273abf7d10'));
        $domain = env('MAILGUN_DOMAIN');
        $validateAddress = 'servicomputacion2@gmail.com';


        # Issue the call to the client.
        $result = $mg->get("address/validate", array('address' => $validateAddress));
        # is_valid is 0 or 1
        $isValid = $result->http_response_body->is_valid;
        echo($isValid);

        $mg->sendMessage($domain, array('from'=>'test@test.com',
            'to'      => $validateAddress,
            'subject' => "test mailgun",
            'text'    => "texto",
            'html'    => "<div>texto</div>"));
    }
}
