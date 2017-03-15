<?php
/**
 * Author: mike
 * Date: 15.03.17
 * Time: 21:14
 */

namespace Mikelmi\MksAdmin\Form\Field;


class Options extends Select
{
    protected $multiple = true;

    protected $inline = true;

    /**
     * @return bool
     */
    public function isInline(): bool
    {
        return $this->inline;
    }

    /**
     * @param bool $inline
     * @return Options
     */
    public function setInline(bool $inline): Options
    {
        $this->inline = $inline;
        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        $result = '<div ' . html_attr($this->getAttributes()) . '>';

        foreach ($this->options as $value => $option) {
            $result .= $this->renderOption($value, $option);
        }

        $result .= '</div>';

        return $result;
    }

    protected function renderOption($value, $option): string
    {
        if (is_array($option)) {
            $result = '<fieldset><legend>' . e($value) . '</legend>';
            foreach ($option as $key => $opt) {
                $result .= $this->renderOption($key, $opt);
            }
            $result .= '</fieldset>';
            return $result;
        }

        $attr = [
            'value' => $value,
            'name' => $this->getName(),
            'type' => $this->isMultiple() ? 'checkbox' : 'radio',
            'class' => 'form-check-input'
        ];

        if ($this->isSelectedValue($value)) {
            $attr['selected'] = true;
        }

        if (in_array($value, $this->getDisabledValues())) {
            $attr['disabled'] = true;
        }

        $result = '<label class="form-check-label"><input ' . html_attr($attr) . '>' . e($option) . '</label>';

        if ($this->inline) {
            return $result;
        }

        return '<div>' . $result . '</div>';
    }

    protected function getDefaultAttributes(): array
    {
        $result = parent::getDefaultAttributes();

        unset($result['name'], $result['multiple']);

        $class = array_get($result, 'class');

        if ($class) {
            if ($class == 'form-control') {
                unset($result['class']);
            } else {
                $result['class'] = str_replace('form-control', '', $class);
            }
        }

        return $result;
    }
}