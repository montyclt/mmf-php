<?php
/**
 * File: Test.php
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

namespace App\Controller;

use App\Entity\User;
use MMF\Controller\ControllerInterface;
use MMF\Database\Credentials;
use MMF\Database\Cursor;
use MMF\Template\Template;

class Test implements ControllerInterface {

    /**
     * This method is called when no function is defined on URL.
     * This function don't accept URL parameters.
     *
     * A example URL that call this function is: example.com/Controller
     *
     * @return array|object
     */
    public function index()
    {
        $cursor = Cursor::getCursorByAlias("test");
        $cursor->prepare("SELECT * FROM USERS WHERE id = ?");
        $cursor->execute([1]);
        $result = $cursor->fetchAll(Cursor::FETCH_NUM);
        array_push($result, $cursor->isConnectionActive());
        if ($cursor->isConnectionActive()) {
            $cursor->changeDatabase(Credentials::getCredentialsByAlias("apes"));
        }
        $cursor->query("SELECT * from AP_CIUDADES");
        $toReturn = [];
        while ($row = $cursor->fetch(Cursor::FETCH_BOTH)) {
            array_push($toReturn, $row);
        }
        return $toReturn;
    }
}