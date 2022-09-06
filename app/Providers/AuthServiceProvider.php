<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Feedback;
use App\Models\User;
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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see-full-feedback-list', function (User $user) {
            return $user->is_manager;
        });

        Gate::define('change-feedback-status', function (User $user) {
            return $user->is_manager;
        });

        Gate::define('see-leave-feedback', function (User $user) {
            return !$user->is_manager;
        });

        Gate::define('leave-feedback', function (User $user, Feedback $latestFeedback) {

            if ($latestFeedback && ($latestFeedback->created_at < $latestFeedback->created_at->addDays(1)))
                return false;

            return true;
        });
    }
}
