<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 22:07
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


class ActionDelete extends Action
{
    protected $icon = 'remove';

    protected $btnType = 'outline-danger no-b';

    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.confirm_delete');
        }

        return $this->confirm;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Delete');
        }

        return $this->title;
    }

    /**
     * @return string
     */
    public function getOnClick(): string
    {
        if ($this->onClick === null) {
            $this->onClick = sprintf("grid.removeRow(row, '%s/'+row.id, '%s')", $this->url, $this->getConfirm());
        }

        return $this->onClick;
    }
}