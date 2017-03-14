<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 16:16
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnSelect extends Column
{
    protected $cellAttributes = ['class' => 'text-center'];

    protected $headAttributes = ['class' => 'text-center'];

    /**
     * @return string
     */
    public function renderHead(): string
    {
        $attr = array_merge([
            'mst-select-all-rows' => 'grid.rows',
            'title' => $this->title
        ], $this->headAttributes);

        return sprintf('<th%s></th>', html_attr($attr));
    }

    /**
     * @return string
     */
    public function renderSearch(): string
    {
        return '<th> </th>';
    }

    /**
     * @return string
     */
    public function renderCell(): string
    {
        $attr = array_merge([
            'mst-select-row' => 'row',
        ], $this->cellAttributes);

        return sprintf('<td%s> </td>', html_attr($attr));
    }
}