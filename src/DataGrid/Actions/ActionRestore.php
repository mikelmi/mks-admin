<?php
/**
 * Author: mike
 * Date: 17.03.17
 * Time: 12:06
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


class ActionRestore extends ActionDelete
{
    protected $icon = 'arrow-circle-o-up';

    protected $btnType = 'outline-success no-b';

    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.Restore') . '?';
        }

        return $this->confirm;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Restore');
        }

        return $this->title;
    }
}