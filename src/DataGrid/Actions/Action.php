<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 21:54
 */

namespace Mikelmi\MksAdmin\DataGrid\Actions;


use Mikelmi\MksAdmin\DataGrid\ActionInterface;
use Mikelmi\MksAdmin\Form\Button;

class Action extends Button implements ActionInterface
{
    protected $showTitle = false;

    protected $size = 'sm';

    /**
     * @var string
     */
    protected $confirm;

    /**
     * @return string
     */
    public function getConfirm(): string
    {
        return $this->confirm;
    }

    /**
     * @param string $confirm
     * @return Action
     */
    public function setConfirm(string $confirm): Action
    {
        $this->confirm = $confirm;
        return $this;
    }
}