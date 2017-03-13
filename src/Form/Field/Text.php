<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 12:02
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\Field;

class Text extends Field
{
    /**
     * @var string
     */
    protected $type = 'text';

    /**
     * @return array
     */
    public function getDefaultAttributes(): array
    {
        $result = parent::getDefaultAttributes();

        $result['type'] = $this->type;
        $result['value'] = $this->value;

        return $result;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        return '<input ' . html_attr($this->getAttributes()) . '/>';
    }
}