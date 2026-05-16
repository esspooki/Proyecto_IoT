@extends('layouts.user_type.auth')

@section('content')
<div class="row">
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card panel-card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="metric-label mb-1">Temperatura</p>
                        <h4 class="metric-value mb-0" id="temperatura">--</h4>
                    </div>
                    <div class="metric-icon">
                        <i class="fas fa-temperature-high"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card panel-card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="metric-label mb-1">Humedad</p>
                        <h4 class="metric-value mb-0" id="humedad">--</h4>
                    </div>
                    <div class="metric-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card panel-card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="metric-label mb-1">Luz</p>
                        <h4 class="metric-value mb-0" id="luz">--</h4>
                    </div>
                    <div class="metric-icon">
                        <i class="fas fa-sun"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
  <div class="col-lg-8 mb-4">
    <div class="card panel-card h-100">
      <div class="card-header bg-transparent border-0 pb-0">
        <h6 class="panel-title mb-1">Comportamiento del mes</h6>
        <p class="panel-subtitle mb-0">Lecturas estimadas de temperatura y humedad</p>
      </div>
      <div class="card-body p-3">
        <canvas id="greenhouseMetrics" height="320"></canvas>
      </div>
    </div>
  </div>
<div class="col-lg-4 mb-4">
    <div class="card panel-card h-100">
        <div class="card-header bg-transparent border-0 pb-0">
            <h6 class="panel-title mb-1">Eventos Recientes</h6>
            <p class="panel-subtitle mb-0">Ultimas acciones del sistema</p>
        </div>
        <div class="card-body">
            <div class="timeline timeline-one-side" id="timeline">
                <p class="text-xs panel-muted text-center">Cargando eventos...</p>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-8 mb-4">
    <div class="card panel-card h-100">
        <div class="card-header bg-transparent border-0 pb-0">
            <h6 class="panel-title mb-1">Comportamiento de Hoy</h6>
            <p class="panel-subtitle mb-0">Lecturas de temperatura y humedad por bloque de 2 horas</p>
        </div>
        <div class="card-body p-3">
            <canvas id="todayMetrics" height="150"></canvas>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card panel-card">
      <div class="card-header bg-transparent border-0 pb-0">
        <h6 class="panel-title mb-1">Resumen Operativo</h6>
        <p class="panel-subtitle mb-0">Estado rapido de los modulos del invernadero</p>
      </div>
      <div class="card-body pt-3">
        <div class="table-responsive">
          <table class="table align-items-center mb-0 panel-table">
            <thead>
              <tr>
                <th>Modulo</th>
                <th>Estado</th>
                <th>Ultima accion</th>
                <th>Responsable</th>
              </tr>
            </thead>
            <tbody>
              @php
                $deviceConfig = [
                    'Bomba de agua' => [
                        'icon' => 'fa-tint',
                        'active_msg'   => 'Riego manual activado',
                        'inactive_msg' => 'Riego manual desactivado',
                    ],
                    'Ventiladores' => [
                        'icon' => 'fa-fan',
                        'active_msg'   => 'Ventilación activada manualmente',
                        'inactive_msg' => 'Ventilación desactivada manualmente',
                    ],
                    'Luces' => [
                        'icon' => 'fa-lightbulb',
                        'active_msg'   => 'Iluminación activada manualmente',
                        'inactive_msg' => 'Iluminación desactivada manualmente',
                    ],
                ];
              @endphp

              @foreach ($deviceConfig as $name => $config)
                @php
                    $log    = $devices[$name] ?? null;
                    $active = $log && $log->mensaje === $config['active_msg'];
                    $pill   = $log ? ($active ? 'ok' : 'off') : 'warn';
                    $label  = $log ? ($active ? 'Activo' : 'Inactivo') : 'Sin datos';
                @endphp
                <tr>
                  <td>
                    {{ $name }}
                  </td>
                  <td>
                    <span class="status-pill {{ $pill }}">{{ $label }}</span>
                  </td>
                  <td>{{ $log->mensaje ?? '—' }}</td>
                  <td>Administrador</td>
                </tr>
              @endforeach

              {{-- Nebulizador (not yet implemented) --}}
              <tr>
                <td>Nebulizador</td>
                <td><span class="status-pill warn">En espera</span></td>
                <td>Pendiente por umbral</td>
                <td>Sistema</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .panel-card {
    border: 0;
    border-radius: 16px;
    box-shadow: 0 10px 24px rgba(65, 67, 27, 0.08);
  }

  .metric-label {
    color: var(--text-muted);
    font-size: 0.88rem;
    font-weight: 600;
  }

  .metric-value {
    color: var(--secondary);
    font-weight: 800;
  }

  .metric-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary);
    color: #fff;
    font-size: 1.1rem;
    box-shadow: 0 8px 18px rgba(176, 74, 47, 0.28);
  }

  .panel-title {
    color: var(--secondary);
    font-weight: 700;
  }

  .panel-subtitle {
    color: var(--text-muted);
    font-size: 0.86rem;
  }

  .timeline-icon {
    background: rgba(176, 74, 47, 0.15);
    color: var(--primary);
  }

  .panel-text {
    color: var(--secondary);
    font-weight: 700;
  }

  .panel-muted {
    color: var(--text-muted);
  }

  .panel-table thead th {
    text-transform: uppercase;
    font-size: 0.68rem;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    border-bottom: 1px solid rgba(65, 67, 27, 0.12);
  }

  .panel-table tbody td {
    color: var(--secondary);
    font-size: 0.9rem;
  }

  .status-pill {
    display: inline-block;
    border-radius: 999px;
    padding: 0.2rem 0.6rem;
    font-size: 0.72rem;
    font-weight: 700;
  }

  .status-pill.ok {
    background: rgba(174, 183, 132, 0.28);
    color: var(--secondary);
  }

  .status-pill.off {
    background: rgba(107, 114, 128, 0.18);
    color: var(--text-muted);
  }

  .status-pill.warn {
    background: rgba(176, 74, 47, 0.18);
    color: var(--primary);
  }
