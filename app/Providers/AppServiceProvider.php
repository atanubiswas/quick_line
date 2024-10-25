<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\adminMenuRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         view()->composer('*', function($view) {
            /*============ SHARE USER DETAILS FOR ALL VIEWES ===============*/
             if(auth()->user()){
                $menues = adminMenuRole::where("role_id", auth()->user()->roles[0]->id)
                    ->with("adminMenu.children", function($query){
                        $query->orderBy('admin_menus.menu_order');
                    })
                    ->orderBy("menu_order")
                    ->get();
                $view->with('menues', $menues);
             }
            $view->with('user', auth()->user());
            $view->with('site_name', 'Quick Line');
            /*============ SHARE USER DETAILS FOR ALL VIEWES ===============*/
         });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
//        Passport::tokensExpireIn(now()->addDays(15));
//        Passport::refreshTokensExpireIn(now()->addDays(30));
//        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
