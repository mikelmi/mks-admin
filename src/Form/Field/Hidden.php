<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 12:48
 */

namespace Mikelmi\MksAdmin\Form\Field;


class Hidden extends Text
{
    protected $type = 'hidden';

    public function render(): string
    {
        if ($this->isStatic()) {
            return '';
        }

        return $this->renderInput();
    }
}