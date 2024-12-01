<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Los namespaces de las rutas.
     *
     * @var string
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Registra cualquier ruta para la aplicación.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Mapea las rutas de la API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')  // Prefijo para las rutas de la API
        ->middleware('api')  // Middleware para proteger las rutas de la API
        ->namespace($this->namespace)  // Espacio de nombres para los controladores
        ->group(base_path('routes/api.php'));  // Aquí se carga el archivo api.php
    }

    /**
     * Mapea las rutas web.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
}
