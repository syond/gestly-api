<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;
use App\Contracts\SocialAuthServiceInterface;
use App\Repository\UserRepository;
use App\Repository\UserOauthAccountRepository;
use App\Models\User;

class SocialAuthService implements SocialAuthServiceInterface
{
    private $userRepository;
    private $userOauthRepository;

    public function __construct(UserRepository $userRepository, UserOauthAccountRepository $userOauthRepository)
    {
        $this->userRepository = $userRepository;
        $this->userOauthRepository = $userOauthRepository;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();

        // dd($providerUser->getName());

        $user = $this->userRepository->updateOrCreateUser(
            [
                'email' => $providerUser->getEmail(),
            ],
            [
                'name' => $providerUser->getName(),
                'registration_method' => User::REGISTRATION_TYPE_OAUTH,
                // 'birth_date' => $providerUser->getBirthdate(), // in this case hasn't
            ]
        );

        // dd($user->id);

        $userAccount = $this->userOauthRepository->updateOrCreateAccount(
            [
                'provider_name' => $provider,
                'provider_id' => $providerUser->getId(),
            ],
            [
                'user_id' => $user->id,
                'email' => $providerUser->getEmail(),
                'access_token' => $providerUser->token,
                'refresh_token' => $providerUser->refreshToken,
                'token_expires_at' => now()->addSeconds($providerUser->expiresIn),
            ]
        );

        dd($user, $userAccount);




        // $test = [
        //     'name' => $providerUser->name,
        //     'email' => $providerUser->email,
        //     'github_token' => $providerUser->token,
        //     'github_refresh_token' => $providerUser->refreshToken,
        // ];

        return $providerUser;
    }
}
