<?php

namespace App\SMS;

use Ghasedak\GhasedakApi;

class Ghasedak implements SmsInterface
{

    private GhasedakApi $api;

    public function __construct()
    {
        $this->api = new GhasedakApi(env('GHASEDAK_API_KEY'));
    }

    function send(string $receiver, string $message)
    {
        $this->api->SendSimple($receiver, $message, env('GHASEDAK_SENDER', '10008642'));
    }
}
