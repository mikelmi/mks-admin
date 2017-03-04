<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:27
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonAdd extends GridButtonLink
{
    public function __construct($url, $title = null, $type = null, $icon = null)
    {
        parent::__construct($url, $title, $type, $icon);

        if ($title === null) {
            $this->title = trans('admin::messages.Add');
        }

        if ($this->type === null) {
            $this->type = 'primary';
        }

        if ($this->icon === null) {
            $this->icon = 'plus';
        }
    }
}