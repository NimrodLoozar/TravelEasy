<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config) {
            return new class($app['hash'], $config['model']) implements \Illuminate\Contracts\Auth\UserProvider {
                protected $hasher;
                protected $model;

                public function __construct($hasher, $model)
                {
                    $this->hasher = $hasher;
                    $this->model = $model;
                }

                public function retrieveById($identifier)
                {
                    return $this->createModel()->newQuery()->find($identifier);
                }

                public function retrieveByToken($identifier, $token)
                {
                    $model = $this->createModel();

                    return $model->newQuery()
                        ->where($model->getKeyName(), $identifier)
                        ->where($model->getRememberTokenName(), $token)
                        ->first();
                }

                public function updateRememberToken(\Illuminate\Contracts\Auth\Authenticatable $user, $token)
                {
                    if ($user instanceof \App\Models\User) {
                        $user->setRememberToken($token);
                        $user->save();
                    } else {
                        throw new \Exception('User instance is not of type \App\Models\User');
                    }
                }

                public function retrieveByCredentials(array $credentials)
                {
                    if (empty($credentials) || !array_key_exists('email', $credentials)) {
                        return null;
                    }

                    $contact = Contact::where('email', $credentials['email'])->first();

                    if (!$contact) {
                        return null;
                    }

                    $customer = $contact->customer;

                    if (!$customer) {
                        return null;
                    }

                    return User::where('person_id', $customer->person_id)->first();
                }

                public function validateCredentials(\Illuminate\Contracts\Auth\Authenticatable $user, array $credentials)
                {
                    return $this->hasher->check($credentials['password'], $user->password);
                }

                protected function createModel()
                {
                    $class = '\\' . ltrim($this->model, '\\');

                    return new $class;
                }
            };
        });
    }
}
