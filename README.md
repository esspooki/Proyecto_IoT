<div align="center">

# 🌿 Sistema Inteligente de Gestión de Invernadero

### Plataforma web desarrollada en Laravel para el monitoreo y administración de un invernadero

<br>

![Laravel](https://img.shields.io/badge/Laravel-Framework-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.x-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql)
![XAMPP](https://img.shields.io/badge/XAMPP-Local%20Server-FB7A24?style=for-the-badge&logo=apache)
![Blade](https://img.shields.io/badge/Blade-Templates-orange?style=for-the-badge&logo=laravel)
![Status](https://img.shields.io/badge/Status-En%20desarrollo-success?style=for-the-badge)

</div>

---

## 📖 Descripción

Este proyecto consiste en el desarrollo de un **sistema web para la gestión de un invernadero**, creado con **Laravel**, cuyo propósito es facilitar el control y monitoreo de variables importantes para el cuidado de cultivos.

La plataforma permite centralizar información relacionada con:

- 🌱 Cultivos
- 💧 Sistemas de riego
- 🌡️ Temperatura
- 💨 Humedad
- 📊 Monitoreo de condiciones ambientales
- 🧑‍🌾 Administración general del invernadero

---

## 🎯 Objetivo general

Desarrollar una aplicación web que permita **administrar, monitorear y optimizar** el funcionamiento de un invernadero mediante el registro y visualización de información importante para el control del entorno y la producción agrícola.

---

## 🎯 Objetivos específicos

- Registrar y gestionar cultivos dentro del sistema
- Monitorear condiciones ambientales del invernadero
- Llevar control del sistema de riego
- Consultar información histórica para análisis
- Facilitar la toma de decisiones en el manejo del cultivo
- Centralizar la administración del invernadero en una sola plataforma

---

## 🛠️ Tecnologías utilizadas

| Tecnología | Descripción |
|-----------|-------------|
| **Laravel** | Framework principal del proyecto |
| **PHP** | Lenguaje backend |
| **PostgreSQL / MySQL** | Base de datos |
| **Blade** | Motor de plantillas |
| **HTML / CSS / JS** | Interfaz de usuario |
| **Composer** | Gestión de dependencias PHP |
| **Node.js / NPM** | Compilación de assets frontend |

---

## 📂 Estructura del proyecto

```bash
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
vendor/
.env
artisan
composer.json
package.json
README.md
```

---

# ⚙️ Instalación y configuración

## 📋 Requisitos previos

Antes de ejecutar el proyecto, asegúrate de tener instalado:

- **PHP >= 8.1**
- **Composer**
- **Node.js >= 18**
- **NPM**
- **PostgreSQL o MySQL**
- **Git**

Puedes verificarlo con los siguientes comandos:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

## 📥 Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
```

Entrar a la carpeta del proyecto:

```bash
cd tu-repositorio
```

---

## 📦 Instalar dependencias

### Dependencias de Laravel / PHP

```bash
composer install
```

### Dependencias frontend

```bash
npm install
```

---

## 🔐 Configurar variables de entorno

### 1) Copiar archivo `.env`

```bash
cp .env.example .env
```

> En **Windows PowerShell** usa:

```powershell
copy .env.example .env
```

---

### 2) Generar clave de la aplicación

```bash
php artisan key:generate
```

---

## 🗄️ Configurar la base de datos

Abre el archivo `.env` y configura tu conexión.

### Ejemplo con PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=invernadero
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

### Ejemplo con MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invernadero
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🧱 Ejecutar migraciones

Crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

Si tienes datos de prueba o iniciales:

```bash
php artisan db:seed
```

O ambas cosas juntas:

```bash
php artisan migrate --seed
```

---

# ▶️ Cómo correr el proyecto

## Opción recomendada

Abre **dos terminales** dentro del proyecto.

---

## 🖥️ Terminal 1 — Servidor Laravel

```bash
php artisan serve
```

Esto levantará el proyecto en:

```bash
http://127.0.0.1:8000
```

---

## 🎨 Terminal 2 — Assets frontend

```bash
npm run dev
```

---

## ✅ Proyecto corriendo correctamente

Si todo salió bien, podrás abrir tu navegador y entrar a:

```bash
http://127.0.0.1:8000
```

---

# 🧪 Flujo completo para ejecutar desde cero

Si acabas de clonar el proyecto, este es el orden correcto:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

> En Windows, si `cp` no funciona:

```powershell
copy .env.example .env
```

---

# 📌 Funcionalidades principales

Este sistema puede incluir funcionalidades como:

- 🌱 Registro de cultivos
- 🌡️ Monitoreo de temperatura
- 💨 Monitoreo de humedad
- 💧 Control de riego
- 📊 Historial de condiciones ambientales
- 🚨 Alertas por condiciones críticas
- 👤 Gestión de usuarios
- 📝 Reportes del invernadero

---

# 🛠️ Comandos útiles

## Limpiar caché del proyecto

```bash
php artisan optimize:clear
```

---

## Limpiar cachés individuales

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Crear una migración

```bash
php artisan make:migration nombre_de_la_migracion
```

---

## Crear un controlador

```bash
php artisan make:controller NombreController
```

---

## Crear un modelo con migración

```bash
php artisan make:model Nombre -m
```

---

# 🐛 Problemas comunes

## Error: No application encryption key has been specified

Solución:

```bash
php artisan key:generate
```

---

## Error de conexión a la base de datos

Verifica en tu archivo `.env`:

- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

---

## Error con dependencias de Laravel

```bash
composer install
```

---

## Error con dependencias frontend

```bash
npm install
npm run dev
```

---

# 📷 Capturas del sistema

Aquí puedes agregar capturas de pantalla del sistema:

```md
![Dashboard](./public/images/dashboard.png)
![Módulo Cultivos](./public/images/cultivos.png)
![Monitoreo](./public/images/monitoreo.png)
```

---

# 👨‍💻 Autor

**Carlos Contreras**  
Proyecto desarrollado como sistema de gestión para un **invernadero inteligente**.

---

<div align="center">

### 🌱 Proyecto enfocado en tecnología aplicada al entorno agrícola

</div>