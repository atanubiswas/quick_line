<?php

namespace App\Providers;

use App\Models\Doctor;
use Illuminate\Support\ServiceProvider;

use App\Models\adminMenuRole;
use App\Models\caseStudy;

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

                if(in_array(auth()->user()->roles[0]->id, [1, 5, 6])){
                    $caseCount = caseStudy::where("study_status_id", 1)->count();
                    $emergencyCaseCount = caseStudy::where("study_status_id", 1)->where("is_emergency", 1)->count();
                    $normalCaseCount = $caseCount - $emergencyCaseCount;
                    $view->with('case_count', $caseCount);
                    $view->with('emergencyCaseCount', $emergencyCaseCount);
                    $view->with('normalCaseCount', $normalCaseCount);
                    $view->with('caseStudiesUrl', route('admin.viewCaseStudy'));
                }
                elseif(in_array(auth()->user()->roles[0]->id, [4])){
                    $userId = auth()->user()->id;
                    $doctor = Doctor::where("user_id", $userId)->first();
                    $caseCount = caseStudy::whereIn("study_status_id", [2, 4])->where("doctor_id", $doctor->id)->count();
                    $emergencyCaseCount = caseStudy::whereIn("study_status_id", [2, 4])->where("doctor_id", $doctor->id)->where("is_emergency", 1)->count();
                    $normalCaseCount = $caseCount - $emergencyCaseCount;
                    $view->with('case_count', $caseCount);
                    $view->with('emergencyCaseCount', $emergencyCaseCount);
                    $view->with('normalCaseCount', $normalCaseCount);
                    $view->with('caseStudiesUrl', route('admin.viewCaseStudy'));
                }
                else{
                    $view->with('case_count', 0);
                    $view->with('emergencyCaseCount', 0);
                    $view->with('normalCaseCount', 0);
                    $view->with('caseStudiesUrl', route('admin.viewCaseStudy'));
                }
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
