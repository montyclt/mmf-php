<?php

namespace MMF\Core\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use MMF\Core\Database\Exception\InvalidAliasException;
use MMF\Core\Environment;

/**
 * Class Credentials encapsulated Database credentials access.
 *
 * @package MMF\MMF.Core\Database
 */
class Credentials {
    private $alias;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $driver;

    function __construct($alias, $hostname, $username, $password, $database, $driver) {
        $this->alias    = $alias;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->driver   = $driver;
    }

    /**
     * Return new Credentials object using alias defined in Config/DatabasesCredentials.json
     *
     * @param string $alias
     * @return Credentials
     * @throws InvalidAliasException
     */
    public static function getCredentialsByAlias($alias) {
        foreach (Environment::getConfigObject()->DatabaseCredentials as $credentials) {
            if ($credentials->alias == $alias) {
                return new Credentials
                (
                    $credentials->alias,
                    $credentials->hostname,
                    $credentials->username,
                    $credentials->password,
                    $credentials->database,
                    $credentials->driver
                );
            }
        }

        throw new InvalidAliasException();
    }

    /**
     * Return the alias as string.
     *
     * @return string
     */
    public function getAlias() {
        return $this->alias;
    }

    /**
     * Return the hostname as string.
     *
     * @return string
     */
    public function getHostname() {
        return $this->hostname;
    }

    /**
     * Return the username as string.
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Return the password as string.
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Return the database name as string.
     *
     * @return string
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * Return the driver name as string.
     *
     * @return string
     */
    public function getDriver() {
        return $this->driver;
    }
}