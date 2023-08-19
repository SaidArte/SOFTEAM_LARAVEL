<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
            ->prefix('personas')
            ->group(base_path('routes/personas.php'));
        
            Route::middleware('web')
                ->prefix('fierro')
                ->group(base_path('routes/fierro.php'));

            Route::middleware('web')
                ->prefix('psacrificio')
                ->group(base_path('routes/psacrificio.php'));
            
            Route::middleware('web')
                ->prefix('Usuarios')
                ->group(base_path('routes/Usuarios.php'));
    
            Route::middleware('web')
                ->prefix('Preguntas')
                ->group(base_path('routes/Preguntas.php'));
    
            Route::middleware('web')
                ->prefix('Roles')
                ->group(base_path('routes/Roles.php'));
    
            Route::middleware('web')
                ->prefix('Objetos')
                ->group(base_path('routes/Objetos.php'));
    
            Route::middleware('web')
                ->prefix('Permisos')
                ->group(base_path('routes/Permisos.php'));
    
            Route::middleware('web')
                ->prefix('Mantenimientos')
                ->group(base_path('routes/Mantenimientos.php'));


            Route::middleware('web')
                 ->prefix('Cventa')
                ->group(base_path('routes/Cventa.php'));

            Route::middleware('web')
                ->prefix('Animal')
                ->group(base_path('routes/Animal.php'));
                
                Route::middleware('web')
                ->prefix('ptraslado')
                ->group(base_path('routes/ptraslado.php'));

                            
        });
    }
}
