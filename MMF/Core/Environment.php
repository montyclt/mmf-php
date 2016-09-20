<?php
/**
 * File: Environment.php
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
 * Class Environment
 *
 * @package MMF\MMF.Core
 */
class Environment {
    /**
     * @var string
     */
    const CONFIG_FILE = "config.json";

    public static function getBasePath() {

    }

    public static function getRemoteIP() {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getDomain() {

    }

    public static function getFullURL() {

    }

    public static function isProductionEnvironment() {
        return self::getConfigObject()->Environment->production == "true" ? true : false;
    }

    public static function getConfigObject() {
        return json_decode(fread(fopen(Environment::CONFIG_FILE, "r"),
            filesize(Environment::CONFIG_FILE)));
    }
}