<?php

namespace App\Controller;

use MMF\Core\Annotation\AnnotationManager;
use MMF\Core\Controller;
use ReflectionClass;

class Sumadora extends Controller{
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

    function testDocComment() {
        $annotationManager = new AnnotationManager(new ReflectionClass("\\MMF\\Core\\Annotation\\AnnotationManager"));
        return ["test" => $annotationManager->getClassAnnotations()];
    }

    public function index()
    {
        // TODO: Implement index() method.
    }
}