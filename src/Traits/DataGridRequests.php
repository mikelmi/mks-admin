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
    public function index(Request $request, SmartTable $smartTable, $scope = null)
    {
        if ($request->wantsJson()) {
            return $this->dataGridJson($smartTable, $scope);
        }

        return $this->dataGridHtml($scope);
    }

    /**
     * @param SmartTable $smartTable
     * @param null $scope
     * @return string
     */
    protected function dataGridJson(SmartTable $smartTable, $scope = null)
    {
        return '';
    }

    /**
     * @param null $scope
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function dataGridHtml($scope = null)
    {
        $response = $this->makeDataGrid($scope)
                ->setScope($scope)
                ->response();

        return ModelTraitHelper::applyCountItemsResponse($this, $response);
    }

    /**
     * @param null $scope
     * @return DataGrid
     */
    protected function makeDataGrid($scope = null): DataGrid
    {
        $dataGrid = new DataGrid($this->dataGridUrl($scope));

        $options = $this->dataGridOptions($scope);

        foreach ($options as $key => $option) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (is_callable([$dataGrid, $method])) {
                $dataGrid->$method($option);
            }
        }

        return $dataGrid;
    }

    /**
     * @param null $scope
     * @return string
     */
    protected function dataGridUrl($scope = null): string
    {
        return '';
    }

    /**
     * @param null $scope
     * @return array
     */
    protected function dataGridOptions($scope = null): array
    {
        return [];
    }
}