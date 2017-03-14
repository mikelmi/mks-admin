<?php
/**
 * Author: mike
 * Date: 02.03.17
 * Time: 17:33
 */

namespace Mikelmi\MksAdmin\DataGrid\Tools;


class GridButtonDelete extends GridButton
{
    /**
     * @var string
     */
    protected $confirm;

    protected $btnType = 'danger';

    protected $icon = 'remove';

    /**
     * @var bool
     */
    protected $showTitle = false;

    /**
     * @return string
     */
    public function getConfirm(): string
    {
        if ($this->confirm === null) {
            $this->confirm = __('admin::messages.confirm_delete_selected');
        }

        return $this->confirm;
    }

    /**
     * @param string $confirm
     * @return GridButtonDelete
     */
    public function setConfirm(string $confirm): GridButtonDelete
    {
        $this->confirm = $confirm;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        if ($this->title === null) {
            $this->title = __('admin::messages.Delete Selected');
        }

        return $this->title;
    }

    /**
     * @return string
     */
    public function getOnClick(): string
    {
        if ($this->onClick === null) {
            $this->onClick = sprintf("grid.removeSelected('%s', '%s')", $this->url, $this->getConfirm());
        }

        return $this->onClick;
    }
}