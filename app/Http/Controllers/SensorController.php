<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SensorReading;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    //Función para recibir los datos del esp32, validarlos y guardarlos en la base de datos
    //El esp32 enviará datos a esta ruta, y se guardarán en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sensor_id' => 'required|string',
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric',
            'luz' => 'required|numeric|min:0',
            'estado_riego' => 'required|boolean',
            'estado_luz' => 'required|boolean',
            'estado_ventilacion' => 'required|boolean',
        ]);

        $reading = SensorReading::create($validated);

        try {
            $this->checkAlerts($validated);
        } catch (\Exception $e) {
            \Log::error('checkAlerts failed: ' . $e->getMessage());
        // don't let alert logic crash the whole endpoint
        }

        return response()->json($reading, 201);
    }

    private function checkAlerts($data)
    {
        //Función para revisar los datos y crear alertas si es necesario
        // Aquí puedes definir tus umbrales y lógica de alerta
        $thresholds = [
            'temperatura' => ['min' => 10, 'max' => 35],
            'humedad' => ['min' => 30, 'max' => 70],
            'luz' => ['min' => 100, 'max' => 1000],
        ];

        if ($data['temperatura']>$thresholds['temperatura']['max']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'],
                'tipo' => 'alerta',
                'icono' => 'fa-thermometer-full',
                'mensaje' => 'Temperatura alta: ' . $data['temperatura'] . '°C',
                'nivel' => 'advertencia',
            ]);
        } elseif ($data['temperatura']<$thresholds['temperatura']['min']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'],
                'tipo' => 'alerta',
                'icono' => 'fa-thermometer-empty',
                'mensaje' => 'Temperatura baja: ' . $data['temperatura'] . '°C',
                'nivel' => 'advertencia',
            ]);
        }
        if ($data['humedad']>$thresholds['humedad']['max']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'],
                'tipo' => 'alerta',
                'icono' => 'fa-tint',
                'mensaje' => 'Humedad alta: ' . $data['humedad'] . '%',
                'nivel' => 'advertencia',
            ]);
        } elseif ($data['humedad']<$thresholds['humedad']['min']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'],
                'tipo' => 'alerta',
                'icono' => 'fa-tint-slash',
                'mensaje' => 'Humedad baja: ' . $data['humedad'] . '%',
                'nivel' => 'advertencia',
            ]);
        }
        if ($data['luz']>$thresholds['luz']['max']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'],
                'tipo' => 'alerta',
                'icono' => 'fa-sun',
                'mensaje' => 'Luz alta: ' . $data['luz'] . ' lux',
                'nivel' => 'advertencia',
            ]);
        } elseif ($data['luz']<$thresholds['luz']['min']) {
            \App\Models\Log::create([
                'sensor_id' => $data['sensor_id'], 
                'tipo' => 'alerta',
                'icono' => 'fa-cloud',
                'mensaje' => 'Luz baja: ' . $data['luz'] . ' lux',
                'nivel' => 'advertencia',
            ]);
        }

    }

    public function index()
{
    //Funcion para obtener los datos de los últimos 30 días de la base de datos para la vista de gráficos
    $readings = SensorReading::where('created_at', '>=', now()->subDays(30))
                ->orderBy('created_at', 'asc')
                ->get();
    return response()->json($readings);
}
    //Se obtiene el dato más reciente de la base de datos para la vista en vivo
    public function latest()
    {
        $reading = SensorReading::latest()->first();

        if (!$reading) {
            return response()->json(['message' => 'No hay datos leídos'], 404);
        }

        return response()->json($reading);
    }

    public function today()
    {
        //Funcion para obtener los datos del día actual de la base de datos para la vista de gráficos diarios
        $readings = SensorReading::whereDate('created_at', today())
                    ->orderBy('created_at', 'asc')
                    ->get();
        return response()->json($readings);
    }

}
