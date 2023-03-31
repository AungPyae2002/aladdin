<?php

namespace App\Providers;

use App\Models\PaymentMethod;
use App\Models\ThreeDSchedule;
use App\Models\ThreeDSection;
use App\Models\TwoDSchedule;
use App\Models\TwoDSection;
use App\Models\TwoDType;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/admin/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::prefix('api/agent')
                ->group(base_path('routes/agent.php'));
        });

        Route::model('twod_type', TwoDType::class);
        Route::model('twod_schedule',TwoDSchedule::class);
        Route::model('twod_section', TwoDSection::class);
        Route::model('threed_schedule', ThreeDSchedule::class);
        Route::model('threed_section', ThreeDSection::class);
        Route::model('payment_method',PaymentMethod::class);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
