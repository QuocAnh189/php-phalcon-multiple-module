<?php

declare(strict_types=1);

namespace MyApp\Auth\Repositories;

use MyApp\Auth\Models\Users;

/**
 * Class AuthsRepository
 *
 * @package MyApp\Auth\Repositories
 */
class AuthsRepository
{
    /**
     * Find a user by username.
     *
     * @param string $username The username to search for
     * @return Users|null The found user or null if not found
     */
    public function findUserByUsername(string $username): ?Users
    {
        return Users::findFirst([
            'conditions' => 'username = :username:',
            'bind' => [
                'username' => $username,
            ],
        ]) ?: null;
    }

    public function create(Users $users): void
    {
        $users->save();
    }

    public function update(Users $users, array $data): void
    {
        $users->assign($data);
        $users->save();
    }

    public function delete(Users $users): void
    {
        $users->delete();
    }
}
