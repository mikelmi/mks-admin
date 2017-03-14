<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:14
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Actions\Action;
use Mikelmi\MksAdmin\Services\ClassFactory;

/**
 * Class ActionFactory
 * @package Mikelmi\MksAdmin\DataGrid
 *
 * @method static make(array $options): ActionInterface
 */
class ActionFactory extends ClassFactory
{
    /**
     * @return string
     */
    protected static function baseClass(): string
    {
        return Action::class;
    }

    /**
     * @return string
     */
    protected static function classInterface(): string
    {
        return ActionInterface::class;
    }
}