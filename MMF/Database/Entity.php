<?php
/**
 * File: Entity.php
 *
 * MMF (Monty Micro Framework). A PHP Micro Framework for Rest apps.
 * Created by Ivan Montilla <personal@ivanmontilla.es>
 *
 * Official website:  mmf-php.com
 * Documentation:     docs.mmf-php.com
 *
 * You have permission to use, adapt and redistribute this
 * code or adaption.
 * You can use this framework or adaption to make apps
 * for your own profit only profit, but never sell this
 * framework or adaption.
 *
 * Get started in docs.mmf-php.com/quickstart
 */

namespace MMF\Database;

use MMF\Annotation\AnnotationManager;
use MMF\Database\Cursor;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

/**
 * Class Entity
 *
 * @package MMF\Core\Database
 */
abstract class Entity {

    const FILTER_SMALLER = 1;
    const FILTER_EQUALS = 2;
    const FILTER_GREATER = 3;
    const ORDER_ASC = 1;
    const ORDER_DESC = 2;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var Cursor
     */
    private $cursor;

    /**
     * @var string
     */
    private $dbAlias;

    /**
     * @var AnnotationManager
     */
    private $annotationManager;

    /**
     * Entity constructor.
     */
    public function __construct() {
        $this->annotationManager = new AnnotationManager(new \ReflectionClass($this));
        $this->dbAlias = $this->annotationManager->getClassAnnotations()["ConnectionAlias"];
        $this->cursor = Cursor::getCursorByAlias($this->dbAlias);

        $this->copyColumnsFiledsToColumnsArray();
    }

    /**
     * Persist in database.
     */
    public function save() {
        $this->copyColumnsFiledsToColumnsArray();
    }

    /**
     * Get new entity object filtering by ID.
     *
     * @param int $id
     * @return Entity
     */
    public static function findById($id) {

    }

    /**
     * Get an array of entities objects, filtering by column value.
     *
     * @param $column
     * @param $value
     * @param $criteria
     * @param int $limit
     * @return Entity[]
     */
    public static function findByFilter($column, $value, $criteria, $limit = 0) {

    }

    /**
     * Get an array of all entities object in some table, opcionally can be specified an order.
     *
     * @param string|null $orderByColumn
     * @param int $orderByCriteria
     * @return Entity[]
     */
    public static function getAll($orderByColumn = null, $orderByCriteria = self::ORDER_ASC) {

    }

    /**
     * Get an array of entities object, using custom SQL Query
     *
     * @param string $sqlCode
     * @return Entity[]
     */
    public static function getWithCustomSQLQuery($sqlCode) {

    }

    private function copyColumnsFiledsToColumnsArray() {
        foreach ($this->annotationManager->getFieldsWithAnnotation("Column") as $column) {
            array_push($this->columns, [
                "name" => $column->getName(),
                "value" => $column->getValue($this),
                "type" => "varchar", //todo Implement
                "isId" => false //todo Implement
            ]);
        }
    }
}