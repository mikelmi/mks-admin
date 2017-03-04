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
    private $confirm;

    /**
     * @var bool
     */
    protected $showTitle = false;

    public function __construct($url, $title = null, $type = null, $icon = null)
    {
        parent::__construct($url, $title, $type, $icon);

        if ($this->title === null) {
            $this->title = trans('admin::messages.Delete Selected');
        }

        if ($this->type === null) {
            $this->type = 'danger';
        }

        if ($this->icon === null) {
            $this->icon = 'remove';
        }

        if ($this->confirm === null) {
            $this->confirm = trans('admin::messages.Delete?');
        }

        $this->onClick = sprintf("grid.removeSelected('%s', '%s')", $this->url, $this->confirm);
    }

    /**
     * @param string $confirm
     */
    public function setConfirm(string $confirm)
    {
        $this->confirm = $confirm;
    }
}