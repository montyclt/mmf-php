<?php

namespace MMF\Core\Database;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

use Core\Database\Exception\QueryException;
use PDO;
use PDOStatement;

/**
 * Class Cursor
 */
class Cursor {
    const FETCH_ASSOC  = 2;
    const FETCH_NUM    = 3;
    const FETCH_OBJECT = 5;
    const FETCH_CLASS  = 8;

    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var PDOStatement
     */
    private $statement;

    /**
     * DatabaseCursor constructor.
     * @param Credentials $credentials
     */
    function __construct($credentials) {
        $dsn = $credentials->getDriver() . ":host=" . $credentials->getHostname() .
            ";dbname=" . $credentials->getDatabase();
        $this->pdo = new PDO($dsn, $credentials->getUsername(), $credentials->getPassword());
    }

    /**
     * Prepare a MySQL query.
     * @param $sql
     * @param array $driver_options
     */
    public function prepare($sql, $driver_options = []) {
        $this->statement = $this->pdo->prepare($sql, $driver_options);
    }

    public function execute($data) {
        $ok = $this->statement->execute($data);
        if (!$ok) throw new QueryException();
    }

    public function query($sql) {
        $result = $this->pdo->query($sql);
        if (!$result) throw new QueryException();
        $this->pdo = $result;
    }


    public function fetch($fecth_type) {
        return $this->statement->fetch($fecth_type);
    }

    public function fetchAll($fetch_type) {
        return $this->fetchAll($fetch_type);
    }

    public function beginTransaction() {
        $this->pdo->beginTransaction();
    }

    public function isTransactionActive() {
        return $this->pdo->inTransaction();
    }

    public function commit() {
        $ok = $this->pdo->commit();
        if (!$ok) throw new QueryException();
    }

    public static function getCursor($database_alias) {
        return new Cursor(Credentials::getCredentialsByAlias($database_alias));
    }
}