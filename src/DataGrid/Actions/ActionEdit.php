<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:57
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


class ActionEdit extends ActionLink
{
    protected $icon = 'pencil';

    protected $btnType = 'outline-primary';

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Edit');
        }

        return $this->title;
    }
}