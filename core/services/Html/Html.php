<?php


namespace core\service\Html;

use Twig\Markup;

class Html
{
    protected $charset = "UTF-8";

    /**
     * @param $content
     * @return Markup
     */
    protected function markup ($content) {
        return new Markup($content, $this->charset);
    }

    /**
     * @param $args
     * @return mixed
     */
    protected function prepare_element_args ($args) {
        $result = "";
        if (!empty($args) or $args == NULL) {
            foreach ($args as $key => $item) {
                $result .= "{$key} = '{$item}' ";
            }
        }
        return $result;
    }

    /**
     * @param array $args
     * @param string $type
     * @return Markup
     *
     * Prepare input element
     */
    protected function input_element(Array $args, $type = "") {
        $args = $this->prepare_element_args($args);
        return $this->markup("<input type = '{$type}' {$args} />");
    }
}