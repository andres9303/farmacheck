<div align="center">
  <h1>Farmacheck</h1>
  <p>Sistema de gestión de interacciones medicamentosas</p>
  <p>
    <img src="./public/images/farmacheck-logo.svg" width="200" alt="Farmacheck Logo">
  </p>
</div>

## Sobre Farmacheck

Farmacheck es una aplicación web desarrollada con Laravel y Livewire para la gestión de interacciones medicamentosas. Permite a profesionales de la salud registrar, consultar y analizar las interacciones entre diferentes medicamentos, facilitando la toma de decisiones clínicas seguras.

## Características principales

- **Catálogo de medicamentos**: Gestión completa de medicamentos, principios activos, vías de administración y unidades de concentración.
- **Análisis de interacciones**: Registro y análisis de interacciones farmacodinámicas, farmacocinéticas y fisicoquímicas.
- **Matriz de compatibilidad**: Visualización de compatibilidades entre medicamentos en formato matricial.
- **Validador de interacciones**: Herramienta para validar posibles interacciones entre medicamentos seleccionados.
- **Gestión de tipos de compatibilidad**: Clasificación de interacciones según su nivel de compatibilidad.

## Tecnologías utilizadas

- **Backend**: Laravel 12.x
- **Frontend**: Livewire 3.x, Tailwind CSS, Alpine.js
- **Base de datos**: MySQL
- **Build tools**: Vite

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/andres9303/farmacheck.git
   cd farmacheck
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Instala las dependencias de Node.js:
   ```bash
   npm install
   ```

4. Copia el archivo de entorno:
   ```bash
   cp .env.example .env
   ```

5. Genera una clave de aplicación:
   ```bash
   php artisan key:generate
   ```

6. Configura tu base de datos en el archivo `.env`.

7. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```
8. Ejecuta los seeders:
   ```bash
   php artisan db:seed
   ```

9. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

10. En otra terminal, compila los activos de frontend:
   ```bash
   npm run dev
   ```

## Uso

1. Crea una cuenta de usuario o inicia sesión.
2. Navega por las diferentes secciones del menú:
   - **Catálogo**: Gestiona medicamentos, principios activos, vías de administración y unidades de concentración.
   - **Interacciones**: Registra y consulta interacciones medicamentosas.
   - **Herramientas**: Utiliza el validador de interacciones y la matriz de compatibilidad.

## Estructura del proyecto

```
app/
├── Http/Controllers/     # Controladores HTTP
├── Livewire/             # Componentes Livewire
├── Models/               # Modelos de base de datos
└── ...

resources/
├── views/
│   ├── livewire/         # Vistas de componentes Livewire
│   ├── layouts/          # Layouts de la aplicación
│   └── ...
└── ...

database/
├── migrations/           # Migraciones de base de datos
└── ...
```

## Licencia

Este proyecto está licenciado bajo la Licencia MIT.

## Créditos

- Desarrollado con [Laravel](https://laravel.com/)
- Interactividad con [Livewire](https://laravel-livewire.com/)
- Estilos con [Tailwind CSS](https://tailwindcss.com/)