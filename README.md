<div align="center">

# Sistema Inteligente de Gestión de Invernadero

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

# Instalación y configuración

## Requisitos previos

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

## Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/tu-repositorio.git
```

Entrar a la carpeta del proyecto:

```bash
cd tu-repositorio
```

---

## Instalar dependencias

### Dependencias de Laravel / PHP

```bash
composer install
```

### Dependencias frontend

```bash
npm install
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

## Ejecutar migraciones

Crear las tablas necesarias en la base de datos:

```bash
php artisan migrate
```
---

# Cómo correr el proyecto

## Opción recomendada

Abre **dos terminales** dentro del proyecto.

---

## Terminal 1 — Servidor Laravel

```bash
php artisan serve
```

Esto levantará el proyecto en:

```bash
http://127.0.0.1:8000
```

---

## Terminal 2 — Assets frontend

```bash
npm run dev
```

---

Si todo salió bien, podrás abrir tu navegador y entrar a:

```bash
http://127.0.0.1:8000
```

---

Proyecto desarrollado como sistema de gestión para un **invernadero inteligente**.

---

<div align="center">

### 🌱 Proyecto enfocado en tecnología aplicada al entorno agrícola

</div>
