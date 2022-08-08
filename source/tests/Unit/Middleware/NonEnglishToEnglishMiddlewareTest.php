<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\NonEnglishToEnglishMiddleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;

class NonEnglishToEnglishMiddlewareTest extends TestCase
{
    public function test_persian_numbers_to_english_numbers()
    {
        $request = new Request;

        $request->merge([
            'attr' => '۱۲۳۴'
        ]);

        $middleware = new NonEnglishToEnglishMiddleware();

        $middleware->handle($request, function ($req) {
            $this->assertEquals('1234', $req->attr);
            return new Response();
        });
    }

    public function test_arabic_numbers_to_english_numbers()
    {
        $request = new Request;

        $request->merge([
            'attr' => '٠١٢٣٤٥'
        ]);

        $middleware = new NonEnglishToEnglishMiddleware();

        $middleware->handle($request, function ($req) {
            $this->assertEquals('012345', $req->attr);
            return new Response();
        });
    }

}
