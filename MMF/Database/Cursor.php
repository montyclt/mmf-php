<?php

namespace MMF\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use MMF\Database\Exception\CursorException;
use MMF\Helper;
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
     * @tested
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
     * @tested
     */
    public static function getCursorByAlias($database_alias) {
        return new Cursor(Credentials::getCredentialsByAlias($database_alias));
    }

    /**
     * Prepare a statement.
     *
     * @param $sql
     * @throws CursorException
     * @tested
     */
    public function prepare($sql) {
        $result = $this->mysqli->prepare($sql);
        if (!$result) throw new CursorException(CursorException::MSG_PREPARE_ERROR);
        $this->statement = $result;
    }

    /**
     * Execute a prepared statement, specify data opcionally.
     *
     * @param array $data
     * @throws CursorException
     * @tested
     */
    public function execute($data = null) {
        if ($data !== null) {
            $types = "";
            foreach ($data as $item) {
                if (is_int($item)) $types .= "i";
                else if (is_double($item)) $types .= "d";
                else if (is_string($item)) $types .= "s";
                else if (is_resource($item) or is_object($item)) $types .= "b";
            }
            array_unshift($data, $types);
            call_user_func_array([$this->statement, "bind_param"], Helper::transformArrayToReferencedArray($data));
        }
        $result = $this->statement->execute();
        if (!$result) throw new CursorException(CursorException::MSG_QUERY_ERROR);
        else $this->result = $this->statement->get_result();
    }

    /**
     * Do a SQL query.
     *
     * @param $sql
     * @throws CursorException
     * @tested
     */
    public function query($sql) {
        $result = $this->mysqli->query($sql);
        if (!$result) throw new CursorException(CursorException::MSG_QUERY_ERROR);
        $this->result = $result;
    }

    /**
     * Get the next row in array.
     *
     * @param $fetch_type
     * @return mixed
     * @throws CursorException
     * @tested
     */
    public function fetch($fetch_type) {
        if ($fetch_type < 1 or $fetch_type > 3) throw new CursorException(CursorException::MSG_INVALID_FETCH_TYPE);
        return $this->result->fetch_array($fetch_type);
    }

    /**
     * Get all row in double dimension array.
     *
     * @param int $fetch_type
     * @return array
     * @throws CursorException
     * @tested
     */
    public function fetchAll($fetch_type) {
        if ($fetch_type < 1 or $fetch_type > 3) throw new CursorException(CursorException::MSG_INVALID_FETCH_TYPE);
        return $this->result->fetch_all($fetch_type);
    }

    /**
     * Check if database connection is active. If not, try to reconnect.
     *
     * @return bool
     * @tested
     */
    public function isConnectionActive() {
        return $this->mysqli->ping();
    }

    /**
     * Change the database on cursor is connected
     *
     * @param $credentials
     * @tested
     */
    public function changeDatabase($credentials) {
        unset($this->mysqli);
        $this->__construct($credentials);
    }

    /**
     * Disconnect cursor from database.
     *
     * @throws CursorException
     * @tested
     */
    public function disconnect() {
        $result = $this->mysqli->close();
        if (!$result) throw new CursorException(CursorException::MSG_CURSOR_UNCLOSED);
    }

    /**
     * Disconnect cursor from database when object is destructed.
     *
     * @tested
     */
    public function __destruct() {
        $this->disconnect();
    }
}