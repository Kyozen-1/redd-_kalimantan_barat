<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $imgSources = [
            "'self'",
            "data:",
            "blob:",
            "https:",
            env('AWS_ENDPOINT')
        ];

        $mediaSources = [
            "'self'",
            "data:",
            "blob:",
            "https:",
            env('AWS_ENDPOINT')
        ];

        $csp = implode('; ', [
            "default-src 'self'",

            "script-src 'self' 'unsafe-inline' data: blob: https://cdn.ckeditor.com https://unpkg.com",

            "style-src 'self' 'unsafe-inline' https://cdn.ckeditor.com https://fonts.googleapis.com https://unpkg.com",

            "font-src 'self' data: https://fonts.gstatic.com https://unpkg.com",

            "img-src ".implode(' ', $imgSources),
            "media-src ".implode(' ', $mediaSources),

            "connect-src 'self' https://cdn.ckeditor.com https://unpkg.com",
        ]);
        $response->headers->set(
            'Content-Security-Policy',
            $csp
        );

        return $response;
    }
}
