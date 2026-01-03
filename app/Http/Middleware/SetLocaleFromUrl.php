<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleFromUrl
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if (!in_array($locale, ['vi', 'en'])) {
            $locale = 'vi';
        }

        App::setLocale($locale);
        return $next($request);
    }
}
