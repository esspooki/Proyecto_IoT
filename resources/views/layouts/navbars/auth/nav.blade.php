<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg mx-4 mt-3 px-3 py-2 border-radius-xl custom-navbar" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid px-0">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb custom-breadcrumb mb-1">
                    <li class="breadcrumb-item text-sm">
                        <a class="breadcrumb-link" href="javascript:;">Paginas</a>
                    </li>
                    <li class="breadcrumb-item text-sm active custom-breadcrumb-active text-capitalize" aria-current="page">
                        {{ str_replace('-', ' ', Request::path()) }}
                    </li>
                </ol>
            </nav>

            <h6 class="custom-navbar-title mb-0 text-capitalize">
                {{ str_replace('-', ' ', Request::path()) }}
            </h6>
        </div>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <ul class="navbar-nav justify-content-end align-items-center gap-2">
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ url('/logout') }}" class="custom-logout-btn">
                        <i class="fa fa-sign-out-alt me-2"></i>
                        <span class="d-sm-inline d-none">Cerrar sesion</span>
                    </a>
                </li>

                <li class="nav-item d-xl-none d-flex align-items-center">
                    <a href="javascript:;" class="custom-menu-toggle" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>
.custom-navbar {
    position: static !important;
    z-index: 1 !important;
    margin-bottom: 1rem;
    background: rgba(248, 243, 225, 0.96);
    border: 1px solid rgba(174, 183, 132, 0.3);
    box-shadow: 0 8px 24px rgba(65, 67, 27, 0.08);
    border-radius: 18px;
}

.custom-breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-link {
    color: var(--tertiary);
    text-decoration: none;
    font-weight: 500;
}

.breadcrumb-link:hover {
    color: var(--primary);
}

.custom-breadcrumb-active {
    color: var(--secondary) !important;
    font-weight: 600;
}

.custom-navbar-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--secondary);
}

.custom-logout-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 18px;
    border-radius: 12px;
    background: var(--primary);
    color: #fff !important;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    box-shadow: 0 8px 18px rgba(176, 74, 47, 0.18);
}

.custom-logout-btn:hover {
    background: #963d27;
    color: #fff !important;
}

.custom-menu-toggle {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.custom-menu-toggle:hover {
    background: var(--tertiary);
}

.custom-menu-toggle .sidenav-toggler-inner {
    width: 18px;
}

.custom-menu-toggle .sidenav-toggler-line {
    display: block;
    width: 100%;
    height: 2px;
    background: var(--secondary);
    margin: 4px 0;
    border-radius: 999px;
}
</style>
<!-- End Navbar -->
