<?php

namespace MMF\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use MMF\Database\Exception\InvalidAliasException;
use MMF\Environment;

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
    private $port;

    function __construct($alias, $hostname, $username, $password, $database, $port = null) {
        $this->alias    = $alias;
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port     = $port;
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
                if (isset($credentials->port)) {
                    return new Credentials
                    (
                        $credentials->alias,
                        $credentials->hostname,
                        $credentials->username,
                        $credentials->password,
                        $credentials->database,
                        $credentials->port
                    );
                } else {
                    return new Credentials
                    (
                        $credentials->alias,
                        $credentials->hostname,
                        $credentials->username,
                        $credentials->password,
                        $credentials->database
                    );
                }
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
     * Return the port as int.
     *
     * @return int
     */
    public function getPort() {
        return $this->port;
    }
}