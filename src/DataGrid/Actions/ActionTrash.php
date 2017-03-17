<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 12:06
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


class ActionTrash extends ActionDelete
{
    protected $icon = 'trash';

    protected $btnType = 'outline-warning no-b';

    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.Move to trash') . '?';
        }

        return $this->confirm;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Move to trash');
        }

        return $this->title;
    }
}