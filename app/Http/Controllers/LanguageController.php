<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function __invoke(Request $request)
    {

        $request->validate([
            'language' => 'required|in:es,en', // Asegurar que el idioma es válido
        ]);

        Session::put('locale', $request->language);
        App::setLocale($request->language);

        return back()->with('status', __('Idioma cambiado correctamente'));
    }
}
