<?php

declare(strict_types=1);

namespace MyApp\User\Models;

use Phalcon\Mvc\Model;
use Phalcon\Db\RawValue;

/**
 * Class Users
 *
 * @package MyApp\Auth\Models
 *
 * @property int|null $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property string|RawValue $created_at
 */
class Users extends Model
{
    /**
     * @Column(type="integer", nullable=true, column="id")
     */
    public ?int $id = null;

    /**
     * @Column(type="string", nullable=false, column="username")
     */
    public string $username;

    /**
     * @Column(type="string", nullable=false, column="password")
     */
    public string $password;

    /**
     * @Column(type="string", nullable=false, column="role")
     */
    public string $role;

    /**
     * @Column(type="string", nullable=false, column="created_at")
     */
    public string|RawValue $created_at;

}
