<?php
/*
 * File: Input.php
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

/**
 * Static class that contains method to obtains data vía GET or POST, sanitaizing this data.
 *
 * @author Ivan Montilla
 * @package MMF\Core
 */
abstract class Input {

    /**
     * Get data via GET HTTP Method.
     *
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return self::sanitize($_GET[$key]);
    }

    /**
     * Get data via POST HTTP Method.
     *
     * @param $key
     * @return mixed
     */
    public static function post($key) {
        return self::sanitize($_POST[$key]);
    }

    /**
     * Sanitize input data to prevent attacks.
     *
     * @param $data
     * @return mixed
     */
    private static function sanitize($data) {
        return filter_var($data, FILTER_SANITIZE_STRING);
    }
}