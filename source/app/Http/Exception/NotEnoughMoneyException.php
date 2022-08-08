<?php

namespace App\Http\Exception;

use JetBrains\PhpStorm\Pure;

class NotEnoughMoneyException extends CustomException
{
    #[Pure]
    public function __construct() {
        parent::__construct(
            "Not Enough Money",
            422
        );
    }

}
