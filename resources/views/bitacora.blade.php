@extends('layouts.user_type.auth')

@section('content')

<div class="row">
  <div class="col-12 mb-4">
    <div class="card border-0 bitacora-header-card">
      <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <h5 class="mb-1 section-title">Bitacora / Logs</h5>
          <p class="mb-0 section-subtitle">Historial de acciones, alertas y eventos del invernadero.</p>
        </div>
        <span class="badge bitacora-badge px-3 py-2">Actualizado hoy</span>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
    <div class="card bitacora-table-card">
      <div class="card-body px-0 pb-0">
        <div class="table-responsive">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-xxs table-head">Fecha</th>
                <th class="text-uppercase text-xxs table-head">Usuario</th>
                <th class="text-uppercase text-xxs table-head">Dispositivo</th>
                <th class="text-uppercase text-xxs table-head">Accion</th>
                <th class="text-uppercase text-xxs table-head">Estado</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($logs as $log)
                <tr>
                  <td>{{ formatLogDate($log->created_at) }}</td>
                  <td>{{ $log->tipo }}</td>
                  <td>{{ resolveDispositivo($log->icono) }}</td>
                  <td>{{ $log->mensaje }}</td>
                  <td>{!! resolveEstadoBadge($log->nivel) !!}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">No hay registros disponibles.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if ($logs->hasPages())
          <div class="d-flex justify-content-between align-items-center px-4 py-3 bitacora-pagination-bar">
            <span class="pagination-info">
              Mostrando {{ $logs->firstItem() }}–{{ $logs->lastItem() }} de {{ $logs->total() }} registros
            </span>
            <div class="bitacora-pagination">
              @if ($logs->onFirstPage())
                <button class="page-btn" disabled>&lsaquo;</button>
              @else
                <a href="{{ $logs->previousPageUrl() }}" class="page-btn">&lsaquo;</a>
              @endif

              @foreach ($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                @if ($page == $logs->currentPage())
                  <button class="page-btn page-btn-active" disabled>{{ $page }}</button>
                @else
                  <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
              @endforeach

              @if ($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="page-btn">&rsaquo;</a>
              @else
                <button class="page-btn" disabled>&rsaquo;</button>
              @endif
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>
</div>

<style>
  .bitacora-header-card,
  .bitacora-table-card {
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
  .bitacora-badge {
    background: var(--tertiary);
    color: var(--secondary);
    font-weight: 700;
  }
  .table-head {
    color: var(--secondary) !important;
    font-weight: 700;
  }
  .status-ok {
    display: inline-block;
    background: rgba(174, 183, 132, 0.25);
    color: var(--secondary);
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
  }
  .status-alert {
    display: inline-block;
    background: rgba(176, 74, 47, 0.2);
    color: var(--primary);
    padding: 0.2rem 0.55rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
  }
  .bitacora-pagination-bar {
    border-top: 1px solid rgba(65, 67, 27, 0.08);
  }
  .pagination-info {
    font-size: 0.78rem;
    color: var(--text-muted);
  }
  .bitacora-pagination {
    display: flex;
    gap: 4px;
    align-items: center;
  }
  .page-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border-radius: 8px;
    border: 1px solid rgba(65, 67, 27, 0.15);
    background: #fff;
    color: var(--secondary);
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s;
  }
  .page-btn:hover:not([disabled]) {
    background: var(--tertiary);
    border-color: var(--secondary);
    color: var(--secondary);
  }
  .page-btn[disabled] {
    opacity: 0.4;
    cursor: default;
  }
  .page-btn-active {
    background: var(--secondary) !important;
    color: #fff !important;
    border-color: var(--secondary) !important;
  }
</style>

<style>
  body.dark-mode .status-ok {
    color: #ffac6d !important;
  }
  body.dark-mode .status-alert {
    color: #ffac6d !important;
  }
</style>

@php
  /**
   * Formats a UTC timestamp into a human-readable local date string.
   * Converts from UTC to America/Mexico_City (UTC-6 standard / UTC-5 DST).
   */
  function formatLogDate($timestamp): string {
    return \Carbon\Carbon::parse($timestamp)
      ->setTimezone('America/Mexico_City')
      ->format('d/m/Y H:i');
  }

  /**
   * Maps a FontAwesome icon class to a human-readable device name.
   */
  function resolveDispositivo(?string $icono): string {
    return match($icono) {
      'fa-fan'       => 'Ventilador',
      'fa-tint'      => 'Bomba',
      'fa-lightbulb' => 'Luces',
      default        => 'Sistema',
    };
  }

  /**
   * Renders the Estado badge HTML based on the nivel field.
   * 'info' maps to 'Correcto' (green pill), anything else keeps its label (alert pill).
   */
  function resolveEstadoBadge(?string $nivel): \Illuminate\Support\HtmlString {
    $isInfo = strtolower(trim($nivel ?? '')) === 'info';
    $class  = $isInfo ? 'status-ok'  : 'status-alert';
    $label  = $isInfo ? 'Correcto'   : e($nivel);
    return new \Illuminate\Support\HtmlString("<span class=\"{$class}\">{$label}</span>");
  }
@endphp
@endsection
