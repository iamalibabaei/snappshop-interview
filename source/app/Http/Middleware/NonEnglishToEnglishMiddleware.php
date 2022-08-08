<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NonEnglishToEnglishMiddleware
{

    /**
     * @var array
     */
    protected array $except = [];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse|Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response|RedirectResponse
    {
        $except = array_merge($this->except, array_slice(func_get_args(), 2));
        $request->merge($this->process($request->except($except)));
        return $next($request);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function process(array $data): array
    {
        array_walk_recursive(
            $data,
            function (&$value) {
                $value = $this->processValue($value);
            }
        );

        return $data;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function processValue(?string $value): mixed
    {
        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $value = str_replace($arabicDigits, $englishDigits, $value);
        return str_replace($persianDigits, $englishDigits, $value);
    }
}
