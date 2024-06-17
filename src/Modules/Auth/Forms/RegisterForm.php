<?php

declare(strict_types=1);

namespace MyApp\Auth\Forms;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Regex;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\Confirmation;
use Phalcon\Filter\Validation\Validator\StringLength\Min;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Form;

class RegisterForm extends Form
{
    /**
     * Initialize the register form.
     * @param null $entity
     * @param null $options
     */
    public function initialize($entity = null, $options = null)
    {
        // Username text field
        $username = new Text('username');
        $username->setLabel('Username');
        $username->addValidators([
            new Regex([
                'pattern' => '/^[a-zA-Z0-9_ ]+$/',
                'message' => 'Username should contain only alphanumeric characters and underscore'
            ]),
            new PresenceOf(['message' => 'Username is required']),
            new Uniqueness(
                [
                    'message' => 'Sorry, Username is already taken',
                ]
            )
        ]);
        $this->add($username);

        // Password field
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new Min(['min' => 8, 'message' => 'Password must be at least 8 characters']),
        ]);
        $this->add($password);

        // Confirm Password field
        $confirmPassword = new Password('confirmPassword');
        $confirmPassword->setLabel('Confirm Password');
        $confirmPassword->addValidators([
            new PresenceOf(['message' => 'Confirmation password is required']),
            new Confirmation(["message" => "Confirmation Passwords are different", "with" => "password"]),
        ]);
        $this->add($confirmPassword);

        // Role field
        $role = new Select('role', [
            'admin' => 'admin',
            'user' => 'user',
        ]);
        $role->setLabel('Role');
        $role->addValidators([
            new PresenceOf(['message' => 'Role is required']),
            new InclusionIn([
                'message' => 'Role must be either "admin" or "user"',
                'domain' => ['admin', 'user'],
            ]),
        ]);
        $this->add($role);
    }
}
