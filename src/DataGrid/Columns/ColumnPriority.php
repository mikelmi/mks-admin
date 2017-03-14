<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:25
 */

namespace Mikelmi\MksAdmin\DataGrid\Columns;


class ColumnPriority extends Column
{
    protected $cellAttributes = ['class' => 'text-center'];

    protected $headAttributes = ['class' => 'text-center'];

    protected $searchType = 'number';

    protected $url;

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return ColumnPriority
     */
    public function setUrl($url): ColumnPriority
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    protected function cell(): string
    {
        return sprintf(
            '<button class="btn btn-secondary btn-sm" ng-click="grid.updateRow(row,\'%s/\'+row.id+\'/1\')">
                <i class="fa fa-angle-down"></i>
            </button>
            {{row.%s}}
            <button class="btn btn-secondary btn-sm" ng-click="grid.updateRow(row,\'%1$s/\'+row.id)">
                <i class="fa fa-angle-up"></i>
            </button>',
            $this->url,
            $this->key
        );
    }
}