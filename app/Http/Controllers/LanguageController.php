<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(string $locale, Request $request)
    {
        if (!in_array($locale, ['id', 'en'])) {
            abort(404);
        }

        session()->put('locale', $locale);

        return redirect()->back();
    }
}