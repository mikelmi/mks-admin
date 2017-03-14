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
}