<?php
/**
 * File: Welcome.php
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

//You need declare in App\Controller namespace in all controllers.
namespace App\Controller;

//You need import Controller class for extends of it.
use MMF\Core\Controller;

//This line is very important in all PHP files. With this, you avoid
//direct access to script typing in browser
// example.com/App/Controller/ControllerName.php
defined("IN_INDEX_FILE") OR die("No direct script access allowed.");

/**
 * Class Welcome is an example controller class.
 *
 * @package App\Controller
 */
class Welcome extends Controller {
    /**
     * Welcome constructor.
     *
     * You can use contruct for do an action in all methods.
     */
    function __construct() {
        //To something in all methods of this class.
    }

    /**
     * The index method is called automatically when controllers
     * is especify, but not method, for example,
     * in example.com/index.php/Welcome
     *
     * @return array
     */
    function index() {
        return ["text" => "Welcome to MMF Framework. Is Working!"];
    }

    /**
     * Example method with parameters.
     * Call this method in example.com/index.php/Welcome/startWithParameters/name/Peter
     *
     * @param string $key
     * @param string $value
     * @return array
     */
    function startWithParameters($key, $value) {
        return [$key => $value];
    }
}