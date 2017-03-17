<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 13:11
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonTrash extends GridButtonDelete
{
    protected $btnType = 'warning';

    protected $icon = 'trash';

    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Move to trash');
        }

        return $this->title;
    }

    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.Move to trash') . '?';
        }

        return $this->confirm;
    }
}