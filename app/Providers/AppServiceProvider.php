<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
}
}
