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

    protected $btnType = 'outline-danger';

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
            $this->confirm = trans('admin::messages.Delete?');
        }

        return $this->confirm;
    }

    /**
     * @param string $confirm
     */
    public function setConfirm(string $confirm)
    {
        $this->confirm = $confirm;
    }

    public function getTitle(): string
    {
        if ($this->title === null) {
            $this->title = trans('admin::messages.Delete Selected');
        }

        return $this->title;
    }

    public function getOnClick(): string
    {
        if ($this->onClick === null) {
            $this->onClick = sprintf("grid.removeSelected('%s', '%s')", $this->url, $this->getConfirm());
        }

        return $this->onClick;
    }
}