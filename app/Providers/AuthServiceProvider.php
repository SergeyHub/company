<?php

namespace App\Providers;

use App\Entity\Agency\Agency;
use App\Entity\Bill\Bill;
use App\Entity\Clients\Client;
use App\Entity\Girl\Girl;
use App\Entity\Offer\Offer;
use App\Entity\Review\Review;
use App\Entity\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(now()->addYears(100));
        Passport::refreshTokensExpireIn(now()->addYears(100));

        // girls
        Gate::define('view-girl', function ($user, Girl $girl) {
            return $user->isAdmin() || $user->id == $girl->user_id;
        });

        Gate::define('update-girl', function ($user, Girl $girl) {
            if ($user->isAgency()) {
                $user = $user->load('agency');
                return $user->agency->id == $girl->agency_id;
            }
            return $user->isAdmin() || $user->id == $girl->user_id;
        });

        Gate::define('remove-girl', function ($user, Girl $girl) {
            return $user->isAdmin() || $user->id == $girl->user_id;
        });

        Gate::define('remove-review', function ($user, Review $review) {
            return $user->isAdmin();
        });

        Gate::define('edit-review', function ($user, Review $review) {
            return $user->isAdmin();
        });

        // bills
        Gate::define('view-bill', function ($user, Bill $bill) {
            return $user->isAdmin() || $user->id == $bill->user_id;
        });

        // clients
        Gate::define('update-client', function ($user, Client $client) {
            return $user->isAdmin() || $user->id == $client->user_id;
        });

        // offers
        Gate::define('edit-offer', function ($user, Offer $offer) {
            return $user->isAdmin() || $offer->client && $user->id == $offer->client->user_id;
        });

        // users
        Gate::define('edit-user', function ($user, User $user_to_update) {
            return $user->isAdmin() || $user_to_update->id == $user->id;
        });

        Gate::define('delete-user', function ($user, User $user_to_update) {
            return $user->isAdmin();
        });

        // agencies
        Gate::define('update-agency', function ($user, Agency $agency) {
            return $user->isAdmin() || $user->id == $agency->user_id;
        });
    }
}
