<?php

namespace App\Http\Controllers;

use App\Contracts\SocialAuthServiceInterface;

class AuthController extends Controller
{
    private $socialAuthService;

    public function __construct(SocialAuthServiceInterface $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirectToProvider($provider)
    {
        return $this->socialAuthService->redirectToProvider($provider);
    }

    public function handleProviderCallback($provider)
    {
        $test = $this->socialAuthService->handleProviderCallback($provider);
        return $test;
    }
}
