<?php
/**
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

class Controller {

    /**
     * Retrieve data from post HTTP method and return it a object.
     */
    public function post() {
        //todo Sanitizar entrada de datos.
        return (object)$_POST;
    }

    /**
     * Retrieve data from post HTTP method and return it a object.
     */
    public function get() {
        //todo Sanitizar entrada de datos.
        return (object)$_GET;
    }
}