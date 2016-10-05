<?php

namespace App\Controller;

use App\Entity\User;
use MMF\Core\Annotation\AnnotationManager;
use MMF\Core\Database\Cursor;

class Sumadora {
    function dosNumeros($n1, $n2) {
        return ["result" => $n1 + $n2];
    }

    function tresNumeros($n1, $n2, $n3) {
        return ["result" => $n1 + $n2 + $n3];
    }

    function getUser() {
        $user = User::getAll();
    }

    function annotaciones() {
        $reader = new AnnotationManager(new \ReflectionClass("\\App\\Entity\\User"));
        return $reader->getClassAnnotations();
    }
}