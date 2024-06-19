<?php

declare(strict_types=1);

namespace MyApp\Student\Forms;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Regex;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

/**
 * Class StudentForm
 *
 * @package MyApp\Auth\Forms
 */
class StudentsForm extends Form
{
    /**
     * @param null $entity
     * @param null $options
     */
    public function initialize($entity = null, $options = null)
    {
        // Code text field
        $code = new Text('code');
        $code->setLabel('Code');
        $code->setFilters(['alnum']);
        $code->addValidators([
            new Regex([
                'pattern' => '/^[a-zA-Z0-9_ ]+$/',
                'message' => 'Username should contain only alphanumeric characters and underscore'
            ]),
            new PresenceOf(['message' => 'Please enter code']),
            new Uniqueness(
                [
                    'message' => 'Sorry, That code is already taken',
                ]
            )
        ]);
        // $this->add($code);
    
        // username text field
        $username = new Text('username');
        $username->setLabel('Username');
        $username->addValidators([
            new PresenceOf(['message' => 'Please enter username']),
        ]);

        $this->add($username);


        // email text field
        $email = new Text('email');
        $email->setLabel('Email');
        $email->addValidators([
            new PresenceOf(['message' => 'Please enter email']),
            new Regex([
                'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'message' => 'Please enter a valid email address'
            ]),
            new Uniqueness(
                [
                    'message' => 'Sorry, That email is already taken',
                ]
            )
        ]);
        $this->add($email);

        // department text field
        $department = new Text('department');
        $department->setLabel('Department');
        $department->addValidators([
            new PresenceOf(['message' => 'Please enter deparment']),
        ]);
        new Regex([
            'pattern' => '/^[^0-9]+$/',
            'message' => 'Department should not contain numbers'
        ]);
        $this->add($department);

        // major text field
        $major = new Text('major');
        $major->setLabel('major');
        $major->addValidators([
            new PresenceOf(['message' => 'Please enter major']),
        ]);
        new Regex([
            'pattern' => '/^[^0-9]+$/',
            'message' => 'Department should not contain numbers'
        ]);
        $this->add($major);
    }
}
