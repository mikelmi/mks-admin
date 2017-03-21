<?php
/**
 * Author: mike
 * Date: 13.03.17
 * Time: 14:54
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\AdminForm;
use Mikelmi\MksAdmin\Form\Field;

class Toggle extends Field
{
    /**
     * @var mixed
     */
    protected $onValue = 1;

    /**
     * @var mixed
     */
    protected $offValue = 0;

    /**
     * @var string
     */
    protected $onTitle = '';

    /**
     * @var string
     */
    protected $offTitle = '';

    /**
     * @return mixed
     */
    public function getOnValue()
    {
        return $this->onValue;
    }

    /**
     * @param mixed $onValue
     * @return Toggle
     */
    public function setOnValue($onValue)
    {
        $this->onValue = $onValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffValue()
    {
        return $this->offValue;
    }

    /**
     * @param mixed $offValue
     * @return Toggle
     */
    public function setOffValue($offValue)
    {
        $this->offValue = $offValue;
        return $this;
    }

    /**
     * @return string
     */
    public function getOnTitle(): string
    {
        if (!$this->onTitle) {
            $this->onTitle = __('admin::messages.Yes');
        }

        return $this->onTitle;
    }

    /**
     * @param string $onTitle
     * @return Toggle
     */
    public function setOnTitle(string $onTitle): Toggle
    {
        $this->onTitle = $onTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getOffTitle(): string
    {
        if (!$this->offTitle) {
            $this->offTitle = __('admin::messages.No');
        }

        return $this->offTitle;
    }

    /**
     * @param string $offTitle
     * @return Toggle
     */
    public function setOffTitle(string $offTitle): Toggle
    {
        $this->offTitle = $offTitle;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOn(): bool
    {
        return $this->getValue() == $this->onValue;
    }

    /**
     * @return bool
     */
    public function isOff(): bool
    {
        return !$this->isOn();
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        if ($this->isDisabled()) {
            return $this->renderDisabledInput();
        }

        return sprintf(
            '<div class="toggle-control">
                <div class="btn-group btn-group-sm" data-toggle="buttons">
                    <label class="btn btn-outline-success%s">
                        <input type="radio" name="'.$this->name.'" autocomplete="off" value="%s"%s>
                        %s
                    </label>
                    <label class="btn btn-outline-danger%s">
                        <input type="radio" name="'.$this->name.'" autocomplete="off" value="%s"%s>
                        %s
                    </label>
                </div>
            </div>',
            $this->isOn() ? ' active' : ' ',
            $this->onValue,
            $this->isOn() ? ' checked' : '',
            $this->getOnTitle(),
            $this->isOff() ? ' active' : ' ',
            $this->offValue,
            $this->isOff() ? ' checked' : '',
            $this->getOffTitle()
        );
    }

    public function renderStaticInput(): string
    {
        return $this->renderDisabledInput();
    }

    /**
     * @return string
     */
    protected function renderDisabledInput(): string
    {
        return sprintf(
            '<h5 class="pt-1"><span class="badge badge-%s">%s</span></h5>',
            $this->isOn() ? 'success' : 'danger',
            $this->isOn() ? $this->getOnTitle() : $this->getOffTitle()
        );
    }
}