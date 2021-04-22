<?php

namespace App\Providers;


use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Carbon\Laravel\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        $this->registerTranslations();
//        $this->registerConfig();

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
    }
}