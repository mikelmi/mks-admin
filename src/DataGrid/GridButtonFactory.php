<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 20:23
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Tools\GridButton;
use Mikelmi\MksAdmin\Form\ButtonFactory;

/**
 * Class GridButtonFactory
 * @package Mikelmi\MksAdmin\DataGrid
 *
 * @method static make(array $options): GridButtonInterface
 */
class GridButtonFactory extends ButtonFactory
{
    protected static $configKey = 'admin::datagrid.buttons';

    /**
     * @return string
     */
    protected static function baseClass(): string
    {
        return GridButton::class;
    }

    /**
     * @return string
     */
    protected static function classInterface(): string
    {
        return GridButtonInterface::class;
    }
}