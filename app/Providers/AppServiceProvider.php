<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Policies\AppointmentPolicy;
use App\Models\Service;
use App\Policies\ServicePolicy;
use App\Models\TimeSlot;
use App\Policies\TimeSlotPolicy;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    Gate::policy(Appointment::class, AppointmentPolicy::class);
    Gate::policy(Service::class, ServicePolicy::class);
    Gate::policy(TimeSlot::class, TimeSlotPolicy::class);

    $this->configureRateLimiting();
}

    /**
     * Configure rate limiting.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('booking.index', function (Request $request) {
            return Limit::perMinute(config('security.rate_limiting.booking.index'));
        });

        RateLimiter::for('booking.slots', function (Request $request) {
            return Limit::perMinute(config('security.rate_limiting.booking.slots'));
        });

        RateLimiter::for('booking.store', function (Request $request) {
            return Limit::perMinute(config('security.rate_limiting.booking.store'));
        });

        RateLimiter::for('auth.login', function (Request $request) {
            return Limit::perMinute(config('security.rate_limiting.auth.login'));
        });

        RateLimiter::for('auth.register', function (Request $request) {
            return Limit::perMinute(config('security.rate_limiting.auth.register'));
        });
    }
}
