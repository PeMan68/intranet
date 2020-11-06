<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Auth\Events\Authenticated;

class BladeExtrasServiceProvider extends ServiceProvider
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
		Blade::if('showmodule', function($expression){
			if(!Auth::check()){
				return false;
			}
			if(setting($expression)){
				return true;
			}
			if(Auth::user()->hasAnyRoles(['superadmin','beta'])){
				return true;
			}
			return false;
		});

		Blade::if('hasrole', function($expression){
			
			if(Auth::user()){
				if(Auth::user()->hasAnyRole($expression)){
					return true;
				}
			}
			
			return false;
		});
		
		Blade::if('hasroles', function($expression){
			
			if(Auth::user()){
				if(Auth::user()->hasAnyRoles($expression)){
					return true;
				}
			}
			
			return false;
		});
		
		Blade::if('impersonate', function(){
			if(session()->get('impersonate')){
				return true;
			}
			
			return false;
		});
    }
}
