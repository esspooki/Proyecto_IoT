@extends('layouts.user_type.auth')
@section('content')

<div class="row">
  <div class="col-12 mb-4">
    <div class="card border-0 control-header-card">
      <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h5 class="mb-1 section-title">Control de Dispositivos</h5>
          <p class="mb-0 section-subtitle">Administra bomba, ventiladores y luces en tiempo real.</p>
        </div>
        <span class="badge control-badge px-3 py-2">Modo Manual</span>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 mb-2">
    <div id="alert-box" class="alert d-none" role="alert"></div>
  </div>
</div>

<div class="row">
  {{-- Bomba de Agua --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card control-card">
      <div class="card-body text-center">
        <i class="fas fa-tint control-icon mb-3" id="icon-riego"></i>
        <h6 class="mb-2">Bomba de Agua</h6>
        <button
          class="btn btn-sm control-btn {{ $states['riego'] ? 'is-on' : '' }}"
          id="btn-riego"
          data-device="riego"
          data-sensor-id="esp32-01"
          data-state="{{ $states['riego'] }}"
          onclick="toggleDevice(this)"
        >
          {{ $states['riego'] ? 'Apagar' : 'Encender' }}
        </button>
      </div>
    </div>
  </div>

  {{-- Ventiladores --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card control-card">
      <div class="card-body text-center">
        <i class="fas fa-fan control-icon mb-3 {{ $states['ventilacion'] ? 'spinning' : '' }}" id="icon-ventilacion"></i>
        <h6 class="mb-2">Ventiladores</h6>
        <button
          class="btn btn-sm control-btn {{ $states['ventilacion'] ? 'is-on' : '' }}"
          id="btn-ventilacion"
          data-device="ventilacion"
          data-sensor-id="esp32-01"
          data-state="{{ $states['ventilacion'] }}"
          onclick="toggleDevice(this)"
        >
          {{ $states['ventilacion'] ? 'Apagar' : 'Encender' }}
        </button>
      </div>
    </div>
  </div>

  {{-- Luces --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card control-card">
      <div class="card-body text-center">
        <i
          class="fas fa-lightbulb control-icon mb-3"
          id="icon-iluminacion"
          style="{{ $states['iluminacion'] ? 'color: #f9a825;' : '' }}"
        ></i>
        <h6 class="mb-2">Luces</h6>
        <button
          class="btn btn-sm control-btn {{ $states['iluminacion'] ? 'is-on' : '' }}"
          id="btn-iluminacion"
          data-device="iluminacion"
          data-sensor-id="esp32-01"
          data-state="{{ $states['iluminacion'] }}"
          onclick="toggleDevice(this)"
        >
          {{ $states['iluminacion'] ? 'Apagar' : 'Encender' }}
        </button>
      </div>
    </div>
  </div>

  {{-- Nebulizador — sin backend aún --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card control-card" style="opacity: 0.5;">
      <div class="card-body text-center">
        <i class="fas fa-cloud control-icon mb-3"></i>
        <h6 class="mb-2">Nebulizador</h6>
        <button class="btn btn-sm control-btn" disabled title="No disponible aún">
          Encender
        </button>
      </div>
    </div>
  </div>
</div>

<style>
  .control-header-card,
  .control-card {
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 10px 22px rgba(65, 67, 27, 0.08);
  }
  .section-title {
    color: var(--secondary);
    font-weight: 700;
  }
  .section-subtitle {
    color: var(--text-muted);
  }
  .control-badge {
    background: var(--tertiary);
    color: var(--secondary);
    font-weight: 700;
  }
  .control-icon {
    font-size: 1.45rem;
    color: var(--primary);
  }
  .control-btn {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.45rem 0.95rem;
    font-weight: 600;
  }
  .control-btn:hover     { background: #963d27; color: #fff; }
  .control-btn:disabled  { opacity: 0.6; cursor: not-allowed; }
  .control-btn.is-on     { background: #2e7d32; }
  .control-btn.is-on:hover { background: #1b5e20; }
  .fa-fan.spinning       { animation: spin 1.2s linear infinite; }
  @keyframes spin        { to { transform: rotate(360deg); } }
</style>

<script>
  const CSRF_TOKEN = '{{ csrf_token() }}';

  async function toggleDevice(btn) {
    const device   = btn.dataset.device;
    const sensorId = btn.dataset.sensorId;
    const newState = btn.dataset.state === '0' ? 1 : 0;

    btn.disabled = true;

    try {
      const response = await fetch('{{ route("commands.store") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': CSRF_TOKEN,
          'Accept': 'application/json',
        },
        body: JSON.stringify({
          sensor_id:     sensorId,
          tipo_comando:  device,
          valor_comando: newState,
        }),
      });

      if (!response.ok) {
        const err = await response.json();
        showAlert('danger', `Error: ${err.message ?? 'No se pudo enviar el comando.'}`);
        return;
      }

      btn.dataset.state = String(newState);
      btn.textContent   = newState ? 'Apagar' : 'Encender';
      btn.classList.toggle('is-on', newState === 1);

      if (device === 'ventilacion') {
        document.getElementById('icon-ventilacion').classList.toggle('spinning', newState === 1);
      }
      if (device === 'iluminacion') {
        const icon = document.getElementById('icon-iluminacion');
        icon.style.color = newState ? '#f9a825' : 'var(--primary)';
      }

      showAlert('success', `${labelFor(device)} ${newState ? 'encendido/a' : 'apagado/a'} correctamente.`);

    } catch (e) {
      console.error(e);
      showAlert('danger', 'Error de red. Verifica tu conexión.');
    } finally {
      btn.disabled = false;
    }
  }

  function labelFor(device) {
    return { riego: 'Bomba de Agua', ventilacion: 'Ventiladores', iluminacion: 'Luces' }[device] ?? device;
  }

  function showAlert(type, message) {
    const box = document.getElementById('alert-box');
    box.className = `alert alert-${type}`;
    box.textContent = message;
    box.classList.remove('d-none');
    setTimeout(() => box.classList.add('d-none'), 3500);
  }
</script>
@endsection