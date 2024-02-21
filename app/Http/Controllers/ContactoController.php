<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMaillabe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function pintarFormulario()
    {
        return view('contacto.index');
    }

    public function procesarFormulario(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'min:5'],
            'contenido' => ['required', 'string', 'min:10'],
            'email' => ['required', 'email']
        ]);

        //Si no está registrado manda el email del formulario y si no manda su correo
        $email = auth()->user() != null ? auth()->user()->email : $request->email;

        try{
            Mail::to("micorreo@correo.es")->send(new ContactoMaillabe($request->nombre, $request->contenido, $email));
            return redirect()->route('inicio')->with('mensaje', "Correo enviado correctamente.");
        } catch (\Exception $ex) {
            return redirect()->route('inicio')->with('mensaje', "No se pudo enviar el correo");
        }
    }
}
