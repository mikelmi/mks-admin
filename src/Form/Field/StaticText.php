<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 13:16
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\Field;

class StaticText extends Field
{
    /**
     * @return string
     */
    public function renderInput(): string
    {
        return '<p class="form-control-static">'.$this->value.'</p>';
    }
}