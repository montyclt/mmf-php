<?php

namespace App\Controller;

use MMF\Annotation\AnnotationManager;
use MMF\Controller\ControllerInterface;
use ReflectionClass;

class Sumadora implements ControllerInterface {
    function dosNumeros($n1, $n2) {
        return ["result" => $n1 + $n2];
    }

    function tresNumeros($n1, $n2, $n3) {
        return ["result" => $n1 + $n2 + $n3];
    }

    function annotaciones() {
        $reader = new AnnotationManager(new \ReflectionClass("\\App\\Entity\\User"));
        return $reader->getFieldsWithAnnotation("ColumnType", "varchar");
    }

    /**
     *
     *
     * @return array
     */
    function testDocComment() {
        $annotationManager = new AnnotationManager(new ReflectionClass("\\MMF\\Core\\Annotation\\AnnotationManager"));
        return ["test" => $annotationManager->getClassAnnotations()];
    }

    /**
     * This method is called when no function is defined on URL.
     * This function don't accept URL parameters.
     *
     * A example URL that call this function is: example.com/Controller
     *
     * @return array|object
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function getData($key, $value) {
        return [$key => $value];
    }
}