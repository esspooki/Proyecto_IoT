<!DOCTYPE html>

@if (\Request::is('rtl'))
<html dir="rtl" lang="ar">
@else
<html lang="es">
@endif

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/logo-ct.png">
  <title>Invernadero</title>

  <!-- Fuentes y estilos -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #b04a2f;
      --secondary: #41431b;
      --tertiary: #aeb784;
      --surface: #e3dbbb;
      --background: #f8f3e1;
      --text-main: #2f2f2f;
      --text-muted: #6b7280;
      --card-bg: #ffffff;
      --border-color: rgba(0, 0, 0, 0.08);
      --font-scale: 1;
    }

    html {
      font-size: calc(100% * var(--font-scale));
    }

    body {
      color: var(--text-main) !important;
      background-color: var(--background) !important;
      font-size: 1rem !important;
    }

    body.dark-mode {
      --background: #020617;
      --surface: #0b1320;
      --card-bg: #0f172a;
      --text-main: #e2e8f0;
      --text-muted: #94a3b8;
      --border-color: rgba(148, 163, 184, 0.18);
      background-color: #020617 !important;
    }

    body.dark-mode,
    body.dark-mode .g-sidenav-show,
    body.dark-mode .main-content,
    body.dark-mode .auth-content-wrap,
    body.dark-mode .container-fluid,
    body.dark-mode .sidenav,
    body.dark-mode .navbar,
    body.dark-mode .navbar-main,
    body.dark-mode .card,
    body.dark-mode .card-header,
    body.dark-mode .card-body,
    body.dark-mode .table,
    body.dark-mode .table-responsive,
    body.dark-mode .dropdown-menu,
    body.dark-mode .form-control,
    body.dark-mode .dataTables_wrapper .dataTables_scroll,
    body.dark-mode .panel-card,
    body.dark-mode .panel-table,
    body.dark-mode .control-card,
    body.dark-mode .control-header-card,
    body.dark-mode .bitacora-header-card,
    body.dark-mode .bitacora-table-card,
    body.dark-mode .bitacora-pagination-bar,
    body.dark-mode .alert,
    body.dark-mode .fixed-plugin .card,
    body.dark-mode .fixed-plugin-button,
    body.dark-mode .fixed-plugin .card-header,
    body.dark-mode .fixed-plugin .card-body {
      background-color: var(--card-bg) !important;
      color: var(--text-main) !important;
      border-color: var(--border-color) !important;
    }

    body.dark-mode .bg-gray-100,
    body.dark-mode .bg-white,
    body.dark-mode .bg-light {
      background-color: var(--card-bg) !important;
    }

    body.dark-mode .btn,
    body.dark-mode .btn-primary,
    body.dark-mode .btn-secondary,
    body.dark-mode .btn-dark,
    body.dark-mode .btn-outline-secondary,
    body.dark-mode .btn-outline-primary,
    body.dark-mode .btn-outline-dark,
    body.dark-mode .btn-outline-success,
    body.dark-mode .btn-outline-warning,
    body.dark-mode .btn-outline-info,
    body.dark-mode .btn-outline-light,
    body.dark-mode .btn-link,
    body.dark-mode .form-check-input,
    body.dark-mode .page-btn {
      background-color: var(--surface) !important;
      color: var(--text-main) !important;
      border-color: var(--border-color) !important;
    }

    body.dark-mode .text-dark,
    body.dark-mode .navbar-brand,
    body.dark-mode .navbar-nav .nav-link,
    body.dark-mode .card .card-title,
    body.dark-mode .card .card-text,
    body.dark-mode .form-check-label,
    body.dark-mode .dataTables_wrapper,
    body.dark-mode table,
    body.dark-mode .panel-title,
    body.dark-mode .panel-subtitle,
    body.dark-mode .panel-text,
    body.dark-mode .panel-muted {
      color: var(--text-main) !important;
    }

    body.dark-mode .text-muted,
    body.dark-mode .panel-muted {
      color: var(--text-muted) !important;
    }

    body.dark-mode .text-muted {
      color: var(--text-muted) !important;
    }

    body.dark-mode .form-control,
    body.dark-mode .btn-outline-secondary,
    body.dark-mode .btn-outline-primary,
    body.dark-mode .btn-outline-dark {
      background-color: var(--surface) !important;
      color: var(--text-main) !important;
      border-color: var(--border-color) !important;
    }

    .font-size-button.active {
      border-width: 2px !important;
      border-color: var(--primary) !important;
      color: var(--primary) !important;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100 {{ (\Request::is('rtl') ? 'rtl' : (Request::is('virtual-reality') ? 'virtual-reality' : '')) }}">

  @include('components.fixed-plugin')

  {{-- Contenido principal --}}
  @auth
    @yield('auth')
  @endauth

  @guest
    @yield('guest')
  @endguest

  {{-- Snackbar dinámico con Alpine.js --}}
  @if(session()->has('success'))
    <div 
      x-data="{ show: true }"
      x-init="setTimeout(() => show = false, 4000)"
      x-show="show"
      x-transition
      class="position-fixed bottom-0 end-0 m-3 bg-success text-white rounded shadow-lg py-2 px-4"
      style="z-index: 1055;">
      <p class="m-0">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
      </p>
    </div>
  @endif

  <!-- Archivos JS principales -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>

  <!-- Scripts personalizados globales -->
  <x-scripts />

  @stack('rtl')
  @stack('dashboard')
  @stack('scripts')

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center para efectos de dashboard -->
  <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const fontButtons = document.querySelectorAll('.font-size-button');
      const darkModeToggle = document.getElementById('darkModeToggle');
      const root = document.documentElement;

      function setFontSize(size) {
        root.style.setProperty('--font-scale', size);
        localStorage.setItem('fontSize', size);
        fontButtons.forEach((button) => {
          button.classList.toggle('active', button.dataset.size === size);
        });
      }

      function setDarkMode(enabled) {
        document.body.classList.toggle('dark-mode', enabled);
        localStorage.setItem('darkMode', enabled ? 'true' : 'false');
        if (darkModeToggle) {
          darkModeToggle.checked = enabled;
        }
      }

      const savedFontSize = localStorage.getItem('fontSize') || '1';
      const savedDarkMode = localStorage.getItem('darkMode') === 'true';

      setFontSize(savedFontSize);
      setDarkMode(savedDarkMode);

      fontButtons.forEach((button) => {
        button.addEventListener('click', function () {
          setFontSize(this.dataset.size);
        });
      });

      if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function () {
          setDarkMode(this.checked);
        });
      }
    });
  </script>

  <!-- Alpine.js para el snackbar -->
  <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
