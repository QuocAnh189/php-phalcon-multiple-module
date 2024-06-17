<?php

declare(strict_types=1);

namespace MyApp\Auth\Services;

use MyApp\Auth\Models\Users;
use MyApp\Common\ErrorException;
use MyApp\Auth\Repositories\AuthsRepository;
use Phalcon\Db\RawValue;
use Phalcon\Encryption\Crypt;

/**
 * Class AuthsService
 *
 * @package MyApp\Auth\Services
 */
class AuthsService
{
    private AuthsRepository $authsRepository;

    /**
     * AuthsService constructor.
     */
    public function __construct()
    {
        $this->authsRepository = new AuthsRepository();
    }

    /**
     * Authenticate user based on provided credentials.
     *
     * @param array $postData The data containing username and password
     * @return Users The authenticated user
     * @throws ErrorException If authentication fails (user not found or incorrect password)
     */
    public function loginUser(array $postData)
    {            
        try {
            $user = $this->authsRepository->findUserByUsername($postData['username']);

            if (!$user) {
                throw new ErrorException(404, 'User not found');
                return;
            }
    
            $crypt = new Crypt();
            $crypt->setCipher('aes256')->useSigning(false);
            $encryptedPassword = base64_decode($user->password);
            $decryptedPassword = $crypt->decrypt($encryptedPassword, 'mykey');
    
            if (!($postData['password'] === $decryptedPassword)) {
                throw new ErrorException(401, 'Incorrect password');
            }
    
            return $user;
        }
        catch (\ErrorException $e){
            if ($e->getCode() === 404) {
                throw $e;
            } elseif ($e->getCode() === 401) {
                throw $e;
            } else {
                throw new ErrorException('Server Error', 500);
            }
        }
    }

    /**
     * Register a new user.
     *
     * @param array $postData The data containing user details
     * @param Users $newUser The new user object
     * @return Users The registered user object
     * @throws ErrorException If user registration fails
     */
    public function registerUser(array $postData, $newUser)
    {
        $crypt  = new Crypt();
        $crypt->setCipher('aes256')->useSigning(false);
        $encryptedPassword = $crypt->encrypt($postData['password'], 'mykey');
        $newUser->password = base64_encode($encryptedPassword);

        $newUser->created_at = new RawValue('now()');

        try {
            $this->authsRepository->create($newUser);
            return $newUser;   
        }
        catch (\Exception $e) {
            throw new ErrorException(500, 'Server Error');
        }
    }
}
