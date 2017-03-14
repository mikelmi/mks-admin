<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:21
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Columns\Column;
use Mikelmi\MksAdmin\Services\ClassFactory;

/**
 * Class ColumnFactory
 * @package Mikelmi\MksAdmin\DataGrid
 *
 * @method static make(array $options): ColumnInterface
 */
class ColumnFactory extends ClassFactory
{
    protected static function baseClass(): string
    {
        return Column::class;
    }

    protected static function classInterface(): string
    {
        return ColumnInterface::class;
    }

    protected static function instance(string $class, array $options)
    {
        return new $class(array_pull($options, 'key', ''));
    }
}