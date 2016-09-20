<?php
/**
 * File: Template.php
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

namespace MMF\Core\Template;

/**
 * Class Template
 *
 * @package MMF.Core
 */
class Template {
    /**
     * @var string
     */
    private $template;

    /**
     * Template constructor. Use double moustaches to variables.
     *
     * @param string $template
     */
    function __construct($template) {
        $this->template = $template;
    }

    /**
     * Get string from a template replacing the double moustache to values.
     *
     * @param string[] $data
     * @return string
     */
    public function replace($data) {
        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            array_push($keys, "{{" . $key . "}}");
            array_push($values, $value);
        }
        return str_replace($keys, $values, $this->template);
    }
}