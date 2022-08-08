<?php

namespace App\Http\Exception;

use JetBrains\PhpStorm\Pure;

class NoAccountWithThisCardException extends CustomException
{
    #[Pure]
    public function __construct() {
        parent::__construct(
            "No Account With This Card",
            422
        );
    }

}