</style>
@endsection

@push('dashboard')

<script>
//Nuevo codigo para cargar datos reales del backend, agrupados en intervalos de 2 horas y promediados para suavizar la grafica
  const styles = getComputedStyle(document.documentElement);
  const primary = styles.getPropertyValue('--primary').trim() || '#b04a2f';
  const secondary = styles.getPropertyValue('--secondary').trim() || '#41431b';

async function loadChart() {
    try {
        const res = await fetch('/api/sensor-readings')
        const data = await res.json()
        if (!data || data.length === 0) return

        const groups = {}

        data.forEach(reading => {
            const date = new Date(reading.created_at)
            // ← group by day instead of 2-hour block
            const label = date.toLocaleDateString('es-MX', { 
                day: '2-digit', 
                month: 'short'  // e.g. "23 abr"
            })
            if (!groups[label]) {
                groups[label] = { temperatura: [], humedad: [], timestamp: date.getTime() }
            }
            groups[label].temperatura.push(reading.temperatura)
            groups[label].humedad.push(reading.humedad)
        })

        // Sort by actual date timestamp
        const labels = Object.keys(groups).sort((a, b) => groups[a].timestamp - groups[b].timestamp)

        const avg = arr => arr.reduce((a, b) => a + b, 0) / arr.length
        const temperaturaData = labels.map(l => parseFloat(avg(groups[l].temperatura).toFixed(1)))
        const humedadData     = labels.map(l => parseFloat(avg(groups[l].humedad).toFixed(1)))

        new Chart(document.getElementById('greenhouseMetrics'), {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        data: temperaturaData,
                        borderColor: primary,
                        backgroundColor: 'rgba(176, 74, 47, 0.18)',
                        fill: true,
                        tension: 0.35
                    },
                    {
                        label: 'Humedad (%)',
                        data: humedadData,
                        borderColor: secondary,
                        backgroundColor: 'rgba(65, 67, 27, 0.06)',
                        fill: true,
                        tension: 0.35
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { labels: { color: secondary } }
                },
                scales: {
                    x: {
                        ticks: { color: secondary },
                        grid: { color: 'rgba(65, 67, 27, 0.08)' }
                    },
                    y: {
                        ticks: { color: secondary },
                        grid: { color: 'rgba(65, 67, 27, 0.08)' }
                    }
                }
            }
        })
    } catch (e) {
        console.error('Error loading chart:', e)
    }
}

loadChart()
</script>

