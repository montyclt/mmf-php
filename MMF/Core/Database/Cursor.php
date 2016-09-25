<?php

namespace MMF\Core\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use MMF\Core\Database\Exception\CursorException;
use MMF\Core\Database\Exception\QueryException;
use mysqli;

/**
 * Class Cursor
 */
class Cursor {
    const FETCH_ASSOC  = 2;
    const FETCH_NUM    = 3;
    const FETCH_OBJECT = 5;
    const FETCH_CLASS  = 8;

    private $mysqli;
    private $result;
    private $statement;

    /**
     * DatabaseCursor constructor.
     * @param Credentials $credentials
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
     * @param $sql
     * @param array $driver_options
     */
    public function prepare($sql, $driver_options = []) {

    }

    public function execute($data) {

    }


    public function query($sql) {

    }

    public function fetch($fecth_type) {

    }

    public function fetchAll($fetch_type) {
        $data = [];
        while ($row = $this->fetch($fetch_type)) {
            array_push($data, $row);
        }
        return $row;
    }

    public function beginTransaction() {

    }

    public function isConnectionActive() {
        return $this->mysqli->ping();
    }

    public function isTransactionActive() {

    }

    public function commitTransiction() {

    }

    public function close() {
        $result = $this->mysqli->close();
        if (!$result) throw new CursorException(
            CursorException::MSG_CURSOR_UNCLOSED,
            CursorException::CODE_CURSOR_UNCLOSED
        );
    }
}