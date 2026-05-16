<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        //Funcion para mostrar los últimos 12 logs en formato JSON para la vista de dashboard
        return response()->json(Log::latest()->take(12)->get());
    }

    public function bitacora()
    {
        //Funcion para mostrar los logs en la vista de bitacora, paginados de 40 en 40
        $logs = Log::latest()->paginate(40);
        return view('bitacora', compact('logs'));
    }

    public function dashboard()
    {
        //Funcion para mostrar el estado actual de cada dispositivo en la vista de dashboard, consultando los últimos logs relacionados con cada dispositivo
        $deviceMessages = [
            'Bomba de agua' => ['Riego manual activado', 'Riego manual desactivado'],
            'Ventiladores'  => ['Ventilación activada manualmente', 'Ventilación desactivada manualmente'],
            'Luces'         => ['Iluminación activada manualmente', 'Iluminación desactivada manualmente'],
        ];

        $devices = [];
        foreach ($deviceMessages as $name => $messages) {
            $devices[$name] = Log::whereIn('mensaje', $messages)
                                  ->latest()
                                  ->first();
        }

        return view('dashboard', compact('devices'));
    }
}