<?php

namespace core\service\Html;

use core\service\Html\Element\Select;
use Twig\Markup;

class From extends Html
{
    /**
     * @param array $args
     * @return Markup
     *
     * Start form
     */
    public function open (Array $args) {
        $args = $this->prepare_element_args($args);
        return $this->markup("<form {$args} > ");
    }

    /**
     * @return Markup
     *
     * End form
     */
    public function close () {
        return $this->markup("</form>");
    }

    /**
     * @param array $args
     * @param $text
     * @return Markup
     *
     * Element Label
     */
    public function label ($text, Array $args = []) {
        $args = $this->prepare_element_args($args);
        return $this->markup("<label $args{} > {$text} </label>");
    }

    /**
     * @param array $args
     * @return Markup
     *
     * Element input text
     *
     */
    public function text (Array $args = []) {
        return  $this->input_element($args, "text");
    }

    /**
     * @param array $args
     * @return Markup
     *
     * Element input number
     */
    public function number (Array $args = []) {
        return $this->input_element($args, "number");
    }

    /**
     * @param array $args
     * @return Markup
     *
     * Element input email
     */
    public function email (Array $args = []) {
        return $this->input_element($args, "email");
    }

    /**
     * @param array $args
     * @return Markup
     *
     * Element input password
     */
    public function password (Array $args = []) {
        return $this->input_element($args, "password");
    }

    /**
     * @param array $args
     * @param string $text
     * @return Markup
     *
     * Button
     */
    public function button (Array $args = [], $text = "button") {
        $args = $this->prepare_element_args($args);
        return $this->markup("<button type='button' $args >{$text}</button>");
    }

    /**
     * @param string $text
     * @param array $args
     * @return Markup
     *
     * Submit
     */
    public function submit ($text = "submit", Array $args = []) {
        $args = $this->prepare_element_args($args);
        return $this->markup("<button type='submit' $args >{$text}</button>");
    }


    /**
     * @param array $options
     * @param array $args
     * @return Markup
     *
     * Element select
     * $options = [
     *      'value1' => [
     *          'args' => [],
     *          'text' => ''
     *      ]
     * ]     */
    public function select (Array $options, Array $args = []) {
        $select_args = $this->prepare_element_args($args);
        $result = "<select {$select_args}> ";

        foreach ($options as $key => $item) {
            if (key_exists('args', $item)) {
                $result .= "<option value='{$key}' {$this->prepare_element_args($item['args'])} '>{$item['text']}</option>";
            }else {
                $result .= "<option value='{$key}'>{$item['text']}</option>";
            }
        }

        return $this->markup($result."</select>");
    }
}