<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Remember;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class   MasterViewServicerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if(Schema::hasTable('remembers')){
            $notifi = Remember::where('action',null)->with('admin','students_remember')->orderBy('date','ASC')->get();
            View::share('notifi',$notifi);

        }
    }
}
