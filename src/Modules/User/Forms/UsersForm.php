<?php

declare(strict_types=1);

namespace MyApp\User\Forms;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class UsersForm extends Form
{
    /**
     * @param null $entity
     * @param null $options
     */
    public function initialize($entity = null, $options = null)
    {
        $username = new Text('username');
        $username->setLabel('Username');
        $username->addValidators([
            new PresenceOf(['message' => 'Please enter username']),
            new Uniqueness(
                [
                    'message' => 'Sorry, That code is already taken',
                ]
            )
        ]);
        $this->add($username);

        $password = new Text('password');
        $password->setLabel('password');
        $password->addValidators([
            new PresenceOf(['message' => 'Please enter password']),
        ]);
        $this->add($password);
    
        // username text field
        $role = new Text('role');
        $role->setLabel('Role');
        $role->addValidators([
            new PresenceOf(['message' => 'Please enter role']),
        ]);
        $this->add($role);
    }
}
