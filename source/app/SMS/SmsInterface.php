<?php

namespace App\SMS;

interface SmsInterface
{
    function send(string $receiver, string $message);

}
