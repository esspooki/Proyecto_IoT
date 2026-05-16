@extends('layouts.user_type.guest')

@section('content')
<main class="auth-wrapper">
    <div class="auth-container">

        <!-- Panel izquierdo -->
        <div class="auth-left">
            <div class="auth-card">

                <!-- Logo -->
                <div class="auth-logo">
                    <img src="{{ asset('assets/img/logo-ct.png') }}" alt="Logo">
                </div>

                <!-- Encabezado -->
                <div class="auth-header">
                    <span class="auth-subtitle">Bienvenido de nuevo</span>
                    <h1>Inicia sesión</h1>
                    <p>Accede a tu plataforma de gestión del invernadero</p>
                </div>

                <!-- Formulario -->
                <form method="POST" action="/session" class="auth-form">
                    @csrf

                    <!-- Email -->
                    <div class="input-group-custom">
                        <label for="email">Correo electrónico</label>
                        <div class="input-wrapper">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                placeholder="ejemplo@correo.com"
                                value="{{ old('email', 'admin@admin.com') }}"
                                required
                                autofocus>
                            <span class="input-icon">✉</span>
                        </div>
                        @error('email')
                            <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group-custom">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                required>
                            <span class="input-icon">🔒</span>
                        </div>
                        @error('password')
                            <p class="input-error">{{ $message }}</p>
                        @enderror
                    </div>

              
                    <!-- Botón -->
                    <button type="submit" class="auth-btn">
                        Ingresar
                    </button>
                </form>
            </div>
        </div>

        <!-- Panel derecho -->
        <div class="auth-right">
            <div class="auth-overlay">
                <div class="auth-right-content">
                    <h2>Controla tu invernadero de forma inteligente</h2>
                    <p>
                        Monitorea cultivos, variables ambientales y procesos desde una sola plataforma.
                    </p>
                </div>
            </div>
        </div>

    </div>
</main>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: var(--background);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-wrapper {
        min-height: 100vh;
        width: 100%;
        background: var(--background);
    }

    .auth-container {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }

    /* =========================
       PANEL IZQUIERDO
    ========================= */
    .auth-left {
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--background);
        padding: 40px;
    }

    .auth-card {
        width: 100%;
        max-width: 420px;
    }

    .auth-logo {
        margin-bottom: 40px;
    }

    .auth-logo img {
    max-width: 230px;
    width: 100%;
    height: auto;
}

    .auth-header {
        margin-bottom: 32px;
    }

    .auth-subtitle {
        display: inline-block;
        font-size: 14px;
        color: var(--tertiary);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .auth-header h1 {
        font-size: 38px;
        font-weight: 700;
        color: var(--secondary);
        margin: 0 0 10px 0;
        line-height: 1.1;
    }

    .auth-header p {
        font-size: 15px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.6;
    }

    .auth-form {
        width: 100%;
    }

    .input-group-custom {
        margin-bottom: 22px;
    }

    .input-group-custom label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 8px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper input {
        width: 100%;
        height: 54px;
        border: 1px solid #d8cfac;
        border-radius: 10px;
        padding: 0 50px 0 16px;
        font-size: 15px;
        color: var(--text-main);
        background: var(--surface);
        outline: none;
        transition: all 0.25s ease;
    }

    .input-wrapper input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(176, 74, 47, 0.15);
        background: var(--background);
    }

    .input-wrapper input::placeholder {
        color: #8b8b8b;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        font-size: 16px;
        opacity: 0.65;
        pointer-events: none;
    }

    .input-error {
        font-size: 12px;
        color: var(--primary);
        margin-top: 8px;
    }

    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 10px 0 28px 0;
        gap: 12px;
        flex-wrap: wrap;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--secondary);
        cursor: pointer;
    }

    .remember-me input {
        accent-color: var(--primary);
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .forgot-link {
        font-size: 14px;
        color: var(--secondary);
        text-decoration: none;
        font-weight: 600;
    }

    .forgot-link:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    .auth-btn {
        width: 100%;
        height: 54px;
        border: none;
        border-radius: 10px;
        background: var(--primary);
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 10px 24px rgba(176, 74, 47, 0.22);
    }

    .auth-btn:hover {
        background: #963d27;
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(176, 74, 47, 0.28);
    }

    /* =========================
       PANEL DERECHO
    ========================= */
    .auth-right {
        width: 50%;
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }

    .auth-overlay {
        width: 100%;
        height: 100%;
        background: linear-gradient(
            135deg,
            rgba(65, 67, 27, 0.78),
            rgba(174, 183, 132, 0.42),
            rgba(248, 243, 225, 0.08)
        );
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        padding: 60px;
    }

    .auth-right-content {
        max-width: 420px;
        color: #ffffff;
        text-shadow: 0 4px 24px rgba(0,0,0,0.20);
    }

    .auth-right-content h2 {
        font-size: 34px;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 16px;
        color: #ffffff;
    }

    .auth-right-content p {
        font-size: 16px;
        line-height: 1.8;
        margin: 0;
        color: var(--background);
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 992px) {
        .auth-left {
            width: 100%;
            padding: 30px 24px;
        }

        .auth-right {
            display: none;
        }

        .auth-card {
            max-width: 100%;
        }

        .auth-header h1 {
            font-size: 30px;
        }
    }

    @media (max-width: 576px) {
        .auth-left {
            padding: 24px 18px;
        }

        .auth-logo {
            margin-bottom: 28px;
            text-align: center;
        }

        .auth-logo img {
            max-width: 135px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 26px;
        }

        .auth-header h1 {
            font-size: 28px;
        }

        .auth-header p {
            font-size: 14px;
        }

        .input-wrapper input {
            height: 50px;
            font-size: 14px;
        }

        .auth-btn {
            height: 50px;
            font-size: 14px;
        }

        .auth-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection
