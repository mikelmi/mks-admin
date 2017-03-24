<?php
/**
 * Author: mike
 * Date: 24.03.17
 * Time: 19:34
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnList extends Column
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param array $options
     * @return ColumnList
     */
    public function setOptions(array $options): ColumnList
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function renderSearch(): string
    {
        if (!$this->getOptions()) {
            return parent::renderSearch();
        }

        $input = '';

        if ($this->searchable) {
            $attr = [
                'st-search' => $this->key,
                'class' => 'form-control form-control-sm form-block',
                'placeholder' => $this->title,
            ];

            $input = '<select ' . html_attr($attr) . '>';
            $input .= '<option value=""></option>';

            foreach($this->getOptions() as $key => $label) {
                $input .= '<option value="' . e($key) . '">' . e($label) . '</option>';
            }

            $input .= '</select>';
        }

        return sprintf('<th>%s</th>', $input);
    }
}