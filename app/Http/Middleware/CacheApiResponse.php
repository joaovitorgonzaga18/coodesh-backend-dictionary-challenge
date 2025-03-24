<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        $cacheKey = 'api:' . md5($request->fullUrl());
        $startTime = microtime(true);

        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            $cacheStatus = 'HIT';
        } else {
            $response = $next($request);
            $cachedData = $response->getContent();
            Cache::put($cacheKey, $cachedData, now()->addMinutes(10));
            $cacheStatus = 'MISS';
        }

        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        return new JsonResponse(json_decode($cachedData, true), 200, [
            'x-cache' => $cacheStatus,
            'x-response-time' => $responseTime . 'ms'
        ]);
    }
}
