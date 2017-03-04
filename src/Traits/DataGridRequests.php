<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:49
 */

namespace Mikelmi\MksAdmin\Traits;


use Illuminate\Http\Request;
use Mikelmi\MksAdmin\DataGrid\DataGrid;
use Mikelmi\SmartTable\SmartTable;

trait DataGridRequests
{
    public function index(Request $request, SmartTable $smartTable)
    {
        if ($request->wantsJson()) {
            return $this->dataGridJson($smartTable);
        }

        return $this->dataGridHtml();
    }

    /**
     * @param SmartTable $smartTable
     * @return string
     */
    protected function dataGridJson(SmartTable $smartTable)
    {
        return '';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function dataGridHtml()
    {
        return $this->makeDataGrid()->response();
    }

    /**
     * @return DataGrid
     */
    protected function makeDataGrid(): DataGrid
    {
        $dataGrid = new DataGrid($this->dataGridUrl());

        $options = $this->dataGridOptions();

        foreach ($options as $key => $option) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($dataGrid, $method)) {
                $dataGrid->$method($option);
            }
        }

        return $dataGrid;
    }

    /**
     * @return string
     */
    protected function dataGridUrl(): string
    {
        return '';
    }

    /**
     * @return array
     */
    protected function dataGridOptions(): array
    {
        return [];
    }
}