<?php

namespace App\Providers;

use App\Asset;
use App\Observers\AssetObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Workflow;
use App\Process;
use App\Observers\WorkflowObserver;
use App\Observers\ProcessObserver;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {

            return Hash::check($value, current($parameters));
        });
        Schema::defaultStringLength(191);
        /*
         * Observer
         */
        Workflow::observe(WorkflowObserver::class);
        Process::observe(ProcessObserver::class);
        Asset::observe(AssetObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
