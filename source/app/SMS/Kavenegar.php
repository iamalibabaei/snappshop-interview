<?php

namespace App\SMS;


use Kavenegar\KavenegarApi;

class Kavenegar implements SmsInterface
{

    private KavenegarApi $api;

    public function __construct()
    {
        $this->api = new KavenegarApi(env('KAVENEGAR_API_KEY'));
    }

    function send(string $receiver, string $message)
    {
        $this->api->Send(env("KAVENEGAR_SENDER",), $receiver, $message);
        //sleep for 3 seconds
        sleep(10);
    }
}
