<?php
/*
 * File: Controller.php
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

namespace MMF\Core;

defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

/**
 * Controller base class. All controllers must be extends this class.
 *
 * @author Ivan Montilla
 * @package MMF\Core
 */
abstract class Controller {

    /**
     * This method is called when no function is defined on URL.
     * This function don't accept URL parameters.
     *
     * A example URL that call this function is: example.com/Controller
     *
     * @return mixed
     */
    abstract public function index();

    /**
     * Retrieve and sanitize data from post HTTP method.
     *
     * @param $key
     * @return string
     */
    public function post($key) {
        return $this->sanitize($_POST[$key]);
    }

    /**
     * Retrieve and sanitize data from post HTTP method.
     *
     * @param $key
     * @return string
     */
    public function get($key) {
        return $this->sanitize($_GET[$key]);
    }

    /**
     * Sanitize an input string.
     *
     * @param $string
     * @return string
     * @todo Buscar una forma de sanitizar strings mejor.
     */
    private function sanitize($string) {
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }
}