<?php

namespace MMF\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use MMF\Database\Exception\CursorException;
use mysqli;
use mysqli_result;
use mysqli_stmt;

/**
 * Class Cursor
 */
class Cursor {
    const FETCH_ASSOC  = 1;
    const FETCH_NUM    = 2;
    const FETCH_BOTH   = 3;

    /**
     * @var mysqli
     */
    private $mysqli;

    /**
     * @var mysqli_result
     */
    private $result;

    /**
     * @var mysqli_stmt
     */
    private $statement;

    /**
     * DatabaseCursor constructor.
     *
     * @param Credentials $credentials
     * @throws CursorException
     */
    function __construct($credentials) {
        if ($credentials->getPort()) {
            $this->mysqli = new mysqli(
                $credentials->getHostname(),
                $credentials->getUsername(),
                $credentials->getPassword(),
                $credentials->getDatabase(),
                $credentials->getPort()
            );
        } else {
            $this->mysqli = new mysqli(
                $credentials->getHostname(),
                $credentials->getUsername(),
                $credentials->getPassword(),
                $credentials->getDatabase()
            );
        }

        if ($this->mysqli->connect_errno) throw new CursorException(CursorException::MSG_CONNECTION_ERROR);
    }

    /**
     * Get a Cursor object with credentials defined in config.json
     * Use an alias to select
     *
     * @param string $database_alias
     * @return Cursor
     */
    public static function getCursorByAlias($database_alias) {
        return new Cursor(Credentials::getCredentialsByAlias($database_alias));
    }

    /**
     * Prepare a MySQL query.
     *
     * @param $sql
     * @throws CursorException
     */
    public function prepare($sql) {
        $result = $this->mysqli->prepare($sql);
        if (!$result) throw new CursorException(CursorException::MSG_PREPARE_ERROR);
        $this->statement = $result;
    }

    /**
     * Execute a prepared statement.
     *
     * @param array $data
     * @throws CursorException
     */
    public function execute($data) {
        $types = "";
        foreach ($data as $item) {
            if (is_int($item)) $types .= "i";
            else if (is_double($item)) $types .= "d";
            else if (is_string($item)) $types .= "s";
            else if (is_resource($item) or is_object($item)) $types .= "b";
        }
        call_user_func_array([$this->statement, "bind_param"], $data);
        $result = $this->statement->execute();
        if (!$result) throw new CursorException(CursorException::MSG_QUERY_ERROR);
        else if (!$result === true) {
            $this->result = $this->statement->get_result();
        }
    }

    /**
     * Do a database query.
     *
     * @param $sql
     * @throws CursorException
     */
    public function query($sql) {
        $result = $this->mysqli->query($sql);
        if (!$result) throw new CursorException(CursorException::MSG_QUERY_ERROR);
        $this->result = $result;
    }

    public function fetch($fetch_type) {
        if ($fetch_type < 1 or $fetch_type > 3) throw new CursorException(CursorException::MSG_INVALID_FETCH_TYPE);
        return $this->result->fetch_array($fetch_type);
    }

    public function fetchAll($fetch_type) {
        if ($fetch_type < 1 or $fetch_type > 3) throw new CursorException(CursorException::MSG_INVALID_FETCH_TYPE);
        return $this->result->fetch_all($fetch_type);
    }

    public function isConnectionActive() {
        return $this->mysqli->ping();
    }

    public function changeDatabase($credentials) {
        $this->disconnect();
        unset($this->mysqli);
        $this->__construct($credentials);
    }

    /**
     * Disconnect cursor from Database.
     *
     * @throws CursorException
     */
    public function disconnect() {
        $result = $this->mysqli->close();
        if (!$result) throw new CursorException(CursorException::MSG_CURSOR_UNCLOSED);
    }

    public function __destruct() {
        $this->disconnect();
    }
}