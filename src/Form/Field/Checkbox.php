<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 14:37
 */

namespace Mikelmi\MksAdmin\Form\Field;


class Checkbox extends Text
{
    protected $type = 'checkbox';

    protected $value = 1;

    protected $class = 'form-check-input';

    /**
     * @var bool
     */
    private $checked = false;

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->checked;
    }

    /**
     * @param bool $checked
     * @return Checkbox
     */
    public function setChecked(bool $checked): Checkbox
    {
        $this->checked = $checked;
        return $this;
    }

    public function getDefaultAttributes(): array
    {
        $result = parent::getDefaultAttributes();

        if ($this->isChecked()) {
            $result['checked'] = true;
        }

        return $result;
    }

    public function render(): string
    {
        return '<div class="form-check">
          <label class="form-check-label">
            ' . $this->renderInput() . ' ' . $this->getLabel() . '
          </label>
        </div>';
    }
}