<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAuthRoutes();

        $this->mapAccountRoutes();

        $this->mapAdminRoutes();

        $this->mapOffersRoutes();

        $this->mapContestsRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapAuthRoutes()
    {
        Route::prefix('auth')
            ->middleware('web')
            ->namespace($this->namespace . '\Auth')
            ->group(base_path('routes/auth.php'));
    }

    protected function mapAccountRoutes()
    {
        Route::prefix('account')
            ->middleware(['web'])
            ->namespace($this->namespace . '\Account')
            ->group(base_path('routes/account.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware(['web', 'admin'])
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapOffersRoutes()
    {
        Route::prefix('offers')
            ->middleware('web')
            ->namespace($this->namespace . '\Offers')
            ->group(base_path('routes/offers.php'));
    }

    protected function mapContestsRoutes()
    {
        Route::prefix('contests')
            ->middleware('web')
            ->namespace($this->namespace . '\Contests')
            ->group(base_path('routes/contests.php'));
    }
}
