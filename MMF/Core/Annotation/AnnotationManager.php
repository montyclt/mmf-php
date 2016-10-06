<?php
/*
 * File: AnnotationManager.php
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

/**
 * This class is a manager API to obtain annotations of class, fields and methods.
 *
 * @author Ivan Montilla
 * @package MMF\Core\Annotation
 */
class AnnotationManager {
    /**
     * @var ReflectionClass
     */
    private $reflectionClass;

    /**
     * AnnotationManager constructor.
     * @param $reflectionClass
     * @tested
     */
    public function __construct($reflectionClass) {
        $this->setReflectionClass($reflectionClass);
    }

    /**
     * Set the class that this manager point.
     *
     * @param ReflectionClass $reflectionClass
     * @tested
     */
    public function setReflectionClass($reflectionClass) {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * Return an associative array of strings with class annotation.
     *
     * @return string[]
     * @tested
     */
    public function getClassAnnotations() {
        return $this->getAnnotationArrayFromDocComment($this->reflectionClass->getDocComment());
    }

    /**
     * Get array of annotations from a field.
     *
     * @param $field
     * @return string[]
     * @tested
     */
    public function getFieldAnnotations($field) {
        $reflectationProperty = new ReflectionProperty($this->reflectionClass->getName(), $field);
        return $this->getAnnotationArrayFromDocComment($reflectationProperty->getDocComment());
    }

    /**
     * Get array of annotations from a method.
     *
     * @param string $method
     * @return string[]
     * @tested
     */
    public function getMethodAnnotations($method) {
        $reflectationMethod = new ReflectionMethod($this->reflectionClass->getName(), $method);
        return $this->getAnnotationArrayFromDocComment($reflectationMethod->getDocComment());
    }

    /**
     * Return an array of fields (ReflectionProperty) that have an annotation.
     * The returned array is an associative array, with this format:  ["fieldName" => ReflectionProperty]
     *
     * If any field has the annotation, this method return an empty array.
     *
     * Optionally, can filter annotations with value only some value.
     *
     * @param string $annotation
     * @param null|string $value
     * @return ReflectionProperty[]
     * @tested
     */
    public function getFieldsWithAnnotation($annotation, $value = null) {
        return $this->getReflectionsWithAnnotation($this->reflectionClass->getProperties(), $annotation, $value);
    }

    /**
     * Return an array of methods (ReflectionMethod) that have an annotation.
     * The returned array is an associative array, with this format:  ["methodName" => ReflectionMethod]
     *
     * If any field has the annotation, this method return an empty array.
     *
     * Optionally, can filter annotations with value only some value.
     *
     * @param string $annotation
     * @param null|string $value
     * @return ReflectionMethod[]|ReflectionProperty[]
     * @tested
     */
    public function getMethodsWithAnnotation($annotation, $value = null) {
        return $this->getReflectionsWithAnnotation($this->reflectionClass->getMethods(), $annotation, $value);
    }

    public function hasClassAnnotation($annotation, $value = null) {

    }

    public function hasMethodAnnotation($methodName, $annotation, $value = null) {

    }

    public function hasFieldAnnotation($fieldName, $annotation, $value = null)
    {
        $fields = $this->getFieldsWithAnnotation($annotation);
        foreach ($fields as $fieldWithAnnotation) {
            if ($fieldName == $fieldWithAnnotation->getName()) return true;
        }
        return false;
    }

    /**
     * Check if docComment has some annotation.
     *
     * @param string $docComment
     * @param string $annotation
     * @return bool
     */
    private function docCommentHasAnnotation($docComment, $annotation) {
        $annotations = $this->getAnnotationArrayFromDocComment($docComment);
        foreach ($annotations as $annotationInDocComment) {
            if (isset($annotationInDocComment[$annotation])) return true;
        }
        return false;
    }

    /**
     * Return an array of annotations from a documentation comment.
     * Thanks http://stackoverflow.com/questions/39812351/getting-annotation-of-comment-in-php-i-get-too-an-email-of-comment
     *
     * @param string $docComment
     * @return string[]
     * @tested
     */
    private function getAnnotationArrayFromDocComment($docComment) {
        $annotationsArray = [];
        preg_match_all('# @(.*?)\n#s', $docComment, $annotations);
        foreach ($annotations[1] as $annotation) {
            $explotedAnnotation = explode(" ", $annotation, 2);
            if (isset($explotedAnnotation[1])) $annotationsArray[trim($explotedAnnotation[0])] = trim($explotedAnnotation[1]);
            else $annotationsArray[trim($explotedAnnotation[0])] = "";
        }
        return $annotationsArray;
    }

    /**
     * Get a ReflectionProperty or ReflectionMethod that has some annotation.
     *
     * @param ReflectionProperty[]|ReflectionMethod[] $reflections
     * @param string $annotation
     * @param string|null $value
     * @return ReflectionProperty[]|ReflectionMethod[]
     * @tested
     */
    private function getReflectionsWithAnnotation($reflections, $annotation, $value = null) {
        $reflectionsWithAnnotation = [];
        foreach ($reflections as $field) {
            foreach ($this->getAnnotationArrayFromDocComment($field->getDocComment()) as $annotationName => $annotationValue) {
                if ($annotationName == $annotation and ($annotationValue == $value or $value === null)) {
                    $reflectionsWithAnnotation[$field->getName()] = $field;
                }
            }
        }
        return $reflectionsWithAnnotation;
    }

    /**
     * Return true if some ReflecionProperty's or ReflectionMethod's have some annotation.
     *
     * @param ReflectionProperty[]|ReflectionMethod[] $reflections
     * @param string $annotation
     * @param string|null $value
     * @return bool
     */
    private function hasReflectionWithAnnotation($reflections, $annotation, $value = null) {
        return count($this->getReflectionsWithAnnotation($reflections, $annotation, $value)) > 0;
    }
}