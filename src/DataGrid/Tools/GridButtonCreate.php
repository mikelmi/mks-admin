<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:27
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonCreate extends GridButtonLink
{
    protected $icon = 'plus';

    protected $btnType = 'primary';

    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Add');
        }

        return $this->title;
    }
}