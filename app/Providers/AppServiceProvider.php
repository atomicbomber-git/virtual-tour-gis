<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Information;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $informationsBinder = function ($view) {
            $view->with("information_menus", $this->getInformationMenus());
        };

        app('view')->composer('shared.navbar-guest', $informationsBinder);
        app('view')->composer('shared.navbar', $informationsBinder);
    }

    private function getInformationMenus() {
        return Information::query()
            ->select("type", "title", "icon")
            ->get()
            ->mapWithKeys(function (Information $information) {
                return [$information->type => [
                    "title" => $information->title,
                    "type" => $information->type,
                    "icon" => $information->icon,
                ]];
            });
    }
}
