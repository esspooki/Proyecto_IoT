<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
  id="sidenav-main"
  style="
    background: #f8f3e1;
    border: 1px solid rgba(174, 183, 132, 0.25);
    box-shadow: 0 18px 40px rgba(65, 67, 27, 0.08);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  ">

  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer position-absolute end-0 top-0 d-none d-xl-none"
       id="iconSidenav"
       style="color: #41431b; opacity: 0.6;"></i>

    <a class="align-items-center d-flex m-0 navbar-brand text-wrap"
       href="{{ route('dashboard') }}">
      <img src="../assets/img/logo-ct.png"
           class="navbar-brand-img h-100"
           alt="Logo"
           style="max-width: 45px;">

      <span class="ms-3 font-weight-bold"
            style="color: #41431b; font-size: 1rem; letter-spacing: 0.2px;">
        Invernadero
      </span>
    </a>
  </div>

  <hr class="horizontal mt-0"
      style="border-top: 1px solid rgba(65, 67, 27, 0.08);">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <!-- Panel Principal -->
      <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
           href="{{ route('dashboard') }}"
           style="
             color: {{ Request::is('dashboard') ? '#fff' : '#41431b' }};
             font-weight: 600;
             border-radius: 14px;
             padding: 0.8rem 0.9rem;
             margin: 0.2rem 0.4rem;
             background: {{ Request::is('dashboard') ? '#b04a2f' : 'transparent' }};
             box-shadow: {{ Request::is('dashboard') ? '0 10px 24px rgba(176, 74, 47, 0.18)' : 'none' }};
           ">

          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
               style="
                 background: {{ Request::is('dashboard') ? 'rgba(255,255,255,0.18)' : '#e3dbbb' }};
                 color: {{ Request::is('dashboard') ? '#fff' : '#41431b' }};
                 box-shadow: none;
               ">
            <i class="fas fa-seedling fa-lg"></i>
          </div>

          <span class="nav-link-text ms-1">Panel Principal</span>
        </a>
      </li>

      <!-- Control de Dispositivos -->
      <li class="nav-item">
        <a class="nav-link {{ Request::is('control-dispositivos*') ? 'active' : '' }}"
           href="{{ route('control.dispositivos') }}"
           style="
             color: {{ Request::is('control-dispositivos*') ? '#fff' : '#41431b' }};
             font-weight: 600;
             border-radius: 14px;
             padding: 0.8rem 0.9rem;
             margin: 0.2rem 0.4rem;
             background: {{ Request::is('control-dispositivos*') ? '#b04a2f' : 'transparent' }};
             box-shadow: {{ Request::is('control-dispositivos*') ? '0 10px 24px rgba(176, 74, 47, 0.18)' : 'none' }};
           ">

          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
               style="
                 background: {{ Request::is('control-dispositivos*') ? 'rgba(255,255,255,0.18)' : '#e3dbbb' }};
                 color: {{ Request::is('control-dispositivos*') ? '#fff' : '#41431b' }};
                 box-shadow: none;
               ">
            <i class="fas fa-sliders-h fa-lg"></i>
          </div>

          <span class="nav-link-text ms-1">Control de Dispositivos</span>
        </a>
      </li>

      <!-- Bitácora y Logs -->
      <li class="nav-item">
        <a class="nav-link {{ Request::is('bitacora*') ? 'active' : '' }}"
           href="{{ route('bitacora.index') }}"
           style="
             color: {{ Request::is('bitacora*') ? '#fff' : '#41431b' }};
             font-weight: 600;
             border-radius: 14px;
             padding: 0.8rem 0.9rem;
             margin: 0.2rem 0.4rem;
             background: {{ Request::is('bitacora*') ? '#b04a2f' : 'transparent' }};
             box-shadow: {{ Request::is('bitacora*') ? '0 10px 24px rgba(176, 74, 47, 0.18)' : 'none' }};
           ">

          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
               style="
                 background: {{ Request::is('bitacora*') ? 'rgba(255,255,255,0.18)' : '#e3dbbb' }};
                 color: {{ Request::is('bitacora*') ? '#fff' : '#41431b' }};
                 box-shadow: none;
               ">
            <i class="fas fa-clipboard-list fa-lg"></i>
          </div>

          <span class="nav-link-text ms-1">Bitácora y Logs</span>
        </a>
      </li>

    </ul>
  </div>
</aside>