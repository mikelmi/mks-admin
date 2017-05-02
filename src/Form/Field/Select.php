<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 23:37
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\Field;

class Select extends Field
{
    /**
     * @var bool
     */
    protected $multiple = false;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $disabledValues = [];

    /**
     * @var bool
     */
    protected $allowEmpty = false;

    /**
     * @var string
     */
    protected $emptyTitle = ' ';

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     * @return Select
     */
    public function setMultiple(bool $multiple): Select
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Select
     */
    public function setOptions(array $options): Select
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getDisabledValues(): array
    {
        return $this->disabledValues;
    }

    /**
     * @param array $disabledValues
     * @return Select
     */
    public function setDisabledValues(array $disabledValues): Select
    {
        $this->disabledValues = $disabledValues;
        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        $result = '<select ' . html_attr($this->getAttributes()) . '>';

        $result .= $this->renderEmptyOption();

        foreach ($this->options as $value => $option) {
            $result .= $this->renderOption($value, $option);
        }

        $result .= '</select>';

        return $result;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function isSelectedValue($value): bool
    {
        if ($this->isMultiple()) {
            return in_array($value, (array)$this->value);
        }

        return $value == $this->value;
    }

    /**
     * @param $value
     * @param $option
     * @return string
     */
    protected function renderOption($value, $option): string
    {
        if (is_array($option)) {
            $result = '<optgroup label="' . e($value) . '">';
            foreach ($option as $key => $opt) {
                $result .= $this->renderOption($key, $opt);
            }
            $result .= '</optgroup>';
            return $result;
        }

        $attr = ['value' => $value];

        if ($this->isSelectedValue($value)) {
            $attr['selected'] = true;
        }

        if (in_array($value, $this->getDisabledValues())) {
            $attr['disabled'] = true;
        }

        return '<option ' . html_attr($attr) . '>' . e($option) . '</option>';
    }

    /**
     * @return string
     */
    protected function renderEmptyOption(): string
    {
        if ($this->allowEmpty) {
            return $this->renderOption('', $this->emptyTitle);
        }

        return '';
    }

    protected function getDefaultAttributes(): array
    {
        $result = parent::getDefaultAttributes();

        if ($this->multiple) {
            $result['multiple'] = true;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isAllowEmpty(): bool
    {
        return $this->allowEmpty;
    }

    /**
     * @param bool $allowEmpty
     * @return Select
     */
    public function setAllowEmpty(bool $allowEmpty): Select
    {
        $this->allowEmpty = $allowEmpty;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmptyTitle(): string
    {
        return $this->emptyTitle;
    }

    /**
     * @param string $emptyTitle
     * @return Select
     */
    public function setEmptyTitle(string $emptyTitle): Select
    {
        $this->emptyTitle = $emptyTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function renderStaticInput(): string
    {
        return '<p class="form-control-static">' . $this->getValueLabel() . '</p>';
    }

    /**
     * @param array $options
     * @return array
     */
    protected function flattenOptions(array $options = []): array
    {
        $result = [];

        foreach($options as $key => $option) {
            if (is_array($option)) {
                $result = array_merge($result, flatten($option));
                continue;
            }

            $result[$key] = $option;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getValueLabel(): string
    {
        $options = $this->flattenOptions($this->getOptions());
        $value = $this->getValue();

        if (is_array($value)) {
            return implode(', ', array_map('e', array_only($options, $value)));
        }

        return e(array_get($options, (string) $value, ''));
    }
}