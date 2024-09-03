<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    
        Gate::define('add-department', function ($user) {
            return $user->hasPermission('add-department'); // Assuming you have a method to check permissions
        });
    
        Gate::define('edit-department', function ($user) {
            return $user->hasPermission('edit-department');
        });
    
        Gate::define('delete-department', function ($user) {
            return $user->hasPermission('delete-department');
        });
    }
}
