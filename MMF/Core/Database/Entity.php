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

namespace MMF\Core\Database;

use Iterator;
use MMF\Core\Annotation\AnnotationManager;
use ReflectionClass;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

/**
 * Class Entity
 *
 * @package MMF\Core\Database
 */
abstract class Entity {

    private $cursor;
    private $tableName;
    private $annotationManager;

    /**
     * Entity constructor.
     */
    public function __construct() {
        $this->annotationManager = new AnnotationManager(new ReflectionClass($this));
        $this->tableName = $this->annotationManager->getClassAnnotations()["Table"];
//        $this->databaseName = Credentials::getCredentialsByAlias($annotationManager->getClassAnnotations()["ConnectionAlias"])->getDatabase();
        $this->cursor = Cursor::getCursorByAlias($this->annotationManager->getClassAnnotations()["ConnectionAlias"]);
    }

    public function save() {
        $arrayToInsert = [];
        foreach ($this as $key => $field) {
            if ($this->annotationManager->fieldHasAnnotation($field, "Column")) {
                $column = $this->annotationManager->getFieldAnnotations("Column");
                $arrayToInsert[$column] = $field;
            }
        }

    }

    public function getById($id) {
        $this->cursor->prepare("SELECT * FROM $this->tableName WHERE $this->getColumnId() = ?");
        $this->cursor->execute([$id]);
    }

    public static function where($column, $value, $limit = 0) {

    }

    public static function getAll($order_by = null) {

    }

    private function getColumn($column) {
        return $this->annotationManager->getFieldsWithAnnotation("Column", $column)[0];
    }

    private function getColumns() {
        $this->annotationManager->getFieldsWithAnnotation("Column")[0];
    }

    private function getColumnId() {
        return $this->annotationManager->getFieldsWithAnnotation("ColumnId")[0];
    }
}