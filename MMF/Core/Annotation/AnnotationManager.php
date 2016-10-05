<?php
/**
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
     * Get array of annotations from a method.
     *
     * @param string $method
     * @return string[]
     */
    public function getMethodAnnotations($method) {
        $reflectationMethod = new ReflectionMethod($this->reflectionClass->getName(), $method);
        return $this->getAnnotationArrayFromDocComment($reflectationMethod->getDocComment());
    }

    /**
     * Get array of annotations from a field.
     *
     * @param $field
     * @return string[]
     */
    public function getFieldAnnotations($field) {
        $reflectationProperty = new ReflectionProperty($this->reflectionClass->getName(), $field);
        return $this->getAnnotationArrayFromDocComment($reflectationProperty->getDocComment());
    }

    /**
     * Return an array of fields (ReflectionProperty) that have an annotation.
     *
     * @param string $annotation
     * @return ReflectionProperty[]
     */
    public function getFieldsWithAnnotation($annotation, $value = null) {
        $fields = $this->reflectionClass->getProperties();
        $fieldsWithAnnotation = [];
        foreach ($fields as $field) {
            foreach ($this->getAnnotationArrayFromDocComment($field->getDocComment()) as $annotationInField) {
                if ($annotationInField == $annotation) array_push($fieldsWithAnnotation, $field);
            }
        }
        return $fieldsWithAnnotation;
    }

    public function getMethodsWithAnnotation($annotation) {

    }

    public function fieldHasAnnotation($field, $annotation)
    {
        $fields = $this->getFieldsWithAnnotation($annotation);
        foreach ($fields as $fieldWithAnnotation) {
            if ($field == $fieldWithAnnotation->getName()) return true;
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
}