<?php
/**
 * Author: mike
 * Date: 15.03.17
 * Time: 20:56
 */

namespace Mikelmi\MksAdmin\Form\Field;


use Mikelmi\MksAdmin\Form\Field;

class Custom extends Field
{
    /**
     * @var string
     */
    protected $view;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     * @return Custom
     */
    public function setView(string $view): Custom
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Custom
     */
    public function setData(array $data): Custom
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        if (!$this->view) {
            return $this->getValue();
        }

        return view($this->view, ['field' => $this], $this->data)->render();
    }
}