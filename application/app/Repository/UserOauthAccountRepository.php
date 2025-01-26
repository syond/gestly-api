<?php

namespace App\Repository;

use App\Models\UserOauthAccount;

class UserOauthAccountRepository
{
    public function updateOrCreateAccount(array $conditions, array $data) {
        return UserOauthAccount::updateOrCreate($conditions, $data);
    }
}
