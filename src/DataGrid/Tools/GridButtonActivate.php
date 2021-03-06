<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 19:38
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonActivate extends GridButtonUpdate
{
    protected $btnType = 'success';

    protected $icon = 'check';

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Activate');
        }

        return $this->title;
    }
}