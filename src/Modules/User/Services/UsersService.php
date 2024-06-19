<?php

declare(strict_types=1);

namespace MyApp\User\Services;

use MyApp\Common\ErrorException;
use MyApp\User\Models\Users;
use Phalcon\Encryption\Crypt;
use MyApp\User\Repositories\UsersRepository;

/**
 * Class usersService
 *
 * This service class handles business logic for User operations.
 *
 * @package MyApp\User\Services
 */
class usersService
{
    private UsersRepository $usersRepository;

    /**
     * usersService constructor.
     *
     * Initializes the usersRepository.
     */
    public function __construct()
    {
        $this->usersRepository = new usersRepository();
    }

    /**
     * Retrieves all users based on given parameters.
     *
     * @param array $parameters An associative array of query parameters.
     *  
     * @return users[]|false The result set of users or false if no results found.
     */
    public function findUsers(array $parameters = [])
    {
        return $this->usersRepository->findUsers($parameters);
    }

    /**
     * Retrieves a User by their unique code.
     *
     * @param string $code The unique code of the User.
     *
     * @return users|false|null The User record, false if not found, or null if no result.
     */
    public function getUserById(string $id): ?users
    {
        $user = $this->usersRepository->getById($id);
        $crypt = new Crypt();
        $crypt->setCipher('aes256')->useSigning(false);
        $user->password = $crypt->decrypt(base64_decode($user->password), 'mykey');

        // $encryptedPassword = base64_decode($user->password);
        // $user->password = $crypt->decrypt($encryptedPassword, 'mykey');

        return $user;   
    }

     /**
     * Creates a new User record.
     *
     * @param array $data An associative array of User data.
     *
     * @throws ErrorException If a server error occurs during creation.
     */
    public function createUser(array $data)
    {
        try {
            $this->usersRepository->create($data); 
        }
        catch (\ErrorException $e) {
            throw new ErrorException(500, 'Server Error');
        }
    }

    /**
     * Updates an existing User record.
     *
     * @param users $User The User model to update.
     * @param array    $data    An associative array of updated User data.
     *
     * @throws ErrorException If the User is not found or if a server error occurs.
     */
    public function updateUser(Users $user, array $data): void
    {
        try {
            $crypt = new Crypt();
            $crypt->setCipher('aes256')->useSigning(false);
            // $user->password = $crypt->encrypt(base64_decode($user->password), 'mykey');
            $data['password'] = base64_encode($crypt->encrypt(($data['password']), 'mykey'));

            // $user = $this->usersRepository->getById($user->id);
            if (!$user) {
                throw new ErrorException(404, 'User not found');
            }
            $this->usersRepository->update($user, $data); 
        }
        catch (\ErrorException $e) {
            if ($e->getCode() === 404) {
                throw $e;
            } else {
                throw new ErrorException('Server Error', 500);
            }
        }
    }

     /**
     * Deletes a User record.
     *
     * @param string $code The unique code of the User.
     *
     * @throws ErrorException If the User is not found or if a server error occurs.
     */
    public function deleteUser(string $id): void
    {
        try {
            $user = $this->usersRepository->getById($id);
            if (!$user) {
                throw new ErrorException(404, 'User not found');
            }

            $this->usersRepository->delete($user);
        }
        catch (\ErrorException $e) {
            if ($e->getCode() === 404) {
                throw $e;
            } else {
                throw new ErrorException('Server Error', 500);
            }
        }
    }
}
