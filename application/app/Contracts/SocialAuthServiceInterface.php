<?php

namespace App\Contracts;

// use App\Models\User;

interface SocialAuthServiceInterface {
    public function redirectToProvider(string $provider);
    public function handleProviderCallback(string $provider);
}