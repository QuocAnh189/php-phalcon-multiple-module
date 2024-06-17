<?php

declare(strict_types=1);

namespace MyApp\Student\Models;

use Phalcon\Db\RawValue;
use Phalcon\Mvc\Model;

/**
 * Class Users
 *
 * @package MyApp\Student\Models
 *
 * @property string $code
 * @property string $username
 * @property string $email
 * @property string $department
 * @property string $major
 * @property string|RawValue $created_at
 */
class Students extends Model
{
    /**
     * @Primary
     * @var string
     */
    public string $code;

    /**
     * @var string
     */
    public string $username;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $department;

        /**
     * @var string
     */
    public string $major;

    /**
     * @var string|RawValue
     */
    public string|RawValue $created_at;

}
