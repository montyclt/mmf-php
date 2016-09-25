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

namespace MMF\Core\Database\Exception;

use Exception;

class CursorException extends Exception {
    const CODE_CURSOR_UNCLOSED  = -1;
    const CODE_QUERY_ERROR      = -2;
    const CODE_PREPARE_ERROR    = -3;

    const MSG_CURSOR_UNCLOSED   = "Error closing connection";
    const MSG_QUERY_ERROR       = "Error executing query";
    const MSG_PREPARE_ERROR     = "Error preparing statement";
}