# Gold Gym

Aplicación web desarrollada para la gestión de un gimnasio, permitiendo la administración de planes, registro de usuarios y procesamiento de pagos mediante Mercado Pago.

## Descripción

Gold Gym es una plataforma web construida con Laravel que cuenta con un panel de administración y una interfaz para usuarios. El sistema permite gestionar membresías, registrar clientes y facilitar la contratación de planes mediante integración con Mercado Pago.

## Características

* Registro e inicio de sesión de usuarios.
* Gestión de planes y membresías.
* Panel de administración.
* Integración con Mercado Pago.
* Gestión de clientes.
* Interfaz responsive.
* Validación de formularios y control de acceso.

## Tecnologías utilizadas

### Backend

* PHP
* Laravel

### Frontend

* Blade
* HTML5
* CSS3
* JavaScript

### Base de datos

* MySQL

### Herramientas

* Git
* Composer
* Vite

## Instalación

Clonar el repositorio:

```bash
git clone https://github.com/herminiabento/GoldGym.git
```

Ingresar al proyecto:

```bash
cd GoldGym
```

Instalar dependencias de PHP:

```bash
composer install
```

Instalar dependencias de JavaScript:

```bash
npm install
```

Crear archivo de entorno:

```bash
cp .env.example .env
```

Generar clave de aplicación:

```bash
php artisan key:generate
```

Configurar la base de datos en el archivo `.env` y ejecutar:

```bash
php artisan migrate
```

Iniciar el servidor:

```bash
php artisan serve
```

Compilar assets:

```bash
npm run dev
```

## Integración de pagos

La aplicación utiliza Mercado Pago para procesar pagos de membresías y planes. Es necesario configurar las credenciales correspondientes en el archivo `.env`.

## Estructura del proyecto

```text
app/
config/
database/
public/
resources/
routes/
storage/
```

## Funcionalidades futuras

* Historial de pagos.
* Panel de métricas y estadísticas.
* Gestión de asistencia de socios.
* Notificaciones por correo electrónico.

## Autora

**Herminia Bento**

* GitHub: github.com/herminiabento
* LinkedIn: linkedin.com/in/herminiabento