<script>
async function loadTodayChart() {
    try {
        const res = await fetch('/api/sensor-readings/today')
        const data = await res.json()
        if (!data || data.length === 0) return

        const groups = {}

        data.forEach(reading => {
            const date = new Date(reading.created_at)
            const hour = Math.floor(date.getHours() / 2) * 2
            const label = `${String(hour).padStart(2, '0')}:00 - ${String(hour + 2).padStart(2, '0')}:00`
            if (!groups[label]) {
                groups[label] = { temperatura: [], humedad: [], hour }
            }
            groups[label].temperatura.push(reading.temperatura)
            groups[label].humedad.push(reading.humedad)
        })

        const labels = Object.keys(groups).sort((a, b) => groups[a].hour - groups[b].hour)
        const avg = arr => arr.reduce((a, b) => a + b, 0) / arr.length
        const temperaturaData = labels.map(l => parseFloat(avg(groups[l].temperatura).toFixed(1)))
        const humedadData     = labels.map(l => parseFloat(avg(groups[l].humedad).toFixed(1)))

        new Chart(document.getElementById('todayMetrics'), {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Temperatura (°C)',
                        data: temperaturaData,
                        borderColor: primary,
                        backgroundColor: 'rgba(176, 74, 47, 0.18)',
                        fill: true,
                        tension: 0.35
                    },
                    {
                        label: 'Humedad (%)',
                        data: humedadData,
                        borderColor: secondary,
                        backgroundColor: 'rgba(65, 67, 27, 0.06)',
                        fill: true,
                        tension: 0.35
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { labels: { color: secondary } }
                },
                scales: {
                    x: {
                        ticks: { color: secondary },
                        grid: { color: 'rgba(65, 67, 27, 0.08)' }
                    },
                    y: {
                        ticks: { color: secondary },
                        grid: { color: 'rgba(65, 67, 27, 0.08)' }
                    }
                }
            }
        })
    } catch (e) {
        console.error('Error loading today chart:', e)
    }
}

loadTodayChart()
</script>

<script>
    async function fetchLatest() {
        try {
            const res = await fetch('/api/sensor-readings/latest')

            if (!res.ok) return

            const data = await res.json()

            document.getElementById('temperatura').textContent =
                data.temperatura !== null ? data.temperatura + ' °C' : '--'

            document.getElementById('humedad').textContent =
                data.humedad !== null ? data.humedad + ' %' : '--'

            document.getElementById('luz').textContent =
                data.luz !== null ? data.luz + ' lx' : '--'

            //document.getElementById('riego').textContent =
               // data.estado_riego ? 'Activo' : 'Inactivo'

            // Optional: color the riego value green/red
            //document.getElementById('riego').style.color =
                //data.estado_riego ? '#22c55e' : '#ef4444'

        } catch (e) {
            console.error('Error fetching sensor data:', e)
        }
    }

    // Load on page open
    fetchLatest()

    // Refresh every 5 seconds
    setInterval(fetchLatest, 5000)
</script>

<script>
  const coloresNivel = {
    /*info: 'text-info',
    advertencia: 'text-warning',
    peligro: 'text-danger'*/
    info: 'color: var(--primary)',
    advertencia: 'text-warning',
    peligro: 'text-danger',
  }

  async function fetchLogs() {
    try { const res = await fetch('/api/logs')
          const logs = await res.json()

          const timeline = document.getElementById('timeline')

          if (logs.length === 0) {
            timeline.innerHTML = '<p class="text-xs panel-muted text-center">No hay eventos recientes</p>'
            return
          }

          timeline.innerHTML = logs.map(log => {
            const time = new Date(log.created_at).toLocaleTimeString('es-MX', {
                hour:   '2-digit',
                minute: '2-digit',
            })
            const color = coloresNivel[log.nivel] || 'text-info'
            return `
                <div class="timeline-block mb-3">
                    <span class="timeline-step timeline-icon ${color}">
                        <i class="fas ${log.icono}"></i>
                    </span>
                    <div class="timeline-content">
                        <h6 class="text-sm mb-0 panel-text">${log.mensaje}</h6>
                        <p class="text-xs mb-0 panel-muted">${time}</p>
                    </div>
                </div>
            `
        }).join('')
    } catch (e) {
        console.error('Error fetching logs:', e)
    }
  }
  fetchLogs()
  setInterval(fetchLogs, 10000) // Refrescar cada 10 segundos
</script> 
@endpush
