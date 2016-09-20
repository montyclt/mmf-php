<?php

namespace App\Controller;

class Sumadora {
    function dosNumeros($n1, $n2) {
        return ["result" => $n1 + $n2];
    }

    function tresNumeros($n1, $n2, $n3) {
        return ["result" => $n1 + $n2 + $n3];
    }
}