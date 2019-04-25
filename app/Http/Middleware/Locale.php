<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param @import(Request) $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$lang = Language::findByCode($request->lang)) {
            return jsonPrint('error', 'no.lang');
        }
        app('translator')->setLocale($lang->code);

        return $next($request);
    }
}
