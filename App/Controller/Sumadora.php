<?php

namespace App\Controller;

use MMF\Core\Database\Cursor;

class Sumadora {
    function dosNumeros($n1, $n2) {
        return ["result" => $n1 + $n2];
    }

    function tresNumeros($n1, $n2, $n3) {
        return ["result" => $n1 + $n2 + $n3];
    }

    function getUser($id) {
        $cursor = Cursor::getCursorByAlias("test");
        $cursor->query("SELECT * FROM Users WHERE id = $id");
        $row = $cursor->fetch(Cursor::FETCH_ASSOC);
        echo $row;
    }
}