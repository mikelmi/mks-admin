<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 15:45
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\Field;

class Textarea extends Field
{
    /**
     * @return string
     */
    public function renderInput(): string
    {
        return '<textarea ' . html_attr($this->getAttributes()) . '>' . $this->value . '</textarea>';
    }
}