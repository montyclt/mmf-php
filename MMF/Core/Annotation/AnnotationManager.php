<?php
/**
 * File: Reader.php
 *
 * MMF (Monty Micro Framework). A PHP Micro Framework for Rest apps.
 * Created by Ivan Montilla <personal@ivanmontilla.es>
 *
 * Official website:  mmf-php.com
 * Documentation:     docs.mmf-php.com
 *
 * You have permission to use, adapt and redistribute this
 * code or adaption.
 * You can use this framework or adaption for make apps
 * with profit, but never sell this framework or adaption.
 *
 * Get started in docs.mmf-php.com/quickstart
 */

namespace MMF\Core\Annotation;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class AnnotationManager {
    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * AnnotationManager constructor.
     * @param string $classname
     * @param string|null $namespace
     */
    public function __construct($classname, $namespace = null) {
        $this->setReflectionClass($classname, $namespace);
    }

    /**
     * Set the class that this manager point.
     *
     * @param $classname
     * @param string|null $namespace
     */
    public function setReflectionClass($classname, $namespace = null) {
        if ($namespace !== null) {
            $this->reflectionClass = new ReflectionClass("\\" . $namespace . "\\" . $classname);
        } else {
            $this->reflectionClass = new ReflectionClass($classname);
        }
    }

    /**
     * Return an associative array of strings with class annotation.
     *
     * @return string[]
     */
    public function getClassAnnotations() {
        return $this->getAnnotationArrayFromDocComment($this->reflectionClass->getDocComment());
    }

    public function getMethodAnnotations($method) {
        $reflectationMethod = new ReflectionMethod($this->reflectionClass->getName(), $method);
        return $this->getAnnotationArrayFromDocComment($reflectationMethod->getDocComment());
    }

    public function getFieldAnnotations($field) {
        $reflectationProperty = new ReflectionProperty($this->reflectionClass->getName(), $field);
        return $this->getAnnotationArrayFromDocComment($reflectationProperty->getDocComment());
    }

    public function getAnnotationArrayFromDocComment($docComment) {
        $annotations = explode("@", $docComment);
        $annotationsArray = [];
        foreach (array_slice($annotations, 1) as $annotation) {
            $words = explode(" ", explode("\n", $annotation)[0], 2);
            if (isset($words[1])) $annotationsArray[trim($words[0])] = explode("\n", trim($words[1]))[0];
            else $annotationsArray[trim($words[0])] = "";
        }
        return $annotationsArray;
    }
}