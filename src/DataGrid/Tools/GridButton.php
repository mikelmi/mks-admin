<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:08
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


use Mikelmi\MksAdmin\Form\Button;

class GridButton extends Button
{
    protected function defaultAttributes(): array
    {
        $result = parent::defaultAttributes();

        $result['ng-disabled'] = '!grid.hasSelected';

        return $result;
    }
}