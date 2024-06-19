<?php

declare(strict_types=1);

namespace MyApp\User\Repositories;

use MyApp\User\Models\Users;
use Phalcon\Encryption\Crypt;

/**
 * Class usersRepository
 *
 * This repository handles data operations for the users model.
 *
 * @package MyApp\user\Repositories
 */
class UsersRepository
{
    /**
     * Retrieves all users based on given parameters.
     *
     * @param array $parameters An associative array of query parameters.
     */
    public function findUsers(array $parameters = [])
    {
        $conditions = [];
        $bind = [];

        // Example: building conditions based on parameters
        if (isset($parameters['department'])) {
            $conditions[] = 'department = :department:';
            $bind['department'] = $parameters['department'];
        }

        // Build your query based on conditions and bind parameters
        return Users::find([
            implode(' AND ', $conditions),
            'bind' => $bind,
        ]);
    }

    /**
     * Retrieves a user by their unique code.
     *
     * @param string $code The unique code of the user.
     */
    public function getById(string|null $id): ?Users
    {
        $user = Users::findFirstById($id);
        return $user;
    }

     /**
     * Creates a new user record.
     *
     * @param array $data An associative array of user data.
     *                    Example: ['name' => 'Anh Quoc', 'department' => 'Khoa hoc may tinh']
     */
    public function create(array $data)
    {
        $user = new Users();
        $user->assign($data);
        $user->save();
    }

    /**
     * Updates an existing user record.
     *
     * @param Users $user The user model to update.
     * @param array    $data    An associative array of updated user data.
     */
    public function update(Users $user, array $data)
    {
        $user->assign($data);
        $user->save();
    }

     /**
     * Deletes a user record.
     *
     * @param Users $user The user model to delete.
     */
    public function delete(Users $user)
    {
        $user->delete();
    }
}
