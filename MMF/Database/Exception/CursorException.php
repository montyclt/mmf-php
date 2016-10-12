<?php
/**
 * File: CursorException.php
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

namespace MMF\Database\Exception;

use Exception;

class CursorException extends Exception {
    const MSG_CURSOR_UNCLOSED    = "Error closing connection";
    const MSG_QUERY_ERROR        = "Error executing query";
    const MSG_PREPARE_ERROR      = "Error preparing statement";
    const MSG_CONNECTION_ERROR   = "Error connecting to database";
    const MSG_INVALID_FETCH_TYPE = "Invalid fetch type";
}