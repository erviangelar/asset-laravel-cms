<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\UserRole;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('hasRole', function ($user, $roles) {
            $role = UserRole::select('user_roles.role_id as role_id','roles.name as role_name')
            ->where('user_id', $user->id)
            ->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
            ->first();
            // dd($role->role_name,$roles, (array)explode(';', $roles));
            return in_array($role->role_name, (array) explode(';', $roles));
        });
    }
}
