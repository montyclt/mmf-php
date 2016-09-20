<?php

namespace MMF\Script;
include_once "Script.php";

/**
 * Class ModelBuilder
 *
 * @package MMF\MMF.Core.Script
 */
class ModelBuilder extends Script {

    protected function process() {
        global $argv;
    }
}

$script = new ModelBuilder();
$script->run();