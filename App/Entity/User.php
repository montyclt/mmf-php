<?php

namespace App\Entity;

use MMF\Database\Entity;

/**
 * NOTE: This file is an example of ORM Entity.
 *
 * File: User.php
 *
 * MMF (Monty Micro Framework). A PHP Micro Framework for Rest apps.
 * Created by Ivan Montilla <example@example.com>
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
 * @author Ivan Montilla
 * @packgae App\Entity
 *
 * @Table User
 * @ConnectionAlias test
 */
class User extends Entity {

    /**
     * @Column id
     * @ColumnId
     * @ColumnType int
     * @var int
     */
    public $id;

    /**
     * @Column username
     * @ColumnType varchar
     * @var string
     */
    public $username;

    /**
     * @Column username
     * @ColumnType varchar
     * @var string
     */
    public $password;
}