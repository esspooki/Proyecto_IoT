<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Services\Esp32CifradoService;

class CommandController extends Controller
{
    public function __construct(private Esp32CifradoService $cipher) {}
    //La web manda un comando a este controlador, el controlador lo guarda en la base de datos y luego el microcontrolador lo consulta para ejecutarlo
public function store(Request $request)
{
    //Funcion para validar los datos del comando, guardarlo en la base de datos y registrar un log de la acción
    $validatedData = $request->validate([
        'sensor_id'     => 'required|string',
        'tipo_comando'  => 'required|string|in:riego,ventilacion,iluminacion',
        'valor_comando' => 'required|boolean',
    ]);

    $command = Command::create([
        'sensor_id'      => $validatedData['sensor_id'],
        'tipo_comando'   => $validatedData['tipo_comando'],
        'valor_comando'  => $validatedData['valor_comando'],
        'estado_comando' => 'pendiente',   // Para pruebas, en producción esto se establecerá a 'pendiente'
        //'fecha_ejecucion'=> now(), para pruebas se quitara esto de comentario
    ]);

    $icons = [
        'riego'       => 'fa-tint',
        'ventilacion' => 'fa-fan',
        'iluminacion' => 'fa-lightbulb',
    ];
    $labels = [
        'riego'       => 'Riego',
        'ventilacion' => 'Ventilación',
        'iluminacion' => 'Iluminación',
    ];
    $mensajes = [
        'riego' => [
            1 => 'Riego manual activado',
            0 => 'Riego manual desactivado',
        ],
        'ventilacion' => [
            1 => 'Ventilación activada manualmente',
            0 => 'Ventilación desactivada manualmente',
        ],
        'iluminacion' => [
            1 => 'Iluminación activada manualmente',
            0 => 'Iluminación desactivada manualmente',
        ],
    ];

    Log::create([
        'sensor_id' => $validatedData['sensor_id'],
        'tipo'    => 'Administrador',
        'icono'   => $icons[$validatedData['tipo_comando']],
        'mensaje'   => $mensajes[$validatedData['tipo_comando']][(int) $validatedData['valor_comando']],
        'nivel'   => 'info',
    ]);

    return response()->json([
        'message' => 'Comando creado exitosamente',
        'command' => $command,
    ], 201);
}

    //El microcontrolador consulta este controlador para obtener los comandos pendientes de ejecución
    public function pending(Request $request)
    {
        //Funcion para que el microcontrolador consulte los comandos pendientes de ejecución, cifrar la respuesta y devolverla al microcontrolador
        $sensorId = $request->query('sensor_id');
        
        $command = Command::where('sensor_id', $sensorId)
            ->where('estado_comando', 'pendiente')
            ->orderBy('created_at')  //Ordenar por fecha de creación para obtener el comando más antiguo
            ->first();               //Obtener solo el primer comando pendiente (el más antiguo)

        if (!$command) {
            return response()->json(null, 204); // 204 = no content
    }

    $encrypted = $this->cipher->encrypt([
        'id' => $command->id,
        'tipo_comando' => $command->tipo_comando,
        'valor_comando' => $command->valor_comando,
    ]);

    return response()->json($encrypted, 200);
}
    //El esp32 llama esto para confirmanr que el comando se ha ejecutado
    //public fucntion acknowledge($id)
    public function acknowledge(Request $request, $id)
    {
        //Funcion para que el microcontrolador confirme que el comando se ha ejecutado, actualizar el estado del comando a 'ejecutado' y registrar la fecha de ejecución
        $command = Command::find($id);

        if (!$command) {
            return response()->json(['message' => 'Comando no encontrado'], 404);
        }

        $command->update([
            'estado_comando' => 'ejecutado',
            'fecha_ejecucion' => now(),
        ]);

        return response()->json([
            'message' => 'Comando confirmado como ejecutado',
        ]);
    }

    //La web llama esto para ver el historial de comandos
    public function history(Request $request)
    {
        $commands = Command::latest()->take(10)->get();
        return response()->json($commands);
    }

    public function currentStates()
    {
        //Funcion para obtener el estado actual de cada dispositivo (riego, ventilacion, iluminacion) consultando el último comando ejecutado para cada uno
        $devices = ['riego', 'ventilacion', 'iluminacion'];
        $states = [];

        foreach ($devices as $device)
            {
                $last = Command::where('sensor_id', 'esp32-01')
                    ->where('tipo_comando', $device)
                    ->orderby('created_at', 'desc')
                    ->first();

                    $states[$device] = $last ? (int) $last->valor_comando : 0;
            }
            return $states;
    }

    public function index()
    {
        //Funcion para mostrar el estado actual de cada dispositivo en la vista de control de dispositivos
        $states = $this->currentStates();
        return view('control-dispositivos', compact('states'));
    }

    public function schema()
    {
        //Funcion para mostrar la documentación de la API del controlador de comandos
        return response()->json([
            'endpoint' => '/api/commands',
            'method' => 'POST',
            'request' => [
                'sensor_id' => 'integer (required)',
                'tipo_comando' => 'string (riego, ventilacion, iluminacion)',
                'valor_comando' => 'boolean (true=1/false=0)',
            ],
            'response' => [
                'message' => 'string',
                'command' => [
                    'id' => 'integer',
                    'sensor_id' => 'integer',
                    'tipo_comando' => 'string',
                    'valor_comando' => 'boolean',
                    'estado_comando' => 'string',
                    'fecha_ejecucion' => 'datetime',
                ]
            ]
        ]);
    }
}
