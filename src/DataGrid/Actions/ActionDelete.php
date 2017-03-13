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

    protected $btnType = 'outline-danger';

    /**
     * @var string
     */
    protected $confirm;

    /**
     * @return string
     */
    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.confirm_delete');
        }

        return $this->confirm;
    }

    /**
     * @param string $confirm
     * @return ActionDelete
     */
    public function setConfirm(string $confirm): ActionDelete
    {
        $this->confirm = $confirm;
        return $this;
    }

    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Delete');
        }

        return $this->title;
    }

    public function getOnClick(): string
    {
        if ($this->onClick === null) {
            $this->onClick = sprintf("grid.removeRow(row, '%s/'+row.id, '%s')", $this->url, $this->getConfirm());
        }

        return $this->onClick;
    }
}