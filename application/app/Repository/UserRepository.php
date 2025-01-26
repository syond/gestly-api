<?php

namespace App\Repository;

use App\Models\User;

class UserRepository {
    public function updateOrCreateUser(array $conditions, array $data) {
        return User::updateOrCreate($conditions, $data);
    }
}