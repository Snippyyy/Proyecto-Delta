<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $provincias = [
            "Álava/Araba",
            "Albacete",
            "Alicante",
            "Almería",
            "Asturias",
            "Ávila",
            "Badajoz",
            "Baleares",
            "Barcelona",
            "Burgos",
            "Cáceres",
            "Cádiz",
            "Cantabria",
            "Castellón",
            "Ceuta",
            "Ciudad Real",
            "Córdoba",
            "Cuenca",
            "Gerona/Girona",
            "Granada",
            "Guadalajara",
            "Guipúzcoa/Gipuzkoa",
            "Huelva",
            "Huesca",
            "Jaén",
            "La Coruña/A Coruña",
            "La Rioja",
            "Las Palmas",
            "León",
            "Lérida/Lleida",
            "Lugo",
            "Madrid",
            "Málaga",
            "Melilla",
            "Murcia",
            "Navarra",
            "Orense/Ourense",
            "Palencia",
            "Pontevedra",
            "Salamanca",
            "Segovia",
            "Sevilla",
            "Soria",
            "Tarragona",
            "Tenerife",
            "Teruel",
            "Toledo",
            "Valencia",
            "Valladolid",
            "Vizcaya/Bizkaia",
            "Zamora",
            "Zaragoza"
        ];
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'province' => ['required', 'string', Rule::in($provincias)],
            'address' => ['required', 'string'],
            'postal_code' => ['required', 'numeric', 'digits_between:5,8'],
            'phone_number' => ['required', 'numeric', 'digits_between:7,11'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'province' => $request->province,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
