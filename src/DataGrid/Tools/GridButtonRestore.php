<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 13:11
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonRestore extends GridButtonDelete
{
    protected $btnType = 'success';

    protected $icon = 'arrow-circle-up';

    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Restore');
        }

        return $this->title;
    }

    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.Restore') . '?';
        }

        return $this->confirm;
    }
}