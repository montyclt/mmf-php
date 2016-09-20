<?php
/**
 * File: MMF.Core.Script.php
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
namespace MMF\Script;

/**
 * Extending this class you can create CLI scripts for making
 * task, for example, crons to update compiled database tables.
 *
 * @package MMF\MMF.Core.Script
 */
abstract class Script {
    /**
     * Your script code must be in the override of this method.
     */
    protected abstract function process();

    /**
     * For execute the script, you must instance the child class and
     * call this method.
     */
    public final function run() {
        $start_datetime = new \DateTimeImmutable();
        echo PHP_EOL . "╔══════════════════════════════════════════════════════════════╗" . PHP_EOL;
        echo "║   Started script execution " . date("r") . "   ║" . PHP_EOL;
        echo "╚══════════════════════════════════════════════════════════════╝" . PHP_EOL . PHP_EOL;
        echo "Executing process method..." . PHP_EOL;
        $this->process();
        echo "MMF.Core.Script execution finished." . PHP_EOL . PHP_EOL;
        $datetime_diff = $start_datetime->diff(new \DateTimeImmutable());
        echo "Elapsed " . $datetime_diff->h . " hours, " . $datetime_diff->m
            . " minutes and " . $datetime_diff->s . " seconds." . PHP_EOL . PHP_EOL;
    }
}