<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 18:47
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\ButtonLink;
use Mikelmi\MksAdmin\Form\Field;
use Mikelmi\MksAdmin\Form\FieldInterface;

class Link extends Field
{
    private $element;

    public function __construct($name = null, $value = null, $label = null)
    {
        parent::__construct($name, $value, $label);

        $this->element = new ButtonLink($value ?: '');
    }

    public function setValue($value): FieldInterface
    {
        if (is_string($value)) {
            $this->element->setUrl($value);
        }

        return parent::setValue($value);
    }

    function __call($name, $arguments)
    {
        return call_user_func_array([$this->element, $name], $arguments);
    }

    public function setUrl(string $url)
    {
        $this->element->setUrl($url);

        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        return $this->element->render();
    }
}