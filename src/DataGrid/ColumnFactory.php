<?php
/**
 * Author: mike
 * Date: 04.03.17
 * Time: 23:21
 */

namespace Mikelmi\MksAdmin\DataGrid;


use Mikelmi\MksAdmin\DataGrid\Columns\Column;

class ColumnFactory
{
    /**
     * @param array $options
     * @return Column
     */
    public static function make(array $options)
    {
        $baseClass = Column::class;

        $type = array_pull($options, 'type');

        if ($type) {
            $class = config('admin::datagrid.columns.'.$type, $baseClass . ucfirst($type));

            if (!class_exists($class)) {
                throw new \InvalidArgumentException('Class ' . $class . ' not found');
            }
        } else {
            $class = $baseClass;
        }

        $column = new $class(array_pull($options, 'key', ''));

        foreach ($options as $key => $value) {
            if (!is_string($key)) {
                continue;
            }

            $method = 'set' . ucfirst($key);

            if (method_exists($column, $method)) {
                $column->$method($value);
            }
        }

        return $column;
    }
}