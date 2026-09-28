<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session 'locale' ada dan valid (id atau en)
        if (Session::has('locale') && in_array(Session::get('locale'), ['id', 'en'])) {
            App::setLocale(Session::get('locale'));
        } else {
            // Fallback default jika belum ada session
            App::setLocale(config('app.locale', 'id'));
        }

        return $next($request);
    }
}