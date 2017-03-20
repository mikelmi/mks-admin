<?php
/**
 * Author: mike
 * Date: 14.03.17
 * Time: 13:16
 */

namespace Mikelmi\MksAdmin\Form\Field;


class Select2 extends Select
{
    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var mixed
     */
    protected $data;

    protected $allowEmpty = true;

    protected function getDefaultAttributes(): array
    {
        $result = parent::getDefaultAttributes();

        $result['mks-select'] = true;

        if ($this->isAllowEmpty()) {
            $result['data-allow-clear'] = 'true';
            $result['data-placeholder'] = $this->getEmptyTitle();
        }

        if ($this->url) {
            $result['data-url'] = $this->url;
        } elseif($this->data) {
            $result['data-data'] = is_string($this->data) ? $this->data : json_encode($this->data);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Select2
     */
    public function setUrl(string $url): Select2
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return Select2
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}