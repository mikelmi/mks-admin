<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 19:58
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonDeactivate extends GridButtonUpdate
{
    protected $btnType = 'outline-warning';

    protected $icon = 'minus';

    public function getTitle(): string
    {
        if ($this->title === null) {
            $this->title = trans('admin::messages.Deactivate');
        }

        return $this->title;
    }
}