<?php

namespace App\Entity;

use MMF\Core\Database\Entity;

/**
 * NOTE: This file is an example of ORM Entity.
 *
 * File: User.php
 *
 * MMF (Monty Micro Framework). A PHP Micro Framework for Rest apps.
 * Created by Ivan Montilla
 *
 * Official website:  mmf-php.com
 * Documentation:     docs.mmf-php.com
 *
 * You have permission to use, adapt and redistribute this
 * code or adaption.
 * You can use this framework or adaption for make apps
 * with profit, but never sell this framework or adaption.
 *
 * Get started in docs.mmf-php.com/quickstart
 *
 * @Table User
 * @ConnectionAlias Example1
 */
class User extends Entity {

    /**
     * @Column id
     * @ColumnType int
     * @var int
     */
    private $id;

    /**
     * @Column username
     * @ColumType varchar
     * @var string
     */
    private $username;

    /**
     * @Column username
     * @ColumType varchar
     * @var string
     */
    private $password;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}